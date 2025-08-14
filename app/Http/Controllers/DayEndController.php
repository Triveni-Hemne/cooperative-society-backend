<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayEnd;
use App\Models\Branch;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DayEndController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $users = User::all();
        $branchId = null;
        // Determine branch filter based on role
        if ($user->role === 'Admin') {
            $branchId = $request->branch_id; // admin can filter via dropdown
        } else {
            $branchId = $user->branch_id; // normal user only sees their branch
        }

        $dayEnds = DayEnd::with('user')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->latest()->paginate(5);
        // $dayEnds = DayEnd::paginate();
        $user = Auth::user();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.day-ends.list',compact('dayEnds','user','branches','users'));
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
            'date' => 'required|date',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            // 'user_id' => 'required|exists:users,id',
            'closing_cash_balance' => 'required|numeric',
            'total_receipts' => 'required|numeric',
            'total_payments' => 'required|numeric',
            // 'system_closing_balance' => 'nullable|numeric',
            // 'difference_amount' => 'nullable|numeric',
            'is_day_closed' => 'required|boolean',
            // 'opening_cash' => 'required|numeric',
            'total_credit_rs' => 'required|numeric',
            'total_credit_chalans' => 'nullable|integer',
            'total_debit_rs' => 'required|numeric',
            'total_debit_challans' => 'nullable|integer',
            'remarks' => 'nullable|string',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $dayEnd = DayEnd::create($request->all());
        return redirect()->back()->with('success','Day Ends created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);
        return response()->json($dayEnd, 200);
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
        $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);

        $request->validate([
            'date' => 'required|date',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            // 'user_id' => 'required|exists:users,id',
            'closing_cash_balance' => 'required|numeric',
            'total_receipts' => 'required|numeric',
            'total_payments' => 'required|numeric',
            // 'system_closing_balance' => 'nullable|numeric',
            // 'difference_amount' => 'nullable|numeric',
            'is_day_closed' => 'required|boolean',
            // 'opening_cash' => 'required|numeric',
            'total_credit_rs' => 'required|numeric',
            'total_credit_chalans' => 'nullable|integer',
            'total_debit_rs' => 'required|numeric',
            'total_debit_challans' => 'nullable|integer',
            'remarks' => 'nullable|string',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $dayEnd->update($request->all());
        return redirect()->back()->with('success','Day Ends updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);

        $dayEnd->delete();
        return redirect()->back()->with('success','Day Ends created Successfully');
    }
}