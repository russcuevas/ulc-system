<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function Payments(string $id)
    {
        $area = DB::table('areas')->where('id', $id)->first();
        $payments = DB::table('clients_area_dailies')
            ->where('client_area', $id)
            ->select(
                'reference_number',
                'collected_by',
                'due_date',
                'created_by',
                DB::raw('COUNT(client_id) as total_clients')
            )
            ->groupBy('reference_number', 'collected_by', 'due_date', 'created_by')
            ->orderBy('due_date', 'desc')
            ->get();

        return view('admin.areas.payments', compact('area', 'payments'));
    }

    public function CreatePayments(Request $request, $id)
    {
        $due_date = $request->due_date;
        $collected_by = $request->collector;

        $exists = DB::table('clients_area_dailies')
            ->where('client_area', $id)
            ->where('due_date', $due_date)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Payments for this date already created.');
        }

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
                'collected_by'     => $collected_by,
                'due_date'         => $due_date,
                'client_id'        => $client->client_id,
                'client_loans_id'  => $client->client_loans_id,
                'client_area'      => $client->client_area,
                'collection'       => null,
                'type'             => null,
                'created_by' => auth()->guard('admin')->user()->fullname ?? 'System',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Payments entry successfully created');
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
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'type' => 'required|string',
        ]);

        $clientId = $request->client_id;
        $amount = $request->amount ?? null;
        $type = $request->type;
        $userName = auth()->guard('admin')->user()->fullname ?? 'System';

        $dailyPayment = DB::table('clients_area_dailies')
            ->where('reference_number', $reference_number)
            ->where('client_id', $clientId)
            ->first();

        if (!$dailyPayment) {
            return redirect()->back()->with('error', 'Payment record not found for this client.');
        }

        $clientLoan = DB::table('clients_loans')
            ->where('id', $dailyPayment->client_loans_id)
            ->first();

        $client = DB::table('clients')->where('id', $clientId)->first();
        // $phone_number = $client->phone ?? null; // SMS temporarily disabled

        if ($type === 'REMINDER') {

            // $message = "Hello {$client->fullname}! Paalala lang po, wala pa kaming natatanggap na payment ngayong araw. Salamat po!";

            // SMS sending temporarily disabled
            /*
            if ($phone_number) {
                $phone_number = preg_replace('/[^0-9]/', '', $phone_number);
                if (preg_match('/^09\d{9}$/', $phone_number)) {
                    $phone_number = '63' . substr($phone_number, 1);
                }
                $ch = curl_init();
                $parameters = [
                    'apikey' => 'b2a42d09e5cd42585fcc90bf1eeff24e',
                    'number' => $phone_number,
                    'message' => $message,
                    'sendername' => 'BPTOCEANUS'
                ];
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch);
                curl_close($ch);
            }
            */

            return redirect()->back()->with('success', 'Reminder processed successfully!');
        }

        if ($type === 'NO PAYMENT') {

            DB::table('clients_area_dailies')
                ->where('id', $dailyPayment->id)
                ->update([
                    'collection' => 0,
                    'type' => 'NO PAYMENT',
                    'created_by' => $userName,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'Marked as NO PAYMENT!');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|string|in:GCASH,CHEQUE,CASH',
        ]);

        // $message = "Hello {$client->fullname}! Your payment of ₱" . number_format($amount, 2) .
        //     " via {$type} has been received. Remaining balance: ₱" .
        //     number_format($clientLoan->balance - $amount, 2) . ".";

        DB::table('clients_area_dailies')
            ->where('id', $dailyPayment->id)
            ->update([
                'collection' => $amount,
                'type' => $type,
                'created_by' => $userName,
                'updated_at' => now(),
            ]);

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

        // SMS sending temporarily disabled
        /*
        if ($phone_number) {
            $phone_number = preg_replace('/[^0-9]/', '', $phone_number);
            if (preg_match('/^09\d{9}$/', $phone_number)) {
                $phone_number = '63' . substr($phone_number, 1);
            }
            $ch = curl_init();
            $parameters = [
                'apikey' => 'b2a42d09e5cd42585fcc90bf1eeff24e',
                'number' => $phone_number,
                'message' => $message,
                'sendername' => 'BPTOCEANUS'
            ];
            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
        */

        return redirect()->back()->with('success', 'Payment collected successfully!');
    }
}
