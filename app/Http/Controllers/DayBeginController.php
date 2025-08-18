<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayBegin;
use App\Models\Member;
use App\Models\User;
use App\Models\DayEnd;
use Illuminate\Validation\Rule;
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

        // Determine branch filter based on role
        $branchId = $user->role === 'Admin'
            ? $request->branch_id
            : $user->branch_id;

        $dayBegins = DayBegin::with('user')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })
            ->latest()
            ->paginate(5);

        // ✅ use helper method instead of JsonResponse
        $openingCashBalance = $this->fetchOpeningBalance($branchId);

        $branches = $user->role === 'Admin' ? Branch::all() : null;

        return view('transactions.day-begins.list', compact(
            'users', 'dayBegins', 'user', 'branches', 'openingCashBalance'
        ));
    }

    public function getOpeningBalance(Request $request)
    {   
        $branchId = $request->branch_id ??Auth::user()->branch_id;
        $userId   = $request->user_id ?? Auth::id();
        $openingBalance = $this->fetchOpeningBalance($branchId, $userId);
         
        return response()->json(['opening_cash_balance' => $openingBalance]);
    }

    // 🔹 Shared private helper
    private function fetchOpeningBalance($branchId = null, $userId = null)
    {  
        $query = DayEnd::query();
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $lastDayEnd = $query->latest('date')->first();

        return $lastDayEnd ? $lastDayEnd->closing_cash_balance : 0.00;
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
            'user_id' => 'nullable|exists:members,id',
            // 'status' => 'required|in:Open,Closed',
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
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'user_id' => 'nullable|exists:members,id',
            // 'status' => 'in:Open,Closed',
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