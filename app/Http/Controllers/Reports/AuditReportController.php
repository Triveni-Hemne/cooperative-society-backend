<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Models\VoucherEntry;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AuditReportController extends Controller
{
    private function getTrialBalance($asOnDate)
    {
        return GeneralLedger::with([
            'voucherEntries' => function ($query) use ($asOnDate) {
                $query->whereDate('date', '<=', $asOnDate);
            }
        ])
        ->get()
        ->map(function ($ledger) {
            $debit = $ledger->voucherEntries->sum('debit_amount');
            $credit = $ledger->voucherEntries->sum('credit_amount');
            return [
                'ledger_name' => $ledger->name,
                'debit' => $debit,
                'credit' => $credit
            ];
        });
    }

    public function generateTrialBalance(Request $request)
    {
        $asOnDate = $request->input('as_on_date') ?? date('Y-m-d');

        $trialBalance = $this->getTrialBalance($asOnDate);

        $totalDebit = $trialBalance->sum('debit');
        $totalCredit = $trialBalance->sum('credit');

        return view('reports.auditReport.trial-balance.index', compact('trialBalance', 'asOnDate', 'totalDebit', 'totalCredit'));
    }

    public function exportTrialBalancePDF(Request $request)
    {
        $asOnDate = $request->input('as_on_date') ?? date('Y-m-d');

        $trialBalance = $this->getTrialBalance($asOnDate);

        $totalDebit = $trialBalance->sum('debit');
        $totalCredit = $trialBalance->sum('credit');

        $pdf = Pdf::loadView('reports.auditReport.trial-balance.trial_balance_pdf', [
            'trialBalance' => $trialBalance,
            'asOnDate' => $asOnDate,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Trial_Balance_' . $asOnDate . '.pdf');
    }


    public function generateBalanceSheet(Request $request)
    {
        $asOnDate = $request->input('as_on_date', now()->toDateString());

        $data = $this->getBalanceSheetData($asOnDate);

        return view('reports.auditReport.balance-sheet.index', array_merge($data, [
            'asOnDate' => $asOnDate
        ]));
    }

    public function exportBalanceSheetPDF(Request $request)
    {
        $asOnDate = $request->input('as_on_date', now()->toDateString());

        $data = $this->getBalanceSheetData($asOnDate);

        $pdf = Pdf::loadView('reports.auditReport.balance-sheet.balance_sheet_pdf', array_merge($data, [
            'asOnDate' => $asOnDate
        ]))->setPaper('A4', 'portrait');

        return $pdf->download('Balance_Sheet_As_On_' . $asOnDate . '.pdf');
    }

    private function getBalanceSheetData($asOnDate)
    {
        $ledgers = GeneralLedger::with(['voucherEntries' => function ($query) use ($asOnDate) {
            $query->whereDate('date', '<=', $asOnDate);
        }])->get();

        $assets = [];
        $liabilities = [];
        $equity = [];

        foreach ($ledgers as $ledger) {
            $balance = $ledger->voucherEntries->sum(function ($entry) {
                return $entry->credit_amount - $entry->debit_amount;
            });

            switch ($ledger->group) {
                case 'Asset':
                    $assets[] = ['ledger_name' => $ledger->name, 'amount' => $balance];
                    break;
                case 'Liability':
                    $liabilities[] = ['ledger_name' => $ledger->name, 'amount' => abs($balance)];
                    break;
                case 'Share':
                case 'Funds':
                    $equity[] = ['ledger_name' => $ledger->name, 'amount' => abs($balance)];
                    break;
            }
        }

        // Include net profit in Equity
        $fromDate = Carbon::parse($asOnDate)->startOfYear()->toDateString();
        $toDate = $asOnDate;

        $income = GeneralLedger::with(['voucherEntries' => function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('date', [$fromDate, $toDate]);
        }])->where('group', 'Income')->get()->sum(function ($ledger) {
            return $ledger->voucherEntries->sum('credit_amount');
        });

        $expenses = GeneralLedger::with(['voucherEntries' => function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('date', [$fromDate, $toDate]);
        }])->where('group', 'Expense')->get()->sum(function ($ledger) {
            return $ledger->voucherEntries->sum('debit_amount');
        });

        $netProfit = $income - $expenses;

        if ($netProfit != 0) {
            $equity[] = [
                'ledger_name' => 'Retained Earnings (P&L)',
                'amount' => $netProfit,
            ];
        }

        $totalAssets = collect($assets)->sum('amount');
        $totalLiabilitiesEquity = collect($liabilities)->sum('amount') + collect($equity)->sum('amount');

        return compact('assets', 'liabilities', 'equity', 'netProfit', 'totalAssets', 'totalLiabilitiesEquity');
    }





    private function getLedgersByGroup($group, $amountField, $fromDate, $toDate)
    {
        return GeneralLedger::with(['voucherEntries' => function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('date', [$fromDate, $toDate]);
            }])
            ->where('group', $group)
            ->get()
            ->map(function ($ledger) use ($amountField) {
                return [
                    'ledger_name' => $ledger->name,
                    'amount' => $ledger->voucherEntries->sum($amountField),
                ];
            });
    }
    
    public function generateProfitLoss(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $incomeLedgers = $this->getLedgersByGroup('Income', 'credit_amount', $fromDate, $toDate);
        $expenseLedgers = $this->getLedgersByGroup('Expense', 'debit_amount', $fromDate, $toDate);

        $totalIncome = $incomeLedgers->sum('amount');
        $totalExpense = $expenseLedgers->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        return view('reports.auditReport.profit-loss.index', compact(
            'incomeLedgers', 'expenseLedgers', 'fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit'
        ));
    }

    public function exportProfitLossPDF(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $incomeLedgers = $this->getLedgersByGroup('Income', 'credit_amount', $fromDate, $toDate);
        $expenseLedgers = $this->getLedgersByGroup('Expense', 'debit_amount', $fromDate, $toDate);

        $totalIncome = $incomeLedgers->sum('amount');
        $totalExpense = $expenseLedgers->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('reports.auditReport.profit-loss.profit_loss_pdf', compact(
            'incomeLedgers', 'expenseLedgers', 'fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('Profit_Loss_' . $fromDate . '_to_' . $toDate . '.pdf');
    }



}