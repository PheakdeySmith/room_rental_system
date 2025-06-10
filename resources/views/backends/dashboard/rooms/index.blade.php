@extends('backends.layouts.app')

@section('title', 'Rooms | RoomGate')


@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mermaid.min.css">
    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.core.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.snow.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/classic.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/monolith.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/nano.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Rooms Table</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Boron</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <h4 class="header-title">Rooms Data</h4>
                            @if (Auth::check() && Auth::user()->hasRole('landlord'))
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                                    <i class="ti ti-plus me-1"></i>Add Room
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

    @if (Auth::check() && Auth::user()->hasRole('landlord'))
        @include('backends.dashboard.rooms.create')
        @include('backends.dashboard.rooms.edit')
    @endif
@endsection

@push('script')
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/dropzone-min.js"></script>
    <script src="{{ asset('assets') }}/js/quill.min.js"></script>
    <script src="{{ asset('assets') }}/js/pickr.min.js"></script>
    <script src="{{ asset('assets') }}/js/ecommerce-add-products.js"></script>

    <script>
        const roomsData = {!! json_encode(
        $rooms->map(function ($room, $key) {
            $roomDataForJs = [
                'id' => $room->id,
                'property_id' => $room->property_id,
                'room_type_id' => $room->room_type_id,
                'room_number' => $room->room_number ?? 'N/A',
                'property_name' => $room->property->name ?? 'N/A',
                'room_type_name' => $room->roomType->name ?? 'N/A',
                'description' => $room->description ?? 'N/A',
                'size' => $room->size ?? 'N/A',
                'floor' => $room->floor ?? 'N/A',
                'status' => $room->status ?? 'N/A',
                'destroy_url' => route('landlord.rooms.destroy', $room->id),
                'edit_url' => route('landlord.rooms.update', $room->id),
                'view_url' => route('landlord.rooms.show', $room->id),
            ];

            return [
                $key + 1,
                $roomDataForJs['room_number'],
                $roomDataForJs['property_name'],
                $roomDataForJs['room_type_name'],
                $roomDataForJs['description'],
                $roomDataForJs['size'],
                $roomDataForJs['floor'],
                $roomDataForJs['status'],
                $roomDataForJs,
            ];
        })->values()->all(),
    ) !!};

        new gridjs.Grid({
            columns: [
                { name: "#", width: "50px" },
                { name: "Room Number", width: "150px" },
                { name: "Property", width: "150px" },
                { name: "Room Type", width: "150px" },
                { name: "Description", width: "200px" },
                { name: "Size", width: "120px" },
                { name: "Floor", width: "100px" },
                {
                    name: "Status",
                    width: "120px",
                    formatter: (cell) => {
                        return gridjs.html(
                            `<span class="badge badge-soft-${cell === 'available' ? 'success' : 'danger'}">${cell}</span>`
                        );
                    }
                },
                {
                    name: "Action",
                    width: "150px",
                    sort: false,
                    formatter: (_, row) => {
                        const actionData = row.cells[8].data;

                        const deleteButtonHtml = `
                                <button data-destroy-url="${actionData.destroy_url}"
                                        data-room-number="${actionData.room_number}"
                                        type="button"
                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-room"
                                        title="Delete"><i class="ti ti-trash"></i></button>`;

                        const editButtonHtml = `
                                <button class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-room-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-room-data='${JSON.stringify(actionData)}'
                                        role="button"
                                        title="Edit"><i class="ti ti-edit fs-16"></i></button>`;

                        return gridjs.html(`
                                <div class="hstack gap-1 justify-content-end">
                                    <a href="${actionData.view_url}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle" title="View Room"><i class="ti ti-eye"></i></a>
                                    ${editButtonHtml}
                                    ${deleteButtonHtml}
                                </div>`);
                    }
                }
            ],
            pagination: { limit: 10, summary: true },
            sort: true,
            search: true,
            data: roomsData,
            style: { table: { 'font-size': '0.85rem' } }
        }).render(document.getElementById("table-gridjs"));

        document.addEventListener('click', function (e) {
            const deleteButton = e.target.closest('.delete-room');
            if (deleteButton) {
                const roomNumber = deleteButton.getAttribute('data-room-number') || 'this room';
                const actionUrl = deleteButton.getAttribute('data-destroy-url');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                Swal.fire({
                    title: "Are you sure?",
                    text: `Room "${roomNumber}" will be permanently deleted! This action cannot be undone.`,
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

            const editButton = e.target.closest('.edit-room-btn');
            if (editButton) {
                const modal = $('#editModal');
                const roomData = JSON.parse(editButton.dataset.roomData);

                modal.find('#editRoomId').val(roomData.id);

                modal.find('#edit_property_id').val(roomData.property_id).trigger('change');
                modal.find('#edit_room_type_id').val(roomData.room_type_id).trigger('change');

                modal.find('#editRoomNumber').val(roomData.room_number);
                modal.find('#editDescription').val(roomData.description);
                modal.find('#editSize').val(roomData.size);
                modal.find('#editFloor').val(roomData.floor);
                modal.find('#editStatus').val(roomData.status).trigger('change');

                modal.find('#editRoomForm').attr('action', roomData.edit_url);
            }
        });

        $(function() {
            $('#status, #property_id, #room_type_id').select2({
                dropdownParent: $('#createModal'),
                placeholder: "Select an option",
                allowClear: true
            });

            $('#editStatusm, #edit_property_id, $edit_room_type_id').select2({
                dropdownParent: $('#editModal'),
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
@endpush