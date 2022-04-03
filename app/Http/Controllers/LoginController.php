<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Guru as Guru;
use \App\Siswa as Siswa;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function formLoginGuru() {

        if (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Anda Sudah Login.');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda');
        }
        else {
            $data['objek'] = new Guru();
            $data['action'] = 'LoginController@prosesLoginGuru';
            $data['method'] = 'POST';
            return view('login', $data);
        }
    }

    public function prosesLoginGuru(Request $request) {

        //Form Validation

        $rules = [
            'email'     => 'required|email',
            'password'  => 'required'
        ];

        $messages = [
            'email.required'        => 'Email tidak boleh kosong.',
            'email.email'           => 'Format email salah.',
            'password.required'     => 'Password tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Processing

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (\Auth::guard('guru')->attempt($credentials)) {
            return redirect('guru/beranda')->with('pesan', 'Selamat, Anda Berhasil Login.');
        } else {
            return back()->with('pesan', 'Login Gagal, Email/Password Salah.');
        }
        

    }

    public function formLoginSiswa() {
        if (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Anda Sudah Login.');
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda');
        } else {
            $data['objek'] = new Siswa();
            $data['action'] = 'LoginController@prosesLoginSiswa';
            $data['method'] = 'POST';
            return view('login', $data);
        }
    }

    public function prosesLoginSiswa(Request $request) {
        
        // Form Validation

        $rules = [
            'email'         => 'required|email',
            'password'      => 'required'
        ];

        $messages = [
            'email.required'        => 'Email tidak boleh kosong.',
            'email.email'           => 'Format email salah.',
            'password.required'     => 'Password tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Processing

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (\Auth::guard('siswa')->attempt($credentials)) {
            return redirect('siswa/beranda')->with('pesan', 'Selamat, Anda Berhasil Login.');
        } else {
            return back()->with('pesan', 'Login Gagal, Email/Password Salah.');
        }

    }
}
