@php
    use Carbon\Carbon;
@endphp

@extends('backends.layouts.app')

@section('title', 'Utility Usage | RoomGate')

@push('style')
<style>
    /* Modern Mobile App Design - Core Variables */
    :root {
        --primary-color: #47CFD1;
        --secondary-color: #2DB6B8;
        --accent-color: #70E1E3;
        --dark-color: #333333;
        --light-color: #FFFFFF;
        --bg-light: #FFFFFF;
        --bg-softer: #F8FDFD;
        --text-color: #333333;
        --text-muted: #718096;
        --card-radius: 1.25rem;
        --button-radius: 1.75rem;
        --progress-height: 0.5rem;
        --icon-bg: rgba(71, 207, 209, 0.15);
        --shadow-color: rgba(71, 207, 209, 0.2);
        --class-card-bg: rgba(112, 225, 227, 0.2);
    }
    
    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 1.25rem;
    }
    
    /* Dashboard Header Styles */
    .dashboard-header {
        position: sticky;
        top: 0;
        background-color: transparent;
        z-index: 100;
        padding: 1rem 0 1.5rem 0;
        margin-bottom: 1rem;
    }
    
    .dashboard-header h1 {
        font-weight: 600;
        font-size: 1.4rem;
        color: var(--text-color);
        margin: 0;
    }
    
    .back-button {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: var(--text-color);
        padding: 0;
        margin-right: 0.75rem;
    }
    
    .dashboard-header-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .header-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: var(--bg-softer);
        color: var(--text-color);
        border: none;
        padding: 0;
        transition: all 0.2s ease;
    }
    
    .header-icon:hover {
        background-color: var(--icon-bg);
        transform: translateY(-2px);
    }
    
    /* Animation keyframes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .page-header {
        background: transparent;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .section-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    
    .section-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 16px 20px;
    }
    
    .section-card .card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .chart-container {
        height: 350px;
        width: 100%;
    }
    
    .meter-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    
    .meter-card .meter-header {
        padding: 16px 20px;
        background-color: rgba(59, 130, 246, 0.1);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .meter-card .meter-header h5 {
        margin: 0;
        font-weight: 600;
        color: #3b82f6;
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .utility-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 12px;
    }
    
    /* Category Filter */
    .category-filter {
        display: flex;
        overflow-x: auto;
        padding: 0.5rem 0;
        gap: 0.75rem;
        -ms-overflow-style: none;
        scrollbar-width: none;
        margin-bottom: 1.5rem;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .category-filter::-webkit-scrollbar {
        display: none;
    }
    
    .category-filter .d-flex {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.75rem;
        padding-right: 1rem; /* Add some padding at the end for better UX */
    }
    
    .category-button {
        width: 40px;
        height: 40px;
        min-width: 40px; /* Ensure the button doesn't shrink */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        flex-shrink: 0; /* Prevent shrinking */
    }
    
    .category-button.active {
        background-color: var(--primary-color);
        color: white;
    }
    
    .category-tag {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        background-color: #f5f5f5;
        font-size: 0.85rem;
        white-space: nowrap;
        flex-shrink: 0; /* Prevent shrinking */
        transition: all 0.2s ease;
    }
    
    .category-tag:hover {
        background-color: var(--icon-bg);
        transform: translateY(-2px);
    }
    
    /* Mobile Navigation */
    .mobile-nav {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: var(--light-color);
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        z-index: 1000;
        padding: 0.75rem;
    }
    
    .mobile-nav-wrapper {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .mobile-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.5rem;
        color: var(--text-muted);
        text-decoration: none;
        position: relative;
        z-index: 2;
        flex: 1;
        text-align: center;
    }
    
    .mobile-nav-item.active {
        color: var(--primary-color);
    }
    
    .mobile-nav-icon {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    
    .mobile-nav-label {
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .mobile-nav {
            display: flex;
            justify-content: space-around;
        }
        
        .container-fluid {
            padding-bottom: 80px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid dashboard-container px-3">
    <!-- Dashboard Header -->
    <div class="dashboard-header animate-fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('tenant.utility-bills') }}" class="back-button">
                    <i class="ti ti-chevron-left"></i>
                </a>
                <h1>Utility Usage</h1>
            </div>
            <div class="dashboard-header-actions">
                <button class="header-icon" data-bs-toggle="tooltip" title="Filter Usage">
                    <i class="ti ti-filter"></i>
                </button>
                <button class="header-icon" data-bs-toggle="tooltip" title="Download Report">
                    <i class="ti ti-download"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="category-filter">
        <div class="d-flex">
            <a href="#" class="category-tag text-decoration-none">
                <span>All Utilities</span>
            </a>
            <a href="#" class="category-tag text-decoration-none">
                <span>Electricity</span>
            </a>
            <a href="#" class="category-tag text-decoration-none">
                <span>Water</span>
            </a>
            <a href="#" class="category-tag text-decoration-none">
                <span>Gas</span>
            </a>
            <a href="#" class="category-tag text-decoration-none">
                <span>Last 3 Months</span>
            </a>
            <a href="#" class="category-tag text-decoration-none">
                <span>Last Year</span>
            </a>
        </div>
    </div>
    
    <!-- Usage Chart -->
    <div class="section-card card mb-4">
        <div class="card-header">
            <h5>Monthly Usage (Last 12 Months)</h5>
        </div>
        <div class="card-body">
            <div id="utility-usage-chart" class="chart-container"></div>
        </div>
    </div>
    
    <!-- Meter Readings -->
    @if(!empty($meterReadingHistory))
        @foreach($meterReadingHistory as $meterId => $meterData)
            <div class="meter-card">
                <div class="meter-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $meterData['meter']->utilityType->name }} Meter Readings</h5>
                        <p class="text-muted mb-0">Meter #{{ $meterData['meter']->meter_number }}</p>
                    </div>
                    <div class="utility-icon bg-primary-subtle text-primary">
                        @if(strtolower($meterData['meter']->utilityType->name) == 'electricity')
                            <i class="ti ti-bolt"></i>
                        @elseif(strtolower($meterData['meter']->utilityType->name) == 'water')
                            <i class="ti ti-droplet"></i>
                        @elseif(strtolower($meterData['meter']->utilityType->name) == 'gas')
                            <i class="ti ti-flame"></i>
                        @else
                            <i class="ti ti-gauge"></i>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reading Value</th>
                                <th>Usage</th>
                                <th>Recorded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meterData['readings'] as $reading)
                                @php
                                    // Sort readings chronologically (oldest first)
                                    $chronologicalReadings = collect($meterData['allReadings']->all())->sortBy('reading_date')->values();
                                    
                                    // Find the position of this reading in chronological order
                                    $chronoIndex = $chronologicalReadings->search(fn($item) => $item->id === $reading->id);
                                    
                                    // Is this the first reading ever?
                                    $isFirstEverReading = ($chronoIndex == 0);
                                    
                                    if ($isFirstEverReading) {
                                        // First ever reading: subtract initial_reading
                                        $consumption = $reading->reading_value - $meterData['meter']->initial_reading;
                                    } else {
                                        // Get the previous reading in chronological order
                                        $previousReading = $chronologicalReadings->get($chronoIndex - 1);
                                        $consumption = $reading->reading_value - $previousReading->reading_value;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $reading->reading_date->format('M d, Y') }}</td>
                                    <td>{{ number_format($reading->reading_value, 2) }} {{ $meterData['meter']->utilityType->unit }}</td>
                                    <td>
                                        @if ($reading->reading_value == 0)
                                            -
                                        @elseif ($consumption >= 0)
                                            <span class="text-success">{{ number_format($consumption, 2) }} {{ $meterData['meter']->utilityType->unit }}</span>
                                        @else
                                            <span class="text-danger">Error</span>
                                        @endif
                                    </td>
                                    <td>{{ $reading->recordedBy->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No readings available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $meterData['readings']->links('vendor.pagination.custom-pagination') }}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            <i class="ti ti-info-circle me-2"></i> No meter readings available.
        </div>
    @endif

    
    <!-- Mobile Navigation for small screens -->
    <div class="d-md-none mobile-nav">
        <div class="mobile-nav-wrapper">
            <a href="{{ route('tenant.dashboard') }}" class="mobile-nav-item">
                <i class="ti ti-home mobile-nav-icon"></i>
                <span class="mobile-nav-label">Home</span>
            </a>
            <a href="{{ route('tenant.invoices') }}" class="mobile-nav-item">
                <i class="ti ti-receipt mobile-nav-icon"></i>
                <span class="mobile-nav-label">Invoices</span>
            </a>
            <a href="{{ route('tenant.utility-bills') }}" class="mobile-nav-item active">
                <i class="ti ti-bolt mobile-nav-icon"></i>
                <span class="mobile-nav-label">Utilities</span>
            </a>
            <a href="{{ route('tenant.profile') }}" class="mobile-nav-item">
                <i class="ti ti-user mobile-nav-icon"></i>
                <span class="mobile-nav-label">Profile</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- Utility Usage Chart ---
        const utilityData = @json($utilityData ?? []);
        const utilityChartSeries = [];
        const months = @json($months ?? []);
        
        // Create series data for each utility type
        for (const [utilityName, monthlyUsage] of Object.entries(utilityData)) {
            utilityChartSeries.push({
                name: utilityName,
                data: Object.values(monthlyUsage)
            });
        }
        
        if (utilityChartSeries.length > 0) {
            const utilityUsageOptions = {
                series: utilityChartSeries,
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: true
                    },
                    fontFamily: 'inherit',
                    foreColor: '#6c757d',
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 2,
                        blur: 4,
                        opacity: 0.2
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4,
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                },
                xaxis: {
                    categories: months,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Consumption',
                        style: {
                            fontSize: '12px',
                            fontWeight: 400
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return value.toFixed(1);
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '14px'
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                markers: {
                    size: 4,
                    strokeWidth: 0,
                    hover: {
                        size: 6
                    }
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(value) {
                            return value.toFixed(2);
                        }
                    }
                }
            };
            
            try {
                if (document.querySelector("#utility-usage-chart")) {
                    new ApexCharts(document.querySelector("#utility-usage-chart"), utilityUsageOptions).render();
                }
            } catch (error) {
                console.error("Error rendering utility chart:", error);
                if (document.querySelector("#utility-usage-chart")) {
                    document.querySelector("#utility-usage-chart").innerHTML = '<div class="text-center text-muted py-5">Error loading chart</div>';
                }
            }
        } else {
            if (document.querySelector("#utility-usage-chart")) {
                document.querySelector("#utility-usage-chart").innerHTML = '<div class="text-center text-muted py-5">No utility usage data available</div>';
            }
        }
    });
</script>
@endpush
