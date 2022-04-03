<div class="right-sidebar">
    <div class="profil">
        <div class="profil-image">
            @if (\Auth::guard('guru')->user()->foto != '')
                <img src="{{ \Storage::url(\Auth::guard('guru')->user()->foto) }}" alt="Profil" id="profil-img">
            @else
                <img src="{{ asset('project') }}/img/avatar.jpg" alt="Profil" id="profil-img">
            @endif
            {{-- <form id="form" action=""> --}}
            {!! Form::model($objek_profil, ['action' => $action_profil, 'method' => $method_profil, 'files' => true, 'id' => 'form']) !!}
                {{-- <input name="foto" type="file" class="img-input" id="file-upload"> --}}
                {!! Form::file('foto', ['class' => 'img-input', 'id' => 'file-upload']) !!}
            {!! Form::close() !!}
            {{-- </form> --}}
            <i class="fa fa-camera"></i>
        </div>
        <div class="form-edit-container">
            {{-- <form class="form-edit" action=""> --}}
            {!! Form::model($objek_profil, ['action' => $action_profil, 'method' => $method_profil, 'class' => 'form-edit']) !!}
                <input name="nama" type="text" value="{{ $objek_profil->nama }}" >
                <input name="email" type="text" value="{{ $objek_profil->email }}" >
                <input name="password" type="password" value="" placeholder="Isi password lama/baru">
                <button type="submit" class="simpan-btn">Simpan</button>
            {!! Form::close() !!}
            {{-- </form> --}}
        </div>
        <div class="bio">
            <span class="nama-lengkap">{{ \Auth::guard('guru')->user()->nama }}</span>
            <span>{{ \Auth::guard('guru')->user()->email }}</span>
            <span>{{ \Auth::guard('guru')->user()->status }}</span>
        </div>
        <span class="edit-profil">
            <i id="edit-link" class="fa fa-edit"></i>
        </span>
    </div>
    <div class="separator">
        <hr>
    </div>
    {{-- <div class="notif">
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
    </div> --}}
</div>