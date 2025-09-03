<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class ProduktivitasHSPDController extends Controller
{
    public function index()
    {
        $monitoring = Monitoring::all();
        return view('produktivitas-hspd.index', compact('monitoring'));
    }
} 