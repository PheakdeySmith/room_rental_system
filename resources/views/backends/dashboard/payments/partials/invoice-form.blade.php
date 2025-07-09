{{-- C:\laragon\www\room_rental_system\resources\views\backends\dashboard\payments\partials\invoice-form.blade.php --}}
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
                            <label class="form-label">Select Contract (Room - Tenant)</label>

                            <select class="form-select contract-select" name="contract_id" required>
                                <option value="" selected disabled>Choose a contract...</option>

                                {{-- Loop through the $contracts collection from your controller --}}
                                @foreach ($contracts as $contract)
                                    @php
                                        // This gets the amenities linked via the 'amenity_room' table
                                        // and converts them into a JSON string for the data attribute.
                                        $amenitiesJson = $contract->room->amenities->map(function ($amenity) {
                                            return ['name' => $amenity->name, 'price' => $amenity->amenity_price];
                                        })->toJson();
                                    @endphp

                                    {{--
                                    This option now has all the data the JavaScript needs,
                                    especially data-amenities.
                                    --}}
                                    <option value="{{ $contract->id }}"
                                        data-room-number="{{ $contract->room->room_number }}"
                                        data-room-price="{{ $contract->rent_amount }}"
                                        data-amenities='{{ $amenitiesJson }}'>
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
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Invoice Date</label>
                                <input type="date" class="form-control issue-date-input" value="{{ $issueDate }}">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control due-date-input" value="{{ $dueDate }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Included Amenities</label>
                            <div class="border rounded p-3 bg-light amenities-display" style="min-height: 100px;">
                                <small class="text-muted">Select a contract to see amenities.</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- The table is included directly for desktop view --}}
                @include('backends.dashboard.payments.partials.invoice-table', ['type' => $type])
            </div>

            <div class="d-block d-md-none">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Select Contract (Room - Tenant)</label>
                            <select class="form-select contract-select" name="contract_id_mobile" required>
                                <option value="" selected disabled>Choose a contract...</option>
                                <option value="1" data-room-number="101" data-room-price="250.00"
                                    data-amenities='[{"name": "WiFi Internet", "price": 10.00},{"name": "Air Conditioner", "price": 15.00}]'>
                                    Room 101 - John Doe
                                </option>
                                <option value="2" data-room-number="102" data-room-price="275.00"
                                    data-amenities='[{"name": "WiFi Internet", "price": 10.00},{"name": "Air Conditioner", "price": 15.00},{"name": "Smart TV", "price": 10.00}]'>
                                    Room 102 - Jane Smith
                                </option>
                                <option value="3" data-room-number="103" data-room-price="220.00" data-amenities='[]'>
                                    Room 103 - Vicheka
                                </option>
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
                        <div class="mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" class="form-control issue-date-input" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control due-date-input">
                        </div>
                    </div>
                </div>

                <div class="accordion" id="invoiceItemsAccordion-{{$type}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseItems-{{$type}}">
                                <strong>Invoice Items</strong>
                            </button>
                        </h2>
                        <div id="collapseItems-{{$type}}" class="accordion-collapse collapse show">
                            <div class="accordion-body p-0">
                                @include('backends.dashboard.payments.partials.invoice-table', ['type' => $type])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end mt-3">
                <div class="col-lg-5 col-md-8">
                    @include('backends.dashboard.payments.partials.invoice-summary')
                </div>
            </div>

        </div>
        <div class="card-footer text-center">
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-primary gap-1 preview-btn" data-type="{{ $type }}">
                    <i class="ti ti-eye fs-16"></i> Preview
                </button>
                <button type="submit" class="btn btn-success gap-1">
                    <i class="ti ti-device-floppy fs-16"></i> Save Invoice
                </button>
            </div>
        </div>
    </form>
</div>