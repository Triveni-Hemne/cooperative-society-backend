<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherEntry;
use App\Models\GeneralLedger;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
class VoucherEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = null;
        // Determine branch filter based on role
        if ($user->role === 'Admin') {
            $branchId = $request->branch_id; // admin can filter via dropdown
        } else {
            $branchId = $user->branch_id; // normal user only sees their branch
        }

        $voucherEntries = VoucherEntry::with('branch')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('enteredBy', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->paginate(5);

        // $voucherEntries = VoucherEntry::paginate(5);
        $ledgers = GeneralLedger::all();
        $accounts = Account::all();
        $depoAccounts = MemberDepoAccount::all();
        $loanAccounts = MemberLoanAccount::all();
        $users = User::all();
        $branches = Branch::all();
        return view('transactions.voucher-entry.list', compact('voucherEntries', 'ledgers','accounts','depoAccounts','loanAccounts','users','branches','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:Receipt,Payment,Journal,Deposit,Withdrawal,Loan Payment,Fund Transfer',
            'voucher_num' => 'nullable|string|max:50|unique:voucher_entries,voucher_num',
            'token_number' => 'nullable|string|max:50|unique:voucher_entries,token_number',
            'serial_no' => 'nullable|string|max:50|unique:voucher_entries,serial_no',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:voucher_entries,receipt_id',
            'payment_id' => 'nullable|string|max:50|unique:voucher_entries,payment_id',
            'ledger_id' => 'required|exists:general_ledgers,id',

            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',

            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'debit_amount' => 'nullable|numeric|min:0',
            'credit_amount' => 'nullable|numeric|min:0',
            'transaction_mode' => 'nullable|in:Cash,Bank,Online,Cheque',
            'payment_mode' => 'nullable|in:NEFT,IMPS,UPI,RTGS,Cheque,Cash,Bank Transfer',
            'reference_number' => 'nullable|string|max:100',
            'is_reversed' => 'boolean',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'entered_by' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);
        
            $selectedCount = 0;

            if (!empty($request->account_id)) $selectedCount++;
            if (!empty($request->member_depo_account_id)) $selectedCount++;
            if (!empty($request->member_loan_account_id)) $selectedCount++;

            if ($selectedCount !== 1) {
                return back()->withErrors([
                    'account_id' => 'Please select exactly one account (general, deposit, or loan account).',
                    'member_depo_account_id' => 'Please select exactly one account (general, deposit, or loan account).',
                    'member_loan_account_id' => 'Please select exactly one account (general, deposit, or loan account).',
                ])->withInput();
            }
        
        $voucherEntry = VoucherEntry::create($request->all());
        return redirect()->back()->with('success', 'Voucher Entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);
        return response()->json($voucherEntry, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);

         $request->validate([
            'transaction_type' => 'required|in:Receipt,Payment,Journal,Deposit,Withdrawal,Loan Payment,Fund Transfer',
            'voucher_num' => 'nullable|string|max:50|unique:voucher_entries,voucher_num,' . $voucherEntry->id,
            'token_number' => 'nullable|string|max:50|unique:voucher_entries,token_number,' . $voucherEntry->id,
            'serial_no' => 'nullable|string|max:50|unique:voucher_entries,serial_no,' . $voucherEntry->id,
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:voucher_entries,receipt_id,' . $voucherEntry->id,
            'payment_id' => 'nullable|string|max:50|unique:voucher_entries,payment_id,' . $voucherEntry->id,
            'ledger_id' => 'required|exists:general_ledgers,id',
            
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',
            
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'debit_amount' => 'nullable|numeric|min:0',
            'credit_amount' => 'nullable|numeric|min:0',
            'transaction_mode' => 'nullable|in:Cash,Bank,Online,Cheque',
            'payment_mode' => 'nullable|in:NEFT,IMPS,UPI,RTGS,Cheque,Cash,Bank Transfer',
            'reference_number' => 'nullable|string|max:100',
            'is_reversed' => 'boolean',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'entered_by' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',

        ]);
         $selectedCount = 0;

        if (!empty($request->account_id)) $selectedCount++;
        if (!empty($request->member_depo_account_id)) $selectedCount++;
        if (!empty($request->member_loan_account_id)) $selectedCount++;

        if ($selectedCount !== 1) {
            return back()->withErrors([
                'account_id' => 'Please select exactly one account (general, deposit, or loan account).',
                'member_depo_account_id' => 'Please select exactly one account (general, deposit, or loan account).',
                'member_loan_account_id' => 'Please select exactly one account (general, deposit, or loan account).',
            ])->withInput();
        }
        $voucherEntry->update($request->all());
        return redirect()->back()->with('success', 'Voucher Entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);

        $voucherEntry->delete();
        return redirect()->back()->with('success', 'Voucher Entry deleted successfully');
    }
}