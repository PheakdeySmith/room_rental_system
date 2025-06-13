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
                @if (Auth::check() && Auth::user()->hasRole('landlord'))
                    <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                        <i class="ti ti-plus me-1"></i>Add Room
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div
                            class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0 text-center align-items-center justify-content-center">
                            <div class="col border-end border-light border-dashed d-flex justify-content-center">

                                <div class="mt-3 mt-md-0 p-3">
                                    <h5 class="text-muted fs-13 text-uppercase" title="Number of Rooms">No. of Rooms</h5>
                                    <div class="d-flex align-items-center justify-content-center gap-2 my-3">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title bg-secondary-subtle text-secondary rounded-circle fs-22">
                                                <iconify-icon icon="solar:home-2-bold-duotone"></iconify-icon>
                                            </span>
                                        </div>
                                        <h3 class="mb-0 fw-bold">{{ $rooms->count() }}</h3>
                                    </div>
                                    <p class="mb-0 text-muted">
                                        <span class="text-nowrap">Total rooms in this property</span>
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header p-0">
                        <ul class="nav nav-tabs nav-bordered" role="tablist">
                            <li class="nav-item px-3" role="presentation">
                                <a href="#table" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2 active"
                                    aria-selected="false" role="tab" tabindex="-1">
                                    <span class="d-block d-sm-none"><iconify-icon icon="solar:notebook-bold"
                                            class="fs-20"></iconify-icon></span>
                                    <span class="d-none d-sm-block"><iconify-icon icon="solar:notebook-bold"
                                            class="fs-14 me-1 align-middle"></iconify-icon> Table</span>
                                </a>
                            </li>
                            <li class="nav-item px-3" role="presentation">
                                <a href="#element" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2"
                                    aria-selected="true" role="tab">
                                    <span class="d-block d-sm-none"><iconify-icon icon="solar:chat-dots-bold"
                                            class="fs-20"></iconify-icon></span>
                                    <span class="d-none d-sm-block"><iconify-icon icon="solar:chat-dots-bold"
                                            class="fs-14 me-1 align-middle"></iconify-icon> Element</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="table" role="tabpanel">

                                <div class="row">
                                    <div id="table-gridjs"></div>
                                </div>

                            </div>
                            <div class="tab-pane" id="element" role="tabpanel">
                                <div class="row g-2">
                                    <div class="row">

                                        @forelse ($rooms as $room)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card">

                                                    <div class="card-body border-top border-dashed mt-5">
                                                        {{-- Room Number --}}
                                                        <h5 class="text-primary fw-medium">Room Number :
                                                            {{ $room->room_number }}
                                                        </h5>

                                                        <div>
                                                            {{-- Property Name (assumes a 'property' relationship) --}}
                                                            <a href="#!"
                                                                class="fw-semibold fs-16 text-dark">{{ $room->property->name ?? 'N/A' }}</a>
                                                        </div>

                                                        {{-- Room Details --}}
                                                        <h5 class="my-1">Size : {{ $room->size }}m&sup2;</h5>
                                                        <h5 class="my-1">Floor : {{ $room->floor }}</h5>
                                                    </div>

                                                    <div
                                                        class="card-footer d-flex flex-wrap align-items-center justify-content-between border-top border-dashed">
                                                        {{-- Room Price --}}
                                                        <h4
                                                            class="fw-semibold text-danger d-flex align-items-center gap-2 mb-0">
                                                            ${{ number_format($room->price, 2) }}
                                                        </h4>

                                                        {{-- <a href="#!" class="btn btn-soft-primary px-2 fs-20">
                                                            <iconify-icon icon="solar:cart-3-bold-duotone"></iconify-icon>
                                                        </a> --}}
                                                    </div>

                                                    {{-- Favorite Button (static for now) --}}
                                                    <span class="position-absolute top-0 end-0 p-2">
                                                        <div data-toggler="on">
                                                            <button type="button" class="btn btn-icon btn-light rounded-circle"
                                                                data-toggler-on="">
                                                                <iconify-icon icon="solar:eye-bold-duotone"
                                                                    class="fs-22 text-danger"></iconify-icon>
                                                            </button>
                                                        </div>
                                                    </span>

                                                    {{-- Status Badge (with dynamic color) --}}
                                                    <span class="position-absolute top-0 start-0 p-2">
                                                        @if ($room->status == 'available')
                                                            <span class="badge bg-success fs-11">Available</span>
                                                        @elseif ($room->status == 'occupied')
                                                            <span class="badge bg-danger fs-11">Occupied</span>
                                                        @else
                                                            <span class="badge bg-warning fs-11">{{ ucfirst($room->status) }}</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            {{-- This message will be shown if there are no rooms --}}
                                            <div class="col-12">
                                                <p class="text-center text-muted mt-4">No rooms available to display.</p>
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <strong>Task 1:</strong> The ability to view room details is not yet active.
                        </div>
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

        $(function () {
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