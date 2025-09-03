@extends('layouts.app-mobile')
@section('title', 'Input Data')
@section('mobile-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="mobile-app">
        <div class="app-header">
            <div class="header-title">
                <i class='bx bx-clipboard'></i>
                <span>Data</span>
            </div>
        </div>

        <div class="app-content">
            <form id="monitoringForm" class="input-form">
                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" class="form-control" name="lokasi" value="{{ $lastMonitoring->lokasi ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="titik">Nomor Titik</label>
                    <input type="text" id="titik" class="form-control" name="titik" value="{{ $lastMonitoring->titik ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="kap_hspd">Kapasitas HSPD (Ton)</label>
                    {{-- <select id="kap_hspd" class="form-control" name="kap_hspd" required>
                        <option value="360" {{ isset($lastMonitoring) && $lastMonitoring->kap_hspd == 360 ? 'selected' : '' }}>360</option>
                        <option value="420" {{ isset($lastMonitoring) && $lastMonitoring->kap_hspd == 420 ? 'selected' : '' }}>420</option>
                        <option value="460" {{ isset($lastMonitoring) && $lastMonitoring->kap_hspd == 460 ? 'selected' : '' }}>460</option>
                        <option value="680" {{ isset($lastMonitoring) && $lastMonitoring->kap_hspd == 680 ? 'selected' : '' }}>680</option>
                        <option value="1000" {{ isset($lastMonitoring) && $lastMonitoring->kap_hspd == 1000 ? 'selected' : '' }}>1000</option>
                    </select> --}}
                    <input type="number" id="kap_hspd" class="form-control" name="kap_hspd" step="0.01" value="{{ $lastMonitoring->kap_hspd ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="bottom_pile">Bottom Pile (m)</label>
                    <input type="number" id="bottom_pile" class="form-control" name="bottom_pile" step="0.01" value="{{ $lastMonitoring->bottom_pile ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="upper_pile">Upper Pile (m)</label>
                    <input type="number" id="upper_pile" class="form-control" name="upper_pile" step="0.01" value="{{ $lastMonitoring->upper_pile ?? '' }}" required>
                </div>

                {{-- <div class="form-group">
                    <label for="kedalaman_tertanam">Kedalaman Tiang Tertanam (m)</label>
                    <input type="number" id="kedalaman_tertanam" class="form-control" name="kedalaman_tertanam" step="0.01" value="{{ $lastMonitoring->kedalaman_tertanam ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="tekanan">Tekanan (Ton)</label>
                    <select id="tekanan" class="form-control" name="tekanan" required>
                        <option value="360" {{ isset($lastMonitoring) && $lastMonitoring->tekanan == 360 ? 'selected' : '' }}>360</option>
                        <option value="420" {{ isset($lastMonitoring) && $lastMonitoring->tekanan == 420 ? 'selected' : '' }}>420</option>
                        <option value="460" {{ isset($lastMonitoring) && $lastMonitoring->tekanan == 460 ? 'selected' : '' }}>460</option>
                        <option value="680" {{ isset($lastMonitoring) && $lastMonitoring->tekanan == 680 ? 'selected' : '' }}>680</option>
                        <option value="1000" {{ isset($lastMonitoring) && $lastMonitoring->tekanan == 1000 ? 'selected' : '' }}>1000</option>
                    </select>
                </div> --}}

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" class="form-control" name="tanggal" value="{{ now()->format('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_kerja">Jam Kerja (Jam)</label>
                    {{-- <select name="jam_kerja" id="jam_kerja" class="form-control" required>
                        <option value="8" {{ isset($lastMonitoring) && $lastMonitoring->jam_kerja == 8 ? 'selected' : '' }}>8</option>
                        <option value="12" {{ isset($lastMonitoring) && $lastMonitoring->jam_kerja == 12 ? 'selected' : '' }}>12</option>
                    </select> --}}
                    <input type="number" id="jam_kerja" class="form-control" name="jam_kerja" step="0.01" value="{{ $lastMonitoring->jam_kerja ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="fa">Fa</label>
                    <input type="number" id="fa" class="form-control" name="fa" step="0.01" value="{{ $lastMonitoring->fa ?? '' }}" required>
                </div>

                <div class="fa-categories">
                    <strong>Faktor Efisiensi Alat</strong>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Kondisi operasi</th>
                                    <th colspan="5">Pemeliharaan mesin</th>
                                </tr>
                                <tr>
                                    <th>Baik sekali</th>
                                    <th>Baik</th>
                                    <th>Sedang</th>
                                    <th>Buruk</th>
                                    <th>Buruk sekali</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Baik sekali</td>
                                    <td>0,83</td>
                                    <td>0,81</td>
                                    <td>0,76</td>
                                    <td class="not-recommended">0,70</td>
                                    <td class="not-recommended">0,63</td>
                                </tr>
                                <tr>
                                    <td>Baik</td>
                                    <td>0,78</td>
                                    <td>0,75</td>
                                    <td>0,71</td>
                                    <td class="not-recommended">0,65</td>
                                    <td class="not-recommended">0,60</td>
                                </tr>
                                <tr>
                                    <td>Sedang</td>
                                    <td>0,72</td>
                                    <td>0,69</td>
                                    <td>0,65</td>
                                    <td class="not-recommended">0,60</td>
                                    <td class="not-recommended">0,54</td>
                                </tr>
                                <tr>
                                    <td>Buruk</td>
                                    <td class="not-recommended">0,63</td>
                                    <td class="not-recommended">0,61</td>
                                    <td class="not-recommended">0,57</td>
                                    <td class="not-recommended">0,52</td>
                                    <td class="not-recommended">0,45</td>
                                </tr>
                                <tr>
                                    <td>Buruk sekali</td>
                                    <td class="not-recommended">0,53</td>
                                    <td class="not-recommended">0,50</td>
                                    <td class="not-recommended">0,47</td>
                                    <td class="not-recommended">0,42</td>
                                    <td class="not-recommended">0,32</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        Angka dalam warna kelabu adalah tidak disarankan. Faktor efisiensi ini adalah didasarkan atas kondisi operasi dan pemeliharaan secara umum.
                                        Faktor efisiensi untuk setiap jenis alat bisa berbeda.
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <strong>Tabel faktor efisiensi alat Permen PU Nomor 28 Tahun 2016</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <style>
                    .fa-categories {
                        margin: 20px 0;
                    }
                    .fa-categories .table {
                        width: 100%;
                        margin-top: 15px;
                        border-collapse: collapse;
                    }
                    .fa-categories .table th,
                    .fa-categories .table td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: center;
                    }
                    .fa-categories .table th {
                        background-color: #f8f9fa;
                    }
                    .fa-categories .notes {
                        margin-top: 10px;
                        font-size: 0.9em;
                    }
                    .fa-categories .notes p {
                        margin: 5px 0;
                    }
                    .table-responsive {
                        overflow-x: auto;
                    }
                    .not-recommended {
                        background-color: #e9ecef !important;
                    }
                </style>

                <button type="submit" class="start-btn">Mulai Pengukuran</button>
            </form>
        </div>

        <div class="bottom-nav">
            <a href="" class="nav-item active">
                <i class='bx bx-clipboard'></i>
                <span>Data</span>
            </a>
            <a href="{{ route('mobile.stopwatch.new') }}" class="nav-item">
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
            padding-bottom: 70px;
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
            gap: 15px;
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
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #00b894;
            box-shadow: 0 0 0 2px rgba(0, 184, 148, 0.1);
        }

        .start-btn {
            background: #00b894;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }

        .start-btn:hover {
            background: #00a885;
        }

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

    <script>
        const baseUrl = '{{ url('/') }}';

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('monitoringForm');

            // Set tanggal hari ini sebagai default
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="tanggal"]').value = today;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Memproses...';

                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);

                    // Gunakan base URL yang benar
                    const response = await fetch(`${baseUrl}/api/monitoring`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Error response:', errorText);
                        throw new Error(`Server error: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.success) {
                        // Tambahkan /gmp ke URL redirect juga
                        window.location.href = `${baseUrl}/mobile/stopwatch?id=${result.id}`;
                    } else {
                        throw new Error(result.message || 'Gagal menyimpan data');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                } finally {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Mulai Pengukuran';
                }
            });

            // Validasi input numerik
            const numericInputs = document.querySelectorAll('input[type="number"]');
            numericInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            });

            // Validasi bottom pile dan upper pile
            const bottomPile = document.querySelector('input[name="bottom_pile"]');
            const upperPile = document.querySelector('input[name="upper_pile"]');

            function validatePiles() {
                if (parseFloat(bottomPile.value) >= parseFloat(upperPile.value)) {
                    alert('Bottom Pile harus lebih kecil dari Upper Pile');
                    return false;
                }
                return true;
            }

            form.addEventListener('submit', function(e) {
                if (!validatePiles()) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
