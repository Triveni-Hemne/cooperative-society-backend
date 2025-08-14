<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferEntry;
use App\Models\GeneralLedger;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use App\Models\User;
use App\Models\Member;
use App\Models\Branch;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TransferEntryController extends Controller
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
        $transferEntries = TransferEntry::with('user')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->latest()->paginate(5);
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
        $user = Auth::user();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.transfer-entry.list', compact('transferEntries','ledgers','accounts','depoAccounts','loanAccounts','user','branches','members'));
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
            'transaction_type' => 'required|in:Credit,Debit,Journal,Receipt,Payment',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50',
            'payment_id' => 'nullable|string|max:50',
            'ledger_id' => 'required|exists:general_ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',
            'branch_id' => 'nullable|exists:branches,id',
            'opening_balance' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'amount' => 'nullable|numeric',
            // 'approved_by' => 'nullable|exists:users,id',
            // 'created_by' => 'nullable|exists:users,id',
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
            'int_payable' => 'nullable|numeric',  
            'int_paid' => 'nullable|numeric',  
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

        $transferEntry = TransferEntry::create($request->all());
        return redirect()->back()->with('success', 'Transfer Entry Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);
        return response()->json($transferEntry, 200);
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
       $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);
        $request->validate([
            'transaction_type' => 'required|in:Credit,Debit,Journal,Receipt,Payment',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:transfer_entries,receipt_id,' . $transferEntry->id,
            'payment_id' => 'nullable|string|max:50|unique:transfer_entries,payment_id,' . $transferEntry->id,
            'ledger_id' => 'required|exists:general_ledgers,id',
            'branch_id' => 'nullable|exists:branches,id',
            'opening_balance' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            // 'created_by' => 'required|exists:users,id',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',
            'amount' => 'nullable|numeric|min:0',
            // 'approved_by' => 'nullable|exists:users,id',
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
            'int_payable' => 'nullable|numeric',  
            'int_paid' => 'nullable|numeric',  
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
        $transferEntry->update($request->all());
        return redirect()->back()->with('success', 'Transfer Entry Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);

        $transferEntry->delete();
        return redirect()->back()->with('success', 'Transfer Entry Deleted Successfully');
    }
}