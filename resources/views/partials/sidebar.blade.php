<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">HRIS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">HR</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i>
                <span>Dashboard</span></a>
        </li>
        {{-- @canany(['karyawan.read', 'karyawan.create']) --}}
        {{-- <li class="menu-header">Divisi</li>
        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-users"></i>
                <span>List Anggota</span></a>
        </li> --}}
        {{-- @endcanany --}}
        @canany(['karyawan.read', 'karyawan.create'])
        <li class="menu-header">Karyawan</li>
        <li class="dropdown {{ request()->routeIs('karyawan.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i>
                <span>Karyawan</span></a>
            <ul class="dropdown-menu">
                @can ('karyawan.read')
                <li class="{{ request()->routeIs('karyawan.index') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('karyawan.index') }}">List Karyawan</a></li>
                @endcan
                @can('karyawan.create')
                <li class="{{ request()->routeIs('karyawan.create') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('karyawan.create') }}">Tambah Karyawan</a></li>
                @endcan
            </ul>
        </li>
        @endcanany
        <li class="menu-header">Kehadiran</li>
        <li class="dropdown {{ request()->routeIs('Kehadiran.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chalkboard-teacher"></i>
                <span>Kehadiran</span></a>
            <ul class="dropdown-menu">
                @can('kehadiran.read')
                <li class="nav-item {{ request()->routeIs('kehadiran.*') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('kehadiran.index') }}"><span> Kehadiran Karyawan</span></a>
                </li>
                @endcan
                <li class="nav-item {{ request()->routeIs('kehadiran.*') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('kehadiran.kehadiran-saya') }}"><span> Kehadiran Saya</span></a>
                </li>
            </ul>
        </li>

        <li class="menu-header">Utility</li>
        <li class="dropdown {{ request()->routeIs('divisi.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-solid fa-cube"></i>
                <span>Divisi</span></a>
            <ul class="dropdown-menu">
                {{-- @can('event.read') --}}
                <li class="nav-item {{ request()->routeIs('divisi.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('divisi.index') }}"><span> Divisi</span></a>
                </li>
                <li class="{{ request()->routeIs('divisi.create') ? 'active' : ''  }}"><a class="nav-link"
                    href="{{ route('divisi.create') }}">Buat Divisi</a></li>
            </ul>
        </li>
        @canany(['pengumuman.create', 'pengumuman.update', 'pengumuman.delete'])
        <li class="dropdown {{ request()->routeIs('pengumuman.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bullhorn"></i>
                <span>Pengumuman</span></a>
            <ul class="dropdown-menu">
                <li class="nav-item {{ request()->routeIs('pengumuman.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('pengumuman.index') }}"><span>List Pengumuman</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('pengumuman.create') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('pengumuman.create') }}"><span>Buat Pengumuman</span></a>
                </li>
            </ul>
        </li>

        @endcanany
        <li class="dropdown {{ request()->routeIs('project.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i>
                <span>Task</span></a>
            <ul class="dropdown-menu">
                <li class="nav-item {{ request()->routeIs('project.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('project.index') }}"><span>Task</span></a>
                </li>
            </ul>
        </li>
        @canany(['polling.create', 'polling.read', 'polling.update', 'polling.delete'])

        <li class="dropdown {{ request()->routeIs('polling.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-table"></i>
                <span>Polling</span></a>
            <ul class="dropdown-menu">
                @can('polling.read')
                <li class="nav-item {{ request()->routeIs('polling.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('polling.index') }}"><span> List Polling</span></a>
                </li>
                @endcan
                @can('polling.create')
                <li class="nav-item {{ request()->routeIs('polling.create') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('polling.create') }}"><span> Buat Polling</span></a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        {{-- @canany(['polling.create', 'polling.read', 'polling.update', 'polling.delete']) --}}

        <li class="dropdown {{ request()->routeIs('event.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-calendar-alt"></i>
                <span>Calendar</span></a>
            <ul class="dropdown-menu">
                {{-- @can('event.read') --}}
                <li class="nav-item {{ request()->routeIs('event.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('event.index') }}"><span> Calendar</span></a>
                </li>
                {{-- @endcan --}}
                @can('event.create')
                <li class="nav-item {{ request()->routeIs('event.create') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('event.create') }}"><span> Buat Event (Advanced)</span></a>
                </li>
                @endcan
            </ul>
        </li>
        {{-- @endcanany --}}
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Cuti</span></a>
            <ul class="dropdown-menu">
                {{-- @can ('manage_cuti_manager') --}}
                {{-- <li class="{{ request()->routeIs('cuti.manager') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.manager') }}">Cuti Manager</a></li> --}}
                {{-- @endcan --}}
                @can ('cuti.read')
                <li class="{{ request()->routeIs('cuti.index') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.index') }}">Cuti</a></li>
                @endcan
                <li class="{{ request()->routeIs('cuti.show') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.show') }}">Cuti Saya</a></li>
                <li class="{{ request()->routeIs('cuti.create') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.create') }}">Ajukan Cuti</a></li>
            </ul>
            @can('restore')
                <li class="dropdown {{ request()->routeIs('trash.*') ? 'active' : ''  }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-trash"></i>
                        <span>Recycle Bin</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('trash.karyawan') ? 'active' : ''  }}"><a class="nav-link"
                                href="{{ route('trash.karyawan') }}">Karyawan</a></li>
                    
                    </ul>
                </li>
            @endcan
        </li>
    </ul>
</aside>