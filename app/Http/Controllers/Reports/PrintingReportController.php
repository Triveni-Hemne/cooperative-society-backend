<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Branch;
use App\Models\Member;
use App\Models\VoucherEntry;
use App\Models\MemberDepoAccount;
use Illuminate\Support\Facades\Auth;
use App\Models\MemberLoanAccount;
use App\Models\MemberFinancial;

class PrintingReportController extends Controller
{
  
   public function getDuplicateData($voucherNo = null, $memberId = null, $startDate = null, $endDate = null, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $entries = VoucherEntry::with([
            'account',
            'memberDepositAccount.member',
            'memberLoanAccount.member'
        ])
        ->when($voucherNo, function ($query) use ($voucherNo) {
            $query->where('voucher_num', $voucherNo);
        })
        ->when($memberId, function ($query) use ($memberId) {
            $query->where(function ($q) use ($memberId) {
                $q->whereHas('memberDepositAccount', fn($q1) => $q1->where('member_id', $memberId))
                ->orWhereHas('memberLoanAccount', fn($q2) => $q2->where('member_id', $memberId));
            });
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        })
        ->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                ->orWhereHas('enteredBy', function ($q2) use ($branchId) {
                    $q2->where('branch_id', $branchId);
                });
            });
        })
        ->orderByDesc('date')
        ->get();

        return compact('entries', 'voucherNo', 'memberId', 'startDate', 'endDate', 'branches');
    }

    public function viewDuplicate(Request $request)
    {
        $voucherNo = $request->input('voucher_num');
        $memberId = $request->input('member_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $branchId = $request->input('branch_id'); 

        $data = $this->getDuplicateData($voucherNo, $memberId, $startDate, $endDate, $branchId);
        // Get distinct voucher numbers and member list
        $data['voucherNumbers'] = VoucherEntry::select('voucher_num')->distinct()->pluck('voucher_num')->filter()->values();
        $data['members'] = Member::select('id', 'name')->orderBy('name')->get();
        
        // return $data;
        return view('reports.printingReport.duplicate-printing.index', $data);
    }

    public function exportDuplicatePDF(Request $request, $id)
    {
        $entry = VoucherEntry::with([
            'account',
            'memberDepositAccount.member',
            'memberLoanAccount.member'
        ])->findOrFail($id);
        $type = $request->input('type','stream'); // default to stream

        $pdf = Pdf::loadView('reports.printingReport.duplicate-printing.duplicate_printing_pdf', compact('entry'))
                ->setPaper('A5', 'portrait');
        
        if($type == 'download'){
            return $pdf->download("Duplicate_Receipt_{$entry->voucher_num}.pdf");
        }
        return $pdf->stream("Duplicate_Receipt_{$entry->voucher_num}.pdf");
    }


    public function exportDuplicateListPDF(Request $request)
    {
        $voucherNo = $request->input('voucher_num');
        $memberId = $request->input('member_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $branchId = $request->input('branch_id'); 
        // dd($voucherNo,$memberId,$startDate,$endDate,$branchId);
        $data = $this->getDuplicateData($voucherNo, $memberId, $startDate, $endDate, $branchId);
        $type = $request->input('type','stream'); // default to stream

        $pdf = Pdf::loadView('reports.printingReport.duplicate-printing.duplicate_printing_list_pdf', $data)
                ->setPaper('A4', 'portrait');

        if($type == 'download'){
            return $pdf->download("Duplicate_Receipts_List.pdf");
        }
        return $pdf->stream("Duplicate_Receipts_List.pdf");

    }

    private function getPassbookData($accountType, $accountId, $fromDate = null, $toDate = null)
    {            
        $transactions = [];

        if ($accountType === 'loan') {
            $transactions = VoucherEntry::where('member_loan_account_id', $accountId)
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        } elseif ($accountType === 'deposit') {
            $transactions = VoucherEntry::where('member_depo_account_id', $accountId)
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        }
        if ($accountType === 'rd') {
            $transactions = VoucherEntry::where('member_depo_account_id', $accountId)
                ->where('deposit_type', 'rd')
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        } elseif ($accountType === 'fd') {
            $transactions = VoucherEntry::where('member_depo_account_id', $accountId)
                ->where('deposit_type', 'fd')
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        } 

        // Running Balance
        $runningBalance = 0;
        foreach ($transactions as $t) {
            $runningBalance += $t->debit_amount - $t->credit_amount;
            $t->running_balance = $runningBalance;
        }

        return $transactions;
    }


    public function generatePassbook(Request $request)
    {
        $memberId = $request->input('member_id');
        $accountType = $request->input('account_type');
        $accountId = $request->input('account_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $transactions = $this->getPassbookData($accountType, $accountId, $fromDate, $toDate);

        // Fetch account with member details
        if ($accountType === 'loan') {
            $account = MemberLoanAccount::with('member')->findOrFail($accountId);
        } elseif ($accountType === 'deposit') {
            $account = MemberDepoAccount::with('member')->findOrFail($accountId);
        } else {
            $account = null;
        }
        if ($accountType === 'rd' || $accountType === 'fd') {
            $account = MemberDepoAccount::with('member')->findOrFail($accountId);
        } 

        return view('reports.printingReport.passbook-printing.index', compact(
            'memberId', 'account', 'transactions', 'accountType', 'accountId', 'fromDate', 'toDate'
        ));
    }


    public function viewPassbookForm()
    {
        $user = Auth::user();
        $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            
        // $branches = $user->role === 'Admin' ? Branch::all() : null;
    
        $members = Member::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        $loanAccounts = MemberLoanAccount::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        $depositAccounts = MemberDepoAccount::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        // $savingAccounts = DB::table('savings_accounts')
        //     ->select('id', 'member_id', 'account_number')
        //     ->get();

        // $recurringDeposits = DB::table('recurring_deposits')
        //     ->select('id', 'member_id', 'account_number')
        //     ->get();

        // $fixedDeposits = DB::table('fixed_deposits')
        //     ->select('id', 'member_id', 'account_number')
        //     ->get();

        // Optional if you have share accounts
        
        $shareAccounts = MemberFinancial::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        return view('reports.printingReport.passbook-printing.passbook-form', compact(
            'members',
            'loanAccounts',
            'depositAccounts',
            // 'savingAccounts',
            // 'recurringDeposits',
            // 'fixedDeposits',
            'shareAccounts',
        ));
    }


    public function viewPassbook(Request $request)
    {
        $accountType = $request->input('account_type');
        $accountId = $request->input('account_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $transactions = $this->getPassbookData($accountType, $accountId, $fromDate, $toDate);

        return view('reports.printingReport.passbook-printing.index', compact('transactions', 'accountType', 'accountId', 'fromDate', 'toDate'));
    }

    public function exportPassbookPDF(Request $request)
    {
        $accountType = $request->input('account_type');
        $accountId = $request->input('account_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($accountType === 'loan') {
            $account = MemberLoanAccount::with('member')->findOrFail($accountId);
        } elseif (in_array($accountType, ['deposit', 'rd', 'fd'])) {
            $account = MemberDepoAccount::with('member')->findOrFail($accountId);
        } elseif ($accountType === 'share') {
            $account = DB::table('member_financials')->where('id', $accountId)->first();
        } else {
            $account = null;
        }
        
        $transactions = $this->getPassbookData($accountType, $accountId, $fromDate, $toDate);

        $pdf = Pdf::loadView('reports.printingReport.passbook-printing.passbook_pdf', compact('transactions', 'accountType', 'fromDate', 'toDate', 'accountId', 'account'))
                ->setPaper('A5', 'portrait');

        $type = $request->input('type','stream'); // default to stream
        if($type == 'download'){
            return $pdf->download("Passbook_{$accountType}_{$accountId}.pdf");
        }
        return $pdf->stream("Passbook_{$accountType}_{$accountId}.pdf");
    }


}