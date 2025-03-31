<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayBegin;
use App\Models\DayEnd;
use App\Models\VoucherEntry;
use App\Models\GeneralLedger;
use App\Models\BranchLedger;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DailyReportController extends Controller
{
   public function getCashBookData($date)
    {
        // Fetch transactions for the selected date
        $transactions = VoucherEntry::whereDate('date', $date)
            ->where('payment_mode', 'Cash')
            ->orderBy('date', 'asc')
            ->get();

        // Calculate Opening Balance (Previous day's closing balance) in a single query
        $openingBalance = VoucherEntry::whereDate('date', '<', $date)
            ->where('payment_mode', 'Cash')
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Deposit' THEN amount ELSE 0 END) -
                SUM(CASE WHEN transaction_type = 'Withdrawal' THEN amount ELSE 0 END)
                AS balance
            ")->value('balance') ?? 0;

        // Calculate Total Receipts & Total Payments for the selected date using a single query
        $totals = VoucherEntry::whereDate('date', $date)
            ->where('payment_mode', 'Cash')
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Deposit' THEN amount ELSE 0 END) AS total_receipts,
                SUM(CASE WHEN transaction_type = 'Withdrawal' THEN amount ELSE 0 END) AS total_payments
            ")->first();

        $cashReceipts = $totals->total_receipts ?? 0;
        $cashPayments = $totals->total_payments ?? 0;

        // Calculate Closing Balance
        $closingBalance = $openingBalance + $cashReceipts - $cashPayments;

        return compact('date', 'openingBalance', 'cashReceipts', 'cashPayments', 'closingBalance', 'transactions');
    }

    public function cashBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getCashBookData($date);

        return view('reports.dailyReport.cash-book.index', $data);
    }

    /**
     * Export Cash Book to PDF.
     */
    public function exportPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getCashBookData($date);

        $pdf = Pdf::loadView('reports.dailyReport.cash-book.cashbook_pdf', $data);
        return $pdf->download('cashbook_report_' . $date . '.pdf');
    }

    /**
     * Export Cash Book to Excel.
     */
    public function exportExcel(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        return Excel::download(new CashBookExport($date), 'cashbook_report_' . $date . '.xlsx');
    }

    public function getDayBookData($date)
    {
        // Fetch all transactions for the selected date (both Cash and Bank)
        $transactions = VoucherEntry::whereDate('date', $date)
            ->orderBy('date', 'asc')
            ->get();

        // Calculate Total Receipts & Total Payments for the selected date
        $totals = VoucherEntry::whereDate('date', $date)
            ->selectRaw("SUM(CASE WHEN transaction_type = 'Deposit' THEN amount ELSE 0 END) AS total_receipts,
                         SUM(CASE WHEN transaction_type = 'Withdrawal' THEN amount ELSE 0 END) AS total_payments")
            ->first();

        $totalReceipts = $totals->total_receipts ?? 0;
        $totalPayments = $totals->total_payments ?? 0;

        return compact('date', 'totalReceipts', 'totalPayments', 'transactions');
    }

    public function dayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getDayBookData($date);

        return view('reports.dailyReport.day-book.index', $data);
    }

    /**
     * Export Day Book to PDF.
     */
    public function exportDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getDayBookData($date);

        $pdf = Pdf::loadView('reports.dailyReport.day-book.daybook_pdf', $data);
        return $pdf->download('daybook_report_' . $date . '.pdf');
    }

    /**
     * Export Day Book to Excel.
     */
    public function exportDayBookExcel(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        return Excel::download(new DayBookExport($date), 'daybook_report_' . $date . '.xlsx');
    }

    /**
     * Fetch Sub Day Book Data
     */
    public function getSubDayBookData($date, $accountType = null)
    {
        // Fetch transactions with account details
        $query = VoucherEntry::whereDate('voucher_entries.date', $date)
            ->join('accounts', 'voucher_entries.account_id', '=', 'accounts.id')
            ->select('voucher_entries.*', 'accounts.account_type', 'accounts.name');

        if ($accountType) {
            $query->where('accounts.account_type', $accountType);
        }

        $transactions = $query->orderBy('voucher_entries.date', 'asc')->get();

        // Fetch aggregated totals separately
        $totals = DB::table('voucher_entries')
            ->join('accounts', 'voucher_entries.account_id', '=', 'accounts.id')
            ->whereDate('voucher_entries.date', $date)
            ->when($accountType, function ($q) use ($accountType) {
                return $q->where('accounts.account_type', $accountType);
            })
            ->selectRaw("
                SUM(CASE WHEN voucher_entries.transaction_type = 'Deposit' THEN voucher_entries.amount ELSE 0 END) AS total_deposits,
                SUM(CASE WHEN voucher_entries.transaction_type = 'Withdrawal' THEN voucher_entries.amount ELSE 0 END) AS total_withdrawals
            ")
            ->first();

        $totalDeposits = $totals->total_deposits ?? 0;
        $totalWithdrawals = $totals->total_withdrawals ?? 0;

        // Fetch unique account types from accounts table
        $accountTypes = DB::table('accounts')->distinct()->pluck('account_type');

        return compact('date', 'transactions', 'totalDeposits', 'totalWithdrawals', 'accountTypes', 'accountType');
    }

    /**
     * Show Sub Day Book Report
     */
    public function subDayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $accountType = $request->input('account_type');

        $data = $this->getSubDayBookData($date, $accountType);

        return view('reports.dailyReport.sub-day-book.index', $data);
    }

    /**
     * Export Sub Day Book to PDF
     */
    public function exportSubDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $accountType = $request->input('account_type');

        $data = $this->getSubDayBookData($date, $accountType);

        $pdf = Pdf::loadView('reports.dailyReport.sub-day-book.subdaybook_pdf', $data);
        return $pdf->download('subdaybook_report_' . $date . '.pdf');
    }

    /**
     * Export Sub Day Book to Excel
     */
    public function exportSubDayBookExcel(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $accountType = $request->input('account_type');

        return Excel::download(new SubDayBookExport($date, $accountType), 'subdaybook_report_' . $date . '.xlsx');
    }
    /**
     * Fetch GL Statement Data
     */
    public function getGLStatementData($startDate, $endDate, $glAccount = null)
    {
        // Initialize Running Balance
        DB::statement('SET @running_balance = 0');

        // Fetch General Ledger Transactions with Running Balance
        $query = DB::table('general_ledgers as gl')
            ->join('accounts as acc', 'gl.parent_ledger_id', '=', 'acc.id')
            ->whereBetween('gl.created_at', [$startDate, $endDate])
            ->select(
                'gl.created_at as date',
                'acc.account_no',
                'acc.account_name',
                'gl.balance',
                'gl.balance_type',
                DB::raw("CASE WHEN gl.balance_type = 'Credit' THEN gl.balance ELSE 0 END AS credit"),
                DB::raw("CASE WHEN gl.balance_type = 'Debit' THEN gl.balance ELSE 0 END AS debit"),
                DB::raw('(@running_balance := @running_balance + 
                        CASE WHEN gl.balance_type = "Debit" THEN gl.balance ELSE -gl.balance END) AS running_balance')
            );

        if ($glAccount) {
            $query->where('acc.id', $glAccount);
        }

        $transactions = $query->orderBy('gl.created_at', 'asc')->get();

        // Calculate total debits and credits
        $totals = DB::table('general_ledgers as gl')
            ->join('accounts as acc', 'gl.parent_ledger_id', '=', 'acc.id')
            ->whereBetween('gl.created_at', [$startDate, $endDate])
            ->when($glAccount, function ($q) use ($glAccount) {
                return $q->where('acc.id', $glAccount);
            })
            ->selectRaw("
                SUM(CASE WHEN gl.balance_type = 'Debit' THEN gl.balance ELSE 0 END) AS total_debits,
                SUM(CASE WHEN gl.balance_type = 'Credit' THEN gl.balance ELSE 0 END) AS total_credits
            ")
            ->first();

        $totalDebits = $totals->total_debits ?? 0;
        $totalCredits = $totals->total_credits ?? 0;
        $isBalanced = ($totalDebits == $totalCredits);

        // Fetch unique GL accounts
        $glAccounts = DB::table('accounts')->pluck('account_name', 'id');

        // Set default date
        $date = now()->format('Y-m-d');

        // Calculate Closing Balance
        $closingBalance = $transactions->isNotEmpty() ? $transactions->last()->running_balance : 0;

        // Return data as an array
        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $transactions,
            'totalDebits' => $totalDebits,
            'totalCredits' => $totalCredits,
            'isBalanced' => $isBalanced,
            'glAccounts' => $glAccounts,
            'glAccount' => $glAccount,
            'date' => $date,
            'closingBalance' => $closingBalance, // Pass Closing Balance
        ];
    }


    /**
     * Show GL Statement Checking Report
     */
    public function glStatementChecking(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $glAccount = $request->input('gl_account');

        // Get data from `getGLStatementData()`
        $data = $this->getGLStatementData($startDate, $endDate, $glAccount);

        // Return the view with the data
        return view('reports.dailyReport.gl-statement-checking.index', $data);
    }


    /**
     * Export GL Statement to PDF
     */
    public function exportGLStatementPDF(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $glAccount = $request->input('gl_account');

        $data = $this->getGLStatementData($startDate, $endDate, $glAccount);

        $pdf = Pdf::loadView('reports.dailyReport.gl-statement-checking.glstatementchecking_pdf', $data);
        return $pdf->download('gl_statement_' . $startDate . '_to_' . $endDate . '.pdf');
    }


    /**
     * Export GL Statement to Excel
     */
   public function exportGLStatementExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $glAccount = $request->input('gl_account');

        return Excel::download(new GLStatementExport($startDate, $endDate, $glAccount), 'gl_statement_' . $startDate . '_to_' . $endDate . '.xlsx');
    }

   /**
     * Fetch Cut Book (Loan Repayment) Data
     */
    public function getCutBookData($startDate, $endDate, $loanAccountId = null)
    {
        // Initialize Running Balance for each Loan Account
        DB::statement('SET @running_balance = 0');

        // Fetch Loan Transactions from General Ledgers
        $query = DB::table('general_ledgers as gl')
            ->join('member_loan_accounts as mla', 'gl.id', '=', 'mla.ledger_id')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->whereBetween('gl.created_at', [$startDate, $endDate])
            ->select(
                'gl.created_at as date',
                'mla.acc_no as loan_account_no',
                'm.name as borrower_name',
                'mla.loan_type',
                'mla.emi_amount',
                DB::raw("CASE WHEN gl.balance_type = 'Credit' THEN gl.balance ELSE 0 END AS interest_paid"),
                DB::raw("CASE WHEN gl.balance_type = 'Debit' THEN gl.balance ELSE 0 END AS principal_paid"),
                DB::raw('(@running_balance := @running_balance - 
                        CASE WHEN gl.balance_type = "Debit" THEN gl.balance ELSE 0 END) AS balance_due')
            );

        if ($loanAccountId) {
            $query->where('mla.id', $loanAccountId);
        }

        $transactions = $query->orderBy('gl.created_at', 'asc')->get();

        // Calculate Total Payments
        $totals = DB::table('general_ledgers as gl')
            ->join('member_loan_accounts as mla', 'gl.id', '=', 'mla.ledger_id')
            ->whereBetween('gl.created_at', [$startDate, $endDate])
            ->when($loanAccountId, function ($q) use ($loanAccountId) {
                return $q->where('mla.id', $loanAccountId);
            })
            ->selectRaw("
                SUM(CASE WHEN gl.balance_type = 'Debit' THEN gl.balance ELSE 0 END) AS total_principal_paid,
                SUM(CASE WHEN gl.balance_type = 'Credit' THEN gl.balance ELSE 0 END) AS total_interest_paid
            ")
            ->first();

        $totalPrincipalPaid = $totals->total_principal_paid ?? 0;
        $totalInterestPaid = $totals->total_interest_paid ?? 0;

        // Fetch Loan Accounts
        $loanAccounts = DB::table('member_loan_accounts')->pluck('name', 'id');

        return view('reports.dailyReport.cut-book.index', compact(
            'startDate', 'endDate', 'transactions', 'totalPrincipalPaid', 'totalInterestPaid', 'loanAccounts', 'loanAccountId'
        ));
    }

    /**
     * Show Cut Book Report
     */
    public function cutBookReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $loanAccountId = $request->input('loan_account');

        return $this->getCutBookData($startDate, $endDate, $loanAccountId);
    }

    public function exportCutBookPDF(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $loanAccountId = $request->input('loan_account');

        $transactions = $this->getCutBookData($startDate, $endDate, $loanAccountId, false);

        $pdf = Pdf::loadView('reports.dailyReport.cut-book.cut-book_pdf', compact(
            'startDate', 'endDate', 'transactions'
        ));

        return $pdf->download('Cut_Book_Report_' . $startDate . '_to_' . $endDate . '.pdf');
    }

    /**
     * Show Demand Day Book Report
     */
    public function getDemandDayBookData($date)
    {
        $expectedPayments = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->leftJoin('general_ledgers as gl', function ($join) use ($date) {
                $join->on('mla.id', '=', 'gl.id')
                    ->whereDate('gl.created_at', $date)
                    ->where('gl.balance_type', 'Credit'); // Loan repayments
            })
            ->whereRaw("DATE_ADD(mla.start_date, INTERVAL FLOOR(DATEDIFF(?, mla.start_date) / 30) MONTH) <= ?", [$date, $date])
            ->where('mla.status', 'Active') // Consider only active loans
            ->where('mla.add_to_demand', true) // Only loans flagged for demand calculations
            ->select(
                'mla.acc_no as loan_account_no',
                'm.name as borrower_name',
                'mla.emi_amount as demand_amount',
                DB::raw("COALESCE(SUM(gl.balance), 0) AS amount_received"),
                DB::raw("(mla.emi_amount - COALESCE(SUM(gl.balance), 0)) AS balance_due")
            )
            ->groupBy('mla.id', 'mla.acc_no', 'm.name', 'mla.emi_amount')
            ->get();

        return compact('date', 'expectedPayments');
    }

        public function demandDayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getDemandDayBookData($date);

        return view('reports.dailyReport.demand-day-book.index', $data);
    }

    public function exportDemandDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $data = $this->getDemandDayBookData($date);

        $pdf = Pdf::loadView('reports.dailyReport.demand-day-book.demand_day_book_pdf', $data);
        return $pdf->download('demand_day_book_' . $date . '.pdf');
    }


}