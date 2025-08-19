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
use App\Models\Member;
use App\Models\Branch;
use Illuminate\Validation\Rule;
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
            })->latest()->paginate(5);

        // $voucherEntries = VoucherEntry::paginate(5);
        $ledgers = GeneralLedger::all();
        $members = Member::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $accounts = Account::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $depoAccounts = MemberDepoAccount::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $loanAccounts = MemberLoanAccount::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        $users = User::all();
        $branches = Branch::all();
        return view('transactions.voucher-entry.list', compact('voucherEntries', 'ledgers','accounts','depoAccounts','loanAccounts','users','branches','user','members'));
    }

public function getLastTransactionNo(Request $request)
{
    $type = $request->query('type');

    if ($type === 'Receipt') {
        $last = VoucherEntry::where('transaction_type', 'Receipt')->max('receipt_id');
        $prefix = "RCPT";
    } elseif ($type === 'Payment') {
        $last = VoucherEntry::where('transaction_type', 'Payment')->max('payment_id');
        $prefix = "PMT";
    } else {
        return response()->json(['error' => 'Invalid transaction type'], 400);
    }

    // If no record exists yet, start with 1
    if (!$last) {
        $nextNo = $prefix . "001";
    } else {
        // Extract number part (remove prefix, handle cases like R20240510 too)
        preg_match('/(\d+)$/', $last, $matches);
        $number = isset($matches[1]) ? (int)$matches[1] : 0;
        $nextNo = $prefix . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
    }

    return response()->json(['next_no' => $nextNo]);
}


public function getAccountBalances(Request $request)
{
     $ledgerId  = $request->ledger_id;
        $accountId = $request->account_id;
        $date      = $request->date ?? now()->toDateString();
        $accountType = $request->account_type;

        // 1️⃣ Opening Balance = last balance *before* the given date
        $query = VoucherEntry::where('ledger_id', $ledgerId);

        if ($accountType === 'general') {
            $query->where('account_id', $accountId);
        } elseif ($accountType === 'deposit') {
            $query->where('member_depo_account_id', $accountId);
        } elseif ($accountType === 'loan') {
            $query->where('member_loan_account_id', $accountId);
        }

        $lastBefore = (clone $query)
            ->where('date', '<', $date)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $openingBalance = $lastBefore?->current_balance ?? 0;

        $transactions = (clone $query)
            ->where('date', '>=', $date)
            ->get();

        $currentBalance = $openingBalance;
        foreach ($transactions as $t) {
            $currentBalance += ($t->debit_amount - $t->credit_amount);
        }

        return response()->json([
            'opening_balance' => $openingBalance,
            'current_balance' => $currentBalance,
        ]);
}


