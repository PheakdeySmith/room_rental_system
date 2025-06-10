@extends('backends.layouts.app')

@section('title', 'Contracts | RoomGate')

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
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Contracts Table</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Contracts</li>
                </ol>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <h4 class="header-title">Contracts Data</h4>
                            @if (Auth::check() && Auth::user()->hasRole('landlord'))
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                                    <i class="ti ti-plus me-1"></i>Add Contract
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
    </div>

    {{-- Modals --}}
    @if (Auth::check() && Auth::user()->hasRole('landlord'))
        @include('backends.dashboard.contracts.create')
        @include('backends.dashboard.contracts.edit')
    @endif
@endsection

@push('script')
    {{-- Scripts remain the same --}}
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>

    <script>
        // 1. DATA MAPPING: Changed to map contracts data
        const contractsData = {!! json_encode(
            $contracts->map(function ($contract, $key) {
                $contractDataForJs = [
                    'id' => $contract->id,
                    'tenant_id' => $contract->user_id,
                    'tenant_name' => $contract->tenant->name ?? 'N/A',
                    'room_id' => $contract->room_id,
                    'room_number' => $contract->room->room_number ?? 'N/A',
                    'start_date' => $contract->start_date,
                    'end_date' => $contract->end_date,
                    'rent_amount' => $contract->rent_amount,
                    'billing_cycle' => $contract->billing_cycle,
                    'status' => $contract->status ?? 'N/A',
                    'destroy_url' => route('landlord.contracts.destroy', $contract->id),
                    'edit_url' => route('landlord.contracts.update', $contract->id),
                    'view_url' => route('landlord.contracts.show', $contract->id),
                ];

                return [
                    $key + 1,
                    $contractDataForJs['tenant_name'],
                    $contractDataForJs['room_number'],
                    $contractDataForJs['start_date'],
                    $contractDataForJs['end_date'],
                    $contractDataForJs['rent_amount'],
                    $contractDataForJs['status'],
                    $contractDataForJs, // Pass the whole object for actions
                ];
            })->values()->all(),
        ) !!};

        // 2. GRIDJS SETUP: Columns updated for contracts
        new gridjs.Grid({
            columns: [
                { name: "#", width: "50px" },
                { name: "Tenant", width: "200px" },
                { name: "Room", width: "150px" },
                { name: "Start Date", width: "150px" },
                { name: "End Date", width: "150px" },
                { name: "Rent Amount", width: "150px" },
                {
                    name: "Status",
                    width: "120px",
                    formatter: (cell) => {
                        let badgeClass = 'secondary';
                        if (cell === 'active') badgeClass = 'success';
                        if (cell === 'expired') badgeClass = 'danger';
                        if (cell === 'terminated') badgeClass = 'warning';
                        return gridjs.html(`<span class="badge badge-soft-${badgeClass}">${cell}</span>`);
                    }
                },
                {
                    name: "Action",
                    width: "150px",
                    sort: false,
                    formatter: (_, row) => {
                        const actionData = row.cells[7].data;

                        const deleteButtonHtml = `
                            <button data-destroy-url="${actionData.destroy_url}"
                                    data-contract-info="for tenant ${actionData.tenant_name}"
                                    type="button"
                                    class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-contract"
                                    title="Delete"><i class="ti ti-trash"></i></button>`;

                        const editButtonHtml = `
                            <button class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-contract-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-contract-data='${JSON.stringify(actionData)}'
                                    role="button"
                                    title="Edit"><i class="ti ti-edit fs-16"></i></button>`;

                        return gridjs.html(`
                            <div class="hstack gap-1 justify-content-end">
                                <a href="${actionData.view_url}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle" title="View Contract"><i class="ti ti-eye"></i></a>
                                ${editButtonHtml}
                                ${deleteButtonHtml}
                            </div>`);
                    }
                }
            ],
            pagination: { limit: 10, summary: true },
            sort: true,
            search: true,
            data: contractsData,
            style: { table: { 'font-size': '0.85rem' } }
        }).render(document.getElementById("table-gridjs"));

        // 3. EVENT LISTENERS: Rewritten for contracts
        document.addEventListener('click', function (e) {
            // Delete Contract Handler
            const deleteButton = e.target.closest('.delete-contract');
            if (deleteButton) {
                const contractInfo = deleteButton.getAttribute('data-contract-info') || 'this contract';
                const actionUrl = deleteButton.getAttribute('data-destroy-url');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                Swal.fire({
                    title: "Are you sure?",
                    text: `Contract "${contractInfo}" will be permanently deleted! This action cannot be undone.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
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

            // Edit Contract Handler
            const editButton = e.target.closest('.edit-contract-btn');
            if (editButton) {
                const modal = $('#editModal');
                const contractData = JSON.parse(editButton.dataset.contractData);

                // Assuming your edit contract modal has these field IDs
                modal.find('#editContractId').val(contractData.id);
                modal.find('#edit_tenant_id').val(contractData.tenant_id).trigger('change');
                modal.find('#edit_room_id').val(contractData.room_id).trigger('change');
                modal.find('#edit_start_date').val(contractData.start_date);
                modal.find('#edit_end_date').val(contractData.end_date);
                modal.find('#edit_rent_amount').val(contractData.rent_amount);
                modal.find('#edit_billing_cycle').val(contractData.billing_cycle).trigger('change');
                modal.find('#edit_status').val(contractData.status).trigger('change');

                // Set the form action URL
                modal.find('#editContractForm').attr('action', contractData.edit_url);
            }
        });

        // 4. SELECT2 INITIALIZATION: Corrected and updated for contract modals
        $(function() {
            // Note: Your controller must pass $tenants and $rooms to the view for these dropdowns.
            $('#createModal .select2').select2({
                dropdownParent: $('#createModal'),
                placeholder: "Select an option",
                allowClear: true
            });

            $('#editModal .select2').select2({
                dropdownParent: $('#editModal'),
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
@endpush