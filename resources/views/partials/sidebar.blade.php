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
        {{-- <li class="menu-header">Account</li>
        <li class="nav-item {{ request()->routeIs('account.*') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('account.index') }}"><i class="fas fa-user"></i> <span>Account</span></a>
        </li> --}}
        <li class="menu-header">Divisi</li>
        <li class="nav-item {{ request()->routeIs('divisi.*') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('divisi.index') }}"><i class="fas fa-users"></i> <span>List
                    Divisi</span></a>
        </li>
        <li class="menu-header">Kehadiran</li>
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Kehadiran</span></a>
            <ul class="dropdown-menu">
                {{-- @can('read_kehadiran') --}}
                <li class="nav-item {{ request()->routeIs('kehadiran.*') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('kehadiran.index') }}"><span> Kehadiran Karyawan</span></a>
                </li>
                {{-- @endcan --}}
                <li class="nav-item {{ request()->routeIs('kehadiran.*') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('kehadiran.kehadiran-staff') }}"><span> Kehadiran Staff</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('kehadiran.*') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('kehadiran.kehadiran-saya') }}"><span> Kehadiran Saya</span></a>
                </li>
            </ul>
        </li>
        <li class="menu-header">Pengumuman</li>
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
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
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Task</span></a>
            <ul class="dropdown-menu">
                <li class="nav-item {{ request()->routeIs('project.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('project.index') }}"><span>Task</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Polling</span></a>
            <ul class="dropdown-menu">
                <li class="nav-item {{ request()->routeIs('polling.index') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('polling.index') }}"><span> List Polling</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('polling.create') ? 'active' : ''  }}">
                    <a class="nav-link" href="{{ route('polling.create') }}"><span> Buat Polling</span></a>
                </li>
            </ul>
        </li>
        <li class="menu-header">Karyawan</li>
        @can('read_karyawan')
        <li class="nav-item {{ request()->routeIs('karyawan.index') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('karyawan.index') }}"><i class="fas fa-users"></i> <span>List
                    Karyawan</span></a>
        </li>
        @endcan
        @can('create_karyawan')
        <li class="nav-item {{ request()->routeIs('karyawan.create') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('karyawan.create') }}"><i class="fas fa-user-plus"></i> <span>Tambah
                    Karyawan</span></a>
        </li>
        @endcan
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Cuti</span></a>
            <ul class="dropdown-menu">
                {{-- @can ('manage_cuti_manager') --}}
                <li class="{{ request()->routeIs('cuti.manager') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.manager') }}">Cuti Manager</a></li>
                {{-- @endcan --}}
                {{-- @can ('manage_cuti_staff') --}}
                <li class="{{ request()->routeIs('cuti.staff') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.staff') }}">Cuti Staff</a></li>
                {{-- @endcan --}}
                <li class="{{ request()->routeIs('cuti.show') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.show') }}">Cuti Saya</a></li>
                <li class="{{ request()->routeIs('cuti.create') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('cuti.create') }}">Ajukan Cuti</a></li>
            </ul>
        </li>
        {{-- <li class="dropdown {{ request()->routeIs('kpi.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i></i>
                <span>KPI</span></a>
            <ul class="dropdown-menu">
                @can ('manage_kpi')
                <li class="{{ request()->routeIs('kpi.index') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('kpi.index') }}">List KPI Karyawan</a></li>
                @endcan
                <li class="{{ request()->routeIs('kpi.mykpi') ? 'active' : ''  }}"><a class="nav-link"
                        href="{{ route('kpi.mykpi') }}">KPI Saya</a></li>
            </ul>
        </li> --}}
    </ul>
</aside>