@extends('backends.layouts.app')

@section('title', 'Contract Details')

@push('style')
    {{-- This custom CSS creates the responsive tab and timeline styles --}}
    <style>
        .nav-pills .nav-link {
            text-align: center;
        }

        .timeline-container {
            position: relative;
            padding-left: 30px;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background-color: var(--bs-border-color);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-pin {
            position: absolute;
            left: -30px;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--bs-body-bg);
        }

        .timeline-pin i {
            font-size: 14px;
            color: #fff;
        }

        .timeline-content {
            margin-left: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="page-container">
        {{-- ======================= Page Header ======================= --}}
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Contract Details</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('landlord.contracts.index') }}">Contracts</a></li>
                    <li class="breadcrumb-item active">#{{ str_pad($contract->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-primary-subtle border-0">
                    <div class="card-body">
                        {{-- Responsive header: Stacks on mobile, row on desktop --}}
                        <div class="d-flex flex-column flex-lg-row align-items-center">
                            <img src="{{ $contract->tenant->image ? asset($contract->tenant->image) : asset('assets/images/default_image.png') }}"
                                class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="ms-lg-3 mt-3 mt-lg-0 text-center text-lg-start flex-grow-1">
                                <h3 class="mb-0">{{ $contract->tenant->name }}</h3>
                                <p class="text-muted mb-0">
                                    Contract #{{ str_pad($contract->id, 6, '0', STR_PAD_LEFT) }} for Room
                                    {{ $contract->room->room_number }}
                                </p>
                            </div>
                            <div class="d-flex gap-2 mt-3 mt-lg-0 flex-shrink-0">
                                <a href="{{ route('landlord.payments.create', ['contract_id' => $contract->id]) }}"
                                    class="btn btn-primary"><i class="ti ti-plus me-1"></i>New Invoice</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- 2x2 grid on mobile, 4-across on desktop --}}
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted mb-2">Monthly Rent</p>
                        <h4 class="mb-0">${{ number_format($totalMonthlyRent, 2) }}</h4>
                        <small class="text-muted">
                            Base: ${{ number_format($rentAmount, 2) }} + 
                            Amenities: ${{ number_format($contract->room->amenities->sum('amenity_price'), 2) }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted mb-2">Current Balance</p>
                        <h4 class="mb-0 {{ $currentBalance > 0 ? 'text-danger' : 'text-success' }}">
                            ${{ number_format($currentBalance, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted mb-2">Status</p>
                        <h4 class="mb-0 text-success">{{ ucfirst($contract->status) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted mb-2">Days Remaining</p>
                        <h4 class="mb-0">{{ $daysRemaining }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#details-pane"
                            role="tab">
                            <i class="ti ti-file-text d-block d-lg-none fs-4"></i>
                            <span class="d-none d-lg-block">Details</span>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#invoices-pane" role="tab">
                            <i class="ti ti-file-invoice d-block d-lg-none fs-4"></i>
                            <span class="d-none d-lg-block">Invoices</span>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#usage-pane" role="tab">
                            <i class="ti ti-bolt d-block d-lg-none fs-4"></i>
                            <span class="d-none d-lg-block">Utility Usage</span>
                        </a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="details-pane" role="tabpanel">
                        <h5 class="mb-3">Contract Information</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Start Date</dt>
                            <dd class="col-sm-9">{{ $contract->start_date->format('F d, Y') }}</dd>
                            <dt class="col-sm-3">End Date</dt>
                            <dd class="col-sm-9">{{ $contract->end_date->format('F d, Y') }}</dd>
                            <dt class="col-sm-3">Duration</dt>
                            <dd class="col-sm-9">
                                {{ $contract->start_date->diff($contract->end_date)->format('%y years, %m months, %d days') }}
                            </dd>
                            <dt class="col-sm-3">Billing Cycle</dt>
                            <dd class="col-sm-9">{{ ucfirst($contract->billing_cycle) }}</dd>
                        </dl>
                        <hr>
                        <h5 class="mb-3">Property Information</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Property</dt>
                            <dd class="col-sm-9">{{ $contract->room->property->name }}</dd>
                            <dt class="col-sm-3">Room</dt>
                            <dd class="col-sm-9">{{ $contract->room->room_number }}
                                ({{ $contract->room->roomType->name }})</dd>
                            <dt class="col-sm-3">Address</dt>
                            <dd class="col-sm-9">{{ $contract->room->property->address }}</dd>
                        </dl>
                    </div>

                    <div class="tab-pane" id="invoices-pane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Issue Date</th>
                                        <th>Due Date</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $invoice)
                                        <tr>
                                            <td><a href="#"
                                                    class="text-dark fw-semibold">{{ $invoice->invoice_number }}</a></td>
                                            <td>{{ $invoice->issue_date->format('M d, Y') }}</td>
                                            <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                            <td class="text-end">${{ number_format($invoice->total_amount, 2) }}</td>
                                            <td class="text-center"><span
                                                    class="badge bg-primary-subtle text-primary">{{ ucfirst($invoice->status) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted p-4">No invoices found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $invoices->links('vendor.pagination.custom-pagination') }}</div>
                    </div>

                    <div class="tab-pane" id="usage-pane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Billing Period</th>
                                        <th>Utility</th>
                                        <th>Consumption</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($utilityHistory as $usage)
                                        <tr>
                                            <td>{{ $usage->billing_period_start->format('M Y') }}</td>
                                            <td>{{ $usage->utilityType->name }}</td>
                                            <td>{{ $usage->consumption }} {{ $usage->utilityType->unit_of_measure }}</td>
                                            <td class="text-end">${{ number_format($usage->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted p-4">No utility history
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $utilityHistory->links('vendor.pagination.custom-pagination') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
