<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountVerifications extends Controller
{
    public function AdminAccountVerification($token)
    {
        $admin = DB::table('admins')->where('verification_token', $token)->first();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Invalid verification link.');
        }

        DB::table('admins')->where('id', $admin->id)->update([
            'status' => 'verified',
            'verification_token' => null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.login')->with('success', 'Your account has been verified!');
    }

    public function AdminAccountVerificationResend($admin)
    {
        $adminData = DB::table('admins')->where('id', $admin)->first();

        if (!$adminData) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Admin not found.']);
        }

        $token = Str::random(64);
        DB::table('admins')->where('id', $admin)->update([
            'verification_token' => $token,
        ]);

        $url = route('admin.verify', ['token' => $token]);

        Mail::send('emails.admin_verify', [
            'fullname' => $adminData->fullname,
            'url' => $url
        ], function($message) use ($adminData) {
            $message->to($adminData->email);
            $message->subject('Verify your Admin Account');
        });

        return redirect()->route('admin.login')->with('success', 'Verification code sent to your email.');
    }
}
