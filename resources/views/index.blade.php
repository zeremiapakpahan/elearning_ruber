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

    <!-- NavBar -->
    <nav>

        <!-- Logo -->
        <div class="logo" onclick="window.location.href='{{ url('/') }}'">
            <img src="{{ asset('project') }}/img/gmec.png" alt="Logo">
            <h2>RUBER</h2>
        </div>
        <!-- Akhir Logo -->

        <!-- Menu -->
        <ul>
            @if (\Auth::guard('guru')->check() || \Auth::guard('siswa')->check())
                
            @else
                <li class="register">
                    <a href="">Register</a>
                    <ul id="register" class="dropdown-menu">
                        <li><a href="{{ url('register/guru') }}">Guru</a></li>
                        <li><a href="{{ url('register/siswa') }}">Siswa</a></li>
                    </ul>
                </li>
                <li class="login">
                    <a href="">Login</a>
                    <ul id="login" class="dropdown-menu">
                        <li><a href="{{ url('login/guru') }}">Guru</a></li>
                        <li><a href="{{ url('login/siswa') }}">Siswa</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- Akhir Menu -->

        <!-- Hamburger Menu -->
        <div class="menu-toggle">
            <input type="checkbox">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <!-- Akhir Hamburger Menu -->

    </nav>
    <!-- Akhir NavBar-->

    <!-- Konten -->
    <div class="konten">
        <div>
            <h1> RUANG BELAJAR ONLINE </h1>
            <h2> SMPS <span>SINAR BIJAKSANA GUANG MING</span> </h2>
            <h5> Belajar Dimana Saja Tanpa Batasan Ruang Dan Waktu </h5>
        </div>
        
        <div class="mascot">
            <img src="{{ asset('project') }}/img/illustration.png" alt="Mascot">
        </div>
    </div>
    <!-- Akhir Konten -->

    <!-- jQuery -->
    <script src="{{ asset('project') }}/js/jquery.js"></script>

    <!-- Javascript -->
    <script src="{{ asset('project') }}/js/script.js"></script>

</body>
</html>