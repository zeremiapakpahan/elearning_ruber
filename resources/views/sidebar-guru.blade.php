<div class="sidebar">
    <div class="logo-content">
        <div class="logo" onclick="window.location.href='{{ url('/') }}'">
            <img src="{{ asset('project') }}/img/gmec.png" alt="Logo">
            <div class="logo-name">
                <h2>RUBER</h2>
            </div>
        </div>
        <i class="fa fa-bars" id="hide-btn"></i>
    </div>
    <ul class="nav-list">
        <li>
            <a class="{{ request()->is('guru/beranda') ? 'active-links' : '' }}" href="{{ url('guru/beranda') }}">
                <i class="fa fa-th-large"></i>
                <span class="links-name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a class="{{ request()->is('guru/kelas*') ? 'active-links' : '' }}" href="{{ url('guru/kelas') }}">
                <i class="fa fa-home"></i>
                <span class="links-name">Kelas</span>
            </a>
            <span class="tooltip">Kelas</span>
        </li>
        <li>
            <a class="{{ request()->is('guru/hasil-belajar-siswa*') ? 'active-links' : '' }}" href="{{ url('guru/hasil-belajar-siswa') }}">
                <i class="fa fa-book"></i>
                <span class="links-name">Hasil Belajar</span>
            </a>
            <span class="tooltip">Hasil Belajar</span>
        </li>
        <li>
            <a href="{{ url('guru/logout') }}">
                <i class="fa fa-sign-out-alt"></i>
                <span class="links-name">Logout</span>
            </a>
            <span class="tooltip">Sign Out</span>
        </li>
    </ul>
</div>
