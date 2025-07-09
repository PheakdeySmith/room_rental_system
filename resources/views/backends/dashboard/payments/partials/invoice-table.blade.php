{{-- C:\laragon\www\room_rental_system\resources\views\backends\dashboard\payments\partials\invoice-table.blade.php --}}
<div class="mt-4">
    <div class="table-responsive">
        <table class="table text-center table-nowrap align-middle mb-0">
            <thead class="bg-light bg-opacity-50">
                <tr>
                    <th scope="col" class="border-0" style="width: 5%;">#</th>
                    <th scope="col" class="border-0 text-start">Details</th>
                    <th scope="col" class="border-0" style="width: 15%;">Quantity</th>
                    <th scope="col" class="border-0" style="width: 20%;">Unit Price</th>
                    <th scope="col" class="border-0 text-end" style="width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                {{-- New Corrected Code --}}
                @if($type == 'full' || $type == 'rent')
                    <tr class="rent-row">
                        <th>01</th>
                        <td class="text-start">
                            <h6 class="mb-0">Room Rent</h6>
                            <p class="text-muted mb-0">(Base rent + amenities)</p>
                        </td>
                        <td>1</td>
                        <td>
                            <div class="input-group">
                                {{-- This input should represent the base unit price --}}
                                <input type="text" class="form-control room-unit-price-input" placeholder="$0.00" readonly>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="input-group">
                                {{-- This input should represent the total amount, which the preview function reads --}}
                                <input type="text" class="form-control room-amount-input" placeholder="$0.00" readonly>
                            </div>
                        </td>
                    </tr>
                @endif

                @if($type == 'full' || $type == 'utility')
                    {{-- Add the 'utility-row' class to the <tr> --}}
                    <tr class="utility-row">
                        <th>{{ ($type == 'full') ? '02' : '01' }}</th>
                        <td class="text-start">
                            {{-- Add a class to the detail input --}}
                            <input type="text" class="form-control utility-detail-input" value="Electricity"
                                placeholder="Utility Detail">
                        </td>
                        <td>
                            {{-- Add a class to the quantity input --}}
                            <input type="number" class="form-control utility-qty-input" placeholder="e.g., 100">
                        </td>
                        <td>
                            {{-- Add a class to the price input --}}
                            <input type="number" class="form-control utility-price-input" value="0.25"
                                placeholder="Price/unit">
                        </td>
                        <td class="text-end">
                            <input type="number" class="form-control" placeholder="$0.00" readonly>
                        </td>
                    </tr>
                    <tr class="utility-row">
                        <th>{{ ($type == 'full') ? '03' : '02' }}</th>
                        <td class="text-start">
                            <input type="text" class="form-control utility-detail-input" value="Water"
                                placeholder="Utility Detail">
                        </td>
                        <td>
                            <input type="number" class="form-control utility-qty-input" placeholder="e.g., 10">
                        </td>
                        <td>
                            <input type="number" class="form-control utility-price-input" value="1.00"
                                placeholder="Price/unit">
                        </td>
                        <td class="text-end">
                            <input type="number" class="form-control" placeholder="$0.00" readonly>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>