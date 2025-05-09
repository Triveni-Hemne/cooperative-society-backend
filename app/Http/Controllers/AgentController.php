<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Validation\Rule;


class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $agents = Agent::with('user')->latest()->paginate(5);
        $users = User::all();
        $branches = Branch::all();
        // return response()->json($centers);
        return view('master.agent.list', compact('agents', 'users', 'branches'));
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
            'user_id' => 'nullable|exists:users,id|unique:agents,user_id',
            'agent_code' => 'required|unique:agents,agent_code|max:50',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'status' => 'required|in:Active,Inactive',
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
            'user_id' => ['nullable', 'exists:users,id', Rule::unique('agents')->ignore($agent->id)],
            'agent_code' => ['required', 'string', 'max:50', Rule::unique('agents')->ignore($agent->id)],
            'commission_rate' => 'required|numeric|min:0|max:100',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'branch_id' => auth()->user()->role === 'Admin'
                ? ['required', Rule::exists('branches', 'id')]
                : ['nullable', Rule::exists('branches', 'id')],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
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