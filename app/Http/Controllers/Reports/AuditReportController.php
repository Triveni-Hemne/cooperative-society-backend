<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Models\VoucherEntry;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AuditReportController extends Controller
{
    private function getTrialBalance($asOnDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
       $ledgers = GeneralLedger::with(['voucherEntries' => function ($query) use ($asOnDate, $branchId) {
    $query->whereDate('date', '<=', $asOnDate);

        if ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            }
        }])->get();

        $trialBalance = $ledgers->map(function ($ledger) {
            // Ensure voucherEntries is a collection
            $voucherEntries = collect($ledger->voucherEntries);

            $debit = $voucherEntries->sum('debit_amount');
            $credit = $voucherEntries->sum('credit_amount');

            return [
                'ledger_name' => $ledger->name,
                'debit' => $debit,
                'credit' => $credit,
            ];
        });

        return compact('trialBalance', 'branches');
    }

    public function generateTrialBalance(Request $request)
    {
        $asOnDate = $request->input('as_on_date') ?? date('Y-m-d');
        $branchId = $request->input('branch_id'); 
        $result = $this->getTrialBalance($asOnDate, $branchId);
        $trialBalance = $result['trialBalance'];
        $branches = $result['branches'];
        $totalDebit = $trialBalance->sum('debit');
        $totalCredit = $trialBalance->sum('credit');

        return view('reports.auditReport.trial-balance.index', compact('trialBalance', 'asOnDate', 'totalDebit', 'totalCredit', 'branches'));
    }

    public function exportTrialBalancePDF(Request $request)
    {
        $asOnDate = $request->input('as_on_date') ?? date('Y-m-d');
        $branchId = $request->input('branch_id'); 

        $result = $this->getTrialBalance($asOnDate,$branchId);
        $type = $request->input('type', 'stream'); // default to stream

        $trialBalance = $result['trialBalance'];
        $branches = $result['branches'];
        $totalDebit = $trialBalance->sum('debit');
        $totalCredit = $trialBalance->sum('credit');

        $pdf = Pdf::loadView('reports.auditReport.trial-balance.trial_balance_pdf', [
            'trialBalance' => $trialBalance,
            'asOnDate' => $asOnDate,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
        ])->setPaper('A4', 'portrait');

        if($type == 'download'){
            return $pdf->download('Trial_Balance_' . $asOnDate . '.pdf');
        }
        return $pdf->stream('Trial_Balance_' . $asOnDate . '.pdf');
    }

    public function generateBalanceSheet(Request $request)
    {
        $asOnDate = $request->input('as_on_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 

        $data = $this->getBalanceSheetData($asOnDate, $branchId);

        return view('reports.auditReport.balance-sheet.index', array_merge($data, [
            'asOnDate' => $asOnDate
        ]));
    }

    public function exportBalanceSheetPDF(Request $request)
    {
        $asOnDate = $request->input('as_on_date', now()->toDateString());
        $type = $request->input('type', 'stream'); // default to stream
        $branchId = $request->input('branch_id'); 

        $data = $this->getBalanceSheetData($asOnDate, $branchId);

        $pdf = Pdf::loadView('reports.auditReport.balance-sheet.balance_sheet_pdf', array_merge($data, [
            'asOnDate' => $asOnDate
        ]))->setPaper('A4', 'portrait');
        if ($type === 'download') {
            return $pdf->download('Balance_Sheet_As_On_' . $asOnDate . '.pdf');

        }
        return $pdf->stream('Balance_Sheet_As_On_' . $asOnDate . '.pdf');
    }

    private function getBalanceSheetData($asOnDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $ledgers = GeneralLedger::with(['voucherEntries' => function ($query) use ($asOnDate, $branchId) {
            $query->whereDate('date', '<=', $asOnDate);
            if ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            }
        }])->get();

        $assets = [];
        $liabilities = [];
        $equity = [];

        foreach ($ledgers as $ledger) {
            $balance = $ledger->voucherEntries->sum(function ($entry) {
                return $entry->credit_amount - $entry->debit_amount;
            });

            switch ($ledger->group) {
                case 'Deposit':
                case 'Loan':
                case 'Bank':
                case 'General':
                    $assets[] = ['ledger_name' => $ledger->name, 'amount' => $balance];
                    break;
                case 'Funds':
                    $equity[] = ['ledger_name' => $ledger->name, 'amount' => abs($balance)];
                    break;
                case 'Share':
                    $equity[] = ['ledger_name' => $ledger->name, 'amount' => abs($balance)];
                    break;
                default:
                    // Handle any unexpected group values if necessary
                    break;
            }
        }

        // Include net profit in Equity
        $fromDate = Carbon::parse($asOnDate)->startOfYear()->toDateString();
        $toDate = $asOnDate;

        $income = GeneralLedger::with(['voucherEntries' => function ($q) use ($fromDate, $toDate, $branchId) {
            $q->whereBetween('date', [$fromDate, $toDate]);
            if ($branchId) {
                $q->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            }
        }])->where('group', 'Income')->get()->sum(function ($ledger) {
            return $ledger->voucherEntries->sum('credit_amount');
        });

        $expenses = GeneralLedger::with(['voucherEntries' => function ($q) use ($fromDate, $toDate, $branchId) {
            $q->whereBetween('date', [$fromDate, $toDate]);
            if ($branchId) {
                $q->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            }
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

        return compact('assets', 'liabilities', 'equity', 'netProfit', 'totalAssets', 'totalLiabilitiesEquity', 'branches');
    }

    private function getLedgersByGroups(array $groups, $amountField, $fromDate, $toDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $ledgers = GeneralLedger::with(['voucherEntries' => function ($query) use ($fromDate, $toDate, $branchId) {
            $query->whereBetween('date', [$fromDate, $toDate]);

            if ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            }
        }])
        ->whereIn('group', $groups)
        ->get();

        $ledgerData = $ledgers->map(function ($ledger) use ($amountField) {
            return [
                'ledger_name' => $ledger->name,
                'amount' => $ledger->voucherEntries->sum($amountField),
            ];
        });
        return [
            'ledgers' => $ledgerData,
            'branches' => $branches,
        ];
    }
    
    public function generateProfitLoss(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $branchId = $request->input('branch_id'); // Assuming branch_id is passed in the request

        $incomeGroups = ['Loan', 'Bank', 'Deposit'];
        $expenseGroups = ['Funds', 'General', 'Share'];

        $incomeResult = $this->getLedgersByGroups($incomeGroups, 'credit_amount', $fromDate, $toDate, $branchId);
        $expenseResult = $this->getLedgersByGroups($expenseGroups, 'debit_amount', $fromDate, $toDate, $branchId);

        $incomeLedgers = $incomeResult['ledgers'];
        $expenseLedgers = $expenseResult['ledgers'];
        $branches = $incomeResult['branches']; // Assuming both results have the same branches

        $totalIncome = $incomeLedgers->sum('amount');
        $totalExpense = $expenseLedgers->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        return view('reports.auditReport.profit-loss.index', compact(
            'incomeLedgers', 'expenseLedgers', 'fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit', 'branches'
        ));
    }

    public function exportProfitLossPDF(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $type = $request->input('type', 'stream'); // default to stream

         $branchId = $request->input('branch_id');
         $incomeGroups = ['Loan', 'Bank', 'Deposit'];
        $expenseGroups = ['Funds', 'General', 'Share'];
        $incomeResult = $this->getLedgersByGroups($incomeGroups, 'credit_amount', $fromDate, $toDate, $branchId);
        $expenseResult = $this->getLedgersByGroups($expenseGroups, 'debit_amount', $fromDate, $toDate, $branchId);

        $incomeLedgers = $incomeResult['ledgers'];
        $expenseLedgers = $expenseResult['ledgers'];

        $totalIncome = $incomeLedgers->sum('amount');
        $totalExpense = $expenseLedgers->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('reports.auditReport.profit-loss.profit_loss_pdf', compact(
            'incomeLedgers', 'expenseLedgers', 'fromDate', 'toDate', 'totalIncome', 'totalExpense', 'netProfit'
        ))->setPaper('A4', 'portrait');

        if ($type === 'download') {
            return $pdf->download('Profit_Loss_' . $fromDate . '_to_' . $toDate . '.pdf');
        }
        
        return $pdf->stream('Profit_Loss_' . $fromDate . '_to_' . $toDate . '.pdf');
    }

}