<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset('storage/' . auth()->user()->img) }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">{{ auth()->user()->name }}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
          <a href="{{ route('account.index') }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
          </a>
          {{-- <a href="features-activities.html" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Activities
          </a> --}}
          <a href="{{ route('account.changePassword') }}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item has-icon text-danger" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>