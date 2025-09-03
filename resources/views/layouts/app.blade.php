<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GMP Dashboard | @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    @include('layouts.styles')
    <link rel="icon" href="{{ asset('public/images/logo.png') }}">
    
    <!-- Mobile Specific Styles -->
    <style>
        @media (max-width: 768px) {
            .mobile-view {
                background-color: #2d2d2d;
                color: white;
                min-height: 100vh;
                padding: 20px;
            }

            .data-pill {
                background-color: #4b6455;
                color: white;
                padding: 8px 15px;
                border-radius: 20px;
                display: inline-block;
                margin: 5px;
                font-size: 14px;
            }

            .crane-image {
                width: 200px;
                margin: 20px auto;
                display: block;
            }

            .action-button {
                background-color: #98d4b3;
                color: black;
                border: none;
                padding: 15px 40px;
                border-radius: 25px;
                font-size: 18px;
                font-weight: bold;
                margin: 20px 0;
                width: 100%;
            }

            .bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: #1a1a1a;
                display: flex;
                justify-content: space-around;
                padding: 15px;
            }

            .bottom-nav-item {
                color: white;
                text-align: center;
                font-size: 12px;
            }

            .bottom-nav-item i {
                font-size: 24px;
                display: block;
                margin-bottom: 5px;
            }

            .delete-btn {
                background-color: #2d4d5c;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .data-section {
                margin-bottom: 30px;
            }

            .data-label {
                color: #98d4b3;
                margin-bottom: 10px;
                font-size: 16px;
            }
        }

        body {
            background-color: #2d3436;
            color: #f5f6fa;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: #2d3436;
        }

        .card {
            background-color: #1a1a1a;
            border: none;
            border-radius: 8px;
        }

        .card-body {
            color: #f5f6fa;
        }

        .table {
            color: #f5f6fa;
            background-color: #1a1a1a;
        }

        .table-bordered {
            border-color: #2d3436;
        }

        .table thead th {
            background-color: #1a1a1a;
            border-color: #2d3436;
            color: #00b894;
            font-weight: normal;
            padding: 12px;
        }

        .table tbody td {
            background-color: #1a1a1a;
            border-color: #2d3436;
            padding: 12px;
        }

        .table tbody tr:hover td {
            background-color: #2d3436;
        }

        .table th[colspan="9"] {
            text-align: center;
            color: #00b894;
        }

        .table th:nth-child(n+10):nth-child(-n+18) {
            color: #00b894;
            text-align: center;
        }

        .table th:nth-child(19) {
            color: #00b894;
            text-align: center;
        }

        .table thead th {
            color: #00b894;
            font-size: 0.9rem;
        }

        .card.mb-4 {
            background-color: #1a1a1a;
        }

        .form-select, .form-control {
            background-color: #1a1a1a;
            border: 1px solid #2d3436;
            color: #f5f6fa;
        }

        .form-select:focus, .form-control:focus {
            background-color: #1a1a1a;
            border-color: #00b894;
            box-shadow: none;
        }

        .form-label {
            color: #00b894;
        }

        .btn-primary {
            background-color: #00b894;
            border: none;
        }

        .btn-secondary {
            background-color: #2d3436;
            border: none;
        }

        .btn-sm.btn-primary {
            background-color: #00b894;
        }

        .btn-sm.btn-danger {
            background-color: #ff5252;
        }

        .table-secondary {
            background-color: #4b6455 !important;
            color: #f5f6fa;
        }

        .btn-primary {
            background-color: #00b894;
            border-color: #00b894;
        }

        .btn-primary:hover {
            background-color: #00a885;
            border-color: #00a885;
        }

        .form-control, .form-select {
            background-color: #2d3436;
            border-color: #636e72;
            color: #f5f6fa;
        }

        .form-control:focus, .form-select:focus {
            background-color: #2d3436;
            border-color: #00b894;
            color: #f5f6fa;
            box-shadow: 0 0 0 0.25rem rgba(0, 184, 148, 0.25);
        }

        .modal-content {
            background-color: #1a1a1a;
            color: #f5f6fa;
        }

        .modal-header {
            border-bottom-color: #636e72;
        }

        .modal-footer {
            border-top-color: #636e72;
        }

        /* Judul halaman */
        h2 {
            color: #00b894;
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }
    </style>

    @yield('styles')

    <script>
        // Check saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    @if(request()->is('mobile*'))
        @yield('mobile-content')
    @else
        <div class="d-flex">
            @include('layouts.sidebar')
            <div class="content">
                @yield('content')
            </div>
        </div>
    @endif
    @include('components.theme-switcher')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 