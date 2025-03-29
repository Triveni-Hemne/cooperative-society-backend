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
}