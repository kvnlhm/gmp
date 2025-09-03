<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class ProduktivitasHarianController extends Controller
{
    public function index()
    {
        $monitoring = Monitoring::all();
        return view('produktivitas-harian.index', compact('monitoring'));
    }
} 