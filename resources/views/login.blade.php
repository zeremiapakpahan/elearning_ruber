<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUBER | GMEC</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('project') }}/css/style.css">

</head>
<body>

    {{-- Pesan Gagal --}}
    
    @if (Session::has('pesan'))
        <div class="failed">
            {!! Session::get('pesan') !!}
        </div>
	@endif

    {{-- Pesan Error --}}

    @if ($errors->any())
        @foreach ( $errors->all() as $error)
            <div class="error">{{ $error }}</div>    
        @endforeach
    @endif

    <div class="split-screen">
        <div class="left">
            <div class="mascot-login">
                <img src="{{ asset('project') }}/img/illustration2.png" alt="Mascot">
            </div>
        </div>
        <div class="right">
            <div class="form-container">
                @if (Request::is('login/guru'))
                    <h2>Login Guru</h2>
                @elseif (Request::is('login/siswa'))
                    <h2>Login Siswa</h2>
                @endif
                <div class="button-container">
                    <div id="btn"></div>
                    <button id="guru-btn" type="button" onclick="window.location.href='{{ url('login/guru') }}'" class="toggle-btn">Guru</button>
                    <button id="siswa-btn" type="button" onclick="window.location.href='{{ url('login/siswa') }}'"  class="toggle-btn">Siswa</button>
                </div>
                {{-- <form id="guru" class="form-group" action=""> --}}
                {!! Form::model($objek, ['action' => $action, 'method' => $method, 'class' => 'form-group']) !!}
                    <div class="input-group">
                        <input name="email" class="form-input" type="text">
                        <span></span>
                        <label class="input-label" for="email">Email</label>
                    </div>
                    
                    <div class="input-group">
                        <input name="password" class="form-input" type="password">
                        <span></span>
                        <label class="input-label" for="password">Password</label>
                    </div>

                    <div class="submit-container">
                        <button type="submit" class="submit-btn">Login</button>
                    </div>
                    <div class="signup-link">
                        @if (Request::is('login/guru'))
                            Belum punya akun? <a href="{{ url('register/guru') }}">Register</a>
                        @elseif (Request::is('login/siswa'))
                            Belum punya akun? <a href="{{ url('register/siswa') }}">Register</a>
                        @endif
                    </div>
                {!! Form::close() !!}
                {{-- </form> --}}
                {{-- <form id="siswa"  class="form-group" action="">
                    <div class="input-group">
                        <input name="email" class="form-input" type="email" required autofocus>
                        <span></span>
                        <label class="input-label" for="email">Email</label>
                    </div>
                    
                    <div class="input-group">
                        <input name="password" class="form-input" type="password" required autofocus>
                        <span></span>
                        <label class="input-label" for="password">Password</label>
                    </div>

                    <div class="submit-container">
                        <button type="submit" class="submit-btn">Login</button>
                    </div>
                    <div class="signup-link">
                        Belum punya akun? <a href="/layout/register.html">Register</a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('project') }}/js/jquery.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('project') }}/js/script.js"></script>
    
</body>
</html>