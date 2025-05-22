@extends('backends.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mermaid.min.css">
    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- Quill css -->
    <link href="{{ asset('assets') }}/css/quill.core.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.snow.css" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets') }}/css/classic.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/monolith.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/nano.min.css" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- One of the following themes -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/classic.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/monolith.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/nano.min.css">
@endpush

@section('content')
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Users Tables</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Boron</a></li>
                    <li class="breadcrumb-item active">Users Tables</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <h4 class="header-title">Users Data</h4>
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#createModal" role="button">
                                <i class="ti ti-plus me-1"></i>Add User
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

    @include('backends.dashboard.users.create')
    {{-- @include('backends.dashboard.users.edit') --}}
@endsection

@push('script')
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- Dropzone File Upload js -->
    <script src="{{ asset('assets') }}/js/dropzone-min.js"></script>

    <script src="{{ asset('assets') }}/js/quill.min.js"></script>

    <!-- Modern colorpicker bundle js -->
    <script src="{{ asset('assets') }}/js/pickr.min.js"></script>

    <script src="{{ asset('assets') }}/js/ecommerce-add-products.js"></script>
    <script src="{{ asset('assets') }}/js/wizard.min.js"></script>
    <script src="{{ asset('assets') }}/js/form-wizard.js"></script>

    <script>
        const usersData = {!! json_encode(
            $users->map(function ($user) {
                return [$user->id, $user->image, $user->name, $user->email, $user->phone, $user->status];
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
                    width: "50px",
                    formatter: e => gridjs.html(`<span class="fw-semibold">${e}</span>`)
                },
                {
                    name: "Image",
                    width: "100px",
                    formatter: (_, row) => {
                        const imagePath = row.cells[1].data;
                        const imageUrl = imagePath ?
                            `/storage/${imagePath}` :
                            `/assets/images/avatar-2.jpg`;

                        return gridjs.html(`
                    <div class="avatar-md">
                        <img src="${imageUrl}" alt="User" class="img-fluid rounded-2" />
                    </div>
                `);
                    }
                },
                {
                    name: "Name",
                    width: "100px"
                },
                {
                    name: "Email",
                    width: "200px"
                },
                {
                    name: "Phone",
                    width: "150px"
                },
                {
                    name: "Status",
                    width: "100px",
                    formatter: (_, row) => {
                        const status = row.cells[5].data;
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
                        const image = row.cells[1].data;
                        const name = row.cells[2].data;
                        const email = row.cells[3].data;
                        const phone = row.cells[4].data;
                        const status = row.cells[5].data;

                        return gridjs.html(`
                                            <div class="hstack gap-1 justify-content-start">
                                                <a href="/user/${id}" class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="#" 
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-user-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal"
                                                    data-id="${id}"
                                                    data-image="${image}"
                                                    data-name="${name}"
                                                    data-email="${email}"
                                                    data-phone="${phone}"
                                                    data-status="${status}">
                                                    <i class="ti ti-edit fs-16"></i>
                                                </a>
                                                <button data-id="${id}" type="button" class="btn btn-soft-danger btn-icon btn-sm rounded-circle delete-user">
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
            data: usersData
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-user')) {
                const button = e.target.closest('.delete-user');
                const postId = button.getAttribute('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This user will be permanently deleted!",
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
                        form.action = `/landlord/users/${postId}`;

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

        document.addEventListener('DOMContentLoaded', function() {

            const editUserForm = document.getElementById('editUserForm');

            document.addEventListener('click', function(e) {
                const button = e.target.closest('.edit-user-btn');
                if (button) {
                    const userId = button.getAttribute('data-id');
                    const number = button.getAttribute('data-number');
                    const price = button.getAttribute('data-price');

                    // Set the form action to the correct update route
                    editUserForm.action = `/landlord/users/${userId}`;
                    document.getElementById('edit-number').value = number;
                    document.getElementById('edit-price').value = price;
                }
            });
        });

        $(function() {
            $('#status').select2({
                dropdownParent: $('#createModal')
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wizardEl = document.querySelector('#basicwizard');
            if (wizardEl) {
                new Wizard(wizardEl, {
                    validate: true,
                    buttons: true,
                    progress: true
                });
            }
        });
    </script>
@endpush
