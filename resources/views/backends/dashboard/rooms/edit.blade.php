<!-- Edit Room Modal -->
<div class="modal fade" id="editModal" aria-labelledby="editModalLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoomForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="landlord_id" value="{{ Auth::user()->id }}">
                    <div class="mb-3">
                        <label for="edit-number" class="col-form-label">Number:</label>
                        <input type="text" class="form-control" name="number" id="edit-number">
                    </div>
                    <div class="mb-3">
                        <label for="edit-price" class="col-form-label">Price:</label>
                        <input type="text" class="form-control" name="price" id="edit-price">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end gap-1">
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
