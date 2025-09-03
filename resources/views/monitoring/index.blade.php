@extends('layouts.app')
@section('title', 'Monitoring')
@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Monitoring</h2>

        @if(session('success'))
        <div id="successMessage" data-message="{{ session('success') }}" style="display: none;"></div>
        @endif

        @if(session('error'))
        <div id="errorMessage" data-message="{{ session('error') }}" style="display: none;"></div>
        @endif

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('monitoring.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Lokasi</label>
                        <select name="lokasi" class="form-select">
                            <option value="">Semua Lokasi</option>
                            @foreach($monitoring->pluck('lokasi')->unique() as $lok)
                                <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>
                                    {{ $lok }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('monitoring.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @php
                        \Carbon\Carbon::setLocale('id');
                    @endphp
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Lokasi</th>
                                <th rowspan="2">Kap. HSPD</th>
                                <th rowspan="2">Titik</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Bottom Pile (meter)</th>
                                <th rowspan="2">Upper Pile (meter)</th>
                                <th rowspan="2">Kedalaman (meter)</th>
                                <th rowspan="2">Tekanan (Ton)</th>
                                <th colspan="9">Durasi Aktivitas ke-</th>
                                <th>Waktu Siklus (menit)</th>
                                <th rowspan="2">Fa</th>
                                <th rowspan="2">Produktivitas HSPD (meter/jam)</th>
                                <th rowspan="2">Laporan</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>T1</th>
                                <th>T2</th>
                                <th>T3</th>
                                <th>T4</th>
                                <th>T5</th>
                                <th>T6</th>
                                <th>T7</th>
                                <th>T8</th>
                                <th>T9</th>
                                <th>Ts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoring as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->kap_hspd }}</td>
                                    <td>{{ $item->titik }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ $item->bottom_pile }}</td>
                                    <td>{{ $item->upper_pile }}</td>
                                    <td>{{ $item->kedalaman_tertanam }}</td>
                                    <td>{{ $item->tekanan }}</td>
                                    <td>{{ number_format($item->t1 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t2 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t3 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t4 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t5 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t6 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t7 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t8 / 60, 3) }}</td>
                                    <td>{{ number_format($item->t9 / 60, 3) }}</td>
                                    <td><b>{{ number_format($item->ts / 60, 3) }}</b></td>
                                    <td>{{ $item->fa }}</td>
                                    <td>{{ $item->produktivitas_hspd }}</td>
                                    <td>{{ $item->laporan }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-primary me-2" 
                                                    onclick='editData({{ $item->id }}, @json($item))' 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal">
                                                <i class='bx bx-edit'></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="deleteData({{ $item->id }})">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Monitoring</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="editLokasi" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Titik</label>
                            <input type="text" class="form-control" name="titik" id="editTitik" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Kapasitas HSPD</label>
                            <input type="text" class="form-control" name="kap_hspd" id="editKapHspd" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Bottom Pile</label>
                            <input type="number" step="0.01" class="form-control" name="bottom_pile" id="editBottomPile" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Upper Pile</label>
                            <input type="number" step="0.01" class="form-control" name="upper_pile" id="editUpperPile" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Kedalaman Tertanam</label>
                            <input type="number" step="0.01" class="form-control" name="kedalaman_tertanam" id="editKedalaman" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Tekanan</label>
                            <input type="number" step="0.01" class="form-control" name="tekanan" id="editTekanan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Fa</label>
                            <input type="number" step="0.01" class="form-control" name="fa" id="editFa" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Jam Kerja</label>
                            <input type="number" step="0.01" class="form-control" name="jam_kerja" id="editJamKerja" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Laporan</label>
                            <textarea class="form-control" name="laporan" id="editLaporan" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data monitoring ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function editData(id, data) {
        const editForm = document.getElementById('editForm');
        editForm.action = `/gmp/monitoring/${id}`;
        
        document.getElementById('editLokasi').value = data.lokasi;
        document.getElementById('editTitik').value = data.titik;
        document.getElementById('editKapHspd').value = data.kap_hspd;
        document.getElementById('editBottomPile').value = data.bottom_pile;
        document.getElementById('editUpperPile').value = data.upper_pile;
        document.getElementById('editKedalaman').value = data.kedalaman_tertanam;
        document.getElementById('editTekanan').value = data.tekanan;
        document.getElementById('editFa').value = data.fa;
        document.getElementById('editJamKerja').value = data.jam_kerja;
        document.getElementById('editLaporan').value = data.laporan;
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/gmp/monitoring/${id}`;
                deleteForm.submit();
            }
        });
    }

    function showSuccessNotification(message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }

    function showErrorNotification(message) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        if (successMessage) {
            showSuccessNotification(successMessage.dataset.message);
        }

        if (errorMessage) {
            showErrorNotification(errorMessage.dataset.message);
        }
    });
    </script>

    <style>
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }

        .btn-sm i {
            font-size: 1rem;
        }

        .form-label {
            color: #00b894;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        /* Override table styles */
        .table-bordered td {
            border-color: #636e72;
        }

        .table tbody tr:hover {
            background-color: #2d3436;
        }

        /* Filter card specific styles */
        .card.mb-4 {
            margin-bottom: 1.5rem;
        }

        /* Button styles */
        .btn-secondary {
            background-color: #636e72;
            border-color: #636e72;
        }

        .btn-secondary:hover {
            background-color: #4d5559;
            border-color: #4d5559;
        }

        .btn-danger {
            background-color: #d63031;
            border-color: #d63031;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
    </style>
@endsection
