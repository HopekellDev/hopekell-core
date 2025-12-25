@extends('hopekell-installer::layouts.installer')

@section('step','Step 4: Import SQL db')

@section('content')
<style>
@keyframes spin {
    100% { transform: rotate(360deg); }
}
.spin {
    animation: spin 3s linear infinite;
}
</style>

@php
    $currentStep = 4;
@endphp

<div class="text-center">
    <h4 class="mb-4">Import Database SQL</h4>

    <div id="errorBox" class="alert alert-danger mt-4 d-none"></div>

    <div class="spinner mb-4">
        <h1 id="gear" class="text-primary" style="font-size:100px">
            <i class="bi bi-gear"></i>
        </h1>
    </div>

    <div class="mt-3 d-grid gap-2">
        <button id="importBtn" class="btn btn-primary btn-lg">
            Import SQL
        </button>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function () {

    let dotInterval;

    function startDots(button) {
        let dots = 0;
        dotInterval = setInterval(() => {
            dots = (dots + 1) % 4;
            button.text('Importing SQL' + '.'.repeat(dots));
        }, 500);
    }

    function stopDots(button, text) {
        clearInterval(dotInterval);
        button.text(text);
    }

    $('#importBtn').on('click', function () {
        const btn = $(this);

        // UI lock
        btn.prop('disabled', true);
        $('#gear').addClass('spin');
        $('#errorBox').addClass('d-none').text('');

        startDots(btn);

        $.ajax({
            url: "{{ route('hopekell.install.database.import-sql.post') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                stopDots(btn, 'Completed');
                window.location.href = "{{ route('hopekell.install.success') }}";
            },
            error: function (xhr) {
                stopDots(btn, 'Import SQL');
                btn.prop('disabled', false);
                $('#gear').removeClass('spin');

                let message = 'SQL import failed. Please try again.';
                if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                $('#errorBox').removeClass('d-none').text(message);
            }
        });
    });

});
</script>
@endpush

