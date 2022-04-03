<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kelas as Kelas;
use \App\Siswa as Siswa;
use \App\Guru as Guru;
use \App\Informasi as Informasi;
use \App\FileInfo as FileInfo;
use \App\Penugasan as Penugasan;
use \App\FileTugas as FileTugas;
use \App\Quiz as Quiz;
use \App\QuizPilgan as QuizPilgan;
use \App\QuizEssay as QuizEssay;
use \App\ProsesQuizPilgan as ProsesQuizPilgan;
use \App\ProsesQuizEssay as ProsesQuizEssay;
use \App\HasilQuizEssay as HasilQuizEssay;
use \App\JawabanBenar as JawabanBenar;
use \App\KomentarTugas as KomenTugas;
use \App\FileKomenTugas as FileKomenTugas;
use \App\KomentarInfo as KomenInfo;
use \App\FileKomenInfo as FileKomenInfo;
use \App\Pertemuan as Pertemuan;
use \App\Anggota as Anggota;
use \App\ProsesTugas as ProsesTugas;
use \App\FileProsesTugas as FileProsesTugas;
use \App\HasilTugas as HasilTugas;
use \App\KomenHasilTugas as KomenHasilTugas;
use \App\FileKomenHasilTugas as FileKomenHasilTugas;
use \App\Kehadiran as Kehadiran;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KelasController extends Controller
{
    public function timeline($id) {

        if (\Auth::guard('guru')->check()) {
            
            $kelas = Kelas::where('id', $id)->first();
            $guru_id = $kelas->guru->id;
            
            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $kelas = Kelas::where('id', $id)->first();
                $data['kelas'] = Kelas::where('id', $id)->first();
                $data['penugasan'] = Penugasan::where('kelas_id', $id)->latest()->get();
                $data['informasi'] = Informasi::where('kelas_id', $id)->latest()->get();
                $data['quiz_pilgan'] = Quiz::where('kelas_id', $id)->where('tipe', 'Quiz Pilgan')->latest()->get();
                $data['quiz_essay'] = Quiz::where('kelas_id', $id)->where('tipe', 'Quiz Essay')->latest()->get();
                $data['x'] = 1;
                
                // $data['fileURL'] = "public/file-info/";
                $data['objek'] = new Informasi();
                $data['action'] = 'KelasController@simpanDataInformasi';
                $data['method'] = 'POST';
                $data['objek2'] = new Penugasan();
                $data['action2'] = 'KelasController@simpanPenugasan';
                $data['method2'] = 'POST';
                $data['objek3'] = new Quiz();
                $data['action3'] = 'KelasController@simpanQuizPilgan';
                $data['method3'] = 'POST';
                $data['objek4'] = new Quiz();
                $data['action4'] = 'KelasController@simpanQuizEssay';
                $data['method4'] = 'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                // Tutup penugasan, quiz otomatis saat sudah melewati batas
                $penugasan = $kelas->penugasan;
                foreach ($penugasan as $penugasan) {
                    if (Carbon::now()->timestamp > strtotime($penugasan->batas) ) {
                        $penugasan->status = "Tutup";
                        $penugasan->save();
                    }
                }
                // dd($penugasan);

                $quiz_pilgan = $kelas->quiz->where('tipe', 'Quiz Pilgan');
                foreach ($quiz_pilgan as $qp) {
                    if (Carbon::now()->timestamp > strtotime($qp->batas)) {
                        $qp->status = "Tutup";
                        $qp->save();
                    }
                }
                // dd($quiz_pilgan);

                $quiz_essay = $kelas->quiz->where('tipe', 'Quiz Essay');
                foreach ($quiz_essay as $qe) {
                    if (Carbon::now()->timestamp > strtotime($qe->batas)) {
                        $qe->status = "Tutup";
                        $qe->save();
                    }
                }
                // dd($quiz_essay);

                return view ('index-kelas-guru', $data);

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

    public function simpanDataInformasi(Request $request) {

        // Form Validation

        $rules = [
            'judul'         => 'required',
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // $info_ganda

        // Data Store

        $info = new Informasi();
        $info->kelas_id     = $request->kelas_id;
        $info->judul        = $request->judul;
        $info->isi          = $request->isi;
        $info->tipe         = 'Informasi';
        $info->save();

        if ($request->hasFile('nama_file')) {

            $files = $request->file('nama_file');

            foreach ($files as $files) {
                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-info', $filename);

                $fileInfo = new FileInfo();
                $fileInfo->info_id      = $info->id;
                $fileInfo->nama_file    = $path;
                $fileInfo->save();
            }
        }

        return back()->with('pesan', 'Selamat, Informasi Berhasil Dibuat.');

    }

    public function editInformasi($id) {

        if (\Auth::guard('guru')->check()) {

            $informasi = Informasi::findOrFail($id);
            $guru_id = $informasi->kelas->guru->id;
            
            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $informasi = Informasi::findOrFail($id);
                $data['kelas'] = $informasi->kelas;
                $data['objek'] = Informasi::findOrFail($id);
                $data['action'] = ['KelasController@updateInformasi', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('index-kelas-guru', $data);
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

    public function updateInformasi(Request $request, $id) {

        // Form Validation

        $rules = [
            'judul'         => 'required',
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'isi.required'          => 'Isi tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $info = Informasi::findOrFail($id);
        $info->kelas_id     = $request->kelas_id;
        $info->judul        = $request->judul;
        $info->isi          = $request->isi;
        $info->tipe         = 'Informasi';
        $info->save();

        if($request->hasFile('nama_file')) {

            $files = $request->file('nama_file');

            foreach ($files as $files => $value) {

                // Hapus dulu file lama dari storage
                $arr = FileInfo::where('info_id', $id)->get();
                $fileInfo = $arr[$files];
                \Storage::delete($fileInfo->nama_file);

                // Setelah itu simpan file yang baru
                $filename = $value->getClientOriginalName();
                $path = $value->storeAs('public/file-info', $filename);

                // Edit File Info berdasarkan index, (karena array)
                $arr = FileInfo::where('info_id', $id)->get();
                $fileInfo = $arr[$files];
                $fileInfo->info_id      = $info->id;
                $fileInfo->nama_file    = $path;
                $fileInfo->save();
            }

        }

        return redirect('guru/kelas/index/'.$info->kelas->id)->with('pesan', 'Selamat, Informasi Berhasil Di Update.');

    }

    public function hapusInformasi($id) {

        if (\Auth::guard('guru')->check()) {

            $informasi = Informasi::findOrFail($id);
            $guru_id = $informasi->kelas->guru->id;
            
            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $info = Informasi::findOrFail($id);

                // Hapus dulu file info dari storage dan database
                foreach ($info->fileInfo as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                // setelah itu hapus informasinya
                $info->delete();

                return back()->with('pesan', 'Selamat, Informasi Berhasil Di Hapus.');

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

    public function simpanPenugasan(Request $request) {

        // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // $penugasan_ganda

        // Data Store

        $penugasan = new Penugasan();
        $penugasan->kelas_id        = $request->kelas_id;
        $penugasan->judul           = $request->judul;
        $penugasan->deskripsi       = $request->deskripsi;
        $penugasan->status          = 'Buka';
        $penugasan->batas           = $request->batas;
        $penugasan->tipe            = 'Penugasan';
        $penugasan->save();

        if ($request->hasFile('nama_file')) {

            $files = $request->file('nama_file');

            foreach ($files as $files) {
                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-penugasan', $filename);

                $fileTugas = new FileTugas();
                $fileTugas->tugas_id      = $penugasan->id;
                $fileTugas->nama_file     = $path;
                $fileTugas->save();
            }
        }

        return back()->with('pesan', 'Selamat, Penugasan Berhasil Dibuat.');

    }

    public function editPenugasan($id) {
        if (\Auth::guard('guru')->check()) {
            
            $penugasan = Penugasan::findOrFail($id);
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                $penugasan = Penugasan::findOrFail($id);
                $data['kelas'] = $penugasan->kelas;
                $data['objek2'] = Penugasan::findOrFail($id);
                $data['action2'] = ['KelasController@updatePenugasan', $id];
                $data['method2'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('index-kelas-guru', $data);
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

    public function updatePenugasan(Request $request, $id) {
        
         // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'nama_file.*.mimes'     => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }
        
        // Data Update

        $penugasan = Penugasan::findOrFail($id);
        $penugasan->kelas_id        = $request->kelas_id;
        $penugasan->judul           = $request->judul;
        $penugasan->deskripsi       = $request->deskripsi;
        if ($penugasan->status == 'Buka') {
            $penugasan->status          = 'Buka';
        } else if ($penugasan->status == 'Tutup') {
            $penugasan->status          = 'Tutup';
        }
        $penugasan->batas           = $request->batas;
        $penugasan->tipe            = 'Penugasan';
        $penugasan->save();

        if ($request->hasFile('nama_file')) {

            $files = $request->file('nama_file');

            foreach ($files as $files => $value) {

                $arr = FileTugas::where('tugas_id', $id)->get();
                $fileTugas = $arr[$files];
                \Storage::delete($fileTugas->nama_file);

                $filename = $value->getClientOriginalName();
                $path = $value->storeAs('public/file-penugasan', $filename);

                $arr = FileTugas::where('tugas_id', $id)->get();
                $fileTugas = $arr[$files];
                $fileTugas->tugas_id      = $penugasan->id;
                $fileTugas->nama_file     = $path;
                $fileTugas->save();
            }
        }

        return redirect('guru/kelas/index/'.$penugasan->kelas->id)->with('pesan', 'Selamat, Penugasan Berhasil Diupdate.');

    }

    public function hapusPenugasan($id) {

        if (\Auth::guard('guru')->check()) {
            
            $penugasan = Penugasan::findOrFail($id);
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                
                $penugasan = Penugasan::findOrFail($id);

                foreach ($penugasan->fileTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }
        
                $penugasan->delete();
        
                return back()->with('pesan', 'Selamat, Penugasan Berhasil Dihapus.');
        

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

    public function bukaPenugasan($id) {

        if (\Auth::guard('guru')->check()) {
            
            $penugasan = Penugasan::findOrFail($id);
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                
                $now = Carbon::now();
                $limit = $now->addHour(24);

                $penugasan = Penugasan::findOrFail($id);
                $penugasan->status      = "Buka";
                $penugasan->batas       = $limit;
                $penugasan->save();

                return back()->with('pesan', 'Selamat, Penugasan Berhasil Dibuka.');

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

    public function simpanQuizPilgan(Request $request) {
        
         // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'time'          => 'required',
            'pertanyaan'    => 'required',
            'pilihan_1'     => 'required',
            'pilihan_2'     => 'required',
            'pilihan_3'     => 'required',
            'pilihan_4'     => 'required',
            'pilihan'       => 'required',
            'point'         => 'required'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'time.required'         => 'Time tidak boleh kosong.',
            'pertanyaan.required'   => 'Pertanyaan tidak boleh kosong.',
            'pilihan_1.required'    => 'Pilihan 1 tidak boleh kosong.',
            'pilihan_2.required'    => 'Pilihan 2 tidak boleh kosong.',
            'pilihan_3.required'    => 'Pilihan 3 tidak boleh kosong.',
            'pilihan_4.required'    => 'Pilihan 4 tidak boleh kosong.',
            'pilihan.required'      => 'Pilihan tidak boleh kosong.',
            'point.required'        => 'Point tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // $quiz_pilgan_ganda

        //Data Store

        $quiz = new Quiz();
        $quiz->kelas_id     = $request->kelas_id;
        $quiz->judul        = $request->judul;
        $quiz->deskripsi    = $request->deskripsi;
        $quiz->status       = 'Buka';
        $quiz->batas        = $request->batas;
        $quiz->tipe         = 'Quiz Pilgan';
        $quiz->time         = $request->time;
        $quiz->save();

        // Looping Untuk Soal

        $pertanyaan = $request->pertanyaan;

        foreach ($pertanyaan as $index => $value) {
            $quiz_pilgan = new QuizPilgan();
            $quiz_pilgan->quiz_id       = $quiz->id;
            $quiz_pilgan->pertanyaan    = $request->pertanyaan[$index];
            $quiz_pilgan->pilihan_1     = $request->pilihan_1[$index];
            $quiz_pilgan->pilihan_2     = $request->pilihan_2[$index];
            $quiz_pilgan->pilihan_3     = $request->pilihan_3[$index];
            $quiz_pilgan->pilihan_4     = $request->pilihan_4[$index];
            $quiz_pilgan->save();
    
            $jb = new JawabanBenar();
            $jb->quiz_pilgan_id         = $quiz_pilgan->id;
            $jb->pilihan                = $request->pilihan[$index];
            $jb->point                  = $request->point[$index];
            $jb->save();
        }
        

        return back()->with('pesan', 'Selamat, Quiz Pilgan Berhasil Dibuat.');
        

    }

    public function editQuizPilgan($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $quiz_pilgan = Quiz::findOrFail($id);
            $guru_id = $quiz_pilgan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                $quiz_pilgan = Quiz::findOrFail($id);
                $data['kelas'] = $quiz_pilgan->kelas;
                $data['objek3'] = Quiz::findOrFail($id);
                $data['action3'] = ['KelasController@updateQuizPilgan', $id];
                $data['method3'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('index-kelas-guru', $data);
                

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

    public function updateQuizPilgan(Request $request, $id) {
        
        // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'time'          => 'required',
            'pertanyaan'    => 'required',
            'pilihan_1'     => 'required',
            'pilihan_2'     => 'required',
            'pilihan_3'     => 'required',
            'pilihan_4'     => 'required',
            'pilihan'       => 'required',
            'point'         => 'required'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'time.required'         => 'Time tidak boleh kosong.',
            'pertanyaan.required'   => 'Pertanyaan tidak boleh kosong.',
            'pilihan_1.required'    => 'Pilihan 1 tidak boleh kosong.',
            'pilihan_2.required'    => 'Pilihan 2 tidak boleh kosong.',
            'pilihan_3.required'    => 'Pilihan 3 tidak boleh kosong.',
            'pilihan_4.required'    => 'Pilihan 4 tidak boleh kosong.',
            'pilihan.required'       => 'Pilihan tidak boleh kosong.',
            'point.required'        => 'Point tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $quiz = Quiz::findOrFail($id);
        $quiz->kelas_id     = $request->kelas_id;
        $quiz->judul        = $request->judul;
        $quiz->deskripsi    = $request->deskripsi;
        if ($quiz->status == 'Buka') {
            $quiz->status       = 'Buka';
        } else if ($quiz->status == 'Tutup') {
            $quiz->status       = 'Tutup';
        }
        $quiz->batas        = $request->batas;
        $quiz->tipe         = 'Quiz Pilgan';
        $quiz->time         = $request->time;
        $quiz->save();

        // Looping Untuk Soal

        $pertanyaan = $request->pertanyaan; //sama dengan jumlah QuizPilgan::where('quiz_id', $id)->get();

        foreach ($pertanyaan as $index => $value) {
            $arr = QuizPilgan::where('quiz_id', $id)->get();
            $quiz_pilgan = $arr[$index];
            $quiz_pilgan->quiz_id       = $quiz->id;
            $quiz_pilgan->pertanyaan    = $request->pertanyaan[$index];
            $quiz_pilgan->pilihan_1     = $request->pilihan_1[$index];
            $quiz_pilgan->pilihan_2     = $request->pilihan_2[$index];
            $quiz_pilgan->pilihan_3     = $request->pilihan_3[$index];
            $quiz_pilgan->pilihan_4     = $request->pilihan_4[$index];
            $quiz_pilgan->save();
    
            $jb = JawabanBenar::where('quiz_pilgan_id', $quiz_pilgan->id)->first();
            $jb->quiz_pilgan_id         = $quiz_pilgan->id;
            $jb->pilihan                = $request->pilihan[$index];
            $jb->point                  = $request->point[$index];
            $jb->save();
        }
        

        return redirect('guru/kelas/index/'.$quiz->kelas->id)->with('pesan', 'Selamat, Quiz Pilgan Berhasil Diupdate.');

    }

    public function hapusQuizPilgan($id) {
        
        
        if (\Auth::guard('guru')->check()) {
            
            $quiz_pilgan = Quiz::findOrFail($id);
            $guru_id = $quiz_pilgan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                        
                $quiz = Quiz::findOrFail($id);

                foreach ($quiz->quizPilgan as $qp) {
                    $jb = $qp->jawabanBenar;
                    $jb->delete();
                    $qp->delete();
                }

                $quiz->delete();

                return back()->with('pesan', 'Selamat, Quiz Pilgan Berhasil Dihapus.');


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

    public function bukaQuizPilgan($id) {

        if (\Auth::guard('guru')->check()) {
            
            $quiz_pilgan = Quiz::findOrFail($id);
            $guru_id = $quiz_pilgan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                
                $now = Carbon::now();
                $limit = $now->addHour(24);

                $quiz_pilgan = Quiz::findOrFail($id);
                $quiz_pilgan->status        = "Buka";
                $quiz_pilgan->batas         = $limit;
                $quiz_pilgan->save();

                return back()->with('pesan', 'Selamat, Quiz Pilgan Berhasil Dibuka.');
                

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

    public function simpanQuizEssay(Request $request) {
        
        // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'time'          => 'required',
            'pertanyaan'    => 'required',
            'point'         => 'required'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'time.required'         => 'Time tidak boleh kosong.',
            'pertanyaan.required'   => 'Pertanyaan tidak boleh kosong.',
            'point.required'        => 'Point tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // $quiz_essay_ganda

        // Data Store
        
        $quiz = new Quiz();
        $quiz->kelas_id     = $request->kelas_id;
        $quiz->judul        = $request->judul;
        $quiz->deskripsi    = $request->deskripsi;
        $quiz->status       = 'Buka';
        $quiz->batas        = $request->batas;
        $quiz->tipe         = 'Quiz Essay';
        $quiz->time         = $request->time;
        $quiz->save();

        // looping untuk soal

        $pertanyaan = $request->pertanyaan;

        foreach ($pertanyaan as $index => $value) {

            $quiz_essay = new QuizEssay();
            $quiz_essay->quiz_id        = $quiz->id;
            $quiz_essay->pertanyaan     = $request->pertanyaan[$index];
            $quiz_essay->point          = $request->point[$index];
            $quiz_essay->save();
        }

        return back()->with('pesan', 'Selamat, Quiz Essay Berhasil Dibuat.');
        
    }

    public function editQuizEssay($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $quiz_essay = Quiz::findOrFail($id);
            $guru_id = $quiz_essay->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                $quiz_essay = Quiz::findOrFail($id);
                $data['kelas'] = $quiz_essay->kelas;
                $data['objek4'] = Quiz::findOrFail($id);
                $data['action4'] = ['KelasController@updateQuizEssay', $id];
                $data['method4'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('index-kelas-guru', $data);

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

    public function updateQuizEssay(Request $request, $id) {
        
         // Form Validation

        $rules = [
            'judul'         => 'required',
            'deskripsi'     => 'required',
            'batas'         => 'required',
            'time'          => 'required',
            'pertanyaan'    => 'required',
            'point'         => 'required'
        ];

        $messages = [
            'judul.required'        => 'Judul tidak boleh kosong.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'batas.required'        => 'Batas tidak boleh kosong.',
            'time.required'         => 'Time tidak boleh kosong.',
            'pertanyaan.required'   => 'Pertanyaan tidak boleh kosong.',
            'point.required'        => 'Point tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update
        
        $quiz = Quiz::findOrFail($id);
        $quiz->kelas_id     = $request->kelas_id;
        $quiz->judul        = $request->judul;
        $quiz->deskripsi    = $request->deskripsi;
        if ($quiz->status == 'Buka') {
            $quiz->status       = 'Buka';
        } else if ($quiz->status == 'Tutup') {
            $quiz->status       = 'Tutup';
        }
        $quiz->batas        = $request->batas;
        $quiz->tipe         = 'Quiz Essay';
        $quiz->time         = $request->time;
        $quiz->save();

        // looping untuk soal

        $pertanyaan = $request->pertanyaan; //sama dengan jumlah QuizEssay::where('quiz_id', $id)->get();

        foreach ($pertanyaan as $index => $value) {
            $arr = QuizEssay::where('quiz_id', $id)->get();
            $quiz_essay = $arr[$index];
            $quiz_essay->quiz_id        = $quiz->id;
            $quiz_essay->pertanyaan     = $request->pertanyaan[$index];
            $quiz_essay->point          = $request->point[$index];
            $quiz_essay->save();
        }

        return redirect('guru/kelas/index/'.$quiz->kelas->id)->with('pesan', 'Selamat, Quiz Essay Berhasil Diupdate.');

    }

    public function hapusQuizEssay($id) {

        if (\Auth::guard('guru')->check()) {
            
            $quiz_essay = Quiz::findOrFail($id);
            $guru_id = $quiz_essay->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
            
                $quiz = Quiz::findOrFail($id);

                foreach ($quiz->quizEssay as $qe) {
                    $qe->delete();
                }
                
                $quiz->delete();

                return back()->with('pesan', 'Selamat, Quiz Essay Berhasil Dihapus.');

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

    public function bukaQuizEssay($id) {

        if (\Auth::guard('guru')->check()) {
            
            $quiz_essay = Quiz::findOrFail($id);
            $guru_id = $quiz_essay->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id ) {
                
                $now = Carbon::now();
                $limit = $now->addHour(24);

                $quiz_essay = Quiz::findOrFail($id);
                $quiz_essay->status        = "Buka";
                $quiz_essay->batas         = $limit;
                $quiz_essay->save();

                return back()->with('pesan', 'Selamat, Quiz Essay Berhasil Dibuka.');
                

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

    public function detailPenugasan($id) {
        if (\Auth::guard('guru')->check()) {

            $penugasan = Penugasan::where('id', $id)->first();
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $penugasan = Penugasan::where('id', $id)->first();
                $data['penugasan'] =  Penugasan::where('id', $id)->first();
                $data['komen_guru'] = KomenTugas::where('tugas_id', $id)->where('guru_id', \Auth::guard('guru')->user()->id)->latest()->get();
                $data['komen_siswa'] = KomenTugas::where('tugas_id', $id)->where('guru_id', 0)->latest()->get();
                $data['kelas'] = $penugasan->kelas;
                $data['objek'] = new KomenTugas();
                $data['action'] = 'KelasController@simpanKomentarTugas';
                $data['method'] = 'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-penugasan', $data);
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

    public function simpanKomentarTugas(Request $request) {

        // Form Validation

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'      => 'Isi tidak boleh kosong.',
            'nama_file.*'       => 'Format file tidak didukung.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Menghapus komen yang sama agar tidak menumpuk

        $komen_ganda = KomenTugas::where('tugas_id', $request->tugas_id)->where('guru_id', \Auth::guard('guru')->user()->id)->where('isi', $request->isi)->first();

        if ($komen_ganda != '') {
            foreach ($komen_ganda->fileKomenTugas as $files) {
                \Storage::delete($files->nama_file);
                $files->delete();
            }
            $komen_ganda->delete();
        }

        // Data Store

        $komenTugas = new KomenTugas();
        $komenTugas->tugas_id   = $request->tugas_id;
        $komenTugas->guru_id    = \Auth::guard('guru')->user()->id;
        $komenTugas->siswa_id   = 0;
        $komenTugas->isi        = $request->isi;
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
        
        if (\Auth::guard('guru')->check()) {

            $komenTugas = KomenTugas::findorFail($id);
            $guru_id = $komenTugas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komenTugas = KomenTugas::findOrFail($id);
                $data['penugasan'] =  $komenTugas->penugasan;
                $data['kelas'] = $komenTugas->penugasan->kelas;
                $data['objek'] = KomenTugas::findOrFail($id);
                $data['action'] = ['KelasController@updateKomentarTugas', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-penugasan', $data);
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

    public function updateKomentarTugas(Request $request, $id) {
        
        // Form Validation

        $rules = [
            'isi'           => 'required',
            'nama_file'     => 'nullable',
            'nama_file.*'   => 'mimes:jpg,jpeg,png,mp3,mp4,mkv,docx,xlsx,pptx,pdf,txt,exe'
        ];

        $messages = [
            'isi.required'      => 'Isi tidak boleh kosong.',
            'nama_file.*'       => 'Format file tidak didukung'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }


        // Data Update

        $komenTugas = KomenTugas::findOrFail($id);
        $komenTugas->tugas_id   = $request->tugas_id;
        $komenTugas->guru_id    = \Auth::guard('guru')->user()->id;
        $komenTugas->siswa_id   = 0;
        $komenTugas->isi        = $request->isi;
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

        return redirect('guru/kelas/penugasan/'.$komenTugas->penugasan->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');

    }

    public function hapusKomentarTugas($id) {

        if (\Auth::guard('guru')->check()) {

            $komenTugas = KomenTugas::findorFail($id);
            $guru_id = $komenTugas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $komenTugas = KomenTugas::findOrFail($id);

                foreach ($komenTugas->fileKomenTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komenTugas->delete();
        
                return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dihapus.');

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

    public function hapusKomentarTugasSiswa($id) {

        if (\Auth::guard('guru')->check()) {

            $komen_tugas_siswa = KomenTugas::findorFail($id);
            $penugasan = $komen_tugas_siswa->penugasan;
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komen_tugas_siswa = KomenTugas::findorFail($id);

                foreach ($komen_tugas_siswa->fileKomenTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komen_tugas_siswa->delete();

                return back()->with('pesan', 'Selamat, Komentar Siswa Berhasil Dihapus.');
                
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

    public function detailHasilTugas($id) {
        if (\Auth::guard('guru')->check()) {

            $prosesTugas = ProsesTugas::where('id', $id)->first();
            $penugasan = $prosesTugas->penugasan;
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $prosesTugas = ProsesTugas::where('id', $id)->first();
                $data['kelas'] = $prosesTugas->penugasan->kelas;
                $data['proses_tugas'] = ProsesTugas::where('id', $id)->first();
                $data['objek'] = new HasilTugas();
                $data['action'] = 'KelasController@simpanPenilaianTugas';
                $data['method'] = 'POST';
                $data['objek2'] = new KomenHasilTugas();
                $data['action2'] = 'KelasController@simpanKomenHasilTugas';
                $data['method2'] = 'POST';
                if ($prosesTugas->hasilTugas != '') {
                    $hasilTugas = $prosesTugas->hasilTugas;
                    $data['komen_guru'] = KomenHasilTugas::where('hasil_tugas_id', $hasilTugas->id)->where('guru_id', \Auth::guard('guru')->user()->id)->latest()->get();
                    $data['komen_siswa'] = KomenHasilTugas::where('hasil_tugas_id', $hasilTugas->id)->where('guru_id', 0)->latest()->get();
                }
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-penilaian-tugas', $data);

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

    public function simpanPenilaianTugas(Request $request) {
        
        // Form Validation

        $rules = [
            'nilai'         => 'required|max:3'
        ];

        $messages = [
            'nilai.required'    => 'Nilai tidak boleh kosong.',
            'nilai.max'         => 'Nilai tidak boleh lebih dari 3 digit angka.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $hasil_ganda = HasilTugas::where('proses_tugas_id', $request->proses_tugas_id)->where('nilai', $request->nilai)->first();

        if ($hasil_ganda != '') {
            $hasil_ganda->delete();
        }

        // Data Store

        $hasilTugas = new HasilTugas();
        $hasilTugas->proses_tugas_id    = $request->proses_tugas_id;
        $hasilTugas->nilai              = $request->nilai;
        $hasilTugas->save();

        return back()->with('pesan', 'Selamat, Penilaian Selesai.');

    }

    public function editPenilaianTugas($id) {

        if (\Auth::guard('guru')->check()) {

            $hasilTugas = HasilTugas::findOrFail($id);
            $prosesTugas = $hasilTugas->prosesTugas;
            $penugasan = $prosesTugas->penugasan;
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $hasilTugas = HasilTugas::findOrFail($id);
                $prosesTugas = $hasilTugas->prosesTugas;
                $data['kelas'] = $prosesTugas->penugasan->kelas;
                $data['proses_tugas'] = $hasilTugas->prosesTugas;
                $data['objek'] = HasilTugas::findOrFail($id);
                $data['action'] = ['KelasController@updatePenilaianTugas', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-penilaian-tugas', $data);

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

    public function updatePenilaianTugas(Request $request, $id) {
        
        // Form Validation

        $rules = [
            'nilai'         => 'required|max:3'
        ];

        $messages = [
            'nilai.required'    => 'Nilai tidak boleh kosong.',
            'nilai.max'         => 'Nilai tidak boleh lebih dari 3 digit angka.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $hasilTugas = HasilTugas::findOrFail($id);
        $hasilTugas->proses_tugas_id    = $request->proses_tugas_id;
        $hasilTugas->nilai              = $request->nilai;
        $hasilTugas->save();

        return redirect('guru/kelas/hasil-tugas/'.$hasilTugas->prosesTugas->id)->with('pesan', 'Selamat, Nilai Berhasil Diupdate.');
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

        $komen_ganda = KomenHasilTugas::where('hasil_tugas_id', $request->hasil_tugas_id)->where('guru_id', \Auth::guard('guru')->user()->id)->where('isi', $request->isi)->first();

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
        $komenHasilTugas->guru_id               = \Auth::guard('guru')->user()->id;
        $komenHasilTugas->siswa_id              = 0;
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
        
        if (\Auth::guard('guru')->check()) {

            $komenHasilTugas = KomenHasilTugas::findOrFail($id);
            $guru_id = $komenHasilTugas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komenHasilTugas = KomenHasilTugas::findOrFail($id);
                $hasilTugas = $komenHasilTugas->hasilTugas;
                $prosesTugas = $hasilTugas->prosesTugas;
                $data['kelas'] = $prosesTugas->penugasan->kelas;
                $data['proses_tugas'] = $hasilTugas->prosesTugas;
                $data['hasil_tugas'] = $komenHasilTugas->hasilTugas;
                $data['objek2'] = KomenHasilTugas::findOrFail($id);
                $data['action2'] = ['KelasController@updateKomenHasilTugas', $id];
                $data['method2'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-penilaian-tugas', $data);

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
        $komenHasilTugas->guru_id               = \Auth::guard('guru')->user()->id;
        $komenHasilTugas->siswa_id              = 0;
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

        return redirect('guru/kelas/hasil-tugas/'.$komenHasilTugas->hasilTugas->prosesTugas->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');

    }

    public function hapusKomenHasilTugas($id) {
        if (\Auth::guard('guru')->check()) {

            $komenHasilTugas = KomenHasilTugas::findOrFail($id);
            $guru_id = $komenHasilTugas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komenHasilTugas = KomenHasilTugas::findOrFail($id);
                
                foreach ($komenHasilTugas->fileKomenHasilTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komenHasilTugas->delete();

                return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dihapus.');

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

    public function hapusKomenHasilTugasSiswa($id) {
        if (\Auth::guard('guru')->check()) {

            $komenHasilTugasSiswa = KomenHasilTugas::findOrFail($id);
            $hasilTugas = $komenHasilTugasSiswa->hasilTugas;
            $prosesTugas = $hasilTugas->prosesTugas;
            $penugasan = $prosesTugas->penugasan;
            $guru_id = $penugasan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komenHasilTugasSiswa = KomenHasilTugas::findOrFail($id);
                
                foreach ($komenHasilTugasSiswa->fileKomenHasilTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komenHasilTugasSiswa->delete();

                return back()->with('pesan', 'Selamat, Komentar Siswa Berhasil Dihapus.');

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

    public function detailInformasi($id) {
        if (\Auth::guard('guru')->check()) {

            $info = Informasi::where('id', $id)->first();
            $guru_id = $info->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $info = Informasi::where('id', $id)->first();
                $data['komen_guru'] = KomenInfo::where('info_id', $id)->where('guru_id', \Auth::guard('guru')->user()->id)->latest()->get();
                $data['komen_siswa'] = KomenInfo::where('info_id', $id)->where('guru_id', 0)->latest()->get();
                $data['info'] = Informasi::where('id', $id)->first();
                $data['kelas'] = $info->kelas;
                $data['objek'] =  new KomenInfo();
                $data['action'] =  'KelasController@simpanKomentarInfo';
                $data['method'] =  'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-informasi', $data);

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

        // Menghapus komen info yang sama agar tidak menumpuk

        $komen_ganda = KomenInfo::where('info_id', $request->info_id)->where('guru_id', \Auth::guard('guru')->user()->id)->where('isi', $request->isi)->first();

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
        $komenInfo->guru_id         = \Auth::guard('guru')->user()->id;
        $komenInfo->siswa_id        = 0;
        $komenInfo->isi             = $request->isi;
        $komenInfo->save();

        if ($request->hasFile('nama_file')) {

            $files = $request->file('nama_file');

            foreach ($files as $files) {

                $filename = $files->getClientOriginalName();
                $path = $files->storeAs('public/file-komentar-info', $filename);

                $fileKomenInfo = new FileKomenInfo();
                $fileKomenInfo->komen_info_id  = $komenInfo->id;
                $fileKomenInfo->nama_file      = $path;
                $fileKomenInfo->save();
            }
        }

        return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dibuat.');
    }

    public function editKomentarInfo($id) {
        
        if (\Auth::guard('guru')->check()) {

            $komenInfo = KomenInfo::findOrFail($id);
            $guru_id = $komenInfo->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $komenInfo = KomenInfo::findOrFail($id);
                $data['info'] = $komenInfo->informasi;
                $data['kelas'] = $komenInfo->informasi->kelas;
                $data['objek'] =  KomenInfo::findOrFail($id);
                $data['action'] =  ['KelasController@updateKomentarInfo', $id];
                $data['method'] =  'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-informasi', $data);

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
        $komenInfo->guru_id         = \Auth::guard('guru')->user()->id;
        $komenInfo->siswa_id        = 0;
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
                $fileKomenInfo->komen_info_id  = $komenInfo->id;
                $fileKomenInfo->nama_file      = $path;
                $fileKomenInfo->save();
            }
        }

        return redirect('guru/kelas/informasi/'.$komenInfo->informasi->id)->with('pesan', 'Selamat, Komentar Anda Berhasil Diupdate.');

    }

    public function hapusKomentarInfo($id) {
        
        if (\Auth::guard('guru')->check()) {

            $komenInfo = KomenInfo::findOrFail($id);
            $guru_id = $komenInfo->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {

                $komenInfo = KomenInfo::findOrFail($id);

                foreach ($komenInfo->fileKomenInfo as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komenInfo->delete();

                return back()->with('pesan', 'Selamat, Komentar Anda Berhasil Dihapus.');

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

    public function hapusKomentarInfoSiswa($id) {

        if (\Auth::guard('guru')->check()) {

            $komen_info_siswa = KomenInfo::findorFail($id);
            $informasi = $komen_info_siswa->informasi;
            $guru_id = $informasi->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $komen_info_siswa = KomenInfo::findorFail($id);

                foreach ($komen_info_siswa->fileKomenInfo as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                $komen_info_siswa->delete();

                return back()->with('pesan', 'Selamat, Komentar Siswa Berhasil Dihapus.');
                
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

    public function detailQuizPilgan($id) {

        if (\Auth::guard('guru')->check()) {

            $quiz_pilgan = Quiz::where('id', $id)->first();
            $guru_id = $quiz_pilgan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $quiz_pilgan = Quiz::where('id', $id)->first();
                $data['kelas'] = $quiz_pilgan->kelas;
                $data['quiz'] = Quiz::where('id', $id)->first();

                foreach ($quiz_pilgan->quizPilgan as $index => $qp) {
                    if ($index == 0) {
                        $proses_quiz_pilgan = $qp->prosesQuizPilgan;
                        $data['proses'] = $proses_quiz_pilgan;
                    }
                }

                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-quiz-pilgan', $data);

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

    public function detailHasilQuizPilgan($id) {

        if (\Auth::guard('guru')->check()) {

            $proses_quiz_pilgan = ProsesQuizPilgan::where('id', $id)->first();
            $quiz_pilgan = $proses_quiz_pilgan->quizPilgan;
            $quiz = $quiz_pilgan->quiz;
            $guru_id = $quiz->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $proses_quiz_pilgan = ProsesQuizPilgan::where('id', $id)->first();
                $quiz_pilgan = $proses_quiz_pilgan->quizPilgan;
                $quiz = $quiz_pilgan->quiz;
                $data['kelas'] = $quiz->kelas;
                $data['proses'] = ProsesQuizPilgan::where('id', $id)->first();
                $data['quiz'] = $quiz_pilgan->quiz;
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-hasil-quiz-pilgan', $data);

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

    public function detailQuizEssay($id) {

        if (\Auth::guard('guru')->check()) {

            $quiz_essay = Quiz::where('id', $id)->first();
            $guru_id = $quiz_essay->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $quiz_essay = Quiz::where('id', $id)->first();
                $data['kelas'] = $quiz_essay->kelas;
                $data['quiz'] = Quiz::where('id', $id)->first();

                // Untuk Menampilkan Data Siswa Yang Telah Mengerjakan Quiz Essay
                foreach ($quiz_essay->quizEssay as $index => $qe) {
                    if ($index == 0) {
                        $proses_quiz_essay = $qe->prosesQuizEssay;
                        $data['proses'] = $proses_quiz_essay;
                    }
                }

                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-quiz-essay', $data);

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

    public function detailHasilQuizEssay($id) {
        
        if (\Auth::guard('guru')->check()) {

            $proses_quiz_essay = ProsesQuizEssay::where('id', $id)->first();
            $quiz_essay = $proses_quiz_essay->quizEssay;
            $quiz = $quiz_essay->quiz;
            $guru_id = $quiz->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $proses_quiz_essay = ProsesQuizEssay::where('id', $id)->first();
                $quiz_essay = $proses_quiz_essay->quizEssay;
                $quiz = $quiz_essay->quiz;
                $data['kelas'] = $quiz->kelas;
                $data['proses'] = ProsesQuizEssay::where('id', $id)->first();
                $data['quiz'] = $quiz_essay->quiz;
                $data['objek'] = new HasilQuizEssay();
                $data['action'] = ['KelasController@simpanPenilaianQuizEssay', $id];
                $data['method'] = 'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-penilaian-quiz-essay', $data);

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

    public function simpanPenilaianQuizEssay(Request $request, $id) {
        
        // Form Validation

        $request->validate(
            [
                'nilai'     => 'nullable'
            ]
        );

        $hasil_ganda = HasilQuizEssay::where('proses_quiz_essay_id', $request->proses_quiz_essay_id)->first();
        if ($hasil_ganda != '') {
            $hasil_ganda->delete();
        }

        
         // Data Store

        // Untuk mendapatkan total nilai quiz essay

        $total = 0;
        $jumlah_soal = count($request->nilai);

        // jike nilai kosong, maka totalnya = 0;
        foreach ($request->nilai as $nilai) {
            // $total += $nilai;
            if ($nilai != '') {
                $true = 1;
                $total += $true;
            }
        }

        // Untuk mengupdate nilai proses quiz essay siswa

        $proses_quiz_essay = ProsesQuizEssay::where('id', $id)->first();
        $quiz = $proses_quiz_essay->quizEssay->quiz;

        foreach ($quiz->quizEssay as $index => $qe) {
            $pQe = $qe->prosesQuizEssay->where('siswa_id', $proses_quiz_essay->siswa->id)->first();
            if ($request->nilai[$index] != '') {
                $pQe->nilai = $request->nilai[$index];
            } else {
                $pQe->nilai = 0;
            }
            $pQe->save();
        }
        
        
        // Untuk menyimpan hasil quiz essay siswa

        $hasilQuizEssay = new HasilQuizEssay();
        $hasilQuizEssay->proses_quiz_essay_id   = $request->proses_quiz_essay_id;
        $hasilQuizEssay->nilai_total            = round((100 / $jumlah_soal) * $total);
        $hasilQuizEssay->save();

        return back()->with('pesan', 'Selamat, Penilaian Selesai.');

    }

    public function editPenilaianQuizEssay($id) {
        
        if (\Auth::guard('guru')->check()) {

            $hasil_quiz_essay = HasilQuizEssay::findOrFail($id);
            $proses_quiz_essay = $hasil_quiz_essay->prosesQuizEssay;
            $quiz_essay = $proses_quiz_essay->quizEssay;
            $quiz = $quiz_essay->quiz;
            $guru_id = $quiz->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $hasil_quiz_essay = HasilQuizEssay::findOrFail($id);
                $proses_quiz_essay = $hasil_quiz_essay->prosesQuizEssay;
                $quiz_essay = $proses_quiz_essay->quizEssay;
                $quiz = $quiz_essay->quiz;
                $data['kelas'] = $quiz->kelas;
                $data['proses'] = $hasil_quiz_essay->prosesQuizEssay;
                $data['quiz'] = $quiz_essay->quiz;
                $data['objek'] = HasilQuizEssay::findOrFail($id);
                $data['action'] = ['KelasController@updatePenilaianQuizEssay', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-penilaian-quiz-essay', $data);

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

    public function updatePenilaianQuizEssay(Request $request, $id) {
        
        // Form Validation

        $request->validate(
            [
                'nilai'     => 'nullable'
            ]
        );

         // Data Update

        // Untuk mendapatkan total nilai quiz essay

        $total = 0;
        $jumlah_soal = count($request->nilai);

        // jike nilai kosong, maka totalnya = 0;
        foreach ($request->nilai as $nilai) {
            // $total += $nilai;
            if ($nilai != '' && $nilai != 0) {
                $true = 1;
                $total += $true;
            }
        }

        // Untuk mengupdate nilai proses quiz essay siswa

        $hasil_quiz_essay = HasilQuizEssay::findOrFail($id);
        $proses_quiz_essay = $hasil_quiz_essay->prosesQuizEssay;
        $quiz = $proses_quiz_essay->quizEssay->quiz;

        foreach ($quiz->quizEssay as $index => $qe) {
            $pQe = $qe->prosesQuizEssay->where('siswa_id', $proses_quiz_essay->siswa->id)->first();
            if ($request->nilai[$index] != '') {
                $pQe->nilai = $request->nilai[$index];
            } else {
                $pQe->nilai = 0;
            }
            $pQe->save();
        }
        
        
        // Untuk mengupdate hasil quiz essay siswa

        $hasilQuizEssay = HasilQuizEssay::findOrFail($id);
        $hasilQuizEssay->proses_quiz_essay_id   = $request->proses_quiz_essay_id;
        $hasilQuizEssay->nilai_total            = round((100 / $jumlah_soal) * $total);
        $hasilQuizEssay->save();

        return redirect('guru/kelas/hasil-quiz-essay/'.$proses_quiz_essay->id)->with('pesan', 'Selamat, Nilai Berhasil Diupdate.');

    }



    public function kehadiran($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $kelas = Kelas::where('id', $id)->first();
            $guru_id = $kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $kelas = Kelas::where('id', $id)->first();
                $data['kelas'] = Kelas::where('id', $id)->first();
                $data['objek'] = new Pertemuan();
                $data['action'] = 'KelasController@simpanPertemuan';
                $data['method'] = 'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                // Tutup pertemuan otomatis saat sudah melewati batas
                $pertemuan = $kelas->pertemuan;
                foreach ($pertemuan as $pertemuan) {
                    if (Carbon::now()->timestamp > strtotime($pertemuan->batas) ) {
                        $pertemuan->status = "Tutup";
                        $pertemuan->save();
                    }
                }
                // dd($pertemuan);

                return view('guru-kehadiran', $data);

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

    public function simpanPertemuan(Request $request) {

        // Form Validation

        $rules = [
            'deskripsi'         => 'required',
            'tanggal'           => 'required',
            'batas'             => 'required'
        ];

        $messages = [
            'deskripsi.required'        => 'Deskripsi tidak boleh kosong.',
            'tanggal.required'          => 'Tanggal tidak boleh kosong.',
            'batas.required'            => 'Batas tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $pertemuan_ganda = Pertemuan::where('kelas_id', $request->kelas_id)->where('deskripsi', $request->deskripsi)->where('tanggal', $request->tanggal)->where('batas', $request->batas)->first();

        if ($pertemuan_ganda != '') {
            $pertemuan_ganda->delete();
        }

        // Data Store

        $pertemuan = new Pertemuan();
        $pertemuan->kelas_id    = $request->kelas_id;
        $pertemuan->deskripsi   = $request->deskripsi;
        $pertemuan->status      = 'Buka';
        $pertemuan->tanggal     = $request->tanggal;
        $pertemuan->batas       = $request->batas;
        $pertemuan->save();

        return back()->with('pesan', 'Selamat, Pertemuan Berhasil Dibuat.');
    }

    public function bukaPertemuan($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $pertemuan = Pertemuan::findOrFail($id);
            $guru_id = $pertemuan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                if (Carbon::now()->timestamp > strtotime($pertemuan->batas) ) {
                    $now = Carbon::now();
                    $limit = $now->addHour(24);

                    $pertemuan = Pertemuan::findOrFail($id);
                    $pertemuan->status      = 'Buka';
                    $pertemuan->batas       = $limit;
                    $pertemuan->save();
                } elseif (Carbon::now()->timestamp < strtotime($pertemuan->batas) ) {
                    $pertemuan = Pertemuan::findOrFail($id);
                    $pertemuan->status      = 'Buka';
                    $pertemuan->save();
                }

                return back()->with('pesan', 'Pertemuan Dibuka.');

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

    public function tutupPertemuan($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $pertemuan = Pertemuan::findOrFail($id);
            $guru_id = $pertemuan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $pertemuan = Pertemuan::findOrFail($id);
                $pertemuan->status = 'Tutup';
                $pertemuan->save();

                return back()->with('pesan', 'Pertemuan Ditutup.');

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

    public function editPertemuan($id) {

        if (\Auth::guard('guru')->check()) {
            
            $pertemuan = Pertemuan::findOrFail($id);
            $guru_id = $pertemuan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $pertemuan = Pertemuan::findOrFail($id);
                $data['kelas'] = $pertemuan->kelas;
                $data['objek'] = Pertemuan::findOrFail($id);
                $data['action'] = ['KelasController@updatePertemuan', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-kehadiran', $data);

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

    public function updatePertemuan(Request $request, $id) {

        // Form Validation

        $rules = [
            'deskripsi'         => 'required',
            'tanggal'           => 'required',
            'batas'             => 'required'
        ];

        $messages = [
            'deskripsi.required'        => 'Deskripsi tidak boleh kosong.',
            'tanggal.required'          => 'Tanggal tidak boleh kosong.',
            'batas.required'            => 'Batas tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $pertemuan = Pertemuan::findOrFail($id);
        $pertemuan->kelas_id    = $request->kelas_id;
        $pertemuan->deskripsi   = $request->deskripsi;
        if ($pertemuan->status == 'Buka') {
            $pertemuan->status      = 'Buka';
        } else if ($pertemuan->status == 'Tutup') {
            $pertemuan->status      = 'Tutup';
        }
        $pertemuan->tanggal     = $request->tanggal;
        $pertemuan->batas       = $request->batas;
        $pertemuan->save();

        return redirect('guru/kelas/kehadiran/'.$pertemuan->kelas->id)->with('pesan', 'Selamat, Pertemuan Berhasil Diupdate.');

    }

    public function hapusPertemuan($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $pertemuan = Pertemuan::findOrFail($id);
            $guru_id = $pertemuan->kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $pertemuan = Pertemuan::findOrFail($id);
                $pertemuan->delete();

                return back()->with('pesan', 'Selamat, Pertemuan Berhasil Dihapus.');

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

    public function editKehadiranSiswa($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $kehadiran = Kehadiran::findOrFail($id);
            $kelas = $kehadiran->pertemuan->kelas;
            $guru_id = $kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $kehadiran = Kehadiran::findOrFail($id);
                $kelas = $kehadiran->pertemuan->kelas;
                $data['kelas'] =  $kelas;
                $data['objek'] = Kehadiran::findOrFail($id);
                $data['action'] = ['KelasController@updateKehadiranSiswa', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-kehadiran', $data);

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

    public function updateKehadiranSiswa(Request $request, $id) {

        // Form Validation

        $rules = [
            'point'     => 'required'
        ];

        $messages = [
            'point.required'        => 'Point tidak boleh kosong.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->pertemuan_id        = $request->pertemuan_id;
        $kehadiran->keterangan          = $request->keterangan;
        $kehadiran->point               = $request->point;
        $kehadiran->save();

        return redirect('guru/kelas/kehadiran/'.$kehadiran->pertemuan->kelas->id)->with('pesan', 'Selamat, Data Kehadiran Siswa Telah Diupdate.');
    }

    public function anggota($id) {
        if (\Auth::guard('guru')->check()) {
            
            $kelas = Kelas::where('id', $id)->first();
            $guru_id = $kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $data['kelas'] = Kelas::where('id', $id)->first();
                $data['guru'] = Anggota::where('kelas_id', $id)->where('guru_id', \Auth::guard('guru')->user()->id)->first();
                $data['siswa'] = Anggota::where('kelas_id', $id)->where('guru_id', 0)->get();
                $data['objek'] = new Anggota();
                $data['action'] = 'KelasController@tambahAnggota';
                $data['method'] = 'POST';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-anggota-kelas', $data);

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

    public function tambahAnggota(Request $request) {
        
        // Form Validation

        $rules = [
            'email'      => 'required|email'
        ];

        $messages = [
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email salah.'
        ];

        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        $siswa = Siswa::where('email', $request->email)->first();

        if ($siswa == '') {
            return back()->with('pesan2', 'Siswa Tidak Ditemukan.');
        }

        $anggota_ganda = Anggota::where('kelas_id', $request->kelas_id)->where('siswa_id', $siswa->id)->first();
        if ($anggota_ganda != '') {
            $anggota_ganda->delete();
        }

        // Data Store

        $anggota = new Anggota();
        $anggota->kelas_id      = $request->kelas_id;
        $anggota->guru_id       = 0;
        $anggota->siswa_id      = $siswa->id;
        $anggota->save();

        return back()->with('pesan', 'Selamat, Anggota Kelas Berhasil Ditambahkan.');


    }

    public function hapusAnggota($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $anggota = Anggota::findOrFail($id);
            $kelas = $anggota->kelas;
            $guru_id = $kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                
                $anggota = Anggota::findOrFail($id);

                $siswa = $anggota->siswa;

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

                $anggota->delete();

                return back()->with('pesan', 'Selamat, Anggota Kelas Berhasil Dihapus.');


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

    public function detailKelas($id) {
        
        if (\Auth::guard('guru')->check()) {
            
            $kelas = Kelas::where('id', $id)->first();
            $guru_id = $kelas->guru->id;

            if (\Auth::guard('guru')->user()->id == $guru_id) {
                $data['kelas'] = Kelas::where('id', $id)->first();
                $data['objek'] = Kelas::findOrFail($id);
                $data['action'] = ['KelasController@updateKelas', $id];
                $data['method'] = 'PUT';
                $id = \Auth::guard('guru')->user()->id; // id guru
                
                $data['objek_profil'] = Guru::findOrFail($id);
                $data['action_profil'] = ['GuruController@updateProfil', $id];
                $data['method_profil'] = 'PUT';

                return view('guru-detail-kelas', $data);
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

    public function updateKelas(Request $request, $id) {

        // Form Validation

        $rules = [
            'nama_kelas'    => 'required|max:70',
            'deskripsi'     => 'required',
            'kode_kelas'    => 'required|min:6|max:6'
        ];

        $messages = [
            'nama_kelas.required'   => 'Nama kelas tidak boleh kosong.',
            'nama_kelas.max'        => 'Nama kelas tidak boleh lebih dari 70 karakter.',
            'deskripsi.required'    => 'Deskripsi tidak boleh kosong.',
            'kode_kelas.required'   => 'Kode kelas tidak boleh kosong.',
            'kode_kelas.min'        => 'Kode kelas tidak boleh kurang dari 6 karakter.',
            'kode_kelas.max'        => 'Kode kelas tidak boleh lebih dari 6 karakter.',
        ];
        
        $validasi = Validator::make($request->all(), $rules, $messages);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }

        // Data Update

        $kelas = Kelas::findOrFail($id);
        $kelas->guru_id         = \Auth::guard('guru')->user()->id;
        $kelas->nama_kelas      = $request->nama_kelas;
        $kelas->deskripsi       = $request->deskripsi;
        $kelas->kode_kelas      = $request->kode_kelas;
        $kelas->save();

        return back()->with('pesan', 'Selamat, Kelas Berhasil Diupdate.');

    }

}
