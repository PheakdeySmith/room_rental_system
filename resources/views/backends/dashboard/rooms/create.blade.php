@extends('backends.layouts.app')
@push('style')
    <!-- Quill css -->
    <link href="{{ asset('assets') }}/css/quill.core.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/quill.snow.css" rel="stylesheet" type="text/css">

    <!-- One of the following themes -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/classic.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/monolith.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/nano.min.css">
@endpush


@section('content')
    <!-- Start Content-->
    <div class="page-container">

        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Add
                    Contracts</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Boron</a></li>

                    <li class="breadcrumb-item"><a href="">Contracts Table</a></li>

                    <li class="breadcrumb-item active">Add
                        Contract</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="{{ route('contracts.store') }}" method="POST">
                        @csrf
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="card-title">Contracts
                                Information</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">User</label>
                                        <select class="form-control" name="user_id" id="user_id" required>
                                            <option value="">Select User</option>
                                            <!-- Populate with users dynamically -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="room_id" class="form-label">Room</label>
                                        <select class="form-control" name="room_id" id="room_id" required>
                                            <option value="">Select Room</option>
                                            <!-- Populate with rooms dynamically -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option>Select Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top border-dashed text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <button type="submit" class="btn btn-primary">Create Contract</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <div class="col-lg-5">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <h4 class="card-title">Product Gallery</h4>
                        <p class="text-muted mb-0">You need at least
                            4 images. Pay attention to the quality
                            of the pictures you add (important)</p>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <form action="https://coderthemes.com/" method="post" class="dropzone dz-clickable"
                                id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                                data-upload-preview-template="#uploadPreviewTemplate">

                                <div class="dz-message needsclick">
                                    <i class="h1 ti ti-cloud-upload mb-4"></i>
                                    <h4>Drop files here or click to
                                        upload.</h4>
                                    <span class="text-muted fs-13">(This
                                        is just a demo dropzone.
                                        Selected files are
                                        <strong>not</strong>
                                        actually uploaded.)</span>
                                </div>
                            </form>

                            <!-- Preview -->
                            <div class="dropzone-previews mt-3" id="file-previews"></div>

                            <!-- file preview template -->
                            <div class="d-none" id="uploadPreviewTemplate">
                                <div class="card mt-1 mb-0 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img data-dz-thumbnail
                                                    src="{{ asset('assets') }}/images/apps-ecommerce-products-add.html"
                                                    class="avatar-sm rounded bg-light" alt>
                                            </div>
                                            <div class="col ps-0">
                                                <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                                <p class="mb-0" data-dz-size></p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                <a href="https://coderthemes.com/boron/layouts/apps-ecommerce-products-add.html"
                                                    class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                    <i class="ti ti-x"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end file preview template -->
                        </div>
                    </div>
                    <div class="card-footer border-top border-dashed text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="https://coderthemes.com/boron/layouts/apps-ecommerce-products-add.html#!"
                                class="btn btn-primary">Create
                                Product</a>
                            <a href="https://coderthemes.com/boron/layouts/apps-ecommerce-products-add.html#!"
                                class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </div> <!-- container -->
@endsection
@push('script')
    <!-- Dropzone File Upload js -->
    <script src="{{ asset('assets') }}/js/dropzone-min.js"></script>

    <script src="{{ asset('assets') }}/js/quill.min.js"></script>

    <!-- Modern colorpicker bundle js -->
    <script src="{{ asset('assets') }}/js/pickr.min.js"></script>

    <input type="file" multiple="multiple" class="dz-hidden-input" tabindex="-1"
        style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const submitBtn = form.querySelector("button[type='submit']");

            form.addEventListener("submit", function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Submitting...';
            });
        });
    </script>
@endpush
