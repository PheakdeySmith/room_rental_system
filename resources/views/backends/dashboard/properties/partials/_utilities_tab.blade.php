<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="card-title mb-0">Manage Utility Readings</h4>
    <a href="#" class="btn btn-sm btn-outline-primary">Manage Property Rates</a>
</div>

<ul class="nav nav-tabs mb-3" id="utilitiesTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-rooms-tab" data-bs-toggle="tab" data-bs-target="#all-rooms-pane"
            type="button" role="tab" aria-controls="all-rooms-pane" aria-selected="true">
            <i class="ti ti-list-details"></i>
            <span class="d-none d-sm-inline ms-1">All Rooms</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="recorded-tab" data-bs-toggle="tab" data-bs-target="#recorded-pane" type="button"
            role="tab" aria-controls="recorded-pane" aria-selected="false">
            <i class="ti ti-circle-check"></i>
            <span class="d-none d-sm-inline ms-1">Recorded</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="needs-reading-tab" data-bs-toggle="tab" data-bs-target="#needs-reading-pane"
            type="button" role="tab" aria-controls="needs-reading-pane" aria-selected="false">
            <i class="ti ti-alert-triangle"></i>
            <span class="d-none d-sm-inline ms-1">Needs Reading</span>
        </button>
    </li>
</ul>

<div class="mb-3">
    <input type="text" id="roomSearchInput" class="form-control" placeholder="Search by Room, Tenant, or Meter #...">
</div>

