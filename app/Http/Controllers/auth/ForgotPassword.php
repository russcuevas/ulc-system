<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPassword extends Controller
{
    // Step 1: show forgot password form
    public function ForgotPasswordPage()
    {
        return view('auth.forgot-password');
    }

    // Send code to email
    public function ForgotPasswordSendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $code = rand(100000, 999999);

        DB::table('admins')
            ->where('email', $request->email)
            ->update([
                'reset_code' => $code,
                'reset_expires_at' => Carbon::now()->addMinutes(10),
            ]);

        $resetLink = route('admin.reset-password', ['email' => $request->email]);

        Mail::send(
            'emails.forgot_password',
            [
                'code' => $code,
                'resetLink' => $resetLink,
            ],
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('ULC Password Reset');
            }
        );

        return back()->with('success', 'Reset code sent to your email.');
    }

public function ResetPasswordPage(Request $request)
{
    $email = $request->query('email');
    $step = $request->query('step', 1);

    if (!$email || !DB::table('admins')->where('email', $email)->exists()) {
        return redirect()->route('admin.forgot-password')->withErrors('Invalid email.');
    }

    return view('auth.reset-password', [
        'email' => $email,
        'step' => $step
    ]);
}

    // Verify access code
   public function VerifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:admins,email',
        'code' => 'required',
    ]);

    $admin = DB::table('admins')
        ->where('email', $request->email)
        ->where('reset_code', $request->code)
        ->where('reset_expires_at', '>=', now())
        ->first();

    if (!$admin) {
        return back()->withErrors(['code' => 'Invalid or expired reset code.'])->withInput();
    }

    // Redirect to step 2 using GET
    return redirect()->route('admin.reset-password', [
        'email' => $request->email,
        'step' => 2
    ]);
}

    // Reset password
    public function ResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        DB::table('admins')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'reset_code' => null,
                'reset_expires_at' => null,
            ]);

        return redirect('/login')->with('success', 'Password reset successfully. You may now login.');
    }
}
