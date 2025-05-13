<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\VoucherEntry;
use App\Models\GeneralLedger;
use App\Models\MemberLoanAccount;
use App\Models\LoanGuarantor;

class GeneralReportController extends Controller
{
     public function getAccountStatement($accountId, $startDate, $endDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
            $branches = $user->role === 'Admin' ? Branch::all() : null;
            
            $transactions = \App\Models\VoucherEntry::with(['enteredBy', 'branch'])
            ->where(function ($query) use ($accountId) {
                $query->where('account_id', $accountId)
                    ->orWhere('member_depo_account_id', $accountId)
                    ->orWhere('member_loan_account_id', $accountId);
                })
            ->whereBetween('date', [$startDate, $endDate])
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            ->orderBy('date', 'asc')
            ->get([
                'id',
                'date',
                'voucher_num',
                'ledger_id',
                'transaction_type',
                'debit_amount',
                'credit_amount',
                'opening_balance',
                'current_balance',
                'transaction_mode',
                'payment_mode',
                'reference_number',
                'narration',
                'status'
            ]);

        return compact('accountId', 'startDate', 'endDate', 'transactions', 'branches');
    }


    public function accountStatement(Request $request)
    {
        $accounts = Account::all();
        $accountId = $request->input('account_id');
        $startDate = $request->input('start_date', today()->subMonth()->toDateString());
        $endDate = $request->input('end_date', today()->toDateString());
        $branchId = $request->input('branch_id'); 

        // Fetch transactions
        $data = $this->getAccountStatement($accountId, $startDate, $endDate, $branchId);

        return view('reports.generalReport.account-statements.index', [
            'accountId' => $accountId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $data['transactions'],
            'branches' => $data['branches'],
            'accounts' => $accounts
        ]);
    }


    public function exportAccountStatementPDF(Request $request)
    {
        $accountId = $request->input('account_id');
        $startDate = $request->input('start_date', today()->subMonth()->toDateString());
        $endDate = $request->input('end_date', today()->toDateString());
        $type = $request->input('type','stream'); // default to stream
        $branchId = $request->input('branch_id'); 

        // Fetch transactions
        $data = $this->getAccountStatement($accountId, $startDate, $endDate, $branchId);

        $pdf = Pdf::loadView('reports.generalReport.account-statements.account_statement_pdf', [
            'accountId' => $accountId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $data['transactions']
        ]);
        if($type == 'download'){
            return $pdf->download('account_statement_' . $accountId . '_' . $startDate . '_to_' . $endDate . '.pdf'); 
        }
        return $pdf->stream('account_statement_' . $accountId . '_' . $startDate . '_to_' . $endDate . '.pdf');
    }

    /**
     * Fetch General Ledger Transactions with totals.
     */
    private function getGeneralLedgerData($ledgerId, $startDate, $endDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $transactions = collect(); // Default empty collection
        $totalDebit = 0;
        $totalCredit = 0;

        if ($ledgerId) {
            $transactions = VoucherEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->where('ledger_id', $ledgerId)
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->get(['date', 'voucher_num', 'transaction_type', 'debit_amount', 'credit_amount', 'current_balance', 'narration']);

            // Calculate totals
            $totalDebit = $transactions->sum('debit_amount');
            $totalCredit = $transactions->sum('credit_amount');
        }

        return compact('transactions', 'totalDebit', 'totalCredit', 'branches');
    }

    /**
     * Display the General Ledger Statement.
     */
    public function generalLedgerStatement(Request $request)
    {
        $ledgers = GeneralLedger::all();
        $ledgerId = $request->input('ledger_id');
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 

        $data = $this->getGeneralLedgerData($ledgerId, $startDate, $endDate, $branchId);

        return view('reports.generalReport.gl-statements.index', array_merge(
            $data, compact('ledgerId', 'startDate', 'endDate', 'ledgers')
        ));
    }

    /**
     * Export General Ledger Statement as PDF.
     */
    public function exportGeneralLedgerPDF(Request $request)
    {
        $ledgerId = $request->input('ledger_id');
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $type = $request->input('type','stream'); //deafaul stream

        if (!$ledgerId) {
            return back()->with('error', 'Please select a ledger to generate the PDF.');
        }
        $branchId = $request->input('branch_id'); 
        $data = $this->getGeneralLedgerData($ledgerId, $startDate, $endDate, $branchId);

        $pdf = Pdf::loadView('reports.generalReport.gl-statements.gl_statement_pdf', array_merge(
            $data, compact('ledgerId', 'startDate', 'endDate')
        ));
        if($type == 'download'){
            return $pdf->download("General_Ledger_Statement_{$startDate}_to_{$endDate}.pdf");
        }
        return $pdf->stream("General_Ledger_Statement_{$startDate}_to_{$endDate}.pdf");
    }

    /**
     * Fetch Member Transactions with Totals.
     */
    private function getMemberTransactions($memberId, $startDate, $endDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }
            
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $transactions = collect(); // Default empty collection
        $totalDeposits = 0;
        $totalWithdrawals = 0;
        $totalLoans = 0;

