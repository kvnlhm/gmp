@extends('layouts.app-mobile')
@section('title', 'Stopwatch')
@section('mobile-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="mobile-app">
        <div class="app-header">
            <div class="header-title" id="timerTitle">T1 Moving to the Point</div>
        </div>

        <div class="stopwatch-content">
            <!-- Timer Circle -->
            <div class="timer-circle">
                <svg class="progress-ring" width="300" height="300">
                    <circle class="progress-ring__circle" stroke="#2d3436" stroke-width="8" fill="transparent" r="140"
                        cx="150" cy="150" />
                    <circle class="progress-ring__circle-overlay" stroke="#00b894" stroke-width="8" fill="transparent"
                        r="140" cx="150" cy="150" id="progressCircle" />
                </svg>
                <div class="timer-display">
                    <div class="timer-main" id="timerDisplay">00:00</div>
                    <div class="timer-ms" id="msDisplay">00</div>
                </div>
            </div>

            <!-- Timer List -->
            <div class="timer-list" id="timerList"></div>

            <!-- Timer Controls -->
            <div class="timer-controls">
                <button id="resetBtn" class="control-btn reset">
                    <i class='bx bx-refresh'></i>
                </button>
                <button id="startStopBtn" class="control-btn main-control">
                    <i class='bx bx-play'></i>
                </button>
                <button id="saveBtn" class="control-btn save">
                    <i class='bx bx-save'></i>
                </button>
            </div>
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
            min-height: 100vh;
            background: #2d3436;
            padding: 20px;
            padding-bottom: 180px;
            position: relative;
        }

        .app-header {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .stopwatch-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timer-circle {
            position: relative;
            width: 300px;
            height: 300px;
            margin-bottom: 20px;
        }

        /* Style untuk area yang bisa di-scroll */
        .timer-list {
            width: 100%;
            max-height: 200px;
            /* Batasi tinggi daftar timer */
            overflow-y: auto;
            /* Aktifkan scroll vertikal */
            margin-bottom: 20px;
        }

        /* Perbaikan untuk timer-controls */
        .timer-controls {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            padding: 20px;
            background: #2d3436;
            position: fixed;
            bottom: 60px;
            /* Posisi di atas bottom-nav yang tingginya 60px */
            left: 0;
            right: 0;
            z-index: 100;
        }

        .control-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .control-btn.reset {
            background: #d63031;
        }

        .control-btn.main-control {
            background: #0984e3;
            width: 70px;
            height: 70px;
            font-size: 28px;
        }

        .control-btn.save {
            background: #00b894;
        }

        .control-btn.finish {
            background: #00b894;
        }

        .timer-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .timer-info {
            display: flex;
            gap: 12px;
        }

        .timer-label {
            min-width: 30px;
        }

        .saved-time {
            color: #00b894;
        }

        .cumulative-time {
            color: #81ecec;
            font-size: 0.9em;
        }

        /* Progress ring styles */
        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.1s;
        }

        .timer-display {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        .timer-main {
            font-size: 48px;
            font-weight: bold;
        }

        .timer-ms {
            font-size: 24px;
            opacity: 0.8;
        }

        /* Style untuk scrollbar */
        .timer-list::-webkit-scrollbar {
            width: 6px;
        }

        .timer-list::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .timer-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .timer-list::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Tambahkan shadow effect untuk timer-controls */
        .timer-controls::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(to top, rgba(45, 52, 54, 1), rgba(45, 52, 54, 0));
            pointer-events: none;
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

        .progress-ring__circle-overlay {
            transition: stroke-dashoffset 0.1s;
        }

        .control-btn.finish {
            background: #00b894;
        }

        .saved-time {
            color: #00b894;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = '{{ url('/') }}';
            const monitoringId = new URLSearchParams(window.location.search).get('id');

            let time = 0;
            let isRunning = false;
            let startTime = 0;
            let lastTime = 0;
            let animationFrameId = null;
            let currentTimer = 1;
            let cumulativeTime = 0;

            const timerTitles = [
                'T1 Moving to the Point',
                'T2 Lifting Pile (Bottom Pile)',
                'T3 Clamping & Verticality (Bottom Pile)',
                'T4 Pilling (Bottom Pile)',
                'T5 Lifting Pile (Upper Pile)',
                'T6 Clamping & Verticality (Upper Pile)',
                'T7 Joint Pile (Welding)',
                'T8 Pilling (Upper Pile)',
                'T9 Cutting Pile'
            ];

            const timerDisplay = document.getElementById('timerDisplay');
            const msDisplay = document.getElementById('msDisplay');
            const timerTitle = document.getElementById('timerTitle');
            const timerList = document.getElementById('timerList');
            const startStopBtn = document.getElementById('startStopBtn');
            const resetBtn = document.getElementById('resetBtn');
            const saveBtn = document.getElementById('saveBtn');
            const progressCircle = document.getElementById('progressCircle');

            const circumference = 2 * Math.PI * 140;
            progressCircle.style.strokeDasharray = circumference;
            progressCircle.style.strokeDashoffset = circumference;

            function updateDisplay() {
                const formattedTime = formatTime(time);
                const [minutes, seconds, ms] = formattedTime.split(':');

                timerDisplay.textContent = `${minutes}:${seconds}`;
                msDisplay.textContent = ms;

                // Update progress circle
                const progress = (time % 60000) / 60000;
                progressCircle.style.strokeDashoffset = circumference * (1 - progress);
            }

            function updateTimer(currentTime) {
                if (isRunning) {
                    // Hitung selisih waktu sejak timer dimulai
                    const elapsed = currentTime - startTime;
                    time = lastTime + elapsed;
                    updateDisplay();
                    animationFrameId = requestAnimationFrame(updateTimer);
                }
            }

            function startTimer() {
                if (!isRunning) {
                    isRunning = true;
                    startStopBtn.innerHTML = '<i class="bx bx-pause"></i>';
                    startTime = performance.now();
                    animationFrameId = requestAnimationFrame(updateTimer);
                }
            }

            function stopTimer() {
                if (isRunning) {
                    isRunning = false;
                    startStopBtn.innerHTML = '<i class="bx bx-play"></i>';
                    lastTime = time;
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                    }
                }
            }

            function resetTimer() {
                stopTimer();
                time = 0;
                lastTime = 0;
                updateDisplay();
            }

            // Fungsi untuk memformat waktu
            function formatTime(timeInMs) {
                const minutes = Math.floor(timeInMs / 60000);
                const seconds = Math.floor((timeInMs % 60000) / 1000);
                const milliseconds = Math.floor((timeInMs % 1000) / 10);

                return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds).padStart(2, '0')}`;
            }

            // Fungsi untuk menambahkan waktu dengan format mm:ss:ms
            function addTimes(times) {
                let totalMs = 0;

                times.forEach(time => {
                    if (time) {
                        totalMs += time;
                    }
                });

                const minutes = Math.floor(totalMs / 60000);
                const seconds = Math.floor((totalMs % 60000) / 1000);
                const milliseconds = Math.floor((totalMs % 1000) / 10);

                // Tidak perlu konversi ke format jam, biarkan menit terus bertambah
                return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds).padStart(2, '0')}`;
            }

            // Tambahkan variabel untuk menyimpan waktu setiap T
            let timerHistory = [];

            async function saveTime() {
                // Jika bukan T9, cek apakah timer sudah dijalankan
                if (currentTimer !== 9 && time === 0) {
                    alert('Timer belum dijalankan');
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    
                    // Simpan waktu saat ini ke history (termasuk T9)
                    timerHistory[currentTimer - 1] = time;

                    // Format waktu individual
                    const individualTime = formatTime(time);

                    // Hitung dan format waktu kumulatif
                    const cumulativeTimeFormatted = addTimes(timerHistory);

                    // Simpan waktu ke database
                    const response = await fetch(`${baseUrl}/api/monitoring/${monitoringId}/timer`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            timer_number: currentTimer,
                            time: time / 1000 // Convert to seconds
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Gagal menyimpan waktu');
                    }

                    // Add to timer list
                    const listItem = document.createElement('div');
                    listItem.className = 'timer-item';
                    listItem.innerHTML = `
                        <div class="timer-info">
                            <span class="timer-label">T${currentTimer}</span>
                            <span class="timer-value saved-time">${individualTime}</span>
                        </div>
                        <div class="cumulative-time">
                            Total: ${cumulativeTimeFormatted}
                        </div>
                    `;
                    timerList.appendChild(listItem);

                    // Scroll ke timer terakhir
                    listItem.scrollIntoView({ behavior: 'smooth', block: 'end' });

                    // Stop current timer
                    stopTimer();

                    // Jika ini adalah T9, setelah menyimpan waktu, lakukan finish
                    if (currentTimer === 9) {
                        await finishMonitoring();
                        return;
                    }

                    // Prepare for next timer (hanya jika bukan T9)
                    currentTimer++;
                    timerTitle.textContent = timerTitles[currentTimer - 1];
                    resetTimer();

                    // Update save button if next is last timer
                    if (currentTimer === 9) {
                        saveBtn.innerHTML = '<i class="bx bx-check"></i>';
                        saveBtn.classList.remove('save');
                        saveBtn.classList.add('finish');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                }
            }

            async function finishMonitoring() {
                try {
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    const response = await fetch(`${baseUrl}/api/monitoring/${monitoringId}/finish`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Gagal menyelesaikan monitoring');
                    }

                    // Ubah redirect ke halaman final input
                    window.location.href = `${baseUrl}/mobile/final-input/${monitoringId}`;
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                }
            }

            startStopBtn.addEventListener('click', () => {
                if (isRunning) {
                    stopTimer();
                } else {
                    startTimer();
                }
            });

            resetBtn.addEventListener('click', resetTimer);
            saveBtn.addEventListener('click', saveTime);
        });
    </script>
@endsection
