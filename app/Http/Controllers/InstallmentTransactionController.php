<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstallmentTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\MemberDepoAccount;

class InstallmentTransactionController extends Controller
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

        $transactions = InstallmentTransaction::with('user') // assuming 'user' is the relationship
            ->when($branchId, function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                });
            })
            ->paginate(5);
        $transactions = InstallmentTransaction::paginate(5);
        $memberDepoAccounts = MemberDepoAccount::all();
        $user = Auth::user();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.installment-transaction.list', compact('transactions', 'memberDepoAccounts','user','branches'));
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
            'deposit_account_id' => 'required|exists:member_depo_accounts,id',
            'installment_no' => 'required|integer|min:1',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'interest_earned' => 'nullable|numeric|min:0',
            'total_balance' => 'required|numeric|min:0',
            'created_by' => 'nullable|string|users,id',
        ]);

        $transaction = InstallmentTransaction::create($request->all());
        return redirect()->back()->with('success','Installment Transaction Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = InstallmentTransaction::findOrFail($id);
        return response()->json($transaction);
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
       $transaction = InstallmentTransaction::findOrFail($id);

        $request->validate([
            'deposit_account_id' => 'sometimes|exists:member_depo_accounts,id',
            'installment_no' => 'sometimes|integer|min:1',
            'amount_paid' => 'sometimes|numeric|min:0',
            'payment_date' => 'sometimes|date',
            'interest_earned' => 'nullable|numeric|min:0',
            'total_balance' => 'sometimes|numeric|min:0',
            'created_by' => 'nullable|string|exists:users:id',
        ]);

        $transaction->update($request->all());
        return redirect()->back()->with('success','Installment Transaction Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = InstallmentTransaction::findOrFail($id);
        $transaction->delete();
        return redirect()->back()->with('success','Installment Transaction deleted Successfully');
    }
}