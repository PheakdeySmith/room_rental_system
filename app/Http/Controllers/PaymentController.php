<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    function index()
    {

        return view('backends.payments.index');
    }

    public function create()
    {
        $landlord = Auth::user();

        if (!$landlord->hasRole('landlord')) {
            abort(403, 'Unauthorized');
        }

        $contracts = Contract::with(['tenant', 'room.amenities'])
            ->where('status', 'active')
            ->whereHas('room.property', function ($query) use ($landlord) {
                $query->where('landlord_id', $landlord->id);
            })
            ->get();

        $lastInvoice = Invoice::whereHas('contract.room.property', function ($query) use ($landlord) {
            $query->where('landlord_id', $landlord->id);
        })->latest('id')->first();

        $nextInvoiceId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $invoiceNumber = 'INV-' . str_pad($nextInvoiceId, 6, '0', STR_PAD_LEFT);

        $issueDate = now()->format('Y-m-d');
        $dueDate = now()->addDays(15)->format('Y-m-d');

        return view('backends.dashboard.payments.create', compact(
            'contracts',
            'invoiceNumber',
            'issueDate',
            'dueDate',
        ));
    }

    // In app/Http/Controllers/Backend/Dashboard/PaymentController.php

public function getContractDetails(Contract $contract)
{
    // Eager load everything we need in one go to be efficient
    $contract->load('room.amenities', 'room.meters.meterReadings', 'room.property.utilityRates.utilityType');

    $utilityData = [];

    // Get the rates for the specific property of the contract
    $propertyRates = $contract->room->property->utilityRates;

    foreach ($propertyRates as $rate) {
        $consumption = 0;
        // Find the specific meter in the room that matches the utility type (e.g., Electricity)
        $meter = $contract->room->meters->firstWhere('utility_type_id', $rate->utility_type_id);

        if ($meter) {
            // Get the two most recent readings for that meter
            $readings = $meter->meterReadings()->latest('reading_date')->take(2)->get();

            if ($readings->count() >= 2) {
                // Standard case: consumption is the difference between the last two readings
                $consumption = $readings[0]->reading_value - $readings[1]->reading_value;
            } elseif ($readings->count() === 1) {
                // First-ever reading: consumption is the difference between the reading and the meter's initial value
                $consumption = $readings[0]->reading_value - $meter->initial_reading;
            }
            // If there are no readings, consumption remains 0
        }

        // Add the utility name, its rate, and the calculated consumption to our data array
        $utilityData[] = [
            'utility_type' => $rate->utilityType,
            'rate' => $rate->rate,
            'consumption' => max(0, $consumption), // Ensure consumption isn't negative
        ];
    }

    // Return all the data the frontend needs
    return response()->json([
        'room_number' => $contract->room->room_number,
        'base_price' => $contract->rent_amount,
        'amenities' => $contract->room->amenities,
        'utility_data' => $utilityData, // Use this new key for our combined data
    ]);
}
}
