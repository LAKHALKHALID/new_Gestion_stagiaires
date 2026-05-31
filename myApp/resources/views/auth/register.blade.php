@extends('layouts.app')
@php($noNav = true)
@section('content')


<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Kept responsive layout while maintaining the ideal mobile-to-desktop card proportion -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            
            <!-- Modern Card: Flat borderless background, deep elevation shadow, and soft tracking corners -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                <div class="card-body p-4 p-sm-5">
                    <!-- Headings Header Section -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark mb-1">{{ __('Create Account') }}</h2>
                        <p class="text-muted small">{{ __('Get started with your free account today') }}</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Input Block -->
                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="John Doe" required autocomplete="name" autofocus>
                            <label for="name" class="text-muted">{{ __('Full Name') }}</label>

                            @error('name')
                                <span class="invalid-feedback px-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email Input Block -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                            <label for="email" class="text-muted">{{ __('Email address') }}</label>

                            @error('email')
                                <span class="invalid-feedback px-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Input Block -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                            <label for="password" class="text-muted">{{ __('Password') }}</label>

                            @error('password')
                                <span class="invalid-feedback px-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password Input Block -->
                        <div class="form-floating mb-4">
                            <input id="password-confirm" type="password" class="form-control rounded-3" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                            <label for="password-confirm" class="text-muted">{{ __('Confirm Password') }}</label>
                        </div>

                        <!-- Primary Action: Big block layout submission button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold rounded-3 shadow-sm py-2 fs-6">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <!-- Utility Redirection Route -->
                        <div class="text-center mt-3 small">
                            <span class="text-secondary">{{ __('Already have an account?') }}</span>
                            <a class="text-decoration-none fw-semibold link-primary ms-1" href="{{ route('login') }}">
                                {{ __('Sign In') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
