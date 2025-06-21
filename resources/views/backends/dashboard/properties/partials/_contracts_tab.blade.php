
<div class="d-flex align-items-center justify-content-between">
    <h4 class="header-title">All Contracts</h4>
    <a href="#" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Add Contract</a>
</div>

<div class="col-12">
    <div class="py-3 border-bottom">
        <div class="d-flex flex-wrap justify-content-between gap-2">
            <div class="position-relative">
                <input type="text" class="form-control ps-4" placeholder="Search contracts...">
                <i class="ti ti-search position-absolute top-50 translate-middle-y ms-2"></i>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover text-nowrap mb-0">
            <thead class="bg-dark-subtle">
                <tr>
                    <th class="ps-3">Tenant</th>
                    <th>Room Number</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($property->contracts as $contract)
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex justify-content-start align-items-center gap-3">
                                <div class="avatar-sm">
                                    <img src="{{ $contract->tenant->image ? asset($contract->tenant->image) : asset('assets/images/default_image.png') }}"
                                        alt="tenant image" class="rounded-circle avatar-md">
                                </div>
                                <span class="fw-semibold">{{ $contract->tenant->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $contract->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $contract->start_date }}</td>
                        <td>{{ $contract->end_date }}</td>
                        <td>
                            @if ($contract->status == 'active')
                                <span class="badge bg-success-subtle text-success fs-12 p-1">Active</span>
                            @elseif ($contract->status == 'expired')
                                <span class="badge bg-danger-subtle text-danger fs-12 p-1">Expired</span>
                            @else
                                <span
                                    class="badge bg-secondary-subtle text-secondary fs-12 p-1">{{ ucfirst($contract->status) }}</span>
                            @endif
                        </td>
                        <td class="pe-3">
                            <div class="hstack gap-1 justify-content-end">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-eye"></i></a>
                                <a href="#" class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-edit fs-16"></i></a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="mb-0">No contracts found for this property.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- You can add pagination here if needed --}}
    <div class="p-3">
        <div class="d-flex justify-content-end">
            {{-- Pagination links would go here --}}
        </div>
    </div>
</div>