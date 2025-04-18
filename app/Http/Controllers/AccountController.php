<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\GeneralLedger;
use App\Models\Member;
use App\Models\Agent;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
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

        $accounts = Account::with('member.user')
        ->when($branchId, function ($query) use ($branchId) {
            $query->whereHas('member.user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        })
        ->paginate(5);
        
        // $accounts = Account::paginate(5);
        $ledgers = GeneralLedger::all();
        $members = Member::all();
        $agents = Agent::all();
        $branches = $user->role === 'Admin' ? Branch::all() : null;

        return view('accounts.general-acc.list', compact('accounts','ledgers','members','agents','branches'));
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
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            'account_no' => 'required|string|max:50|unique:accounts,account_no',
            'account_name' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'required|integer|min:0',
            'closing_date' => 'nullable|date'
        ]);

        // return $request->all();
        $account = Account::create($request->all());
        return redirect()->back()->with('success','Account Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = Account::findOrFail($id);
        return response()->json($account);
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
        $account = Account::findOrFail($id);
        $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            'account_no' => "required|string|max:50|unique:accounts,account_no,{$id}",
            'account_name' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'required|integer|min:0',
            'closing_date' => 'nullable|date'
        ]);

        // return $request->all();
        $account->update($request->all());
        return redirect()->back()->with('success','Account Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return redirect()->back()->with('success','Account deleted successfully');
    }
}