<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $table = 'monitoring';
    protected $fillable = [
        'lokasi',
        'titik',
        'kap_hspd',
        'bottom_pile',
        'upper_pile',
        'kedalaman_tertanam',
        'tekanan',
        'laporan',
        'tanggal',
        'fa',
        'jam_kerja',
        't1',
        't2',
        't3',
        't4',
        't5',
        't6',
        't7',
        't8',
        't9',
        'ts',
        'produktivitas_hspd'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_kerja' => 'float',
        'bottom_pile' => 'float',
        'upper_pile' => 'float',
        'kedalaman_tertanam' => 'float',
        'fa' => 'float',
        'tekanan' => 'float',
        'produktivitas_hspd' => 'float'
    ];
}
