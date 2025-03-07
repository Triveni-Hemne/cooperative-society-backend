<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayBegin;

class DayBeginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(DayBegin::all(), 200);
        return view('transactions.day-begins.list');
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
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:Open,Closed'
        ]);

        $dayBegin = DayBegin::create($request->all());
        return response()->json($dayBegin, 201);
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
            'status' => 'in:Open,Closed'
        ]);

        $dayBegin->update($request->all());
        return response()->json($dayBegin, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dayBegin = DayBegin::find($id);
        if (!$dayBegin) return response()->json(['message' => 'Not Found'], 404);

        $dayBegin->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}