@extends('backends.layouts.app')

@section('title', 'Dashboard | RoomGate')

@push('style')
@endpush



@section('content')
    <div class="page-container">

        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 text-uppercase fw-bold m-0">{{ __('messages.dashboard') }}</h4>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <form action="javascript:void(0);">
                            <div class="row g-2 mb-0 align-items-center">
                                <div class="col-auto">
                                    <a href="javascript: void(0);" class="btn btn-outline-primary">
                                        <i class="ti ti-sort-ascending me-1"></i> Sort By
                                    </a>
                                </div>
                                <!--end col-->
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input type="text" class="form-control flatpickr-input" data-provider="flatpickr"
                                            data-deafult-date="01 May to 31 May" data-date-format="d M"
                                            data-range-date="true" readonly="readonly">
                                        <span class="input-group-text bg-primary border-primary text-white">
                                            <i class="ti ti-calendar fs-15"></i>
                                        </span>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div> <!-- end row-->

        <div class="row">
            <div class="col">
                <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 text-center">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Total Orders</h5>
                                <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                    <div class="user-img fs-42 flex-shrink-0">
                                        <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                            <iconify-icon icon="solar:case-round-minimalistic-bold-duotone"><template
                                                    shadowrootmode="open">
                                                    <style data-style="data-style">
                                                        :host {
                                                            display: inline-block;
                                                            vertical-align: 0
                                                        }

                                                        span,
                                                        svg {
                                                            display: block
                                                        }
                                                    </style><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                        height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" fill-rule="evenodd"
                                                            d="M9.878 4.25a2.251 2.251 0 0 1 4.244 0a.75.75 0 1 0 1.414-.5a3.751 3.751 0 0 0-7.073 0a.75.75 0 1 0 1.415.5m-7.13 3.84a.8.8 0 0 0-.168-.081c.153-.318.347-.594.591-.838C4.343 6 6.23 6 10 6h4c3.771 0 5.657 0 6.828 1.172a3 3 0 0 1 .592.838a.8.8 0 0 0-.167.081c-2.1 1.365-3.42 2.22-4.517 2.767A.75.75 0 0 0 15.25 11v.458c-2.12.64-4.38.64-6.5 0V11a.75.75 0 0 0-1.487-.142C6.167 10.31 4.847 9.456 2.747 8.09"
                                                            clip-rule="evenodd"></path>
                                                        <path fill="currentColor"
                                                            d="M2 14c0-1.95 0-3.397.162-4.5c2.277 1.48 3.736 2.423 5.088 3.004V13a.75.75 0 0 0 1.5.016c2.13.562 4.37.562 6.5 0a.75.75 0 0 0 1.5-.016v-.495c1.352-.582 2.811-1.525 5.088-3.005C22 10.604 22 12.05 22 14c0 3.771 0 5.657-1.172 6.828S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14"
                                                            opacity=".5"></path>
                                                    </svg>
                                                </template></iconify-icon>
                                        </span>
                                    </div>
                                    <h3 class="mb-0 fw-bold">687.3k</h3>
                                </div>
                                <p class="mb-0 text-muted">
                                    <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 9.19%</span>
                                    <span class="text-nowrap">Since last month</span>
                                </p>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Total Returns</h5>
                                <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                    <div class="user-img fs-42 flex-shrink-0">
                                        <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                            <iconify-icon icon="solar:bill-list-bold-duotone"><template
                                                    shadowrootmode="open">
                                                    <style data-style="data-style">
                                                        :host {
                                                            display: inline-block;
                                                            vertical-align: 0
                                                        }

                                                        span,
                                                        svg {
                                                            display: block
                                                        }
                                                    </style><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                        height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2"
                                                            opacity=".5"></path>
                                                        <path fill="currentColor"
                                                            d="M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z">
                                                        </path>
                                                    </svg>
                                                </template></iconify-icon>
                                        </span>
                                    </div>
                                    <h3 class="mb-0 fw-bold">9.62k</h3>
                                </div>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 26.87%</span>
                                    <span class="text-nowrap">Since last month</span>
                                </p>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Avg. Sales Earnings
                                </h5>
                                <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                    <div class="user-img fs-42 flex-shrink-0">
                                        <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                            <iconify-icon icon="solar:wallet-money-bold-duotone"><template
                                                    shadowrootmode="open">
                                                    <style data-style="data-style">
                                                        :host {
                                                            display: inline-block;
                                                            vertical-align: 0
                                                        }

                                                        span,
                                                        svg {
                                                            display: block
                                                        }
                                                    </style><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                        height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M4.892 9.614c0-.402.323-.728.722-.728H9.47c.4 0 .723.326.723.728a.726.726 0 0 1-.723.729H5.614a.726.726 0 0 1-.722-.729">
                                                        </path>
                                                        <path fill="currentColor" fill-rule="evenodd"
                                                            d="M21.188 10.004q-.094-.005-.2-.004h-2.773C15.944 10 14 11.736 14 14s1.944 4 4.215 4h2.773q.106.001.2-.004c.923-.056 1.739-.757 1.808-1.737c.004-.064.004-.133.004-.197v-4.124c0-.064 0-.133-.004-.197c-.069-.98-.885-1.68-1.808-1.737m-3.217 5.063c.584 0 1.058-.478 1.058-1.067c0-.59-.474-1.067-1.058-1.067s-1.06.478-1.06 1.067c0 .59.475 1.067 1.06 1.067"
                                                            clip-rule="evenodd"></path>
                                                        <path fill="currentColor"
                                                            d="M21.14 10.002c0-1.181-.044-2.448-.798-3.355a4 4 0 0 0-.233-.256c-.749-.748-1.698-1.08-2.87-1.238C16.099 5 14.644 5 12.806 5h-2.112C8.856 5 7.4 5 6.26 5.153c-1.172.158-2.121.49-2.87 1.238c-.748.749-1.08 1.698-1.238 2.87C2 10.401 2 11.856 2 13.694v.112c0 1.838 0 3.294.153 4.433c.158 1.172.49 2.121 1.238 2.87c.749.748 1.698 1.08 2.87 1.238c1.14.153 2.595.153 4.433.153h2.112c1.838 0 3.294 0 4.433-.153c1.172-.158 2.121-.49 2.87-1.238q.305-.308.526-.66c.45-.72.504-1.602.504-2.45l-.15.001h-2.774C15.944 18 14 16.264 14 14s1.944-4 4.215-4h2.773q.079 0 .151.002"
                                                            opacity=".5"></path>
                                                        <path fill="currentColor"
                                                            d="M10.101 2.572L8 3.992l-1.733 1.16C7.405 5 8.859 5 10.694 5h2.112c1.838 0 3.294 0 4.433.153q.344.045.662.114L16 4l-2.113-1.428a3.42 3.42 0 0 0-3.786 0">
                                                        </path>
                                                    </svg>
                                                </template></iconify-icon>
                                        </span>
                                    </div>
                                    <h3 class="mb-0 fw-bold">$98.24 <small class="text-muted">USD</small></h3>
                                </div>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 3.51%</span>
                                    <span class="text-nowrap">Since last month</span>
                                </p>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Number of Visits</h5>
                                <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                    <div class="user-img fs-42 flex-shrink-0">
                                        <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                            <iconify-icon icon="solar:eye-bold-duotone"><template shadowrootmode="open">
                                                    <style data-style="data-style">
                                                        :host {
                                                            display: inline-block;
                                                            vertical-align: 0
                                                        }

                                                        span,
                                                        svg {
                                                            display: block
                                                        }
                                                    </style><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                        height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12"
                                                            opacity=".5"></path>
                                                        <path fill="currentColor" fill-rule="evenodd"
                                                            d="M8.25 12a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0m1.5 0a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </template></iconify-icon>
                                        </span>
                                    </div>
                                    <h3 class="mb-0 fw-bold">87.94M</h3>
                                </div>
                                <p class="mb-0 text-muted">
                                    <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 1.05%</span>
                                    <span class="text-nowrap">Since last month</span>
                                </p>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-xxl-4">
                        <div class="card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center border-bottom border-dashed">
                                <h4 class="header-title">Top Traffic by Source</h4>
                                <div class="dropdown">
                                    <a href="https://coderthemes.com/boron/layouts/index.html#"
                                        class="dropdown-toggle drop-arrow-none card-drop p-0" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="multiple-radialbar" class="apex-charts"
                                    data-colors="#6ac75a,#313a46,#ce7e7e,#669776" style="min-height: 288.7px;">
                                </div>

                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <div>
                                                <i class="ti ti-circle-filled fs-12 align-middle me-1 text-primary"></i>
                                                <span class="align-middle fw-semibold">Direct</span>
                                            </div>
                                            <span class="fw-semibold text-muted float-end"><i
                                                    class="ti ti-arrow-badge-down text-danger"></i> 965</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <div>
                                                <i class="ti ti-circle-filled fs-12 text-success align-middle me-1"></i>
                                                <span class="align-middle fw-semibold">Social</span>
                                            </div>
                                            <span class="fw-semibold text-muted float-end"><i
                                                    class="ti ti-arrow-badge-up text-success"></i> 75</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <div>
                                                <i class="ti ti-circle-filled fs-12 text-secondary align-middle me-1"></i>
                                                <span class="align-middle fw-semibold"> Marketing</span>
                                            </div>
                                            <span class="fw-semibold text-muted float-end"><i
                                                    class="ti ti-arrow-badge-up text-success"></i> 102</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <div>
                                                <i class="ti ti-circle-filled fs-12 text-danger align-middle me-1"></i>
                                                <span class="align-middle fw-semibold">Affiliates</span>
                                            </div>
                                            <span class="fw-semibold text-muted float-end"><i
                                                    class="ti ti-arrow-badge-down text-danger"></i> 96</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xxl-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="header-title">Overview</h4>
                                <div class="dropdown">
                                    <a href="https://coderthemes.com/boron/layouts/index.html#"
                                        class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-danger bg-opacity-10">
                                <div class="row text-center">
                                    <div class="col-md-3 col-6">
                                        <p class="text-muted mt-3 mb-1">Revenue</p>
                                        <h4 class="mb-3">
                                            <span class="ti ti-square-rounded-arrow-down text-success me-1"></span>
                                            <span>$29.5k</span>
                                        </h4>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <p class="text-muted mt-3 mb-1">Expenses</p>
                                        <h4 class="mb-3">
                                            <span class="ti ti-square-rounded-arrow-up text-danger me-1"></span>
                                            <span>$15.07k</span>
                                        </h4>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <p class="text-muted mt-3 mb-1">Investment</p>
                                        <h4 class="mb-3">
                                            <span class="ti ti-chart-infographic me-1"></span>
                                            <span>$3.6k</span>
                                        </h4>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <p class="text-muted mt-3 mb-1">Savings</p>
                                        <h4 class="mb-3">
                                            <span class="ti ti-pig me-1"></span>
                                            <span>$6.9k</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div dir="ltr">
                                    <div id="revenue-chart" class="apex-charts"
                                        data-colors="#6ac75a,#313a46,#ce7e7e,#669776" style="min-height: 315px;">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="header-title">Brands Listing</h4>
                                <a href="javascript:void(0);" class="btn btn-sm btn-secondary">Add Brand <i
                                        class="ti ti-plus ms-1"></i></a>
                            </div>
                            <div class="card-body p-0">
                                <div class="bg-success bg-opacity-10 py-1 text-center">
                                    <p class="m-0"><b>69</b> Active brands out of <span class="fw-medium">102</span>
                                    </p>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-md flex-shrink-0 me-2">
                                                            <span class="avatar-title bg-primary-subtle rounded-circle">
                                                                <img src="{{ asset('assets') }}/images/logo-1.svg"
                                                                    alt="" height="22">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-12">Clothing</span> <br>
                                                            <h5 class="fs-14 mt-1">Zaroan - Brazil</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Established</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">Since 2020</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Stores</span> <br>
                                                    <h5 class="fs-14 mt-1 fw-normal">1.5k</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Products</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">8,950</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Status</span>
                                                    <h5 class="fs-14 mt-1 fw-normal"><i
                                                            class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                            class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                Report</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Export
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-md flex-shrink-0 me-2">
                                                            <span class="avatar-title bg-info-subtle rounded-circle">
                                                                <img src="{{ asset('assets') }}/images/logo-4.svg"
                                                                    alt="" height="22">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-12">Clothing</span> <br>
                                                            <h5 class="fs-14 mt-1">Jocky-Johns - USA</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Established</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">Since 1985</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Stores</span> <br>
                                                    <h5 class="fs-14 mt-1 fw-normal">205</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Products</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">1,258</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Status</span>
                                                    <h5 class="fs-14 mt-1 fw-normal"><i
                                                            class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                            class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                Report</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Export
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-md flex-shrink-0 me-2">
                                                            <span class="avatar-title bg-secondary-subtle rounded-circle">
                                                                <img src="{{ asset('assets') }}/images/logo-5.svg"
                                                                    alt="" height="22">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-12">Lifestyle</span> <br>
                                                            <h5 class="fs-14 mt-1">Ginne - India</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Established</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">Since 2001</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Stores</span> <br>
                                                    <h5 class="fs-14 mt-1 fw-normal">89</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Products</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">338</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Status</span>
                                                    <h5 class="fs-14 mt-1 fw-normal"><i
                                                            class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                            class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                Report</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Export
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-md flex-shrink-0 me-2">
                                                            <span class="avatar-title bg-danger-subtle rounded-circle">
                                                                <img src="{{ asset('assets') }}/images/logo-6.svg"
                                                                    alt="" height="22">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-12">Fashion</span> <br>
                                                            <h5 class="fs-14 mt-1">DDoen - Brazil</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Established</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">Since 1995</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Stores</span> <br>
                                                    <h5 class="fs-14 mt-1 fw-normal">650</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Products</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">6,842</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Status</span>
                                                    <h5 class="fs-14 mt-1 fw-normal"><i
                                                            class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                            class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                Report</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Export
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-md flex-shrink-0 me-2">
                                                            <span class="avatar-title bg-primary-subtle rounded-circle">
                                                                <img src="{{ asset('assets') }}/images/logo-8.svg"
                                                                    alt="" height="22">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-12">Manufacturing</span> <br>
                                                            <h5 class="fs-14 mt-1">Zoddiak - Canada</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Established</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">Since 1963</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Stores</span> <br>
                                                    <h5 class="fs-14 mt-1 fw-normal">109</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Products</span>
                                                    <h5 class="fs-14 mt-1 fw-normal">952</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-12">Status</span>
                                                    <h5 class="fs-14 mt-1 fw-normal"><i
                                                            class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                            class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                Report</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Export
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end card-body-->

                            <div class="card-footer border-0">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">5</span> of <span
                                                class="fw-semibold">15</span> Results
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                            <li class="page-item disabled">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link"><i class="ti ti-chevron-left"></i></a>
                                            </li>
                                            <li class="page-item active">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link"><i class="ti ti-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> <!-- -->
                            </div>

                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xxl-6">
                        <div class="card">
                            <div
                                class="card-header d-flex flex-wrap align-items-center gap-2 border-bottom border-dashed">
                                <h4 class="header-title me-auto">Top Selling Products</h4>

                                <div class="d-flex gap-2 justify-content-end text-end">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary">Import <i
                                            class="ti ti-download ms-1"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary">Export <i
                                            class="ti ti-file-export ms-1"></i></a>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-custom align-middle table-nowrap table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="avatar-lg">
                                                        <img src="{{ asset('assets') }}/images/p-1.png" alt="Product-1"
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                </td>
                                                <td class="ps-0">
                                                    <h5 class="fs-14 my-1"><a
                                                            href="https://coderthemes.com/boron/layouts/apps-ecommerce-product-details.html"
                                                            class="link-reset">ASOS High Waist Tshirt</a></h5>
                                                    <span class="text-muted fs-12">07 April 2024</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">$79.49</h5>
                                                    <span class="text-muted fs-12">Price</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">82</h5>
                                                    <span class="text-muted fs-12">Quantity</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="me-2">
                                                            <h5 class="fs-14 my-1">$6,518.18</h5>
                                                            <span class="text-muted fs-12">Amount</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="avatar-lg">
                                                        <img src="{{ asset('assets') }}/images/p-7.png" alt="Product-1"
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                </td>
                                                <td class="ps-0">
                                                    <h5 class="fs-14 my-1"><a
                                                            href="https://coderthemes.com/boron/layouts/apps-ecommerce-product-details.html"
                                                            class="link-reset">Marco Single Sofa</a></h5>
                                                    <span class="text-muted fs-12">25 March 2024</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">$128.50</h5>
                                                    <span class="text-muted fs-12">Price</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">37</h5>
                                                    <span class="text-muted fs-12">Quantity</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="me-2">
                                                            <h5 class="fs-14 my-1">$4,754.50</h5>
                                                            <span class="text-muted fs-12">Amount</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="avatar-lg">
                                                        <img src="{{ asset('assets') }}/images/p-4.png" alt="Product-1"
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                </td>
                                                <td class="ps-0">
                                                    <h5 class="fs-14 my-1"><a
                                                            href="https://coderthemes.com/boron/layouts/apps-ecommerce-product-details.html"
                                                            class="link-reset">Smart Headphone </a></h5>
                                                    <span class="text-muted fs-12">17 March 2024</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">$39.99</h5>
                                                    <span class="text-muted fs-12">Price</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">64</h5>
                                                    <span class="text-muted fs-12">Quantity</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="me-2">
                                                            <h5 class="fs-14 my-1">$2,559.36</h5>
                                                            <span class="text-muted fs-12">Amount</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="avatar-lg">
                                                        <img src="{{ asset('assets') }}/images/p-5.png" alt="Product-1"
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                </td>
                                                <td class="ps-0">
                                                    <h5 class="fs-14 my-1"><a
                                                            href="https://coderthemes.com/boron/layouts/apps-ecommerce-product-details.html"
                                                            class="link-reset">Lightweight Jacket</a></h5>
                                                    <span class="text-muted fs-12">12 March 2024</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">$20.00</h5>
                                                    <span class="text-muted fs-12">Price</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">184</h5>
                                                    <span class="text-muted fs-12">Quantity</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="me-2">
                                                            <h5 class="fs-14 my-1">$3,680.00</h5>
                                                            <span class="text-muted fs-12">Amount</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="avatar-lg">
                                                        <img src="{{ asset('assets') }}/images/p-6.png" alt="Product-1"
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                </td>
                                                <td class="ps-0">
                                                    <h5 class="fs-14 my-1"><a
                                                            href="https://coderthemes.com/boron/layouts/apps-ecommerce-product-details.html"
                                                            class="link-reset">Marco Shoes</a></h5>
                                                    <span class="text-muted fs-12">05 March 2024</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">$28.49</h5>
                                                    <span class="text-muted fs-12">Price</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 my-1">69</h5>
                                                    <span class="text-muted fs-12">Quantity</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="me-2">
                                                            <h5 class="fs-14 my-1">$1,965.81</h5>
                                                            <span class="text-muted fs-12">Amount</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end card-body-->

                            <div class="card-footer border-0">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">5</span> of <span
                                                class="fw-semibold">10</span> Results
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                            <li class="page-item disabled">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link"><i class="ti ti-chevron-left"></i></a>
                                            </li>
                                            <li class="page-item active">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="https://coderthemes.com/boron/layouts/index.html#"
                                                    class="page-link"><i class="ti ti-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> <!-- -->
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

            </div> <!-- end col-->

            <div class="col-auto info-sidebar">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <h4 class="header-title">Recent Orders:</h4>
                            <div>
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary rounded-circle btn-icon"><i
                                        class="ti ti-plus"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 position-relative mb-2">
                            <div class="avatar-md flex-shrink-0">
                                <img src="{{ asset('assets') }}/images/p-6.png" alt="product-pic" height="36">
                            </div>
                            <div>
                                <h5 class="fs-14 my-1"><a
                                        href="https://coderthemes.com/boron/layouts/apps-ecommerce-order-details.html"
                                        class="stretched-link link-reset">Marco Shoes</a></h5>
                                <span class="text-muted fs-12">$29.99 x 1 = $29.99</span>
                            </div>
                            <div class="ms-auto">
                                <span class="badge badge-soft-success px-2 py-1">Sold</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 position-relative mb-2">
                            <div class="avatar-md flex-shrink-0">
                                <img src="{{ asset('assets') }}/images/p-1.png" alt="product-pic" height="36">
                            </div>
                            <div>
                                <h5 class="fs-14 my-1"><a
                                        href="https://coderthemes.com/boron/layouts/apps-ecommerce-order-details.html"
                                        class="stretched-link link-reset">High Waist Tshirt</a></h5>
                                <span class="text-muted fs-12">$9.99 x 3 = $29.97</span>
                            </div>
                            <div class="ms-auto">
                                <span class="badge badge-soft-success px-2 py-1">Sold</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 position-relative mb-2">
                            <div class="avatar-md flex-shrink-0">
                                <img src="{{ asset('assets') }}/images/p-3.png" alt="product-pic" height="36">
                            </div>
                            <div>
                                <h5 class="fs-14 my-1"><a
                                        href="https://coderthemes.com/boron/layouts/apps-ecommerce-order-details.html"
                                        class="stretched-link link-reset">Comfirt Chair</a></h5>
                                <span class="text-muted fs-12">$49.99 x 1 = $49.99</span>
                            </div>
                            <div class="ms-auto">
                                <span class="badge badge-soft-danger px-2 py-1">Return</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 position-relative mb-2">
                            <div class="avatar-md flex-shrink-0">
                                <img src="{{ asset('assets') }}/images/p-4.png" alt="product-pic" height="36">
                            </div>
                            <div>
                                <h5 class="fs-14 my-1"><a
                                        href="https://coderthemes.com/boron/layouts/apps-ecommerce-order-details.html"
                                        class="stretched-link link-reset">Smart Headphone</a></h5>
                                <span class="text-muted fs-12">$39.99 x 1 = $39.99</span>
                            </div>
                            <div class="ms-auto">
                                <span class="badge badge-soft-success px-2 py-1">Sold</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 position-relative">
                            <div class="avatar-md flex-shrink-0">
                                <img src="{{ asset('assets') }}/images/p-2.png" alt="product-pic" height="36">
                            </div>
                            <div>
                                <h5 class="fs-14 my-1"><a
                                        href="https://coderthemes.com/boron/layouts/apps-ecommerce-order-details.html"
                                        class="stretched-link link-reset">Laptop Bag</a></h5>
                                <span class="text-muted fs-12">$12.99 x 4 = $51.96</span>
                            </div>
                            <div class="ms-auto">
                                <span class="badge badge-soft-success px-2 py-1">Sold</span>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="https://coderthemes.com/boron/layouts/index.html#!"
                                class="text-decoration-underline fw-semibold ms-auto link-offset-2 link-dark">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0 border-top border-dashed">
                        <h4 class="header-title px-3 mb-2 mt-3">Recent Activity:</h4>
                        <div class="my-3 px-3 simplebar-scrollable-y" data-simplebar="init"
                            style="max-height: 370px;">
                            <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content"
                                            style="height: auto; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px 24px;">
                                                <div class="timeline-alt py-0">
                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-basket bg-info-subtle text-info timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">You sold an
                                                                item</a>
                                                            <span class="mb-1">Paul Burgess just purchased “My - Admin
                                                                Dashboard”!</span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">5 minutes ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-rocket bg-primary-subtle text-primary timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">Product on the
                                                                Theme Market</a>
                                                            <span class="mb-1">Reviewer added
                                                                <span class="fw-medium">Admin Dashboard</span>
                                                            </span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">30 minutes ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-message bg-info-subtle text-info timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">Robert
                                                                Delaney</a>
                                                            <span class="mb-1">Send you message
                                                                <span class="fw-medium">"Are you there?"</span>
                                                            </span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">2 hours ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-photo bg-primary-subtle text-primary timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">Audrey
                                                                Tobey</a>
                                                            <span class="mb-1">Uploaded a photo
                                                                <span class="fw-medium">"Error.jpg"</span>
                                                            </span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">14 hours ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-basket bg-info-subtle text-info timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">You sold an
                                                                item</a>
                                                            <span class="mb-1">Paul Burgess just purchased “My - Admin
                                                                Dashboard”!</span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">16 hours ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-rocket bg-primary-subtle text-primary timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">Product on the
                                                                Bootstrap Market</a>
                                                            <span class="mb-1">Reviewer added
                                                                <span class="fw-medium">Admin Dashboard</span>
                                                            </span>
                                                            <p class="mb-0 pb-3">
                                                                <small class="text-muted">22 hours ago</small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item">
                                                        <i
                                                            class="ti ti-message bg-info-subtle text-info timeline-icon"></i>
                                                        <div class="timeline-item-info">
                                                            <a href="javascript:void(0);"
                                                                class="link-reset fw-semibold mb-1 d-block">Robert
                                                                Delaney</a>
                                                            <span class="mb-1">Send you message
                                                                <span class="fw-medium">"Are you there?"</span>
                                                            </span>
                                                            <p class="mb-0 pb-2">
                                                                <small class="text-muted">2 days ago</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end timeline -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 286px; height: 864px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 158px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div> <!-- end slimscroll -->
                    </div>

                    <div class="card-body">
                        <div class="card mb-0 bg-warning bg-opacity-25">
                            <div class="card-body"
                                style="background-image: url(assets/images/arrows.svg); background-size: contain; background-repeat: no-repeat; background-position: right bottom;">
                                <h1><i class="ti ti-receipt-tax text-warning"></i></h1>
                                <h4 class="text-warning">Estimated tax for this year</h4>
                                <p class="text-warning text-opacity-75">We kindly encourage you to review your recent
                                    transactions</p>
                                <a href="https://coderthemes.com/boron/layouts/index.html#!"
                                    class="btn btn-sm rounded-pill btn-info">Activate Now</a>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->

    </div> <!-- container -->
