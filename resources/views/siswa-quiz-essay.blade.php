<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUBER | GMEC </title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('project') }}/css/style.css">

    {{-- CSS Countdown --}}
    {{-- <link rel="stylesheet" href="{{ asset('project') }}/css/jquery.countdown.css"> --}}

    <!-- CSS Khusus  -->
    <link rel="stylesheet" href="{{ asset('project') }}/css/style-khusus.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('project') }}/font/font/css/all.css">

</head>

<body>

    <!-- Sidebar -->

    <div class="modal-background">
        <div class="modal-section">
            <div class="modal-header">
                <span>Konfirmasi</span>
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body">
                <span>APAKAH ANDA YAKIN AKAN MENYELESAIKAN QUIZ?</span>
                <button type="button" class="btn-section" id="submit">Ya</button>
                <button type="button" class="btn-section" id="yes">Ya</button>
                <button type="button" class="btn-section" id="no">Tutup</button>
            </div>
        </div>
    </div>

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
        
        <div class="kelas-main-content">
            {!! Form::hidden('kelas_id', $kelas->id, ['class' => 'hidden']) !!}
            <div class="quiz-essay-page">
                @if ($proses == '' && $whqe == '')
                    <div class="question-section">
                        <div class="qs-header">
                            <h3>QUIZ ESSAY</h3>
                            <span>{{ $times_up }}</span>
                            {{-- <span class="countdown"> --}}
                            {!! Form::model($objek2, ['action' => $action2, 'method' => $method2, 'class' => 'countdown' ]) !!}
                                {!! Form::hidden('quiz_id', $quiz->id) !!}
                                {{-- <span class="h"></span>
                                <span class="sep">:</span>
                                <span class="m"></span>
                                <span class="sep">:</span>
                                <span class="s"></span> --}}
                                <span class="full-time"></span>
                            {!! Form::close() !!}
                            {{-- </span> --}}
                        </div>
                        <div class="qs-content">
                            {{-- <form action=""> --}}
                            {!! Form::model($objek, ['action' => $action, 'method' => $method]) !!}
                                @foreach ($quiz->quizEssay as $qe)
                                    {!! Form::hidden('quiz_essay_id[]', $qe->id) !!}
                                    <div class="qs-row">
                                        <span class="qs-question">
                                            <span>{{ $loop->iteration }}.</span>
                                            <span>{{ $qe->pertanyaan }}</span>
                                        </span>
                                        <div class="qs-answer">
                                            <textarea class="ta-section" name="jawaban[]" rows="3" placeholder="Jawaban"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <span>
                                    <button type="button" class="btn-section">Kirim</button>
                                </span>
                            {!! Form::close() !!}
                            {{-- </form> --}}
                        </div>
                    </div>
                @endif
                
                @if ($proses == '' && $whqe != '')
                    <div class="qp-notice">
                        <img src="/img/sad.jpg" alt="Foto">
                        <span>ANDA TIDAK MEMILIKI NILAI QUIZ!</span>
                    </div>
                @endif

                @if ($proses != '')
                    <div class="grade-section">
                        <span class="grade-header">
                            <h3>HASIL QUIZ ESSAY SISWA</h3>
                            <span>
                                @if ($proses->hasilQuizEssay == '')
                                    (Menunggu Penilaian)
                                @endif
                            </span>
                        </span>
                        <div class="grade-row">
                            <span>{{ $proses->quizEssay->quiz->judul }}</span>
                            <div class="s-identity">
                                <span class="tag">Nama <p>:</p></span>
                                <span>{{ $proses->siswa->nama }}</span>
                            </div>
                            <span class="grade">
                                <span class="tag">Nilai <p>:</p></span>
                                <span>
                                    @if ($proses->hasilQuizEssay != '')
                                        {{ $proses->hasilQuizEssay->nilai_total }}
                                    @endif
                                </span>
                            </span>
                            <span>Hasil Quiz</span>
                        </div>
                    </div>
                    <div class="qe-preview-section">
                        @foreach ($quiz->quizEssay as $qe)
                            <div class="question-row">
                                <span class="question">
                                    <span> {{ $loop->iteration }}.</span>
                                    <span>{{ $qe->pertanyaan }}</span>
                                </span>
                                <span class="answer">
                                    <span>
                                        {{ $qe->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->jawaban }}
                                    </span>
                                </span>
                                <span class="point" > 
                                    <span class="grade">
                                        <span class="tag">Point <p>:</p></span>
                                        <span>{{ $qe->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first()->nilai }}</span>
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
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

    {{-- jQuery Countdown Plugin --}}
    <script src="{{ asset('project') }}/js/jquery.plugin.js"></script>

    {{-- jQuery Countdown --}}
    <script src="{{ asset('project') }}/js/jquery.countdown.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('project') }}/js/script.js"></script>
    <script src="{{ asset('project') }}/js/script2.js"></script>
    <!-- <script src="/js/script3.js"></script> -->
    <script src="{{ asset('project') }}/js/script5.js"></script>
    <!-- <script src="/js/script6.js"></script> -->

</body>

</html>