<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Siswa as Siswa;
use \App\Kelas as Kelas;
use \App\Anggota as Anggota;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function dashboard() {
        if (\Auth::guard('siswa')->check()) {
            $data['anggota'] = Anggota::where('siswa_id', \Auth::guard('siswa')->user()->id)->get();
            $id = \Auth::guard('siswa')->user()->id;

            $data['objek_profil'] = Siswa::findOrFail($id);
            $data['action_profil'] = ['SiswaController@updateProfil', $id];
            $data['method_profil'] = 'PUT';
            
            return view('beranda-siswa', $data);
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function kelas() {
        if (\Auth::guard('siswa')->check()) {

            $data['objek'] = new Anggota();
            $data['action'] = 'SiswaController@gabungKelas';
            $data['method'] = 'POST';
            $data['anggota'] = Anggota::where('siswa_id', \Auth::guard('siswa')->user()->id)->get();
            $id = \Auth::guard('siswa')->user()->id;

            $data['objek_profil'] = Siswa::findOrFail($id);
            $data['action_profil'] = ['SiswaController@updateProfil', $id];
            $data['method_profil'] = 'PUT';

            return view('kelas-siswa', $data);
            
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function gabungKelas(Request $request) {
        
        // Form Validation

        $rules = [
            'kode_kelas'        => 'required|min:6|max:6'
        ];

        $messages = [
            'kode_kelas.required'       => 'Kode kelas tidak boleh kosong.',
            'kode_kelas.min'            => 'Kode kelas tidak boleh kurang dari 6 karakter.',
            'kode_kelas.max'            => 'Kode kelas tidak boleh lebih dari 6 karakter.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Store

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();

        $anggota_ganda = Anggota::where('kelas_id', $kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

        // Agar tidak bergabung berkali-kali
        if ($anggota_ganda != '') {
            return back()->with('pesan2', 'Anda Telah Bergabung Ke Dalam Kelas.');
        }

        if ($kelas == '') {
            return back()->with('pesan2', 'Kode Kelas Tidak Valid');
        }

        $anggota = new Anggota();
        $anggota->kelas_id      = $kelas->id;
        $anggota->guru_id       = 0;
        $anggota->siswa_id      = \Auth::guard('siswa')->user()->id;
        $anggota->save();

        return back()->with('pesan', 'Selamat, Anda Telah Bergabung Ke Dalam Kelas.');
    }

    public function updateProfil(Request $request, $id) {

        // Form Validation

        if ($request->has(['nama', 'email', 'password'])) {
            
            $rules = [
                'nama'          => 'required',
                'email'         => 'required|email',
                'password'      => 'required'
            ];

            $messages = [
                'nama.required'         => 'Nama lengkap tidak boleh kosong.',
                'email.required'        => 'Email tidak boleh kosong.',
                'email.email'           => 'Format email salah.',
                'password.required'     => 'Password tidak boleh kosong.'
            ];

            $validasi = Validator::make($request->all(), $rules, $messages);

            if ($validasi->fails()) {
                return back()->withErrors($validasi)->withInput();
            }

        }

        // Data Update

        $siswa = Siswa::findOrFail($id);
        if ($request->has(['nama', 'email', 'password'])) {
            $siswa->nama         = $request->nama;
            $siswa->email        = $request->email;
            $siswa->password     = bcrypt($request->password);
        }
        $siswa->status          = "Siswa";
        if ($request->hasFile('foto')) {
            if ($siswa->foto != '') {
                \Storage::delete($siswa->foto);
            }
            $file           = $request->file('foto');
            $filename       = $file->getClientOriginalName();
            $path           = $file->storeAs('public/foto-profil-siswa', $filename);
            $siswa->foto    = $path;
        }
        $siswa->save();

        return back()->with('pesan', 'Selamat, Profil Anda Berhasil Diupdate.');

    }

    public function logout() {
        if (\Auth::guard('siswa')->check()) {

            \Auth::guard('siswa')->logout();
            return redirect('/');
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }
}
