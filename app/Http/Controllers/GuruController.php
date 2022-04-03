<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Guru as Guru;
use \App\Kelas as Kelas;
use \App\Anggota as Anggota;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function dashboard() {

        if (\Auth::guard('guru')->check()) {
            $data['kelas'] = Kelas::where('guru_id', \Auth::guard('guru')->user()->id)->get();
            $id = \Auth::guard('guru')->user()->id; // id guru
                
            $data['objek_profil'] = Guru::findOrFail($id);
            $data['action_profil'] = ['GuruController@updateProfil', $id];
            $data['method_profil'] = 'PUT';
            
            return view('beranda-guru', $data);
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/guru')->with('pesan', 'Anda Belum Terdaftar Sebagai Guru.');
        }

    }

    public function kelas() {
        if (\Auth::guard('guru')->check()) {
            $id = \Auth::guard('guru')->user()->id; // id guru
            $data['objek'] = new Kelas();
            $data['action'] = 'GuruController@buatKelas';
            $data['method'] = 'POST';
            $data['objek_profil'] = Guru::findOrFail($id);
            $data['action_profil'] = ['GuruController@updateProfil', $id];
            $data['method_profil'] = 'PUT';
            $data['kelas'] = Kelas::where('guru_id', \Auth::guard('guru')->user()->id)->get();
            return view('kelas-guru', $data);
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/guru')->with('pesan', 'Anda Belum Terdaftar Sebagai Guru.');
        }
    }

    public function buatKelas(Request $request) {
        
        //Form Validation

        $rules = [
            'nama_kelas'    => 'required|max:70',
            'deskripsi'     => 'required',
            'kode_kelas'    => 'required|min:6|max:6|unique:kelas,kode_kelas'
        ];

        $messages = [
            'nama_kelas.required'   => 'Nama kelas tidak boleh kosong.',
            'nama_kelas.max'        => 'Nama kelas tidak boleh lebih dari 70 karakter.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'kode_kelas.required'   => 'Kode kelas tidak boleh kosong.',
            'kode_kelas.min'        => 'Kode kelas tidak boleh kurang dari 6 karakter.',
            'kode_kelas.max'        => 'Kode kelas tidak boleh lebih dari 6 karakter.',
            'kode_kelas.unique'     => 'Kode kelas ini telah digunakan.'
        ];
        
        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Hapus Data Yang Sama

        $kelas_ganda = Kelas::where('guru_id', \Auth::guard('guru')->user()->id)->where('nama_kelas', $request->nama_kelas)->where('deskripsi', $request->deskripsi)->first();

        if ($kelas_ganda != '') {
            $kelas_ganda->delete();
        }

        // Data Store

        $kelas = new Kelas();
        $kelas->guru_id         = \Auth::guard('guru')->user()->id;
        $kelas->nama_kelas      = $request->nama_kelas;
        $kelas->deskripsi       = $request->deskripsi;
        $kelas->kode_kelas      = $request->kode_kelas;
        $kelas->save();

        $anggota = new Anggota();
        $anggota->kelas_id      = $kelas->id;
        $anggota->guru_id       = $kelas->guru_id;
        $anggota->siswa_id      = 0;
        $anggota->save();

        return back()->with('pesan', 'Selamat, Kelas Berhasil Dibuat.');
    }

    public function updateProfil(Request $request, $id) {
        
        // Form Validation
        if ($request->has(['nama', 'email', 'password'])) {
            $rules = [
                'nama'         => 'required',
                'email'        => 'required|email',
                'password'     => 'required'
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

        $guru = Guru::findOrFail($id);
        if ($request->has(['nama', 'email', 'password'])) {
            $guru->nama         = $request->nama;
            $guru->email        = $request->email;
            $guru->password     = bcrypt($request->password);
        }
        $guru->status       = 'Guru';
        if ($request->hasFile('foto')) {
            if ($guru->foto != '') {
                \Storage::delete($guru->foto);
            }
            $file           = $request->file('foto');
            $filename       = $file->getClientOriginalName();
            $path           = $file->storeAs('public/foto-profil-guru', $filename);
            
            $guru->foto     = $path;
        }
        $guru->save();


        return back()->with('pesan', 'Selamat, Profil Anda Berhasil Diupdate.');
        

    }

    public function logout() {

        if (\Auth::guard('guru')->check()) {

            \Auth::guard('guru')->logout();
            return redirect('/');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/guru')->with('pesan', 'Anda Belum Terdaftar Sebagai Guru.');
        }
        
    }
}
