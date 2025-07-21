<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\MemberLoanAccount;
use App\Models\GeneralLedger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
   public function getOverdueLoans($date, $branchId = null, $ledgerId = null, $months = 1, $startDate, $endDate, $type = 'without_interest')
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

       $branches = $user->role === 'Admin' ? Branch::all() : null;
       $ledgers = GeneralLedger::where('group','loan')->get();
       
       $loanAccounts = MemberLoanAccount::with(['member', 'loanInstallment' => function ($query) use ($endDate) {
            $query->where('mature_date', '<=', $endDate);
        }])
        ->when($ledgerId, function ($query) use ($ledgerId) {
            $query->where('ledger_id', $ledgerId);
        })
        ->when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();

        $overdueLoans = collect();

        foreach ($loanAccounts as $account) {
            $overdueInstallments = $account->loanInstallment()->where('mature_date', '<=', $endDate)->get();

            if ($overdueInstallments->isEmpty()) continue;

            $overdueAmount = $overdueInstallments->sum('installment_amount');

            $interest = 0;
            if ($type !== 'without_interest') {
                foreach ($overdueInstallments as $installment) {
                    $matureDate = Carbon::parse($installment->mature_date);
                    $calcDate = Carbon::parse($date);
                    if ($calcDate->greaterThan($matureDate)) {
                        $daysOverdue = $matureDate->diffInDays($calcDate);
                        $dailyRate = ($account->interest_rate / 100) / 365;
                        $interest += $installment->installment_amount * $dailyRate * $daysOverdue;
                    }
                }
            }

            $overdueLoans->push([
                'name' => $account->member->name ?? 'Unknown',
                'account_no' => $account->acc_no,
                'loan_date' => $account->created_at,
                'sanction_amount' => $account->loan_amount,
                'overdue_amount' => round($overdueAmount, 2),
                'interest' => round($interest, 2),
                'total' => round($overdueAmount + $interest, 2),
                'penalty_amount' => round($interest, 2),
            ]);
        }

        return [
            'branches' => $branches,
            'overdueLoans' => $overdueLoans,
            'ledgers' => $ledgers,
        ];

    }

    public function overdueRegister(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $branchId = $request->input('branch_id');

        $ledgerId = $request->input('ledger_id');
        $months = (int)$request->input('months', 1);
        $type = $request->input('type', 'without_interest');

        $startDate = Carbon::parse($date)->subMonths($months)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();
        $data = $this->getOverdueLoans($date, $branchId, $ledgerId, $months, $startDate, $endDate, $type);

        $totalOverdueAmount = $data['overdueLoans']->sum('overdue_amount');
        $totalPenalty = $data['overdueLoans']->sum('penalty_amount');
        $overdueLoans = $data['overdueLoans'];
        $branches = $data['branches'];
        $ledgers = $data['ledgers'];

       return view('reports.loanReport.overdue-register.index', compact('date', 'overdueLoans', 'totalOverdueAmount', 'totalPenalty', 'branches', 'type','ledgers','ledgerId','months','branchId',));
    }

    public function exportOverduePDF(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $branchId = $request->input('branch_id');

        $ledgerId = $request->input('ledger_id');
        $months = (int)$request->input('months', 1);
        $type = $request->input('type', 'without_interest');

        $startDate = Carbon::parse($date)->subMonths($months)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();
        $data = $this->getOverdueLoans($date, $branchId, $ledgerId, $months, $startDate, $endDate, $type);
        
        $streamType  = $request->input('type', 'stream');
        $data['totalOverdueAmount'] = $data['overdueLoans']->sum('overdue_amount');
        $data['totalPenalty'] = $data['overdueLoans']->sum('penalty_amount');
        $data['date'] = $date;

        $pdf = Pdf::loadView('reports.loanReport.overdue-register.overdue_register_pdf', $data);
        if($streamType == 'download'){
            return $pdf->download('overdue_report_' . $date . '.pdf');
        }
        return $pdf->stream('overdue_report_' . $date . '.pdf');
    }

    public function getNPAList($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // $today = now()->toDateString(); // '2025-04-30' or use a specific date if needed

        $data = DB::table('member_loan_accounts as mla')
                ->join('members as m', 'mla.member_id', '=', 'm.id')
                ->select(
                    'mla.acc_no',
                    'm.name as borrower_name',
                    'mla.loan_amount',
                    'mla.end_date as first_default_date',
                    'mla.balance as outstanding_balance',
                    DB::raw("DATEDIFF('$date', mla.end_date) AS days_overdue"),
                    DB::raw("CASE 
                        WHEN DATEDIFF('$date', mla.end_date) BETWEEN 91 AND 364 THEN 'Substandard'
                        WHEN DATEDIFF('$date', mla.end_date) BETWEEN 365 AND 1094 THEN 'Doubtful'
                        WHEN DATEDIFF('$date', mla.end_date) >= 1095 THEN 'Loss'
                    END AS npa_classification")
                )
                ->where('mla.status', '=', 'active')
                ->whereRaw("DATEDIFF('$date', mla.end_date) > 90");

        if ($branchId) {
            $data->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhere('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $data = $data->orderByDesc('days_overdue')->get();

        return compact('date', 'data', 'branches');
    }

    public function npaList(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $report = $this->getNPAList($date, $branchId);
        $overdueLoans = $report['data'];
        $branches = $report['branches'];

        return view('reports.loanReport.npa-list.index', compact('date', 'overdueLoans', 'branches'));
    }


    public function exportNPAPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $overdueLoans = $this->getNPAList($date, $branchId);
        $type = $request->input('type', 'stream');
        // dd($type);
        $data = [
            'date' => $date,
            'overdueLoans' => $overdueLoans
        ];

        $pdf = Pdf::loadView('reports.loanReport.npa-list.npa_list_pdf', $data);
        if($type == 'download'){
            return $pdf->download('npa_list_' . $date . '.pdf');
        }
        return $pdf->stream('npa_list_' . $date . '.pdf');
    }

    public function getFinalNPAChartData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        // Base query with optional branch filtering
        $baseQuery = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->where('mla.status', 'Active');

        if ($branchId) {
            $baseQuery->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhere('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        // Clone for reuse
        $totalLoans = (clone $baseQuery)->count();

        $totalNPALoans = (clone $baseQuery)
            ->whereRaw("DATEDIFF('$date', mla.end_date) > 90")
            ->count();

        $totalOutstanding = (clone $baseQuery)->sum('mla.balance');

        $totalOverdue = (clone $baseQuery)
            ->whereRaw("DATEDIFF('$date', mla.end_date) > 0")
            ->sum('mla.balance');

        $npaCounts = (clone $baseQuery)
            ->whereRaw("DATEDIFF('$date', mla.end_date) > 90")
            ->selectRaw("
                SUM(CASE WHEN DATEDIFF('$date', mla.end_date) BETWEEN 91 AND 364 THEN 1 ELSE 0 END) AS substandard,
                SUM(CASE WHEN DATEDIFF('$date', mla.end_date) BETWEEN 365 AND 1094 THEN 1 ELSE 0 END) AS doubtful,
                SUM(CASE WHEN DATEDIFF('$date', mla.end_date) >= 1095 THEN 1 ELSE 0 END) AS loss
            ")
            ->first();

        $npaPercentage = ($totalLoans > 0) ? ($totalNPALoans / $totalLoans) * 100 : 0;

        return [
            'date' => $date,
            'totalLoans' => $totalLoans,
            'totalNPALoans' => $totalNPALoans,
            'totalOutstanding' => $totalOutstanding,
            'totalOverdue' => $totalOverdue,
            'npaPercentage' => number_format($npaPercentage, 2),
            'npaCounts' => [
                'substandard' => $npaCounts->substandard ?? 0,
                'doubtful' => $npaCounts->doubtful ?? 0,
                'loss' => $npaCounts->loss ?? 0,
            ],
            'branches' => $branches,
        ];
    }

    public function finalNPAChart(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        $branchId = $request->input('branch_id');
        $npaData = $this->getFinalNPAChartData($date,$branchId);
        $branches = $npaData['branches'];
        
        return view('reports.loanReport.final-npa-chart.index', compact('npaData', 'branches'));
    }

    public function exportFinalNPAChartPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $npaData = $this->getFinalNPAChartData($date, $branchId);
        $type = $request->input('type', 'stream');
        $pdf = Pdf::loadView('reports.loanReport.final-npa-chart.final_npa_chart_pdf', compact('npaData'));
        if($type == 'download'){
            return $pdf->download('final_npa_chart_' . $date . '.pdf');
        }
        return $pdf->stream('final_npa_chart_' . $date . '.pdf');
    }

    public function getDebitLoanReportData($fromDate, $toDate, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $query = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->select(
                'mla.acc_no as loan_account_no',
                'm.name as borrower_name',
                'mla.start_date as disbursement_date',
                'mla.loan_amount as loan_amount_disbursed',
                'mla.interest_rate',
                'mla.tenure'
            )
            ->whereBetween('mla.start_date', [$fromDate, $toDate])
            ->orderBy('mla.start_date', 'desc');

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhere('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $debitLoans = $query->get();

        return [
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'debitLoans' => $debitLoans,
            'branches' => $branches,
        ];

    }

    public function debitLoanReport(Request $request)
    {
        // Get date range from request or default to current month
        $fromDate = $request->input('from_date', today()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', today()->endOfMonth()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getDebitLoanReportData($fromDate, $toDate, $branchId);
        $debitLoans = $data['debitLoans'];
        $branches = $data['branches'];
        // dd($debitLoans);

        return view('reports.loanReport.debit-loan.index', compact('fromDate', 'toDate', 'debitLoans','branches'));
    }

    public function exportDebitLoanReportPDF(Request $request)
    {
        $fromDate = $request->input('from_date', today()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', today()->endOfMonth()->toDateString());
        $type = $request->input('type', 'stream');
        $branchId = $request->input('branch_id');
        $debitLoans = $this->getDebitLoanReportData($fromDate, $toDate,$branchId);

        $data = [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'debitLoans' => $debitLoans
        ];

        $pdf = Pdf::loadView('reports.loanReport.debit-loan.debit_loan_pdf', $data);
        if($type == 'download'){
            return $pdf->download('debit_loan_report_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('debit_loan_report_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    public function getGuarantorRegisterData($branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $data = DB::table('member_loan_accounts')
            ->join('members as borrowers', 'member_loan_accounts.member_id', '=', 'borrowers.id')
            ->join('loan_guarantors', 'member_loan_accounts.id', '=', 'loan_guarantors.loan_id')
            ->join('members as guarantors', 'loan_guarantors.member_id', '=', 'guarantors.id')
            ->select(
                'member_loan_accounts.acc_no as loan_account_no',
                'borrowers.name as borrower_name',
                'guarantors.name as guarantor_name',
            );
        if ($branchId) {
            $data->where(function ($q) use ($branchId) {
                $q->where('borrowers.branch_id', $branchId)
                ->orWhere('borrowers.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }
        $guarantors = $data->get();

        return [
            'guarantors' => $guarantors,
            'branches' => $branches
        ];
    }

    public function guarantorRegister(Request $request)
    {
        $branchId = $request->input('branch_id');
        $data = $this->getGuarantorRegisterData($branchId);
        return view('reports.loanReport.gaurantor-register.index', $data);
    }

    public function exportGuarantorRegisterPDF(Request $request)
    {
        $branchId = $request->input('branch_id');
        $data = $this->getGuarantorRegisterData($branchId);
        $type = $request->input('type', 'stream');

        $pdf = Pdf::loadView('reports.loanReport.gaurantor-register.guarantor_register_pdf', $data);
        if($type == 'download'){
            return $pdf->download('guarantor_register.pdf');
        }
        return $pdf->stream('guarantor_register.pdf');
    }

    public function getLoanAccountStatement($loanAccNo, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
       // Base query: fetch all loan accounts based on branch ownership or who created them
        $query = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->leftJoin('users as u', 'm.created_by', '=', 'u.id');

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhereIn('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        // Get all filtered accounts
        $accounts = $query->select('mla.*')->get();
        // Find the account you're interested in
        $loan = $accounts->where('acc_no', $loanAccNo)->first();
        
        $transactions = collect();
        $totalPaid = 0;
        $outstandingBalance = 0;
        $interestAccrued = 0;
        // dd($loan);

        if ($loan) {
            $transactions = DB::table('voucher_entries')
                ->where('ledger_id', $loan->ledger_id)
                ->orderBy('created_at', 'asc')
                ->get();

            $totalPaid = $transactions->where('transaction_type', 'Payment')->sum('amount');
            $outstandingBalance = $loan->loan_amount - $totalPaid;
            $interestAccrued = ($loan->loan_amount * $loan->interest_rate / 100) * ($loan->tenure / 12);
        }

        return [
            'loan' => $loan,
            'accounts' => $accounts,
            'transactions' => $transactions,
            'totalPaid' => $totalPaid,
            'outstandingBalance' => $outstandingBalance,
            'interestAccrued' => $interestAccrued,
            'branches' => $branches
        ];
    }

    public function loanAccountStatement(Request $request)
    {
        $loanAccNo = $request->input('loan_acc_no');
        $branchId = $request->input('branch_id');
        $data = $this->getLoanAccountStatement($loanAccNo,$branchId);
        // dd($data);
        return view('reports.loanReport.account-statement.index', $data);
    }

    public function exportLoanAccountStatementPDF(Request $request)
    {
        $loanAccNo = $request->input('loan_acc_no');
        $branchId = $request->input('branch_id');
        $data = $this->getLoanAccountStatement($loanAccNo,$branchId);

        if (!$data) {
            return back()->with('error', 'Loan account not found.');
        }

        $pdf = Pdf::loadView('reports.loanReport.account-statement.loan_account_statement_pdf', $data);
        return $pdf->stream('loan_account_statement_' . $loanAccNo . '.pdf');
    }



}