@extends('hopekell-installer::layouts.installer')

@section('step', 'License Verification')

@section('content')
@php
    $currentStep = 2;
@endphp
<form method="POST" action="{{ route('hopekell.install.verify') }}">
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
