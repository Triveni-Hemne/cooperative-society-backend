<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Validation\Rule;


class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $agents = Agent::with('user')->paginate(5);
        $users = User::all();
        // return response()->json($centers);
        return view('master.agent.list', compact('agents', 'users'));
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
            'commition_rate' => 'required|numeric|between:0,999.99',
            // 'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
        
        $agent = Agent::create($validated);
        return redirect()->back()->with('success', 'Agent added successfully');
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
            'commition_rate' => 'required|numeric|between:0,999.99',
            // 'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $agent->update($validated);
        return redirect()->back()->with('success', 'Agent updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();
        redirect()->back()->with('success', 'Agent deleted successfully');
    }
}