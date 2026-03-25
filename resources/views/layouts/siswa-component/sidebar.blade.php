<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <img src="{{ asset('assets/backend/img/avatars/logo.png') }}" width="200" />
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- Dashboard Siswa --}}
        <li class="menu-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <a href="{{ route('siswa.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard Saya</div>
            </a>
        </li>

        <li class="menu-item mt-4">
            <a href="{{ route('siswa.logout') }}" class="menu-link text-danger" 
            onclick="event.preventDefault(); document.getElementById('siswa-logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div>Keluar</div>
            </a>
        </li>

        <form id="siswa-logout-form" action="{{ route('siswa.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</aside>