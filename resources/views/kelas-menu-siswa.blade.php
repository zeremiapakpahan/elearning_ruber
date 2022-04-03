<div class="kelas-menu">
    <ul class="menu-container">
        <li><a class="{{ request()->is('siswa/kelas/index*') ? 'active-links' : '' }}" href="{{ url('siswa/kelas/index/'.$kelas->id) }}">TIMELINE</a></li>
        <li><a class="{{ request()->is('siswa/kelas/kehadiran*') ? 'active-links' : '' }}" href="{{ url('siswa/kelas/kehadiran/'.$kelas->id) }}">KEHADIRAN</a></li>
        <li><a class="{{ request()->is('siswa/kelas/anggota*') ? 'active-links' : '' }}" href="{{ url('siswa/kelas/anggota/'.$kelas->id) }}">ANGGOTA</a></li>
        <li><a class="{{ request()->is('siswa/kelas/detail*') ? 'active-links' : '' }}" href="{{ url('siswa/kelas/detail/'.$kelas->id) }}">DETAIL KELAS</a></li>
    </ul>
</div>