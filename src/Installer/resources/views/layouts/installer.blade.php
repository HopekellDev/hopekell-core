<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HopekellDev Core Installer &mdash; @yield('step')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: #f8f9fa;
        }

        .installer-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        /* Progress steps */
        .step-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 8px;
        }

        .step-labels span.active {
            font-weight: 600;
            color: #0d6efd;
        }
    </style>
</head>
<body>

@php
    // Default step if not passed
    $currentStep = $currentStep ?? 1;
    $totalSteps = 5;
    $progressPercent = ($currentStep / $totalSteps) * 100;
@endphp

<div class="container">
    <div class="installer-box">

        <h2 class="mb-4 text-center">HopekellDev Core Installer</h2>

        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="progress" style="height: 22px;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                    role="progressbar"
                    style="width: {{ $progressPercent }}%;">
                    Step {{ $currentStep }} of {{ $totalSteps }}
                </div>
            </div>

            <div class="step-labels">
                <span class="{{ $currentStep >= 1 ? 'active' : '' }}">Requirements</span>
                <span class="{{ $currentStep >= 2 ? 'active' : '' }}">License</span>
                <span class="{{ $currentStep >= 3 ? 'active' : '' }}">Database</span>
                <span class="{{ $currentStep >= 4 ? 'active' : '' }}">Install</span>
                <span class="{{ $currentStep >= 5 ? 'active' : '' }}">Success</span>
            </div>
        </div>

        <!-- Page Content -->
        @yield('content')

    </div>
</div>

</body>
</html>
