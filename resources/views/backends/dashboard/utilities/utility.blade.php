@extends('backends.layouts.app')

@section('title', 'Manage Rates for ' . $property->name)

@push('style')
    {{-- Styles can remain the same --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mermaid.min.css">
    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.core.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.snow.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="page-container">
    {{-- Page Title remains the same --}}
    <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
        <div class="flex-grow-1">
            <h4 class="fs-18 text-uppercase fw-bold mb-0">Manage Utility Rates for: {{ $property->name }}</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{-- route('landlord.properties.index') --}}">Properties</a></li>
                <li class="breadcrumb-item active">Manage Rates</li>
            </ol>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom border-dashed">
                    <div class="d-flex flex-wrap justify-content-between gap-2">
                        <h4 class="header-title">All Utility Types & Rates</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRateModal">
                            <i class="ti ti-plus me-1"></i>Add New Rate
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-rates-gridjs"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals remain the same --}}
@include('backends.dashboard.utilities.create-rate', ['utilityTypes' => $allUtilityTypes])
@include('backends.dashboard.utilities.edit-rate')
@endsection

@push('script')
    {{-- Scripts remain the same --}}
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Use the new $utilityData variable from the controller
    const utilityData = {!! json_encode($utilityData->values()) !!};

    // 2. Render Grid.js Table
    if (document.getElementById("table-rates-gridjs")) {
        new gridjs.Grid({
            columns: [
                { name: "Utility Type", width: "250px", formatter: (cell, row) => row.cells[0].data.type.name },
                {
                    name: "Rate", width: "150px",
                    formatter: (cell, row) => {
                        const rate = row.cells[0].data.rate;
                        return rate ? `$${parseFloat(rate.rate).toFixed(2)} / ${row.cells[0].data.type.unit_of_measure}` : gridjs.html('<span class="text-muted">Not Set</span>');
                    }
                },
                {
                    name: "Effective From", width: "180px",
                    formatter: (cell, row) => {
                        const rate = row.cells[0].data.rate;
                        return rate ? new Date(rate.effective_from).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : gridjs.html('<span class="text-muted">N/A</span>');
                    }
                },
                {
                    name: "Actions",
                    width: "150px",
                    sort: false,
                    formatter: (cell, row) => {
                        const item = row.cells[0].data;
                        // If rate EXISTS, show Edit/Delete buttons
                        if (item.rate) {
                            const editButtonHtml = `<button class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-rate-btn" data-bs-toggle="modal" data-bs-target="#editRateModal" data-rate-data='${JSON.stringify(item.rate)}' data-utility-type-name="${item.type.name}" title="Edit Rate"><i class="ti ti-edit fs-16"></i></button>`;
                            const deleteButtonHtml = `<button class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-rate-btn" data-destroy-url="{{ url('utility-rates') }}/${item.rate.id}" data-utility-type-name="${item.type.name}" title="Delete Rate"><i class="ti ti-trash"></i></button>`;
                            return gridjs.html(`<div class="hstack gap-1 justify-content-center">${editButtonHtml}${deleteButtonHtml}</div>`);
                        }
                        // If rate is NULL, show Add button
                        else {
                            return gridjs.html(`<button class="btn btn-sm btn-soft-primary add-rate-btn" data-bs-toggle="modal" data-bs-target="#createRateModal" data-utility-type-id="${item.type.id}"><i class="ti ti-plus me-1"></i> Add Rate</button>`);
                        }
                    }
                }
            ],
            // Use a hidden column to store the raw data object for each row
            data: utilityData.map(item => [item]),
            search: true,
            sort: {
                // Multi-column sorting
                multiColumn: false,
                // Custom compare function to sort by Utility Type name
                compare: (a, b) => {
                    if (a.type.name < b.type.name) return -1;
                    if (a.type.name > b.type.name) return 1;
                    return 0;
                }
            },
            pagination: { limit: 10 },
            style: { table: { 'font-size': '0.85rem' } }
        }).render(document.getElementById("table-rates-gridjs"));
    }

    // 3. Handle Button Clicks (Add, Edit, Delete)
    document.addEventListener('click', function (e) {
        // Handle ADD Rate button from table row
        const addButton = e.target.closest('.add-rate-btn');
        if (addButton) {
            const utilityTypeId = addButton.dataset.utilityTypeId;
            const createModal = $('#createRateModal');
            // Pre-select the utility type in the modal's dropdown
            createModal.find('#utility_type_id').val(utilityTypeId).trigger('change');
        }

        // Handle EDIT button
        const editButton = e.target.closest('.edit-rate-btn');
        if (editButton) {
            const modal = $('#editRateModal');
            const rateData = JSON.parse(editButton.dataset.rateData);
            const utilityTypeName = editButton.dataset.utilityTypeName;

            modal.find('.modal-title').text(`Edit Rate for ${utilityTypeName}`);
            modal.find('#editRate').val(rateData.rate);
            modal.find('#editEffectiveFrom').val(new Date(rateData.effective_from).toISOString().split('T')[0]);
            modal.find('#editRateForm').attr('action', `{{ url('utility-rates') }}/${rateData.id}`);
        }

        // Handle Delete Button Click
        const deleteButton = e.target.closest('.delete-rate-btn');
        if (deleteButton) {
            const utilityTypeName = deleteButton.getAttribute('data-utility-type-name');
            const actionUrl = deleteButton.getAttribute('data-destroy-url');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Are you sure?',
                text: `The rate for "${utilityTypeName}" will be permanently deleted!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;
                    form.innerHTML = `<input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    });

    // Initialize Select2 for modals
    $(function () {
        $('#createRateModal .select2').select2({ dropdownParent: $('#createRateModal') });
    });
});
</script>
@endpush
