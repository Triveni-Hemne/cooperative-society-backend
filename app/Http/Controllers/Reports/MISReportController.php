<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Models\Branch;
use App\Models\VoucherEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class MISReportController extends Controller
{
    /**
     * Get Trial Balance Data
     */
    public function getTrialBalance($fromDate, $toDate, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $ledgers = DB::table('general_ledgers as gl')
            ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
            ->leftJoin('member_depo_accounts as mda', 've.account_id', '=', 'mda.id')
            ->leftJoin('members', 'mda.member_id', '=', 'members.id')
           ->select(
                'gl.id as ledger_id',
                'gl.name as ledger_name',
                'gl.open_balance as opening_balance',
                'gl.open_balance_type',
                DB::raw("SUM(CASE WHEN DATE(ve.date) BETWEEN '$fromDate' AND '$toDate' THEN ve.debit_amount ELSE 0 END) as total_debit"),
                DB::raw("SUM(CASE WHEN DATE(ve.date) BETWEEN '$fromDate' AND '$toDate' THEN ve.credit_amount ELSE 0 END) as total_credit")
            )
            ->groupBy('gl.id', 'gl.name', 'gl.open_balance', 'gl.open_balance_type');

        if ($branchId) {
            $ledgers->where(function ($q) use ($branchId) {
                $q->where('members.branch_id', $branchId)
                ->orWhereIn('members.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')->from('users')->where('branch_id', $branchId);
                });
            });
        }

        $ledgers = $ledgers->get();

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

        return compact('ledgers', 'fromDate', 'toDate', 'totalDebit', 'totalCredit', 'branches');
    }

    /**
     * View Trial Balance Report
     */
    public function viewTrialBalance(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getTrialBalance($fromDate, $toDate, $branchId);
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
        $branchId = $request->input('branch_id'); 
        $data = $this->getTrialBalance($fromDate, $toDate, $branchId);
        $pdf = Pdf::loadView('reports.misReport.trial-balance.trial_balance_pdf', $data);
        if($type == 'download'){
            return $pdf->download('trial_balance_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('trial_balance_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Receipt & Payment Report Data
     */
    public function getReceiptPaymentReport($fromDate, $toDate, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // Reusable branch filter
        $applyBranchFilter = function ($query, $tableAlias = '', $creatorField = 'entered_by') use ($branchId) {
            $branchColumn = $tableAlias ? "$tableAlias.branch_id" : 'branch_id';
            $creatorColumn = $tableAlias ? "$tableAlias.$creatorField" : 'entered_by';

            if ($branchId) {
                $query->where(function ($q) use ($branchColumn, $creatorColumn, $branchId) {
                    $q->where($branchColumn, $branchId)
                    ->orWhereIn($creatorColumn, function ($sub) use ($branchId) {
                        $sub->select('id')->from('users')->where('branch_id', $branchId);
                    });
                });
            }
        };

        // Receipts Query
        $receiptsQuery = DB::table('voucher_entries')
            ->whereBetween('date', [$fromDate, $toDate])
            ->whereIn('transaction_type', ['Receipt', 'Deposit', 'Loan Payment']);

        $applyBranchFilter($receiptsQuery);

        // Payments Query
        $paymentsQuery = DB::table('voucher_entries')
            ->whereBetween('date', [$fromDate, $toDate])
            ->whereIn('transaction_type', ['Payment', 'Withdrawal', 'Fund Transfer']);

        $applyBranchFilter($paymentsQuery);

        // Select totals
        $receipts = $receiptsQuery->select(
            DB::raw("SUM(amount) as total_receipts"),
            DB::raw("SUM(CASE WHEN transaction_mode = 'Cash' THEN amount ELSE 0 END) as cash_receipts"),
            DB::raw("SUM(CASE WHEN transaction_mode = 'Bank' THEN amount ELSE 0 END) as bank_receipts")
        )->first();

        $payments = $paymentsQuery->select(
            DB::raw("SUM(amount) as total_payments"),
            DB::raw("SUM(CASE WHEN transaction_mode = 'Cash' THEN amount ELSE 0 END) as cash_payments"),
            DB::raw("SUM(CASE WHEN transaction_mode = 'Bank' THEN amount ELSE 0 END) as bank_payments")
        )->first();

        return compact('fromDate', 'toDate', 'receipts', 'payments', 'branches');
    }

    /**
     * View Receipt & Payment Report
     */
    public function viewReceiptPaymentReport(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getReceiptPaymentReport($fromDate, $toDate, $branchId);
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
        $branchId = $request->input('branch_id'); 
        $data = $this->getReceiptPaymentReport($fromDate, $toDate, $branchId);
        $pdf = Pdf::loadView('reports.misReport.receipt-payment.receipt_payment_pdf', $data);
        if($type == 'download'){
            return $pdf->stream('receipt_payment_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        return $pdf->stream('receipt_payment_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Profit & Loss Report Data
     */
    public function getProfitLoss($fromDate, $toDate, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        $incomeGroups = ['Loan', 'Bank', 'Deposit'];
        $expenseGroups = ['Funds', 'General', 'Share'];

        // Centralized reusable branch filter closure
        $applyBranchFilter = function ($query, $tableAlias = null, $creatorField = 'entered_by') use ($branchId) {
            $branchColumn = $tableAlias ? "$tableAlias.branch_id" : "branch_id";
            $creatorColumn = $tableAlias ? "$tableAlias.$creatorField" : $creatorField;

            if ($branchId) {
                $query->where(function ($q) use ($branchColumn, $creatorColumn, $branchId) {
                    $q->where($branchColumn, $branchId)
                        ->orWhereIn($creatorColumn, function ($sub) use ($branchId) {
                            $sub->select('id')->from('users')->where('branch_id', $branchId);
                        });
                });
            }
        };

        // Income Query
        $incomeQuery = DB::table('voucher_entries as ve')
            ->join('general_ledgers as gl', 've.ledger_id', '=', 'gl.id')
            ->whereIn('gl.group', $incomeGroups)
            ->whereBetween('ve.date', [$fromDate, $toDate]);

        $applyBranchFilter($incomeQuery, 've', 'entered_by');

        $income = $incomeQuery->selectRaw('SUM(ve.credit_amount) as total_income')->first();

        // Expense Query
        $expenseQuery = DB::table('voucher_entries as ve')
            ->join('general_ledgers as gl', 've.ledger_id', '=', 'gl.id')
            ->whereIn('gl.group', $expenseGroups)
            ->whereBetween('ve.date', [$fromDate, $toDate]);

        $applyBranchFilter($expenseQuery, 've', 'entered_by');

        $expenses = $expenseQuery->selectRaw('SUM(ve.debit_amount) as total_expense')->first();

        // Calculate Net Profit or Loss
        $totalIncome = $income->total_income ?? 0;
        $totalExpense = $expenses->total_expense ?? 0;
        $netProfit = $totalIncome - $totalExpense;

        return compact('fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit', 'branches');
    }

    /**
     * View Profit & Loss Report
     */
    public function viewProfitLoss(Request $request)
    {
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getProfitLoss($fromDate, $toDate, $branchId);
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
        $branchId = $request->input('branch_id'); 
        $data = $this->getProfitLoss($fromDate, $toDate, $branchId);
        $pdf = Pdf::loadView('reports.misReport.profit-loss.profit_loss_pdf', $data);
        if($type == 'download'){
            return $pdf->download('profit_loss_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
            return $pdf->stream('profit_loss_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

    /**
     * Get Balance Sheet Data
     */
    public function getBalanceSheet($date, $branchId = null)
    {
       $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // Centralized reusable branch filter closure
        $applyBranchFilter = function ($query, $tableAlias = 've', $creatorField = 'entered_by') use ($branchId) {
            $branchColumn = "$tableAlias.branch_id";
            $creatorColumn = "$tableAlias.$creatorField";

            if ($branchId) {
                $query->where(function ($q) use ($branchColumn, $creatorColumn, $branchId) {
                    $q->where($branchColumn, $branchId)
                    ->orWhereIn($creatorColumn, function ($sub) use ($branchId) {
                        $sub->select('id')->from('users')->where('branch_id', $branchId);
                    });
                });
            }
        };

        $assetGroups = ['Deposit', 'Loan', 'Bank'];
        $liabilityGroups = ['Share', 'Funds'];
        $equityGroups = ['General'];

        // Common function for repeated queries
        $fetchGroupBalances = function ($groups, $balanceExpr, $alias) use ($date, $applyBranchFilter) {
            $query = DB::table('general_ledgers as gl')
                ->leftJoin('voucher_entries as ve', 'gl.id', '=', 've.ledger_id')
                ->whereIn('gl.group', $groups)
                ->whereDate('ve.date', '<=', $date)
                ->select(
                    'gl.name as ledger_name',
                    DB::raw("$balanceExpr as balance")
                )
                ->groupBy('gl.id', 'gl.name')
                ->havingRaw('balance > 0');

            $applyBranchFilter($query, 've');
            return $query->get();
        };

        $assets = $fetchGroupBalances($assetGroups, "SUM(ve.debit_amount) - SUM(ve.credit_amount)", 'assets');
        $liabilities = $fetchGroupBalances($liabilityGroups, "SUM(ve.credit_amount) - SUM(ve.debit_amount)", 'liabilities');
        $equity = $fetchGroupBalances($equityGroups, "SUM(ve.credit_amount) - SUM(ve.debit_amount)", 'equity');

        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance');

        return compact('date', 'assets', 'liabilities', 'equity', 'totalAssets', 'totalLiabilities', 'totalEquity', 'branches');
    }

    /**
     * View Balance Sheet Report
     */
    public function viewBalanceSheet(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getBalanceSheet($date, $branchId);
        return view('reports.misReport.balance-sheet.index', $data);
    }

    /**
     * Export Balance Sheet Report to PDF
     */
    public function exportBalanceSheetPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream'); // default type stream
        $branchId = $request->input('branch_id'); 
        $data = $this->getBalanceSheet($date, $branchId);
        $pdf = Pdf::loadView('reports.misReport.balance-sheet.balance_sheet_pdf', $data);
        if($type == 'download'){
            return $pdf->download('balance_sheet_' . $date . '.pdf');
        }
        return $pdf->stream('balance_sheet_' . $date . '.pdf');
    }


    /**
     * Get CD Ratio Data
     */
    public function getCDRatio($date, $branchId = null)
    {
         $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        $data = VoucherEntry::with('ledger')->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($q) use ($branchId) {
                    $q->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            ->select('ledger_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('ledger_id')
            ->get()
            ->map(function ($entry) {
                return [
                    'group' => $entry->ledger->group,
                    'id' => $entry->ledger->id,
                    'name' => $entry->ledger->name,
                    'total_amount' => $entry->total_amount,
                ];
            })->groupBy('group');


        return compact('data','branches');
    }

    /**
     * View CD Ratio Report
     */
    public function viewCDRatio(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getCDRatio($date,$branchId);
        return view('reports.misReport.cd-ratio.index', $data);
        // return $data;
    }

    /**
     * Export CD Ratio Report to PDF
     */
    public function exportCDRatioPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream');
        $branchId = $request->input('branch_id'); 
        $data = $this->getCDRatio($date,$branchId);
        $data['date'] = $date;
        $pdf = Pdf::loadView('reports.misReport.cd-ratio.cd_ratio_pdf', $data);
        if($type == 'download'){
            return $pdf->download('cd_ratio_' . $date . '.pdf');
        }
        return $pdf->stream('cd_ratio_' . $date . '.pdf');
    }

     /**
     * Get MIS Report Data
     */
    public function getMISReport($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // Reusable filter
        $applyBranchFilter = function ($query, $tableAlias = null, $creatorField = 'created_by') use ($branchId) {
            $branchRelationAlias = $tableAlias ? "$tableAlias.branch_id" : "branch_id";
            $creatorColumn = $tableAlias ? "$tableAlias.$creatorField" : $creatorField;

            if ($branchId) {
                $query->where(function ($q) use ($branchRelationAlias, $creatorColumn, $branchId) {
                    // Match where either:
                    $q->where($branchRelationAlias, $branchId) // the record is directly tied to this branch
                    ->orWhereIn($creatorColumn, function ($sub) use ($branchId) {
                        // or the record's creator is from this branch
                        $sub->select('id')->from('users')->where('branch_id', $branchId);
                    });
                });
            }
        };

        // Deposits
        $depositQuery = DB::table('member_depo_accounts as mda')
            ->join('members as m', 'mda.member_id', '=', 'm.id')
            ->whereDate('mda.created_at', '<=', $date);
        $applyBranchFilter($depositQuery, 'm');
        $totalDeposits = $depositQuery->sum('mda.balance');

        // Loans Disbursed
        $loanDisbursedQuery = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->whereDate('mla.created_at', '<=', $date);
        $applyBranchFilter($loanDisbursedQuery, 'm');
        $totalLoansDisbursed = $loanDisbursedQuery->sum('mla.loan_amount');

        // Loan Outstanding
        $loanOutstandingQuery = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->whereDate('mla.created_at', '<=', $date);
        $applyBranchFilter($loanOutstandingQuery, 'm');
        $totalLoansOutstanding = $loanOutstandingQuery->sum('mla.balance');

        // Interest Earned
        $interestEarnedQuery = DB::table('voucher_entries as ve')
            ->whereDate('ve.created_at', '<=', $date)
            ->where('ve.transaction_type', 'Interest Earned');
        $applyBranchFilter($interestEarnedQuery, 've', 'entered_by');
        $totalInterestEarned = $interestEarnedQuery->sum('ve.credit_amount');

        // Interest Paid
        $interestPaidQuery = DB::table('voucher_entries as ve')
            ->whereDate('ve.created_at', '<=', $date)
            ->where('ve.transaction_type', 'Interest Paid');
        $applyBranchFilter($interestPaidQuery, 've', 'entered_by');
        $totalInterestPaid = $interestPaidQuery->sum('ve.debit_amount');

        // Members
        $membersQuery = DB::table('members as m')
            ->whereDate('m.created_at', '<=', $date);
        $applyBranchFilter($membersQuery, 'm');
        $totalMembers = $membersQuery->count();

        // Accounts
        $accountsQuery = DB::table('accounts as a')
        ->join('members as m', 'a.member_id', '=', 'm.id')
        ->whereDate('a.created_at', '<=', $date);
        $applyBranchFilter($accountsQuery, 'm');
        $totalAccounts = $accountsQuery->count();

        // Loan Overdue
        $loanOverdueQuery = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->whereDate('mla.end_date', '<=', $date);
        $applyBranchFilter($loanOverdueQuery, 'm');
        $loanOverdue = $loanOverdueQuery->sum('mla.penal_interest');

        // NPA Loans
        $npaQuery = DB::table('member_loan_accounts as mla')
            ->join('members as m', 'mla.member_id', '=', 'm.id')
            ->where('mla.status', 'Defaulted');
        $applyBranchFilter($npaQuery, 'm');
        $totalNPALoans = $npaQuery->sum('mla.balance');

        // NPA Ratio
        $npaRatio = $totalLoansOutstanding > 0 ? ($totalNPALoans / $totalLoansOutstanding) * 100 : 0;

        $shareCapital = DB::table('member_financials as mf')
            ->join('members as m', 'mf.member_id', '=', 'm.id')
            ->whereDate('mf.created_at', '<=', $date);
        $applyBranchFilter($shareCapital, 'm');
        $shareCapitalAmount = $shareCapital->sum('mf.share_amount');

        $cdRatio = $totalDeposits > 0 ? ($totalLoansDisbursed / $totalDeposits) * 100 : 0;

        $credit = DB::table('voucher_entries as ve')
            ->whereDate('ve.created_at', '<=', $date);
        $applyBranchFilter($credit, 've', 'entered_by');
        $totalCredit = $credit->where('ve.transaction_type', 'Payment')->sum('ve.amount');

        $debit = DB::table('voucher_entries as ve')
            ->whereDate('ve.created_at', '<=', $date);
        $applyBranchFilter($debit, 've', 'entered_by');
        $totalDebit = $credit->where('ve.transaction_type', 'Receipt')->sum('ve.amount');

        $profit = $totalCredit > $totalDebit ? $totalCredit - $totalDebit : 0;
        $loss = $totalDebit > $totalCredit ? $totalDebit - $totalCredit : 0;

        $overduePercent = $totalLoansDisbursed > 0 ? ($loanOverdue / $totalLoansDisbursed) * 100 : 0;

        return compact(
            'date', 'totalDeposits', 'totalLoansDisbursed', 'totalLoansOutstanding',
            'totalInterestEarned', 'totalInterestPaid', 'totalMembers', 'totalAccounts',
            'loanOverdue', 'totalNPALoans', 'npaRatio', 'branches', 'shareCapitalAmount', 'cdRatio','totalCredit','totalDebit', 'profit','loss','overduePercent'
        );
    }

    /**
     * View MIS Report
     */
    public function viewMISReport(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getMISReport($date,$branchId);
        return view('reports.misReport.mis-report.index', $data);
    }

    /**
     * Export MIS Report to PDF
     */
    public function exportMISReportPDF(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $type = $request->input('type','stream'); //default type stream
        $branchId = $request->input('branch_id'); 
        $data = $this->getMISReport($date,$branchId);
        $pdf = Pdf::loadView('reports.misReport.mis-report.mis_report_pdf', $data);
        if($type == 'download'){
            return $pdf->download('mis_report_' . $date . '.pdf');
        }
        return $pdf->stream('mis_report_' . $date . '.pdf');
    }

    public function getGeneralLedgerStatement($ledgerId, $fromDate, $toDate, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $applyBranchFilter = function ($query, $tableAlias = null, $creatorField = 'entered_by') use ($branchId) {
            $branchColumn = $tableAlias ? "$tableAlias.branch_id" : "branch_id";
            $creatorColumn = $tableAlias ? "$tableAlias.$creatorField" : $creatorField;

            if ($branchId) {
                $query->where(function ($q) use ($branchColumn, $creatorColumn, $branchId) {
                    $q->where($branchColumn, $branchId)
                        ->orWhereIn($creatorColumn, function ($sub) use ($branchId) {
                            $sub->select('id')->from('users')->where('branch_id', $branchId);
                        });
                });
            }
        };

        // Fetch all transactions for the given ledger within the date range
        $transactionsQuery = DB::table('voucher_entries')
            ->select('date', 'narration', 'm_narration', 'debit_amount', 'credit_amount', 'opening_balance')
            ->where('ledger_id', $ledgerId)
            ->whereBetween('date', [$fromDate, $toDate])
            ->orderBy('date', 'asc');

        $applyBranchFilter($transactionsQuery);

        $transactions = $transactionsQuery->get();

        // Calculate opening balance before fromDate
        try {
            $fromDate = Carbon::parse($fromDate)->toDateString(); // Format: 'Y-m-d'

            $openingQuery = DB::table('voucher_entries')
                ->where('ledger_id', $ledgerId)
                ->whereDate('date', '<', $fromDate);

            $applyBranchFilter($openingQuery);

            $openingBalance = $openingQuery->sum(DB::raw('credit_amount - debit_amount + opening_balance'));

        } catch (\Exception $e) {
            logger()->error('Invalid fromDate passed: ' . $e->getMessage());
            $openingBalance = 0;
        }

        // Initialize running balance with opening balance
        $runningBalance = $openingBalance;
        $transactions = collect($transactions);
        // Process transactions and calculate running balance
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
            'branches'     => $branches,
        ];
    }

    public function viewGeneralLedgerStatementReport(Request $request)
    {
        $ledgerId = $request->input('ledger_id');
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());

        $ledgers = DB::table('general_ledgers')->select('id', 'name')->get();
        $branchId = $request->input('branch_id'); 
        $data = $this->getGeneralLedgerStatement($ledgerId, $fromDate, $toDate, $branchId);
        // dd($data);
        return view('reports.misReport.gl-statement.index', compact('ledgers', 'ledgerId', 'fromDate', 'toDate') + $data);
    }

    public function exportGeneralLedgerStatementReportPDF(Request $request)
    {
        $ledgerId = $request->input('ledger_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $type = $request->input('type', 'stream'); //default type stream

        $ledger = DB::table('general_ledgers')->where('id', $ledgerId)->first();
        $branchId = $request->input('branch_id'); 
        $data = $this->getGeneralLedgerStatement($ledgerId, $fromDate, $toDate, $branchId);
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