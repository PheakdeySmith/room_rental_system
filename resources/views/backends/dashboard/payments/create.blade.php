@extends('backends.layouts.app')

@push('style')
    {{-- Link to your custom CSS or use internal styles --}}
    <link href="{{ asset('assets') }}/css/flatpickr.min.css" rel="stylesheet" type="text/css">
    <style>
        .invoice-type-card {
            cursor: pointer;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .invoice-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Hide all form sections by default */
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
            | Handles switching between the main selection cards and the specific
            | invoice forms (Full, Rent, Utility).
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

            selectionCards.forEach(card => card.addEventListener('click', function () {
                showForm(this.getAttribute('data-form'));
            }));

            backButtons.forEach(button => button.addEventListener('click', showCardSelection));


            const allContractSelects = document.querySelectorAll('.contract-select');
            allContractSelects.forEach(select => {
                select.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const parentForm = this.closest('form');

                    // 1. Populate Room Number (No change here)
                    parentForm.querySelector('.room-number-input').value = selectedOption.dataset.roomNumber || '';

                    // 2. Display Amenities (No change here)
                    const amenitiesDisplay = parentForm.querySelector('.amenities-display');
                    const amenitiesString = selectedOption.dataset.amenities || '[]';
                    amenitiesDisplay.innerHTML = '';

                    let amenities = [];
                    try {
                        amenities = JSON.parse(amenitiesString);
                    } catch (e) {
                        console.error("Could not parse amenities data:", e);
                        amenitiesDisplay.innerHTML = '<small class="text-danger">Error loading amenities.</small>';
                        return;
                    }

                    if (amenities.length > 0) {
                        amenities.forEach(amenity => {
                            const amenityEl = document.createElement('div');
                            amenityEl.className = 'd-flex justify-content-between align-items-center mb-1';
                            amenityEl.innerHTML = `
                                    <span><i class="ti ti-check text-success me-2"></i>${amenity.name}</span>
                                    <span class="fw-bold">$${parseFloat(amenity.price).toFixed(2)}</span>
                                `;
                            amenitiesDisplay.appendChild(amenityEl);
                        });
                    } else {
                        amenitiesDisplay.innerHTML = '<small class="text-muted">No extra amenities for this room.</small>';
                    }

                    // 3. Calculate and Populate Prices (UPDATED LOGIC)
                    // Get the base rent price directly from the contract.
                    const basePrice = parseFloat(selectedOption.dataset.roomPrice) || 0;

                    // Calculate the total price of all amenities.
                    const amenitiesPrice = amenities.reduce((total, amenity) => total + (parseFloat(amenity.price) || 0), 0);

                    // Calculate the final amount for the row (rent + amenities).
                    const totalRentAmount = basePrice + amenitiesPrice;

                    // Find the specific inputs using their new classes and set their values.
                    const unitPriceInput = parentForm.querySelector('.room-unit-price-input');
                    const amountInput = parentForm.querySelector('.room-amount-input');

                    if (unitPriceInput) {
                        unitPriceInput.value = basePrice.toFixed(2); // Set Unit Price to BASE RENT ONLY
                    }
                    if (amountInput) {
                        amountInput.value = totalRentAmount.toFixed(2); // Set Amount to RENT + AMENITIES
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | PART 3: INVOICE PREVIEW GENERATION (Corrected Design)
            |--------------------------------------------------------------------------
            */
            const logoUrl = "{{ asset('assets/images/logo-dark.png') }}";
            const qrCode1Url = "{{ asset('assets/images/qr1.jpg') }}";
            const qrCode2Url = "{{ asset('assets/images/qr2.jpg') }}";

            /*
            |--------------------------------------------------------------------------
            | PART 3: INVOICE PREVIEW GENERATION (Corrected)
            |--------------------------------------------------------------------------
            */
            const generateInvoicePreview = (clickedButton) => {
                const activeForm = clickedButton.closest('form');
                const formType = clickedButton.dataset.type;

                // Gather common data from the active form
                const invoiceNumber = activeForm.querySelector('.invoice-no-input').value || 'N/A';
                const roomNumber = activeForm.querySelector('.room-number-input').value;
                const issueDate = activeForm.querySelector('.issue-date-input').value;
                const dueDate = activeForm.querySelector('.due-date-input').value;

                let itemsHtml = '';
                let subtotal = 0;
                let itemCounter = 1;

                // Process RENT item if applicable
                if (formType === 'full' || formType === 'rent') {
                    const rentRow = activeForm.querySelector('.rent-row');
                    if (rentRow) {
                        // --- THIS IS THE FIXED LINE ---
                        // Changed '.room-price-input' to '.room-amount-input'
                        const roomPrice = parseFloat(rentRow.querySelector('.room-amount-input').value) || 0;

                        // The rest of this section is the same
                        itemsHtml += `
                    <tr>
                        <th scope="row">${String(itemCounter++).padStart(2, '0')}</th>
                        <td class="text-start">
                            <span class="fw-medium">Room Rent</span>
                            <p class="text-muted mb-0">(Base rent + amenities)</p>
                        </td>
                        <td>1</td>
                        <td>$${roomPrice.toFixed(2)}</td>
                        <td class="text-end">$${roomPrice.toFixed(2)}</td>
                    </tr>`;
                        subtotal += roomPrice;
                    }
                }

                // Process UTILITY items if applicable (no changes in this section)
                if (formType === 'full' || formType === 'utility') {
                    const utilityRows = Array.from(activeForm.querySelectorAll('.utility-row'))
                        .filter(row => row.offsetParent !== null);
                    utilityRows.forEach(row => {
                        const detail = row.querySelector('.utility-detail-input').value || 'Utility';
                        const qty = parseFloat(row.querySelector('.utility-qty-input').value) || 0;
                        const price = parseFloat(row.querySelector('.utility-price-input').value) || 0;
                        const amount = qty * price;

                        itemsHtml += `
                    <tr>
                        <th scope="row">${String(itemCounter++).padStart(2, '0')}</th>
                        <td class="text-start">${detail}</td>
                        <td>${qty}</td>
                        <td>$${price.toFixed(2)}</td>
                        <td class="text-end">$${amount.toFixed(2)}</td>
                    </tr>`;
                        subtotal += amount;
                    });
                }

                const totalAmount = subtotal;

                // Build the final HTML for the preview (No changes from here on)
                const invoiceHtml = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Invoice #${invoiceNumber}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { font-family: sans-serif; -webkit-print-color-adjust: exact; background-color: #fff !important; }
                    .info-label { font-weight: bold; }
                    .invoice-items-table .totals-row td,
                    .invoice-items-table .final-total-row td,
                    .invoice-items-table .final-total-row th {
                        border: none;
                        padding-top: 0.75rem;
                        padding-bottom: 0.75rem;
                    }
                    .invoice-items-table .totals-row td:nth-last-child(-n+2) {
                        border-top: 1px solid #e9ecef;
                    }
                    .invoice-items-table .final-total-row td,
                    .invoice-items-table .final-total-row th {
                        border-top: 2px solid #212529;
                        border-bottom: 2px solid #212529;
                        font-weight: 700;
                    }
                </style>
            </head>
            <body>
                <div class="container py-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-6"><img src="${logoUrl}" height="60" alt="Logo"></div>
                        <div class="col-6 text-end"><h6>Invoice #${invoiceNumber}</h6></div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-6">
                            <p class="info-label">Bill To:</p>
                            <p>Tenant Name<br>Room ${roomNumber}<br>Phnom Penh</p>
                        </div>
                        <div class="col-6 text-end">
                            <p><span class="info-label">Invoice Date:</span> ${issueDate}</p>
                            <p><span class="info-label">Due Date:</span> ${dueDate}</p>
                        </div>
                    </div>
                    <table class="table invoice-items-table text-center table-nowrap align-middle mb-0">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th class="text-start">Item Details</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                            <tr class="totals-row">
                                <td colspan="3"></td>
                                <td class="text-end">Subtotal</td>
                                <td class="text-end">$${subtotal.toFixed(2)}</td>
                            </tr>
                            <tr class="final-total-row fs-15">
                                <th colspan="3"></th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-end">$${totalAmount.toFixed(2)}</th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-5">
                        <img src="${qrCode1Url}" height="100" class="mx-2" alt="QR Code 1">
                        <img src="${qrCode2Url}" height="100" class="mx-2" alt="QR Code 2">
                    </div>
                </div>
            </body>
            </html>`;

                // Create an iframe to print the content
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                iframe.contentDocument.write(invoiceHtml);
                iframe.contentDocument.close();
                iframe.onload = function () {
                    iframe.contentWindow.print();
                    document.body.removeChild(iframe);
                };
            };

            const previewButtons = document.querySelectorAll('.preview-btn');
            previewButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    generateInvoicePreview(this);
                });
            });

            /*
    |--------------------------------------------------------------------------
    | PART 4: DYNAMIC ITEM ROWS
    |--------------------------------------------------------------------------
    */
            document.addEventListener('click', function (e) {
                // --- Event for ADDING a new utility row ---
                if (e.target.classList.contains('add-utility-btn')) {
                    const formType = e.target.dataset.type;
                    const template = document.getElementById(`utility-row-template-${formType}`);
                    const tableBody = document.getElementById(`invoice-items-body-${formType}`);

                    if (template && tableBody) {
                        // Clone the hidden template
                        const newRow = template.content.cloneNode(true);
                        tableBody.appendChild(newRow);
                        updateRowNumbers(tableBody);
                    }
                }

                // --- Event for REMOVING a row ---
                if (e.target.closest('.remove-item-btn')) {
                    const row = e.target.closest('tr');
                    const tableBody = row.closest('tbody');
                    row.remove();
                    updateRowNumbers(tableBody);
                    // You would also trigger a recalculation of the total summary here
                }
            });

            document.addEventListener('change', function (e) {
                // --- Event for when a UTILITY TYPE is selected in a dropdown ---
                if (e.target.classList.contains('utility-type-select')) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const rate = selectedOption.dataset.rate || 0;
                    const row = e.target.closest('tr');
                    // Set the unit price input in the same row to the rate
                    row.querySelector('.utility-price-input').value = parseFloat(rate).toFixed(4);
                }
            });

            // --- Function to keep the # column correctly numbered ---
            function updateRowNumbers(tableBody) {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    const indexCell = row.querySelector('th:first-child');
                    if (indexCell) {
                        indexCell.textContent = String(index + 1).padStart(2, '0');
                    }
                });
            }

            // Initialize the page by showing the selection cards
            showCardSelection();
        });
    </script>
@endpush