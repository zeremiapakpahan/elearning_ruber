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
        
        @if (Request::is('guru/kelas/index*'))
            @include('kelas-menu-guru')
        @endif

        <div class="kelas-main-content">

            @if (Request::is('guru/kelas/index*'))
                {{-- <form class="form-information-section" action=""> --}}
                {!! Form::model($objek, ['action' => $action, 'method' => $method, 'files' => true, 'class' => 'form-information-section']) !!}
                    {{-- Kirim id kelas secara tersembunyi --}}
                    {!! Form::hidden('kelas_id', $kelas->id) !!}
                    <input class="input-section" name="judul" type="text" placeholder="Judul">
                    <textarea class="ta-section" name="isi" rows="3" placeholder="Isi"></textarea>

                    <!-- <span class="label-section">Batas: </span>
                    <input class="date" name="batas" type="date">
                    <span class="placeholder">00 / 00 / 0000</span> -->

                    <span class="file-input-value">
                        <span id="v1"></span>
                        <span id="v2"></span>
                        <span id="v3"></span>
                        <i class="fa fa-times-circle" id="rem-val1"></i>
                        <i class="fa fa-times-circle" id="rem-val2"></i>
                        <i class="fa fa-times-circle" id="rem-val3"></i>
                        {{-- jangan lupo dibaikin yang di atas --}}
                        <p id="vn"></p>
                    </span>

                    <i class="fa fa-paperclip"></i>
                    <span>
                        {{-- <input class="file-input" name="nama_file[]" type="file" multiple="true"> --}}
                        {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                    </span>
                    <button type="submit" class="btn-section">Kirim</button>
                {!! Form::close() !!}
                {{-- </form> --}}
            @endif

            @if (Request::is('guru/kelas/edit-informasi*'))
                {{-- <form class="form-information-section" action=""> --}}
                {!! Form::model($objek, ['action' => $action, 'method' => $method, 'files' => true, 'class' => 'form-information-section']) !!}
                    {{-- Kirim id kelas secara tersembunyi --}}
                    {!! Form::hidden('kelas_id', $kelas->id) !!}
                    <input class="input-section" name="judul" type="text" placeholder="Judul" value="{{ $objek->judul }}">
                    <textarea class="ta-section" name="isi" rows="3" placeholder="Isi">{{ $objek->isi }}</textarea>

                    <!-- <span class="label-section">Batas: </span>
                    <input class="date" name="batas" type="date">
                    <span class="placeholder">00 / 00 / 0000</span> -->

                    <span class="file-input-value">
                        <span id="v1"></span>
                        <span id="v2"></span>
                        <span id="v3"></span>
                        <i class="fa fa-times-circle" id="rem-val1"></i>
                        <i class="fa fa-times-circle" id="rem-val2"></i>
                        <i class="fa fa-times-circle" id="rem-val3"></i>
                        {{-- jangan lupo dibaikin yang di atas --}}
                        <p id="vn"></p>
                    </span>

                    <i class="fa fa-paperclip"></i>
                    <span>
                        {{-- <input class="file-input" name="nama_file[]" type="file" multiple="true"> --}}
                        {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                    </span>
                    <button type="submit" class="btn-section">Kirim</button>
                {!! Form::close() !!}
                {{-- </form> --}}
            @endif

            @if (Request::is('guru/kelas/index*'))
                {{-- <form class="form-assignment-section" action=""> --}}
                {!! Form::model($objek2, ['action' => $action2, 'method' => $method2, 'files' => true, 'class' => 'form-assignment-section']) !!}
                    {{-- Kirim id kelas secara tersembunyi --}}
                    {!! Form::hidden('kelas_id', $kelas->id) !!}
                    <input class="input-section" name="judul" type="text" placeholder="Judul">
                    <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>

                    <span class="label-section">Batas: </span>
                    <input class="date" name="batas" type="datetime-local">
                    <span class="placeholder">00 / 00 / 0000 &nbsp --.--</span>

                    <span class="file-input-value">
                        <span id="v1"></span>
                        <span id="v2"></span>
                        <span id="v3"></span>
                        <i class="fa fa-times-circle" id="rem-val1"></i>
                        <i class="fa fa-times-circle" id="rem-val2"></i>
                        <i class="fa fa-times-circle" id="rem-val3"></i>
                        <p id="vn"></p>
                    </span>

                    <i class="fa fa-paperclip"></i>
                    <span>
                        {{-- <input class="file-input" name="nama_file[]" type="file" multiple="true"> --}}
                        {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                    </span>
                    <button type="submit" class="btn-section">Kirim</button>
                {!! Form::close() !!}
                {{-- </form> --}}
            @endif

            @if (Request::is('guru/kelas/edit-penugasan*'))
                {{-- <form class="form-assignment-section" action=""> --}}
                {!! Form::model($objek2, ['action' => $action2, 'method' => $method2, 'files' => true, 'class' => 'form-assignment-section']) !!}
                    {{-- Kirim id kelas secara tersembunyi --}}
                    {!! Form::hidden('kelas_id', $kelas->id) !!}
                    <input class="input-section" name="judul" type="text" placeholder="Judul" value="{{ $objek2->judul }}">
                    <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi">{{ $objek2->deskripsi }}</textarea>

                    <span class="label-section">Batas: </span>
                    <input class="date" name="batas" type="datetime-local" value="{{ $objek2->batas }}">
                    <span class="placeholder">00 / 00 / 0000 &nbsp --.--</span>

                    <span class="file-input-value">
                        <span id="v1"></span>
                        <span id="v2"></span>
                        <span id="v3"></span>
                        <i class="fa fa-times-circle" id="rem-val1"></i>
                        <i class="fa fa-times-circle" id="rem-val2"></i>
                        <i class="fa fa-times-circle" id="rem-val3"></i>
                        <p id="vn"></p>
                    </span>

                    <i class="fa fa-paperclip"></i>
                    <span>
                        {{-- <input class="file-input" name="nama_file[]" type="file" multiple="true"> --}}
                        {!! Form::file('nama_file[]', ['multiple' => true, 'class' => 'file-input']) !!}
                    </span>
                    <button type="submit" class="btn-section">Kirim</button>
                {!! Form::close() !!}
                {{-- </form> --}}
            @endif
            
            @if (Request::is('guru/kelas/index*'))
                <div class="quiz-section">
                    {{-- <form class="quiz-pilgan" action=""> --}}
                    {!! Form::model($objek3, ['action' => $action3, 'method' => $method3, 'class' => 'quiz-pilgan' ]) !!}
                        {!! Form::hidden('kelas_id', $kelas->id) !!}
                        <input class="input-section" name="judul" type="text" placeholder="Judul">
                        <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>

                        <span class="label-section">Batas: </span>
                        <input class="date" name="batas" type="datetime-local">
                        <span class="placeholder">Durasi: </span>

                        <input class="time" name="time" type="text" placeholder="Menit">
                        {{-- pikirin lagi tentang waktu --}}

                        <div class="quiz-container">
                            <h3>Pertanyaan</h3>
                            <span ng-app="myApp" ng-controller="myCtrl" ng-click="myFunction" class="add-question">Tambah Pertanyaan <i class="fa fa-plus"></i> </span>
                            
                            <div class="quiz-group">
                                <span class="question"> <span class="number">1.</span>  <textarea class="ta-section" name="pertanyaan[]" rows="3" cols="80" placeholder="Pertanyaan"></textarea>  </span>

                                <h3>Pilihan</h3>

                                <div class="choice-group">
                                    <span class="choice"> <span class="alpha">A.</span> <textarea class="ta-section" name="pilihan_1[]" placeholder="Pilihan 1"></textarea>  </span>
                                    <span class="true"><input type="checkbox" name="pilihan[]" value="" ></span>
                                </div>
                                <div class="choice-group">
                                    <span class="choice"> <span class="alpha">B.</span> <textarea class="ta-section" name="pilihan_2[]" placeholder="Pilihan 2"></textarea>  </span>
                                    <span class="true"><input type="checkbox" name="pilihan[]" value="" ></span>
                                </div>
                                <div class="choice-group">
                                    <span class="choice"> <span class="alpha">C.</span> <textarea class="ta-section" name="pilihan_3[]" placeholder="Pilihan 3"></textarea> </span>
                                    <span class="true"><input type="checkbox" name="pilihan[]" value="" ></span>
                                </div>
                                <div class="choice-group">
                                    <span class="choice"> <span class="alpha">D.</span> <textarea class="ta-section" name="pilihan_4[]" placeholder="Pilihan 4"></textarea> </span>
                                    <span class="true"><input type="checkbox" name="pilihan[]" value="" ></span>
                                </div>

                                <span class="point">   <input class="input-section" name="point[]" type="text" placeholder="Point"> </span>
                                <span class="delete"><i class="fa fa-trash"></i> Hapus</span>
                            </div>

                            <div class="btn-group">
                                <button class="btn-section" type="button">Kosong</button>
                                <button type="submit" class="btn-section">Kirim</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    {{-- </form> --}}
                </div>
            @endif

            @if (Request::is('guru/kelas/edit-quiz-pilgan*'))
                <div class="quiz-section">
                    {{-- <form class="quiz-pilgan" action=""> --}}
                    {!! Form::model($objek3, ['action' => $action3, 'method' => $method3, 'class' => 'quiz-pilgan' ]) !!}
                        {!! Form::hidden('kelas_id', $kelas->id) !!}
                        <input class="input-section" name="judul" type="text" placeholder="Judul" value="{{ $objek3->judul }}">
                        <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi">{{ $objek3->deskripsi }}</textarea>

                        <span class="label-section">Batas: </span>
                        <input class="date" name="batas" type="datetime-local" value="{{ $objek3->batas }}">
                        <span class="placeholder">Durasi: </span>

                        <input class="time" name="time" type="text" placeholder="Menit" value="{{ $objek3->time }}">
                        {{-- pikirin lagi tentang waktu --}}

                        <div class="quiz-container">
                            <h3>Pertanyaan</h3>
                            {{-- <span class="add-question">Tambah Pertanyaan <i class="fa fa-plus"></i> </span> --}}
                            
                            @foreach ($objek3->quizPilgan as $soal)
                                <div class="quiz-group">
                                    <span class="question"> <span class="number">{{ $loop->iteration }}.</span>  <textarea class="ta-section" name="pertanyaan[]" rows="3" cols="80" placeholder="Pertanyaan">{{ $soal->pertanyaan }}</textarea>  </span>

                                    <h3>Pilihan</h3>

                                    <div class="choice-group">
                                        <span class="choice"> <span class="alpha">A.</span> <textarea class="ta-section" name="pilihan_1[]" placeholder="Pilihan 1">{{ $soal->pilihan_1 }}</textarea>  </span>
                                        <span class="true"><input type="checkbox" name="pilihan[]" value="{{ $soal->jawabanBenar->pilihan }}" ></span>
                                    </div>
                                    <div class="choice-group">
                                        <span class="choice"> <span class="alpha">B.</span> <textarea class="ta-section" name="pilihan_2[]" placeholder="Pilihan 2">{{ $soal->pilihan_2 }}</textarea>  </span>
                                        <span class="true"><input type="checkbox" name="pilihan[]" value="{{ $soal->jawabanBenar->pilihan }}" ></span>
                                    </div>
                                    <div class="choice-group">
                                        <span class="choice"> <span class="alpha">C.</span> <textarea class="ta-section" name="pilihan_3[]" placeholder="Pilihan 3">{{ $soal->pilihan_3 }}</textarea> </span>
                                        <span class="true"><input type="checkbox" name="pilihan[]" value="{{ $soal->jawabanBenar->pilihan }}" ></span>
                                    </div>
                                    <div class="choice-group">
                                        <span class="choice"> <span class="alpha">D.</span> <textarea class="ta-section" name="pilihan_4[]" placeholder="Pilihan 4">{{ $soal->pilihan_4 }}</textarea> </span>
                                        <span class="true"><input type="checkbox" name="pilihan[]" value="{{ $soal->jawabanBenar->pilihan }}" ></span>
                                    </div>

                                    <span class="point">   <input class="input-section" name="point[]" type="text" placeholder="Point" value="{{ $soal->jawabanBenar->point }}"> </span>
                                    
                                </div>
                            @endforeach

                            <div class="btn-group">
                                
                                <button type="submit" class="btn-section">Kirim</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    {{-- </form> --}}
                </div>
            @endif


            @if (Request::is('guru/kelas/index*'))
                <div class="quiz-section">
                    {{-- <form class="quiz-essay" action=""> --}}
                    {!! Form::model($objek4, ['action' => $action4, 'method' => $method4, 'class' => 'quiz-essay']) !!}
                        {!! Form::hidden('kelas_id', $kelas->id) !!}
                        <input class="input-section" name="judul" type="text" placeholder="Judul">
                        <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>

                        <span class="label-section">Batas: </span>
                        <input class="date" name="batas" type="datetime-local">
                        <span class="placeholder">Durasi: </span>

                        <input class="time" name="time" type="text" placeholder="Menit">
                        <!-- <input class="date" name="batas" type="datetime"> -->

                        <div class="quiz-container">
                            <h3>Pertanyaan</h3>
                            <span class="add-question">Tambah Pertanyaan <i class="fa fa-plus"></i> </span>

                            <div class="quiz-group">
                                <span class="question"> <span class="number">1.</span>  <textarea class="ta-section" name="pertanyaan[]" rows="3" cols="80" placeholder="Pertanyaan"></textarea>  </span>
                                
                                <span class="point">   <input class="input-section" name="point[]" type="text" placeholder="Point"> </span>
                                <span class="delete"><i class="fa fa-trash"></i> Hapus</span>
                            </div>

                            <div class="btn-group">
                                <button class="btn-section" type="button">Kosong</button>
                                <button type="submit" class="btn-section">Kirim</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    {{-- </form> --}}
                </div>
            @endif

            @if (Request::is('guru/kelas/edit-quiz-essay*'))
                <div class="quiz-section">
                    {{-- <form class="quiz-essay" action=""> --}}
                    {!! Form::model($objek4, ['action' => $action4, 'method' => $method4, 'class' => 'quiz-essay']) !!}
                        {!! Form::hidden('kelas_id', $kelas->id) !!}
                        <input class="input-section" name="judul" type="text" placeholder="Judul" value="{{ $objek4->judul }}">
                        <textarea class="ta-section" name="deskripsi" rows="3" placeholder="Deskripsi">{{ $objek4->deskripsi }}</textarea>

                        <span class="label-section">Batas: </span>
                        <input class="date" name="batas" type="datetime-local" value="{{ $objek4->batas }}">
                        <span class="placeholder">Durasi: </span>

                        <input class="time" name="time" type="text" placeholder="Menit" value="{{ $objek4->time }}">
                        <!-- <input class="date" name="batas" type="datetime"> -->

                        <div class="quiz-container">
                            <h3>Pertanyaan</h3>
                            

                            @foreach ($objek4->quizEssay as $soal)
                                <div class="quiz-group">
                                    <span class="question"> <span class="number">{{ $loop->iteration }}.</span>  <textarea class="ta-section" name="pertanyaan[]" rows="3" cols="80" placeholder="Pertanyaan">{{ $soal->pertanyaan }}</textarea>  </span>
                                    
                                    <span class="point">   <input class="input-section" name="point[]" type="text" placeholder="Point" value="{{ $soal->point }}"> </span>
                                    
                                </div>
                            @endforeach

                            <div class="btn-group">
                                
                                <button type="submit" class="btn-section">Kirim</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    {{-- </form> --}}
                </div>
            @endif

            @if (Request::is('guru/kelas/index*'))
                <div class="pagination">
                    <i class="fa fa-circle pg1 active-links"></i>
                    <span class="ipg1" >Informasi</span>
                    <i class="fa fa-circle pg2"></i>
                    <span class="ipg2" >Penugasan</span>
                    <i class="fa fa-circle pg3"></i>
                    <span class="ipg3" >Quiz Pilgan</span>
                    <i class="fa fa-circle pg4"></i>
                    <span class="ipg4" >Quiz Essay</span>
                </div>
            @endif
            
            @if (Request::is('guru/kelas/index*'))
                <div class="post-container">
                    @foreach ($penugasan as $penugasan )
                    <div class="assignment-section" data-datetime="{{ $penugasan->created_at->format('d M Y H:i:s') }}" id="guru-section">
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

                        <a href="{{ url('guru/kelas/edit-penugasan/'.$penugasan->id) }}"><i class="fa fa-pen"></i></a>
                        <a href="{{ url('guru/kelas/hapus-penugasan/'.$penugasan->id) }}"><i class="fa fa-trash"></i></a>

                        <div class="assignment-header">
                            <h5 class="assignment-title">{{ $penugasan->judul }}</h5> 
                            <span class="post-type">-{{ $penugasan->tipe }}</span>
                        </div>

                        <p class="assignment-desc">
                            {{ $penugasan->deskripsi }}
                        </p>

                        <span class="file-container"> 
                            @foreach ($penugasan->fileTugas as $files)
                                <a id="file-link" href="{{ \Storage::url($files->nama_file) }}" target="blank"><span id="file-image-container"></span> <span>{{ $files->nama_file }}</span></a> 
                            @endforeach
                        </span>

                        <span>Yang Mengumpulkan: <p>{{ count($penugasan->prosesTugas) }}</p> </span>
                        <span>Komentar: <p>{{ count($penugasan->komentarTugas) }}</p> </span>

                        <a href="{{ url('guru/kelas/penugasan/'.$penugasan->id) }}" class="as-db">Detail</a>

                        @if ($penugasan->status == "Buka")
                            <span> {{ $penugasan->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($penugasan->batas)) }} </span>
                        @elseif ($penugasan->status == "Tutup")
                            <span style="transform: translateX(-120px)"> {{ $penugasan->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($penugasan->batas)) }} </span> <a href="{{ url('guru/kelas/buka-penugasan/'.$penugasan->id) }}" class="as-ocb">Buka</a>
                        @endif
                    </div>
                @endforeach

                @foreach ($informasi as $info )
                    <div class="information-section" data-datetime="{{ $info->created_at->format('d M Y H:i:s') }}" id="guru-section">
                        <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                        <!-- <a href=""> -->
                        @if ($info->kelas->guru->foto != '')
                            <img class="as-photo" src="{{ \Storage::url($info->kelas->guru->foto) }}" alt="Foto">
                        @else
                            <img class="as-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                        @endif
                        <!-- </a> -->
                        <span class="is-name"> {{ $info->kelas->guru->nama }} </span>
                        <span>{{ $info->kelas->guru->status }}</span>

                        <a href="{{ url('guru/kelas/edit-informasi/'.$info->id)  }}"><i class="fa fa-pen"></i></a>
                        <a href="{{ url('guru/kelas/hapus-informasi/'.$info->id) }}"><i class="fa fa-trash"></i></a>

                        <div class="information-header">
                            <h5 class="information-title">{{ $info->judul }}</h5> 
                            <span class="post-type">-{{ $info->tipe }}</span>
                        </div>

                        <p class="information-desc">
                            {{ $info->isi }}
                        </p>

                        <span class="file-container"> 
                            @foreach ($info->fileInfo as $files)
                                <a id="file-link" href="{{ \Storage::url($files->nama_file) }}" target="blank"><span id="file-image-container"></span> <span>{{ $files->nama_file }}</span> </a> 
                            @endforeach
                        </span>

                        <span>Komentar: <p>{{ count($info->komentarInfo) }}</p> </span>

                        <a href="{{ url('guru/kelas/informasi/'.$info->id) }}" class="is-db">Detail</a>

                        <span>{{ $info->created_at->format('d M Y H:i') }}</span>
                    </div>
                @endforeach

                @foreach ($quiz_pilgan as $qp)
                    <div class="quiz-pilgan-section" data-datetime="{{ $qp->created_at->format('d M Y H:i:s') }}" id="guru-section">
                        <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                        <!-- <a href=""> -->
                        @if ($qp->kelas->guru->foto != '')
                            <img class="as-photo" src="{{ \Storage::url($qp->kelas->guru->foto) }}" alt="Foto">
                        @else
                            <img class="as-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                        @endif
                        <!-- </a> -->
                        <span class="qps-name"> {{ $qp->kelas->guru->nama }} </span>
                        <span>{{ $qp->kelas->guru->status }}</span>

                        <a href="{{ url('guru/kelas/edit-quiz-pilgan/'.$qp->id) }}"><i class="fa fa-pen"></i></a>
                        <a href="{{ url('guru/kelas/hapus-quiz-pilgan/'.$qp->id) }}"><i class="fa fa-trash"></i></a>

                        <div class="quiz-pilgan-header">
                            <h5 class="quiz-pilgan-title">{{ $qp->judul }}</h5> 
                            <span class="post-type">-{{ $qp->tipe }}</span>
                        </div>

                        <p class="quiz-pilgan-desc">
                            {{ $qp->deskripsi }}
                        </p>

                        <span>Yang Mengerjakan: <p>{{ count($qp->quizPilgan[0]->prosesQuizPilgan) }}</p> </span>

                        <a href="{{ url('guru/kelas/quiz-pilgan/'.$qp->id) }}" class="qps-db">Detail</a>

                        @if ($qp->status == "Buka")
                            <span> {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span>
                        @elseif ($qp->status == "Tutup")
                            <span style="transform: translateX(-120px)"> {{ $qp->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qp->batas)) }} </span> <a href="{{ url('guru/kelas/buka-quiz-pilgan/'.$qp->id) }}" class="as-ocb">Buka</a>
                        @endif
                    </div>
                @endforeach

                @foreach ($quiz_essay as $qe)
                    <div class="quiz-essay-section" data-datetime="{{ $qe->created_at->format('d M Y H:i:s') }}" id="guru-section">
                        <img class="pattern" src="{{ asset('project') }}/img/pattern2.png" alt="Pattern">

                        <!-- <a href=""> -->
                        @if ($qe->kelas->guru->foto != '')
                            <img class="as-photo" src="{{ \Storage::url($qe->kelas->guru->foto) }}" alt="Foto">
                        @else
                            <img class="as-photo" src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                        @endif
                        <!-- </a> -->
                        <span class="qes-name"> {{ $qe->kelas->guru->nama }} </span>
                        <span>{{ $qe->kelas->guru->status }}</span>

                        <a href="{{ url('guru/kelas/edit-quiz-essay/'.$qe->id) }}"><i class="fa fa-pen"></i></a>
                        <a href="{{ url('guru/kelas/hapus-quiz-essay/'.$qe->id) }}"><i class="fa fa-trash"></i></a>

                        <div class="quiz-essay-header">
                            <h5 class="quiz-essay-title">{{ $qe->judul }}</h5> 
                            <span class="post-type">-{{ $qe->tipe }}</span>
                        </div>

                        <p class="quiz-essay-desc">
                            {{ $qe->deskripsi }}
                        </p>

                        <span>Yang Mengerjakan: <p>{{ count($qe->quizEssay[0]->prosesQuizEssay) }}</p> </span>

                        <a href="{{ url('guru/kelas/quiz-essay/'.$qe->id) }}" class="qes-db">Detail</a>

                        @if ($qe->status == "Buka")
                            <span> {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span>
                        @elseif ($qe->status == "Tutup")
                            <span style="transform: translateX(-120px)"> {{ $qe->created_at->format('d M Y H:i') }} - {{ date('d M Y H:i', strtotime($qe->batas)) }} </span> <a href="{{ url('guru/kelas/buka-quiz-essay/'.$qe->id) }}" class="as-ocb">Buka</a>
                        @endif
                    </div>
                @endforeach

                </div>
                
            @endif
            
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

    {{-- AngularJS --}}
    <script src="{{ asset('project') }}/js/angular.min.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('project') }}/js/script.js"></script>
    <script src="{{ asset('project') }}/js/script2.js"></script>
    <script src="{{ asset('project') }}/js/script4.js"></script>
    <script src="{{ asset('project') }}/js/script6.js"></script>

</body>

</html>