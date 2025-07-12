@extends('backends.layouts.blank')

@section('content')
    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="{{ route('dashboard') }}" class="auth-brand mb-3">
                        <img src="{{ asset('assets') }}/images/logo-dark.png" alt="dark logo" height="70" class="logo-dark">
                        <img src="{{ asset('assets') }}/images/logo.png" alt="logo light" height="70" class="logo-light">
                    </a>

                    <div class="d-flex align-items-center gap-2 mb-4 text-start">
                        {{-- Use a default image if the user's image is not set --}}
                        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/images/default_image.png') }}"
                            alt="user-image" class="avatar-xl rounded-circle img-thumbnail">
                        <div>
                            <h4 class="fw-semibold text-dark">Hi, {{ Auth::user()->name }}!</h4>
                            <p class="mb-0">Please enter your password to unlock.</p>
                        </div>
                    </div>

                    {{-- Unlock Form --}}
                    <form method="POST" action="{{ route('lockscreen.unlock') }}" class="text-start mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="password">Enter Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                                autofocus>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-2 d-grid">
                            <button class="btn btn-primary" type="submit"><i class="ti ti-lock-open me-1"></i> Access
                                Screen</button>
                        </div>
                    </form>

                    <p class="text-muted fs-14 mb-4">
                        Not you?
                        <a href="{{ route('lockscreen.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('lockscreen-logout-form').submit();"
                            class="fw-semibold text-dark ms-1">
                            Logout
                        </a>
                    </p>

                    {{-- ### THIS IS THE FIX ### --}}
                    {{-- The form's ID and ACTION have been updated to use the new route. --}}
                    <form id="lockscreen-logout-form" action="{{ route('lockscreen.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                    
                    <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © RoomGate
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection