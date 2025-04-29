<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanInstallment;
use App\Models\MemberLoanAccount;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

class LoanInstallmentController extends Controller
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

        $LoanInstallments = LoanInstallment::with('user')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('loan.member.branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->paginate(5);
        // $LoanInstallment = BankInvestment::paginate(5);
        $loanAccounts = MemberLoanAccount::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('member.user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('member.branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->get();
        // $ledgers = GeneralLedger::all();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.loan-installment.list', compact('LoanInstallments','loanAccounts','branches','user'));
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
            'loan_id' => 'required|exists:member_loan_accounts,id',
            'installment_type' => 'required|in:Monthly,Quarterly,Yearly',
            'mature_date' => 'nullable|date',
            'first_installment_date' => 'nullable|date',
            'total_installments' => 'required|integer|min:1',
            'installment_amount' => 'required|numeric|min:0',
            'installment_with_interest' => 'required|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $loanInstallment = LoanInstallment::create($request->all());
        return redirect()->back()->with('success','Loan Installment Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($loanInstallment, 200);
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
        $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'loan_id' => 'required|exists:member_loan_accounts,id',
            'installment_type' => 'in:Monthly,Quarterly,Yearly',
            'mature_date' => 'nullable|date',
            'first_installment_date' => 'nullable|date',
            'total_installments' => 'integer|min:1',
            'installment_amount' => 'numeric|min:0',
            'installment_with_interest' => 'numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $loanInstallment->update($request->all());
        return redirect()->back()->with('success','Loan Installment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);

        $loanInstallment->delete();
        return redirect()->back()->with('success','Loan Installment Deleted Successfully');
    }
}