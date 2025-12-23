@extends('hopekelldev:layouts.installer')

@section('step', 'License Verification')

@section('content')
<form method="POST" action="{{ route('installer.verify') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Envato Purchase Code</label>
        <input type="text" name="purchase_code" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100">
        Verify License
    </button>
</form>
@endsection
