<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::paginate(5);
         $branches = Branch::all();
         return view('master.user.list', compact('users','branches'));
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
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email|max:100',
            'password' => 'required|min:6',
            'role' => 'required|in:Director,Admin,Employee,Agent',
            // 'status' => 'required|in:Active,Inactive',
            'member_id' => 'nullable|exists:members,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'member_id' => $request->member_id,
        ]);
        return redirect()->back()->with('success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
       $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $request->validate([
            'name' => 'string|max:100',
            'email' => 'email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'in:Director,Admin,Employee,Agent',
            'member_id' => 'nullable|exists:members,id',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
            'member_id' => $request->member_id ?? $user->member_id,
        ]);

        return redirect()->back()->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success','User Deleted Successfully');
    }
}