@extends('backends.layouts.app')


@push('style')
    {{-- {{ asset('assets') }}/css/ --}}

    <style>
        .color-swatch {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .color-swatch.active {
            border: 2px solid var(--bs-primary);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>

@endpush


@section('content')
    <div class="page-container">


        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 text-uppercase fw-bold mb-0">Calendar</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Boron</a></li>

                    <li class="breadcrumb-item active">Calendar</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary w-100" id="btn-new-event">
                            <i class="ti ti-plus me-2 align-middle"></i> Set New Price
                        </button>

                        <div id="external-events" class="mt-2">
                            <p class="text-muted">Drag and drop your event or click in the calendar</p>
                            <div class="external-event fc-event bg-success-subtle text-success"
                                data-class="bg-success-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Khmer New Year
                            </div>
                            <div class="external-event fc-event bg-info-subtle text-info" data-class="bg-info-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Pchum Ben
                            </div>
                            <div class="external-event fc-event bg-warning-subtle text-warning"
                                data-class="bg-warning-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Water Festival
                            </div>
                            <div class="external-event fc-event bg-danger-subtle text-danger" data-class="bg-danger-subtle">
                                <i class="ti ti-circle-filled me-2"></i>Royal Ploughing Ceremony
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-standard"
                            style="height: 758px;">
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!--end row-->

        <!-- Add New Event MODAL -->
        <div class="modal fade" id="override-modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="needs-validation" name="override-form" id="override-event" novalidate="">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title">
                                New Price Override Event
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="control-label form-label" for="title">Title</label>
                                        <input class="form-control" type="text" name="title" id="title" required="">
                                        <div class="invalid-feedback">Please provide a valid title.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="control-label form-label" for="price">Override Price
                                            ($)</label>
                                        <input class="form-control" type="number" step="0.01" name="price" id="price"
                                            required="">
                                        <div class="invalid-feedback">Please provide a valid price.</div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="mb-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="start_date"
                                        name="start_date" data-provider="flatpickr" data-date-format="Y-m-d"
                                        readonly="readonly" data-sharkid="__1" required="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="end_date" name="end_date"
                                        data-provider="flatpickr" data-date-format="Y-m-d" readonly="readonly"
                                        data-sharkid="__1" required="">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pick Color</label>
                                <div class="d-flex gap-2 mb-2">
                                    <div class="color-swatch bg-info-subtle active" data-color="bg-info-subtle"></div>
                                    <div class="color-swatch bg-primary-subtle" data-color="bg-primary-subtle"></div>
                                    <div class="color-swatch bg-warning-subtle" data-color="bg-warning-subtle"></div>
                                    <div class="color-swatch bg-danger-subtle" data-color="bg-danger-subtle"></div>
                                    <div class="color-swatch bg-success-subtle" data-color="bg-success-subtle"></div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <button type="button" class="btn btn-danger" id="btn-delete-event" style="display: none;">
                                    Delete
                                </button>

                                <button type="button" class="btn btn-light ms-auto" data-bs-dismiss="modal">
                                    Close
                                </button>

                                <button type="submit" class="btn btn-primary" id="btn-save-event">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end modal-content-->
            </div>
            <!-- end modal dialog-->
        </div>
        <!-- end modal-->

    </div> <!-- container -->
@endsection

@push('script')
    <script src="{{ asset('assets') }}/js/index.global.min.js"></script>

    <script>
        // Data passed from the Laravel Controller
        const calendarEvents = @json($events);
        const storeUrl = '{{ route("landlord.properties.roomTypes.overrides.store", [$property, $roomType]) }}';
        const updateUrlTemplate = '{{ route("landlord.properties.roomTypes.overrides.update", [$property, $roomType, "OVERRIDE_ID"]) }}';
        const deleteUrlTemplate = '{{ route("landlord.properties.roomTypes.overrides.destroy", [$property, $roomType, "OVERRIDE_ID"]) }}';
        const csrfToken = '{{ csrf_token() }}';

        class CalendarSchedule {
            constructor() {
                // DOM Element References
                this.modalEl = document.getElementById("override-modal");
                this.calendarEl = document.getElementById("calendar");
                this.formEventEl = document.getElementById("override-event");
                this.btnNewEventEl = document.getElementById("btn-new-event");
                this.btnDeleteEventEl = document.getElementById("btn-delete-event");

                // Instances and State
                this.modal = new bootstrap.Modal(this.modalEl);
                this.calendar = null;
                this.selectedEvent = null;
            }

            // Formats a Date object into "YYYY-MM-DD"
            _formatDateForInput(date) {
                if (!date) return "";
                const d = new Date(date);
                const pad = (num) => num.toString().padStart(2, '0');
                return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
            }

            // Handler for clicking an existing event on the calendar
            _onEventClick(clickInfo) {
                this.formEventEl.reset();
                this.formEventEl.classList.remove("was-validated");
                this.selectedEvent = clickInfo.event;

                document.getElementById("modal-title").textContent = "Edit Price Override";
                this.btnDeleteEventEl.style.display = "block";

                // Populate form fields
                document.getElementById("title").value = this.selectedEvent.title;
                document.getElementById("price").value = this.selectedEvent.extendedProps.price || '';
                document.getElementById("start_date").value = this._formatDateForInput(this.selectedEvent.start);

                let endDate = this.selectedEvent.end ? new Date(this.selectedEvent.end) : new Date(this.selectedEvent.start);
                if (this.selectedEvent.allDay && this.selectedEvent.end) {
                    endDate.setDate(endDate.getDate() - 1);
                }
                document.getElementById("end_date").value = this._formatDateForInput(endDate);

                // Set the active color swatch
                document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
                const eventColorClass = this.selectedEvent.classNames[0] || this.selectedEvent.extendedProps.color || 'bg-info-subtle';
                const activeSwatch = document.querySelector(`.color-swatch[data-color="${eventColorClass}"]`);
                if (activeSwatch) {
                    activeSwatch.classList.add('active');
                }

                this.modal.show();
            }
            
            // Handler for selecting a new date/range or clicking the "Set New Price" button
            _onSelect(selectionInfo) {
                this.formEventEl.reset();
                this.formEventEl.classList.remove("was-validated");
                this.selectedEvent = null;

                document.getElementById("modal-title").textContent = "Add Price Override";
                this.btnDeleteEventEl.style.display = "none";
                
                // Set default color
                document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
                document.querySelector('.color-swatch[data-color="bg-info-subtle"]').classList.add('active');

                // Handle different selection types
                let startDate = selectionInfo.start;
                // FullCalendar's 'end' for all-day events is exclusive, so subtract one day to make it inclusive for the form
                let endDate = selectionInfo.end ? new Date(selectionInfo.end.getTime() - (24 * 60 * 60 * 1000)) : startDate;

                document.getElementById("start_date").value = this._formatDateForInput(startDate);
                document.getElementById("end_date").value = this._formatDateForInput(endDate);

                this.modal.show();
                if(this.calendar) {
                    this.calendar.unselect();
                }
            }
            
            // Saves updates from drag/drop or resize actions
            async _saveEventUpdate(updateInfo) {
                const event = updateInfo.event;
                const url = updateUrlTemplate.replace('OVERRIDE_ID', event.id);

                let inclusiveEndDate = event.end ? new Date(event.end.getTime()) : new Date(event.start.getTime());
                if (event.allDay && event.end) {
                    inclusiveEndDate.setDate(inclusiveEndDate.getDate() - 1);
                }

                const eventData = {
                    title: event.title,
                    price: event.extendedProps.price,
                    start_date: this._formatDateForInput(event.start),
                    end_date: this._formatDateForInput(inclusiveEndDate),
                    color: event.classNames[0] || 'bg-info-subtle',
                };

                try {
                    const response = await fetch(url, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify(eventData)
                    });

                    if (!response.ok) {
                         const errorData = await response.json();
                         throw new Error(errorData.message || 'Failed to save event update.');
                    }
                    // On success, the visual change is already done, just show the toast
                    Swal.fire({ position: "top-end", title: "Event Updated!", width: 500, padding: 30, background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-5.jpg') }}) no-repeat center", showConfirmButton: false, timer: 4000, customClass: { title: 'swal-title-success' } });

                } catch (error) {
                    console.error('Error updating event:', error);
                    updateInfo.revert(); // Revert the visual change on the calendar
                    Swal.fire({ position: "top-end", title: "Could not save change", text: error.message, icon: 'error', showConfirmButton: false, timer: 4000 });
                }
            }

            // Handles confirmation for drag/drop and resize
            _handleEventUpdate(updateInfo) {
                Swal.fire({
                    title: "Are you sure?", text: "Do you want to save the new date for this event?", icon: "warning", showCancelButton: true, confirmButtonText: "Yes, save it!", cancelButtonText: "No, cancel", confirmButtonColor: "#70bb63", cancelButtonColor: "#d33", customClass: { confirmButton: "swal2-confirm btn btn-success me-2 mt-2", cancelButton: "swal2-cancel btn btn-danger mt-2", }, buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this._saveEventUpdate(updateInfo);
                    } else {
                        updateInfo.revert();
                    }
                });
            }

            // Main initialization method
            init() {
                // Make sidebar events draggable
                const externalEventsContainer = document.getElementById('external-events');
                if (externalEventsContainer) {
                    new FullCalendar.Draggable(externalEventsContainer, {
                        itemSelector: '.external-event',
                        eventData: function(eventEl) {
                            return {
                                title: eventEl.innerText.trim(),
                                className: eventEl.getAttribute('data-class') || 'bg-info-subtle',
                                extendedProps: { price: '' } // Price will be set in the modal
                            };
                        }
                    });
                }

                // Initialize the Calendar
                this.calendar = new FullCalendar.Calendar(this.calendarEl, {
                    initialEvents: calendarEvents,
                    themeSystem: "bootstrap",
                    headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
                    editable: true,
                    selectable: true,
                    droppable: true, // This is essential!
                    height: window.innerHeight - 200,

                    // === HOOK FOR DROPPING EXTERNAL EVENTS ===
                    eventReceive: (info) => {
                        const title = info.event.title;
                        const colorClass = info.event.classNames[0];
                        const startDate = info.event.start;

                        info.event.remove(); // Remove the temporary event

                        // Open the modal and pre-fill the form
                        this.formEventEl.reset();
                        this.formEventEl.classList.remove("was-validated");
                        this.selectedEvent = null;
                        document.getElementById("modal-title").textContent = "Add Dropped Event";
                        this.btnDeleteEventEl.style.display = "none";
                        
                        document.getElementById("title").value = title;
                        document.getElementById("price").value = '';
                        document.getElementById("start_date").value = this._formatDateForInput(startDate);
                        document.getElementById("end_date").value = this._formatDateForInput(startDate);
                        
                        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
                        const activeSwatch = document.querySelector(`.color-swatch[data-color="${colorClass}"]`);
                        if (activeSwatch) activeSwatch.classList.add('active');

                        this.modal.show();
                    },

                    // All other hooks
                    eventDrop: (info) => this._handleEventUpdate(info),
                    eventResize: (info) => this._handleEventUpdate(info),
                    eventClick: (info) => this._onEventClick(info),
                    select: (info) => this._onSelect(info)
                });

                this.calendar.render();

                // === ATTACH EVENT LISTENERS ===
                this.btnNewEventEl.addEventListener("click", () => {
                    const today = new Date();
                    // Call _onSelect with an object that mimics a one-day calendar selection
                    this._onSelect({ start: today, end: new Date(today.getTime() + (24*60*60*1000)) });
                });

                this.btnDeleteEventEl.addEventListener("click", () => {
                     if (!this.selectedEvent) return;
                     Swal.fire({
                         title: "Are you sure?", text: `Event "${this.selectedEvent.title}" will be permanently deleted!`, icon: "warning", showCancelButton: true, confirmButtonText: "Yes, delete it!", cancelButtonText: "No, cancel", confirmButtonColor: "#d33", customClass: { confirmButton: "swal2-confirm btn btn-danger me-2 mt-2", cancelButton: "swal2-cancel btn btn-secondary mt-2" }, buttonsStyling: false
                     }).then(async (result) => {
                         if (result.isConfirmed) {
                             const url = deleteUrlTemplate.replace('OVERRIDE_ID', this.selectedEvent.id);
                             try {
                                 const response = await fetch(url, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }});
                                 if (!response.ok) {
                                     const errorData = await response.json();
                                     throw new Error(errorData.message || 'Failed to delete');
                                 }
                                 this.selectedEvent.remove();
                                 this.modal.hide();
                                 Swal.fire({ position: "top-end", title: "Event Deleted!", width: 500, padding: 30, background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-5.jpg') }}) no-repeat center", showConfirmButton: false, timer: 4000, customClass: { title: 'swal-title-success' } });
                             } catch (error) {
                                 Swal.fire({ title: "Error", text: error.message, icon: "error" });
                             }
                         }
                     });
                });

                this.formEventEl.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const saveButton = document.getElementById('btn-save-event');
                    if (!this.formEventEl.checkValidity()) {
                        e.stopPropagation();
                        this.formEventEl.classList.add("was-validated");
                        return;
                    }
                    saveButton.disabled = true;
                    saveButton.innerHTML = 'Saving...';
                    const activeSwatch = document.querySelector('.color-swatch.active');
                    const colorClassNameToSave = activeSwatch ? activeSwatch.getAttribute('data-color') : 'bg-info-subtle';
                    const eventData = {
                        title: document.getElementById("title").value,
                        price: document.getElementById("price").value,
                        start_date: document.getElementById("start_date").value,
                        end_date: document.getElementById("end_date").value,
                        color: colorClassNameToSave,
                    };

                    let url = storeUrl;
                    let method = 'POST';
                    if (this.selectedEvent) {
                        url = updateUrlTemplate.replace('OVERRIDE_ID', this.selectedEvent.id);
                        method = 'PUT';
                    }

                    try {
                        const response = await fetch(url, { method: method, headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify(eventData) });
                        const resultData = await response.json();
                        if (!response.ok) {
                             let errorText = resultData.message || "An unknown error occurred.";
                             if(resultData.errors) { errorText = Object.values(resultData.errors).flat().join(' '); }
                             throw new Error(errorText);
                        }

                        let successMessage = '';
                        if (method === 'POST') {
                            this.calendar.addEvent(resultData);
                            successMessage = 'Event created successfully!';
                        } else {
                            this.selectedEvent.remove();
                            this.calendar.addEvent(resultData);
                            successMessage = 'Event updated successfully!';
                        }
                        this.modal.hide();
                        Swal.fire({ position: "top-end", title: successMessage, width: 500, padding: 30, background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-5.jpg') }}) no-repeat center", showConfirmButton: false, timer: 4000, customClass: { title: 'swal-title-success' } });

                    } catch (error) {
                        Swal.fire({ position: "top-end", title: "Error!", text: error.message, icon: "error", showConfirmButton: false, timer: 6000, background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-4.jpg') }}) no-repeat center", customClass: { title: 'swal-title-error', htmlContainer: 'swal-text-error' } });
                    } finally {
                        saveButton.disabled = false;
                        saveButton.innerHTML = 'Save';
                    }
                });
            }
        }

        // --- SCRIPT EXECUTION STARTS HERE ---
        document.addEventListener('DOMContentLoaded', () => {
            const colorSwatches = document.querySelectorAll('.color-swatch');
            colorSwatches.forEach(swatchToActivate => {
                swatchToActivate.addEventListener('click', () => {
                    colorSwatches.forEach(s => s.classList.remove('active'));
                    swatchToActivate.classList.add('active');
                });
            });

            (new CalendarSchedule()).init();
        });
    </script>
@endpush