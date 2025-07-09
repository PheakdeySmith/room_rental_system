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

    // Optional: Role check for security
    if (!$landlord->hasRole('landlord')) {
        abort(403, 'Unauthorized');
    }

    // 1. FETCH CONTRACTS FOR THE DROPDOWN
    // Eager load all necessary relationships: tenant, room, and the room's amenities.
    // This is scoped to the logged-in landlord for security.
    $contracts = Contract::with(['tenant', 'room.amenities'])
        ->where('status', 'active')
        ->whereHas('room.property', function ($query) use ($landlord) {
            $query->where('landlord_id', $landlord->id);
        })
        ->get();

    // 2. FETCH UTILITY DATA
    // Get all utility types (Electricity, Water, etc.) to list them.
    $utilityTypes = UtilityType::all();
    // Get only the utility rates that this landlord has set for their properties.
    $utilityRates = UtilityRate::whereHas('property', function ($query) use ($landlord) {
            $query->where('landlord_id', $landlord->id);
        })
        ->get();

    // 3. GENERATE THE NEXT INVOICE NUMBER (Scoped to the landlord)
    $lastInvoice = Invoice::whereHas('contract.room.property', function ($query) use ($landlord) {
        $query->where('landlord_id', $landlord->id);
    })->latest('id')->first();

    $nextInvoiceId = $lastInvoice ? $lastInvoice->id + 1 : 1;
    $invoiceNumber = 'INV-' . str_pad($nextInvoiceId, 6, '0', STR_PAD_LEFT);

    // 4. PREPARE DEFAULT DATES
    $issueDate = now()->format('Y-m-d');
    $dueDate = now()->addDays(15)->format('Y-m-d'); // Example: Due in 15 days

    // 5. PASS ALL THE PREPARED DATA TO THE VIEW
    return view('backends.dashboard.payments.create', compact(
        'contracts',
        'invoiceNumber',
        'issueDate',
        'dueDate',
        'utilityTypes',
        'utilityRates'
    ));
}
}
