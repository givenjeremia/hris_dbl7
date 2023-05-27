<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a href="{{url('/backend/home')}}" class="nav-link">Home</a>
    </li>
    @if(auth()->user()->can('view-roles')
    || auth()->user()->can('create-roles')
    || auth()->user()->can('edit-roles')
    || auth()->user()->can('delete-roles')
    || auth()->user()->can('view-users')
    || auth()->user()->can('create-users')
    || auth()->user()->can('edit-users')
    || auth()->user()->can('delete-users'))
    <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="nav-link dropdown-toggle">Admin Management</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            @if(auth()->user()->can('view-roles')
            || auth()->user()->can('create-roles')
            || auth()->user()->can('edit-roles')
            || auth()->user()->can('delete-roles'))
            <li><a href="{{url('backend/roles')}}" class="dropdown-item">Roles</a></li>
            @endif
            @if(auth()->user()->can('view-users')
            || auth()->user()->can('create-users')
            || auth()->user()->can('edit-users')
            || auth()->user()->can('delete-users'))
            <li><a href="{{url('backend/admin')}}" class="dropdown-item">Admin</a></li>
            @endif
        </ul>
    </li>
    {{-- Drop Down Absensi --}}
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu3" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle">Absensi</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                            <li><a href="{{url('backend/absensi')}}" class="dropdown-item">Data Absen</a></li>
                            <li><a href="{{url('backend/cuti')}}" class="dropdown-item">Data Cuti</a></li>
                            <li><a href="{{url('backend/lembur')}}" class="dropdown-item">Data Lembur</a></li>
                            <li><a href="{{url('backend/jadwal')}}" class="dropdown-item">Jadwal Shift</a></li>
                            <li><a href="{{url('backend/permohonan-cuti')}}" class="dropdown-item">Permohonan Cuti</a></li>
                            {{-- <li><a href="{{url('backend/permohonan-lembur')}}" class="dropdown-item">Permohonan Lembur</a></li> --}}

                    </ul>
            </li>
    {{-- Drop Down Gaji --}}
        {{-- <li class="nav-item dropdown">
            <a id="dropdownSubMenu3" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle">Gaji</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                            <li><a href="{{url('backend/laporangaji')}}" class="dropdown-item">Laporan Gaji</a></li>
                            <li><a href="{{url('backend/umk')}}" class="dropdown-item">UMK</a></li>
                            <li><a href="{{url('backend/tunjangankeahlian')}}" class="dropdown-item">Tunjangan Keahlian</a></li>
                            <li><a href="{{url('backend/tunjanganlamaberkerja')}}" class="dropdown-item">Tunjangan Lama Berkerja </a></li>
                    </ul>
            </li>
     --}}
    {{--Drop Down Data master--}}
        <li class="nav-item dropdown">
        <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                class="nav-link dropdown-toggle">Data Master</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="{{url('backend/pegawai')}}" class="dropdown-item">Pegawai</a></li>
                        <li><a href="{{url('backend/divisi')}}" class="dropdown-item">Divisi</a></li>
                        <li><a href="{{url('backend/jabatan')}}" class="dropdown-item">Jabatan</a></li>
                        <li><a href="{{url('backend/shift')}}" class="dropdown-item">Shift</a></li>
                        <li><a href="{{url('backend/client')}}" class="dropdown-item">Client</a></li>
                        <li><a href="{{url('backend/bpjs')}}" class="dropdown-item">BPJS</a></li>
                </ul>
        </li>
    {{-- Gaji --}}
    <li class="nav-item">
        <a href="{{url('backend/laporangaji')}}" class="nav-link">Laporan Gaji</a>
    </li>
    @endif
    @if(auth()->user()->can('view-test')
    || auth()->user()->can('create-test')
    || auth()->user()->can('edit-test')
    || auth()->user()->can('delete-test'))
    {{-- <li class="nav-item">
        <a href="{{url('backend/test')}}" class="nav-link">test</a>
    </li> --}}
    @endif
</ul>