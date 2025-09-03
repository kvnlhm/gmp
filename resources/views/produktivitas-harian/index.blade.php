@extends('layouts.app')
@section('title', 'Produktivitas Harian')
@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Produktivitas Harian</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @php
                    $groupedByLokasi = $monitoring->groupBy('lokasi');
                    \Carbon\Carbon::setLocale('id');
                @endphp

                @foreach($groupedByLokasi as $lokasi => $lokasiItems)
                    <h5 class="mt-4 mb-3">Lokasi: {{ $lokasi }}</h5>
                    
                    @php
                        $groupedByTanggal = $lokasiItems->groupBy('tanggal');
                    @endphp
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Kerja (jam)</th>
                                <th>Realisasi (titik)</th>
                                <th>Total Kedalaman Tiang Terpancang (meter)</th>
                                <th>Produktivitas Harian (meter/jam)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedByTanggal as $tanggal => $items)
                            @php
                                $jamKerja = $items->last()->jam_kerja;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM Y') }}</td>
                                <td>{{ $jamKerja }}</td>
                                <td>{{ $items->count() }}</td>
                                <td>{{ $items->sum('kedalaman_tertanam') }}</td>
                                <td>{{ number_format($items->sum('kedalaman_tertanam') / $jamKerja, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Table styles */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: var(--text-color) !important;
        vertical-align: top;
        border-color: var(--border-color) !important;
    }

    .table > :not(caption) > * > * {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        padding: 0.75rem;
    }

    .table-bordered > :not(caption) > * {
        border-width: 1px 0;
    }

    .table-bordered > :not(caption) > * > * {
        border-width: 0 1px;
        border-color: var(--border-color) !important;
    }

    .table > thead th {
        color: var(--primary-color) !important;
        font-weight: 600 !important;
        background-color: var(--card-bg) !important;
        border-bottom: 2px solid var(--border-color) !important;
        white-space: nowrap;
    }

    .table tbody tr:nth-of-type(odd) > * {
        background-color: var(--card-bg) !important;
    }

    .table tbody tr:nth-of-type(even) > * {
        background-color: var(--background-color) !important;
    }

    .table tbody tr:hover > * {
        background-color: var(--background-color) !important;
        color: var(--text-color) !important;
    }
</style>
@endsection 