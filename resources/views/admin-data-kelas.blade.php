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
                    <i class="fa fa-user-tie"></i>
                    <span class="links-name">Data Guru</span>
                </a>
                <span class="tooltip">Data Guru</span>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-user"></i>
                    <span class="links-name">Data Siswa</span>
                </a>
                <span class="tooltip">Data Siswa</span>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-home"></i>
                    <span class="links-name">Data Kelas</span>
                </a>
                <span class="tooltip">Data Kelas</span>
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

    @include('sidebar-admin')

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

        <div class="table-container">
            <h2>DAFTAR KELAS</h2>
            <h5>Matematika</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_mtk as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>IPA</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_ipa as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>IPS</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_ips as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>TIK</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_tik as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>SBK</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_sbk as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>English</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_english as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Mandarin</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_mandarin as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>PJOK</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_pjok as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Musik</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_musik as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Tipografi</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_tipografi as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Agama</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_agama as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Bahasa Indonesia</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_bahasa as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>PKN</h5>
            <table class="class-list" id="admin">
                <thead class="list-header">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="list-content">
                    @foreach ($kelas_pkn as $kelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>
                                <i class="fa fa-angle-down" id="drop"></i>
                                <button onclick="window.location.href='{{ url('admin/data-kelas/hapus/'.$kelas->id) }}'" type="button" class="btn-section">Hapus</button>
                            </td>
                        </tr>
                        <tr class="dropdown-row">
                            <td colspan="6">
                                <div class="dropdown-column">
                                    <div class="dropdown-list">
                                        
                                        <div class="class-profil">
                                            <span>Profil Kelas</span>
                                            <div class="profil-content">
                                                <img src="{{ asset('project') }}/img/pattern.png" alt="Pattern">
                                                <div class="text-data-section">
                                                    <span>{{ $kelas->nama_kelas }}</span>
                                                    <span>{{ $kelas->deskripsi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class-member">
                                            <span>Anggota Kelas</span>
                                            @foreach ($kelas->anggota->where('siswa_id', 0) as $guru)
                                                <div class="member-content">
                                                    @if ($guru->guru->foto != '')
                                                        <img src="{{ \Storage::url($guru->guru->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $guru->guru->nama }}</span>
                                                        <span>{{ $guru->guru->email }}</span>
                                                        <span>{{ $guru->guru->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach ($kelas->anggota->where('guru_id', 0) as $siswa)
                                                <div class="member-content">
                                                    @if ($siswa->siswa->foto != '')
                                                        <img src="{{ \Storage::url($siswa->siswa->foto) }}" alt="Foto">
                                                    @else
                                                        <img src="{{ asset('project') }}/img/avatar.jpg" alt="Foto">
                                                    @endif
                                                    <div class="text-data-section">
                                                        <span>{{ $siswa->siswa->nama }}</span>
                                                        <span>{{ $siswa->siswa->email }}</span>
                                                        <span>{{ $siswa->siswa->status }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        </div>
    </div> --}}

    @include('rightbar-admin')

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
                <span>zeremiakerene@gmail.com</span>
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
    <script src="{{ asset('project') }}/js/script4.js"></script>

</body>

</html>