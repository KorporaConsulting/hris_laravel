<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">HRIS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-pencil-ruler"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item {{ request()->routeIs('account.*') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('account.index') }}"><i class="fas fa-user"></i> <span>Account</span></a>
        </li>
        <li class="dropdown {{ request()->routeIs('cuti.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Cuti</span></a>
            <ul class="dropdown-menu">
                @if (auth()->user()->level == 'manager' || auth()->user()->level == 'direktur')
                    <li class="{{ request()->routeIs('cuti.index') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('cuti.index') }}">Manage Cuti</a></li>
                @endif
                @if (auth()->user()->level != 'direktur')
                    <li class="{{ request()->routeIs('cuti.show') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('cuti.show') }}">Cuti Saya</a></li>
                    <li class="{{ request()->routeIs('cuti.create') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('cuti.create') }}">Ajukan Cuti</a></li>
                @endif

            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('kpi.*') ? 'active' : ''  }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i></i> <span>KPI</span></a>
            <ul class="dropdown-menu">
                    @if (auth()->user()->level == 'hr')
                    <li class="{{ request()->routeIs('kpi.index') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('kpi.index') }}">List KPI Karyawan</a></li>
                    @endif
                    <li class="{{ request()->routeIs('kpi.index') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('kpi.index') }}">KPI Saya</a></li>

            </ul>
        </li>
    </ul>
</aside>