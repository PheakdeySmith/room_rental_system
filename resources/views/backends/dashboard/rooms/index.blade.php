@extends('backends.layouts.app')


@push('style')
    {{-- {{ asset('assets') }}/css/ --}}
    <!-- gridjs css -->
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
                            <div class="position-relative">
                                <h4 class="header-title">Rooms Data</h4>
                            </div>

                            <div>
                                <a href="{{ route('rooms.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Add Room</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="table-gridjs">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('script')
    <!-- gridjs js -->
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>

    <script>
        const roomsData = {!! json_encode(
            $rooms->map(function ($room) {
                return [
                    $room->id,
                    $room->number,
                    $room->price,
                    $room->status,
                    '',
                ];
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
                        return gridjs.html(`
                <div class="hstack gap-1 justify-content-start">
                    <a href="/room/${id}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle"><i class="ti ti-eye"></i></a>
                    <a href="/room/${id}/edit" class="btn btn-soft-success btn-icon btn-sm rounded-circle"><i class="ti ti-edit fs-16"></i></a>
                    <button data-id="${id}" type="button" id="sweetalert-params" class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-room"><i class="ti ti-trash"></i></button>
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
    </script>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-post')) {
                const button = e.target.closest('.delete-post');
                const postId = button.getAttribute('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This post will be permanently deleted!",
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
                        // Submit a hidden form via POST method with CSRF token
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/rooms/${roomId}`;

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
    </script>
@endpush
