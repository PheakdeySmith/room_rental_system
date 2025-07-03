@extends('backends.layouts.app')

@push('style')
    {{--
    <link rel="stylesheet" href="{{ asset('assets/css/your-custom-styles.css') }}"> --}}
@endpush

@section('content')
    <div class="page-container">

        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Property Manager</h4>
            </div>
            <div class="text-end">
                {{-- This is the NEW and improved breadcrumb --}}
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('landlord.properties.show', $property->id) }}">{{ $property->name }}</a></li>
                    <li class="breadcrumb-item active" id="breadcrumb-active-tab">Overviews</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="d-flex">
                {{-- Left Sidebar / Tab Navigation --}}
                <div class="offcanvas-xl offcanvas-start file-manager" tabindex="-1" id="fileManagerSidebar"
                    aria-labelledby="fileManagerSidebarLabel">
                    <div class="d-flex flex-column">
                        <div class="py-2 px-3 flex-shrink-0 d-flex align-items-center gap-2 border-bottom border-dashed">
                            <div class="avatar-md">
                                <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/images/default_image.png') }}"
                                    alt="" class="img-fluid rounded-circle">
                            </div>
                            <div>
                                <h5 class="mb-1 fs-16 fw-semibold">{{ Auth::user()->name }} <i
                                        class="ti ti-rosette-discount-check-filled text-success" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Pro User"></i></h5>
                                <p class="fs-12 mb-0">Welcome!</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-icon btn-soft-danger ms-auto d-xl-none"
                                data-bs-dismiss="offcanvas" data-bs-target="#fileManagerSidebar" aria-label="Close">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <div class="p-3">
                            <div class="d-flex flex-column">
                                <button type="button"
                                    class="btn fw-medium btn-success drop-arrow-none dropdown-toggle w-100 mb-3">
                                    Create New <i class="ti ti-plus ms-1"></i>
                                </button>

                                <div class="nav flex-column nav-pills file-menu" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">

                                    <a class="list-group-item active" id="v-pills-overviews-tab" data-bs-toggle="pill"
                                        href="#v-pills-overviews" role="tab" aria-controls="v-pills-overviews"
                                        aria-selected="true">
                                        <i class="ti ti-building-community fs-18 align-middle me-2"></i>Overviews
                                    </a>

                                    <a class="list-group-item" id="v-pills-all-rooms-tab" data-bs-toggle="pill"
                                        href="#v-pills-all-rooms" role="tab" aria-controls="v-pills-all-rooms"
                                        aria-selected="true">
                                        <i class="ti ti-building-community fs-18 align-middle me-2"></i>Rooms
                                    </a>

                                    <a class="list-group-item" id="v-pills-utilities-tab" data-bs-toggle="pill"
                                        href="#v-pills-utilities" role="tab" aria-controls="v-pills-utilities"
                                        aria-selected="false">
                                        <i class="ti ti-bolt fs-18 align-middle me-2"></i>Utilities
                                    </a>

                                    <a class="list-group-item" id="v-pills-contracts-tab" data-bs-toggle="pill"
                                        href="#v-pills-contracts" role="tab" aria-controls="v-pills-contracts"
                                        aria-selected="false">
                                        <i class="ti ti-file-text fs-18 align-middle me-2"></i>Contracts
                                    </a>

                                    <a class="list-group-item" id="v-pills-deleted-tab" data-bs-toggle="pill"
                                        href="#v-pills-deleted" role="tab" aria-controls="v-pills-deleted"
                                        aria-selected="false">
                                        <i class="ti ti-trash fs-18 align-middle me-2"></i>Deleted Items
                                    </a>
                                </div>

                                <div class="mt-5 pt-5">
                                    <div class="alert alert-secondary p-3 pt-0 text-center mb-0" role="alert">
                                        <img src="{{ asset('assets') }}/images/panda.svg" alt=""
                                            class="img-fluid mt-n5" style="max-width: 135px;">
                                        <div>
                                            <h5 class="alert-heading fw-semibold fs-18 mt-2">Get more space for files</h5>
                                            <p>We offer you unlimited storage space for all you needs</p>
                                            <a href="!" class="btn btn-secondary">Upgrade to Pro</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side / Tab Content Panes --}}
                <div class="w-100 border-start">
                    <div class="tab-content p-3" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="v-pills-overviews" role="tabpanel"
                            aria-labelledby="v-pills-overviews-tab">

                            @include('backends.dashboard.properties.partials._overview_tab')

                        </div>

                        <div class="tab-pane fade" id="v-pills-all-rooms" role="tabpanel"
                            aria-labelledby="v-pills-all-rooms-tab">
                            @include('backends.dashboard.properties.partials._all_rooms_tab')
                        </div>

                        <div class="tab-pane fade" id="v-pills-utilities" role="tabpanel"
                            aria-labelledby="v-pills-utilities-tab">
                            @include('backends.dashboard.properties.partials._utilities_tab')
                        </div>

                        <div class="tab-pane fade" id="v-pills-contracts" role="tabpanel"
                            aria-labelledby="v-pills-contracts-tab">
                            @include('backends.dashboard.properties.partials._contracts_tab')
                        </div>

                        <div class="tab-pane fade" id="v-pills-deleted" role="tabpanel"
                            aria-labelledby="v-pills-deleted-tab">
                            @include('backends.dashboard.properties.partials._deleted_fields_tab')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Wait for the document to be fully loaded before running the script
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Select the element we want to update (our active breadcrumb item)
            const breadcrumbTarget = document.getElementById('breadcrumb-active-tab');

            // 2. Select all the tab trigger links
            const tabTriggers = document.querySelectorAll('#v-pills-tab a[data-bs-toggle="pill"]');

            // 3. Loop through each tab link and add an event listener
            tabTriggers.forEach(function(tabTrigger) {
                // We use Bootstrap's own event 'shown.bs.tab' which is more reliable than a 'click' event.
                // It fires after a tab has been successfully shown.
                tabTrigger.addEventListener('shown.bs.tab', function(event) {

                    // The 'event.target' is the tab link that was just clicked (e.g., the 'Contracts' <a> tag).

                    // We clone the element to safely manipulate it without affecting the original.
                    const tempNode = event.target.cloneNode(true);

                    // We find and remove the <i> icon from our clone.
                    if (tempNode.querySelector('i')) {
                        tempNode.querySelector('i').remove();
                    }

                    // Get the remaining clean text and trim any whitespace.
                    const cleanText = tempNode.textContent.trim();

                    // 4. Update the breadcrumb's text with the clean text from the tab.
                    breadcrumbTarget.textContent = cleanText;
                });
            });
        });
    </script>
@endpush
