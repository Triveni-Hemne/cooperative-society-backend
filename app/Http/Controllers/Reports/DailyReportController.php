<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayBegin;
use App\Models\DayEnd;
use App\Models\VoucherEntry;
use App\Models\TransferEntry;
use App\Models\GeneralLedger;
use App\Models\BranchLedger;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use App\Models\Branch;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyReportController extends Controller
{
   public function getCashBookData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        // Fetch transactions for the selected date
        $cashEntries  = VoucherEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('enteredBy', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->whereDate('date', $date)->with('ledger')->get();
        // Fetch transactions for the selected date
        $transferEntries   = TransferEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->whereDate('date', $date)->with('ledger')->get();

       $allEntries = $cashEntries->concat($transferEntries)->values();

        $grouped = $allEntries
            ->groupBy(function ($entry) {
                return $entry->ledger->name ?? 'Unknown Ledger'; // Group by Ledger name
            })
            ->map(function ($entriesByLedger) {
                return $entriesByLedger
                    ->groupBy('transaction_type') // Group by transaction_type
                    ->map(function ($entriesByTransactionType) {
                        return [
                            'voucher_entries' => $entriesByTransactionType->filter(fn($e) => $e instanceof VoucherEntry)->values(),
                            'transfer_entries' => $entriesByTransactionType->filter(fn($e) => $e instanceof TransferEntry)->values(),
                        ];
                    });
            });

       // 1. VoucherEntry Opening Balance (Before selected date)
        $voucherOpening = VoucherEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            // ->where('payment_mode', 'Cash')
            ->whereDate('date', $date)
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) -
                SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END)
                AS balance
            ")
            ->value('balance') ?? 0;

        // 2. TransferEntry Opening Balance (Before selected date)
        $transferOpening = TransferEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            ->whereDate('date', $date)
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) -
                SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END)
                AS balance
            ")
            ->value('balance') ?? 0;

        // 3. Final Opening Balance
        $openingBalance = $voucherOpening + $transferOpening;

        $voucherTotals = VoucherEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('enteredBy', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })
        // ->where('payment_mode', 'Cash')
        ->whereDate('date', $date) // ✅ Current date, not before
        ->selectRaw("
            SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) AS total_cash_receipts,
            SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END) AS total_cash_payments
        ")
        ->first();
        $transferTotals = TransferEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })
        ->whereDate('date', $date)
        ->selectRaw("
            SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) AS total_transfer_receipts,
            SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END) AS total_transfer_payments
        ")
        ->first();

        $cashReceipts    = $voucherTotals->total_cash_receipts ?? 0;
        $cashPayments    = $voucherTotals->total_cash_payments ?? 0;

        $transReceipts   = $transferTotals->total_transfer_receipts ?? 0;
        $transPayments   = $transferTotals->total_transfer_payments ?? 0;

        $totalReceipts   = $cashReceipts + $transReceipts;
        $totalPayments   = $cashPayments + $transPayments;

        $closingBalance  = $openingBalance + $totalReceipts - $totalPayments;


        return compact('date', 'openingBalance', 'totalReceipts', 'totalPayments', 'closingBalance', 'grouped', 'branches');
    }

    public function cashBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getCashBookData($date, $branchId);

        return view('reports.dailyReport.cash-book.index', $data);
    }

    /**
     * Export Cash Book to PDF.
     */
    public function exportPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getCashBookData($date, $branchId);
        $type = $request->input('type', 'stream');

        $pdf = Pdf::loadView('reports.dailyReport.cash-book.cashbook_pdf', $data);
        if($type == 'download'){
            return $pdf->download('cashbook_report_' . $date . '.pdf');
        }
        return $pdf->stream('cashbook_report_' . $date . '.pdf');
    }

    public function getDayBookData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        
        // Fetch transactions for the selected date
        $cashEntries  = VoucherEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('enteredBy', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->whereDate('date', $date)->with('ledger')->get();
        // Fetch transactions for the selected date
        $transferEntries   = TransferEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->whereDate('date', $date)->with('ledger')->get();

       $allEntries = $cashEntries->concat($transferEntries)->values();

        $grouped = $allEntries
            ->groupBy(function ($entry) {
                return $entry->ledger->name ?? 'Unknown Ledger'; // Group by Ledger name
            })
            ->map(function ($entriesByLedger) {
                return $entriesByLedger
                    ->groupBy('transaction_type') // Group by transaction_type
                    ->map(function ($entriesByTransactionType) {
                        return [
                            'voucher_entries' => $entriesByTransactionType->filter(fn($e) => $e instanceof VoucherEntry)->values(),
                            'transfer_entries' => $entriesByTransactionType->filter(fn($e) => $e instanceof TransferEntry)->values(),
                        ];
                    });
            });


        // 1. VoucherEntry Opening Balance (Before selected date)
        $voucherOpening = VoucherEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            // ->where('payment_mode', 'Cash')
            ->whereDate('date', $date)
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) -
                SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END)
                AS balance
            ")
            ->value('balance') ?? 0;

        // 2. TransferEntry Opening Balance (Before selected date)
        $transferOpening = TransferEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            ->whereDate('date', $date)
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) -
                SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END)
                AS balance
            ")
            ->value('balance') ?? 0;

        // 3. Final Opening Balance
        $openingBalance = $voucherOpening + $transferOpening;

        $voucherTotals = VoucherEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('enteredBy', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })
        // ->where('payment_mode', 'Cash')
        ->whereDate('date', $date) // ✅ Current date, not before
        ->selectRaw("
            SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) AS total_cash_receipts,
            SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END) AS total_cash_payments
        ")
        ->first();
        $transferTotals = TransferEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })
        ->whereDate('date', $date)
        ->selectRaw("
            SUM(CASE WHEN transaction_type = 'Receipt' THEN amount ELSE 0 END) AS total_transfer_receipts,
            SUM(CASE WHEN transaction_type = 'Payment' THEN amount ELSE 0 END) AS total_transfer_payments
        ")
        ->first();

        $cashReceipts    = $voucherTotals->total_cash_receipts ?? 0;
        $cashPayments    = $voucherTotals->total_cash_payments ?? 0;

        $transReceipts   = $transferTotals->total_transfer_receipts ?? 0;
        $transPayments   = $transferTotals->total_transfer_payments ?? 0;

        $totalReceipts   = $cashReceipts + $transReceipts;
        $totalPayments   = $cashPayments + $transPayments;

        $closingBalance  = $openingBalance + $totalReceipts - $totalPayments;

        return compact('date', 'totalReceipts', 'totalPayments','branches', 'grouped', 'openingBalance', 'closingBalance');
    }

    public function dayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getDayBookData($date, $branchId);

        return view('reports.dailyReport.day-book.index', $data);
    }

    /**
     * Export Day Book to PDF.
     */
    public function exportDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $data = $this->getDayBookData($date, $branchId);
        $type = $request->input('type', 'stream');

        $pdf = Pdf::loadView('reports.dailyReport.day-book.daybook_pdf', $data);
         if($type == 'download'){
            return $pdf->download('daybook_report_' . $date . '.pdf');
        }
        return $pdf->stream('daybook_report_' . $date . '.pdf');
    }


    /**
     * Fetch Sub Day Book Data
     */
    public function getSubDayBookData($date, $accountType = null, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // Fetch transactions
        $query = VoucherEntry::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('enteredBy', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })
        ->whereDate('voucher_entries.date', $date)
        ->join('accounts', 'voucher_entries.account_id', '=', 'accounts.id')
        ->select('voucher_entries.*', 'accounts.account_type', 'accounts.name');

        if ($accountType) {
            $query->where('accounts.account_type', $accountType);
        }

        $transactions = $query->orderBy('voucher_entries.date', 'asc')->get();

        // Fetch aggregated totals (with branch filter applied)
        $totals = DB::table('voucher_entries')
            ->join('accounts', 'voucher_entries.account_id', '=', 'accounts.id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereExists(function ($q) use ($branchId) {
                        $q->select(DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'voucher_entries.entered_by')
                        ->where('users.branch_id', $branchId);
                    })->orWhereExists(function ($q) use ($branchId) {
                        $q->select(DB::raw(1))
                        ->from('branches')
                        ->whereColumn('branches.id', 'voucher_entries.branch_id')
                        ->where('branches.id', $branchId);
                    });
                });
            })
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

        $accountTypes = DB::table('accounts')->distinct()->pluck('account_type');

        return compact(
            'date',
            'transactions',
            'totalDeposits',
            'totalWithdrawals',
            'accountTypes',
            'accountType',
            'branches'
        );
    }

    /**
     * Show Sub Day Book Report
     */
    public function subDayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');
        $accountType = $request->input('account_type');

        $data = $this->getSubDayBookData($date, $accountType, $branchId);

        return view('reports.dailyReport.sub-day-book.index', $data);
    }

    /**
     * Export Sub Day Book to PDF
     */
    public function exportSubDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $accountType = $request->input('account_type');

        $data = $this->getSubDayBookData($date, $accountType, $branchId);
        $type = $request->input('type', 'stream');

        $pdf = Pdf::loadView('reports.dailyReport.sub-day-book.subdaybook_pdf', $data);
        if($type == 'download'){
            return $pdf->download('subdaybook_report_' . $date . '.pdf');
        }
        return $pdf->stream('subdaybook_report_' . $date . '.pdf');
    }

    /**
     * Fetch GL Statement Data
     */
    public function getGLStatementData($startDate, $endDate, $glAccount = null,$branchId = null)
    {
         $user = Auth::user();

        // Determine branch context
        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        // Load branches list for Admins
        $branches = $user->role === 'Admin' ? Branch::all() : null;

    // Reset SQL variable
    DB::statement('SET @running_balance = 0');

        // Fetch General Ledger Transactions with Running Balance
       $query = DB::table('general_ledgers as gl')
        ->join('accounts as acc', 'gl.id', '=', 'acc.ledger_id')
        ->leftJoin('members as m', 'acc.member_id', '=', 'm.id')
        ->leftJoin('users as u', 'm.created_by', '=', 'u.id')
        ->when($branchId, function ($q) use ($branchId) {
            $q->where(function ($subQuery) use ($branchId) {
                $subQuery->where('m.branch_id', $branchId)
                        ->orWhere('u.branch_id', $branchId);
            });
        })
        ->whereBetween('gl.created_at', [$startDate, $endDate])
        ->when($glAccount, function ($q) use ($glAccount) {
            return $q->where('acc.id', $glAccount);
        })
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
        )
        ->orderBy('gl.created_at', 'asc');

        if ($glAccount) {
            $query->where('acc.id', $glAccount);
        }

        $transactions = $query->orderBy('gl.created_at', 'asc')->get();

        // Calculate total debits and credits
       $totals = DB::table('general_ledgers as gl')
        ->join('accounts as acc', 'gl.parent_ledger_id', '=', 'acc.id')
        ->leftJoin('members as m', 'acc.member_id', '=', 'm.id')
        ->leftJoin('users as u', 'm.created_by', '=', 'u.id')
        ->when($branchId, function ($q) use ($branchId) {
            $q->where(function ($subQuery) use ($branchId) {
                $subQuery->where('m.branch_id', $branchId)
                        ->orWhere('u.branch_id', $branchId);
            });
        })
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
            'branches' => $branches
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
        $branchId = $request->input('branch_id');        

        // Get data from `getGLStatementData()`
        $data = $this->getGLStatementData($startDate, $endDate, $glAccount, $branchId);

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
        $type = $request->input('type', 'stream');
        $branchId = $request->input('branch_id');

        $data = $this->getGLStatementData($startDate, $endDate, $glAccount,$branchId);

        $pdf = Pdf::loadView('reports.dailyReport.gl-statement-checking.glstatementchecking_pdf', $data);
         if($type == 'download'){
            return $pdf->download('gl_statement_' . $startDate . '_to_' . $endDate . '.pdf');
        }
        return $pdf->stream('gl_statement_' . $startDate . '_to_' . $endDate . '.pdf');
    }

   /**
     * Fetch Cut Book (Loan Repayment) Data
     */
    public function getCutBookData($startDate, $endDate, $loanAccountId = null, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        // Initialize Running Balance for each Loan Account
        DB::statement('SET @running_balance = 0');

        // Fetch Loan Transactions from General Ledgers with branch filter
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

        // Apply the loan account filter if provided
        if ($loanAccountId) {
            $query->where('mla.id', $loanAccountId);
        }

        // Apply the branch filter if provided (Admin role or user branch)
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhere('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')
                        ->from('users')
                        ->where('branch_id', $branchId);
                });
            });
        }

        $transactions = $query->orderBy('gl.created_at', 'asc')->get();

        // Calculate Total Payments
        $totals = DB::table('general_ledgers as gl')
        ->join('member_loan_accounts as mla', 'gl.id', '=', 'mla.ledger_id')
        ->join('members as m', 'mla.member_id', '=', 'm.id')
        ->leftJoin('users as u', 'm.created_by', '=', 'u.id')
        ->whereBetween('gl.created_at', [$startDate, $endDate])
        ->when($loanAccountId, fn($q) => $q->where('mla.id', $loanAccountId))
        ->when($branchId, function ($q) use ($branchId) {
            $q->where(function ($subQuery) use ($branchId) {
                $subQuery->where('m.branch_id', $branchId)
                        ->orWhere('u.branch_id', $branchId);
            });
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

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $transactions,
            'totalPrincipalPaid' => $totalPrincipalPaid,
            'totalInterestPaid' => $totalInterestPaid,
            'loanAccounts' => $loanAccounts,
            'loanAccountId' => $loanAccountId,
            'branches' => $branches
        ];
    }

    /**
     * Show Cut Book Report
     */
    public function cutBookReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $loanAccountId = $request->input('loan_account');
        $branchId = $request->input('branch_id');

        $data = $this->getCutBookData($startDate, $endDate, $loanAccountId, $branchId);
         return view('reports.dailyReport.cut-book.index', $data);
    }

    public function exportCutBookPDF(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $loanAccountId = $request->input('loan_account');
        $type = $request->input('type', 'stream');
        $branchId = $request->input('branch_id');

         $data = $this->getCutBookData($startDate, $endDate, $loanAccountId, $branchId);

        // Load PDF view with the same data
        $pdf = Pdf::loadView('reports.dailyReport.cut-book.cut-book_pdf', $data);

        if ($type == 'download') {
            return $pdf->download('Cut_Book_Report_' . $startDate . '_to_' . $endDate . '.pdf');
        }
        return $pdf->stream('Cut_Book_Report_' . $startDate . '_to_' . $endDate . '.pdf');
    }

    /**
     * Show Demand Day Book Report
     */
    public function getDemandDayBookData($date, $branchId = null)
    {
        $user = Auth::user();

        if (!$branchId) {
            $branchId = $user->role === 'Admin' ? null : $user->branch_id;
        }

        $branches = $user->role === 'Admin' ? Branch::all() : null;

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
            ->groupBy('mla.id', 'mla.acc_no', 'm.name', 'mla.emi_amount');

            // Apply branch filter if provided
        if ($branchId) {
            $expectedPayments->where(function ($q) use ($branchId) {
                $q->where('m.branch_id', $branchId)
                ->orWhere('m.created_by', function ($sub) use ($branchId) {
                    $sub->select('id')
                        ->from('users')
                        ->where('branch_id', $branchId);
                });
            });
        }

        $expectedPayments = $expectedPayments->get();
        return compact('date', 'expectedPayments', 'branches');
    }

    public function demandDayBook(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');        
        $data = $this->getDemandDayBookData($date, $branchId);

        return view('reports.dailyReport.demand-day-book.index', $data);
    }

    public function exportDemandDayBookPDF(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $branchId = $request->input('branch_id');        
        $data = $this->getDemandDayBookData($date, $branchId);
        $type = $request->input('type', 'stream');
        $pdf = Pdf::loadView('reports.dailyReport.demand-day-book.demand_day_book_pdf', $data);
        if($type == 'download'){
            return $pdf->download('demand_day_book_' . $date . '.pdf');
        }
        return $pdf->stream('demand_day_book_' . $date . '.pdf');
    }


}