<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">

    <ul class="navbar-nav mr-auto">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>

    <ul class="navbar-nav navbar-right">
        {{-- profile --}}
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ Auth::user()->photo_path ? Storage::url('foto profil/'. Auth::user()->photo_path) : asset('img/avatar/avatar-1.png')  }}" class="rounded-circle mr-1" style="width: 30px; height : 30px; object-fit: cover;">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            {{-- <div class=""> --}}
                <form action="{{ route('logout') }}" method="POST" class="dropdown-menu dropdown-menu-right">
                    @csrf

                    <div class="dropdown-title">Selamat datang</div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>

                    <div class="dropdown-divider"></div>
                    <button type="submit" class="dropdown-item has-icon text-danger d-flex align-items-center">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </button>
                </form>
            {{-- </div> --}}
        </li>
    </ul>
</nav>
