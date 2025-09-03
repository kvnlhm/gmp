@extends('layouts.app-mobile')
@section('title', 'Recap')
@section('mobile-content')
    <div class="mobile-app">
        <div class="app-header">
            <h2>Recapitulation Productivity</h2>
        </div>

        <div class="recap-content">
            <!-- Productivity Summary -->
            <div class="productivity-summary">
                <h3>Produktivitas HSPD</h3>
                <div class="summary-items">
                    <div class="summary-item">
                        <label>Average</label>
                        <span>{{ number_format($monitorings->avg('produktivitas_hspd'), 2) }} meter/jam</span>
                    </div>
                    <div class="summary-item">
                        <label>Minimum</label>
                        <span>{{ number_format($monitorings->min('produktivitas_hspd'), 2) }} meter/jam</span>
                    </div>
                    <div class="summary-item">
                        <label>Maximum</label>
                        <span>{{ number_format($monitorings->max('produktivitas_hspd'), 2) }} meter/jam</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="mobile-cards">
                @foreach ($monitorings as $item)
                    <div class="data-card">
                        <div class="card-header">
                            <div class="header-main">
                                <div class="header-left">
                                    <span class="card-number">#{{ $monitorings->count() - $loop->index }}</span>
                                    <h4>Lokasi: {{ $item->lokasi }}</h4>
                                </div>
                                <span class="date">{{ $item->tanggal->format('d/m/Y') }}</span>
                            </div>
                            <div class="header-sub">
                                <span class="point">Titik: {{ $item->titik }}</span>
                                <span class="productivity">{{ $item->jam_kerja }} Jam kerja</span>
                            </div>
                        </div>

                        <div class="card-details">
                            <div class="detail-group">
                                <div class="detail-item">
                                    <label>Kap. HSPD:</label>
                                    <span>{{ $item->kap_hspd }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Bottom Pile:</label>
                                    <span>{{ number_format($item->bottom_pile, 2) }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Upper Pile:</label>
                                    <span>{{ number_format($item->upper_pile, 2) }}</span>
                                </div>
                            </div>

                            <div class="detail-group">
                                <div class="detail-item">
                                    <label>Kedalaman:</label>
                                    <span>{{ number_format($item->kedalaman_tertanam, 2) }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Tekanan:</label>
                                    <span>{{ number_format($item->tekanan, 2) }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Fa:</label>
                                    <span>{{ number_format($item->fa, 2) }}</span>
                                </div>
                            </div>

                            <div class="timer-grid">
                                <div class="timer-item">
                                    <label>T1 (menit)</label>
                                    <span>{{ number_format($item->t1 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T2 (menit)</label>
                                    <span>{{ number_format($item->t2 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T3 (menit)</label>
                                    <span>{{ number_format($item->t3 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T4 (menit)</label>
                                    <span>{{ number_format($item->t4 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T5 (menit)</label>
                                    <span>{{ number_format($item->t5 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T6 (menit)</label>
                                    <span>{{ number_format($item->t6 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T7 (menit)</label>
                                    <span>{{ number_format($item->t7 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T8 (menit)</label>
                                    <span>{{ number_format($item->t8 / 60, 3) }}</span>
                                </div>
                                <div class="timer-item">
                                    <label>T9 (menit)</label>
                                    <span>{{ number_format($item->t9 / 60, 3) }}</span>
                                </div>
                            </div>

                            <div class="total-time">
                                <label>Ts (menit):</label>
                                <span>{{ number_format($item->ts / 60, 3) }}</span>
                            </div>

                            <div class="total-time">
                                <label>Produktivitas:</label>
                                <span>{{ number_format($item->produktivitas_hspd, 2) }} meter/jam</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bottom-nav">
            <a href="{{ route('mobile.monitoring') }}" class="nav-item">
                <i class='bx bx-clipboard'></i>
                <span>Data</span>
            </a>
            <a href="{{ route('mobile.stopwatch.new') }}" class="nav-item">
                <i class='bx bx-stopwatch'></i>
                <span>Stopwatch</span>
            </a>
            <a href="" class="nav-item active">
                <i class='bx bx-chart'></i>
                <span>Recap</span>
            </a>
        </div>
    </div>

    <style>
        .mobile-app {
            min-height: 100vh;
            background: #2d3436;
            padding: 20px;
            padding-bottom: 80px;
            color: white;
        }

        .app-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .app-header h2 {
            margin: 0;
            color: white;
            font-size: 20px;
        }

        .recap-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Productivity Summary Styles */
        .productivity-summary {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px;
        }

        .productivity-summary h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #00b894;
        }

        .summary-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .summary-item {
            background: rgba(0, 0, 0, 0.2);
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Mobile Cards Styles */
        .mobile-cards {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .data-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .header-main h4 {
            margin: 0;
            color: #00b894;
            font-size: 16px;
        }

        .date {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .header-sub {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .point {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .productivity {
            color: #00b894;
            font-weight: 500;
            font-size: 14px;
        }

        .card-details {
            padding: 15px;
        }

        .detail-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .detail-item label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .detail-item span {
            font-size: 14px;
        }

        .timer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .timer-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .timer-item label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .timer-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .total-time {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 500;
        }

        .total-time label {
            color: rgba(255, 255, 255, 0.8);
        }

        .total-time span {
            color: #00b894;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-number {
            background: rgba(0, 184, 148, 0.2);
            color: #00b894;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Style untuk bottom-nav */
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
