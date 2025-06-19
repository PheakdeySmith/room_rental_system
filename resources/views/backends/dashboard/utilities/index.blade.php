@extends('backends.layouts.app')

@section('title', 'Utilities | RoomGate')

@push('style')
    {{-- Styles remain the same --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mermaid.min.css">
    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.core.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.snow.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-container">
        {{-- Page Title --}}
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">{{ __('messages.table') }} Utility Type</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">Utility Type</li>
                </ol>
            </div>
        </div>

        {{-- Main Content --}}
        @if (Auth::check() && Auth::user()->hasRole('admin'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <h4 class="header-title">Utility Type</h4>
                                @if (Auth::check() && Auth::user()->hasRole('admin'))
                                    <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                                        <i class="ti ti-plus me-1"></i>{{ __('messages.create') }} Utility Type
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="table-gridjs"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Auth::check() && Auth::user()->hasRole('landlord'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs nav-bordered" role="tablist">
                                <li class="nav-item px-3" role="presentation">
                                    <a href="#element" data-bs-toggle="tab" aria-expanded="true"
                                        class="nav-link py-2 active" aria-selected="true" role="tab">
                                        <span class="d-block d-sm-none"><iconify-icon icon="solar:home-garage-bold"
                                                class="fs-20"></iconify-icon></span>
                                        <span class="d-none d-sm-block"><iconify-icon icon="solar:home-garage-bold"
                                                class="fs-14 me-1 align-middle"></iconify-icon> Properties</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="element" role="tabpanel">
                                    <div class="row g-3">
                                        @forelse ($properties as $property)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card h-100 position-relative">

                                                    <span class="position-absolute top-0 end-0 p-2">
                                                        <span
                                                            class="badge bg-{{ $property->status == 'active' ? 'success' : 'secondary' }} fs-11">{{ ucfirst($property->status) }}</span>
                                                    </span>

                                                    <div class="card-body">
                                                        <h5 class="text-primary fw-medium">{{ $property->name ?? 'N/A' }}
                                                        </h5>
                                                        <p class="text-muted mb-2">Type:
                                                            {{ $property->property_type ?? 'N/A' }}</p>

                                                        @php
                                                            $address_parts = array_filter([
                                                                $property->address_line_1,
                                                                $property->address_line_2,
                                                                $property->city,
                                                                $property->state_province,
                                                                $property->postal_code,
                                                                $property->country,
                                                            ]);
                                                            $full_address = implode(', ', $address_parts);
                                                        @endphp
                                                        <p class="text-muted mb-0"><i
                                                                class="ti ti-map-pin me-1"></i>{{ $full_address }}</p>

                                                        <hr class="my-3">

                                                        {{-- MODIFICATION START: This section now shows Utility Rates --}}
                                                        <div>
                                                            <h6 class="text-muted text-uppercase fs-12 mb-3">Utility Rates
                                                            </h6>

                                                            {{-- Loop through the utilityRates for this property --}}
                                                            @forelse ($property->utilityRates as $rate)
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <div>
                                                                        {{-- Access the utility type's name through the relationship
                                                                    --}}
                                                                        <p class="mb-0 fw-medium text-dark">
                                                                            {{ $rate->utilityType->name }}</p>
                                                                        <small class="text-muted">Effective:
                                                                            {{ $rate->effective_from->format('d M, Y') }}</small>
                                                                    </div>

                                                                    {{-- Display the rate. Assumes a 'rate' column on your utility_rates
                                                                table --}}
                                                                    <p class="mb-0 fw-semibold text-danger">
                                                                        ${{ number_format($rate->rate, 2) }}
                                                                        <small class="text-muted">/
                                                                            {{ $rate->utilityType->unit_of_measure }}</small>
                                                                    </p>
                                                                </div>
                                                            @empty
                                                                {{-- Updated empty state message --}}
                                                                <div class="text-center py-2">
                                                                    <p class="fs-13 text-muted mb-0">No utility rates have
                                                                        been set for
                                                                        this property yet.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                        {{-- MODIFICATION END --}}
                                                    </div>

                                                    <div class="card-footer border-top border-dashed">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            {{-- Update the link to point to a route for managing utility rates --}}
                                                            <a href="{{ route('landlord.properties.rates.index', ['property' => $property->id]) }}"
                                                                class="btn btn-sm btn-primary">Manage Rates</a>
                                                            <a href="#!" class="btn btn-sm btn-light">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-center text-muted mt-4">You have not created any properties
                                                    yet.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <h4 class="header-title">Pending Tasks</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger mb-0">
                            <strong>Task 1:</strong> The ability to view contract details is not yet active.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @if (Auth::check() && Auth::user()->hasRole('admin'))
        @include('backends.dashboard.utilities.create')
        @include('backends.dashboard.utilities.edit')
    @endif
@endsection

@push('script')
    {{-- Scripts remain the same --}}
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const utilityTypesData = {!! json_encode(
                $utilityTypes->map(function ($utilityType, $key) {
                        $utilityTypeDataForJs = [
                            'id' => $utilityType->id,
                            'name' => $utilityType->name,
                            'unit_of_measure' => $utilityType->unit_of_measure,
                            'billing_type' => $utilityType->billing_type,
                            'destroy_url' => route('admin.utility_types.destroy', $utilityType->id),
                            'edit_url' => route('admin.utility_types.update', $utilityType->id),
                            'view_url' => route('admin.utility_types.show', $utilityType->id),
                        ];
                        return [
                            $key + 1,
                            $utilityTypeDataForJs['name'],
                            $utilityTypeDataForJs['unit_of_measure'],
                            $utilityTypeDataForJs['billing_type'],
                            $utilityTypeDataForJs,
                        ];
                    })->values()->all(),
            ) !!};

            if (typeof utilityTypesData !== 'undefined' && Array.isArray(utilityTypesData)) {
                if (utilityTypesData.length === 0) {
                    document.getElementById("table-gridjs").innerHTML =
                        '<div class="alert alert-info text-center">No utility type found.</div>';
                } else {
                    new gridjs.Grid({
                        columns: [{
                            name: "#",
                            width: "50px"
                        }, {
                            name: "{{ __('messages.name') }}",
                            width: "200px"
                        }, {
                            name: "Unit of Measure",
                            width: "150px"
                        }, {
                            name: "Billing Type",
                            width: "150px"
                        }, {
                            name: "{{ __('messages.action') }}",
                            width: "150px",
                            sort: false,
                            formatter: (_, row) => {
                                const actionData = row.cells[4].data;
                                const deleteButtonHtml = `
                                                <button data-destroy-url="${actionData.destroy_url}"
                                                        data-utility-type-name="${actionData.name}"
                                                        type="button"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-utilityType"
                                                        title="Delete"><i class="ti ti-trash"></i></button>`;

                                const editButtonHtml = `
                                                <button class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-utilityType-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-utility-type-data='${JSON.stringify(actionData)}'
                                                        role="button"
                                                        title="Edit"><i class="ti ti-edit fs-16"></i></button>`;

                                return gridjs.html(`
                                                <div class="hstack gap-1 justify-content-end">
                                                    <a href="${actionData.view_url}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle" title="View Details"><i class="ti ti-eye"></i></a>
                                                    @if (Auth::check() && Auth::user()->hasRole('admin'))
                                                        ${editButtonHtml}
                                                    @endif
                                                    ${deleteButtonHtml}
                                                </div>`);
                            }
                        }],
                        pagination: {
                            limit: 10,
                            summary: true
                        },
                        sort: true,
                        search: true,
                        data: utilityTypesData,
                        style: {
                            table: {
                                'font-size': '0.85rem'
                            }
                        }
                    }).render(document.getElementById("table-gridjs"));
                }
            } else {
                console.error("Grid.js Error: utilityTypesData is missing or not a valid array.");
                document.getElementById("table-gridjs").innerHTML =
                    '<div class="alert alert-danger">Could not load utility type data.</div>';
            }

            document.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.delete-utilityType');
                if (deleteButton) {
                    const utilityTypeName = deleteButton.getAttribute('data-utility-type-name') ||
                        'this utility type';
                    const actionUrl = deleteButton.getAttribute('data-destroy-url');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    Swal.fire({
                        title: "Are you sure?",
                        text: `Utility Type "${utilityTypeName}" will be permanently deleted! This action cannot be undone.`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        customClass: {
                            confirmButton: "swal2-confirm btn btn-danger me-2 mt-2",
                            cancelButton: "swal2-cancel btn btn-secondary mt-2",
                        },
                        buttonsStyling: false,
                        showCloseButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = actionUrl;
                            form.innerHTML = `
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="_method" value="DELETE">
                                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }

                const editButton = e.target.closest('.edit-utilityType-btn');
                if (editButton) {
                    const modal = $('#editModal');
                    const utilityTypeData = JSON.parse(editButton.dataset.utilityTypeData);

                    modal.find('#editName').val(utilityTypeData.name);
                    modal.find('#editUnitOfMeasure').val(utilityTypeData.unit_of_measure);
                    modal.find('#editBillingType').val(utilityTypeData.billing_type).trigger(
                        'change');

                    modal.find('#editUtilityTypeForm').attr('action', utilityTypeData.edit_url);
                }
            });

            $(function() {
                $('#createModal .select2').select2({
                    dropdownParent: $('#createModal')
                });
                $('#editModal .select2').select2({
                    dropdownParent: $('#editModal')
                });
            });


        });
    </script>
@endpush
