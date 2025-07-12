<div class="card position-relative">
    <form>
        <div class="card-body">
            <div class="row g-2 align-items-center mb-4">
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-secondary back-to-selection-btn">
                        <i class="ti ti-arrow-left"></i>
                        <span class="d-none d-sm-inline">Back</span>
                    </button>
                </div>
                <div class="col text-center">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="50">
                </div>
                <div class="col-12 col-sm-auto" style="min-width: 180px;">
                    <div class="input-group">
                        <span class="input-group-text fw-bold">#</span>
                        <input type="text" class="form-control invoice-no-input" value="{{ $invoiceNumber }}" readonly>
                    </div>
                </div>
            </div>
            <hr>

            <div class="d-none d-md-block">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Contract</label>
                            <select class="form-select contract-select" required>
                                <option value="" selected disabled>Choose a contract...</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">
                                        Room {{ $contract->room->room_number }} - {{ $contract->tenant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" class="form-control room-number-input" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-6 mb-3"><label class="form-label">Invoice Date</label><input type="date" class="form-control issue-date-input" value="{{ $issueDate }}"></div>
                            <div class="col-lg-6 mb-3"><label class="form-label">Due Date</label><input type="date" class="form-control due-date-input" value="{{ $dueDate }}"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Included Amenities</label>
                            <div class="border rounded p-3 bg-light amenities-display" style="min-height: 100px;">
                                <small class="text-muted">Select a contract to see amenities.</small>
                            </div>
                        </div>
                    </div>
                </div>
                @include('backends.dashboard.payments.partials.invoice-table', ['type' => $type])
            </div>

            <div class="d-block d-md-none">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Select Contract</label>
                            <select class="form-select contract-select" required>
                                <option value="" selected disabled>Choose a contract...</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">
                                        Room {{ $contract->room->room_number }} - {{ $contract->tenant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" class="form-control room-number-input" readonly>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Included Amenities</label>
                            <div class="border rounded p-3 bg-light amenities-display" style="min-height: 80px;">
                                <small class="text-muted">Select a contract to see amenities.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                     <div class="card-body">
                         <div class="mb-3"><label class="form-label">Invoice Date</label><input type="date" class="form-control issue-date-input" value="{{ $issueDate }}"></div>
                         <div class="mb-0"><label class="form-label">Due Date</label><input type="date" class="form-control due-date-input" value="{{ $dueDate }}"></div>
                     </div>
                </div>
                <div class="accordion" id="invoiceItemsAccordion-{{$type}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseItems-{{$type}}"><strong>Invoice Items</strong></button></h2>
                        <div id="collapseItems-{{$type}}" class="accordion-collapse collapse show">
                            <div class="accordion-body p-0">
                                @include('backends.dashboard.payments.partials.invoice-table', ['type' => $type])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end mt-3">
                <div class="col-lg-5 col-md-8 invoice-summary-wrapper">
                    @include('backends.dashboard.payments.partials.invoice-summary')
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-primary gap-1 preview-btn" data-type="{{ $type }}"><i class="ti ti-eye fs-16"></i> Preview</button>
                <button type="submit" class="btn btn-success gap-1"><i class="ti ti-device-floppy fs-16"></i> Save Invoice</button>
            </div>
        </div>
    </form>
</div>