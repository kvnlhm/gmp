@extends('layouts.app-mobile')
@section('title', 'Final Input')
@section('mobile-content')
    <div class="mobile-app">
        <div class="app-header">
            <div class="header-title">
                <i class='bx bx-check-circle'></i>
                <span>Final Input</span>
            </div>
        </div>

        <div class="app-content">
            <form action="{{ route('mobile.final.input.save', $monitoring->id) }}" method="POST" class="input-form">
                @csrf
                
                <div class="form-group">
                    <label for="kedalaman_tertanam">Kedalaman Tiang Tertanam (m)</label>
                    <input type="number" id="kedalaman_tertanam" class="form-control" name="kedalaman_tertanam" step="0.01" required value="{{ $lastMonitoring->kedalaman_tertanam ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="tekanan">Tekanan (Ton)</label>
                    <input type="number" id="tekanan" class="form-control" name="tekanan" value="{{ $lastMonitoring->tekanan ?? '' }}" required>

                <button type="submit" class="finish-btn">
                    <i class='bx bx-check'></i>
                    Finish
                </button>
            </form>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav">
            <a href="{{ route('mobile.monitoring') }}" class="nav-item">
                <i class='bx bx-clipboard'></i>
                <span>Data</span>
            </a>
            <a href="" class="nav-item active">
                <i class='bx bx-stopwatch'></i>
                <span>Stopwatch</span>
            </a>
            <a href="{{ route('mobile.recap') }}" class="nav-item">
                <i class='bx bx-chart'></i>
                <span>Recap</span>
            </a>
        </div>
    </div>

    <style>
        .mobile-app {
            background: #2d3436;
            min-height: 100vh;
            padding-bottom: 80px; /* Increased padding to accommodate bottom nav */
        }

        .app-header {
            background: #2d3436;
            color: white;
            padding: 20px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .app-content {
            background: #f5f6fa;
            border-radius: 20px 20px 0 0;
            padding: 20px;
            min-height: calc(100vh - 60px);
        }

        .input-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3436;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            font-size: 16px;
        }

        .finish-btn {
            background: #00b894;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            margin-top: 20px;
        }

        .finish-btn:hover {
            background: #00a885;
        }

        /* Bottom Navigation Styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #111313;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 99;
        }

        .nav-item {
            color: #636e72;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
        }

        .nav-item.active {
            color: #00b894;
        }

        .nav-item i {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .nav-item:hover {
            color: #00b894;
        }
    </style>
@endsection 