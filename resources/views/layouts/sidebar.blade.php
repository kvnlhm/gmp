<div class="sidebar">
    <div class="brand">
        <i class='bx bx-building-house'></i>
        GMP
    </div>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('monitoring*') ? 'active' : '' }}" href="{{ route('monitoring.index') }}">
                <i class='bx bx-chart'></i>
                Monitoring
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('produktivitas-hspd*') ? 'active' : '' }}" href="{{ route('produktivitas-hspd.index') }}">
                <i class='bx bx-line-chart'></i>
                Produktivitas HSPD
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('produktivitas-harian*') ? 'active' : '' }}" href="{{ route('produktivitas-harian.index') }}">
                <i class='bx bx-bar-chart-alt-2'></i>
                Produktivitas Harian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('pengguna*') ? 'active' : '' }}" href="{{ route('pengguna.index') }}">
                <i class='bx bx-user'></i>
                Pengguna
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('profil*') ? 'active' : '' }}" href="{{ route('profil.index') }}">
                <i class='bx bx-cog'></i>
                Profil
            </a>
        </li>
        <li class="nav-item mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-danger w-100 text-start">
                    <i class='bx bx-log-out'></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div> 

<style>
.sidebar {
    width: 250px;
    min-height: 100vh;
    background: #111313;
    padding: 20px;
}

.brand {
    color: #00b894;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-link {
    color: #636e72;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-link:hover {
    color: #00b894;
    background-color: #2d3436;
}

.nav-link.active {
    color: #00b894;
    background-color: #2d3436;
}

.nav-link i {
    font-size: 20px;
}
</style> 