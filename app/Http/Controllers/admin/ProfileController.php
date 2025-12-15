<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function ProfilePage()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

public function ProfileUpdateRequest(Request $request)
{
    $admin = Auth::guard('admin')->user();

    $request->validate([
        'fullname' => 'required|string|max:255',
        'email'    => 'required|email|unique:admins,email,' . $admin->id,
        'phone'    => 'required|string|max:20',
        'gender'   => 'required|in:Male,Female',
        'password' => 'nullable|min:8|confirmed',
    ]);

    $admin->fullname = $request->fullname;
    $admin->email    = $request->email;
    $admin->phone    = $request->phone;
    $admin->gender   = $request->gender;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return back()->with('success', 'Profile updated successfully.');
}

}
