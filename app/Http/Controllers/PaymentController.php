<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Contract;
use App\Models\LineItem;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\UtilityBill;
use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $landlord = Auth::user();
        $query = Invoice::whereHas('contract.room.property', fn($q) => $q->where('landlord_id', $landlord->id));

        // --- Search Filter (Existing) ---
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('invoice_number', 'like', "%{$searchTerm}%")
                    ->orWhereHas('contract.tenant', function ($tenantQuery) use ($searchTerm) {
                        $tenantQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // --- Date Range Filter (Add This) ---
        if ($request->filled('date_range') && strpos($request->date_range, ' to ') !== false) {
            [$startDate, $endDate] = explode(' to ', $request->date_range);
            $query->whereBetween('issue_date', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }

        // --- Property Filter (Add This) ---
        if ($request->filled('property_id')) {
            $query->whereHas('contract.room.property', function ($q) use ($request) {
                $q->where('id', $request->property_id);
            });
        }

        // --- Room Type Filter (Add This) ---
        if ($request->filled('room_type_id')) {
            $query->whereHas('contract.room', function ($q) use ($request) {
                $q->where('room_type_id', $request->room_type_id);
            });
        }

        // --- Status Filter (Add This) ---
        if ($request->filled('status') && $request->status !== 'any-status') {
            $query->where('status', $request->status);
        }

        $query->orderBy($request->input('sort_by', 'issue_date'), $request->input('sort_dir', 'desc'));

        $invoices = $query->with(['contract.tenant', 'contract.room'])
            ->paginate(15)
            ->appends($request->query());

        if ($request->wantsJson()) {
            return response()->json([
                'invoices' => $invoices,
                'pagination' => (string) $invoices->links('vendor.pagination.custom-pagination')
            ]);
        }

        $properties = Property::where('landlord_id', $landlord->id)->orderBy('name')->get();
        $roomTypes = RoomType::where('landlord_id', $landlord->id)->orderBy('name')->get();
        $stats = $this->getDashboardStats($landlord);

        return view('backends.dashboard.payments.index', compact('invoices', 'stats', 'properties', 'roomTypes'));
    }

    /**
     * Calculate and return the dashboard statistics for the given landlord.
     *
     * @param \App\Models\User $landlord
     * @return array
     */
    private function getDashboardStats(\App\Models\User $landlord): array
    {
        $now = Carbon::now();
        $thisMonthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();

        // Fetch all relevant data from the last ~2 months in a single query
        $recentInvoices = Invoice::whereHas('contract.room.property', fn($q) => $q->where('landlord_id', $landlord->id))
            ->where('issue_date', '>=', $lastMonthStart)
            ->with('lineItems')
            ->get();

        // Use collections to perform calculations in PHP, which is much faster
        $invoicesThisMonth = $recentInvoices->where('issue_date', '>=', $thisMonthStart);
        $invoicesLastMonth = $recentInvoices->where('issue_date', '<', $thisMonthStart);

        // --- Calculate KPIs from collections ---
        $revenueThisMonth = $invoicesThisMonth->sum('total_amount');
        $revenueLastMonth = $invoicesLastMonth->sum('total_amount');

        $paidThisMonth = $invoicesThisMonth->where('status', 'paid')->sum('paid_amount');
        $paidLastMonth = $invoicesLastMonth->where('status', 'paid')->sum('paid_amount');

        $utilityRevenueThisMonth = $invoicesThisMonth->pluck('lineItems')->flatten()->where('lineable_type', UtilityBill::class)->sum('amount');
        $utilityRevenueLastMonth = $invoicesLastMonth->pluck('lineItems')->flatten()->where('lineable_type', UtilityBill::class)->sum('amount');

        $cancelledThisMonth = $invoicesThisMonth->where('status', 'void')->sum('total_amount');
        $cancelledLastMonth = $invoicesLastMonth->where('status', 'void')->sum('total_amount');

        // New contract counts are a separate, simple query
        $newContractsThisMonth = Contract::whereHas('room.property', fn($q) => $q->where('landlord_id', $landlord->id))
            ->whereBetween('start_date', [$thisMonthStart, $now->copy()->endOfMonth()])->count();
        $newContractsLastMonth = Contract::whereHas('room.property', fn($q) => $q->where('landlord_id', $landlord->id))
            ->whereBetween('start_date', [$lastMonthStart, $now->copy()->subMonth()->endOfMonth()])->count();

        // --- Helper for calculating percentage change ---
        $calculateChange = fn($current, $previous) => $previous > 0 ? (($current - $previous) / $previous) * 100 : ($current > 0 ? 100 : 0);

        // --- Return the final stats array ---
        return [
            'new_contracts' => ['current' => $newContractsThisMonth, 'change' => $calculateChange($newContractsThisMonth, $newContractsLastMonth)],
            'revenue' => ['current' => $revenueThisMonth, 'change' => $calculateChange($revenueThisMonth, $revenueLastMonth)],
            'utility_revenue' => ['current' => $utilityRevenueThisMonth, 'change' => $calculateChange($utilityRevenueThisMonth, $utilityRevenueLastMonth)],
            'paid' => ['current' => $paidThisMonth, 'change' => $calculateChange($paidThisMonth, $paidLastMonth)],
            'cancelled' => ['current' => $cancelledThisMonth, 'change' => $calculateChange($cancelledThisMonth, $cancelledLastMonth)],
        ];
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

    public function getContractDetails(Contract $contract)
    {
        // Eager load everything we need in one go to be efficient
        $contract->load('room.amenities', 'room.meters.meterReadings', 'room.property.utilityRates.utilityType');

        $utilityData = [];

        // Get the rates for the specific property of the contract
        $propertyRates = $contract->room->property->utilityRates;

        foreach ($propertyRates as $rate) {
            $consumption = 0;
            // ✨ DEFINE variables to hold the readings
            $start_reading = null;
            $end_reading = null;

            $meter = $contract->room->meters->firstWhere('utility_type_id', $rate->utility_type_id);

            if ($meter) {
                $readings = $meter->meterReadings()->latest('reading_date')->take(2)->get();

                if ($readings->count() >= 2) {
                    // Get the readings before calculating
                    $end_reading = $readings[0]->reading_value;
                    $start_reading = $readings[1]->reading_value;
                    $consumption = $end_reading - $start_reading;
                } elseif ($readings->count() === 1) {
                    // Get the readings before calculating
                    $end_reading = $readings[0]->reading_value;
                    $start_reading = $meter->initial_reading;
                    $consumption = $end_reading - $start_reading;
                } else {
                    $start_reading = $meter->initial_reading;
                    $end_reading = $meter->initial_reading;
                    $consumption = 0;
                }
            }

            // ✨ ADD the new reading data to the array
            $utilityData[] = [
                'utility_type' => $rate->utilityType,
                'rate' => $rate->rate,
                'consumption' => max(0, $consumption),
                'start_reading' => $start_reading, // New
                'end_reading' => $end_reading,   // New
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

    public function store(Request $request)
    {
        // 1. Validate the request data
        $validatedData = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'discount' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|string|in:rent,utility',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.utility_type_id' => 'required_if:items.*.type,utility|exists:utility_types,id',
            'items.*.start_reading' => 'nullable|numeric',
            'items.*.end_reading' => 'nullable|numeric',
            'items.*.consumption' => 'required_if:items.*.type,utility|numeric',
            'items.*.rate' => 'required_if:items.*.type,utility|numeric',
        ]);

        try {
            $invoice = DB::transaction(function () use ($validatedData, $request) {
                // 2. Create the main Invoice
                $invoice = Invoice::create([
                    'contract_id' => $validatedData['contract_id'],
                    'invoice_number' => $validatedData['invoice_number'],
                    'issue_date' => $validatedData['issue_date'],
                    'due_date' => $validatedData['due_date'],
                    'status' => 'draft', // Or 'sent'
                ]);

                $totalAmount = 0;

                // 3. Loop through items and create LineItems
                foreach ($validatedData['items'] as $itemData) {
                    $lineable = null;

                    // If it's a utility, create the historical UtilityBill record first
                    if ($itemData['type'] === 'utility') {
                        $lineable = UtilityBill::create([
                            'contract_id' => $validatedData['contract_id'],
                            'utility_type_id' => $itemData['utility_type_id'],
                            'billing_period_start' => $validatedData['issue_date'],
                            'billing_period_end' => $validatedData['issue_date'],
                            'start_reading' => $itemData['start_reading'], // New
                            'end_reading' => $itemData['end_reading'],
                            'consumption' => $itemData['consumption'],
                            'rate_applied' => $itemData['rate'],
                            'amount' => $itemData['amount'],
                        ]);
                    }

                    // Create the LineItem
                    $lineItem = new LineItem([
                        'description' => $itemData['description'],
                        'amount' => $itemData['amount'],
                    ]);

                    // Associate with the Invoice
                    $lineItem->invoice()->associate($invoice);

                    // If a lineable model was created (UtilityBill), associate it
                    if ($lineable) {
                        $lineItem->lineable()->associate($lineable);
                    }

                    $lineItem->save();
                    $totalAmount += $lineItem->amount;
                }

                // 4. Calculate discount and final total
                $discountAmount = 0;
                if (isset($validatedData['discount']) && $validatedData['discount'] > 0) {
                    $discountAmount = $totalAmount * ($validatedData['discount'] / 100);
                    // Optional: Add a line item for the discount
                    LineItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => 'Discount (' . $validatedData['discount'] . '%)',
                        'amount' => -$discountAmount, // Store discount as a negative amount
                    ]);
                }

                // 5. Update the final total on the invoice
                $invoice->total_amount = $totalAmount - $discountAmount;
                $invoice->save();

                return $invoice;
            });

        } catch (\Exception $e) {
            // Handle potential errors
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage())->withInput();
        }

        // 6. Redirect with success message
        return redirect()->route('landlord.payments.show', $invoice->id)->with('success', 'Invoice created successfully!');
    }

    // In app/Http/Controllers/PaymentController.php

    public function show($invoiceId)
    {
        $landlord = Auth::user();

        // Find the invoice but ONLY if it belongs to the current landlord.
        $invoice = Invoice::where('id', $invoiceId)
            ->whereHas('contract.room.property', function ($query) use ($landlord) {
                $query->where('landlord_id', $landlord->id);
            })
            ->with([
                'contract.tenant',
                'contract.room.property',
                'lineItems.lineable'
            ])
            ->firstOrFail(); // Fails to a 404 page if not found or not owned.

        // Now you are guaranteed to have the correct, authorized invoice.
        return view('backends.dashboard.payments.show', compact('invoice'));
    }


public function updateStatus(Request $request, Invoice $invoice)
{
    try {
        // 1. Authorize the request
        if ($invoice->contract->room->property->landlord_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2. Validate the incoming status
        $validated = $request->validate([
            'status' => 'required|string|in:draft,sent,paid,partial,overdue,void',
        ]);

        // 3. Update the invoice status and payment date
        $invoice->status = $validated['status'];
        $invoice->payment_date = ($validated['status'] === 'paid') ? now() : null;

        // 4. Save the changes
        $invoice->save();

        // 5. Return a success response
        return response()->json(['message' => 'Invoice status updated successfully.']);

    } catch (\Exception $e) {
        // --- This is the new error handling block ---
        
        // Log the real error for you (the developer) to see
        Log::error('Invoice Status Update Failed: ' . $e->getMessage());

        // Return a clean, user-friendly error message to the browser
        return response()->json([
            'message' => 'The server encountered an error and could not update the status. Please try again.'
        ], 500); // 500 is the "Internal Server Error" HTTP status code
    }
}
}
