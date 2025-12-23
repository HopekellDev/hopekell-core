@extends('hopekelldev:layouts.installer')

@section('step', 'Database Setup')

@section('content')
<form method="POST" action="{{ route('installer.database') }}">
    @csrf

    <div class="mb-3">
        <label>Database Host</label>
        <input name="db_host" class="form-control" value="127.0.0.1" required>
    </div>

    <div class="mb-3">
        <label>Database Name</label>
        <input name="db_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Database Username</label>
        <input name="db_user" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Database Password</label>
        <input name="db_pass" class="form-control">
    </div>

    <button class="btn btn-primary w-100">
        Install
    </button>
</form>
@endsection
