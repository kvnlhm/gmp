@extends('layouts.app')
@section('title', 'Produktivitas HSPD')
@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Produktivitas HSPD</h2>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produktivitas HSPD</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2">
                            <strong>Average:</strong> {{ number_format($monitoring->avg('produktivitas_hspd'), 2) }} meter/jam
                        </li>
                        <li class="mb-2">
                            <strong>Minimum:</strong> {{ number_format($monitoring->min('produktivitas_hspd'), 2) }} meter/jam
                        </li>
                        <li class="mb-2">
                            <strong>Maximum:</strong> {{ number_format($monitoring->max('produktivitas_hspd'), 2) }} meter/jam
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 