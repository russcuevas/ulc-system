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

        $clientsLoans = DB::table('clients_loans')->get();
        $clientsDailies = DB::table('clients_area_dailies')
            ->whereIn('client_id', $clients->pluck('id'))
            ->get();

        return view('admin.areas.show', compact('area', 'clients', 'clientsLoans', 'clientsDailies'));
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
