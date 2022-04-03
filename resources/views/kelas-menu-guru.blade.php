<div class="kelas-menu">
    <ul class="menu-container">
        <li><a class="{{ request()->is('guru/kelas/index*') ? 'active-links' : '' }}" href="{{ url('guru/kelas/index/'.$kelas->id) }}">TIMELINE</a></li>
        <li><a class="{{ request()->is('guru/kelas/kehadiran*') ? 'active-links' : '' }}" href="{{ url('guru/kelas/kehadiran/'.$kelas->id) }}">KEHADIRAN</a></li>
        <li><a class="{{ request()->is('guru/kelas/anggota*') ? 'active-links' : '' }}" href="{{ url('guru/kelas/anggota/'.$kelas->id) }}">ANGGOTA</a></li>
        <li><a class="{{ request()->is('guru/kelas/detail*') ? 'active-links' : '' }}" href="{{ url('guru/kelas/detail/'.$kelas->id) }}">DETAIL KELAS</a></li>
    </ul>
</div>