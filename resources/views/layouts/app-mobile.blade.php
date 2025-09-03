<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GMP Dashboard | @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    @include('layouts.styles_mobile')
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
    </style>

    @yield('styles')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 