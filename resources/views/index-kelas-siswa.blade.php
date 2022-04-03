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
    <div class="modal-background">
        <div class="modal-section">
            <div class="modal-header">
                <span>Konfirmasi</span>
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body">
                <span>APAKAH ANDA YAKIN AKAN MENGERJAKAN QUIZ?</span>
                <a href="" class="btn-section" id="qp" type="button">Ya</a>
                <a href="" class="btn-section" id="qe" type="button">Ya</a>
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
            <div class="post-container">

                @foreach ($penugasan as $penugasan)
                <div class="assignment-section" data-datetime="{{ $penugasan->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                    <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                    <!-- <a href=""> -->
                    @if ($penugasan->kelas->guru->foto != '')
                        <img class="as-photo" src="{{ \Storage::url($penugasan->kelas->guru->foto) }}" alt="Foto">
                    @else
                        <img class="as-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                    @endif
                    <!-- </a> -->

                    <span class="as-name"> {{ $penugasan->kelas->guru->nama }} </span>
                    <span>{{ $penugasan->kelas->guru->status }}</span>

                    <div class="assignment-header">
                        <h5 class="assignment-title">{{ $penugasan->judul }}</h5> 
                        <span class="post-type">-{{ $penugasan->tipe }}</span>
                    </div>

                    <p class="assignment-desc">
                        {{ $penugasan->deskripsi }}
                    </p>

                    <span class="file-container"> 
                        @foreach ($penugasan->fileTugas as $files)
                            <a id="file-link" href="{{ \Storage::url($files->nama_file) }}"><span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a>
                        @endforeach
                    </span>

                    <a href="{{ url('siswa/kelas/komentar-penugasan/'.$penugasan->id) }}">Komentar</a>

                    @if ($penugasan->prosesTugas->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <a href="{{ url('siswa/kelas/kumpulkan-tugas/'.$penugasan->id) }}" class="as-db">Lihat Hasil</a>
                    @elseif ($penugasan->prosesTugas->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '' && $penugasan->status == "Buka")
                    {{-- belom selesai jok --}}
                        <a href="{{ url('siswa/kelas/kumpulkan-tugas/'.$penugasan->id) }}" class="as-db">Kumpulkan</a>
                    @endif

                    @if ($penugasan->status == "Buka")
                        <span class="as-date"> {{ $penugasan->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($penugasan->batas)) }} </span>
                    @elseif ($penugasan->status == "Tutup" && $penugasan->prosesTugas->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <span class="as-date" style="transform: translate(-100px, -7px)"> {{ $penugasan->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($penugasan->batas)) }} </span> <span class="as-status">Tutup</span>
                    @elseif ($penugasan->status == "Tutup" && $penugasan->prosesTugas->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '')
                        <span class="as-date" style="transform: translate(-325px, -7px)"> {{ $penugasan->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($penugasan->batas)) }} </span> <span class="as-status">Tutup - Anda Terlambat Mengumpulkan Tugas</span>
                    @endif
                    
                </div>
            @endforeach

            @foreach ($informasi as $info)
                <div class="information-section" data-datetime="{{ $info->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                    <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                    <!-- <a href=""> -->
                    @if ($info->kelas->guru->foto != '')
                        <img class="is-photo" src="{{ \Storage::url($info->kelas->guru->foto) }}" alt="Foto">
                    @else
                        <img class="is-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                    @endif
                    <!-- </a> -->
                    
                    <span class="is-name"> {{ $info->kelas->guru->nama }} </span>
                    <span>{{ $info->kelas->guru->status }}</span>

                    <div class="information-header">
                        <h5 class="information-title">{{ $info->judul }}</h5> 
                        <span class="post-type">-{{ $info->tipe }}</span>
                    </div>

                    <p class="information-desc">
                        {{ $info->isi }}
                    </p>

                    <span class="file-container"> 
                        @foreach ($info->fileInfo as $files)
                            <a id="file-link" href="{{ \Storage::url($files->nama_file) }}" target="blank"> <span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a>
                        @endforeach
                    </span>

                    <a href="{{ url('siswa/kelas/komentar-informasi/'.$info->id) }}" class="is-db">Komentar</a>

                    <span> {{ $info->created_at->format('d M Y H:i') }} </span>
                </div>
            @endforeach

            @foreach ($quiz_pilgan as $qp)
                <div class="quiz-pilgan-section" data-datetime="{{ $qp->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                    <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                    <!-- <a href=""> -->
                    @if ($qp->kelas->guru->foto != '')
                        <img class="qps-photo" src="{{ \Storage::url($qp->kelas->guru->foto) }}" alt="Foto">
                    @else
                        <img class="qps-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                    @endif
                    <!-- </a> -->
                    <span class="qps-name"> {{ $qp->kelas->guru->nama }} </span>
                    <span>{{ $qp->kelas->guru->status }}</span>

                    <div class="quiz-pilgan-header">
                        <h5 class="quiz-pilgan-title">{{ $qp->judul }}</h5> 
                        <span class="post-type">-{{ $qp->tipe }}</span>
                    </div>

                    <p class="quiz-pilgan-desc">
                        {{ $qp->deskripsi }}
                    </p>

                    @if ($qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <a href="{{ url('siswa/kelas/quiz-pilgan/'.$qp->id) }}" class="qps-db-clone">Lihat Hasil</a>
                    @elseif ($qp->whQP->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <a href="{{ url('siswa/kelas/quiz-pilgan/'.$qp->id) }}" class="qps-db-clone">Lihat Hasil</a>
                    @elseif ($qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '' && $qp->status == "Buka")
                        <a href="{{ url('siswa/kelas/quiz-pilgan/'.$qp->id) }}" class="qps-db">Kerjakan</a>
                    @endif

                    @if ($qp->status == "Buka")
                        <span class="qps-date">  {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span>
                    @elseif ($qp->status== "Tutup" && $qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <span class="qps-date" style="transform: translate(-100px, -7px)">  {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span> <span class="qps-status">Tutup</span>
                    @elseif ($qp->status== "Tutup" && $qp->whQP->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <span class="qps-date" style="transform: translate(-100px, -7px)">  {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span> <span class="qps-status">Tutup</span>
                    @elseif ($qp->status== "Tutup" && $qp->quizPilgan[0]->prosesQuizPilgan->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '')
                        <span class="qps-date" style="transform: translate(-340px, -7px)">  {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span> <span class="qps-status">Tutup - Anda Terlambat Mengerjakan Quiz Pilgan</span>
                    @endif

                </div>
            @endforeach

            @foreach ($quiz_essay as $qe)
                <div class="quiz-essay-section" data-datetime="{{ $qe->created_at->format('d M Y H:i:s') }}" id="siswa-section">
                    <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                    <!-- <a href=""> -->
                    @if ($qe->kelas->guru->foto != '')
                        <img class="qes-photo" src="{{ \Storage::url($qe->kelas->guru->foto) }}" alt="Foto">
                    @else
                        <img class="qes-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                    @endif
                    <!-- </a> -->
                    <span class="qes-name"> {{ $qe->kelas->guru->nama }} </span>
                    <span>{{ $qe->kelas->guru->status }}</span>

                    <div class="quiz-essay-header">
                        <h5 class="quiz-essay-title">{{ $qe->judul }}</h5> 
                        <span class="post-type">-{{ $qe->tipe }}</span>
                    </div>

                    <p class="quiz-essay-desc">
                        {{ $qe->deskripsi }}
                    </p>

                    @if ($qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <a href="{{ url('siswa/kelas/quiz-essay/'.$qe->id) }}" class="qes-db-clone">Lihat Hasil</a>
                    @elseif ( $qe->whQe->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <a href="{{ url('siswa/kelas/quiz-essay/'.$qe->id) }}" class="qes-db-clone">Lihat Hasil</a>
                    @elseif ($qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '' && $qe->status == "Buka")
                        <a href="{{ url('siswa/kelas/quiz-essay/'.$qe->id) }}" class="qes-db">Kerjakan</a>
                    @endif

                    @if ($qe->status == "Buka")
                        <span class="qes-date">  {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span>
                    @elseif ($qe->status== "Tutup" && $qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <span class="qes-date" style="transform: translate(-100px, -7px)">  {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span> <span class="qes-status">Tutup</span>
                    @elseif ($qe->status== "Tutup" && $qe->whQe->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() != '')
                        <span class="qes-date" style="transform: translate(-100px, -7px)">  {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span> <span class="qes-status">Tutup</span>
                    @elseif ($qe->status== "Tutup" && $qe->quizEssay[0]->prosesQuizEssay->where('siswa_id', \Auth::guard('siswa')->user()->id)->first() == '')
                        <span class="qes-date" style="transform: translate(-340px, -7px)">  {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span> <span class="qes-status">Tutup - Anda Terlambat Mengerjakan Quiz Essay</span>
                    @endif
                    
                </div>
            @endforeach

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
    <script src="{{ asset('project') }}/js/script4.js"></script>
    <script src="{{ asset('project') }}/js/script6.js"></script>

</body>

</html>