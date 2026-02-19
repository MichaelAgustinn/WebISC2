<nav class="navbar">
    <a href="#" class="logo"><img src="{{ asset('Assets/logo-isc.png') }}" alt="" style="height: 50px"></a>
    <div class="menu-toggle"><i class="ri-menu-3-line"></i></div>
    <ul class="nav-links">
        @if (request()->routeIs('home'))
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#creation">Creation</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="#blog">Blog</a></li>
        @else
            <li><a href="/#home">Home</a></li>
            <li><a href="/#about">About</a></li>
            <li><a href="/#creation">Creation</a></li>
            <li><a href="/#team">Team</a></li>
            <li><a href="/#blog">Blog</a></li>
        @endif

        <li class="dropdown-item">
            <a href="#">Information <i class="ri-arrow-down-s-line"></i></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('dosen') }}">Dosen Pembimbing</a></li>
                <li><a href="{{ route('anggota') }}">Anggota ISC</a></li>
                <li><a href="{{ route('dokumen') }}">Dokumen</a></li>
            </ul>
        </li>

        @if (!Auth::user())
            <li><a href="{{ route('login') }}" class="login-btn">Login</a></li>
        @else
            <li><a href="{{ route('dashboard') }}" class="login-btn">Dashboard</a></li>
        @endif

    </ul>
</nav>
