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

        @if (Request::is('guru/kelas/kehadiran*'))
            @include('kelas-menu-guru')
        @endif
        
        <div class="kelas-main-content">
            <div class="attendance" id="guru-section">
                <div class="attendance-section">
                    @if (Request::is('guru/kelas/kehadiran*') || Request::is('guru/kelas/edit-kehadiran-siswa*'))
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
                                            <td>{{ date('d M Y H:i', strtotime($pertemuan->tanggal)) }}</td>  <!-- tambahin 1 kolom database dan form dibawah ni  -->
                                            <td>{{ $pertemuan->deskripsi }}</td>
                                            <td>{{ date('d M Y H:i', strtotime($pertemuan->batas)) }}</td>
                                            <td>
                                                @if ($pertemuan->status == 'Buka')
                                                    <button onclick="window.location.href='{{ url('guru/kelas/tutup-pertemuan/'.$pertemuan->id) }}'" class="btn-section" type="button">
                                                        {{ $pertemuan->status }}
                                                    </button>
                                                @elseif ($pertemuan->status == 'Tutup' )
                                                    <button onclick="window.location.href='{{ url('guru/kelas/buka-pertemuan/'.$pertemuan->id) }}'" class="btn-section" type="button">
                                                        {{ $pertemuan->status }}
                                                    </button>
                                                @endif
                                            </td>
                                            <td> 
                                                <i class="fa fa-angle-down" id="drop"></i>
                                                <button onclick="window.location.href='{{ url('guru/kelas/edit-pertemuan/'.$pertemuan->id) }}'" class="btn-section" type="button">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="dropdown-row">
                                            <td colspan="6">
                                                <div class="dropdown-column">
                                                    <div class="dropdown-list">
                                                        @if (Request::is('guru/kelas/kehadiran*'))
                                                            <span onclick="window.location.href='{{ url('guru/kelas/hapus-pertemuan/'.$pertemuan->id) }}'" class="a-delete"><i class="fa fa-trash"></i> Hapus Pertemuan</span>
                                                            @foreach ($pertemuan->kehadiran as $kehadiran)
                                                                <div class="a-identity">
                                                                    @if ($kehadiran->siswa->foto != '')
                                                                        <img src="{{ \Storage::url($kehadiran->siswa->foto) }}" alt="Foto">
                                                                    @else
                                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                                    @endif
                                                                    <div>
                                                                        <span>{{ $kehadiran->siswa->nama }}</span>
                                                                        <span>{{ $kehadiran->siswa->status }}</span>
                                                                    </div>
                                                                    <span onclick="window.location.href='{{ url('guru/kelas/edit-kehadiran-siswa/'.$kehadiran->id) }}'" id="p-edit"><i class="fa fa-pen"></i> Edit</span>
                                                                </div>
                                                                <div class="a-group">
                                                                    <div class="a-information">
                                                                        <span class="tag">Keterangan <p>:</p> </span>
                                                                        <span>{{ $kehadiran->keterangan }}</span>
                                                                    </div>
                                                                    <div class="a-point">
                                                                        <span class="tag">Point <p>:</p></span>
                                                                        <span>{{ $kehadiran->point }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                            @endforeach
                                                        @endif
                                                        @if (Request::is('guru/kelas/edit-kehadiran-siswa*'))
                                                            {{-- <form class="presence-form" action=""> --}}
                                                            {!! Form::model($objek, ['action' => $action, 'method' => $method, 'class' => 'presence-form']) !!}
                                                                {!! Form::hidden('pertemuan_id', $pertemuan->id) !!}
                                                                <h5>EDIT KEHADIRAN SISWA</h5>
                                                                <span class="info-group">
                                                                    <span>Keterangan: </span>
                                                                    <input name="keterangan" type="radio" value="Hadir" {{ $objek->keterangan == "Hadir" ? 'checked' : "Hadir" }}> Hadir
                                                                    <input name="keterangan" type="radio" value="Sakit" {{ $objek->keterangan == "Sakit" ? 'checked' : "Sakit" }}> Sakit
                                                                    <input name="keterangan" type="radio" value="Izin" {{ $objek->keterangan == "Izin" ? 'checked' : "Izin" }}> Izin
                                                                    <input name="keterangan" type="radio" value="Alfa" {{ $objek->keterangan == "Alfa" ? 'checked' : "Alfa" }}> Alfa
                                                                </span>
                                                                <input class="input-section" name="point" type="text" placeholder="Point" value="{{ $objek->point }}">
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
                            <!-- <div class="attendance-header">
                                <span>No</span>
                                <span>Tanggal</span>
                                <span>Deskripsi</span>
                                <span>Batas</span>
                                <span>Status</span>
                                <span>Aksi</span>
                            </div> -->
                        </div>
                        @if (Request::is('guru/kelas/kehadiran*'))
                            {{-- <form class="attendance-form" action=""> --}}
                            {!! Form::model($objek, ['action' => $action, 'method' => $method, 'class' => 'attendance-form']) !!}
                                {!! Form::hidden('kelas_id', $kelas->id) !!}
                                <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>
            
                                <div class="date-input">
                                    <span class="start-input">
                                        <span class="label-section">Tanggal: </span>
                                        <input class="date" name="tanggal" type="datetime-local">
                                        <!-- <span class="placeholder">00 / 00 / 0000</span> -->
                                    </span>
                                    <span class="limit-input">
                                        <span class="label-section">Batas: </span>
                                        <input class="date" name="batas" type="datetime-local">
                                        <!-- <span class="placeholder">00 / 00 / 0000</span> -->
                                    </span>
                                </div>
                                <button type="submit" class="btn-section">Kirim</button>
                            {!! Form::close() !!}
                            {{-- </form> --}}
                        @endif
                    @endif

                    @if (Request::is('guru/kelas/edit-pertemuan*'))
                        {{-- <form class="attendance-form" action=""> --}}
                        {!! Form::model($objek, ['action' => $action, 'method' => $method, 'class' => 'attendance-form']) !!}
                            {!! Form::hidden('kelas_id', $kelas->id) !!}
                            <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi">{{ $objek->deskripsi }}</textarea>

                            <div class="date-input">
                                <span class="start-input">
                                    <span class="label-section">Tanggal: </span>
                                    <input class="date" name="tanggal" type="datetime-local" value="{{ $objek->tanggal }}">
                                    <!-- <span class="placeholder">00 / 00 / 0000</span> -->
                                </span>
                                <span class="limit-input">
                                    <span class="label-section">Batas: </span>
                                    <input class="date" name="batas" type="datetime-local" value="{{ $objek->batas }}">
                                    <!-- <span class="placeholder">00 / 00 / 0000</span> -->
                                </span>
                            </div>
                            <button type="submit" class="btn-section">Kirim</button>
                        {!! Form::close() !!}
                        {{-- </form> --}}
                    @endif
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