<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class UserLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                return view('login');
                // return "Login Here";
    }

    /**
     * to authenticate the Admin.
     */
    public function authenticate(Request $request)
    {   
        // Validate the input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // If validation passes
    if ($validator->passes()) {

        // Attempt to authenticate the user
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            // Check if the user has an authorized role
            if (Auth::guard('admin')->user()->role === 'Admin' || Auth::guard('admin')->user()->role === 'Agent') {
                // Redirect to dashboard if the user has the right role
                // dd('User role check passed! Redirecting...');
                return redirect()->intended(route('user.dashboard'));
                return redirect()->route('user.dashboard');
            } else {
                // Log the user out if they don't have the right role
                Auth::guard('admin')->logout();
                return redirect()->route('user.login')
                    ->with('error', 'You are not authorized to access this page.');
            }

        } else {
            // Authentication failed
            return redirect()->route('user.login')
                ->with('error', 'Either email or password is incorrect.');
        }
        
    } else {
        // Validation failed
        return redirect()->route('user.login')
            ->withInput() // Keep the previous input
            ->withErrors($validator); // Show validation errors
    }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('user.login');
    }
}