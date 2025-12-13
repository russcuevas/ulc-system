<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\ClientsAreaDaily;
use App\Models\ClientsLoans;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function DashboardPage(Request $request)
    {
        $currentYear = $request->year ?? Carbon::now()->year;
        $previousYear = $currentYear - 1;

        // Total Loans
        $totalLoans = ClientsLoans::sum('loan_amount');
        $totalLoansPrevYear = ClientsLoans::whereYear('created_at', $previousYear)->sum('loan_amount');
        $loansTrend = $totalLoans - $totalLoansPrevYear;

        // Total Clients
        $totalClients = Clients::count();
        $totalClientsPrevYear = Clients::whereYear('created_at', $previousYear)->count();
        $clientsTrend = $totalClients - $totalClientsPrevYear;

        // Daily Collections
        $today = Carbon::today();
        $dailyCollections = ClientsAreaDaily::whereDate('created_at', $today)->sum('collection');
        $currentTimestamp = Carbon::now()->format('F j, Y h:i:s A');

        // Monthly collections for current year
        $monthlyCollections = ClientsAreaDaily::selectRaw('MONTH(updated_at) as month, SUM(collection) as total')
            ->whereYear('updated_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

$collectionsData = [];
for ($i = 0; $i < 12; $i++) {
    // month keys in $monthlyCollections are 1–12, so we use $i + 1
    $collectionsData[$i] = $monthlyCollections[$i + 1] ?? 0;
}

$labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        // Total collections for the year
        $totalYearCollections = array_sum($collectionsData);

        return view('admin.dashboard.index', compact(
            'totalLoans',
            'loansTrend',
            'totalClients',
            'clientsTrend',
            'dailyCollections',
            'currentTimestamp',
            'currentYear',
            'previousYear',
            'labels',
            'collectionsData',
            'totalYearCollections' // pass to view
        ))->with('year', $currentYear);
    }


    public function getYearlyLoanData(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        $monthlyCollections = ClientsAreaDaily::selectRaw('MONTH(updated_at) as month, SUM(collection) as total')
            ->whereYear('updated_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

$collectionsData = [];
for ($i = 0; $i < 12; $i++) {
    $collectionsData[$i] = $monthlyCollections[$i + 1] ?? 0;
}

$labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        return response()->json([
            'labels' => $labels,
            'collections' => array_values($collectionsData),
            'total' => array_sum($collectionsData)
        ]);
    }
}
