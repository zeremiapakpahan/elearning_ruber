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
        
        <div class="kelas-main-content">
            <div class="assignment-comment">
                <div class="comment-section">
                    
                    @if (Request::is('siswa/kelas/komentar-penugasan*'))

                        <div class="comment-container">
                        @foreach ($komen_guru as $komen)
                            <!-- Guru -->
                            <div class="comment-row" data-datetime="{{ $komen->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                                <div class="comment-header">
                                    @if ($komen->guru->foto != '')
                                        <img src="{{ \Storage::url($komen->guru->foto) }}" alt="Foto">
                                    @else
                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                    @endif
                                    <div class="comment-identity">
                                        <span>{{ $komen->guru->nama }}</span>
                                        <span>{{ $komen->guru->status }}</span>
                                    </div>
                                    
                                </div>
                                <div class="comment-content">
                                    <!-- isi -->
                                    {{ $komen->isi }}

                                    <!-- Nama File -->
                                    <span class="comment-file">  
                                        @foreach ($komen->fileKomenTugas as $files)
                                            <a id="file-link" href="{{ \Storage::url($files->nama_file) }}"> <span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a>
                                        @endforeach
                                    </span>
                                </div>
                                <span class="comment-datetime">
                                    {{ $komen->created_at->format('d M Y H:i') }}
                                </span>
                            </div>
                            <!-- Guru -->
                        @endforeach

                        @foreach ($komen_siswa as $komen)
                            <!-- Siswa Lain -->
                            <div class="comment-row" data-datetime="{{ $komen->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                                <div class="comment-header">
                                    @if ($komen->siswa->foto != '')
                                        <img src="{{ \Storage::url($komen->siswa->foto) }}" alt="Foto">
                                    @else
                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                    @endif
                                    <div class="comment-identity">
                                        <span>{{ $komen->siswa->nama }}</span>
                                        <span>{{ $komen->siswa->status }}</span>
                                    </div>
                                    
                                </div>
                                <div class="comment-content">
                                    <!-- isi -->
                                    {{ $komen->isi }}

                                    <!-- Nama File -->
                                    <span class="comment-file">  
                                        @foreach ($komen->fileKomenTugas as $files)
                                            <a id="file-link" href="{{ \Storage::url($files->nama_file) }}"> <span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a>
                                        @endforeach
                                    </span>
                                </div>
                                <span class="comment-datetime">
                                    {{ $komen->created_at->format('d M Y H:i') }}
                                </span>
                            </div>
                            <!-- Siswa Lain -->
                        @endforeach

                        @foreach ($komen_pribadi as $komen)

                            <!-- Siswa -->
                            <div class="comment-row" data-datetime="{{ $komen->created_at->format('d M Y H:i:s') }}" id="guru-section">
                                <div class="comment-header">
                                    @if ($komen->siswa->foto != '')
                                        <img src="{{ \Storage::url($komen->siswa->foto) }}" alt="Foto">
                                    @else
                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                    @endif
                                    <div class="comment-identity">
                                        <span>{{ $komen->siswa->nama }}</span>
                                        <span>{{ $komen->siswa->status }}</span>
                                    </div>
                                    <span onclick="window.location.href='{{ url('siswa/kelas/edit-komentar-tugas/'.$komen->id) }}'"><i class="fa fa-pen"></i> Edit </span>
                                    <span onclick="window.location.href='{{ url('siswa/kelas/hapus-komentar-tugas/'.$komen->id) }}'"><i class="fa fa-trash"></i> Hapus </span>
                                </div>
                                <div class="comment-content">
                                    {{ $komen->isi }}
                                    
                                    <span class="comment-file">  
                                        @foreach ($komen->fileKomenTugas as $files)
                                            <a id="file-link" href="{{ \Storage::url($files->nama_file) }}"> <span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a>
                                        @endforeach
                                    </span>
                                </div>
                                <span class="comment-datetime">
                                    {{ $komen->created_at->format('d M Y H:i') }}
                                </span>
                            </div>
                            <!-- Siswa -->

                        @endforeach
                        </div>

                        <span class="next-btn">
                            <button type="button"> 
                                Selanjutnya...
                            </button>
                        </span>
                        <span class="comment-total">
                            Komentar: <p></p>
                        </span>
                        {{-- <form class="comment-form" action=""> --}}
                        {!! Form::model($objek, ['action' => $action, 'method' => $method, 'files' => true, 'class' => 'comment-form']) !!}
                            {!! Form::hidden('tugas_id', $penugasan->id) !!}
                            <textarea class="ta-section" name="isi" rows="3" placeholder="Komentar"></textarea>
                            
                            <span class="comment-file-input">
                                <i class="fa fa-paperclip"></i>
                                {{-- <input class="file-input" name="nama_file" type="file" multiple="true"> --}}
                                {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                                <span class="file-input-value">
                                    <span id="v1"></span>
                                    <span id="v2"></span>
                                    <span id="v3"></span>
                                    <i class="fa fa-times-circle" id="rem-val1"></i>
                                    <i class="fa fa-times-circle" id="rem-val2"></i>
                                    <i class="fa fa-times-circle" id="rem-val3"></i>
                                    <p id="vn"></p>
                                </span>
                            </span>
                            <button type="submit" class="btn-section">Kirim</button>
                        {!! Form::close() !!}
                        {{-- </form> --}}

                    @endif

                    @if (Request::is('siswa/kelas/edit-komentar-tugas*'))
                        {{-- <form class="comment-form" action=""> --}}
                        {!! Form::model($objek, ['action' => $action, 'method' => $method, 'files' => true, 'class' => 'comment-form']) !!}
                            {!! Form::hidden('tugas_id', $penugasan->id) !!}
                            <textarea class="ta-section" name="isi" rows="3" placeholder="Komentar">{{ $objek->isi }}</textarea>
                            
                            <span class="comment-file-input">
                                <i class="fa fa-paperclip"></i>
                                {{-- <input class="file-input" name="nama_file" type="file" multiple="true"> --}}
                                {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                                <span class="file-input-value">
                                    <span id="v1"></span>
                                    <span id="v2"></span>
                                    <span id="v3"></span>
                                    <i class="fa fa-times-circle" id="rem-val1"></i>
                                    <i class="fa fa-times-circle" id="rem-val2"></i>
                                    <i class="fa fa-times-circle" id="rem-val3"></i>
                                    <p id="vn"></p>
                                </span>
                            </span>
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