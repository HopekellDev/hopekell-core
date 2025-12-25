@extends('hopekell-installer::layouts.installer')

@section('step', 'Database Setup')

@section('content')
@php
    $currentStep = 3;
@endphp
<form method="POST" action="{{ route('hopekell.install.database') }}">
    @csrf

    <div class="mb-3">
        <label>Database Host</label>
        <input name="db_host" class="form-control" value="{{ env('DB_HOST') }}" required>
    </div>

    <div class="mb-3">
        <label>Database Name</label>
        <input name="db_name" class="form-control" value="{{ env('DB_DATABASE') }}" required>
    </div>

    <div class="mb-3">
        <label>Database Username</label>
        <input name="db_user" class="form-control" value="{{ env('DB_USERNAME') }}" required>
    </div>

    <div class="mb-3">
        <label>Database Password</label>
        <input name="db_pass" value="{{ env('DB_PASSWORD') }}" class="form-control">
    </div>

    <button class="btn btn-primary w-100">
        Update Database Credentials
    </button>
</form>
@endsection
