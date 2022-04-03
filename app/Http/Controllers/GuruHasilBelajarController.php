<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Kelas as Kelas;
use \App\Guru as Guru;
use \App\Siswa as Siswa;
use \App\Anggota as Anggota;
use \App\Penugasan as Penugasan;
use \App\Informasi as Informasi;
use \App\Quiz as Quiz;
use \App\Pertemuan as Pertemuan;

class GuruHasilBelajarController extends Controller
{
    public function hasilBelajarSiswa() {
        if (\Auth::guard('guru')->check()) {
            $data['kelas'] = Kelas::where('guru_id', \Auth::guard('guru')->user()->id)->get();
            $id = \Auth::guard('guru')->user()->id; // id guru
                
            $data['objek_profil'] = Guru::findOrFail($id);
            $data['action_profil'] = ['GuruController@updateProfil', $id];
            $data['method_profil'] = 'PUT';

            return view('guru-hasil-belajar', $data);
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/guru')->with('pesan', 'Anda Belum Terdaftar Sebagai Guru.');
        }
    }

    public function detailHasilBelajar($id) {
        //bawa id siswa

        if (\Auth::guard('guru')->check()) {
            
            $anggota = Anggota::where('id', $id)->first();
            $guru_id = $anggota->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                $anggota = Anggota::where('id', $id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['siswa'] = $anggota->siswa;

                $kelas = $anggota->kelas;

                $data['penugasan'] = Penugasan::where('kelas_id', $kelas->id)->latest()->get();
                $data['informasi'] = Informasi::where('kelas_id', $kelas->id)->latest()->get();
                $data['quiz_pilgan'] = Quiz::where('kelas_id', $kelas->id)->where('tipe', 'Quiz Pilgan')->latest()->get();
                $data['quiz_essay'] = Quiz::where('kelas_id', $kelas->id)->where('tipe', 'Quiz Essay')->latest()->get();
                $data['pertemuan'] = Pertemuan::where('kelas_id', $kelas->id)->latest()->get();
                $data['x'] = 1;

                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-hasil-belajar', $data);

            } else {
                return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/guru')->with('pesan', 'Anda Belum Terdaftar Sebagai Guru.');
        }

    }
}
