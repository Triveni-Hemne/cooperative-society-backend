<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Member;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use App\Models\VoucherEntry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = $request->get('branch_id');
        // Branches only for Admin
        $branches = [];
        if ($user->role === 'Admin') {
            $branches = Branch::all();
        } else {
            $branchId = $user->branch_id; // Force branch filter for non-admins
            // dd($user);
        }
        if ($branchId) {
            $members = Member::where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            })->get();
            
            $deposits = MemberDepoAccount::where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            })->get();

            $loans = MemberLoanAccount::where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            })->get();

            $transactions = VoucherEntry::where('branch_id', $branchId)
            ->whereDate('created_at', now()->toDateString())
            ->count();
        } else {
            $members = Member::all();
            $deposits = MemberDepoAccount::all();
            $loans = MemberLoanAccount::all();
            $transactions = VoucherEntry::all()->count();
        }

        $totalMembers = $members->count();
        $members = $members->map(function ($member) {
            return [
                'message' => "New member registered: <strong>{$member->name}</strong>",
                'time' => $member->created_at,
            ];
        });

        $totalDeposits = $deposits->sum('balance');
         $deposits = $deposits->map(function ($deposit) {
            return [
                'message' => "Deposit Account Created for: <strong>{$deposit->member->name}</strong> with ₹{$deposit->balance}",
                'time' => $deposit->created_at,
            ];
        });

        $totalLoans = $loans->sum('balance');
        $loans = $loans->map(function ($loan) {
            return [
                'message' => "Loan Account Created for: <strong>{$loan->member->name}</strong> with ₹{$loan->balance}",
                'time' => $loan->created_at,
            ];
        });


        $monthlyDeposits = DB::table('voucher_entries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw("SUM(credit_amount) as amount"))
            ->where('transaction_type', 'Deposit')
            ->when($branchId, function ($query) use ($branchId) {
                    return $query->where('branch_id', $branchId);
                })
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->pluck('amount', 'month'); // returns ['2025-01' => 12000, ...]

        $monthlyWithdrawals = DB::table('voucher_entries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw("SUM(debit_amount) as amount"))
            ->where('transaction_type', 'Withdrawal')
            ->when($branchId, function ($query) use ($branchId) {
                    return $query->where('branch_id', $branchId);
                })
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->pluck('amount', 'month');

        $allMonths = collect($monthlyDeposits->keys())->merge($monthlyWithdrawals->keys())->unique()->sort();

        $chartLabels = [];
        $depositData = [];
        $withdrawalData = [];

        foreach ($allMonths as $month) {
            $chartLabels[] = Carbon::parse($month . '-01')->format('F Y');
            $depositData[] = round($monthlyDeposits[$month] ?? 0, 2);
            $withdrawalData[] = round($monthlyWithdrawals[$month] ?? 0, 2);
        }

        // Get monthly loan disbursements
        $loanDisbursements = DB::table('voucher_entries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw("SUM(debit_amount) as total_disbursed"))
            ->where('transaction_type', 'Loan Payment') // Make sure this is the correct type for disbursement
            ->when($branchId, function ($query) use ($branchId) {
                    return $query->where('branch_id', $branchId);
                })
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total_disbursed', 'month');

        // Format data
        $loanLabels = [];
        $loanData = [];

        foreach ($loanDisbursements as $month => $amount) {
            $loanLabels[] = Carbon::parse($month . '-01')->format('F Y');
            $loanData[] = round($amount, 2);
        }

        // Merge and sort all activities
        $activities =  collect()
        ->merge($members)
        ->merge($deposits)
        ->merge($loans)
        ->sortByDesc('time')
        ->take(5); // Take only 5 most recent overall
   

        return view('index', compact(
            'branches',
            'branchId',
            'totalMembers',
            'totalDeposits',
            'totalLoans',
            'transactions',
            'chartLabels',
            'depositData',
            'withdrawalData',
            'loanLabels',
            'loanData',
            'activities'
        ));
    }
   
}