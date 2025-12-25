@extends('hopekell-installer::layouts.installer')

@section('step', 'Requirements')

@section('content')
@php
    $requirements = [
        'PHP >= 8.2' => version_compare(PHP_VERSION, '8.2.0', '>='),
        'BCMath Extension' => extension_loaded('bcmath'),
        'Ctype Extension' => extension_loaded('ctype'),
        'JSON Extension' => extension_loaded('json'),
        'OpenSSL Extension' => extension_loaded('openssl'),
        'PDO Extension' => extension_loaded('pdo'),
    ];
@endphp

<ul class="list-group mb-4">
    @foreach($requirements as $label => $passed)
        <li class="list-group-item d-flex justify-content-between">
            {{ $label }}
            @if($passed)
                <span class="badge bg-success">OK</span>
            @else
                <span class="badge bg-danger">Missing</span>
            @endif
        </li>
    @endforeach
</ul>

@if(!in_array(false, $requirements, true))
    <a href="{{ route('hopekell.install.step2') }}" class="btn btn-primary w-100">
        Veirfy Purchase Code
    </a>
@else
    <div class="alert alert-danger">
        Please fix the missing requirements before continuing.
    </div>
@endif
@endsection
