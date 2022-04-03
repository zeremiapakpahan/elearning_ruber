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
                    <i class="fa fa-sign-out-alt"></i>
                    <span class="links-name">Logout</span>
                </a>
                <span class="tooltip">Sign Out</span>
            </li>
        </ul>
    </div> --}}

    @include('sidebar-siswa')

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

        {{-- Pesan Gagal--}}
        @if (Session::has('pesan2'))
        <div class="failed access">
            {!! Session::get('pesan2') !!}
        </div>
        @endif

        {{-- Pesan Error --}}
        @if ($errors->any())
            @foreach ( $errors->all() as $error)
                <div class="error">{{ $error }}</div>    
            @endforeach
        @endif  

        <div class="kelas-header">
            <h2>{{ $kelas->nama_kelas }}</h2>
            <div class="deskripsi-section">
                <span class="deskripsi">{{ $kelas->deskripsi }}</span>
                <div></div>
            </div>
            <div class="profil-section">
                @if ($kelas->guru->foto != '')
                    <img class="photo-section-1" src="{{ \Storage::url($kelas->guru->foto) }}" alt="Foto">
                @else
                    <img class="photo-section-1" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                @endif
                <span class="name-section-1">{{ $kelas->guru->nama }}</span>
                <span class="status">{{ $kelas->guru->status }}</span>

                <!-- <img class="photo-section-2" src="/img/karolin.jpg" alt="Foto">
                <span class="name-section-2">Karolin Natalia</span>
                <span class="status-2">P2</span> -->
            </div>
        </div>

        @include('kelas-menu-siswa')
        
        <div class="kelas-main-content">
            <div class="attendance" id="siswa-section">
                <div class="attendance-section">
                    <h3>KEHADIRAN</h3>
                    <div class="attendance-row">
                        <table class="attendance-table">
                            <thead class="attendance-header">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Batas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="attendance-content">

                                @foreach ($kelas->pertemuan as $pertemuan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($pertemuan->tanggal) ) }}</td>  <!-- tambahin 1 kolom database dan form dibawah ni  -->
                                        <td>{{ $pertemuan->deskripsi }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($pertemuan->batas) ) }}</td>
                                        <td>{{ $pertemuan->status }}</td>
                                        <td> 
                                            <!-- <i class="fa fa-angle-down" id="drop"></i> -->
                                            @if ($pertemuan->status == "Buka")
                                                <button type="button" class="btn-section" id="drop">Presensi</button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="dropdown-row">
                                        <td colspan="6">
                                            <div class="dropdown-column">
                                                <div class="dropdown-list">
                                                    @if ($pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                                                        <div class="a-identity">
                                                            @if ($pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->siswa->foto != '')
                                                                <img src="{{ \Storage::url($pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->siswa->foto) }}" alt="Foto">
                                                            @else
                                                                <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                            @endif
                                                            <div>
                                                                <span>{{ $pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->siswa->nama }}</span>
                                                                <span>{{ $pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->siswa->status }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="a-group">
                                                            <div class="a-information">
                                                                <span class="tag">Keterangan <p>:</p> </span>
                                                                <span>{{ $pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->keterangan }}</span>
                                                            </div>
                                                            <div class="a-point">
                                                                <span class="tag">Point <p>:</p></span>
                                                                <span>{{ $pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->point }}</span>
                                                            </div>
                                                        </div> 
                                                    @endif
                                                    @if ( $pertemuan->kehadiran->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '')
                                                        {{-- <form class="presence-form" action=""> --}}
                                                        {!! Form::model($objek, ['action' => $action, 'method' => $method, 'class' => 'presence-form']) !!}
                                                            {!! Form::hidden('pertemuan_id', $pertemuan->id) !!}
                                                            <span class="info-group">
                                                                <span>Keterangan: </span>
                                                                <input name="keterangan" type="radio" value="Hadir"> Hadir
                                                                <input name="keterangan" type="radio" value="Sakit"> Sakit
                                                                <input name="keterangan" type="radio" value="Izin"> Izin
                                                                <input name="keterangan" type="radio" value="Alfa"> Alfa
                                                            </span>
                                                            <button type="submit" class="btn-section">Kirim</button>
                                                        {!! Form::close() !!}
                                                        {{-- </form> --}}
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
                <span>YDB.10.06.017</span>
                <span>DOSEN</span>
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
                            <span>
                                Kazelia Valent Agatha Timothy
                                <p>telah mengerjakan</p>
                                Bimbingan 1
                            </span>
                            <span>
                                17 Des 2019 19.29 WIB
                            </span>
                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
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
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
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
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
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
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
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
                    </div>
                </a>
                <a href="">
                    <div class="notif-row">
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
                    </div>
                </a>
            </div>
        </div>
    </div> --}}

    @include('rightbar-siswa')

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
                <span>YDB.10.06.017</span>
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
    <script src="{{ asset('project') }}/js/script2.js"></script>
    <script src="{{ asset('project') }}/js/script3.js"></script>

</body>

</html>