<div class="tab-content" id="utilitiesTabContent">

    <div class="tab-pane fade show active" id="all-rooms-pane" role="tabpanel" aria-labelledby="all-rooms-tab"
        tabindex="0">
        <div class="accordion" id="allRoomsAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-all-101"><button class="accordion-button collapsed"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse-all-101"><span
                            class="fw-bold me-2">Room 101</span> - <span class="text-muted ms-2">Chan Maly</span><span
                            class="badge bg-success-subtle text-success ms-auto"><i
                                class="ti ti-check me-1"></i>Recorded</span></button></h2>
                <div id="collapse-all-101" class="accordion-collapse collapse" data-bs-parent="#allRoomsAccordion">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-end mb-3"><button class="btn btn-sm btn-success"
                                data-bs-toggle="modal" data-bs-target="#assignMeterModal"><i
                                    class="ti ti-plus me-1"></i> Assign New Meter</button></div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="ti ti-bolt text-warning me-2"></i>Electricity Meter
                                        <small class="text-muted">#ELEC101</small></h6><small
                                        class="text-muted">Installed: Jan 01, 2025</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-none d-md-flex">
                                    <div class="col-md-4 border-end">
                                        <h5>Record New Reading</h5>
                                        <form action="#">
                                            <div class="mb-2"><label for="all-elec-1-d" class="form-label">New
                                                    Value</label><input type="number" step="0.01" class="form-control"
                                                    id="all-elec-1-d"></div><button type="submit"
                                                class="btn btn-sm btn-primary w-100">Save</button>
                                        </form>
                                        <hr>
                                        <div><small class="text-muted d-block">Last Reading:</small>
                                            <h5 class="mb-0">1650.75 kWh</h5><small class="text-muted">on Jul 01</small>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>History</h5>
                                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                            <table class="table table-sm table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Value</th>
                                                        <th>Usage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jul 01</td>
                                                        <td>1650.75</td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success">150.25</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jun 01</td>
                                                        <td>1500.50</td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success">145.50</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>May 01</td>
                                                        <td>1355.00</td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success">130.00</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-md-none">
                                    <ul class="nav nav-pills nav-fill btn-group mb-3">
                                        <li class="nav-item"><button class="btn btn-sm btn-outline-primary active"
                                                data-bs-toggle="tab" data-bs-target="#all-rec-elec-1">Record</button>
                                        </li>
                                        <li class="nav-item"><button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="tab" data-bs-target="#all-hist-elec-1">History</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="all-rec-elec-1">
                                            <form action="#">
                                                <div class="mb-2"><label for="all-elec-1-m" class="form-label">New
                                                        Value</label><input type="number" step="0.01"
                                                        class="form-control" id="all-elec-1-m"></div><button
                                                    type="submit" class="btn btn-primary w-100">Save</button>
                                            </form>
                                            <hr>
                                            <div class="text-center"><small class="text-muted d-block">Last
                                                    Reading:</small>
                                                <h5 class="mb-0">1650.75 kWh</h5><small class="text-muted">on Jul
                                                    01</small>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="all-hist-elec-1">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Jul 01</td>
                                                            <td>1650.75</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jun 01</td>
                                                            <td>1500.50</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="ti ti-droplet text-info me-2"></i>Water Meter <small
                                            class="text-muted">#WAT101</small></h6><small class="text-muted">Installed:
                                        Jan 01, 2025</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-none d-md-flex">
                                    <div class="col-md-4 border-end">
                                        <h5>Record New Reading</h5>
                                        <form action="#">
                                            <div class="mb-2"><label for="all-wat-1-d" class="form-label">New
                                                    Value</label><input type="number" step="0.01" class="form-control"
                                                    id="all-wat-1-d"></div><button type="submit"
                                                class="btn btn-sm btn-primary w-100">Save</button>
                                        </form>
                                        <hr>
                                        <div><small class="text-muted d-block">Last Reading:</small>
                                            <h5 class="mb-0">225.00 m³</h5><small class="text-muted">on Jul 01</small>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>History</h5>
                                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                            <table class="table table-sm table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Value</th>
                                                        <th>Usage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jul 01</td>
                                                        <td>225.00</td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success">22.50</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jun 01</td>
                                                        <td>202.50</td>
                                                        <td><span
                                                                class="badge bg-success-subtle text-success">21.00</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-md-none">
                                    <p class="text-center text-muted">Mobile view for Water Meter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-all-102"><span class="fw-bold me-2">Room
                            102</span> - <span class="text-muted ms-2">Borey Sovann</span><span
                            class="badge bg-warning-subtle text-warning ms-auto"><i
                                class="ti ti-clock-hour-4 me-1"></i>Needs Reading</span></button></h2>
                <div id="collapse-all-102" class="accordion-collapse collapse" data-bs-parent="#allRoomsAccordion">
                    <div class="accordion-body">
                        <div class="card mb-3 border-warning">
                            <div class="card-header bg-warning-subtle">
                                <h6 class="mb-0"><i class="ti ti-bolt text-warning me-2"></i>Electricity Meter <small
                                        class="text-muted">#ELEC102</small></h6>
                            </div>
                            <div class="card-body">...</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item border border-danger">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-all-103"><span class="fw-bold me-2">Room
                            103</span> - <span class="text-muted ms-2">Sokun Nareth</span><span
                            class="badge bg-danger-subtle text-danger ms-auto"><i
                                class="ti ti-alert-triangle me-1"></i>2 Months Overdue</span></button></h2>
                <div id="collapse-all-103" class="accordion-collapse collapse" data-bs-parent="#allRoomsAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Warning: Reading Overdue!</h4>
                            <p>The last meter reading was recorded on <strong>May 01, 2025</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-all-201"><span class="fw-bold me-2">Room
                            201</span> - <span class="text-muted ms-2 fst-italic">Vacant</span><span
                            class="badge bg-secondary-subtle text-secondary ms-auto"><i
                                class="ti ti-moon me-1"></i>Vacant</span></button></h2>
                <div id="collapse-all-201" class="accordion-collapse collapse" data-bs-parent="#allRoomsAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-secondary text-center">This room is vacant. Meter readings are paused.
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-all-202"><span class="fw-bold me-2">Room
                            202</span> - <span class="text-muted ms-2">Dara Khim</span><span
                            class="badge bg-info-subtle text-info ms-auto"><i class="ti ti-help-hexagon me-1"></i>No
                            Meters</span></button></h2>
                <div id="collapse-all-202" class="accordion-collapse collapse" data-bs-parent="#allRoomsAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-info text-center">
                            <p class="mb-2">No utility meters have been assigned.</p><button
                                class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#assignMeterModal"><i class="ti ti-plus me-1"></i> Assign First
                                Meter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="recorded-pane" role="tabpanel" aria-labelledby="recorded-tab" tabindex="0">
        <div class="accordion" id="recordedAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-rec-101"><button class="accordion-button collapsed"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse-rec-101"><span
                            class="fw-bold me-2">Room 101</span> - <span class="text-muted ms-2">Chan Maly</span><span
                            class="badge bg-success-subtle text-success ms-auto"><i
                                class="ti ti-check me-1"></i>Recorded</span></button></h2>
                <div id="collapse-rec-101" class="accordion-collapse collapse" data-bs-parent="#recordedAccordion">
                    <div class="accordion-body">
                        <p class="text-muted text-center py-5">Full details for Room 101 would be duplicated here to
                            simulate the filter.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="needs-reading-pane" role="tabpanel" aria-labelledby="needs-reading-tab" tabindex="0">
        <div class="accordion" id="needsReadingAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-needs-102"><span class="fw-bold me-2">Room
                            102</span> - <span class="text-muted ms-2">Borey Sovann</span><span
                            class="badge bg-warning-subtle text-warning ms-auto"><i
                                class="ti ti-clock-hour-4 me-1"></i>Needs Reading</span></button></h2>
                <div id="collapse-needs-102" class="accordion-collapse collapse"
                    data-bs-parent="#needsReadingAccordion">
                    <div class="accordion-body">
                        <p class="text-muted text-center py-5">Details for Room 102 would be duplicated here.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item border border-danger">
                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-needs-103"><span class="fw-bold me-2">Room
                            103</span> - <span class="text-muted ms-2">Sokun Nareth</span><span
                            class="badge bg-danger-subtle text-danger ms-auto"><i
                                class="ti ti-alert-triangle me-1"></i>2 Months Overdue</span></button></h2>
                <div id="collapse-needs-103" class="accordion-collapse collapse"
                    data-bs-parent="#needsReadingAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Warning: Reading Overdue!</h4>
                            <p>The last meter reading was on <strong>May 01, 2025</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignMeterModal" tabindex="-1" aria-labelledby="assignMeterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignMeterModalLabel">Assign New Meter</h5><button type="button"
                    class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="assignMeterForm">
                    <div class="mb-3"><label class="form-label">Assigning to Room:</label><input type="text"
                            class="form-control" id="modalRoomNumber" value="202" disabled></div>
                    <div class="mb-3"><label for="utility_type" class="form-label">Utility Type</label><select
                            class="form-select" id="utility_type" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="1">Electricity</option>
                            <option value="2">Water</option>
                        </select></div>
                    <div class="mb-3"><label for="meter_number" class="form-label">Meter Number</label><input
                            type="text" class="form-control" id="meter_number" required></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label for="initial_reading" class="form-label">Initial
                                Reading</label><input type="number" step="0.01" class="form-control"
                                id="initial_reading" value="0.00" required></div>
                        <div class="col-md-6 mb-3"><label for="installed_at" class="form-label">Installation
                                Date</label><input type="date" class="form-control" id="installed_at" value="2025-07-07"
                                required></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary"
                    form="assignMeterForm">Save Meter</button></div>
        </div>
    </div>
</div>