<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="{{ asset('assets') }}/images/logo.png" alt="logo"></span>
            <span class="logo-sm text-center"><img src="{{ asset('assets') }}/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets') }}/images/logo-dark.png" alt="dark logo"></span>
            <span class="logo-sm text-center"><img src="{{ asset('assets') }}/images/logo-sm.png"
                    alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar="init" class="simplebar-scrollable-y">
        <div class="simplebar-content-wrapper active" tabindex="0" role="region" aria-label="scrollable content"
            style="height: 100%;">
            <div class="simplebar-content">

                <!--- Sidenav Menu -->
                <ul class="side-nav">

                    <li class="side-nav-item">
                        <a href="{{ route('dashboard') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                            <span class="badge bg-success rounded-pill">5</span>
                        </a>
                    </li>

                    <li class="side-nav-title mt-2">Apps &amp; Pages</li>

                    @php
    $isRoomActive = request()->is('landlord/rooms*') || request()->is('admin/rooms*');
@endphp

<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarRoom" aria-expanded="{{ $isRoomActive ? 'true' : 'false' }}"
        aria-controls="sidebarRoom" class="side-nav-link">
        <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
        <span class="menu-text"> Room </span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse {{ $isRoomActive ? 'show' : '' }}" id="sidebarRoom">
        <ul class="sub-menu">
            <li class="side-nav-item">
                <a href="{{ url(userRolePrefix() . '/rooms') }}" class="side-nav-link">
                    <span class="menu-text">View All</span>
                </a>
            </li>
        </ul>
    </div>
</li>


                    @php
                        $isContractActive = request()->is('landlord/contracts*') || request()->is('admin/contracts*');
                    @endphp

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarContract"
                            aria-expanded="{{ $isContractActive ? 'true' : 'false' }}" aria-controls="sidebarContract"
                            class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                            <span class="menu-text"> Contract </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse {{ $isContractActive ? 'show' : '' }}" id="sidebarContract">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ url(userRolePrefix() . '/contracts') }}" class="side-nav-link">
                                        <span class="menu-text">View All</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
