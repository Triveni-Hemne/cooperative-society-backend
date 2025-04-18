<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankInvestment;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\GeneralLedger;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BankInvestmentController extends Controller
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

        $bankInvestments = BankInvestment::with('depositAccount.member.user')
        ->when($branchId, function ($query) use ($branchId) {
            $query->whereHas('depositAccount.member.user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        })
        ->paginate(5);
        // $bankInvestments = BankInvestment::paginate(5);
        $accounts = Account::all();
        $depoAccounts = MemberDepoAccount::all();
        $ledgers = GeneralLedger::all();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('accounts.bank-investment.list', compact('bankInvestments','accounts','depoAccounts','ledgers','branches'));

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
        $validatedData = $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'name' => 'required|string|max:255',
            'investment_type' => 'required|in:FD,RD,Other',
            'interest_rate' => 'required|numeric|min:0',
            'opening_date' => 'required|date',
            'opening_balance' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
            
            //RD details
            'rd_maturity_date' => 'required_if:investment_type,RD|nullable|date',
            'rd_deposit_term_days' => 'nullable|integer',
            'rd_months' => 'nullable|integer',
            'rd_years' => 'nullable|integer',
            'rd_monthly_deposit' => 'nullable|numeric|min:0',
            'rd_term_months' => 'nullable|integer',
            'rd_maturity_amount' => 'required_if:investment_type,RD|nullable|numeric|min:0',
            'rd_interest_receivable' => 'required_if:investment_type,RD|nullable|numeric|min:0',
            'rd_interest_frequency' => 'nullable|string|max:255',
            
            // FD details
            'fd_maturity_date' => 'required_if:investment_type,FD|nullable|date',
            'fd_deposit_term_days' => 'nullable|integer',
            'fd_months' => 'nullable|integer',
            'fd_years' => 'nullable|integer',
            'fd_amount' => 'nullable|numeric|min:0',
            'fd_monthly_deposit' => 'nullable|numeric|min:0',
            'fd_maturity_amount' => 'required_if:investment_type,FD|nullable|numeric|min:0',
            'fd_interest_receivable' => 'required_if:investment_type,FD|nullable|numeric|min:0',
            'fd_interest_frequency' => 'nullable|string|max:255',            
            'interest' => 'required_if:investment_type,FD|nullable|numeric|min:0',

            // Ensure at least one of 'account_id' or 'depo_account_id' is provided
            'account_id' => 'nullable|exists:accounts,id|required_without:depo_account_id',
            'depo_account_id' => 'nullable|exists:member_depo_accounts,id|required_without:account_id',
            
        ]);

        
        // return $request->all();
        
        $investmentType = strtolower($validatedData['investment_type']); // Convert FD/RD to fd/rd

        $investmentData = [
            'ledger_id' => $validatedData['ledger_id'],
            'account_id' => $validatedData['account_id'] ?? null,
            'depo_account_id' => $validatedData['depo_account_id'],
            'name' => $validatedData['name'],
            'investment_type' => $validatedData['investment_type'],
            'interest_rate' => $validatedData['interest_rate'],
            'opening_date' => $validatedData['opening_date'],
            'opening_balance' => $validatedData['opening_balance'],
            'current_balance' => $validatedData['current_balance'],
            'maturity_date' => $validatedData["{$investmentType}_maturity_date"],
            'deposit_term_days' => $validatedData["{$investmentType}_deposit_term_days"] ?? null,
            'months' => $validatedData["{$investmentType}_months"] ?? null,
            'years' => $validatedData["{$investmentType}_years"] ?? null,
            'monthly_deposit' => $validatedData["{$investmentType}_monthly_deposit"] ?? null,
            'maturity_amount' => $validatedData["{$investmentType}_maturity_amount"],
            'interest_receivable' => $validatedData["{$investmentType}_interest_receivable"],
            'interest_frequency' => $validatedData["{$investmentType}_interest_frequency"] ?? null,
        ];

        // FD-specific field
        if ($validatedData['investment_type'] === 'FD') {
            $investmentData['fd_amount'] = $validatedData['fd_amount'] ?? null;
            $investmentData['interest'] = $validatedData["interest"];
        }

        // RD-specific field
        if ($validatedData['investment_type'] === 'RD') {
            $investmentData['rd_term_months'] = $validatedData['rd_term_months'] ?? null;
        }
        
        BankInvestment::create($investmentData);
     
        return redirect()->back()->with('success', 'Deposite Account added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
        return response()->json($bankInvestment);
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
        $investment = BankInvestment::findOrFail($id);
    
        $validatedData = $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'account_id' => 'nullable|exists:accounts,id|required_without:depo_account_id',
            'depo_account_id' => 'nullable|exists:member_depo_accounts,id|required_without:account_id',
            'name' => 'required|string|max:255',
            'investment_type' => 'required|in:FD,RD,Other',
            'interest_rate' => 'required|numeric|min:0',
            'opening_date' => 'required|date',
            'opening_balance' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',

            // RD details
            'rd_maturity_date' => 'required_if:investment_type,RD|nullable|date',
            'rd_deposit_term_days' => 'nullable|integer',
            'rd_months' => 'nullable|integer',
            'rd_years' => 'nullable|integer',
            'rd_monthly_deposit' => 'nullable|numeric|min:0',
            'rd_term_months' => 'nullable|integer',
            'rd_maturity_amount' => 'required_if:investment_type,RD|nullable|numeric|min:0',
            'rd_interest_receivable' => 'required_if:investment_type,RD|nullable|numeric|min:0',
            'rd_interest_frequency' => 'nullable|string|max:255',

            // FD details
            'fd_maturity_date' => 'required_if:investment_type,FD|nullable|date',
            'fd_deposit_term_days' => 'nullable|integer',
            'fd_months' => 'nullable|integer',
            'fd_years' => 'nullable|integer',
            'fd_amount' => 'nullable|numeric|min:0',
            'fd_monthly_deposit' => 'nullable|numeric|min:0',
            'fd_maturity_amount' => 'required_if:investment_type,FD|nullable|numeric|min:0',
            'fd_interest_receivable' => 'required_if:investment_type,FD|nullable|numeric|min:0',
            'fd_interest_frequency' => 'nullable|string|max:255',
            'interest' => 'required_if:investment_type,FD|nullable|numeric|min:0',
        ]);
        
        $investmentType = strtolower($validatedData['investment_type']);
        
        $investmentData = [
            'ledger_id' => $validatedData['ledger_id'],
            'account_id' => $validatedData['account_id'] ?? null,
            'depo_account_id' => $validatedData['depo_account_id'],
            'name' => $validatedData['name'],
            'investment_type' => $validatedData['investment_type'],
            'interest_rate' => $validatedData['interest_rate'],
            'opening_date' => $validatedData['opening_date'],
            'opening_balance' => $validatedData['opening_balance'],
            'current_balance' => $validatedData['current_balance'],
            'maturity_date' => $validatedData["{$investmentType}_maturity_date"],
            'deposit_term_days' => $validatedData["{$investmentType}_deposit_term_days"] ?? null,
            'months' => $validatedData["{$investmentType}_months"] ?? null,
            'years' => $validatedData["{$investmentType}_years"] ?? null,
            'monthly_deposit' => $validatedData["{$investmentType}_monthly_deposit"] ?? null,
            'maturity_amount' => $validatedData["{$investmentType}_maturity_amount"],
            'interest_receivable' => $validatedData["{$investmentType}_interest_receivable"],
            'interest_frequency' => $validatedData["{$investmentType}_interest_frequency"] ?? null,
        ];

        if ($validatedData['investment_type'] === 'FD') {
            $investmentData['fd_amount'] = $validatedData['fd_amount'] ?? null;
            $investmentData['interest'] = $validatedData['interest'];
        }

        if ($validatedData['investment_type'] === 'RD') {
            $investmentData['rd_term_months'] = $validatedData['rd_term_months'] ?? null;
        }

        $investment->update($investmentData);

        return redirect()->back()->with('success', 'Investment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
       $bankInvestment->delete();
       return redirect()->back()->with('success', 'Bank investment deleted successfully');
    }
}