@extends('layouts.app')
@php($noNav = true)
@section('content')



<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Kept col-md-8 container but restricted inner content max-width for a clean mobile-friendly look -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            
            <!-- Modernized Card: Removed harsh borders, added deep shadow and soft corners -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                <div class="card-body p-4 p-sm-5">
                    <!-- Clean Title Section -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark mb-1">{{ __('Welcome Back') }}</h2>
                        <p class="text-muted small">{{ __('Please enter your details to sign in') }}</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input Block using Bootstrap Floating Labels -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email" autofocus>
                            <label for="email" class="text-muted">{{ __('Email address') }}</label>

                            @error('email')
                                <span class="invalid-feedback px-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Input Block using Bootstrap Floating Labels -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                            <label for="password" class="text-muted">{{ __('Password') }}</label>

                            @error('password')
                                <span class="invalid-feedback px-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Utilities: Remember Me & Forgot Password aligned perfectly -->
                        <div class="d-flex justify-content-between align-items-center mb-4 small">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary" for="remember">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none fw-semibold link-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Modern Full-Width Action Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold rounded-3 shadow-sm py-2 fs-6">
                                {{ __('Sign In') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
