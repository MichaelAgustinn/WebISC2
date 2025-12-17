<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="/" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('landing/assets/img/logo-isc.webp') }}" alt="">
            <h1 class="sitename">ISC</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/#hero" class="{{ Route::is('landing') ? 'active' : '' }}">Home<br></a>
                </li>
                <li><a href="/#about">About</a></li>
                <li><a href="/#portfolio">Creation</a></li>
                <li><a href="/#team">Team</a></li>
                <li><a href="{{ route('blog.page') }}"
                        class="{{ Route::is('blog.page') || Route::is('blog.landing') ? 'active' : '' }}">Blog</a>
                </li>
                <li><a href="{{ route('voting.input') }}"
                        class="{{ Route::is('voting.index') || Route::is('voting.input') || Route::is('voting.thanks') ? 'active' : '' }}">Voting
                        Karya</a>
                </li>
                <li class="dropdown"><a href="#"><span>Information</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ route('information.dosen') }}">Dosen Pembimbing</a></li>
                        <li><a href="{{ route('information.anggota') }}">Anggota ISC</a></li>
                        <li><a href="{{ route('information.download') }}">Dokumen</a></li>
                        {{-- <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Deep Dropdown 1</a></li>
                                <li><a href="#">Deep Dropdown 2</a></li>
                                <li><a href="#">Deep Dropdown 3</a></li>
                                <li><a href="#">Deep Dropdown 4</a></li>
                                <li><a href="#">Deep Dropdown 5</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </li>

                {{-- * mungkin tidak akan digunakan --}}
                {{-- <li><a href="#contact">Contact</a></li> --}}
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @if (Route::has('login'))
            @auth
                @if (Auth::user()->role === 'Admin')
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    {{-- <form method="POST" action="{{ route('profile.index') }}" class="btn-getstarted flex-md-shrink-0"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        @csrf --}}
                    <a style="color: white" href="{{ route('dashboard') }}"
                        class="btn-getstarted flex-md-shrink-0">Profile</a>
                    {{-- </form> --}}
                @endif
            @else
                {{-- <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Login</a> --}}
                @if (Route::has('login'))
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Login</a>
                @endif
            @endauth
        @endif

    </div>
</header>
