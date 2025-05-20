<div class="modal fade" id="createModal" aria-labelledby="createModalLabel" tabindex="-1" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create New Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="landlord_id" value="{{ Auth::user()->id }}">

                    <div class="mb-3">
                        <label for="number" class="col-form-label">Number:</label>
                        <input type="text" class="form-control" name="number" id="number" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="col-form-label">Price:</label>
                        <input type="text" class="form-control" name="price" id="price" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end gap-1">
                        <button type="submit" class="btn btn-primary">Create Room</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
