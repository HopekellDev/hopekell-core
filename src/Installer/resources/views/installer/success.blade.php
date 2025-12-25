@extends('hopekell-installer::layouts.installer')

@section('step', 'Installation Complete')

@section('content')
@php
    $currentStep = 5;
@endphp

<div class="text-center py-5">

    <!-- Success Icon -->
    <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size:100px"></i>
    </div>

    <h2 class="mb-3">Installation Successful 🎉</h2>
    <p class="text-muted mb-4">
        Your application has been installed successfully and is ready to use.
    </p>

    <!-- Admin Credentials -->
    <div class="card shadow-sm mx-auto mb-4" style="max-width: 420px;">
        <div class="card-body">
            <h5 class="card-title mb-3">Default Admin Login</h5>

            <div class="text-start">
                <p class="mb-1">
                    <strong>Email:</strong>
                    <code>admin@example.com</code>
                </p>
                <p class="mb-0">
                    <strong>Password:</strong>
                    <code>Admin1223</code>
                </p>
            </div>

            <small class="text-danger d-block mt-3">
                ⚠️ Please change these credentials immediately after login.
            </small>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
        <a href="{{ url('/') }}" class="btn btn-success btn-lg">
            <i class="bi bi-globe"></i> Go to Website
        </a>

        <a href="{{ route('admin.dashbord') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-shield-lock"></i> Admin Login
        </a>
    </div>

</div>
@endsection
