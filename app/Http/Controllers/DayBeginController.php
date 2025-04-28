<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayBegin;
use App\Models\Member;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class DayBeginController extends Controller
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

        $dayBegins = DayBegin::with('user')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->paginate(5);
        $user = Auth::user();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.day-begins.list', compact('users','dayBegins','user','branches'));
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
            'branch_id' => 'required|exists:branches,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:Open,Closed',
            'opening_cash_balance' => 'required|numeric',
            'remarks' => 'nullable|string',
            'created_by' => 'required|exists:users,id',
        ]);
        
        $dayBegin = DayBegin::create($request->all());
        return redirect()->back()->with('success', 'Day Bigin Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dayBegin = DayBegin::find($id);
        if (!$dayBegin) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($dayBegin, 200);
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
        $dayBegin = DayBegin::find($id);
        if (!$dayBegin) return response()->json(['message' => 'Not Found'], 404);
        
        $request->validate([
            'date' => 'date',
            'branch_id' => 'required|exists:branches,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'in:Open,Closed',
            'opening_cash_balance' => 'required|numeric',
            'created_by' => 'nullable|exists:users,id',
            'remarks' => 'nullable|string',
        ]);
        
        $dayBegin->update($request->all());
        return redirect()->back()->with('success', 'Day Bigin updated successfully');
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dayBegin = DayBegin::find($id);
        if (!$dayBegin) return response()->json(['message' => 'Not Found'], 404);

        $dayBegin->delete();
         return redirect()->back()->with('success', 'Day Bigin deleted successfully');
    }
}