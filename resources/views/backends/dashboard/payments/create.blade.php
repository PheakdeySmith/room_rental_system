@extends('backends.layouts.app')

@section('title', 'Create Invoice | RoomGate')

@push('style')
    <style>
        .invoice-type-card {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .invoice-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .form-section {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0" id="page-title">Select Invoice Type</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Boron</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Invoices</a></li>
                    <li class="breadcrumb-item active" id="breadcrumb-active">Select Type</li>
                </ol>
            </div>
        </div>

        <div id="invoice-type-selection" class="row mt-4">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card invoice-type-card h-100" data-form="full-invoice-form">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                        <i class="ti ti-file-invoice fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">Create Full Invoice</h5>
                        <p class="card-text text-muted">Includes both room rent and all utility charges.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card invoice-type-card h-100" data-form="rent-invoice-form">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                        <i class="ti ti-home-dollar fs-1 text-success mb-3"></i>
                        <h5 class="card-title">Create Rent Invoice</h5>
                        <p class="card-text text-muted">An invoice that only includes the monthly room rent.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card invoice-type-card h-100" data-form="utility-invoice-form">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                        <i class="ti ti-bolt fs-1 text-info mb-3"></i>
                        <h5 class="card-title">Create Utility Invoice</h5>
                        <p class="card-text text-muted">An invoice for charges like electricity, water, etc.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="invoice-form-container">
            <div id="full-invoice-form" class="form-section">
                @include('backends.dashboard.payments.partials.invoice-form', ['type' => 'full'])
            </div>
            <div id="rent-invoice-form" class="form-section">
                @include('backends.dashboard.payments.partials.invoice-form', ['type' => 'rent'])
            </div>
            <div id="utility-invoice-form" class="form-section">
                @include('backends.dashboard.payments.partials.invoice-form', ['type' => 'utility'])
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | PART 1: VIEW MANAGEMENT
            |--------------------------------------------------------------------------
            */
            const cardSelectionView = document.getElementById('invoice-type-selection');
            const formContainerView = document.getElementById('invoice-form-container');
            const pageTitle = document.getElementById('page-title');
            const breadcrumbActive = document.getElementById('breadcrumb-active');
            const allForms = document.querySelectorAll('.form-section');
            const selectionCards = document.querySelectorAll('.invoice-type-card');
            const backButtons = document.querySelectorAll('.back-to-selection-btn');

            const showForm = (formId) => {
                cardSelectionView.style.display = 'none';
                allForms.forEach(form => form.style.display = 'none');
                const formToShow = document.getElementById(formId);
                if (formToShow) {
                    formToShow.style.display = 'block';
                    formContainerView.style.display = 'block';
                    let title = 'Create Invoice';
                    if (formId.includes('rent')) title = 'Create Rent Invoice';
                    if (formId.includes('utility')) title = 'Create Utility Invoice';
                    if (formId.includes('full')) title = 'Create Full Invoice';
                    pageTitle.textContent = title;
                    breadcrumbActive.textContent = title;
                }
            };

            const showCardSelection = () => {
                formContainerView.style.display = 'none';
                cardSelectionView.style.display = 'flex';
                pageTitle.textContent = 'Select Invoice Type';
                breadcrumbActive.textContent = 'Select Type';
            };

            selectionCards.forEach(card => card.addEventListener('click', function () { showForm(this.getAttribute('data-form')); }));
            backButtons.forEach(button => button.addEventListener('click', showCardSelection));

            /*
            |--------------------------------------------------------------------------
            | PART 2: DYNAMIC FORM POPULATION (AJAX)
            |--------------------------------------------------------------------------
            */
            const allContractSelects = document.querySelectorAll('.contract-select');
            allContractSelects.forEach(select => {
                select.addEventListener('change', function () {
                    const contractId = this.value;
                    const parentForm = this.closest('form');
                    if (!contractId) return;
                    fetchContractDetails(`/landlord/payments/get-contract-details/${contractId}`, parentForm);
                });
            });

            function fetchContractDetails(url, parentForm) {
                const formType = parentForm.closest('.form-section').id.split('-')[0];
                const tableBody = parentForm.querySelector(`#invoice-items-body-${formType}`);
                const amenitiesDisplay = parentForm.querySelector('.amenities-display');
                const loader = parentForm.querySelector('.utility-loader');

                loader.style.display = 'block';
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center p-4"><div class="spinner-border spinner-border-sm"></div></td></tr>`;
                amenitiesDisplay.innerHTML = '<small class="text-muted">Loading...</small>';
                parentForm.querySelector('.room-number-input').value = '';

                fetch(url)
                    .then(response => response.ok ? response.json() : Promise.reject('Network error'))
                    .then(data => {
                        parentForm.querySelector('.room-number-input').value = data.room_number;

                        populateAmenities(parentForm.querySelector('.amenities-display'), data.amenities);

                        const formType = parentForm.closest('.form-section').id.split('-')[0];
                        const tableBody = parentForm.querySelector(`#invoice-items-body-${formType}`);
                        populateTable(tableBody, data, formType);

                        // After populating, run calculations for all rows
                        parentForm.querySelectorAll('.utility-row').forEach(updateUtilityRowAmount);
                        updateInvoiceSummary(parentForm);

                        parentForm.querySelector('.utility-loader').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error fetching contract details:', error);
                        loader.style.display = 'none';
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Failed to load invoice details. Please check the console.</td></tr>`;
                        amenitiesDisplay.innerHTML = '<small class="text-danger">Failed to load amenities.</small>';
                    });
            }

            function populateAmenities(displayElement, amenities) {
                displayElement.innerHTML = '';
                if (amenities && amenities.length > 0) {
                    amenities.forEach(amenity => {
                        const amenityEl = document.createElement('div');
                        amenityEl.className = 'd-flex justify-content-between align-items-center mb-1';
                        amenityEl.innerHTML = `<span><i class="ti ti-check text-success me-2"></i>${amenity.name}</span><span class="fw-bold">$${parseFloat(amenity.amenity_price).toFixed(2)}</span>`;
                        displayElement.appendChild(amenityEl);
                    });
                } else {
                    displayElement.innerHTML = '<small class="text-muted">No extra amenities for this room.</small>';
                }
            }

            function populateTable(tableBody, data, formType) {
                tableBody.innerHTML = '';
                let itemCounter = 1;

                if (formType === 'full' || formType === 'rent') {
                    const basePrice = parseFloat(data.base_price) || 0;
                    const amenitiesPrice = (data.amenities || []).reduce((total, amenity) => total + (parseFloat(amenity.amenity_price) || 0), 0);
                    const finalRent = basePrice + amenitiesPrice;

                    const rentRow = tableBody.insertRow();
                    rentRow.className = 'rent-row';
                    rentRow.innerHTML = `
                        <th>${String(itemCounter++).padStart(2, '0')}</th>
                        <td class="text-start"><h6 class="mb-0">Room Rent</h6><p class="text-muted mb-0 small">(Base + amenities)</p></td>
                        <td><input type="text" class="form-control text-center" value="1" readonly></td>
                        <td><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control room-unit-price-input" value="${basePrice.toFixed(2)}" readonly></div></td>
                        <td class="text-end"><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control room-amount-input text-end" value="${finalRent.toFixed(2)}" readonly></div></td>`;
                }

                if (formType === 'full' || formType === 'utility') {
                    // ## THIS IS THE FIX ##
                    // We now loop through `utility_data` which contains the consumption
                    (data.utility_data || []).forEach(utility => {
                        const utilityRow = tableBody.insertRow();
                        utilityRow.className = 'utility-row';
                        utilityRow.innerHTML = `
                        <th>${String(itemCounter++).padStart(2, '0')}</th>
                        <td class="text-start"><input type="text" class="form-control utility-detail-input" value="${utility.utility_type.name}" readonly></td>

                        {{-- The quantity is now pre-filled from the controller --}}
                        <td><input type="number" class="form-control utility-qty-input text-center" value="${utility.consumption}" min="0" readonly></td>

                        <td><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control utility-price-input" value="${parseFloat(utility.rate).toFixed(2)}" readonly></div></td>
                        <td class="text-end"><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control utility-amount-input text-end" placeholder="$0.00" readonly></div></td>`;
                    });
                }
            }

            /*
            |--------------------------------------------------------------------------
            | PART 3: REAL-TIME CALCULATIONS & SUMMARY UPDATES
            |--------------------------------------------------------------------------
            */
            document.addEventListener('input', function (e) {
                if (e.target.matches('.utility-qty-input, .discount-input')) {
                    const form = e.target.closest('form');
                    if (e.target.matches('.utility-qty-input')) {
                        updateUtilityRowAmount(e.target.closest('tr'));
                    }
                    updateInvoiceSummary(form);
                }
            });

            function updateUtilityRowAmount(row) {
                const qty = parseFloat(row.querySelector('.utility-qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.utility-price-input').value) || 0;
                const amountInput = row.querySelector('.utility-amount-input');
                if (amountInput) amountInput.value = (qty * price).toFixed(2);
            }

            function updateInvoiceSummary(form) {
                if (!form) return;
                let subtotal = 0;

                const roomAmountInput = form.querySelector('.room-amount-input');
                if (roomAmountInput) subtotal += parseFloat(roomAmountInput.value) || 0;

                form.querySelectorAll('.utility-row').forEach(row => {
                    subtotal += parseFloat(row.querySelector('.utility-amount-input').value) || 0;
                });

                const summaryWrapper = form.querySelector('.invoice-summary-wrapper');
                if (!summaryWrapper) return;

                const discountInput = summaryWrapper.querySelector('.discount-input');
                const discountAmountEl = summaryWrapper.querySelector('.discount-display');
                const subtotalEl = summaryWrapper.querySelector('.subtotal-display');
                const totalEl = summaryWrapper.querySelector('.total-display');

                const discountPercent = parseFloat(discountInput.value) || 0;
                const discountAmount = subtotal * (discountPercent / 100);
                const total = subtotal - discountAmount;

                if (subtotalEl) subtotalEl.textContent = '$' + subtotal.toFixed(2);
                if (discountAmountEl) discountAmountEl.textContent = '-$' + discountAmount.toFixed(2);
                if (totalEl) totalEl.textContent = '$' + total.toFixed(2);
            }

            /*
            |--------------------------------------------------------------------------
            | PART 4: INVOICE PREVIEW GENERATION
            |--------------------------------------------------------------------------
            */
            const logoUrl = "{{ asset('assets/images/logo-dark.png') }}";
            const qrCode1Url = "{{ asset('assets/images/qr1.jpg') }}";
            const qrCode2Url = "{{ asset('assets/images/qr2.jpg') }}";

            // --- THIS IS THE FIX ---
            // The 'previewButtons' variable must be declared before it is used.
            const previewButtons = document.querySelectorAll('.preview-btn');

            previewButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    generateInvoicePreview(this);
                });
            });

            function generateInvoicePreview(clickedButton) {
                const activeForm = clickedButton.closest('form');
                const formType = clickedButton.closest('.form-section').id.split('-')[0];

                const invoiceNumber = activeForm.querySelector('.invoice-no-input').value || 'N/A';
                const roomNumber = activeForm.querySelector('.room-number-input').value;
                const issueDate = activeForm.querySelector('.issue-date-input').value;
                const dueDate = activeForm.querySelector('.due-date-input').value;
                const tenantName = activeForm.querySelector('.contract-select').options[activeForm.querySelector('.contract-select').selectedIndex].text.split(' - ')[1] || 'Tenant';

                let itemsHtml = '';
                let itemCounter = 1;

                activeForm.querySelector(`#invoice-items-body-${formType}`).querySelectorAll('tr').forEach(row => {
                    let detail, qty, price, amount;
                    if (row.classList.contains('rent-row')) {
                        detail = 'Room Rent';
                        qty = 1;
                        price = parseFloat(row.querySelector('.room-amount-input').value) || 0;
                        amount = price;
                    } else if (row.classList.contains('utility-row')) {
                        detail = row.querySelector('.utility-detail-input').value;
                        qty = row.querySelector('.utility-qty-input').value || 0;
                        price = parseFloat(row.querySelector('.utility-price-input').value) || 0;
                        amount = parseFloat(row.querySelector('.utility-amount-input').value) || 0;
                    }

                    itemsHtml += `
                        <tr>
                            <th scope="row">${String(itemCounter++).padStart(2, '0')}</th>
                            <td class="text-start">${detail}</td>
                            <td>${qty}</td>
                            <td>$${price.toFixed(2)}</td>
                            <td class="text-end">$${amount.toFixed(2)}</td>
                        </tr>`;
                });

                const summaryWrapper = activeForm.querySelector('.invoice-summary-wrapper');
                const subtotalText = summaryWrapper.querySelector('.subtotal-display').textContent;
                const discountText = summaryWrapper.querySelector('.discount-display').textContent;
                const totalText = summaryWrapper.querySelector('.total-display').textContent;

                const invoiceHtml = `
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Invoice #${invoiceNumber}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { font-family: sans-serif; -webkit-print-color-adjust: exact; background-color: #fff !important; }
                            .invoice-items-table .totals-row td, .invoice-items-table .final-total-row td, .invoice-items-table .final-total-row th { border: none; padding-top: 0.75rem; padding-bottom: 0.75rem; }
                            .invoice-items-table .totals-row td:nth-last-child(-n+2) { border-top: 1px solid #e9ecef; }
                            .invoice-items-table .final-total-row td, .invoice-items-table .final-total-row th { border-top: 2px solid #212529; border-bottom: 2px solid #212529; font-weight: 700; }
                        </style>
                    </head>
                    <body>
                        <div class="container py-4">
                            <div class="row align-items-center mb-4"><div class="col-6"><img src="${logoUrl}" height="60" alt="Logo"></div><div class="col-6 text-end"><h2>Invoice #${invoiceNumber}</h2></div></div><hr>
                            <div class="row mb-4"><div class="col-6"><p class="fw-bold">Bill To:</p><p>${tenantName}<br>Room ${roomNumber}<br>Phnom Penh</p></div><div class="col-6 text-end"><p><span class="fw-bold">Invoice Date:</span> ${issueDate}</p><p><span class="fw-bold">Due Date:</span> ${dueDate}</p></div></div>
                            <table class="table invoice-items-table text-center table-nowrap align-middle mb-0">
                                <thead class="bg-light bg-opacity-50"><tr><th style="width:50px;">#</th><th class="text-start">Item Details</th><th>Quantity</th><th>Unit Price</th><th class="text-end">Amount</th></tr></thead>
                                <tbody>
                                    ${itemsHtml}
                                    <tr class="totals-row"><td colspan="3"></td><td class="text-end">Subtotal</td><td class="text-end">${subtotalText}</td></tr>
                                    <tr class="totals-row"><td colspan="3"></td><td class="text-end">Discount</td><td class="text-end">${discountText}</td></tr>
                                    <tr class="final-total-row fs-15"><th colspan="3"></th><th class="text-end">Total Amount</th><th class="text-end">${totalText}</th></tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-5"><img src="${qrCode1Url}" height="100" class="mx-2" alt="QR Code"><img src="${qrCode2Url}" height="100" class="mx-2" alt="QR Code"></div>
                        </div>
                    </body>
                    </html>`;

                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                iframe.contentDocument.write(invoiceHtml);
                iframe.contentDocument.close();
                iframe.onload = function () {
                    iframe.contentWindow.print();
                    document.body.removeChild(iframe);
                };
            }

            // Initialize the page
            showCardSelection();
        });
    </script>
@endpush