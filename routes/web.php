<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'IndexController@beranda');

// Guru
Route::get('register/guru', 'RegisterController@formRegisterGuru');
Route::post('register/simpan-register-guru', 'RegisterController@simpanRegisterGuru');

Route::put('guru/update-profil/{id}', 'GuruController@updateProfil');

Route::get('login/guru', 'LoginController@formLoginGuru');
Route::post('login/proses-login-guru', 'LoginController@prosesLoginGuru');

Route::get('guru/beranda', 'GuruController@dashboard');

Route::get('guru/kelas', 'GuruController@kelas');
Route::post('guru/simpan-data-kelas', 'GuruController@buatKelas');

Route::get('guru/kelas/index/{id}', 'KelasController@timeline');
// Informasi
Route::post('guru/kelas/simpan-data-informasi', 'KelasController@simpanDataInformasi');

Route::get('guru/kelas/edit-informasi/{id}', 'KelasController@editInformasi');
Route::put('guru/kelas/update-informasi/{id}', 'KelasController@updateInformasi');

Route::get('guru/kelas/hapus-informasi/{id}', 'KelasController@hapusInformasi');

Route::get('guru/kelas/informasi/{id}', 'KelasController@detailInformasi');

// Komentar Informasi
Route::post('guru/kelas/simpan-data-komentar-info', 'KelasController@simpanKomentarInfo');

Route::get('guru/kelas/edit-komentar-info/{id}', 'KelasController@editKomentarInfo');
Route::put('guru/kelas/update-komentar-info/{id}', 'KelasController@updateKomentarInfo');

Route::get('guru/kelas/hapus-komentar-info/{id}', 'KelasController@hapusKomentarInfo');

Route::get('guru/kelas/hapus-komentar-info-siswa/{id}', 'KelasController@hapusKomentarInfoSiswa');

// Penugasan
Route::post('guru/kelas/simpan-data-penugasan', 'KelasController@simpanPenugasan');

Route::get('guru/kelas/edit-penugasan/{id}', 'KelasController@editPenugasan');
Route::put('guru/kelas/update-penugasan/{id}', 'KelasController@updatePenugasan');

Route::get('guru/kelas/hapus-penugasan/{id}', 'KelasController@hapusPenugasan');

// Buka Penugasan (Apabila Status Penugasan Tutup)
Route::get('guru/kelas/buka-penugasan/{id}', 'KelasController@bukaPenugasan');

Route::get('guru/kelas/penugasan/{id}', 'KelasController@detailPenugasan');

// Komentar Penugasan
Route::post('guru/kelas/simpan-data-komentar-tugas', 'KelasController@simpanKomentarTugas');

Route::get('guru/kelas/edit-komentar-tugas/{id}', 'KelasController@editKomentarTugas');
Route::put('guru/kelas/update-komentar-tugas/{id}', 'KelasController@updateKomentarTugas');

Route::get('guru/kelas/hapus-komentar-tugas/{id}', 'KelasController@hapusKomentarTugas');

Route::get('guru/kelas/hapus-komentar-tugas-siswa/{id}', 'KelasController@hapusKomentarTugasSiswa');

// Penilaian Tugas

Route::get('guru/kelas/hasil-tugas/{id}', 'KelasController@detailhasilTugas');
Route::post('guru/kelas/simpan-penilaian-tugas', 'KelasController@simpanPenilaianTugas');

Route::get('guru/kelas/edit-penilaian-tugas/{id}', 'KelasController@editPenilaianTugas');
Route::put('guru/kelas/update-penilaian-tugas/{id}', 'KelasController@updatePenilaianTugas');

// Komentar Hasil Tugas
Route::post('guru/kelas/simpan-komentar-hasil-tugas', 'KelasController@simpanKomenHasilTugas');

Route::get('guru/kelas/edit-komentar-hasil-tugas/{id}', 'KelasController@editKomenHasilTugas');
Route::put('guru/kelas/update-komentar-hasil-tugas/{id}', 'KelasController@updateKomenHasilTugas');

Route::get('guru/kelas/hapus-komentar-hasil-tugas/{id}', 'KelasController@hapusKomenHasilTugas');

Route::get('guru/kelas/hapus-komentar-hasil-tugas-siswa/{id}', 'KelasController@hapusKomenHasilTugasSiswa');


// Quiz Pilgan
Route::post('guru/kelas/simpan-data-quiz-pilgan', 'KelasController@simpanQuizPilgan');

Route::get('guru/kelas/edit-quiz-pilgan/{id}', 'KelasController@editQuizPilgan');
Route::put('guru/kelas/update-quiz-pilgan/{id}', 'KelasController@updateQuizPilgan');

