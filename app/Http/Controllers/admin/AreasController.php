<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = DB::table('areas')->get();
        return view('admin.areas.index', compact('areas'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $area = DB::table('areas')->where('id', $id)->first();
        $clients = DB::table('clients')
            ->where('area_id', $id)
            ->leftJoin('areas', 'clients.area_id', '=', 'areas.id')
            ->select('clients.*', 'areas.area_name as area_name')
            ->get();
        return view('admin.areas.show', compact('area', 'clients'));
    }

    public function Payments(string $id)
    {
        $area = DB::table('areas')->where('id', $id)->first();

        // Get distinct daily payments for this area (group by reference_number)
        $payments = DB::table('clients_area_dailies')
            ->where('client_area', $id)
            ->select(
                'reference_number',
                'due_date',
                'created_by',
                DB::raw('COUNT(client_id) as total_clients')
            )
            ->groupBy('reference_number', 'due_date', 'created_by')
            ->orderBy('due_date', 'desc')
            ->get();

        return view('admin.areas.payments', compact('area', 'payments'));
    }

    public function CreatePayments(Request $request, $id)
    {
        $due_date = $request->due_date;
        $exists = DB::table('clients_area_dailies')
            ->where('client_area', $id)
            ->where('due_date', $due_date)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Payments for this date already created.');
        }

        // Get the highest reference number for this date from ALL AREAS
        $maxRef = DB::table('clients_area_dailies')
            ->where('due_date', $due_date)
            ->max('reference_number');

        if ($maxRef) {
            $lastNumber = (int)substr($maxRef, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $reference_number = $due_date . '-' . sprintf("%03d", $newNumber);

        $clients = DB::table('clients')
            ->leftJoin('clients_loans', 'clients.id', '=', 'clients_loans.client_id')
            ->where('clients.area_id', $id)
            ->whereDate('clients_loans.loan_from', '<=', $due_date)
            ->whereDate('clients_loans.loan_to', '>=', $due_date)
            ->select(
                'clients.id as client_id',
                'clients_loans.id as client_loans_id',
                'clients.area_id as client_area',
                'clients.fullname'
            )
            ->get();

        foreach ($clients as $client) {
            DB::table('clients_area_dailies')->insert([
                'reference_number' => $reference_number,
                'due_date'         => $due_date,
                'client_id'        => $client->client_id,
                'client_loans_id'  => $client->client_loans_id,
                'client_area'      => $client->client_area,
                'collection'       => null,
                'type'             => null,
                'created_by'       => auth()->user()->name ?? 'System',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Payments created based on selected date!');
    }


    public function ViewPayment($area_id, $reference_number)
    {
        $area = DB::table('areas')->where('id', $area_id)->first();
        $clients = DB::table('clients_area_dailies as cad')
            ->leftJoin('clients as c', 'cad.client_id', '=', 'c.id')
            ->leftJoin('clients_loans as cl', 'cad.client_loans_id', '=', 'cl.id')
            ->where('cad.client_area', $area_id)
            ->where('cad.reference_number', $reference_number)
            ->select(
                'cad.*',
                'c.fullname',
                'cl.loan_amount',
                'cl.balance'
            )
            ->get();

        return view('admin.areas.payments_view', compact('area', 'clients', 'reference_number'));
    }

    public function UpdatePayment(Request $request, $area_id, $reference_number)
    {
        // Validate required fields
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|string|in:GCASH,CHEQUE,CASH',
        ]);

        $clientId = $request->client_id;
        $amount = $request->amount;
        $type = $request->type;
        $userName = auth()->user()->name ?? 'System';

        // Get the daily payment record
        $dailyPayment = DB::table('clients_area_dailies')
            ->where('reference_number', $reference_number)
            ->where('client_id', $clientId)
            ->first();

        if (!$dailyPayment) {
            return redirect()->back()->with('error', 'Payment record not found for this client.');
        }

        // Update the daily payment collection and type
        DB::table('clients_area_dailies')
            ->where('id', $dailyPayment->id)
            ->update([
                'collection' => $amount,
                'type' => $type,
                'updated_at' => now(),
                'created_by' => $userName,
            ]);

        // Deduct the amount from the loan balance
        $clientLoan = DB::table('clients_loans')->where('id', $dailyPayment->client_loans_id)->first();
        if ($clientLoan) {
            $newBalance = max(0, $clientLoan->balance - $amount);

            DB::table('clients_loans')
                ->where('id', $clientLoan->id)
                ->update([
                    'balance' => $newBalance,
                    'status' => $newBalance == 0 ? 'PAID' : $clientLoan->status,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->back()->with('success', 'Payment collected successfully!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
