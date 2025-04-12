<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MISReportController extends Controller
{
    /**
     * Get Trial Balance Data
     */
    public function getTrialBalance($fromDate, $toDate)
    {
        $ledgers = DB::table('general_ledgers as gl')
            ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
            ->select(
                'gl.id as ledger_id',
                'gl.name as ledger_name',
                'gl.open_balance as opening_balance',
                'gl.open_balance_type',
                DB::raw("SUM(CASE WHEN ve.date BETWEEN '$fromDate' AND '$toDate' THEN ve.debit_amount ELSE 0 END) as total_debit"),
                DB::raw("SUM(CASE WHEN ve.date BETWEEN '$fromDate' AND '$toDate' THEN ve.credit_amount ELSE 0 END) as total_credit")
            )
            ->groupBy('gl.id', 'gl.name', 'gl.open_balance', 'gl.open_balance_type')
            ->get();

        // Calculate closing balance
        $ledgers = $ledgers->map(function ($ledger) {
            $opening_balance = ($ledger->open_balance_type === 'Debit') ? $ledger->opening_balance : -$ledger->opening_balance;
            $closing_balance = $opening_balance + $ledger->total_debit - $ledger->total_credit;
            $ledger->closing_balance = $closing_balance;
            return $ledger;
        });

        // Total Debit & Credit for verification
        $totalDebit = $ledgers->sum('total_debit');
        $totalCredit = $ledgers->sum('total_credit');

        return compact('ledgers', 'fromDate', 'toDate', 'totalDebit', 'totalCredit');
    }

    /**
     * View Trial Balance Report
     */
    public function viewTrialBalance(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());

        $data = $this->getTrialBalance($fromDate, $toDate);
        return view('reports.misReport.trial-balance.index', $data);
    }

    /**
     * Export Trial Balance to PDF
     */
    public function exportTrialBalancePDF(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $type = $request->input('type', 'stream'); //default type stream
        $data = $this->getTrialBalance($fromDate, $toDate);
        $pdf = Pdf::loadView('reports.misReport.trial-balance.trial_balance_pdf', $data);
        if($type == 'download'){
            return $pdf->download('trial_balance_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('trial_balance_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Receipt & Payment Report Data
     */
    public function getReceiptPaymentReport($fromDate, $toDate)
    {
        $receipts = DB::table('voucher_entries')
            ->whereBetween('date', [$fromDate, $toDate])
            ->whereIn('transaction_type', ['Receipt', 'Deposit', 'Loan Payment'])
            ->select(
                DB::raw("SUM(amount) as total_receipts"),
                DB::raw("SUM(CASE WHEN transaction_mode = 'Cash' THEN amount ELSE 0 END) as cash_receipts"),
                DB::raw("SUM(CASE WHEN transaction_mode = 'Bank' THEN amount ELSE 0 END) as bank_receipts")
            )
            ->first();

        $payments = DB::table('voucher_entries')
            ->whereBetween('date', [$fromDate, $toDate])
            ->whereIn('transaction_type', ['Payment', 'Withdrawal', 'Fund Transfer'])
            ->select(
                DB::raw("SUM(amount) as total_payments"),
                DB::raw("SUM(CASE WHEN transaction_mode = 'Cash' THEN amount ELSE 0 END) as cash_payments"),
                DB::raw("SUM(CASE WHEN transaction_mode = 'Bank' THEN amount ELSE 0 END) as bank_payments")
            )
            ->first();

        return compact('fromDate', 'toDate', 'receipts', 'payments');
    }

    /**
     * View Receipt & Payment Report
     */
    public function viewReceiptPaymentReport(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());

        $data = $this->getReceiptPaymentReport($fromDate, $toDate);
        return view('reports.misReport.receipt-payment..index', $data);
    }

    /**
     * Export Receipt & Payment Report to PDF
     */
    public function exportReceiptPaymentPDF(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $type = $request->input('type','stream'); //default type stream

        $data = $this->getReceiptPaymentReport($fromDate, $toDate);
        $pdf = Pdf::loadView('reports.misReport.receipt-payment.receipt_payment_pdf', $data);
        if($type == 'download'){
            return $pdf->stream('receipt_payment_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('receipt_payment_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Profit & Loss Report Data
     */
    public function getProfitLoss($fromDate, $toDate)
    {
        // Fetch Income
        $income = DB::table('voucher_entries as ve')
            ->join('general_ledgers as gl', 've.ledger_id', '=', 'gl.id')
            ->whereIn('gl.group', ['Income'])
            ->whereBetween('ve.date', [$fromDate, $toDate])
            ->selectRaw('SUM(ve.credit_amount) as total_income')
            ->first();

        // Fetch Expenses
        $expenses = DB::table('voucher_entries as ve')
            ->join('general_ledgers as gl', 've.ledger_id', '=', 'gl.id')
            ->whereIn('gl.group', ['Expense'])
            ->whereBetween('ve.date', [$fromDate, $toDate])
            ->selectRaw('SUM(ve.debit_amount) as total_expense')
            ->first();

        // Calculate Net Profit or Loss
        $totalIncome = $income->total_income ?? 0;
        $totalExpense = $expenses->total_expense ?? 0;
        $netProfit = $totalIncome - $totalExpense;

        return compact('fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit');
    }

    /**
     * View Profit & Loss Report
     */
    public function viewProfitLoss(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());

        $data = $this->getProfitLoss($fromDate, $toDate);
        return view('reports.misReport.profit-loss.index', $data);
    }

    /**
     * Export Profit & Loss Report to PDF
     */
    public function exportProfitLossPDF(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $type = $request->input('type', 'stream'); //default type stream

        $data = $this->getProfitLoss($fromDate, $toDate);
        $pdf = Pdf::loadView('reports.misReport.profit-loss.profit_loss_pdf', $data);
        if($type == 'download'){
            return $pdf->download('profit_loss_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
            return $pdf->stream('profit_loss_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Balance Sheet Data
     */
    public function getBalanceSheet($date)
    {
        // Fetch Assets
        $assets = DB::table('general_ledgers as gl')
            ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
            ->whereIn('gl.group', ['Assets'])
            ->whereDate('ve.date', '<=', $date)
            ->select(
                'gl.name as ledger_name',
                DB::raw("SUM(ve.debit_amount) - SUM(ve.credit_amount) as balance")
            )
            ->groupBy('gl.id', 'gl.name')
            ->havingRaw('balance > 0')
            ->get();

        // Fetch Liabilities
        $liabilities = DB::table('general_ledgers as gl')
            ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
            ->whereIn('gl.group', ['Liabilities'])
            ->whereDate('ve.date', '<=', $date)
            ->select(
                'gl.name as ledger_name',
                DB::raw("SUM(ve.credit_amount) - SUM(ve.debit_amount) as balance")
            )
            ->groupBy('gl.id', 'gl.name')
            ->havingRaw('balance > 0')
            ->get();

        // Fetch Equity (Share Capital & Reserves)
        $equity = DB::table('general_ledgers as gl')
            ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
            ->whereIn('gl.group', ['Equity'])
            ->whereDate('ve.date', '<=', $date)
            ->select(
                'gl.name as ledger_name',
                DB::raw("SUM(ve.credit_amount) - SUM(ve.debit_amount) as balance")
            )
            ->groupBy('gl.id', 'gl.name')
            ->havingRaw('balance > 0')
            ->get();

        // Summarize Totals
        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance');

        return compact('date', 'assets', 'liabilities', 'equity', 'totalAssets', 'totalLiabilities', 'totalEquity');
    }

    /**
     * View Balance Sheet Report
     */
    public function viewBalanceSheet(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $data = $this->getBalanceSheet($date);
        return view('reports.misReport.balance-sheet.index', $data);
    }

    /**
     * Export Balance Sheet Report to PDF
     */
    public function exportBalanceSheetPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream'); // default type stream

        $data = $this->getBalanceSheet($date);
        $pdf = Pdf::loadView('reports.misReport.balance-sheet.balance_sheet_pdf', $data);
        if($type == 'download'){
            return $pdf->download('balance_sheet_' . $date . '.pdf');
        }
        return $pdf->stream('balance_sheet_' . $date . '.pdf');
    }


    /**
     * Get CD Ratio Data
     */
    public function getCDRatio($date)
    {
        // Fetch total loan disbursed (instead of remaining balance)
        $totalLoans = DB::table('member_loan_accounts')
            ->whereDate('ac_start_date', '<=', $date)
            ->where('status', 'Active') // Consider only active loans
            ->sum('loan_amount');

        // Fetch total deposits collected
        $totalDeposits = DB::table('member_depo_accounts')
            ->whereDate('ac_start_date', '<=', $date)
            ->where('closing_flag', false) // Consider only active deposits
            ->sum('balance');

        // Calculate CD Ratio
        $cdRatio = ($totalDeposits > 0) ? ($totalLoans / $totalDeposits) * 100 : 0;

        return compact('date', 'totalLoans', 'totalDeposits', 'cdRatio');
    }

    /**
     * View CD Ratio Report
     */
    public function viewCDRatio(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $data = $this->getCDRatio($date);
        return view('reports.misReport.cd-ratio.index', $data);
    }

    /**
     * Export CD Ratio Report to PDF
     */
    public function exportCDRatioPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream');

        $data = $this->getCDRatio($date);
        $pdf = Pdf::loadView('reports.misReport.cd-ratio.cd_ratio_pdf', $data);
        if($type == 'download'){
            return $pdf->download('cd_ratio_' . $date . '.pdf');
        }
        return $pdf->stream('cd_ratio_' . $date . '.pdf');
    }

     /**
     * Get MIS Report Data
     */
    public function getMISReport($date)
    {
        // Fetch total deposits collected
        $totalDeposits = DB::table('member_depo_accounts')
            ->whereDate('created_at', '<=', $date)
            ->sum('balance');

        // Fetch total loans disbursed
        $totalLoansDisbursed = DB::table('member_loan_accounts')
            ->whereDate('created_at', '<=', $date)
            ->sum('loan_amount');

        // Fetch total loans outstanding
        $totalLoansOutstanding = DB::table('member_loan_accounts')
            ->whereDate('created_at', '<=', $date)
            ->sum('balance');

        // Fetch total interest earned
        $totalInterestEarned = DB::table('voucher_entries')
            ->whereDate('created_at', '<=', $date)
            ->where('transaction_type', 'Interest Earned')
            ->sum('credit_amount');

        // Fetch total interest paid
        $totalInterestPaid = DB::table('voucher_entries')
            ->whereDate('created_at', '<=', $date)
            ->where('transaction_type', 'Interest Paid')
            ->sum('debit_amount');

        // Fetch total members
        $totalMembers = DB::table('members')
            ->whereDate('created_at', '<=', $date)
            ->count();

        // Fetch total accounts
        $totalAccounts = DB::table('accounts')
            ->whereDate('created_at', '<=', $date)
            ->count();

        // Fetch loan overdue amount
        $loanOverdue = DB::table('member_loan_accounts')
            ->whereDate('end_date', '<=', $date)
            ->sum('penal_interest');

        // Fetch NPA (Non-Performing Assets) Ratio
        $totalNPALoans = DB::table('member_loan_accounts')
            ->where('status', 'Defaulted')
            ->sum('balance');

        $npaRatio = ($totalLoansOutstanding > 0) ? ($totalNPALoans / $totalLoansOutstanding) * 100 : 0;

        return compact(
            'date', 'totalDeposits', 'totalLoansDisbursed', 'totalLoansOutstanding',
            'totalInterestEarned', 'totalInterestPaid', 'totalMembers', 'totalAccounts',
            'loanOverdue', 'totalNPALoans', 'npaRatio'
        );
    }

    /**
     * View MIS Report
     */
    public function viewMISReport(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $data = $this->getMISReport($date);
        return view('reports.misReport.mis-report.index', $data);
    }

    /**
     * Export MIS Report to PDF
     */
    public function exportMISReportPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream'); //default type stream

        $data = $this->getMISReport($date);
        $pdf = Pdf::loadView('reports.misReport.mis-report.mis_report_pdf', $data);
        if($type == 'download'){
            return $pdf->download('mis_report_' . $date . '.pdf');
        }
        return $pdf->stream('mis_report_' . $date . '.pdf');
    }

   public function getGeneralLedgerStatement($ledgerId, $fromDate, $toDate)
    {
        // Fetch all transactions for the given ledger within the date range
        $transactions = DB::table('voucher_entries')
            ->select('date', 'narration', 'm_narration', 'debit_amount', 'credit_amount', 'opening_balance')
            ->where('ledger_id', $ledgerId)
            ->whereBetween('date', [$fromDate, $toDate])
            ->orderBy('date', 'asc')
            ->get();

       if ($fromDate) {
            try {
                $fromDate = Carbon::parse($fromDate)->toDateString(); // 'Y-m-d' format

                $openingBalance = DB::table('voucher_entries')
                    ->where('ledger_id', $ledgerId)
                    ->whereDate('date', '<', $fromDate)
                    ->sum(DB::raw('credit_amount - debit_amount + opening_balance'));

            } catch (\Exception $e) {
                // Handle invalid date format
                logger()->error('Invalid fromDate passed: ' . $e->getMessage());
                $openingBalance = 0; // or whatever default you want
            }
        } else {
            $openingBalance = 0; // or handle as needed
        }
     
        // Initialize running balance with opening balance
        $runningBalance = $openingBalance;

        // Process transactions
        $ledgerStatement = $transactions->map(function ($transaction) use (&$runningBalance) {
            $runningBalance += $transaction->credit_amount - $transaction->debit_amount;

            return [
                'date'        => $transaction->date,
                'description' => $transaction->narration ?? $transaction->m_narration ?? 'No Description',
                'debit'       => $transaction->debit_amount,
                'credit'      => $transaction->credit_amount,
                'balance'     => $runningBalance,
            ];
        });

        return [
            'openingBalance'  => $openingBalance,
            'ledgerStatement' => $ledgerStatement,
        ];
    }

    public function viewGeneralLedgerStatementReport(Request $request)
    {
        $ledgerId = $request->input('ledger_id');
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());

        $ledgers = DB::table('general_ledgers')->select('id', 'name')->get();
        $data = $this->getGeneralLedgerStatement($ledgerId, $fromDate, $toDate);

        return view('reports.misReport.gl-statement.index', compact('ledgers', 'ledgerId', 'fromDate', 'toDate') + $data);
    }

    public function exportGeneralLedgerStatementReportPDF(Request $request)
    {
        $ledgerId = $request->input('ledger_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $type = $request->input('type', 'stream'); //default type stream

        $ledger = DB::table('general_ledgers')->where('id', $ledgerId)->first();
        $data = $this->getGeneralLedgerStatement($ledgerId, $fromDate, $toDate);
        $ledgerName = $ledger?->name ?? 'Unknown Ledger';
        $pdf = Pdf::loadView('reports.misReport.gl-statement.gl_statement_pdf', [
            'ledgerName'      => $ledgerName,
            'fromDate'        => $fromDate,
            'toDate'          => $toDate,
        ] + $data);

        if($type == 'download'){
            return $pdf->download('general_ledger_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('general_ledger_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

}