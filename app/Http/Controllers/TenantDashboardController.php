<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\MeterReading;
use App\Models\Meter;
use App\Models\UtilityBill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TenantDashboardController extends Controller
{
    /**
     * Display the tenant's dashboard with all relevant statistics and data.
     */
    public function index(Request $request)
    {
        $tenant = Auth::user();
        $now = Carbon::now();

        // Get the tenant's active contract
        $currentContract = Contract::where('user_id', $tenant->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        // --- Base Queries (to keep code DRY and scoped to the tenant) ---
        $invoicesQuery = Invoice::whereHas('contract', fn($q) => $q->where('user_id', $tenant->id));

        // Get next invoice due (if any)
        $nextInvoice = (clone $invoicesQuery)
            ->whereIn('status', ['sent', 'overdue'])
            ->orderBy('due_date')
            ->first();

        // Get recent invoices
        $recentInvoices = (clone $invoicesQuery)
            ->with(['contract', 'lineItems'])
            ->latest('issue_date')
            ->limit(5)
            ->get();

        // Get total balance due - calculate as total_amount - paid_amount
        $pendingInvoices = (clone $invoicesQuery)
            ->whereIn('status', ['sent', 'overdue'])
            ->get();
            
        $totalBalanceDue = $pendingInvoices->sum(function($invoice) {
            return $invoice->total_amount - $invoice->paid_amount;
        });

        // Get total paid this month
        $totalPaidThisMonth = (clone $invoicesQuery)
            ->where('status', 'paid')
            ->where('issue_date', '>=', Carbon::now()->startOfMonth())
            ->sum('paid_amount');

        // Calculate remaining stats for backwards compatibility
        $totalInvoices = (clone $invoicesQuery)->count();
        $pendingInvoices = (clone $invoicesQuery)->whereIn('status', ['sent', 'overdue'])->count();
        $paidInvoices = (clone $invoicesQuery)->where('status', 'paid')->count();
        
        $stats = [
            'total_invoices' => $totalInvoices,
            'pending_invoices' => $pendingInvoices,
            'paid_invoices' => $paidInvoices,
            'contract_days_left' => $currentContract ? intval($now->diffInDays($currentContract->end_date, false)) : 0,
        ];

        // Get data for simple payment history chart (Last 6 Months)
        $months = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M Y'));
        }
        
        $paymentData = (clone $invoicesQuery)
            ->select(
                DB::raw('SUM(total_amount) as billed'),
                DB::raw('SUM(paid_amount) as paid'),
                DB::raw("DATE_FORMAT(issue_date, '%b %Y') as monthname"),
                DB::raw("MIN(issue_date) as month_date") // Add this for ordering
            )
            ->where('issue_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('monthname')
            ->orderBy('month_date', 'asc') // Order by the aggregated date field instead
            ->get();
            
        $billedChart = $months->mapWithKeys(fn($month) => [
            $month => $paymentData->firstWhere('monthname', $month)->billed ?? 0
        ]);
        
        $paidChart = $months->mapWithKeys(fn($month) => [
            $month => $paymentData->firstWhere('monthname', $month)->paid ?? 0
        ]);

        // Get all invoices for backward compatibility
        $allInvoices = (clone $invoicesQuery)
            ->with(['contract', 'lineItems'])
            ->latest('issue_date')
            ->get();

        // Get recent utility bills
        $recentUtilityBills = UtilityBill::whereHas('contract', fn($q) => $q->where('user_id', $tenant->id))
            ->with(['utilityType', 'contract'])
            ->latest('billing_period_end')
            ->limit(3)
            ->get();

        // Get utility bills for backward compatibility
        $utilityBills = UtilityBill::whereHas('contract', fn($q) => $q->where('user_id', $tenant->id))
            ->with(['utilityType', 'contract'])
            ->latest('billing_period_end')
            ->get();

        // Get utility usage data for the chart (simplified)
        $utilityData = [];
        $meterReadingHistory = [];
        
        if ($currentContract) {
            // Get all meters associated with the tenant's room
            $meters = Meter::where('room_id', $currentContract->room_id)->get();
            
            foreach ($meters as $meter) {
                $utilityName = $meter->utilityType->name;
                $utilityData[$utilityName] = [];
                
                // Process meter readings for simplified chart
                $readings = MeterReading::where('meter_id', $meter->id)
                    ->where('reading_date', '>=', now()->subMonths(5)->startOfMonth())
                    ->orderBy('reading_date')
                    ->get()
                    ->groupBy(function ($reading) {
                        return Carbon::parse($reading->reading_date)->format('M Y');
                    });
                
                // Store all readings for detailed history view (backward compatibility)
                $meterReadingHistory[$meter->id] = [
                    'meter' => $meter,
                    'readings' => MeterReading::where('meter_id', $meter->id)
                        ->with('recordedBy')
                        ->orderBy('reading_date', 'desc')
                        ->get(),
                    'paginatedReadings' => MeterReading::where('meter_id', $meter->id)
                        ->with('recordedBy')
                        ->orderBy('reading_date', 'desc')
                        ->paginate(5, ['*'], "meter_{$meter->id}_page"),
                    'allReadings' => MeterReading::where('meter_id', $meter->id)
                        ->orderBy('reading_date', 'desc')
                        ->get()
                ];
                
                // Calculate monthly usage
                $previousReading = null;
                
                foreach ($months as $month) {
                    if (isset($readings[$month]) && count($readings[$month]) > 0) {
                        $monthReadings = $readings[$month];
                        $latestReading = $monthReadings->sortByDesc('reading_date')->first()->reading_value;
                        
                        if ($previousReading === null) {
                            // For the first month with data, use the reading as is or calculate from initial reading
                            $earliestInPeriod = $monthReadings->sortBy('reading_date')->first()->reading_value;
                            $usage = $latestReading - ($earliestInPeriod ?: $meter->initial_reading);
                        } else {
                            // For subsequent months, calculate usage from previous month
                            $usage = $latestReading - $previousReading;
                        }
                        
                        $utilityData[$utilityName][$month] = max(0, $usage); // Ensure no negative usage
                        $previousReading = $latestReading;
                    } else {
                        $utilityData[$utilityName][$month] = 0;
                    }
                }
            }
        }

        // Get important notifications
        $notifications = [];
        
        // Add overdue invoice notification
        $overdueInvoices = (clone $invoicesQuery)->where('status', 'overdue')->count();
        
        if ($overdueInvoices > 0) {
            $notifications[] = [
                'type' => 'danger',
                'icon' => 'alert-triangle',
                'message' => "You have {$overdueInvoices} overdue " . ($overdueInvoices > 1 ? 'invoices' : 'invoice') . " that " . ($overdueInvoices > 1 ? 'require' : 'requires') . " immediate attention."
            ];
        }
        
        // Add contract ending soon notification
        if ($currentContract && $currentContract->end_date->diffInDays(now()) <= 30) {
            $daysUntilEnd = intval($currentContract->end_date->diffInDays(now()));
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'calendar',
                'message' => "Your contract is ending in {$daysUntilEnd} days. Please contact the property manager to discuss renewal options."
            ];
        }
        
        // Add high utility usage notification (simplified example)
        foreach ($utilityData as $utilityName => $monthlyData) {
            $currentMonth = now()->format('M Y');
            $lastMonth = now()->subMonth()->format('M Y');
            
            if (isset($monthlyData[$currentMonth]) && isset($monthlyData[$lastMonth])) {
                $currentUsage = $monthlyData[$currentMonth];
                $lastUsage = $monthlyData[$lastMonth];
                
                if ($currentUsage > $lastUsage * 1.25 && $currentUsage > 0 && $lastUsage > 0) { // 25% increase
                    $notifications[] = [
                        'type' => 'info',
                        'icon' => 'zap',
                        'message' => "Your {$utilityName} usage has increased by " . number_format(($currentUsage - $lastUsage) / $lastUsage * 100, 0) . "% compared to last month."
                    ];
                }
            }
        }

        // Always use the simplified dashboard design
        $viewTemplate = 'backends.dashboard.tenant.index_simplified';

        return view($viewTemplate, compact(
            'currentContract',
            'nextInvoice',
            'recentInvoices',
            'totalBalanceDue',
            'totalPaidThisMonth',
            'recentUtilityBills',
            'utilityData',
            'notifications',
            'months',
            // Include variables for backwards compatibility
            'stats',
            'billedChart',
            'paidChart',
            'allInvoices',
            'utilityBills',
            'meterReadingHistory'
        ));
    }
    
    /**
     * Get all invoices for the tenant
     */
    public function allInvoices(Request $request)
    {
        // Start with base query
        $query = Invoice::whereHas('contract', fn($q) => $q->where('user_id', Auth::id()))
            ->with(['contract', 'lineItems']);
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter recent (last 30 days) if requested
        if ($request->has('status') && $request->status == 'recent') {
            $query->where('issue_date', '>=', now()->subDays(30));
        }
        
        // Filter rent-only invoices if requested
        if ($request->has('status') && $request->status == 'rent_only') {
            $query->whereHas('lineItems', function($q) {
                $q->where('description', 'like', '%rent%');
            });
        }
        
        // Get paginated results
        $invoices = $query->latest('issue_date')->paginate(10);
        
        // Append query parameters for pagination links
        $invoices->appends($request->all());
            
        return view('backends.dashboard.tenant.invoices', compact('invoices'));
    }
    
    /**
     * Get all utility bills for the tenant
     */
    public function allUtilityBills(Request $request)
    {
        // Start with base query
        $query = UtilityBill::whereHas('contract', fn($q) => $q->where('user_id', Auth::id()))
            ->with(['utilityType', 'contract.room.property', 'lineItem']);
        
        // Apply type filter if provided
        if ($request->has('type') && $request->type != 'all') {
            $query->whereHas('utilityType', function($q) use ($request) {
                $q->where('name', $request->type);
            });
        }
        
        // Get paginated results with 10 items per page
        $utilityBills = $query->latest('billing_period_end')->paginate(10);
            
        // Append query parameters for pagination links
        $utilityBills->appends($request->all());
            
        return view('backends.dashboard.tenant.utility-bills', compact('utilityBills'));
    }
    
    /**
     * Get utility usage details
     */
    public function utilityUsage()
    {
        $tenant = Auth::user();
        
        // Get the tenant's active contract
        $currentContract = Contract::where('user_id', $tenant->id)
            ->where('status', 'active')
            ->latest()
            ->first();
            
        if (!$currentContract) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'No active contract found.');
        }
        
        // Get meters associated with the tenant's room
        $meters = Meter::where('room_id', $currentContract->room_id)
            ->with('utilityType')
            ->get();
            
        // Get readings for each meter
        $meterReadingHistory = [];
        
        foreach ($meters as $meter) {
            $readings = MeterReading::where('meter_id', $meter->id)
                ->with('recordedBy')
                ->orderBy('reading_date', 'desc')
                ->paginate(10, ['*'], "meter_{$meter->id}_page");
                
            $meterReadingHistory[$meter->id] = [
                'meter' => $meter,
                'readings' => $readings,
                'allReadings' => MeterReading::where('meter_id', $meter->id)
                    ->orderBy('reading_date', 'desc')
                    ->get()
            ];
        }
        
        // Get utility usage data for the chart
        $utilityData = [];
        $months = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M Y');
        }
        
        foreach ($meters as $meter) {
            $utilityName = $meter->utilityType->name;
            $utilityData[$utilityName] = [];
            
            foreach ($months as $month) {
                $monthDate = Carbon::createFromFormat('M Y', $month);
                $monthStart = $monthDate->copy()->startOfMonth();
                $monthEnd = $monthDate->copy()->endOfMonth();
                
                // Get readings in this month
                $readings = MeterReading::where('meter_id', $meter->id)
                    ->whereBetween('reading_date', [$monthStart, $monthEnd])
                    ->orderBy('reading_date')
                    ->get();
                
                // Calculate usage for this month
                $usage = 0;
                if ($readings->count() > 0) {
                    $firstReading = $readings->first()->reading_value;
                    $lastReading = $readings->last()->reading_value;
                    $usage = $lastReading - $firstReading;
                }
                
                $utilityData[$utilityName][$month] = max(0, $usage);
            }
        }
        
        return view('backends.dashboard.tenant.utility-usage', compact(
            'meters',
            'meterReadingHistory',
            'utilityData',
            'months'
        ));
    }
    
    /**
     * Get invoice details for AJAX request
     */
    public function getInvoiceDetails(Invoice $invoice)
    {
        // Check if this invoice belongs to the authenticated tenant
        if ($invoice->contract->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Load the invoice with its line items
        $invoice->load(['contract', 'lineItems']);
        
        return response()->json([
            'invoice' => $invoice,
            'line_items' => $invoice->lineItems,
            'contract' => $invoice->contract,
            'room' => $invoice->contract->room,
            'property' => $invoice->contract->room->property,
        ]);
    }
    
    /**
     * Reset the dashboard design to original
     */
    public function resetDesign()
    {
        Session::forget('dashboard_design');
        return redirect()->route('tenant.dashboard');
    }
    
    /**
     * Display the tenant's profile page
     */
    public function profile()
    {
        $user = Auth::user();
        $now = Carbon::now();
        
        // Get the tenant's active contract
        $currentContract = Contract::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();
            
        // Calculate stats
        $stats = [
            'total_contracts' => Contract::where('user_id', $user->id)->count(),
            'properties_rented' => Contract::where('user_id', $user->id)
                ->select('room_id')
                ->distinct()
                ->count(),
            'months_as_tenant' => Contract::where('user_id', $user->id)
                ->where('start_date', '<=', now())
                ->sum(DB::raw('TIMESTAMPDIFF(MONTH, GREATEST(start_date, DATE_SUB(NOW(), INTERVAL 1 YEAR)), LEAST(end_date, NOW()))'))
        ];
        
        return view('backends.dashboard.tenant.profile', compact('user', 'currentContract', 'stats'));
    }
    
    /**
     * Update the tenant's profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        
        if ($user->isDirty('email')) {
            // Set email_verified_at to null without type errors
            $user->forceFill(['email_verified_at' => null]);
        }
        
        $user->save();
        
        return redirect()->route('tenant.profile')->with('success', 'Profile information updated successfully.');
    }
}
