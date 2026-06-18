<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login page
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    { 
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            
            // session is automatically created by Laravel
            $request->session()->regenerate();
           
            // ✅ You can store extra session data if needed
            session([
                'user_name' => Auth::user()->name,
                'designation' => Auth::user()->designation->name,
                'user_email' => Auth::user()->email,
                'user_photo' => Auth::user()->photo,
                'department' => Auth::user()->department,
                ]);
                
                // return redirect()->route('dashboard');
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    // Dashboard
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}