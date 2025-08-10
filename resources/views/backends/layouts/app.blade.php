<!DOCTYPE html>
<html lang="en" data-sidenav-size="default" data-bs-theme="dark" data-menu-color="dark" data-topbar-color="dark"
    data-layout-mode="fluid">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', 'RoomGate')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta name="lock-screen-url" content="{{ route('lockscreen.show') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    @stack('style')

    <!-- Theme Config Js -->
    <script src="{{ asset('assets') }}/js/config.js"></script>

    <!-- Vendor css -->
    <link href="{{ asset('assets') }}/css/vendor.min.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" id="app-style">

    <!-- Icons css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets') }}/css/sweetalert2.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- Sidenav Menu Start -->
        @include('backends.partials.sidebar')
        <!-- Sidenav Menu End -->

        <!-- Topbar Start -->
        @include('backends.partials.navbar')
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card mb-0 shadow-none">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" id="search-modal-input"
                                placeholder="Search for actions, people,">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal"
                                aria-label="Close">[esc]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">
            @yield('content')


            <!-- Footer Start -->
            @include('backends.partials.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    @include('backends.partials.theme-settings')


    <!-- Vendor js -->
    <script src="{{ asset('assets') }}/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('assets') }}/js/app.js"></script>

    <!-- gridjs js -->
    <script src="{{ asset('assets') }}/js/gridjs.umd.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/js/sweetalert2.min.js"></script>

    <!-- Extented Js -->
    @stack('script')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    position: "top-end",
                    title: "{{ session('success') }}",
                    width: 500,
                    padding: 30,
                    background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-5.jpg') }}) no-repeat center",
                    showConfirmButton: false,
                    timer: 4000,
                    customClass: {
                        title: 'swal-title-success'
                    }
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    position: "top-end",
                    icon: 'error', // Add an error icon for clarity
                    title: "{{ session('error') }}", // Display the error message from the controller
                    width: 500,
                    padding: 30,
                    background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-4.jpg') }}) no-repeat center",
                    showConfirmButton: false,
                    timer: 6000, // Give a little more time to read errors
                    customClass: {
                        title: 'swal-title-error' // Use your existing error style
                    }
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '• {{ $error }}\n';
                @endforeach

                Swal.fire({
                    position: "top-end",
                    title: 'Please Fix The Errors',
                    text: errorMessages
                        width: 500,
                    padding: 30,
                    background: "var(--bs-secondary-bg) url({{ asset('assets/images/small-4.jpg') }}) no-repeat center",
                    showConfirmButton: false,
                    customClass: {
                        title: 'swal-title-error'
                    }
                });
            });
        </script>
    @endif


    @once
        <style>
            .swal-title-success {
                color: rgb(85, 133, 142) !important;
                font-size: 28px !important;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .swal-title-error {
                color: rgb(142, 85, 85) !important;
                font-size: 28px !important;
                font-weight: bold;
                margin-bottom: 20px;
            }
        </style>
    @endonce



<script>
document.addEventListener('DOMContentLoaded', function () {
    // This script will only run if a user is logged in and not on the lock screen page.
    @auth
        // Don't run the timer on the lock screen page itself.
        if (window.location.pathname !== new URL("{{ route('lockscreen.show') }}").pathname) {

            let inactivityTimer;
            // Set timeout duration. 15 * 60 * 1000 = 15 minutes.
            // For testing, use a short time like 5000 (5 seconds).
            const timeoutDuration = 120 * 60 * 1000;

            // Get the URL from the meta tag we added.
            const lockScreenUrl = document.querySelector('meta[name="lock-screen-url"]').content;

            // This function performs the redirect.
            const redirectToLockScreen = () => {
                window.location.href = lockScreenUrl;
            };

            // This function resets the timer whenever the user is active.
            const resetTimer = () => {
                clearTimeout(inactivityTimer);
                inactivityTimer = setTimeout(redirectToLockScreen, timeoutDuration);
            };

            // We listen for any of these events to consider the user "active".
            ['mousemove', 'keypress', 'scroll', 'click', 'touchstart'].forEach(event => {
                window.addEventListener(event, resetTimer);
            });

            // Start the timer for the first time when the page loads.
            resetTimer();
        }
    @endauth
});
</script>

</body>

</html>