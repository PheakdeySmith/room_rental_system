<div class="modal fade" id="createRateModal" tabindex="-1" aria-labelledby="createRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRateModalLabel">Add New Utility Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('landlord.properties.rates.store', $property) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="utility_type_id" class="form-label">Utility Type</label>
                        <select class="form-control select2" name="utility_type_id" id="utility_type_id" required>
                            <option value="">Select Utility Type...</option>
                            @foreach($utilityTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->unit_of_measure }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rate" class="form-label">Rate ($)</label>
                        <input type="number" step="0.01" class="form-control" name="rate" id="rate" placeholder="e.g., 1.25" required>
                    </div>
                    <div class="mb-3">
                        <label for="effective_from" class="form-label">Effective From</label>
                        <input type="date" class="form-control" name="effective_from" id="effective_from" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>
