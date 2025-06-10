<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="{{ asset('assets') }}/images/logo.png" alt="logo"></span>
            <span class="logo-sm text-center"><img src="{{ asset('assets') }}/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets') }}/images/logo-dark.png" alt="dark logo"></span>
            <span class="logo-sm text-center"><img src="{{ asset('assets') }}/images/logo-sm.png" alt="small logo"></span>
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
        <div class="simplebar-content-wrapper active" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%;">
            <div class="simplebar-content">

                <!--- Sidenav Menu -->
                <ul class="side-nav">

                    <!-- Dashboard -->
                    <li class="side-nav-item">
                        <a href="{{ route('dashboard') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                            <span class="badge bg-success rounded-pill">5</span>
                        </a>
                    </li>

                    <li class="side-nav-title mt-2">Apps &amp; Pages</li>

                    @hasanyrole('admin')
                        @php
                            $isUserActive = request()->is('admin/users*');
                        @endphp
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="{{ $isUserActive ? 'true' : 'false' }}"
                                aria-controls="sidebarUser" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-home"></i></span>
                                <span class="menu-text"> User </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ $isUserActive ? 'show' : '' }}" id="sidebarUser">
                                <ul class="sub-menu">
                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/users') }}" class="side-nav-link">
                                            <span class="menu-text">View All</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endhasanyrole

                    @hasanyrole('landlord')
                        @php
                            $isUserActive = request()->is('landlord/users*');
                        @endphp
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="{{ $isUserActive ? 'true' : 'false' }}"
                                aria-controls="sidebarUser" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-home"></i></span>
                                <span class="menu-text"> Manage User </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ $isUserActive ? 'show' : '' }}" id="sidebarUser">
                                <ul class="sub-menu">
                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/users') }}" class="side-nav-link">
                                            <span class="menu-text">View Users</span>
                                        </a>
                                    </li>

                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/contracts') }}" class="side-nav-link">
                                            <span class="menu-text">View Contracts</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endhasanyrole

                    @hasanyrole('landlord')
                        @php
                            $isPropertyActive = request()->is('landlord/properties*');
                        @endphp
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarProperty" aria-expanded="{{ $isPropertyActive ? 'true' : 'false' }}"
                                aria-controls="sidebarProperty" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-home"></i></span>
                                <span class="menu-text"> Property </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ $isPropertyActive ? 'show' : '' }}" id="sidebarProperty">
                                <ul class="sub-menu">
                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/properties') }}" class="side-nav-link">
                                            <span class="menu-text">View All</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endhasanyrole

                    <!-- Room Menu (Landlord only) -->
                    @hasanyrole('landlord')
                        @php
                            $isRoomActive = request()->is('landlord/rooms*') || request()->is('admin/rooms*');
                        @endphp
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarRoom" aria-expanded="{{ $isRoomActive ? 'true' : 'false' }}"
                                aria-controls="sidebarRoom" class="side-nav-link">
                                <span class="menu-icon"><i class="ti ti-home"></i></span>
                                <span class="menu-text"> Manage Room </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ $isRoomActive ? 'show' : '' }}" id="sidebarRoom">
                                <ul class="sub-menu">
                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/rooms') }}" class="side-nav-link">
                                            <span class="menu-text">View Rooms</span>
                                        </a>
                                    </li>
                                    <li class="side-nav-item">
                                        <a href="{{ url(userRolePrefix() . '/room_types') }}" class="side-nav-link">
                                            <span class="menu-text">View Types</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endhasanyrole

                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
