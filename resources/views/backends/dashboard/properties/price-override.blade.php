@extends('backends.layouts.app')


@push('style')
    {{-- {{ asset('assets') }}/css/ --}}
@endpush


@section('content')
    <div class="page-container">


        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Calendar</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Boron</a></li>

                    <li class="breadcrumb-item active">Calendar</li>
                </ol>
            </div>
        </div>




        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary w-100" id="btn-new-event">
                            <i class="ti ti-plus me-2 align-middle"></i> Set New Price
                        </button>

                        <div id="external-events" class="mt-2">
                            <p class="text-muted">Drag and drop your event or click in the calendar</p>
                            <div class="external-event fc-event bg-success-subtle text-success"
                                data-class="bg-success-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Khmer New Year
                            </div>
                            <div class="external-event fc-event bg-info-subtle text-info" data-class="bg-info-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Pchum Ben
                            </div>
                            <div class="external-event fc-event bg-warning-subtle text-warning"
                                data-class="bg-warning-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Water Festival
                            </div>
                            <div class="external-event fc-event bg-danger-subtle text-danger" data-class="bg-danger-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Royal Ploughing Ceremony
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-standard"
                            style="height: 758px;">
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!--end row-->

        <!-- Add New Event MODAL -->
        <div class="modal fade" id="event-modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="needs-validation" name="event-form" id="forms-event" novalidate="">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title">
                                New Price Override Event
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label form-label" for="override-reason">Reason</label>
                                        <input class="form-control" placeholder="e.g., Khmer New Year Special" type="text"
                                            name="reason" id="override-reason">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="control-label form-label" for="override-price">Override Price
                                            ($)</label>
                                        <input class="form-control" placeholder="e.g., 150.00" type="number" step="0.01"
                                            name="price" id="override-price" required="">
                                        <div class="invalid-feedback">Please provide a valid price.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="start_date"
                                        name="start_date" data-provider="flatpickr" data-date-format="d M, Y"
                                        readonly="readonly" value="<?php echo date('d M, Y'); ?>" data-sharkid="__1">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="end_date" name="end_date"
                                        data-provider="flatpickr" data-date-format="d M, Y" readonly="readonly"
                                        data-sharkid="__1">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <button type="button" class="btn btn-danger" id="btn-delete-event" style="display: none;">
                                    Delete
                                </button>

                                <button type="button" class="btn btn-light ms-auto" data-bs-dismiss="modal">
                                    Close
                                </button>

                                <button type="submit" class="btn btn-primary" id="btn-save-event">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end modal-content-->
            </div>
            <!-- end modal dialog-->
        </div>
        <!-- end modal-->

    </div> <!-- container -->
@endsection



@push('script')
    <!-- Fullcalendar js -->
    <script src="{{ asset('assets') }}/js/index.global.min.js"></script>

    <!-- Calendar App Demo js -->
    <script src="{{ asset('assets') }}/js/apps-calendar.js"></script>
@endpush
