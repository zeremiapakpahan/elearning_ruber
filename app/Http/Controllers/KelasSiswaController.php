<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Siswa as Siswa;
use \App\Kelas as Kelas;
use \App\Anggota as Anggota;
use \App\Penugasan as Penugasan;
use \App\Informasi as Informasi;
use \App\Quiz as Quiz;
use \App\KomentarTugas as KomenTugas;
use \App\FileKomenTugas as FileKomenTugas;
use \App\KomentarInfo as KomenInfo;
use \App\FileKomenInfo as FileKomenInfo;
use \App\ProsesTugas as ProsesTugas;
use \App\FileProsesTugas as FileProsesTugas;
use \App\KomenHasilTugas as KomenHasilTugas;
use \App\FileKomenHasilTugas as FileKomenHasilTugas;
use \App\ProsesQuizPilgan as ProsesQuizPilgan;
use \App\HasilQuizPilgan as HasilQuizPilgan;
use \App\WhQp as WhQp;
use \App\ProsesQuizEssay as ProsesQuizEssay;
use \App\WhQe as WhQe;
use \App\Kehadiran as Kehadiran;
use \App\Pertemuan as Pertemuan;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KelasSiswaController extends Controller
{
    public function timeline($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['penugasan'] = Penugasan::where('kelas_id', $id)->latest()->get();
                $data['informasi'] = Informasi::where('kelas_id', $id)->latest()->get();
                $data['quiz_pilgan'] = Quiz::where('kelas_id', $id)->where('tipe', 'Quiz Pilgan')->latest()->get();
                $data['quiz_essay'] = Quiz::where('kelas_id', $id)->where('tipe', 'Quiz Essay')->latest()->get();
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                 // Tutup penugasan, quiz otomatis saat sudah melewati batas
                $penugasan = $anggota->kelas->penugasan;
                foreach ($penugasan as $penugasan) {
                    if (Carbon::now()->timestamp > strtotime($penugasan->batas) ) {
                        $penugasan->status = "Tutup";
                        $penugasan->save();
                    }
                }
                // dd($penugasan);

                $quiz_pilgan = $anggota->kelas->quiz->where('tipe', 'Quiz Pilgan');
                foreach ($quiz_pilgan as $qp) {
                    if (Carbon::now()->timestamp > strtotime($qp->batas)) {
                        $qp->status = "Tutup";
                        $qp->save();
                    }
                }
                // dd($quiz_pilgan);

                $quiz_essay = $anggota->kelas->quiz->where('tipe', 'Quiz Essay');
                foreach ($quiz_essay as $qe) {
                    if (Carbon::now()->timestamp > strtotime($qe->batas)) {
                        $qe->status = "Tutup";
                        $qe->save();
                    }
                }
                // dd($quiz_essay);

                return view('index-kelas-siswa', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
        
    }

    public function komentarPenugasan($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $penugasan = Penugasan::where('id', $id)->first();
            if ($penugasan == '') {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {

                $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['penugasan'] = Penugasan::where('id', $id)->first();
                $data['komen_guru'] = KomenTugas::where('tugas_id', $id)->where('siswa_id', 0)->latest()->get();
                $data['komen_siswa'] = KomenTugas::where('tugas_id', $id)->where('guru_id', 0)->where('siswa_id', '!=', \Auth::guard('siswa')->user()->id)->latest()->get();
                $data['komen_pribadi'] = KomenTugas::where('tugas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->latest()->get();
                $data['objek'] = new KomenTugas();
                $data['action'] = 'KelasSiswaController@simpanKomentarTugas';
                $data['method'] = 'POST';
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-komentar-tugas', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function simpanKomentarTugas(Request $request) {
        
        // Form Validation

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'              => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'         => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Hapus Komen Ganda

        $komen_ganda = KomenTugas::where('tugas_id', $request->tugas_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->where('isi', $request->isi)->first();

        if ($komen_ganda != '') {
            foreach ($komen_ganda->fileKomenTugas as $files) {
                \Storage::delete($files->nama_file);
                $files->delete();
            }
            $komen_ganda->delete();
        }

        // Data Store

        $komenTugas = new KomenTugas();
        $komenTugas->tugas_id       = $request->tugas_id;
        $komenTugas->guru_id        = 0;
        $komenTugas->siswa_id       = \Auth::guard('siswa')->user()->id;
        $komenTugas->isi            = $request->isi;
        $komenTugas->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files) {
                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-komentar-tugas', $filename);

                $fileKomenTugas = new FileKomenTugas();
                $fileKomenTugas->komen_tugas_id     = $komenTugas->id;
                $fileKomenTugas->nama_file          = $path;
                $fileKomenTugas->save();

            }

        }

        return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dibuat.');
    }

    public function editKomentarTugas($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $komenTugas = KomenTugas::findOrFail($id);
            $penugasan = $komenTugas->penugasan;
            
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                if ($komenTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                    $data['penugasan'] = $komenTugas->penugasan;
                    $data['kelas'] = $anggota->kelas;
                    $data['objek'] = KomenTugas::findOrFail($id);
                    $data['action'] = ['KelasSiswaController@updateKomentarTugas', $id];
                    $data['method'] = 'PUT';
                    $id = \Auth::guard('siswa')->user()->id;
    
                    $data['objek_profil'] = Siswa::findOrFail($id);
                    $data['action_profil'] = ['SiswaController@updateProfil', $id];
                    $data['method_profil'] = 'PUT';
    
                    return view('siswa-komentar-tugas', $data);
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    } 

    public function updateKomentarTugas(Request $request, $id) {
        
        // Form Validation

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'              => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'         => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $komenTugas = KomenTugas::findOrFail($id);
        $komenTugas->tugas_id       = $request->tugas_id;
        $komenTugas->guru_id        = 0;
        $komenTugas->siswa_id       = \Auth::guard('siswa')->user()->id;
        $komenTugas->isi            = $request->isi;
        $komenTugas->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files => $value) {
                $arr = FileKomenTugas::where('komen_tugas_id', $id)->get();
                $fileKomenTugas = $arr[$files];
                \Storage::delete($fileKomenTugas->nama_file);

                $filename = $value->getClientOriginalName();
                $path = $value->storeAs('public/file-komentar-tugas', $filename);

                $arr = FileKomenTugas::where('komen_tugas_id', $id)->get();
                $fileKomenTugas = $arr[$files];
                $fileKomenTugas->komen_tugas_id     = $komenTugas->id;
                $fileKomenTugas->nama_file          = $path;
                $fileKomenTugas->save();

            }

        }

        return redirect('siswa/kelas/komentar-penugasan/'.$komenTugas->penugasan->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');

    }

    public function hapusKomentarTugas($id) {

        if (\Auth::guard('siswa')->check()) {
            
            $komenTugas = KomenTugas::findOrFail($id);
            $penugasan = $komenTugas->penugasan;
            
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {

                if ($komenTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $komenTugas = KomenTugas::findOrFail($id);

                    foreach ($komenTugas->fileKomenTugas as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }

                    $komenTugas->delete();

                    return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dihapus.');
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }


    public function formKumpulTugas($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $penugasan = Penugasan::where('id', $id)->first();
            if ($penugasan == '') {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {

                $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['penugasan'] = Penugasan::where('id', $id)->first();
                $data['proses_tugas'] = ProsesTugas::where('tugas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['objek'] = new ProsesTugas;
                $data['action'] = 'KelasSiswaController@prosesKumpulTugas';
                $data['method'] = 'POST';
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-kumpulkan-tugas', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function prosesKumpulTugas(Request $request) {
        
        // Form Validation

        $rules = [
            'file'          => 'required',
            'file.*'        => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'file.required'         => 'File tidak boleh kosong.',
            'file.*.mimes'          => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $proses_tugas_ganda =  ProsesTugas::where('tugas_id', $request->tugas_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
        
        if ($proses_tugas_ganda != '') {
            foreach ($proses_tugas_ganda->fileProsesTugas as $files) {
                \Storage::delete($files->file);
                $files->delete();
            }
            $proses_tugas_ganda->delete();
        }

        // Data Store

        $prosesTugas = new ProsesTugas();
        $prosesTugas->tugas_id      = $request->tugas_id;
        $prosesTugas->siswa_id      = \Auth::guard('siswa')->user()->id;
        $prosesTugas->save();

        $files = $request->file('file');

        foreach ($files as $files) {
            $filename = $files->getClientOriginalName();
            $path = $files->storeAs('public/file-proses-tugas', $filename);

            $fileProsesTugas = new FileProsesTugas();
            $fileProsesTugas->proses_tugas_id       = $prosesTugas->id;
            $fileProsesTugas->file                  = $path;
            $fileProsesTugas->save();
            
        }

        return back()->with('pesan', 'Selamat, Hasil Tugas Anda Telah Dikumpulkan.');

    }

    public function editHasilTugas($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $prosesTugas = ProsesTugas::findOrFail($id);
            $penugasan = $prosesTugas->penugasan;
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {

                if ($prosesTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                    $data['kelas'] = $anggota->kelas;
                    $data['penugasan'] = $prosesTugas->penugasan;
                    $data['objek'] = ProsesTugas::findOrFail($id);
                    $data['action'] = ['KelasSiswaController@updateHasilTugas', $id];
                    $data['method'] = 'PUT';
                    $id = \Auth::guard('siswa')->user()->id;

                    $data['objek_profil'] = Siswa::findOrFail($id);
                    $data['action_profil'] = ['SiswaController@updateProfil', $id];
                    $data['method_profil'] = 'PUT';

                    return view('siswa-kumpulkan-tugas', $data);
                    
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function updateHasilTugas(Request $request, $id) {
        
        // Form Validation

        $rules = [
            'file'          => 'required',
            'file.*'        => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'file.required'         => 'File tidak boleh kosong.',
            'file.*.mimes'          => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $prosesTugas = ProsesTugas::findOrFail($id);
        $prosesTugas->tugas_id      = $request->tugas_id;
        $prosesTugas->siswa_id      = \Auth::guard('siswa')->user()->id;
        $prosesTugas->save();

        $files = $request->file('file');

        foreach ($files as $files => $value) {
            $arr = FileProsesTugas::where('proses_tugas_id', $id)->get();
            $fileProsesTugas = $arr[$files];
            \Storage::delete($fileProsesTugas->file);

            $filename = $value->getClientOriginalName();
            $path = $value->storeAs('public/file-proses-tugas', $filename);

            $arr = FileProsesTugas::where('proses_tugas_id', $id)->get();
            $fileProsesTugas = $arr[$files];
            $fileProsesTugas->proses_tugas_id       = $prosesTugas->id;
            $fileProsesTugas->file                  = $path;
            $fileProsesTugas->save();
            
        }

        return redirect('siswa/kelas/kumpulkan-tugas/'.$prosesTugas->penugasan->id)->with('pesan', 'Selamat, Hasil Tugas Anda Telah Diupdate.');

    }

    public function detailHasilTugas($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $prosesTugas = ProsesTugas::where('id', $id)->first();
            $penugasan = $prosesTugas->penugasan;
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($prosesTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $prosesTugas = ProsesTugas::where('id', $id)->first();
                    $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                    $data['kelas'] = $anggota->kelas;
                    $data['proses_tugas'] = ProsesTugas::where('id', $id)->first();
                    $data['objek'] = new KomenHasilTugas();
                    $data['action'] = 'KelasSiswaController@simpanKomenHasilTugas';
                    $data['method'] = 'POST';
                    if ($prosesTugas->hasilTugas != '') {
                        $hasil_tugas = $prosesTugas->hasilTugas;
                        $data['komen_guru'] = KomenHasilTugas::where('hasil_tugas_id', $hasil_tugas->id)->where('siswa_id', 0)->latest()->get();
                        $data['komen_siswa'] = KomenHasilTugas::where('hasil_tugas_id', $hasil_tugas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->latest()->get();
                    }
                    $id = \Auth::guard('siswa')->user()->id;

                    $data['objek_profil'] = Siswa::findOrFail($id);
                    $data['action_profil'] = ['SiswaController@updateProfil', $id];
                    $data['method_profil'] = 'PUT';

                    return view('siswa-hasil-tugas', $data);
                    
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }
                
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }


    }

    public function simpanKomenHasilTugas(Request $request) {
        
        // Form Validation 

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $komen_ganda = KomenHasilTugas::where('hasil_tugas_id', $request->hasil_tugas_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->where('isi', $request->isi)->first();

        if ($komen_ganda != '') {
            foreach ($komen_ganda->fileKomenHasilTugas as $files) {
                \Storage::delete($files->nama_file);
                $files->delete();
            }
            $komen_ganda->delete();
        }

        // Data Store

        $komenHasilTugas = new KomenHasilTugas();
        $komenHasilTugas->hasil_tugas_id        = $request->hasil_tugas_id;
        $komenHasilTugas->guru_id               = 0;
        $komenHasilTugas->siswa_id              = \Auth::guard('siswa')->user()->id;
        $komenHasilTugas->isi                   = $request->isi;
        $komenHasilTugas->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files) {
                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-komentar-hasil-tugas', $filename);

                $fileKomenHasilTugas = new FileKomenHasilTugas();
                $fileKomenHasilTugas->komen_hasil_tugas_id          = $komenHasilTugas->id;
                $fileKomenHasilTugas->nama_file                     = $path;
                $fileKomenHasilTugas->save();
            }
        }

        return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dibuat.');
    }

    public function editKomenHasilTugas($id) {
        
        if (\Auth::guard('siswa')->check()) {

            $komenHasilTugas = KomenHasilTugas::findOrFail($id);
            $hasilTugas = $komenHasilTugas->hasilTugas;
            $prosesTugas = $hasilTugas->prosesTugas;
            $penugasan = $prosesTugas->penugasan;
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($komenHasilTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $komenHasilTugas = KomenHasilTugas::findOrFail($id);
                    $hasilTugas = $komenHasilTugas->hasilTugas;
                    $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                    $data['kelas'] = $anggota->kelas;
                    $data['proses_tugas'] = $hasilTugas->prosesTugas;
                    $data['hasil_tugas'] = $komenHasilTugas->hasilTugas;
                    $data['objek'] = KomenHasilTugas::findOrFail($id);
                    $data['action'] = ['KelasSiswaController@updateKomenHasilTugas', $id];
                    $data['method'] = 'PUT';
                    $id = \Auth::guard('siswa')->user()->id;

                    $data['objek_profil'] = Siswa::findOrFail($id);
                    $data['action_profil'] = ['SiswaController@updateProfil', $id];
                    $data['method_profil'] = 'PUT';

                    return view('siswa-hasil-tugas', $data);
                    
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function updateKomenHasilTugas(Request $request, $id) {
        
        // Form Validation 

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $komenHasilTugas = KomenHasilTugas::findOrFail($id);
        $komenHasilTugas->hasil_tugas_id        = $request->hasil_tugas_id;
        $komenHasilTugas->guru_id               = 0;
        $komenHasilTugas->siswa_id              = \Auth::guard('siswa')->user()->id;
        $komenHasilTugas->isi                   = $request->isi;
        $komenHasilTugas->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files => $value) {
                $arr = FileKomenHasilTugas::where('komen_hasil_tugas_id', $id)->get();
                $fileKomenHasilTugas = $arr[$files];
                \Storage::delete($fileKomenHasilTugas->nama_file);

                $filename = $value->getClientOriginalName();
                $path = $value->storeAs('public/file-komentar-hasil-tugas', $filename);

                $arr = FileKomenHasilTugas::where('komen_hasil_tugas_id', $id)->get();
                $fileKomenHasilTugas = $arr[$files];
                $fileKomenHasilTugas->komen_hasil_tugas_id          = $komenHasilTugas->id;
                $fileKomenHasilTugas->nama_file                     = $path;
                $fileKomenHasilTugas->save();
            }
        }

        return redirect('siswa/kelas/hasil-tugas/'.$komenHasilTugas->hasilTugas->prosesTugas->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');
    }

    public function hapusKomenHasilTugas($id) {
        
        if (\Auth::guard('siswa')->check()) {

            $komenHasilTugas = KomenHasilTugas::findOrFail($id);
            $hasilTugas = $komenHasilTugas->hasilTugas;
            $prosesTugas = $hasilTugas->prosesTugas;
            $penugasan = $prosesTugas->penugasan;
            $anggota = Anggota::where('kelas_id', $penugasan->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($komenHasilTugas->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $komenHasilTugas = KomenHasilTugas::findOrFail($id);

                    foreach ($komenHasilTugas->fileKomenHasilTugas as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }

                    $komenHasilTugas->delete();

                    return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dihapus.');
                    
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function komentarInformasi($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $info = Informasi::where('id', $id)->first();
            if ($info == '') {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }
            $anggota = Anggota::where('kelas_id', $info->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {

                $anggota = Anggota::where('kelas_id', $info->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['info'] = Informasi::where('id', $id)->first();
                $data['komen_guru'] = KomenInfo::where('info_id', $id)->where('siswa_id', 0)->latest()->get();
                $data['komen_siswa'] = KomenInfo::where('info_id', $id)->where('guru_id', 0)->where('siswa_id', '!=', \Auth::guard('siswa')->user()->id)->latest()->get();
                $data['komen_pribadi'] = KomenInfo::where('info_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->latest()->get();
                $data['objek'] = new KomenInfo();
                $data['action'] = 'KelasSiswaController@simpanKomentarInfo';
                $data['method'] = 'POST';
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-komentar-info', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function simpanKomentarInfo(Request $request) {

        // Form Validation 

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $komen_ganda = KomenInfo::where('info_id', $request->info_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->where('isi', $request->isi)->first();

        if ($komen_ganda != '') {
            foreach ($komen_ganda->fileKomenInfo as $files) {
                \Storage::delete($files->nama_file);
                $files->delete();
            }
            $komen_ganda->delete();
        }

        // Data Store
        
        $komenInfo = new KomenInfo();
        $komenInfo->info_id         = $request->info_id;
        $komenInfo->guru_id         = 0;
        $komenInfo->siswa_id        = \Auth::guard('siswa')->user()->id;
        $komenInfo->isi             = $request->isi;
        $komenInfo->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files) {
                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-komentar-info', $filename);

                $fileKomenInfo = new FileKomenInfo();
                $fileKomenInfo->komen_info_id       = $komenInfo->id;
                $fileKomenInfo->nama_file           = $path;
                $fileKomenInfo->save();
            }

        }

        return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dibuat.');

    }

    public function editKomentarInfo($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $komenInfo = KomenInfo::findOrFail($id);
            $info = $komenInfo->informasi;
            $anggota = Anggota::where('kelas_id', $info->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($komenInfo->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $komenInfo = KomenInfo::findOrFail($id);
                    $anggota = Anggota::where('kelas_id', $info->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                    $data['kelas'] = $anggota->kelas;
                    $data['info'] = $komenInfo->informasi;
                    $data['objek'] = KomenInfo::findOrFail($id);
                    $data['action'] = ['KelasSiswaController@updateKomentarInfo', $id];
                    $data['method'] = 'PUT';
                    $id = \Auth::guard('siswa')->user()->id;

                    $data['objek_profil'] = Siswa::findOrFail($id);
                    $data['action_profil'] = ['SiswaController@updateProfil', $id];
                    $data['method_profil'] = 'PUT';

                    return view('siswa-komentar-info', $data);
                    
                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function updateKomentarInfo(Request $request, $id) {
        
        // Form Validation 

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update
        
        $komenInfo = KomenInfo::findOrFail($id);
        $komenInfo->info_id         = $request->info_id;
        $komenInfo->guru_id         = 0;
        $komenInfo->siswa_id        = \Auth::guard('siswa')->user()->id;
        $komenInfo->isi             = $request->isi;
        $komenInfo->save();

        if ($request->hasFile('nama_file')) {
            
            $files = $request->file('nama_file');

            foreach ($files as $files => $value) {
                $arr = FileKomenInfo::where('komen_info_id', $id)->get();
                $fileKomenInfo = $arr[$files];
                \Storage::delete($fileKomenInfo->nama_file);

                $filename = $value->getClientOriginalName();
                $path = $value->storeAs('public/file-komentar-info', $filename);

                $arr = FileKomenInfo::where('komen_info_id', $id)->get();
                $fileKomenInfo = $arr[$files];
                $fileKomenInfo->komen_info_id       = $komenInfo->id;
                $fileKomenInfo->nama_file           = $path;
                $fileKomenInfo->save();
            }

        }

        return redirect('siswa/kelas/komentar-informasi/'.$komenInfo->informasi->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');

    }

    public function hapusKomentarInfo($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $komenInfo = KomenInfo::findOrFail($id);
            $info = $komenInfo->informasi;
            $anggota = Anggota::where('kelas_id', $info->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($komenInfo->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $komenInfo = KomenInfo::findOrFail($id);
                    
                    foreach ($komenInfo->fileKomenInfo as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }

                    $komenInfo->delete();

                    return back()->with('pesan', 'Selamat. Komentar Anda Berhasil Dihapus.');

                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function formQuizPilgan($id) {

        if (\Auth::guard('siswa')->check()) {
            
            $quiz = Quiz::where('id', $id)->first();
            $anggota = Anggota::where('kelas_id', $quiz->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $quiz = Quiz::where('id', $id)->first();
                // Waktu Sekarang
                $now = Carbon::now();
                // Tambah Waktu berdasarkan 'durasi' quiz yang di pilih
                $future = $now->addMinutes($quiz->time);
                // penting untuk membuat countdown yang efisien
                $future = $future->format('Y n d H i s');
                // dd($future);
                
                $anggota = Anggota::where('kelas_id', $quiz->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['quiz'] = Quiz::where('id', $id)->first();
                // kirim data ke blade
                $data['times_up'] = $future;
                $data['objek'] = new ProsesQuizPilgan();
                $data['action'] = 'KelasSiswaController@prosesQuizPilgan';
                $data['method'] = 'POST';

                $data['objek2'] = new WhQp();
                $data['action2'] = 'KelasSiswaController@waktuHabisQuizPilgan';
                $data['method2'] = 'POST';

                foreach ($quiz->quizPilgan as $index => $qp ) {
                    if ($index == 0) {
                        $proses_quiz_pilgan = $qp->prosesQuizPilgan->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                        $data['proses'] = $proses_quiz_pilgan;
                    }
                }

                $data['whqp'] = WhQp::where('quiz_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-quiz-pilgan', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function prosesQuizPilgan(Request $request) {
        
        // Form Validation 

        $rules = [
            'pilihan'       => 'required',
            'nilai'         => 'nullable'
        ];

        $messages = [
            'pilihan.required'      => 'Pilihan tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        if (count($request->quiz_pilgan_id) != count($request->pilihan)) {
            return back()->with('pesan2', 'Pilihan tidak boleh kosong.');
        }

        foreach ($request->pilihan as $index => $value) {
            // $proses_quiz_ganda = ProsesQuizPilgan::where('quiz_pilgan_id', $request->quiz_pilgan_id[$index])->where('siswa_id', \Auth::guard('siswa')->user()->id)->where('pilihan', $request->pilihan[$index])->first();
            $proses_quiz_ganda = ProsesQuizPilgan::where('quiz_pilgan_id', $request->quiz_pilgan_id[$index])->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
            if ($proses_quiz_ganda != '') {
                $proses_quiz_ganda->delete();
            }
        }

        // Data Store

        foreach ($request->pilihan as $index => $value) {
            $prosesQuizPilgan = new ProsesQuizPilgan();
            $prosesQuizPilgan->quiz_pilgan_id   = $request->quiz_pilgan_id[$index];
            $prosesQuizPilgan->siswa_id         = \Auth::guard('siswa')->user()->id;
            $prosesQuizPilgan->pilihan          = $request->pilihan[$index];
            if ($request->nilai[$index] != '') {
                $prosesQuizPilgan->nilai        = $request->nilai[$index];
            } else {
                $prosesQuizPilgan->nilai        = 0; 
            }
            $prosesQuizPilgan->save();
            
            // Untuk mengambil id dari proses quiz pilgan yang pertama
            if ($index == 0) {
                
                $id = $prosesQuizPilgan->id;
            }
        }
        
        $total = 0;
        $jumlah_soal = count($request->quiz_pilgan_id);

        //  Untuk mendapatkan total nilai quiz pilgan
        foreach ($request->nilai as $nilai) {
            // $total += $nilai;
            if ($nilai != '') {
                $true = 1;
                $total += $true;
            }
        }
        
        $hasilQuizPilgan = new HasilQuizPilgan();
        $hasilQuizPilgan->proses_quiz_pilgan_id     = $id;
        $hasilQuizPilgan->nilai_total               = round((100 / $jumlah_soal) * $total);
        $hasilQuizPilgan->save();

        return back()->with('pesan', 'Selamat, Anda Telah Menyelesaikan Quiz Pilgan.');

        // belom selesai jok, pelajari lagi yang diatas
        // buat old value di blade
        // atur kondisi timer kalo quiz lah dikirim

    }

    public function waktuHabisQuizPilgan(Request $request) {
        
        $whqp_ganda = WhQp::where('quiz_id', $request->quiz_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
        if ($whqp_ganda != '') {
            $whqp_ganda->delete();
        }

        // Data Store

        $whQp = new WhQp;
        $whQp->quiz_id      = $request->quiz_id;
        $whQp->siswa_id     = \Auth::guard('siswa')->user()->id;
        $whQp->status       = '1';
        $whQp->save();

        return back();

    }

    public function formQuizEssay($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $quiz = Quiz::where('id', $id)->first();
            $anggota = Anggota::where('kelas_id', $quiz->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $quiz = Quiz::where('id', $id)->first();
                $now = Carbon::now();
                $future = $now->addMinutes($quiz->time);
                // penting untuk membuat countdown yang efisien
                $future = $future->format('Y n d H i s');
                // dd($future);

                $anggota = Anggota::where('kelas_id', $quiz->kelas->id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $data['quiz'] = Quiz::where('id', $id)->first();

                $data['times_up'] = $future;

                $data['objek'] = new ProsesQuizEssay();
                $data['action'] = 'KelasSiswaController@prosesQuizEssay';
                $data['method'] = 'POST';

                $data['objek2'] = new WhQe();
                $data['action2'] = 'KelasSiswaController@waktuHabisQuizEssay';
                $data['method2'] = 'POST';

                foreach ($quiz->quizEssay as $index => $qe) {
                    if ($index == 0) {
                        $proses_quiz_essay = $qe->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                        $data['proses'] = $proses_quiz_essay;
                    }
                }

                $data['whqe'] = WhQe::where('quiz_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-quiz-essay', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function prosesQuizEssay(Request $request) {
        
        // Form Validation

        $rules = [
            'jawaban'       => 'required'
        ];

        $messages = [
            'jawaban.required'     => 'Jawaban tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Jawaban tidak boleh kosong.

        foreach ($request->jawaban as $jawaban) {
            if ($jawaban == '') {
                return back()->with('pesan2', 'Jawaban tidak boleh kosong.');
            }
        }

        foreach ($request->jawaban as $index => $value) {
            $proses_quiz_ganda = ProsesQuizEssay::where('quiz_essay_id', $request->quiz_essay_id[$index])->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
            if ($proses_quiz_ganda != '') {
                $proses_quiz_ganda->delete();
            }
        }

        // Data Store

        foreach ($request->jawaban as $index => $value) {
            $prosesQuizEssay = new ProsesQuizEssay();
            $prosesQuizEssay->quiz_essay_id         = $request->quiz_essay_id[$index];
            $prosesQuizEssay->siswa_id              = \Auth::guard('siswa')->user()->id;
            $prosesQuizEssay->jawaban               = $request->jawaban[$index];
            $prosesQuizEssay->save();
        }

        return back()->with('pesan', 'Selamat, Anda Telah Menyelesaikan Quiz Essay.');

    }

    public function waktuHabisQuizEssay(Request $request) {

        $whqe_ganda = WhQe::where('quiz_id', $request->quiz_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
        if ($whqe_ganda != '') {
            $whqe_ganda->delete();
        }

        // Data Store

        $whQe = new WhQe();
        $whQe->quiz_id      = $request->quiz_id;
        $whQe->siswa_id     = \Auth::guard('siswa')->user()->id;
        $whQe->status       = '1';
        $whQe->save();

        return back();
    }

    public function kehadiran($id) {
        if (\Auth::guard('siswa')->check()) {
            
            $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;

                $data['objek'] = new Kehadiran();
                $data['action'] = 'KelasSiswaController@simpanKehadiran';
                $data['method'] = 'POST';
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                // Tutup pertemuan otomatis saat sudah melewati batas
                $pertemuan = $anggota->kelas->pertemuan;
                foreach ($pertemuan as $pertemuan) {
                    if (Carbon::now()->timestamp > strtotime($pertemuan->batas) ) {
                        $pertemuan->status = "Tutup";
                        $pertemuan->save();
                    }
                }
                // dd($pertemuan);

                return view('siswa-kehadiran', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }
    }

    public function simpanKehadiran(Request $request) {

        // Form Validation

        $rules = [
            'keterangan'        => 'required'
        ];

        $messages = [
            'keterangan.required'       => 'Keterangan tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        if ($request->keterangan == '') {
            return back()->with('pesan2', 'Keterangan tidak boleh kosong.');
        }

        $kehadiran_ganda = Kehadiran::where('pertemuan_id', $request->pertemuan_id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
        if ($kehadiran_ganda != '') {
            $kehadiran_ganda->delete();
        }

        // Data Store

        $kehadiran = new Kehadiran();
        $kehadiran->pertemuan_id        = $request->pertemuan_id;
        $kehadiran->siswa_id            = \Auth::guard('siswa')->user()->id;
        $kehadiran->keterangan          = $request->keterangan;
        if ($request->keterangan == 'Hadir') {
            $kehadiran->point           = 1;
        } else {
            $kehadiran->point           = 0;
        }
        $kehadiran->save();

        return back()->with('pesan', 'Selamat, Data Kehadiran Anda Telah Disimpan.');

    }

    public function anggota($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;

                $data['guru'] = Anggota::where('kelas_id', $id)->where('siswa_id', 0)->first();
                $data['siswa_lain'] = Anggota::where('kelas_id', $id)->where('guru_id', 0)->where('siswa_id', '!=', \Auth::guard('siswa')->user()->id)->get();
                $data['pribadi'] = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('siswa-anggota-kelas', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function keluarKelas($id) {

        if (\Auth::guard('siswa')->check()) {
            
            $pribadi = Anggota::findOrFail($id);
            $anggota = Anggota::where('kelas_id', $pribadi->kelas->id )->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                
                if ($pribadi->siswa_id == \Auth::guard('siswa')->user()->id) {
                    
                    $pribadi = Anggota::findOrFail($id);

                    $siswa = $pribadi->siswa;

                    foreach ($siswa->komentarInfo as $komenInfo) {
                        foreach ($komenInfo->fileKomenInfo as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komenInfo->delete();
                    }

                    foreach ($siswa->komentarTugas as $komenTugas) {
                        foreach ($komenTugas->fileKomenTugas as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komenTugas->delete();
                    }

                    foreach ($siswa->komenHasilTugas as $komenHasilTugas) {
                        foreach ($komenHasilTugas->fileKomenHasilTugas as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komenHasilTugas->delete();
                    }

                    foreach ($siswa->prosesTugas as $prosesTugas) {
                        foreach ($prosesTugas->fileProsesTugas as $files) {
                            \Storage::delete($files->file);
                            $files->delete();
                        }
                        if ($prosesTugas->hasilTugas != '') {
                            $prosesTugas->hasilTugas->delete();
                        }
                        $prosesTugas->delete();
                    }

                    foreach ($siswa->prosesQuizPilgan as $index => $pQp) {
                        if ($index == 0) {
                            $pQp->hasilQuizPilgan->delete();
                        }
                        $pQp->delete();
                    }

                    foreach ($siswa->prosesQuizEssay as $index => $pQe) {
                        if ($index == 0) {
                            if ($pQe->hasilQuizEssay != '') {
                                $pQe->hasilQuizEssay->delete();
                            }
                        }
                        $pQe->delete();
                    }

                    foreach ($siswa->kehadiran as $kehadiran) {
                        $kehadiran->delete();
                    }

                    $pribadi->delete();

                    return redirect('siswa/kelas')->with('pesan', 'Anda Telah Keluar Dari Kelas.');

                } else {
                    return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
                }

            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

    public function detailKelas($id) {
        
        if (\Auth::guard('siswa')->check()) {
            
            $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();

            if ($anggota != '') {
                $anggota = Anggota::where('kelas_id', $id)->where('siswa_id', \Auth::guard('siswa')->user()->id)->first();
                $data['kelas'] = $anggota->kelas;
                $id = \Auth::guard('siswa')->user()->id;

                $data['objek_profil'] = Siswa::findOrFail($id);
                $data['action_profil'] = ['SiswaController@updateProfil', $id];
                $data['method_profil'] = 'PUT';
                
                return view('siswa-detail-kelas', $data);
            } else {
                return redirect('siswa/beranda')->with('pesan2', 'Akses Ditolak!');
            }

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan2', 'Akses Ditolak!');
        } elseif (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan2', 'Akses Ditolak!');
        } else {
            return redirect('register/siswa')->with('pesan', 'Anda Belum Terdaftar Sebagai Siswa.');
        }

    }

}
