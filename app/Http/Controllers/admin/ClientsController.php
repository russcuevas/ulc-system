<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Areas;
use App\Models\Clients;
use App\Models\ClientsLoans;
use App\Models\Activity;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = DB::table('areas')->get();

        $clients = DB::table('clients')
            ->leftJoin('areas', 'clients.area_id', '=', 'areas.id')
            ->leftJoin('clients_loans', 'clients.id', '=', 'clients_loans.client_id')
            ->select(
                'clients.*',
                'areas.area_name',
                'clients_loans.loan_from',
                'clients_loans.loan_to',
                'clients_loans.loan_amount',
                'clients_loans.loan_terms',
                'clients_loans.status'
            )
            ->get();

        return view('admin.clients.index', compact('areas', 'clients'));
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
        // VALIDATION
        $validated = $request->validate([
            'fullname'      => 'required|string|max:255',
            'phone'         => 'required|digits:11',
            'address'       => 'required|string|max:255',
            'area_id'       => 'required|exists:areas,id',
            'gender'        => 'required|string',

            'loan_from'     => 'required|date',
            'loan_to'       => 'required|date|after_or_equal:loan_from',
            'loan_amount'   => 'required|numeric|min:1',
            'loan_terms'    => 'required|numeric',
        ]);

        // SAVE CLIENT
        $client = Clients::create([
            'fullname'   => $request->fullname,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'area_id'    => $request->area_id,
            'gender'     => $request->gender,
            'created_by' => auth()->guard('admin')->user()->fullname ?? 'System',
        ]);

        // GENERATE PN NUMBER
        $area = Areas::find($request->area_id);

        // Example: A12025-12-03-01
        $area_code = strtoupper(substr($area->area_name, 0, 1)) . $area->id; // A1

        $today = now()->format('m-d');  // 12-03
        $year  = now()->format('Y');    // 2025

        $pn_number = $area_code . $year . "-" . $today . "-" . sprintf("%02d", $client->id);

        // SAVE LOAN
        ClientsLoans::create([
            'client_id'   => $client->id,
            'pn_number'   => $pn_number,
            'loan_from'   => $request->loan_from,
            'loan_to'     => $request->loan_to,
            'loan_amount' => $request->loan_amount,
            'balance'     => $request->loan_amount,
            'principal'   => $request->loan_amount,
            'loan_terms'  => $request->loan_terms,
            'status'      => 'unpaid',
            'created_by' => auth()->guard('admin')->user()->fullname ?? 'System',
        ]);

        DB::table('activities')->insert([
            'description' => "New added client {$client->fullname}.",
            'admin_id'    => auth()->guard('admin')->id(),
            'color'       => 'bg-success',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);


        return redirect()->back()->with('success', 'Client successfully created!');
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|digits:11',
            'address' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'gender' => 'required|string',
        ]);

        $client = Clients::findOrFail($id);

        $client->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
            'area_id' => $request->area_id,
            'gender' => $request->gender,
        ]);

        return redirect()->back()->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Clients::findOrFail($id);
        ClientsLoans::where('client_id', $client->id)->delete();
        $client->delete();
        return redirect()->back()->with('success', 'Client successfully deleted!');
    }
}
