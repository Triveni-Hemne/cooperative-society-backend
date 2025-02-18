<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\Rule;


class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $agents = Agent::with('user')->get();
        return response()->json($agents);
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
       $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:agents,user_id',
            'agent_code' => 'required|string|max:50|unique:agents,agent_code',
            'commition_rate' => 'required|numeric|min:0|max:100',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $agent = Agent::create($validated);
        return response()->json(['message' => 'Agent added successfully', 'agent' => $agent], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agent = Agent::with('user')->findOrFail($id);
        return response()->json($agent);
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
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::unique('agents')->ignore($agent->id)],
            'agent_code' => ['required', 'string', 'max:50', Rule::unique('agents')->ignore($agent->id)],
            'commition_rate' => 'required|numeric|min:0|max:100',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $agent->update($validated);
        return response()->json(['message' => 'Agent updated successfully', 'agent' => $agent]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();
        return response()->json(['message' => 'Agent deleted successfully']);
    }
}