<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add New Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createContractForm" method="POST" action="{{ route('landlord.contracts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Tenant</label>
                            <select class="form-control select2" id="user_id" name="user_id" required>
                                <option value="" disabled selected>Select a tenant...</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select class="form-control select2" id="room_id" name="room_id" required>
                                <option value="" disabled selected>Select a room...</option>
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->property->name }} - {{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" class="form-control flatpickr-input" id="start_date" name="start_date" data-provider="flatpickr" data-date-format="d M, Y"
                                readonly="readonly" value="<?php echo date('d M, Y'); ?>" data-sharkid="__1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" class="form-control flatpickr-input" id="end_date" name="end_date" data-provider="flatpickr" data-date-format="d M, Y" readonly="readonly" data-sharkid="__1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rent_amount" class="form-label">Rent Amount ($)</label>
                            <input type="number" step="0.01" class="form-control" id="rent_amount" name="rent_amount" placeholder="e.g. 500.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="billing_cycle" class="form-label">Billing Cycle</label>
                            <select class="form-control select2" id="billing_cycle" name="billing_cycle" required>
                                <option value="monthly" selected>Monthly</option>
                                <option value="yearly">Yearly</option>
                                <option value="daily">Daily</option>
                            </select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control select2" id="status" name="status" required>
                                <option value="active" selected>Active</option>
                                <option value="expired">Expired</option>
                                <option value="terminated">Terminated</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contract_image" class="form-label">Contract Scan (Optional)</label>
                            <input type="file" class="form-control" id="contract_image" name="contract_image">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>