@extends('backends.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mermaid.min.css">
    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Rooms Tables</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Boron</a></li>
                    <li class="breadcrumb-item active">Rooms Tables</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <h4 class="header-title">Rooms Data</h4>
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                                <i class="ti ti-plus me-1"></i>Add Room
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="table-gridjs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backends.dashboard.rooms.create')
    @include('backends.dashboard.rooms.edit')
@endsection

@push('script')
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>

    <script>
        const roomsData = {!! json_encode(
            $rooms->map(function ($room) {
                return [$room->id, $room->number, $room->price, $room->status];
            }),
        ) !!};

        const clearAndRenderGrid = (containerId, gridConfig) => {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = "";
                new gridjs.Grid(gridConfig).render(container);
            }
        };

        clearAndRenderGrid("table-gridjs", {
            columns: [{
                    name: "ID",
                    width: "80px",
                    formatter: e => gridjs.html(`<span class="fw-semibold">${e}</span>`)
                },
                {
                    name: "Number",
                    width: "300px"
                },
                {
                    name: "Price",
                    width: "300px"
                },
                {
                    name: "Status",
                    width: "100px",
                    formatter: (_, row) => {
                        const status = row.cells[3].data;
                        return gridjs.html(`
                            <span class="badge badge-soft-${status === 'active' ? 'success' : 'danger'}">${status}</span>
                        `);
                    }
                },
                {
                    name: "Action",
                    width: "150px",
                    formatter: (_, row) => {
                        const id = row.cells[0].data;
                        const number = row.cells[1].data;
                        const price = row.cells[2].data;

                        return gridjs.html(`
                            <div class="hstack gap-1 justify-content-start">
                                <a href="/room/${id}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="#" 
                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-room-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="${id}"
                                    data-number="${number}"
                                    data-price="${price}">
                                    <i class="ti ti-edit fs-16"></i>
                                </a>
                                <button data-id="${id}" type="button" class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-room">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        `);
                    }
                }
            ],
            pagination: {
                limit: 5
            },
            sort: true,
            search: true,
            data: roomsData
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-room')) {
                const button = e.target.closest('.delete-room');
                const postId = button.getAttribute('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This room will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton: "swal2-confirm btn btn-primary me-2 mt-2",
                        cancelButton: "swal2-cancel btn btn-danger mt-2",
                    },
                    buttonsStyling: false,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/landlord/rooms/${postId}`;

                        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = csrf;

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';

                        form.appendChild(token);
                        form.appendChild(method);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
    const editRoomForm = document.getElementById('editRoomForm');

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.edit-room-btn');
        if (button) {
            const roomId = button.getAttribute('data-id');
            const number = button.getAttribute('data-number');
            const price = button.getAttribute('data-price');

            // Set the form action to the correct update route
            editRoomForm.action = `/landlord/rooms/${roomId}`;
            document.getElementById('edit-number').value = number;
            document.getElementById('edit-price').value = price;
        }
    });
});
    </script>
@endpush
