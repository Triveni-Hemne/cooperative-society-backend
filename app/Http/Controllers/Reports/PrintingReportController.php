<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Member;
use App\Models\VoucherEntry;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;

class PrintingReportController extends Controller
{
  
   public function getDuplicateData($voucherNo = null, $memberId = null, $startDate = null, $endDate = null)
    {
        $query = VoucherEntry::with([
            'account',
            'memberDepoAccount.member',
            'memberLoanAccount.member'
        ]);

        if (!empty($voucherNo)) {
            $query->where('voucher_num', $voucherNo);
        }

        if (!empty($memberId)) {
            $query->whereHas('memberDepositAccount', fn($q) => $q->where('member_id', $memberId))
                ->orWhereHas('memberLoanAccount', fn($q) => $q->where('member_id', $memberId));
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $entries = $query->orderByDesc('date')->get();

        return compact('entries', 'voucherNo', 'memberId', 'startDate', 'endDate');
    }

    public function viewDuplicate(Request $request)
    {
        $voucherNo = $request->input('voucher_num');
        $memberId = $request->input('member_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = $this->getDuplicateData($voucherNo, $memberId, $startDate, $endDate);
        // Get distinct voucher numbers and member list
        $data['voucherNumbers'] = VoucherEntry::select('voucher_num')->distinct()->pluck('voucher_num')->filter()->values();
        $data['members'] = Member::select('id', 'name')->orderBy('name')->get();
        
        return view('reports.printingReport.duplicate-printing.index', $data);
    }

    public function exportDuplicatePDF($id)
    {
        $entry = VoucherEntry::with([
            'account',
            'memberDepoAccount.member',
            'memberLoanAccount.member'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('reports.printingReport.duplicate-printing.duplicate_printing_pdf', compact('entry'))
                ->setPaper('A5', 'portrait');

        return $pdf->download("Duplicate_Receipt_{$entry->voucher_num}.pdf");
    }


    public function exportDuplicateListPDF(Request $request)
    {
        $data = $this->getDuplicateData(
            $request->input('voucher_num'),
            $request->input('member_id'),
            $request->input('start_date'),
            $request->input('end_date')
        );

        $pdf = Pdf::loadView('reports.printingReport.duplicate-printing.duplicate_printing_list_pdf', $data)
                ->setPaper('A4', 'portrait');

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
            $transactions = VoucherEntry::where('member_deposit_account_id', $accountId)
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        }
        if ($accountType === 'rd') {
            $transactions = VoucherEntry::where('member_deposit_account_id', $accountId)
                ->where('deposit_type', 'rd')
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        } elseif ($accountType === 'fd') {
            $transactions = VoucherEntry::where('member_deposit_account_id', $accountId)
                ->where('deposit_type', 'fd')
                ->when($fromDate && $toDate, fn($q) => $q->whereBetween('date', [$fromDate, $toDate]))
                ->orderBy('date')
                ->get();
        } elseif ($accountType === 'share') {
            $transactions = VoucherEntry::where('member_financial_id', $accountId)
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
            $account = MemberDepositAccount::with('member')->findOrFail($accountId);
        } else {
            $account = null;
        }
        if ($accountType === 'rd' || $accountType === 'fd') {
            $account = MemberDepositAccount::with('member')->findOrFail($accountId);
        } elseif ($accountType === 'share') {
            $account = DB::table('member_financials')
                ->where('id', $accountId)
                ->first(); // or convert to model if needed
        }

        return view('reports.printingReport.passbook-printing.index', compact(
            'memberId', 'account', 'transactions', 'accountType', 'accountId', 'fromDate', 'toDate'
        ));
    }


    public function viewPassbookForm()
    {
        $members = DB::table('members')->select('id', 'name')->get();

        $loanAccounts = DB::table('member_loan_accounts')
            ->select('id', 'member_id', 'acc_no as account_number')
            ->get();

        $depositAccounts = DB::table('member_depo_accounts')
            ->select('id', 'member_id', 'acc_no', 'deposit_type') // deposit_type: savings, rd, fd
            ->get();

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
        $shareAccounts = DB::table('member_financials')
            ->select('id', 'member_id') // adjust field if needed
            ->where('type', 'Share')
            ->get();

        return view('reports.printingReport.passbook-printing.passbook-form', compact(
            'members',
            'loanAccounts',
            'depositAccounts',
            // 'savingAccounts',
            // 'recurringDeposits',
            // 'fixedDeposits',
            'shareAccounts'
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
            $account = MemberDepositAccount::with('member')->findOrFail($accountId);
        } elseif ($accountType === 'share') {
            $account = DB::table('member_financials')->where('id', $accountId)->first();
        } else {
            $account = null;
        }
        
        $transactions = $this->getPassbookData($accountType, $accountId, $fromDate, $toDate);

        $pdf = Pdf::loadView('reports.printingReport.passbook-printing.passbook_pdf', compact('transactions', 'accountType', 'fromDate', 'toDate', 'accountId', 'account'))
                ->setPaper('A5', 'portrait');

        return $pdf->stream("Passbook_{$accountType}_{$accountId}.pdf");
    }


}