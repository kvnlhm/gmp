<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Monitoring::query();

        // Filter by lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $monitoring = $query->get();
        return view('monitoring.index', compact('monitoring'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'lokasi' => 'required|string',
                'titik' => 'required|string',
                'kap_hspd' => 'required|string',
                'bottom_pile' => 'required|numeric',
                'upper_pile' => 'required|numeric',
                // 'kedalaman_tertanam' => 'required|numeric',
                // 'tekanan' => 'required|numeric',
                'tanggal' => 'required|date',
                'jam_kerja' => 'required|numeric',
                'fa' => 'required|numeric',
            ]);
            
            // Set nilai default untuk timer
            $validated['t1'] = 0;
            $validated['t2'] = 0;
            $validated['t3'] = 0;
            $validated['t4'] = 0;
            $validated['t5'] = 0;
            $validated['t6'] = 0;
            $validated['t7'] = 0;
            $validated['t8'] = 0;
            $validated['t9'] = 0;
            $validated['ts'] = 0;
            $validated['produktivitas_hspd'] = 0;

            $monitoring = Monitoring::create($validated);

            return response()->json([
                'success' => true,
                'id' => $monitoring->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in monitoring store:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updateTimer(Request $request, $id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            
            $validated = $request->validate([
                'timer_number' => 'required|integer|between:1,9',
                'time' => 'required|numeric'
            ]);

            $timerField = 't' . $validated['timer_number'];
            $monitoring->$timerField = $validated['time'];
            
            // Hitung total waktu setiap kali timer disimpan
            $monitoring->ts = $monitoring->t1 + $monitoring->t2 + $monitoring->t3 + 
                             $monitoring->t4 + $monitoring->t5 + $monitoring->t6 + 
                             $monitoring->t7 + $monitoring->t8 + $monitoring->t9;
            
            $monitoring->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function finish(Request $request, $id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            
            // Hitung total waktu
            if ($monitoring->ts === 0) {
                $monitoring->ts = $monitoring->t1 + $monitoring->t2 + $monitoring->t3 + 
                                $monitoring->t4 + $monitoring->t5 + $monitoring->t6 + 
                                $monitoring->t7 + $monitoring->t8 + $monitoring->t9;
                $monitoring->save();
            }

            return redirect()->route('mobile.final.input', $monitoring->id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function recap()
    {
        try {
            $monitorings = Monitoring::orderBy('tanggal', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            return view('mobile.recap', compact('monitorings'));
        } catch (\Exception $e) {
            return redirect()->route('mobile.monitoring')
                ->with('error', 'Gagal memuat data monitoring');
        }
    }

    public function create()
    {
        // Ambil data monitoring terakhir
        $lastMonitoring = Monitoring::latest()->first();
        
        return view('mobile.monitoring', compact('lastMonitoring'));
    }

    public function stopwatch(Request $request)
    {
        try {
            if ($request->has('id')) {
                $monitoring = Monitoring::findOrFail($request->id);
            } else {
                $lastMonitoring = Monitoring::latest()->first();
                
                $monitoring = Monitoring::create([
                    'lokasi' => $lastMonitoring->lokasi ?? '',
                    'titik' => $lastMonitoring->titik ?? '',
                    'kap_hspd' => $lastMonitoring->kap_hspd ?? '',
                    'bottom_pile' => $lastMonitoring->bottom_pile ?? 0,
                    'upper_pile' => $lastMonitoring->upper_pile ?? 0,
                    'kedalaman_tertanam' => $lastMonitoring->kedalaman_tertanam ?? 0,
                    'tekanan' => $lastMonitoring->tekanan ?? 0,
                    'tanggal' => now(),
                    'fa' => $lastMonitoring->fa ?? 0,
                    'jam_kerja' => $lastMonitoring->jam_kerja ?? 0,
                    't1' => 0,
                    't2' => 0,
                    't3' => 0,
                    't4' => 0,
                    't5' => 0,
                    't6' => 0,
                    't7' => 0,
                    't8' => 0,
                    't9' => 0,
                    'ts' => 0,
                    'produktivitas_hspd' => 0
                ]);
            }

            return view('mobile.stopwatch', compact('monitoring'));
        } catch (\Exception $e) {
            return redirect()->route('mobile.monitoring')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateTime(Request $request)
    {
        try {
            // Jika ada ID, gunakan data yang sudah ada
            if ($request->has('id')) {
                $monitoring = Monitoring::findOrFail($request->id);
            } else {
                // Jika tidak ada ID, buat data baru dari data terakhir
                $lastMonitoring = Monitoring::latest()->first();
                
                $monitoring = Monitoring::create([
                    'lokasi' => $lastMonitoring->lokasi ?? '',
                    'titik' => $lastMonitoring->titik ?? '',
                    'kap_hspd' => $lastMonitoring->kap_hspd ?? '',
                    'bottom_pile' => $lastMonitoring->bottom_pile ?? 0,
                    'upper_pile' => $lastMonitoring->upper_pile ?? 0,
                    'kedalaman_tertanam' => $lastMonitoring->kedalaman_tertanam ?? 0,
                    'tekanan' => $lastMonitoring->tekanan ?? 0,
                    'tanggal' => now(),
                    'fa' => $lastMonitoring->fa ?? 0,
                    'jam_kerja' => $lastMonitoring->jam_kerja ?? 0,
                    't1' => 0,
                    't2' => 0,
                    't3' => 0,
                    't4' => 0,
                    't5' => 0,
                    't6' => 0,
                    't7' => 0,
                    't8' => 0,
                    't9' => 0,
                    'ts' => 0,
                    'produktivitas_hspd' => 0
                ]);
            }

            $field = 't' . $request->timer_number;
            
            if ($field === 't1' || $field === 't2' || $field === 't3' || 
                $field === 't4' || $field === 't5' || $field === 't6' || 
                $field === 't7' || $field === 't8' || $field === 't9') {
                
                $monitoring->$field = $request->time;
                $monitoring->ts = $monitoring->t1 + $monitoring->t2 + $monitoring->t3 + 
                                $monitoring->t4 + $monitoring->t5 + $monitoring->t6 + 
                                $monitoring->t7 + $monitoring->t8 + $monitoring->t9;
                
                if ($monitoring->ts > 0) {
                    $monitoring->produktivitas_hspd = (1 * $monitoring->kedalaman_tertanam * 60 * $monitoring->fa) / ($monitoring->ts / 60);
                }
                
                $monitoring->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Waktu berhasil disimpan',
                    'monitoring_id' => $monitoring->id,
                    'total_time' => $monitoring->ts
                ]);
            }
            
            throw new \Exception('Timer tidak valid');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan waktu: ' . $e->getMessage()
            ], 422);
        }
    }

    public function createNew()
    {
        $lastMonitoring = Monitoring::latest()->first();
        return view('mobile.stopwatch-new', compact('lastMonitoring'));
    }

    public function updateTimeNew(Request $request)
    {
        try {
            // Jika ada ID, gunakan data yang sudah ada
            if ($request->has('monitoring_id')) {
                $monitoring = Monitoring::findOrFail($request->monitoring_id);
            } else {
                // Jika tidak ada ID, buat data baru dari data terakhir
                $lastMonitoring = Monitoring::latest()->first();
                
                $monitoring = Monitoring::create([
                    'lokasi' => $lastMonitoring->lokasi ?? '',
                    'titik' => $lastMonitoring->titik ?? '',
                    'kap_hspd' => $lastMonitoring->kap_hspd ?? '',
                    'bottom_pile' => $lastMonitoring->bottom_pile ?? 0,
                    'upper_pile' => $lastMonitoring->upper_pile ?? 0,
                    'kedalaman_tertanam' => $lastMonitoring->kedalaman_tertanam ?? 0,
                    'tekanan' => $lastMonitoring->tekanan ?? 0,
                    'tanggal' => now(),
                    'fa' => $lastMonitoring->fa ?? 0,
                    'jam_kerja' => $lastMonitoring->jam_kerja ?? 0,
                    't1' => 0,
                    't2' => 0,
                    't3' => 0,
                    't4' => 0,
                    't5' => 0,
                    't6' => 0,
                    't7' => 0,
                    't8' => 0,
                    't9' => 0,
                    'ts' => 0,
                    'produktivitas_hspd' => 0
                ]);
            }

            $field = 't' . $request->timer_number;
            
            if ($field === 't1' || $field === 't2' || $field === 't3' || 
                $field === 't4' || $field === 't5' || $field === 't6' || 
                $field === 't7' || $field === 't8' || $field === 't9') {
                
                $monitoring->$field = $request->time;
                
                // Hitung total waktu setiap kali timer disimpan
                $monitoring->ts = $monitoring->t1 + $monitoring->t2 + $monitoring->t3 + 
                                $monitoring->t4 + $monitoring->t5 + $monitoring->t6 + 
                                $monitoring->t7 + $monitoring->t8 + $monitoring->t9;
                
                $monitoring->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Waktu berhasil disimpan',
                    'monitoring_id' => $monitoring->id,
                    'total_time' => $monitoring->ts
                ]);
            }
            
            throw new \Exception('Timer tidak valid');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan waktu: ' . $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            
            $monitoring->update([
                'lokasi' => $request->lokasi,
                'titik' => $request->titik,
                'kap_hspd' => $request->kap_hspd,
                'bottom_pile' => $request->bottom_pile,
                'upper_pile' => $request->upper_pile,
                'kedalaman_tertanam' => $request->kedalaman_tertanam,
                'tekanan' => $request->tekanan,
                'fa' => $request->fa,
                'jam_kerja' => $request->jam_kerja
            ]);

            return redirect()->route('monitoring.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('monitoring.index')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            $monitoring->delete();

            return redirect()->route('monitoring.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('monitoring.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function finalInput($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        
        // Ambil data monitoring terakhir sebelum data saat ini
        $lastMonitoring = Monitoring::where('id', '<', $id)
                                   ->latest()
                                   ->first();
        
        return view('mobile.final-input', compact('monitoring', 'lastMonitoring'));
    }

    public function saveFinalInput(Request $request, $id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            
            $validated = $request->validate([
                'kedalaman_tertanam' => 'required|numeric',
                'tekanan' => 'required|numeric'
            ]);

            $monitoring->update($validated);

            // Hitung ulang produktivitas HSPD
            if ($monitoring->ts > 0) {
                $monitoring->produktivitas_hspd = (1 * $monitoring->kedalaman_tertanam * 60 * $monitoring->fa) / ($monitoring->ts / 60);
                $monitoring->save();
            }

            return redirect()->route('mobile.recap')
                ->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function finalInputNew($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        
        // Ambil data monitoring terakhir sebelum data saat ini
        $lastMonitoring = Monitoring::where('id', '<', $id)
                                   ->latest()
                                   ->first();
        
        return view('mobile.final-input-new', compact('monitoring', 'lastMonitoring'));
    }

    public function saveFinalInputNew(Request $request, $id)
    {
        try {
            $monitoring = Monitoring::findOrFail($id);
            
            $validated = $request->validate([
                'kedalaman_tertanam' => 'required|numeric',
                'tekanan' => 'required|numeric',
                'laporan' => 'required|string'
            ]);

            $monitoring->update($validated);

            // Hitung ulang produktivitas HSPD
            if ($monitoring->ts > 0) {
                $monitoring->produktivitas_hspd = (1 * $monitoring->kedalaman_tertanam * 60 * $monitoring->fa) / ($monitoring->ts / 60);
                $monitoring->save();
            }

            return redirect()->route('mobile.recap')
                ->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