Route::get('guru/kelas/hapus-quiz-pilgan/{id}', 'KelasController@hapusQuizPilgan');

// Buka Quiz Pilgan (Apabila Status Quiz Pilgan Tutup)
Route::get('guru/kelas/buka-quiz-pilgan/{id}', 'KelasController@bukaQuizPilgan');

Route::get('guru/kelas/quiz-pilgan/{id}', 'KelasController@detailQuizPilgan');

// Hasil Quiz Pilgan
Route::get('guru/kelas/hasil-quiz-pilgan/{id}', 'KelasController@detailHasilQuizPilgan');

// Quiz Essay
Route::post('guru/kelas/simpan-data-quiz-essay', 'KelasController@simpanQuizEssay');

Route::get('guru/kelas/edit-quiz-essay/{id}', 'KelasController@editQuizEssay');
Route::put('guru/kelas/update-quiz-essay/{id}', 'KelasController@updateQuizEssay');

Route::get('guru/kelas/hapus-quiz-essay/{id}', 'KelasController@hapusQuizEssay');

// Buka Quiz Essay (Apabila Status Quiz Essay Tutup)
Route::get('guru/kelas/buka-quiz-essay/{id}', 'KelasController@bukaQuizEssay');

Route::get('guru/kelas/quiz-essay/{id}', 'KelasController@detailQuizEssay');

// Penilaian Quiz Essay
Route::get('guru/kelas/hasil-quiz-essay/{id}', 'KelasController@detailHasilQuizEssay');
Route::post('guru/kelas/simpan-penilaian-quiz-essay/{id}', 'KelasController@simpanPenilaianQuizEssay');

Route::get('guru/kelas/edit-penilaian-quiz-essay/{id}', 'KelasController@editPenilaianQuizEssay');
Route::put('guru/kelas/update-penilaian-quiz-essay/{id}', 'KelasController@updatePenilaianQuizEssay');

// Kehadiran

Route::get('guru/kelas/kehadiran/{id}', 'KelasController@kehadiran');

Route::post('guru/kelas/simpan-pertemuan', 'KelasController@simpanPertemuan');

Route::get('guru/kelas/buka-pertemuan/{id}', 'KelasController@bukaPertemuan');
Route::get('guru/kelas/tutup-pertemuan/{id}', 'KelasController@tutupPertemuan');

Route::get('guru/kelas/edit-pertemuan/{id}', 'KelasController@editPertemuan');
Route::put('guru/kelas/update-pertemuan/{id}', 'KelasController@updatePertemuan');

Route::get('guru/kelas/hapus-pertemuan/{id}', 'KelasController@hapusPertemuan');


Route::get('guru/kelas/edit-kehadiran-siswa/{id}', 'KelasController@editKehadiranSiswa');
Route::put('guru/kelas/update-kehadiran-siswa/{id}', 'KelasController@updateKehadiranSiswa');

// Anggota

Route::get('guru/kelas/anggota/{id}', 'KelasController@anggota');

Route::post('guru/kelas/tambah-anggota', 'KelasController@tambahAnggota');

Route::get('guru/kelas/hapus-anggota/{id}', 'KelasController@hapusAnggota');

// Detail Kelas

Route::get('guru/kelas/detail/{id}', 'KelasController@detailKelas');

Route::put('guru/kelas/update-kelas/{id}', 'KelasController@updateKelas');

// Hasil Belajar
Route::get('guru/hasil-belajar-siswa', 'GuruHasilBelajarController@hasilBelajarSiswa');
Route::get('guru/hasil-belajar-siswa/detail/{id}', 'GuruHasilBelajarController@detailHasilBelajar');

Route::get('guru/logout', 'GuruController@logout');


// Siswa

Route::get('register/siswa', 'RegisterController@formRegisterSiswa');
Route::post('register/simpan-register-siswa', 'RegisterController@simpanRegisterSiswa');

Route::put('siswa/update-profil/{id}', 'SiswaController@updateProfil');

Route::get('login/siswa', 'LoginController@formLoginSiswa');
Route::post('login/proses-login-siswa', 'LoginController@prosesLoginSiswa');

Route::get('siswa/beranda', 'SiswaController@dashboard');

Route::get('siswa/kelas', 'SiswaController@kelas');
Route::post('siswa/proses-masuk-kelas', 'SiswaController@gabungKelas');

Route::get('siswa/kelas/index/{id}', 'KelasSiswaController@timeline');

