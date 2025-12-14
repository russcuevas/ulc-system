<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Mail\AdminVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;



class AdminManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = DB::table('admins')->orderBy('created_at', 'desc')->get();
        return view('admin.admins.index', compact('admins'));
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
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'phone'    => 'required|digits:11',
            'gender'   => 'required|in:Male,Female',
            'password' => 'required|min:6|confirmed',
        ]);

        $token = Str::random(64);


        DB::table('admins')->insert([
            'fullname'   => $request->fullname,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'gender'     => $request->gender,
            'password'   => Hash::make($request->password),
            'status'     => 'not verified',
            'verification_token' => $token,
            'created_by' => auth()->guard('admin')->user()->fullname ?? 'System',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $verifyUrl = route('admin.verify', ['token' => $token]);
        Mail::to($request->email)->send(new AdminVerificationMail($verifyUrl, $request->fullname));
        return redirect()->back()->with('success', 'Admin successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($id)
            ],
            'phone' => 'required|digits:11',
            'gender' => 'required|in:Male,Female',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('admins')->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('admins')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Admin deleted successfully!');
    }



}
