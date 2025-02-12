<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (Auth::user()->role === 'admin')
                <li class="nav-item {{ $type_menu === 'manage-user' ? 'active' : '' }}">
                    <a href="{{ route('manage-user.index') }}" class="nav-link"><i
                            class="fas fa-person"></i><span>Pengguna</span></a>
                </li>
            @elseif (Auth::user()->role === 'staff')
                <li class="nav-item {{ $type_menu === 'internship' ? 'active' : '' }}">
                    <a href="{{ route('magang.index') }}" class="nav-link"><i
                            class="fas fa-tasks"></i><span>Magang</span></a>
                </li>
            @elseif (Auth::user()->internship)
                <li class="nav-item {{ $type_menu === 'magang-user' ? 'active' : '' }}">
                    <a href="{{ route('intern') }}" class="nav-link"><i class="fas fa-tasks"></i><span>Magang</span></a>
                </li>
                <li class="nav-item {{ $type_menu === 'laporan' ? 'active' : '' }}">
                    <a href="{{ route('report-weeks.index') }}" class="nav-link"><i class="fas fa-tasks"></i><span>Laporan</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
