<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Priv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::user()->id_priv != 1) {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }

        $data = User::all();
        $priv = Priv::all();
        return view('user.index', compact('data', 'priv'));
    }

    public function store(Request $request)
    {
        try {
            if (Auth::user()->id_priv != 1) {
                return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
            }

            $user = new User;
            $user->name = $request->name;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;
            $user->password = bcrypt($request->password);
            $user->id_priv = $request->id_priv;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('images/user/' . $filename, File::get($file));
                $user->foto = $filename;
            }

            $user->save();

            Log::create([
                'id_user' => Auth::id(),
                'aktivitas' => 'Menambahkan user ' . $user->name
            ]);

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (Auth::user()->id_priv != 1) {
                return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
            }

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;
            $user->id_priv = $request->id_priv;

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->foto) {
                    Storage::disk('public')->delete('images/user/' . $user->foto);
                }
                
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('images/user/' . $filename, File::get($file));
                $user->foto = $filename;
            }

            $user->save();

            Log::create([
                'id_user' => Auth::id(),
                'aktivitas' => 'Memperbarui user ' . $user->name
            ]);

            return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (Auth::user()->id_priv != 1) {
                return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
            }

            $user = User::findOrFail($id);
            
            // Hapus foto jika ada
            if ($user->foto) {
                Storage::disk('public')->delete('images/user/' . $user->foto);
            }

            Log::create([
                'id_user' => Auth::id(),
                'aktivitas' => 'Menghapus user ' . $user->name
            ]);

            $user->delete();

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    public function profil()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $file = $request->foto;
        if ($file != null) {
            $extension = $file->getClientOriginalExtension();
        }else{
            $extension = null;
        }
        if ($extension != null) {
            $mimetype = $file->getClientMimeType();
        }else{
            $mimetype = null;
        }
        if ($mimetype != null) {
            $filegambar = $file->getFilename().'.'.$extension;
            Storage::disk('public')->put('/images/user/'.$file->getFilename().'.'.$extension,File::get($file));
        }else{
            $filegambar = null;
        }
        if ($request->foto) {
            Storage::delete('public/images/user/'.$request->foto_lama);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->alamat = $request->alamat;
        $user->id_priv = $request->id_priv;
        if ($filegambar != null) {
            $user->foto = $filegambar;
        }
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $log = new Log;
        $log->id_user = $user->id;
        $log->aktivitas = 'Memperbarui profil';
        $log->save();

        return redirect('/user/profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateProfilPass(Request $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        $log = new Log;
        $log->id_user = $user->id;
        $log->aktivitas = 'Mengganti password';
        $log->save();

        return redirect('/user/profil')->with('success', 'Password berhasil diganti.');
    }
}
