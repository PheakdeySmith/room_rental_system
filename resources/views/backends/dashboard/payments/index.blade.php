@extends('backends.layouts.app')

@section('title', 'Invoices | RoomGate')

@push('style')
    <link href="{{ asset('assets') }}/css/flatpickr.min.css" rel="stylesheet" type="text/css">
    <style>
        .filter-group {
            padding: 0.5rem 1rem;
        }

        .filter-option-list .filter-option {
            display: block;
            text-decoration: none;
            color: var(--bs-body-color);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: background-color 0.15s ease-in-out;
        }

        .filter-option-list .filter-option:hover {
            background-color: var(--bs-secondary-bg);
        }

        .filter-option-list .filter-option.active {
            background-color: var(--bs-secondary-bg);
            font-weight: 600;
        }

        #filtersOffcanvas {
            height: 65vh;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid var(--bs-border-color);
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-container">
        {{-- Page Header --}}
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Invoices</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Invoices</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0 text-center align-items-center">

                    {{-- 1. New Contracts --}}
                    <div class="col border-end-md border-light border-dashed">
                        <div class="p-3">
                            <h5 class="text-muted fs-13 text-uppercase">New Contracts</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($stats['new_contracts']['current']) }}</h3>
                            </div>
                            <p class="mb-0 text-muted">
                                <span
                                    class="{{ $stats['new_contracts']['change'] >= 0 ? 'text-success' : 'text-danger' }} me-2">
                                    <i
                                        class="ti ti-caret-{{ $stats['new_contracts']['change'] >= 0 ? 'up' : 'down' }}-filled"></i>
                                    {{ number_format(abs($stats['new_contracts']['change']), 1) }}%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>

                    {{-- 2. Total Revenue --}}
                    <div class="col border-end-md border-light border-dashed">
                        <div class="p-3">
                            <h5 class="text-muted fs-13 text-uppercase">Total Revenue</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                <h3 class="mb-0 fw-bold">${{ number_format($stats['revenue']['current'], 2) }}</h3>
                            </div>
                            <p class="mb-0 text-muted">
                                <span class="{{ $stats['revenue']['change'] >= 0 ? 'text-success' : 'text-danger' }} me-2">
                                    <i
                                        class="ti ti-caret-{{ $stats['revenue']['change'] >= 0 ? 'up' : 'down' }}-filled"></i>
                                    {{ number_format(abs($stats['revenue']['change']), 1) }}%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>

                    {{-- 3. Utility Revenue --}}
                    <div class="col border-end-md border-light border-dashed">
                        <div class="p-3">
                            <h5 class="text-muted fs-13 text-uppercase">Utility Revenue</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                <h3 class="mb-0 fw-bold">${{ number_format($stats['utility_revenue']['current'], 2) }}</h3>
                            </div>
                            <p class="mb-0 text-muted">
                                <span
                                    class="{{ $stats['utility_revenue']['change'] >= 0 ? 'text-success' : 'text-danger' }} me-2">
                                    <i
                                        class="ti ti-caret-{{ $stats['utility_revenue']['change'] >= 0 ? 'up' : 'down' }}-filled"></i>
                                    {{ number_format(abs($stats['utility_revenue']['change']), 1) }}%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>

                    {{-- 4. Amount Paid --}}
                    <div class="col border-end-md border-light border-dashed">
                        <div class="p-3">
                            <h5 class="text-muted fs-13 text-uppercase">Amount Paid</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                <h3 class="mb-0 fw-bold">${{ number_format($stats['paid']['current'], 2) }}</h3>
                            </div>
                            <p class="mb-0 text-muted">
                                <span class="{{ $stats['paid']['change'] >= 0 ? 'text-success' : 'text-danger' }} me-2">
                                    <i class="ti ti-caret-{{ $stats['paid']['change'] >= 0 ? 'up' : 'down' }}-filled"></i>
                                    {{ number_format(abs($stats['paid']['change']), 1) }}%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>

                    {{-- 5. Cancelled Revenue --}}
                    <div class="col">
                        <div class="p-3">
                            <h5 class="text-muted fs-13 text-uppercase">Cancelled Revenue</h5>
                            <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                <h3 class="mb-0 fw-bold">${{ number_format($stats['cancelled']['current'], 2) }}</h3>
                            </div>
                            <p class="mb-0 text-muted">
                                {{-- For cancelled, an increase is bad (red) --}}
                                <span
                                    class="{{ $stats['cancelled']['change'] > 0 ? 'text-danger' : 'text-success' }} me-2">
                                    <i
                                        class="ti ti-caret-{{ $stats['cancelled']['change'] > 0 ? 'up' : 'down' }}-filled"></i>
                                    {{ number_format(abs($stats['cancelled']['change']), 1) }}%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-light">
                        <div class="row justify-content-between g-3">
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control ps-4 filter-control"
                                                placeholder="Search by ID, Tenant..." value="{{ request('search') }}">
                                            <i class="ti ti-search position-absolute top-50 translate-middle-y ms-2"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" name="date_range"
                                                class="form-control flatpickr-input filter-control"
                                                data-provider="flatpickr" data-default-date="{{ request('date_range') }}"
                                                data-date-format="Y-m-d" data-range-date="true"
                                                placeholder="Filter by issue date...">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="ti ti-calendar fs-15"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="text-lg-end">
                                    <button type="button" class="btn btn-dark d-none d-md-inline-block me-1"
                                        data-bs-toggle="modal" data-bs-target="#filtersModal">
                                        <i class="ti ti-filter me-1"></i> Filters
                                    </button>
                                    <button type="button" class="btn btn-dark d-inline-block d-md-none me-1"
                                        data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas"
                                        aria-controls="filtersOffcanvas">
                                        <i class="ti ti-filter me-1"></i> Filters
                                    </button>
                                    <a href="{{ route('landlord.payments.create') }}" class="btn btn-success"><i
                                            class="ti ti-plus me-1"></i>Add Invoice</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">#</th>
                                    <th>Invoice ID</th>
                                    <th>Room </th>
                                    <th>Created On</th>
                                    <th>Invoice To</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="ps-3">
                                            <strong>{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('landlord.payments.show', $invoice->id) }}"
                                                class="text-muted fw-semibold">{{ $invoice->invoice_number }}</a>
                                        </td>
                                        <td>
                                            Room {{ $invoice->contract->room->room_number }}
                                        </td>
                                        <td>
                                            <span
                                                class="fs-15 text-muted">{{ $invoice->issue_date->format('d M Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-sm d-flex justify-content-left align-items-left ">
                                                    <img src="{{ asset($invoice->contract->tenant->image) ?? asset('assets/images/default_image.png') }}"
                                                        alt="User" class="rounded"
                                                        style="width: 100%; height: 100%; object-fit: cover;" />
                                                </div>
                                                <h6 class="fs-14 mb-0">{{ $invoice->contract->tenant->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            ${{ number_format($invoice->total_amount, 2) }}
                                        </td>
                                        <td>
                                            <span
                                                class="fs-15 text-muted">{{ $invoice->due_date->format('d M Y') }}</span>
                                        </td>
                                        <td>
                                            @switch($invoice->status)
                                                @case('paid')
                                                    <span class="badge bg-success-subtle text-success fs-12 p-1">Paid</span>
                                                @break

                                                @case('partial')
                                                    <span class="badge bg-primary-subtle text-primary fs-12 p-1">Partial</span>
                                                @break

                                                @case('overdue')
                                                    <span class="badge bg-warning-subtle text-warning fs-12 p-1">Overdue</span>
                                                @break

                                                @case('void')
                                                    <span class="badge bg-danger-subtle text-danger fs-12 p-1">Void</span>
                                                @break

                                                @case('sent')
                                                    <span class="badge bg-info-subtle text-info fs-12 p-1">Sent</span>
                                                @break

                                                @case('draft')
                                                    <span class="badge bg-secondary-subtle text-secondary fs-12 p-1">Draft</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-light text-dark fs-12 p-1">{{ ucfirst($invoice->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-end">
                                                <a href="{{ route('landlord.payments.show', $invoice->id) }}"
                                                    class="btn btn-soft-primary btn-icon btn-sm rounded-circle"><i
                                                        class="ti ti-eye"></i></a>
                                                {{-- <a href=""
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle"><i
                                                        class="ti ti-edit fs-16"></i></a> --}}
                                                {{-- <form action="" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle"><i
                                                            class="ti ti-trash"></i></button>
                                                </form> --}}
                                            </div>

                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">No invoices found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table><!-- end table -->
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {{-- This single line renders your custom pagination view --}}
                                {{ $invoices->links('vendor.pagination.custom-pagination') }}
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>

        </div> <!-- container -->


        <div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtersModalLabel">Search Filters</h5><button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('backends.dashboard.payments.partials._filters_content')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light clear-filters-btn">Clear Filters</button>
                        <button type="button" class="btn btn-primary apply-filters-btn" data-bs-dismiss="modal">Apply
                            Filters</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="filtersOffcanvas"
            aria-labelledby="filtersOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="filtersOffcanvasLabel">Search Filters</h5><button type="button"
                    class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @include('backends.dashboard.payments.partials._filters_content')
            </div>
            <div class="offcanvas-footer p-3 border-top">
                <button type="button" class="btn btn-light w-100 mb-2 clear-filters-btn">Clear Filters</button>
                <button type="button" class="btn btn-primary w-100 apply-filters-btn" data-bs-dismiss="offcanvas">Apply
                    Filters</button>
            </div>
        </div>

    @endsection

    @push('script')
        <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const invoiceTableBody = document.querySelector('.table tbody');
                const paginationContainer = document.querySelector('.card-footer .d-flex');

                /**
                 * Debounce function to delay execution
                 */
                const debounce = (func, delay) => {
                    let timeoutId;
                    return function(...args) {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(() => func.apply(this, args), delay);
                    };
                };

                /**
                 * Helper to get status badge classes based on status text
                 */
                const getStatusBadge = (status) => {
                    const sanitizedStatus = status.toLowerCase();
                    switch (sanitizedStatus) {
                        case 'paid':
                            return 'bg-success-subtle text-success';
                        case 'partial': // New
                            return 'bg-primary-subtle text-primary';
                        case 'overdue':
                            return 'bg-warning-subtle text-warning';
                        case 'void':
                            return 'bg-danger-subtle text-danger';
                        case 'sent': // New
                            return 'bg-info-subtle text-info';
                        case 'draft': // New
                            return 'bg-secondary-subtle text-secondary';
                        default:
                            return 'bg-light text-dark'; // A more neutral default
                    }
                };

                /**
                 * Main function to fetch data and update the table via AJAX
                 */
                async function applyFilters(page = 1) {
                    const params = new URLSearchParams();

                    // 1. Get search value
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput && searchInput.value) {
                        params.set('search', searchInput.value);
                    }

                    // 2. Get date range value
                    const dateRangeInput = document.querySelector('input[name="date_range"]');
                    if (dateRangeInput && dateRangeInput.value) {
                        params.set('date_range', dateRangeInput.value);
                    }

                    // 3. Get values from filter links (Property, Room Type, Status)
                    document.querySelectorAll('.filter-option-list').forEach(list => {
                        const filterGroup = list.dataset.filterGroup;
                        const activeOption = list.querySelector('.filter-option.active');
                        // Ensure 'any-status' or empty values are not added to the URL
                        if (activeOption && activeOption.dataset.value && !['any-status', ''].includes(
                                activeOption.dataset.value)) {
                            params.set(filterGroup, activeOption.dataset.value);
                        }
                    });

                    // 4. Add page number for pagination
                    params.set('page', page);

                    const url = `{{ url()->current() }}?${params.toString()}`;
                    window.history.pushState({
                        path: url
                    }, '', url);

                    try {
                        const response = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const data = await response.json();
                        updateTable(data);

                    } catch (error) {
                        console.error('Error fetching invoices:', error);
                        invoiceTableBody.innerHTML =
                            `<tr><td colspan="9" class="text-center text-danger py-4">Failed to load data. Please try again.</td></tr>`;
                    }
                }

                /**
                 * Function to redraw the table and pagination with new data
                 */
                function updateTable(data) {
                    invoiceTableBody.innerHTML = '';
                    if (!data.invoices || data.invoices.data.length === 0) {
                        invoiceTableBody.innerHTML =
                            `<tr><td colspan="9" class="text-center text-muted py-4">No invoices found.</td></tr>`;
                    } else {
                        data.invoices.data.forEach(invoice => {
                            const issueDate = new Date(invoice.issue_date).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                            const dueDate = new Date(invoice.due_date).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                            const statusClass = getStatusBadge(invoice.status);
                            const tenantName = invoice.contract.tenant ? invoice.contract.tenant.name : 'N/A';
                            const roomNumber = invoice.contract.room ? invoice.contract.room.room_number :
                                'N/A';
                            const statusText = invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1);

                            // Basic view/edit/delete URLs (update these to your actual routes)
                            const viewUrl = `{{ url('landlord/payments') }}/${invoice.id}`;
                            const editUrl = `{{ url('landlord/payments') }}/${invoice.id}/edit`;
                            const deleteUrl = `{{ url('landlord/payments') }}/${invoice.id}`;


                            const row = `
                            <tr>
                                <td class="ps-3"><input type="checkbox" class="form-check-input" id="customCheck${invoice.id}"></td>
                                <td><a href="${viewUrl}" class="text-muted fw-semibold">${invoice.invoice_number}</a></td>
                                <td>Room ${roomNumber}</td>
                                <td><span class="fs-15 text-muted">${issueDate}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6 class="fs-14 mb-0">${tenantName}</h6>
                                    </div>
                                </td>
                                <td>$${parseFloat(invoice.total_amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td><span class="fs-15 text-muted">${dueDate}</span></td>
                                <td><span class="badge ${statusClass} fs-12 p-1">${statusText}</span></td>
                                <td class="pe-3">
                                    <div class="hstack gap-1 justify-content-end">
                                        <a href="${viewUrl}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle"><i class="ti ti-eye"></i></a>
                                        <a href="${editUrl}" class="btn btn-soft-success btn-icon btn-sm rounded-circle"><i class="ti ti-edit fs-16"></i></a>
                                         <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-icon btn-sm rounded-circle"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `;

                            invoiceTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                    paginationContainer.innerHTML = data.pagination;
                }

                // --- ALL EVENT LISTENERS ---

                // Listener for live search
                document.querySelector('input[name="search"]').addEventListener('input', debounce(() => applyFilters(),
                    400));

                // Listener for Flatpickr
                flatpickr('input[name="date_range"]', {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            // We need to set the value manually for applyFilters to pick it up
                            this.input.value = this.formatDate(selectedDates[0], "Y-m-d") + ' to ' + this
                                .formatDate(selectedDates[1], "Y-m-d");
                            applyFilters();
                        }
                    }
                });

                // Listener for pagination links (delegated to the container)
                paginationContainer.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                        e.preventDefault();
                        const url = new URL(e.target.href);
                        const page = url.searchParams.get('page');
                        applyFilters(page);
                    }
                });


                // Listener for the modal/offcanvas "Apply Filters" button
                document.querySelectorAll('.apply-filters-btn').forEach(button => {
                    button.addEventListener('click', () => applyFilters());
                });

                // Listener for filter links
                document.querySelectorAll('.filter-option').forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Deselect siblings
                        this.closest('.filter-option-list').querySelectorAll('.filter-option').forEach(
                            opt => opt.classList.remove('active'));
                        // Select clicked option
                        this.classList.add('active');
                        // No need to call applyFilters here; user will click the main button.
                    });
                });

                // Listener for the "Clear Filters" button
                document.querySelectorAll('.clear-filters-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelector('input[name="search"]').value = '';
                        if (document.querySelector('input[name="date_range"]')._flatpickr) {
                            document.querySelector('input[name="date_range"]')._flatpickr.clear();
                        }

                        document.querySelectorAll('.filter-option.active').forEach(opt => opt.classList
                            .remove('active'));
                        document.querySelectorAll('.filter-option-list').forEach(list => {
                            // Set the "All/Any" options to active
                            list.querySelector('.filter-option:first-child').classList.add(
                                'active');
                        });

                        applyFilters(); // Fetch all results again
                    });
                });
            });
        </script>
    @endpush