public function getAccountsByLedger($ledgerId)
    {
        $ledger = GeneralLedger::findOrFail($ledgerId);
        // Replace these with actual relationships or queries based on your structure
        $generalAccounts = Account::where('ledger_id', $ledgerId)->get(['id', 'name']);
        $depositAccounts = MemberDepoAccount::where('ledger_id', $ledgerId)->get(['id', 'name']);
        $loanAccounts = MemberLoanAccount::where('ledger_id', $ledgerId)->get(['id', 'name']);
        $members = Member::all(['id', 'name']);
        $ledgerName = $ledger->name;

        return response()->json([
            'group' => $ledger->group,
            'general_accounts' => $generalAccounts,
            'deposit_accounts' => $depositAccounts,
            'loan_accounts' => $loanAccounts,
            'ledger_name' => $ledgerName,
            'members' => $members,
        ]);
    }

    public function getAccountsDetails($id, $name)
    {
        if($name == "member_depo_account_id"){
            $account = MemberDepoAccount::findOrFail($id);
        }
        else if($name == "member_loan_account_id"){
            $account = MemberLoanAccount::findOrFail($id);
        }
        else if($name == "account_id"){
            $account = Account::findOrFail($id);
        }else if($name == "member_id"){
            $account = Member::findOrFail($id);
        }
        // return response()->json([
        //     'holder_name' => $account->name ?? 'N/A',
        //     // Add more fields as needed
        // ]);
        return response()->json($account);

        return response()->json([
            'request' => $request ?? 'N/A',
        ]);
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
            // 'voucher_num' => 'nullable|string|max:50|unique:voucher_entries,voucher_num',
            // 'token_number' => 'nullable|string|max:50|unique:voucher_entries,token_number',
            // 'serial_no' => 'nullable|string|max:50|unique:voucher_entries,serial_no',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:voucher_entries,receipt_id',
            'payment_id' => 'nullable|string|max:50|unique:voucher_entries,payment_id',
            'ledger_id' => 'required|exists:general_ledgers,id',

            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',

            // 'from_date' => 'nullable|date',
            // 'to_date' => 'nullable|date',
            'opening_balance' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'amount' => 'nullable|numeric',
            // // 'debit_amount' => 'nullable|numeric|min:0',
            // // 'credit_amount' => 'nullable|numeric|min:0',
            // // 'transaction_mode' => 'nullable|in:Cash,Bank,Online,Cheque',
            // // 'payment_mode' => 'nullable|in:NEFT,IMPS,UPI,RTGS,Cheque,Cash,Bank Transfer',
            // // 'reference_number' => 'nullable|string|max:100',
            // // 'is_reversed' => 'nullable|boolean',
            'approved_by' => 'nullable|exists:users,id',
            // // 'approved_at' => 'nullable|date',
            'entered_by' => 'nullable|exists:users,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],

            'member_id' => 'nullable|exists:members,id',
            'cheque_no' => 'nullable',
            'balance' => 'nullable|numeric',  
            'interest' => 'nullable|numeric',  
            'penal' => 'nullable|numeric',  
            'post_court' => 'nullable|numeric',  
            'insurance' => 'nullable|numeric',  
            'notice_fee' => 'nullable|numeric',  
            'other' => 'nullable|string',  
            'trans_chargs' => 'nullable|numeric',  
            'int_paid' => 'nullable|numeric',  
            'int_payable' => 'nullable|numeric',  
            'penal_interest' => 'nullable|numeric',  
            'total_amount' => 'nullable|numeric',  

        ]);
        
        // return $request->all();
             $selectedCount = 0;

        if (!empty($request->account_id)) $selectedCount++;
        if (!empty($request->member_depo_account_id)) $selectedCount++;
        if (!empty($request->member_loan_account_id)) $selectedCount++;
        if (!empty($request->member_id)) $selectedCount++;

        if ($selectedCount !== 1) {
            return back()->withErrors([
                'account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_depo_account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_loan_account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
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
            'opening_balance' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'debit_amount' => 'nullable|numeric|min:0',
            'credit_amount' => 'nullable|numeric|min:0',
            'transaction_mode' => 'nullable|in:Cash,Bank,Online,Cheque',
            'payment_mode' => 'nullable|in:NEFT,IMPS,UPI,RTGS,Cheque,Cash,Bank Transfer',
            'reference_number' => 'nullable|string|max:100',
            'is_reversed' => 'nullable|boolean',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'entered_by' => 'nullable|exists:users,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            
            'member_id' => 'nullable|exists:members,id',
            'cheque_no' => 'nullable',
            'balance' => 'nullable|numeric',  
            'interest' => 'nullable|numeric',  
            'penal' => 'nullable|numeric',  
            'post_court' => 'nullable|numeric',  
            'insurance' => 'nullable|numeric',  
            'notice_fee' => 'nullable|numeric',  
            'other' => 'nullable|numeric',  
            'trans_chargs' => 'nullable|numeric',  
            'int_paid' => 'nullable|numeric',  
            'int_payable' => 'nullable|numeric',  
            'penal_interest' => 'nullable|numeric',  
            'total_amount' => 'nullable|numeric',

        ]);
        $selectedCount = 0;

        if (!empty($request->account_id)) $selectedCount++;
        if (!empty($request->member_depo_account_id)) $selectedCount++;
        if (!empty($request->member_loan_account_id)) $selectedCount++;
        if (!empty($request->member_id)) $selectedCount++;

        if ($selectedCount !== 1) {
            return back()->withErrors([
                'account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_depo_account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_loan_account_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
                'member_id' => 'Please select exactly one account (member, general, deposit, or loan account).',
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