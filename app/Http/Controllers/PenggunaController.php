<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Priv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::all();
        $priv = Priv::all();
        return view('pengguna.index', compact('users', 'priv'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'no_telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'id_priv' => 'required|exists:privs,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $userData = [
                'name' => $request->name,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'id_priv' => $request->id_priv
            ];

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('images/user/' . $filename, File::get($file));
                $userData['foto'] = $filename;
            }

            User::create($userData);

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'no_telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'id_priv' => 'required|exists:privs,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $userData = [
                'name' => $request->name,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'id_priv' => $request->id_priv
            ];

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->foto) {
                    Storage::disk('public')->delete('images/user/' . $user->foto);
                }
                
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('images/user/' . $filename, File::get($file));
                $userData['foto'] = $filename;
            }

            $user->update($userData);

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            // Hapus foto jika ada
            if ($user->foto) {
                Storage::disk('public')->delete('images/user/' . $user->foto);
            }

            $user->delete();

            return redirect()->route('pengguna.index')
                ->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
} 