<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{

    public function LoginPage()
    {
        return view('auth.login');
    }

    public function LoginRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if ($admin->status !== 'verified'){
                $verificationUrl = URL::signedRoute('admin.verification.resend', ['admin' => $admin->id]);

                return back()->withErrors([
                'email' => 'Your account is not verified yet. <a href="' . $verificationUrl . '">resend code again</a>'
                ]);
            }
            
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . Auth::guard('admin')->user()->fullname . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function Logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()
        ->route('admin.login')
        ->with('success', 'Logged out successfully.');
    }

    public function ForgotPasswordPage()
    {
        return view('auth.forgot-password');
    }
}