// Penugasan
Route::get('siswa/kelas/komentar-penugasan/{id}', 'KelasSiswaController@komentarPenugasan');
Route::post('siswa/kelas/simpan-data-komentar-tugas', 'KelasSiswaController@simpanKomentarTugas');

Route::get('siswa/kelas/edit-komentar-tugas/{id}', 'KelasSiswaController@editKomentarTugas');
Route::put('siswa/kelas/update-komentar-tugas/{id}', 'KelasSiswaController@updateKomentarTugas');

Route::get('siswa/kelas/hapus-komentar-tugas/{id}', 'KelasSiswaController@hapusKomentarTugas');

Route::get('siswa/kelas/kumpulkan-tugas/{id}', 'KelasSiswaController@formKumpulTugas');
Route::post('siswa/kelas/proses-kumpul-tugas', 'KelasSiswaController@prosesKumpulTugas');

Route::get('siswa/kelas/edit-hasil-tugas/{id}', 'KelasSiswaController@editHasilTugas');
Route::put('siswa/kelas/update-hasil-tugas/{id}', 'KelasSiswaController@updateHasilTugas');

Route::get('siswa/kelas/hasil-tugas/{id}', 'KelasSiswaController@detailHasilTugas');

Route::post('siswa/kelas/simpan-komentar-hasil-tugas', 'KelasSiswaController@simpanKomenHasilTugas');

Route::get('siswa/kelas/edit-komentar-hasil-tugas/{id}', 'KelasSiswaController@editKomenHasilTugas');
Route::put('siswa/kelas/update-komentar-hasil-tugas/{id}', 'KelasSiswaController@updateKomenHasilTugas');

Route::get('siswa/kelas/hapus-komentar-hasil-tugas/{id}', 'KelasSiswaController@hapusKomenHasilTugas');

// Informasi
Route::get('siswa/kelas/komentar-informasi/{id}', 'KelasSiswaController@komentarInformasi');
Route::post('siswa/kelas/simpan-data-komentar-info', 'KelasSiswaController@simpanKomentarInfo');

Route::get('siswa/kelas/edit-komentar-info/{id}', 'KelasSiswaController@editKomentarInfo');
Route::put('siswa/kelas/update-komentar-info/{id}', 'KelasSiswaController@updateKomentarInfo');

Route::get('siswa/kelas/hapus-komentar-info/{id}', 'KelasSiswaController@hapusKomentarInfo');

// Quiz Pilgan
Route::get('siswa/kelas/quiz-pilgan/{id}', 'KelasSiswaController@formQuizPilgan');
Route::post('siswa/kelas/proses-quiz-pilgan', 'KelasSiswaController@prosesQuizPilgan');
Route::post('siswa/kelas/waktu-habis-quiz-pilgan', 'KelasSiswaController@waktuHabisQuizPilgan');

// Quiz Essay
Route::get('siswa/kelas/quiz-essay/{id}', 'KelasSiswaController@formQuizEssay');
Route::post('siswa/kelas/proses-quiz-essay', 'KelasSiswaController@prosesQuizEssay');
Route::post('siswa/kelas/waktu-habis-quiz-essay', 'KelasSiswaController@waktuHabisQuizEssay');

// Kehadiran
Route::get('siswa/kelas/kehadiran/{id}', 'KelasSiswaController@kehadiran');
Route::post('siswa/kelas/simpan-data-kehadiran', 'KelasSiswaController@simpanKehadiran');


// Anggota
Route::get('siswa/kelas/anggota/{id}', 'KelasSiswaController@anggota');
Route::get('siswa/kelas/keluar-kelas/{id}', 'KelasSiswaController@keluarKelas');

// Detail Kelas
Route::get('siswa/kelas/detail/{id}', 'KelasSiswaController@detailKelas');

Route::get('siswa/logout', 'SiswaController@logout');


// Admin

Route::get('admin/login', 'AdminController@formLoginAdmin');
Route::post('admin/proses-login-admin', 'AdminController@prosesLoginAdmin');

Route::put('admin/update-profil/{id}', 'AdminController@updateProfil');

Route::get('admin/beranda', 'AdminController@dashboard');

Route::get('admin/data-guru', 'AdminController@dataGuru');

Route::get('admin/data-guru/hapus/{id}', 'AdminController@hapusDataGuru');

Route::get('admin/data-siswa', 'AdminController@dataSiswa');

Route::get('admin/data-siswa/hapus/{id}', 'AdminController@hapusdataSiswa');

Route::get('admin/data-kelas', 'AdminController@dataKelas');

Route::get('admin/data-kelas/hapus/{id}', 'AdminController@hapusdataKelas');

Route::get('admin/logout', 'AdminController@logout');

