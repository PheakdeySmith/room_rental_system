<div class="d-flex align-items-center gap-1 mb-3">
    
    {{-- This is the hamburger menu icon --}}
    <div class="flex-shrink-0 d-xl-none d-inline-flex">
        <button class="btn btn-sm btn-icon btn-soft-primary align-items-center p-0" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#fileManagerSidebar" aria-controls="fileManagerSidebar">
            <i class="ti ti-menu-2 fs-20"></i>
        </button>
    </div>
    
    {{-- This is the title --}}
    <h4 class="header-title mb-0">All Rooms</h4>
    
    {{-- This is the button's container. Add ms-auto here. --}}
    <div class="ms-auto">
        <a href="apps-ecommerce-products-add.html" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i>Add Products
        </a>
    </div>

</div>




<div class="col-12">
    <div class="py-3 border-bottom">
        <div class="d-flex flex-wrap justify-content-between gap-2">
            <div class="position-relative">
                <input type="text" class="form-control ps-4" placeholder="Search products" data-sharkid="__0">
                <i class="ti ti-search position-absolute top-50 translate-middle-y ms-2"></i>
            </div>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover text-nowrap mb-0">
            <thead class="bg-dark-subtle">
                <tr>
                    <th class="ps-3">Room Number</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Monthly Rent</th>
                    <th>Last Updated</th>
                    <th class="text-center" style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($property->rooms as $room)
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex justify-content-start align-items-center gap-3">
                                <div
                                    class="avatar-md bg-light-subtle d-inline-flex align-items-center justify-content-center rounded-2">
                                    <i class="ti ti-door fs-22 text-secondary"></i>
                                </div>
                                <span class="fw-semibold">{{ $room->room_number ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $room->roomType->name ?? 'Uncategorized' }}</td>
                        <td>
                            @if ($room->status == 'available')
                                <span class="badge bg-success-subtle text-success fs-12 p-1">Available</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fs-12 p-1">Occupied</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $priceRecord = $basePrices[$room->room_type_id] ?? null;
                            @endphp

                            @if ($priceRecord)
                                ${{ number_format($priceRecord->price, 2) }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>{{ $room->updated_at->format('M d, Y') }}</td>
                        <td class="pe-3">
                            <div class="hstack gap-1 justify-content-end">
                                {{-- These links can be updated later to point to real routes --}}
                                <a href="javascript:void(0);" class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);" class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                    <i class="ti ti-edit fs-16"></i></a>
                                <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-sm rounded-circle"> <i
                                        class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="mb-0">No rooms have been added to this property yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        <div class="d-flex justify-content-center">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="javascript: void(0);" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="javascript: void(0);">Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>