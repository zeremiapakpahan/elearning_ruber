<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Admin as Admin;
use \App\Kelas as Kelas;
use \App\Guru as Guru;
use \App\Siswa as Siswa;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function formLoginAdmin() {
        if (\Auth::guard('admin')->check()) {
            return redirect('admin/beranda')->with('pesan', 'Anda Sudah Login.');
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            $data['objek'] = new Admin();
            $data['action'] = 'AdminController@prosesLoginAdmin';
            $data['method'] = 'POST';
            return view('login-admin', $data);
        }
    }

    public function prosesLoginAdmin(Request $request) {

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

        if (\Auth::guard('admin')->attempt($credentials)) {
            return redirect('admin/beranda')->with('pesan', 'Selamat, Anda Berhasil Login.');
        } else {
            return back()->with('pesan', 'Login Gagal, Email/Password Salah.');
        }

    }

    public function dashboard() {

        if (\Auth::guard('admin')->check()) {
            $data['kelas_ipa'] = Kelas::where('deskripsi', 'IPA')->get();
            $data['kelas_ips'] = Kelas::where('deskripsi', 'IPS')->get();
            $data['kelas_tik'] = Kelas::where('deskripsi', 'TIK')->get();
            $data['kelas_sbk'] = Kelas::where('deskripsi', 'SBK')->get();
            $data['kelas_english'] = Kelas::where('deskripsi', 'English')->get();
            $data['kelas_mandarin'] = Kelas::where('deskripsi', 'Mandarin')->get();
            $data['kelas_mtk'] = Kelas::where('deskripsi', 'Matematika')->get();
            $data['kelas_pjok'] = Kelas::where('deskripsi', 'PJOK')->get();
            $data['kelas_musik'] = Kelas::where('deskripsi', 'Musik')->get();
            $data['kelas_tipografi'] = Kelas::where('deskripsi', 'Tipografi')->get();
            $data['kelas_agama'] = Kelas::where('deskripsi', 'Agama')->get();
            $data['kelas_bahasa'] = Kelas::where('deskripsi', 'Bahasa Indonesia')->get();
            $data['kelas_pkn'] = Kelas::where('deskripsi', 'PKN')->get();

            $id = \Auth::guard('admin')->user()->id;

            $data['objek_profil'] = Admin::findOrFail($id);
            $data['action_profil'] = ['AdminController@updateProfil', $id];
            $data['method_profil'] = 'PUT';
            
            return view('beranda-admin', $data);

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    public function dataGuru() {

        if (\Auth::guard('admin')->check()) {
            $data['kelas_ipa'] = Kelas::where('deskripsi', 'IPA')->get();
            $data['kelas_ips'] = Kelas::where('deskripsi', 'IPS')->get();
            $data['kelas_tik'] = Kelas::where('deskripsi', 'TIK')->get();
            $data['kelas_sbk'] = Kelas::where('deskripsi', 'SBK')->get();
            $data['kelas_english'] = Kelas::where('deskripsi', 'English')->get();
            $data['kelas_mandarin'] = Kelas::where('deskripsi', 'Mandarin')->get();
            $data['kelas_mtk'] = Kelas::where('deskripsi', 'Matematika')->get();
            $data['kelas_pjok'] = Kelas::where('deskripsi', 'PJOK')->get();
            $data['kelas_musik'] = Kelas::where('deskripsi', 'Musik')->get();
            $data['kelas_tipografi'] = Kelas::where('deskripsi', 'Tipografi')->get();
            $data['kelas_agama'] = Kelas::where('deskripsi', 'Agama')->get();
            $data['kelas_bahasa'] = Kelas::where('deskripsi', 'Bahasa Indonesia')->get();
            $data['kelas_pkn'] = Kelas::where('deskripsi', 'PKN')->get();

            $id = \Auth::guard('admin')->user()->id;

            $data['objek_profil'] = Admin::findOrFail($id);
            $data['action_profil'] = ['AdminController@updateProfil', $id];
            $data['method_profil'] = 'PUT';

            return view('admin-data-guru', $data);

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    public function hapusDataGuru($id) {
        if (\Auth::guard('admin')->check()) {

            $guru = Guru::findOrFail($id);

            foreach ($guru->kelas as $kelas) {
                foreach ($kelas->penugasan as $penugasan) {
                    foreach ($penugasan->fileTugas as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }

                    foreach ($penugasan->komentarTugas as $komen) {
                        foreach ($komen->fileKomenTugas as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komen->delete();
                    }

                    foreach ($penugasan->prosesTugas as $proses) {
                        if ($proses->hasilTugas != '') {
                            foreach ($proses->hasilTugas->komenHasilTugas as $komen) {
                                foreach ($komen->fileKomenHasilTugas as $files) {
                                    \Storage::delete($files->nama_file);
                                    $files->delete();
                                }
                                $komen->delete();
                            }
                            $proses->hasilTugas->delete();
                        }
                        foreach ($proses->fileProsesTugas as $files) {
                            \Storage::delete($files->file);
                            $files->delete();
                        }
                        $proses->delete();
                    }
                    $penugasan->delete();
                }

                foreach ($kelas->informasi as $info) {
                    foreach ($info->fileInfo as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }

                    foreach ($info->komentarInfo as $komen) {
                        foreach ($komen->fileKomenInfo as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komen->delete();
                    }
                    $info->delete();
                }

                foreach ($kelas->quiz->where('tipe', 'Quiz Pilgan') as $quiz) {
                    foreach ($quiz->quizPilgan as $index => $qp) {
                        if ($index == 0) {
                            foreach ($qp->prosesQuizPilgan as $proses) {
                                $proses->hasilQuizPilgan->delete();
                                $proses->delete();
                            }
                        } else {
                            foreach ($qp->prosesQuizPilgan as $proses) {
                                $proses->delete();
                            }
                        }
                        $qp->jawabanBenar->delete();
                        $qp->delete();
                    }
                    if ($quiz->whQp != '') {
                        $quiz->whQp->delete();
                    }
                    $quiz->delete();
                }
                
                foreach ($kelas->quiz->where('tipe', 'Quiz Essay') as $quiz) {
                    foreach ($quiz->quizEssay as $index => $qe) {
                        if ($index == 0) {
                            foreach ($qe->prosesQuizEssay as $proses) {
                                if ($proses->hasilQuizEssay != '') {
                                    $proses->hasilQuizEssay->delete();
                                }
                                $proses->delete();
                            }
                        } else {
                            foreach ($qe->prosesQuizEssay as $proses) {
                                $proses->delete();
                            }
                        }
                        $qe->delete();
                    }
                    if ($quiz->whQe != '') {
                        $quiz->whQe->delete();
                    }
                    $quiz->delete();
                }

                foreach ($kelas->pertemuan as $pertemuan) {
                    foreach ($pertemuan->kehadiran as $kehadiran) {
                        $kehadiran->delete();
                    }
                    $pertemuan->delete();
                }

                foreach ($kelas->anggota as $anggota) {
                    $anggota->delete();
                }

                $kelas->delete();
            }

            $guru->user->delete();

            \Storage::delete($guru->foto);
            $guru->delete();

            return back()->with('pesan', 'Selamat, Data Guru Berhasil Dihapus.');

            
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }
    }

    public function dataSiswa() {

        if (\Auth::guard('admin')->check()) {
            $data['kelas_tujuh'] = Kelas::where('nama_kelas', 'LIKE', '%7%')->where('deskripsi', 'IPA')->get();
            $data['kelas_delapan'] = Kelas::where('nama_kelas', 'LIKE', '%8%')->where('deskripsi', 'IPA')->get();
            $data['x'] = 1;

            $id = \Auth::guard('admin')->user()->id;

            $data['objek_profil'] = Admin::findOrFail($id);
            $data['action_profil'] = ['AdminController@updateProfil', $id];
            $data['method_profil'] = 'PUT';

            return view('admin-data-siswa', $data);

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    public function hapusDataSiswa($id) {

        if (\Auth::guard('admin')->check()) {
            
            $siswa = Siswa::findOrFail($id);
            
            foreach ($siswa->komentarTugas as $komen) {
                foreach ($komen->fileKomenTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }
                $komen->delete();
            }

            foreach ($siswa->prosesTugas as $proses) {
                if ($proses->hasilTugas != '') {
                    foreach ($proses->hasilTugas->komenHasilTugas->where('siswa_id', $siswa->id) as $komen) {
                        foreach ($komen->fileKomenHasilTugas as $files) {
                            \Storage::delete($files->nama_file);
                            $files->delete();
                        }
                        $komen->delete();
                    }
                    $proses->hasilTugas->delete();
                }

                foreach ($proses->fileProsesTugas as $files) {
                    \Storage::delete($files->file);
                    $files->delete();
                }

                $proses->delete();
            }

            foreach ($siswa->komentarInfo as $komen) {
                foreach ($komen->fileKomenInfo as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }
                $komen->delete();
            }

            foreach ($siswa->prosesQuizPilgan as $proses) {
                if ($proses->hasilQuizPilgan != '') {
                    $proses->hasilQuizPilgan->delete();
                }
                $proses->delete();
            }

            foreach ($siswa->prosesQuizEssay as $proses) {
                if ($proses->hasilQuizEssay != '') {
                    $proses->hasilQuizEssay->delete();
                }
                $proses->delete();
            }

            foreach ($siswa->kehadiran as $kehadiran) {
                $kehadiran->delete();
            }

            foreach ($siswa->anggota as $anggota) {
                $anggota->delete();
            }

            $siswa->user->delete();

            \Storage::delete($siswa->foto);
            $siswa->delete();

            return back()->with('pesan', 'Selamat, Data Siswa Berhasil Dihapus.');

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }
    }

    public function dataKelas() {

        if (\Auth::guard('admin')->check()) {
            $data['kelas_ipa'] = Kelas::where('deskripsi', 'IPA')->get();
            $data['kelas_ips'] = Kelas::where('deskripsi', 'IPS')->get();
            $data['kelas_tik'] = Kelas::where('deskripsi', 'TIK')->get();
            $data['kelas_sbk'] = Kelas::where('deskripsi', 'SBK')->get();
            $data['kelas_english'] = Kelas::where('deskripsi', 'English')->get();
            $data['kelas_mandarin'] = Kelas::where('deskripsi', 'Mandarin')->get();
            $data['kelas_mtk'] = Kelas::where('deskripsi', 'Matematika')->get();
            $data['kelas_pjok'] = Kelas::where('deskripsi', 'PJOK')->get();
            $data['kelas_musik'] = Kelas::where('deskripsi', 'Musik')->get();
            $data['kelas_tipografi'] = Kelas::where('deskripsi', 'Tipografi')->get();
            $data['kelas_agama'] = Kelas::where('deskripsi', 'Agama')->get();
            $data['kelas_bahasa'] = Kelas::where('deskripsi', 'Bahasa Indonesia')->get();
            $data['kelas_pkn'] = Kelas::where('deskripsi', 'PKN')->get();

            $id = \Auth::guard('admin')->user()->id;

            $data['objek_profil'] = Admin::findOrFail($id);
            $data['action_profil'] = ['AdminController@updateProfil', $id];
            $data['method_profil'] = 'PUT';

            return view('admin-data-kelas', $data);

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    public function hapusDataKelas($id) {
        
        if (\Auth::guard('admin')->check()) {
            
            $kelas = Kelas::findOrFail($id);

            foreach ($kelas->penugasan as $penugasan) {
                foreach ($penugasan->fileTugas as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }

                foreach ($penugasan->komentarTugas as $komen) {
                    foreach ($komen->fileKomenTugas as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }
                    $komen->delete();
                }

                foreach ($penugasan->prosesTugas as $proses) {
                    if ($proses->hasilTugas != '') {
                        foreach ($proses->hasilTugas->komenHasilTugas as $komen) {
                            foreach ($komen->fileKomenHasilTugas as $files) {
                                \Storage::delete($files->nama_file);
                                $files->delete();
                            }
                            $komen->delete();
                        }
                        $proses->hasilTugas->delete();
                    }

                    foreach ($proses->fileProsesTugas as $files) {
                        \Storage::delete($files->file);
                        $files->delete();
                    }

                    $proses->delete();
                }
                $penugasan->delete();
            }

            foreach ($kelas->informasi as $info) {
                foreach ($info->fileInfo as $files) {
                    \Storage::delete($files->nama_file);
                    $files->delete();
                }
                
                foreach ($info->komentarInfo as $komen) {
                    foreach ($komen->fileKomenInfo as $files) {
                        \Storage::delete($files->nama_file);
                        $files->delete();
                    }
                    $komen->delete();
                }
                $info->delete();
            }

            foreach ($kelas->quiz->where('tipe', 'Quiz Pilgan') as $quiz) {
                foreach ($quiz->quizPilgan as $index => $qp) {
                    if ($index == 0) {
                        foreach ($qp->prosesQuizPilgan as $proses) {
                            $proses->hasilQuizPilgan->delete();
                            $proses->delete();
                        }
                    } else {
                        foreach ($qp->prosesQuizPilgan as $proses) {
                            $proses->delete();
                        }
                    }
                    $qp->jawabanBenar->delete();
                    $qp->delete();
                }
                if ($quiz->whQp != '') {
                    $quiz->whQp->delete();
                }
                $quiz->delete();
            }
            
            foreach ($kelas->quiz->where('tipe', 'Quiz Essay') as $quiz) {
                foreach ($quiz->quizEssay as $index => $qe) {
                    if ($index == 0) {
                        foreach ($qe->prosesQuizEssay as $proses) {
                            if ($proses->hasilQuizEssay != '') {
                                $proses->hasilQuizEssay->delete();
                            }
                            $proses->delete();
                        }
                    } else {
                        foreach ($qe->prosesQuizEssay as $proses) {
                            $proses->delete();
                        }
                    }
                    $qe->delete();
                }
                if ($quiz->whQe != '') {
                    $quiz->whQe->delete();
                }
                $quiz->delete();
            }

            foreach ($kelas->pertemuan as $pertemuan) {
                foreach ($pertemuan->kehadiran as $kehadiran) {
                    $kehadiran->delete();
                }
                $pertemuan->delete();
            }

            foreach ($kelas->anggota as $anggota) {
                $anggota->delete();
            }

            $kelas->delete();

            return back()->with('pesan', 'Selamat, Data Kelas Berhasil Dihapus.');
        

        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    public function updateProfil(Request $request, $id) {

        // Form Validation

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

        // Data Update

        $admin = Admin::findOrFail($id);
        $admin->nama            = $request->nama;
        $admin->email           = $request->email;
        $admin->password        = bcrypt($request->password);
        $admin->save();

        return back()->with('pesan', 'Selamat, Profil Anda Berhasil Diupdate.');

    }

    public function logout() {

        if (\Auth::guard('admin')->check()) {
            
            \Auth::guard('admin')->logout();
            return redirect('/');
        } elseif (\Auth::guard('guru')->check()) {
            return redirect('guru/beranda')->with('pesan', 'Akses Ditolak!');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect('siswa/beranda')->with('pesan', 'Akses Ditolak!');
        } else {
            return redirect('/')->with('pesan', 'Anda Bukan Admin!');
        }

    }

    
}