@endsection



@push('script')
    <!-- Apex Chart js -->
    <script src="{{ asset('assets') }}/js/apexcharts.min.js"></script>

    <!-- Projects Analytics Dashboard App js -->
    <script src="{{ asset('assets') }}/js/dashboard-sales.js"></script><svg id="SvgjsSvg1006" width="2" height="0" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1007"></defs>
        <polyline id="SvgjsPolyline1008" points="0,0"></polyline>
        <path id="SvgjsPath1009" d="M0 0 "></path>
    </svg>



    <div class="flatpickr-calendar rangeMode animate" tabindex="-1">
        <div class="flatpickr-months"><span class="flatpickr-prev-month"><svg version="1.1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17">
                    <g></g>
                    <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z"></path>
                </svg></span>
            <div class="flatpickr-month">
                <div class="flatpickr-current-month"><select class="flatpickr-monthDropdown-months" aria-label="Month"
                        tabindex="-1">
                        <option class="flatpickr-monthDropdown-month" value="0" tabindex="-1">January</option>
                        <option class="flatpickr-monthDropdown-month" value="1" tabindex="-1">February</option>
                        <option class="flatpickr-monthDropdown-month" value="2" tabindex="-1">March</option>
                        <option class="flatpickr-monthDropdown-month" value="3" tabindex="-1">April</option>
                        <option class="flatpickr-monthDropdown-month" value="4" tabindex="-1">May</option>
                        <option class="flatpickr-monthDropdown-month" value="5" tabindex="-1">June</option>
                        <option class="flatpickr-monthDropdown-month" value="6" tabindex="-1">July</option>
                        <option class="flatpickr-monthDropdown-month" value="7" tabindex="-1">August</option>
                        <option class="flatpickr-monthDropdown-month" value="8" tabindex="-1">September</option>
                        <option class="flatpickr-monthDropdown-month" value="9" tabindex="-1">October</option>
                        <option class="flatpickr-monthDropdown-month" value="10" tabindex="-1">November</option>
                        <option class="flatpickr-monthDropdown-month" value="11" tabindex="-1">December</option>
                    </select>
                    <div class="numInputWrapper"><input class="numInput cur-year" type="number" tabindex="-1"
                            aria-label="Year"><span class="arrowUp"></span><span class="arrowDown"></span></div>
                </div>
            </div><span class="flatpickr-next-month"><svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17">
                    <g></g>
                    <path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z">
                    </path>
                </svg></span>
        </div>
        <div class="flatpickr-innerContainer">
            <div class="flatpickr-rContainer">
                <div class="flatpickr-weekdays">
                    <div class="flatpickr-weekdaycontainer">
                        <span class="flatpickr-weekday">
                            Sun</span><span class="flatpickr-weekday">Mon</span><span
                            class="flatpickr-weekday">Tue</span><span class="flatpickr-weekday">Wed</span><span
                            class="flatpickr-weekday">Thu</span><span class="flatpickr-weekday">Fri</span><span
                            class="flatpickr-weekday">Sat
                        </span>
                    </div>
                </div>
                <div class="flatpickr-days" tabindex="-1">
                    <div class="dayContainer"><span class="flatpickr-day prevMonthDay" aria-label="April 27, 2025"
                            tabindex="-1">27</span><span class="flatpickr-day prevMonthDay"
                            aria-label="April 28, 2025" tabindex="-1">28</span><span
                            class="flatpickr-day prevMonthDay" aria-label="April 29, 2025"
                            tabindex="-1">29</span><span class="flatpickr-day prevMonthDay"
                            aria-label="April 30, 2025" tabindex="-1">30</span><span
                            class="flatpickr-day selected startRange" aria-label="May 1, 2025"
                            tabindex="-1">1</span><span class="flatpickr-day inRange" aria-label="May 2, 2025"
                            tabindex="-1">2</span><span class="flatpickr-day inRange" aria-label="May 3, 2025"
                            tabindex="-1">3</span><span class="flatpickr-day inRange" aria-label="May 4, 2025"
                            tabindex="-1">4</span><span class="flatpickr-day inRange" aria-label="May 5, 2025"
                            tabindex="-1">5</span><span class="flatpickr-day inRange" aria-label="May 6, 2025"
                            tabindex="-1">6</span><span class="flatpickr-day inRange" aria-label="May 7, 2025"
                            tabindex="-1">7</span><span class="flatpickr-day today inRange" aria-label="May 8, 2025"
                            aria-current="date" tabindex="-1">8</span><span class="flatpickr-day inRange"
                            aria-label="May 9, 2025" tabindex="-1">9</span><span class="flatpickr-day inRange"
                            aria-label="May 10, 2025" tabindex="-1">10</span><span class="flatpickr-day inRange"
                            aria-label="May 11, 2025" tabindex="-1">11</span><span class="flatpickr-day inRange"
                            aria-label="May 12, 2025" tabindex="-1">12</span><span class="flatpickr-day inRange"
                            aria-label="May 13, 2025" tabindex="-1">13</span><span class="flatpickr-day inRange"
                            aria-label="May 14, 2025" tabindex="-1">14</span><span class="flatpickr-day inRange"
                            aria-label="May 15, 2025" tabindex="-1">15</span><span class="flatpickr-day inRange"
                            aria-label="May 16, 2025" tabindex="-1">16</span><span class="flatpickr-day inRange"
                            aria-label="May 17, 2025" tabindex="-1">17</span><span class="flatpickr-day inRange"
                            aria-label="May 18, 2025" tabindex="-1">18</span><span class="flatpickr-day inRange"
                            aria-label="May 19, 2025" tabindex="-1">19</span><span class="flatpickr-day inRange"
                            aria-label="May 20, 2025" tabindex="-1">20</span><span class="flatpickr-day inRange"
                            aria-label="May 21, 2025" tabindex="-1">21</span><span class="flatpickr-day inRange"
                            aria-label="May 22, 2025" tabindex="-1">22</span><span class="flatpickr-day inRange"
                            aria-label="May 23, 2025" tabindex="-1">23</span><span class="flatpickr-day inRange"
                            aria-label="May 24, 2025" tabindex="-1">24</span><span class="flatpickr-day inRange"
                            aria-label="May 25, 2025" tabindex="-1">25</span><span class="flatpickr-day inRange"
                            aria-label="May 26, 2025" tabindex="-1">26</span><span class="flatpickr-day inRange"
                            aria-label="May 27, 2025" tabindex="-1">27</span><span class="flatpickr-day inRange"
                            aria-label="May 28, 2025" tabindex="-1">28</span><span class="flatpickr-day inRange"
                            aria-label="May 29, 2025" tabindex="-1">29</span><span class="flatpickr-day inRange"
                            aria-label="May 30, 2025" tabindex="-1">30</span><span
                            class="flatpickr-day selected endRange" aria-label="May 31, 2025"
                            tabindex="-1">31</span><span class="flatpickr-day nextMonthDay" aria-label="June 1, 2025"
                            tabindex="-1">1</span><span class="flatpickr-day nextMonthDay" aria-label="June 2, 2025"
                            tabindex="-1">2</span><span class="flatpickr-day nextMonthDay" aria-label="June 3, 2025"
                            tabindex="-1">3</span><span class="flatpickr-day nextMonthDay" aria-label="June 4, 2025"
                            tabindex="-1">4</span><span class="flatpickr-day nextMonthDay" aria-label="June 5, 2025"
                            tabindex="-1">5</span><span class="flatpickr-day nextMonthDay" aria-label="June 6, 2025"
                            tabindex="-1">6</span><span class="flatpickr-day nextMonthDay" aria-label="June 7, 2025"
                            tabindex="-1">7</span></div>
                </div>
            </div>
        </div>
    </div>
@endpush
