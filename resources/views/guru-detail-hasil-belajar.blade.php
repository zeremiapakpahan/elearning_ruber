<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUBER | GMEC </title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('project') }}/css/style.css">

    <!-- CSS Khusus  -->
    <link rel="stylesheet" href="{{ asset('project') }}/css/style-khusus.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('project') }}/font/font/css/all.css">

</head>

<body>

    <!-- Sidebar -->

    {{-- <div class="sidebar">
        <div class="logo-content">
            <div class="logo">
                <img src="/img/gmec.png" alt="Logo">
                <div class="logo-name">
                    <h2>RUBER</h2>
                </div>
            </div>
            <i class="fa fa-bars" id="hide-btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="">
                    <i class="fa fa-th-large"></i>
                    <span class="links-name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-home"></i>
                    <span class="links-name">Kelas</span>
                </a>
                <span class="tooltip">Kelas</span>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-book"></i>
                    <span class="links-name">Hasil Belajar</span>
                </a>
                <span class="tooltip">Hasil Belajar</span>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-sign-out-alt"></i>
                    <span class="links-name">Logout</span>
                </a>
                <span class="tooltip">Sign Out</span>
            </li>
        </ul>
    </div> --}}

    @include('sidebar-guru')

    <!-- Akhir Sidebar -->

    <!-- Khusus Ukuran Mobile -->
    <div class="shadow-bg">

    </div>

    <!-- Konten -->
    <div class="content">

        {{-- Pesan Sukses --}}
        @if (Session::has('pesan'))
            <div class="success">
                {!! Session::get('pesan') !!}
            </div>
        @endif

        {{-- Pesan Error --}}
        @if ($errors->any())
            @foreach ( $errors->all() as $error)
                <div class="error">{{ $error }}</div>    
            @endforeach
        @endif  

        <div class="table-container">
            <h3>{{ $siswa->nama }}</h3>
            <h5>Kegiatan Belajar</h5>
            <table class="activity-list" >
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Judul Kegiatan</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    <!-- Penugasan Loop -->
                    @foreach ($penugasan as $penugasan)
                        <tr data-datetime="{{ $penugasan->created_at->format('d M Y H:i:s') }}" >
                            <td></td>
                            <td>{{ $penugasan->judul }}</td>
                            <td>{{ $penugasan->tipe }}</td>
                            <td>{{ $penugasan->created_at->format('d M Y') }}</td>
                            <td class="nilai">
                                @if ($penugasan->prosesTugas->where('siswa_id', $siswa->id)->first() != '')
                                    @if ($penugasan->prosesTugas->where('siswa_id', $siswa->id)->first()->hasilTugas != '')
                                        {{ $penugasan->prosesTugas->where('siswa_id', $siswa->id)->first()->hasilTugas->nilai }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <!-- Informasi Loop -->
                    @foreach ($informasi as $info)
                        <tr data-datetime="{{ $info->created_at->format('d M Y H:i:s') }}" >
                            <td></td>
                            <td>{{ $info->judul }}</td>
                            <td>{{ $info->tipe }}</td>
                            <td>{{ $info->created_at->format('d M Y') }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    <!-- Quiz Essay Loop -->
                    @foreach ($quiz_pilgan as $qp)
                        <tr data-datetime="{{ $qp->created_at->format('d M Y H:i:s') }}" >
                            <td></td>
                            <td>{{ $qp->judul }}</td></td>
                            <td>{{ $qp->tipe }}</td>
                            <td>{{ $qp->created_at->format('d M Y') }}</td>
                            <td class="nilai">
                                @if ($qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', $siswa->id)->first() != '')
                                    {{ $qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', $siswa->id)->first()->hasilQuizPilgan->nilai_total }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <!-- Quiz Pilgan Loop -->
                    @foreach ($quiz_essay as $qe)
                        <tr data-datetime="{{ $qe->created_at->format('d M Y H:i:s') }}">
                            <td></td>
                            <td>{{ $qe->judul }}</td></td>
                            <td>{{ $qe->tipe }}</td>
                            <td>{{ $qe->created_at->format('d M Y') }}</td>
                            <td class="nilai">
                                @if ($qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', $siswa->id)->first() != '')
                                    @if ($qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', $siswa->id)->first()->hasilQuizEssay != '')
                                        {{ $qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', $siswa->id)->first()->hasilQuizEssay->nilai_total }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="total">Total: <p id="grade-c"></p></td>
                    </tr>
                </tbody>
            </table>
            <h5>Kehadiran</h5>
            <table class="presence-list">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Point</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($pertemuan as $pertemuan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pertemuan->deskripsi }}</td>
                            <td>{{ date('d M Y', strtotime($pertemuan->tanggal)) }}</td>
                            <td>
                                @if ($pertemuan->kehadiran->where('siswa_id', $siswa->id)->first() != '')
                                    {{ $pertemuan->kehadiran->where('siswa_id', $siswa->id)->first()->keterangan }}
                                @endif
                            </td>
                            <td class="poin">
                                @if ($pertemuan->kehadiran->where('siswa_id', $siswa->id)->first() != '')
                                    {{ $pertemuan->kehadiran->where('siswa_id', $siswa->id)->first()->point }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="5" class="total">Total: <p id="poin-c"></p></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="print-section">
            <button type="button" class="btn-section">Cetak</button>
        </div>
    </div>
    <!-- Akhir Konten -->

    <!-- Right Bar Content -->
    {{-- <div class="right-sidebar">
        <div class="profil">
            <div class="profil-image">
                <img src="/img/avatar.jpg" alt="Profil" id="profil-img">
                <form id="form" action="">
                    <input name="foto" type="file" class="img-input" id="file-upload">
                </form>
                <i class="fa fa-camera"></i>
            </div>
            <div class="form-edit-container">
                <form class="form-edit" action="">
                    <input name="nama" type="text" value="ZEREMIA PAKPAHAN" required autofocus>
                    <input name="nik" type="text" value="YDB.10.06.017" required autofocus>
                    <input name="password" type="password" value="*****" required autofocus>
                    <button type="submit" class="simpan-btn">Simpan</button>
                </form>
            </div>
            <div class="bio">
                <span class="nama-lengkap">ZEREMIA TIMOTHY</span>
                <span>zeremiakeren@gmail.com</span>
                <span>GURU</span>
            </div>
            <span class="edit-profil">
                <i id="edit-link" class="fa fa-edit"></i>
            </span>
        </div>
        <div class="separator">
            <hr>
        </div>
        <div class="notif">
            <div class="notif-heading">
                <span>NOTIFICATION</span>
                <i class="fa fa-bell"></i>
            </div>
            <div class="notif-content">
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Tugas Klasifikasi Mahluk Hidup</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Bimbingan 1</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Bimbingan 1</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Bimbingan 1</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Bimbingan 1</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
                        <i class="fa fa-file-alt"></i>
                        <div>
                            <span class="notif-container">
                                <span>Kazelia Valent Agatha Timothy</span>
                                <p>telah mengerjakan</p>
                                <span>Bimbingan 1</span>
                            </span>
                            <span class="notif-time" >
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> --}}

    @include('rightbar-guru')

    <!-- Akhir Right Bar Content -->

    <!-- Top Bar Content -->
    <div class="top-bar">
        <div class="top-notif">
            <ul>
                <li>
                    <div class="top-notif-heading">
                        <span>NOTIFICATION</span>
                        <i class="fa fa-bell"></i>
                    </div>
                </li>
                <li class="dropdown-container">
                    <ul class="dropdown-notif">
                        <a href="">
                            <li class="top-notif-row">
                                <i class="fa fa-file-alt"></i>
                                <div>
                                    <span>
                                        Kazelia Valent Agatha Timothy
                                        <p>telah mengerjakan</p>
                                        Bimbingan 1
                                    </span>
                                    <span>
                                        17 Des 2019 19.29 WIB
                                    </span>
                                </div>
                            </li>
                        </a>
                        <a href="">
                            <li class="top-notif-row">
                                <i class="fa fa-file-alt"></i>
                                <div>
                                    <span>
                                        Kazelia Valent Agatha Timothy
                                        <p>telah mengerjakan</p>
                                        Bimbingan 1
                                    </span>
                                    <span>
                                        17 Des 2019 19.29 WIB
                                    </span>
                                </div>
                            </li>
                        </a>
                        <a href="">
                            <li class="top-notif-row">
                                <i class="fa fa-file-alt"></i>
                                <div>
                                    <span>
                                        Kazelia Valent Agatha Timothy
                                        <p>telah mengerjakan</p>
                                        Bimbingan 1
                                    </span>
                                    <span>
                                        17 Des 2019 19.29 WIB
                                    </span>
                                </div>
                            </li>
                        </a>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="top-profil">
            <div class="top-profil-image">
                <img src="/img/avatar.jpg" alt="Profil" id="top-profil-img">
                <form id="top-form" action="">
                    <input name="foto" type="file" class="top-img-input" id="top-file-upload">
                </form>
                <i class="fa fa-camera"></i>
            </div>
            <div class="top-form-edit-container">
                <form class="top-form-edit" action="">
                    <input name="nama" type="text" value="ZEREMIA PAKPAHAN" required autofocus>
                    <input name="nik" type="text" value="YDB.10.06.017" required autofocus>
                    <input name="password" type="password" value="*****" required autofocus>
                    <button type="submit" class="top-simpan-btn">Simpan</button>
                </form>
            </div>
            <div class="top-bio">
                <span class="nama">ZEREMIA TIMOTHY</span>
                <span>zeremiakerene@gmail.com</span>
                <span>DOSEN</span>
            </div>
            <span class="top-edit-profil">
                <i id="top-edit-link" class="fa fa-edit"></i>
            </span>
        </div>
    </div>
    <!-- Akhir Top Bar Content -->

    <!-- jQuery -->
    <script src="{{ asset('project') }}/js/jquery.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('project') }}/js/script.js"></script>
    <script src="{{ asset('project') }}/js/script4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

</body>

</html>