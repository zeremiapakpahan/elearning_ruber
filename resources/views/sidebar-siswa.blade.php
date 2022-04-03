<div class="sidebar">
    <div class="logo-content">
        <div class="logo"  onclick="window.location.href='{{ url('/') }}'">
            <img src="{{ asset('project') }}/img/gmec.png" alt="Logo">
            <div class="logo-name">
                <h2>RUBER</h2>
            </div>
        </div>
        <i class="fa fa-bars" id="hide-btn"></i>
    </div>
    <ul class="nav-list">
        <li>
            <a class="{{ request()->is('siswa/beranda') ? 'active-links' : '' }}" href="{{ url('siswa/beranda') }}">
                <i class="fa fa-th-large"></i>
                <span class="links-name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a class="{{ request()->is('siswa/kelas*') ? 'active-links' : '' }}" href="{{ url('siswa/kelas') }}">
                <i class="fa fa-home"></i>
                <span class="links-name">Kelas</span>
            </a>
            <span class="tooltip">Kelas</span>
        </li>
        <li>
            <a href="{{ url('siswa/logout') }}">
                <i class="fa fa-sign-out-alt"></i>
                <span class="links-name">Logout</span>
            </a>
            <span class="tooltip">Sign Out</span>
        </li>
    </ul>
</div>