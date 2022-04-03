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
                <a class="{{ request()->is('admin/beranda') ? 'active-links' : '' }}" href="{{ url('admin/beranda') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="links-name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a class="{{ request()->is('admin/data-guru') ? 'active-links' : '' }}" href="{{ url('admin/data-guru') }}">
                    <i class="fa fa-user-tie"></i>
                    <span class="links-name">Data Guru</span>
                </a>
                <span class="tooltip">Data Guru</span>
            </li>
            <li>
                <a class="{{ request()->is('admin/data-siswa') ? 'active-links' : '' }}" href="{{ url('admin/data-siswa') }}">
                    <i class="fa fa-user"></i>
                    <span class="links-name">Data Siswa</span>
                </a>
                <span class="tooltip">Data Siswa</span>
            </li>
            <li>
                <a class="{{ request()->is('admin/data-kelas') ? 'active-links' : '' }}" href="{{ url('admin/data-kelas') }}">
                    <i class="fa fa-home"></i>
                    <span class="links-name">Data Kelas</span>
                </a>
                <span class="tooltip">Data Kelas</span>
            </li>
            <li>
                <a href="{{ url('admin/logout') }}">
                    <i class="fa fa-sign-out-alt"></i>
                    <span class="links-name">Logout</span>
                </a>
                <span class="tooltip">Sign Out</span>
            </li>
        </ul>
    </div>