        if ($memberId) {
            $transactions = VoucherEntry::when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->where(function ($query) use ($memberId) {
                    $query->whereHas('memberDepositAccount', function ($q) use ($memberId) {
                        $q->where('member_id', $memberId);
                    })->orWhereHas('memberLoanAccount', function ($q) use ($memberId) {
                        $q->where('member_id', $memberId);
                    });
                })
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->get(['date', 'voucher_num', 'transaction_type', 'debit_amount', 'credit_amount', 'amount', 'status', 'narration']);

            // Calculate totals
            $totalDeposits = $transactions->where('transaction_type', 'Deposit')->sum('amount');
            $totalWithdrawals = $transactions->where('transaction_type', 'Withdrawal')->sum('amount');
            $totalLoans = $transactions->where('transaction_type', 'Loan Payment')->sum('amount');
        }

        return compact('transactions', 'totalDeposits', 'totalWithdrawals', 'totalLoans', 'branches');
    }

    /**
     * Display the Member Statement.
     */
    public function memberStatement(Request $request)
    {
        $members = Member::all();
        $memberId = $request->input('member_id');
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getMemberTransactions($memberId, $startDate, $endDate, $branchId);

        return view('reports.generalReport.member-statements.index', array_merge(
            $data, compact('memberId', 'startDate', 'endDate', 'members')
        ));
    }

    /**
     * Export Member Statement as PDF.
     */
    public function exportMemberStatementPDF(Request $request)
    {
        $memberId = $request->input('member_id');
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $type = $request->input('type','stream'); //default type stream

        if (!$memberId) {
            return back()->with('error', 'Please select a member to generate the PDF.');
        }
        $branchId = $request->input('branch_id'); 
        $data = $this->getMemberTransactions($memberId, $startDate, $endDate, $branchId);

        $pdf = Pdf::loadView('reports.generalReport.member-statements.member_statement_pdf', array_merge(
            $data, compact('memberId', 'startDate', 'endDate')
        ));

        if($type == 'download'){
            return $pdf->download("Member_Statement_{$startDate}_to_{$endDate}.pdf");
        }
        return $pdf->stream("Member_Statement_{$startDate}_to_{$endDate}.pdf");
    }

    public function getloanGuarantorReport($startDate, $endDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        $guarantors = LoanGuarantor::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('loan.member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('loan.member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->with([
            'loan.member',
            'member'
        ])
        ->whereHas('loan', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->get();

        return compact('guarantors', 'startDate', 'endDate', 'branches');
    }

    public function loanGuarantorReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getloanGuarantorReport($startDate, $endDate, $branchId);
        return view('reports.generalReport.loan-guarantors.index', array_merge(
                $data, compact('startDate', 'endDate')
            ));
    }

    public function exportLoanGuarantorPDF(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 
        $data = $this->getloanGuarantorReport($startDate, $endDate, $branchId);
        $type = $request->input('type', 'stream'); //deafault type stream
        $pdf = Pdf::loadView('reports.generalReport.loan-guarantors.loan_guarantors_pdf', array_merge(
            $data, compact('startDate', 'endDate')
        ));
        if($type == 'download'){
            return $pdf->download("Loan_Guarantor_Report_{$startDate}_to_{$endDate}.pdf");
        }
        return $pdf->stream("Loan_Guarantor_Report_{$startDate}_to_{$endDate}.pdf");
    }

    public function getDemandList($startDate, $endDate, $branchId = null)
    {
         $user = Auth::user();
         if (!$branchId) {
             $branchId = $user->role === 'Admin' ? null : $user->branch_id;
            }

        $branches = $user->role === 'Admin' ? Branch::all() : null;
        
       $demandList = MemberLoanAccount::with(['member', 'loanInstallments' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('mature_date', [$startDate, $endDate])
                ->whereColumn('total_installments_paid', '<', 'total_installments'); // unpaid
            }])
            ->whereHas('loanInstallments', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('mature_date', [$startDate, $endDate])
                ->whereColumn('total_installments_paid', '<', 'total_installments'); // unpaid
            })
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('member.user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('member', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    });
                });
            })
            ->get();

        return compact('demandList', 'startDate', 'endDate', 'branches');
    }


    public function demandList(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $branchId = $request->input('branch_id'); 

        $data = $this->getDemandList($startDate, $endDate, $branchId);
        // return $data;
        return view('reports.generalReport.demand-list.index', $data);
    }

    public function exportDemandListPDF(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $type = $request->input('type','stream');
        $branchId = $request->input('branch_id'); 

        $data = $this->getDemandList($startDate, $endDate, $branchId);

        $pdf = Pdf::loadView('reports.generalReport.demand-list.demand_list_pdf', $data);
        if($type == 'download'){
            return $pdf->download("Demand_List_Report_{$startDate}_to_{$endDate}.pdf");
        }
        return $pdf->stream("Demand_List_Report_{$startDate}_to_{$endDate}.pdf");
    }


}