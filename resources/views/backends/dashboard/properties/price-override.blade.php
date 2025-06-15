@extends('backends.layouts.app')


@push('style')
    {{-- {{ asset('assets') }}/css/ --}}
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
                            <div class="fc-header-toolbar fc-toolbar fc-toolbar-ltr">
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group"><button type="button" title="Previous Month"
                                            aria-pressed="false"
                                            class="fc-prev-button fc-button fc-button-primary">Prev</button><button
                                            type="button" title="Next Month" aria-pressed="false"
                                            class="fc-next-button fc-button fc-button-primary">Next</button></div><button
                                        type="button" title="This Month" disabled="" aria-pressed="false"
                                        class="fc-today-button fc-button fc-button-primary">Today</button>
                                </div>
                                <div class="fc-toolbar-chunk">
                                    <h2 class="fc-toolbar-title" id="fc-dom-1">May 2025</h2>
                                </div>
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group"><button type="button" title="Month view"
                                            aria-pressed="true"
                                            class="fc-dayGridMonth-button fc-button fc-button-primary fc-button-active">Month</button><button
                                            type="button" title="Week view" aria-pressed="false"
                                            class="fc-timeGridWeek-button fc-button fc-button-primary">Week</button><button
                                            type="button" title="Day view" aria-pressed="false"
                                            class="fc-timeGridDay-button fc-button fc-button-primary">Day</button><button
                                            type="button" title="List view" aria-pressed="false"
                                            class="fc-listMonth-button fc-button fc-button-primary">List</button></div>
                                </div>
                            </div>
                            <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active">
                                <div class="fc-dayGridMonth-view fc-view fc-daygrid">
                                    <table role="grid" class="fc-scrollgrid  fc-scrollgrid-liquid">
                                        <thead role="rowgroup">
                                            <tr role="presentation"
                                                class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                                                <th role="presentation">
                                                    <div class="fc-scroller-harness">
                                                        <div class="fc-scroller" style="overflow: hidden;">
                                                            <table role="presentation" class="fc-col-header "
                                                                style="width: 1225px;">
                                                                <colgroup></colgroup>
                                                                <thead role="presentation">
                                                                    <tr role="row">
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-sun">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Sunday"
                                                                                    class="fc-col-header-cell-cushion">Sun</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-mon">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Monday"
                                                                                    class="fc-col-header-cell-cushion">Mon</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-tue">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Tuesday"
                                                                                    class="fc-col-header-cell-cushion">Tue</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-wed">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Wednesday"
                                                                                    class="fc-col-header-cell-cushion">Wed</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-thu">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Thursday"
                                                                                    class="fc-col-header-cell-cushion">Thu</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-fri">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Friday"
                                                                                    class="fc-col-header-cell-cushion">Fri</a>
                                                                            </div>
                                                                        </th>
                                                                        <th role="columnheader"
                                                                            class="fc-col-header-cell fc-day fc-day-sat">
                                                                            <div class="fc-scrollgrid-sync-inner"><a
                                                                                    aria-label="Saturday"
                                                                                    class="fc-col-header-cell-cushion">Sat</a>
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                            <tr role="presentation"
                                                class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                                                <td role="presentation">
                                                    <div class="fc-scroller-harness fc-scroller-harness-liquid">
                                                        <div class="fc-scroller fc-scroller-liquid-absolute"
                                                            style="overflow: hidden auto;">
                                                            <div class="fc-daygrid-body fc-daygrid-body-unbalanced "
                                                                style="width: 1225px;">
                                                                <table role="presentation" class="fc-scrollgrid-sync-table"
                                                                    style="width: 1225px; height: 660px;">
                                                                    <colgroup></colgroup>
                                                                    <tbody role="presentation">
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-2" role="gridcell"
                                                                                data-date="2025-04-27"
                                                                                class="fc-day fc-day-sun fc-day-past fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="April 27, 2025"
                                                                                            id="fc-dom-2"
                                                                                            class="fc-daygrid-day-number">27</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-4" role="gridcell"
                                                                                data-date="2025-04-28"
                                                                                class="fc-day fc-day-mon fc-day-past fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="April 28, 2025"
                                                                                            id="fc-dom-4"
                                                                                            class="fc-daygrid-day-number">28</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-6" role="gridcell"
                                                                                data-date="2025-04-29"
                                                                                class="fc-day fc-day-tue fc-day-past fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="April 29, 2025"
                                                                                            id="fc-dom-6"
                                                                                            class="fc-daygrid-day-number">29</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-8" role="gridcell"
                                                                                data-date="2025-04-30"
                                                                                class="fc-day fc-day-wed fc-day-past fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="April 30, 2025"
                                                                                            id="fc-dom-8"
                                                                                            class="fc-daygrid-day-number">30</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-10" role="gridcell"
                                                                                data-date="2025-05-01"
                                                                                class="fc-day fc-day-thu fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 1, 2025"
                                                                                            id="fc-dom-10"
                                                                                            class="fc-daygrid-day-number">1</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-12" role="gridcell"
                                                                                data-date="2025-05-02"
                                                                                class="fc-day fc-day-fri fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 2, 2025"
                                                                                            id="fc-dom-12"
                                                                                            class="fc-daygrid-day-number">2</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-14" role="gridcell"
                                                                                data-date="2025-05-03"
                                                                                class="fc-day fc-day-sat fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 3, 2025"
                                                                                            id="fc-dom-14"
                                                                                            class="fc-daygrid-day-number">3</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-16" role="gridcell"
                                                                                data-date="2025-05-04"
                                                                                class="fc-day fc-day-sun fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 4, 2025"
                                                                                            id="fc-dom-16"
                                                                                            class="fc-daygrid-day-number">4</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-18" role="gridcell"
                                                                                data-date="2025-05-05"
                                                                                class="fc-day fc-day-mon fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 5, 2025"
                                                                                            id="fc-dom-18"
                                                                                            class="fc-daygrid-day-number">5</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-20" role="gridcell"
                                                                                data-date="2025-05-06"
                                                                                class="fc-day fc-day-tue fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 6, 2025"
                                                                                            id="fc-dom-20"
                                                                                            class="fc-daygrid-day-number">6</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-22" role="gridcell"
                                                                                data-date="2025-05-07"
                                                                                class="fc-day fc-day-wed fc-day-past fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 7, 2025"
                                                                                            id="fc-dom-22"
                                                                                            class="fc-daygrid-day-number">7</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-24" role="gridcell"
                                                                                data-date="2025-05-08"
                                                                                class="fc-day fc-day-thu fc-day-today fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 8, 2025"
                                                                                            id="fc-dom-24"
                                                                                            class="fc-daygrid-day-number">8</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 0px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-today bg-primary fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    5:51p</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Interview - Backend
                                                                                                    Engineer</div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 0px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-today bg-warning fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    9:27p</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Meeting with CT Team
                                                                                                </div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-26" role="gridcell"
                                                                                data-date="2025-05-09"
                                                                                class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 9, 2025"
                                                                                            id="fc-dom-26"
                                                                                            class="fc-daygrid-day-number">9</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness fc-daygrid-event-harness-abs"
                                                                                            style="top: 0px; left: 0px; right: -175.567px;">
                                                                                            <a tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-start fc-event-end fc-event-future bg-secondary fc-daygrid-event fc-daygrid-block-event fc-h-event">
                                                                                                <div class="fc-event-main">
                                                                                                    <div
                                                                                                        class="fc-event-main-frame">
                                                                                                        <div
                                                                                                            class="fc-event-time">
                                                                                                            10:40a</div>
                                                                                                        <div
                                                                                                            class="fc-event-title-container">
                                                                                                            <div
                                                                                                                class="fc-event-title fc-sticky">
                                                                                                                Interview -
                                                                                                                Frontend
                                                                                                                Engineer
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 38px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-28" role="gridcell"
                                                                                data-date="2025-05-10"
                                                                                class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 10, 2025"
                                                                                            id="fc-dom-28"
                                                                                            class="fc-daygrid-day-number">10</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 38px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future bg-success fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    4:31p</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Phone Screen - Frontend
                                                                                                    Engineer</div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-30" role="gridcell"
                                                                                data-date="2025-05-11"
                                                                                class="fc-day fc-day-sun fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 11, 2025"
                                                                                            id="fc-dom-30"
                                                                                            class="fc-daygrid-day-number">11</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-32" role="gridcell"
                                                                                data-date="2025-05-12"
                                                                                class="fc-day fc-day-mon fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 12, 2025"
                                                                                            id="fc-dom-32"
                                                                                            class="fc-daygrid-day-number">12</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 0px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future bg-info fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    7:24a</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Meeting with Mr. Admin
                                                                                                </div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 0px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future bg-primary fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    1:31p</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Buy Design Assets</div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-34" role="gridcell"
                                                                                data-date="2025-05-13"
                                                                                class="fc-day fc-day-tue fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 13, 2025"
                                                                                            id="fc-dom-34"
                                                                                            class="fc-daygrid-day-number">13</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-36" role="gridcell"
                                                                                data-date="2025-05-14"
                                                                                class="fc-day fc-day-wed fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 14, 2025"
                                                                                            id="fc-dom-36"
                                                                                            class="fc-daygrid-day-number">14</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-38" role="gridcell"
                                                                                data-date="2025-05-15"
                                                                                class="fc-day fc-day-thu fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 15, 2025"
                                                                                            id="fc-dom-38"
                                                                                            class="fc-daygrid-day-number">15</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-40" role="gridcell"
                                                                                data-date="2025-05-16"
                                                                                class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 16, 2025"
                                                                                            id="fc-dom-40"
                                                                                            class="fc-daygrid-day-number">16</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-42" role="gridcell"
                                                                                data-date="2025-05-17"
                                                                                class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 17, 2025"
                                                                                            id="fc-dom-42"
                                                                                            class="fc-daygrid-day-number">17</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-44" role="gridcell"
                                                                                data-date="2025-05-18"
                                                                                class="fc-day fc-day-sun fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 18, 2025"
                                                                                            id="fc-dom-44"
                                                                                            class="fc-daygrid-day-number">18</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-46" role="gridcell"
                                                                                data-date="2025-05-19"
                                                                                class="fc-day fc-day-mon fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 19, 2025"
                                                                                            id="fc-dom-46"
                                                                                            class="fc-daygrid-day-number">19</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-48" role="gridcell"
                                                                                data-date="2025-05-20"
                                                                                class="fc-day fc-day-tue fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 20, 2025"
                                                                                            id="fc-dom-48"
                                                                                            class="fc-daygrid-day-number">20</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness fc-daygrid-event-harness-abs"
                                                                                            style="top: 0px; left: 0px; right: -175px;">
                                                                                            <a tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-start fc-event-end fc-event-future bg-danger fc-daygrid-event fc-daygrid-block-event fc-h-event">
                                                                                                <div class="fc-event-main">
                                                                                                    <div
                                                                                                        class="fc-event-main-frame">
                                                                                                        <div
                                                                                                            class="fc-event-time">
                                                                                                            9:51a</div>
                                                                                                        <div
                                                                                                            class="fc-event-title-container">
                                                                                                            <div
                                                                                                                class="fc-event-title fc-sticky">
                                                                                                                Setup Github
                                                                                                                Repository
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 38px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-50" role="gridcell"
                                                                                data-date="2025-05-21"
                                                                                class="fc-day fc-day-wed fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 21, 2025"
                                                                                            id="fc-dom-50"
                                                                                            class="fc-daygrid-day-number">21</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 38px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-52" role="gridcell"
                                                                                data-date="2025-05-22"
                                                                                class="fc-day fc-day-thu fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 22, 2025"
                                                                                            id="fc-dom-52"
                                                                                            class="fc-daygrid-day-number">22</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-54" role="gridcell"
                                                                                data-date="2025-05-23"
                                                                                class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 23, 2025"
                                                                                            id="fc-dom-54"
                                                                                            class="fc-daygrid-day-number">23</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-56" role="gridcell"
                                                                                data-date="2025-05-24"
                                                                                class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 24, 2025"
                                                                                            id="fc-dom-56"
                                                                                            class="fc-daygrid-day-number">24</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-58" role="gridcell"
                                                                                data-date="2025-05-25"
                                                                                class="fc-day fc-day-sun fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 25, 2025"
                                                                                            id="fc-dom-58"
                                                                                            class="fc-daygrid-day-number">25</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-60" role="gridcell"
                                                                                data-date="2025-05-26"
                                                                                class="fc-day fc-day-mon fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 26, 2025"
                                                                                            id="fc-dom-60"
                                                                                            class="fc-daygrid-day-number">26</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-62" role="gridcell"
                                                                                data-date="2025-05-27"
                                                                                class="fc-day fc-day-tue fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 27, 2025"
                                                                                            id="fc-dom-62"
                                                                                            class="fc-daygrid-day-number">27</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-64" role="gridcell"
                                                                                data-date="2025-05-28"
                                                                                class="fc-day fc-day-wed fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 28, 2025"
                                                                                            id="fc-dom-64"
                                                                                            class="fc-daygrid-day-number">28</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-66" role="gridcell"
                                                                                data-date="2025-05-29"
                                                                                class="fc-day fc-day-thu fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 29, 2025"
                                                                                            id="fc-dom-66"
                                                                                            class="fc-daygrid-day-number">29</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-68" role="gridcell"
                                                                                data-date="2025-05-30"
                                                                                class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 30, 2025"
                                                                                            id="fc-dom-68"
                                                                                            class="fc-daygrid-day-number">30</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-70" role="gridcell"
                                                                                data-date="2025-05-31"
                                                                                class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="May 31, 2025"
                                                                                            id="fc-dom-70"
                                                                                            class="fc-daygrid-day-number">31</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr role="row">
                                                                            <td aria-labelledby="fc-dom-72" role="gridcell"
                                                                                data-date="2025-06-01"
                                                                                class="fc-day fc-day-sun fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 1, 2025"
                                                                                            id="fc-dom-72"
                                                                                            class="fc-daygrid-day-number">1</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-74" role="gridcell"
                                                                                data-date="2025-06-02"
                                                                                class="fc-day fc-day-mon fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 2, 2025"
                                                                                            id="fc-dom-74"
                                                                                            class="fc-daygrid-day-number">2</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-76" role="gridcell"
                                                                                data-date="2025-06-03"
                                                                                class="fc-day fc-day-tue fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 3, 2025"
                                                                                            id="fc-dom-76"
                                                                                            class="fc-daygrid-day-number">3</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-78" role="gridcell"
                                                                                data-date="2025-06-04"
                                                                                class="fc-day fc-day-wed fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 4, 2025"
                                                                                            id="fc-dom-78"
                                                                                            class="fc-daygrid-day-number">4</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-80" role="gridcell"
                                                                                data-date="2025-06-05"
                                                                                class="fc-day fc-day-thu fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 5, 2025"
                                                                                            id="fc-dom-80"
                                                                                            class="fc-daygrid-day-number">5</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-82" role="gridcell"
                                                                                data-date="2025-06-06"
                                                                                class="fc-day fc-day-fri fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 6, 2025"
                                                                                            id="fc-dom-82"
                                                                                            class="fc-daygrid-day-number">6</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-event-harness"
                                                                                            style="margin-top: 0px;"><a
                                                                                                tabindex="0"
                                                                                                class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future bg-dark fc-daygrid-event fc-daygrid-dot-event">
                                                                                                <div
                                                                                                    class="fc-daygrid-event-dot">
                                                                                                </div>
                                                                                                <div class="fc-event-time">
                                                                                                    6:31p</div>
                                                                                                <div class="fc-event-title">
                                                                                                    Meeting with Mr. Shreyu
                                                                                                </div>
                                                                                            </a></div>
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td aria-labelledby="fc-dom-84" role="gridcell"
                                                                                data-date="2025-06-07"
                                                                                class="fc-day fc-day-sat fc-day-future fc-day-other fc-daygrid-day">
                                                                                <div
                                                                                    class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                    <div class="fc-daygrid-day-top"><a
                                                                                            aria-label="June 7, 2025"
                                                                                            id="fc-dom-84"
                                                                                            class="fc-daygrid-day-number">7</a>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-events">
                                                                                        <div class="fc-daygrid-day-bottom"
                                                                                            style="margin-top: 0px;"></div>
                                                                                    </div>
                                                                                    <div class="fc-daygrid-day-bg"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!--end row-->

        <!-- Add New Event MODAL -->
        <div class="modal fade" id="event-modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="needs-validation" name="event-form" id="forms-event" novalidate="">
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
                                        <label class="control-label form-label" for="override-reason">Reason</label>
                                        <input class="form-control" placeholder="e.g., Khmer New Year Special" type="text"
                                            name="reason" id="override-reason">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="control-label form-label" for="override-price">Override Price
                                            ($)</label>
                                        <input class="form-control" placeholder="e.g., 150.00" type="number" step="0.01"
                                            name="price" id="override-price" required="">
                                        <div class="invalid-feedback">Please provide a valid price.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="start_date"
                                        name="start_date" data-provider="flatpickr" data-date-format="d M, Y"
                                        readonly="readonly" value="<?php echo date('d M, Y'); ?>" data-sharkid="__1">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" class="form-control flatpickr-input" id="end_date" name="end_date"
                                        data-provider="flatpickr" data-date-format="d M, Y" readonly="readonly"
                                        data-sharkid="__1">
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
    <!-- Fullcalendar js -->
    <script src="{{ asset('assets') }}/js/index.global.min.js"></script>

    <!-- Calendar App Demo js -->
    <script src="{{ asset('assets') }}/js/apps-calendar.js"></script>
@endpush
