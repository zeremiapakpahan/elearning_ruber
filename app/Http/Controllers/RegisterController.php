<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Guru as Guru;
use \App\Siswa as Siswa;
use \App\User as User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function formRegisterGuru() {
        if (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Anda Sudah Login.');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda');
        } else {
            $data['objek'] = new Guru();
            $data['action'] = 'RegisterController@simpanRegisterGuru';
            $data['method'] = 'POST';
            return view('register', $data);
        }
    }

    public function simpanRegisterGuru(Request $request) {

        // Form Validation

        $rules = [
            'nama'          => 'required',
            'email'         => 'required|email|unique:gurus,email',
            'password'      => 'required'
        ];

        $messages = [
            'nama.required'      => 'Nama lengkap tidak boleh kosong.',
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email salah.',
            'email.unique'       => 'Email ini telah digunakan.',
            'password.required'  => 'Password tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Store

        $guru = new Guru();
        $guru->nama         = $request->nama;
        $guru->email        = $request->email;
        $guru->password     = bcrypt($request->password);
        $guru->status       = 'Guru';
        $guru->save();

        $user = new User();
        $user->admin_id     = 0;
        $user->guru_id      = $guru->id;
        $user->siswa_id     = 0;
        $user->save();

        // Login Guru
        \Auth::guard('guru')->login($guru);

        return redirect('guru/beranda')->with('pesan', 'Selamat, Pendaftaran Anda Berhasil.');
        
    }

    public function formRegisterSiswa() {
        if (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Anda Sudah Login.');
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda');
        } else {
            $data['objek'] = new Siswa();
            $data['action'] = 'RegisterController@simpanRegisterSiswa';
            $data['method'] = 'POST';
            return view('register', $data);
        }
    }

    public function simpanRegisterSiswa(Request $request) {

        // Form Validation

        $rules = [
            'nama'          => 'required',
            'email'         => 'required|email|unique:siswas,email',
            'password'      => 'required'
        ];

        $messages = [
            'nama.required'         => 'Nama lengkap tidak boleh kosong.',
            'email.required'        => 'Email tidak boleh kosong.',
            'email.email'           => 'Format email salah.',
            'email.unique'          => 'Email ini telah digunakan.',
            'password.required'     => 'Password tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Store

        $siswa = new Siswa();
        $siswa->nama        = $request->nama;
        $siswa->email       = $request->email;
        $siswa->password    = bcrypt($request->password);
        $siswa->status      = 'Siswa';
        $siswa->save();

        $user = new User();
        $user->admin_id     = 0;
        $user->guru_id      = 0;
        $user->siswa_id     = $siswa->id;
        $user->save();

        // Login Siswa
        \Auth::guard('siswa')->login($siswa);

        return redirect('siswa/beranda')->with('pesan', 'Selamat, Pendaftaran Anda Berhasil.');


    }
}
