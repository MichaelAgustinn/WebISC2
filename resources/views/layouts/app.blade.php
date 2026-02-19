<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Informatics Study Club</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden" aria-hidden="true">
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transition-transform duration-300 ease-in-out md:static md:translate-x-0 border-r border-gray-100 flex flex-col">

            <div class="flex h-16 items-center justify-center border-b border-gray-100 bg-white px-6 shrink-0">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 font-bold text-xl text-black-600 hover:text-indigo-700 transition">
                    <img src="{{ asset('Assets/logo-isc.png') }}" style="height: 30px" alt="ISC Logo">
                    <span>ISC</span>
                </a>
            </div>

            <nav class="mt-6 flex flex-col space-y-1 px-3 overflow-y-auto flex-1 pb-4">

                <p class="px-3 text-xs font-semibold uppercase text-gray-400 mt-2 mb-2 tracking-wider">Utama</p>
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
                    <p class="px-3 text-xs font-semibold uppercase text-gray-400 mt-6 mb-2 tracking-wider">Konten Web
                    </p>

                    <a href="{{ route('landing.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('landing.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('landing.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Landing Page
                    </a>

                    <a href="{{ route('faq.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('faq.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('faq.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kelola FAQ
                    </a>

                    <a href="{{ route('teams.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('teams.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('teams.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Kelola Pengurus
                    </a>

                    <a href="{{ route('advisors.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('advisors.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('advisors.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Kelola Dosen
                    </a>
                @endif

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
                    <p class="px-3 text-xs font-semibold uppercase text-gray-400 mt-6 mb-2 tracking-wider">Anggota &
                        Karya
                    </p>
                    <a href="{{ route('projects.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('projects.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('projects.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Karya (Projects)
                    </a>

                    <a href="{{ route('users.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Verifikasi Anggota
                    </a>
                @endif

                <p class="px-3 text-xs font-semibold uppercase text-gray-400 mt-6 mb-2 tracking-wider">Administrasi</p>

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pengurus')
                    <a href="{{ route('documents.index') }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('documents.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('documents.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Arsip Dokumen Saya
                    </a>
                @endif
                <a href="{{ route('posts.manage') }}"
                    class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('posts.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('posts.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Artikel Saya
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-colors">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile Saya
                </a>

                <div class="mt-auto pt-4 pb-2">
                    <a href="{{ route('home') }}"
                        class="group flex items-center justify-center rounded-lg px-3 py-2.5 text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition-all shadow-sm">
                        <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </nav>
        </aside>

        <div class="flex flex-1 flex-col overflow-hidden relative">

            <header
                class="flex h-16 items-center justify-between bg-white px-6 py-4 shadow-sm z-10 border-b border-gray-100">

                <div class="flex items-center md:hidden">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 focus:outline-none p-1 rounded-md hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="hidden md:block">
                    <h2 class="text-xl font-semibold text-gray-800 tracking-tight">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="relative ml-auto" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center gap-2 focus:outline-none transition-transform active:scale-95">
                        <div class="text-right hidden sm:block mr-2">
                            <p class="text-sm font-semibold text-gray-700 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-500 font-medium leading-none mt-1">
                                {{ ucfirst(Auth::user()->role) }}</p>
                        </div>

                        <div
                            class="h-10 w-10 rounded-full bg-gray-200 border-2 border-indigo-100 overflow-hidden shadow-sm">
                            @if (Auth::user()->profile && Auth::user()->profile->photo)
                                <img src="{{ asset('uploads/profiles/' . Auth::user()->profile->photo) }}"
                                    class="h-full w-full object-cover" alt="Profile">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff"
                                    class="h-full w-full object-cover" alt="Profile">
                            @endif
                        </div>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak
                        class="absolute right-0 mt-3 w-72 rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 origin-top-right z-50">

                        <div class="flex flex-col items-center border-b border-gray-100 p-6 bg-gray-50 rounded-t-xl">
                            <div class="h-20 w-20 rounded-full border-4 border-white shadow-md overflow-hidden mb-3">
                                @if (Auth::user()->profile && Auth::user()->profile->photo)
                                    <img src="{{ asset('uploads/profiles/' . Auth::user()->profile->photo) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff"
                                        class="h-full w-full object-cover">
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 text-center">{{ Auth::user()->name }}</h3>
                            <span
                                class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 mt-1">
                                {{ strtoupper(Auth::user()->role) }}
                            </span>
                        </div>

                        <div class="p-3">
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-red-50 border border-red-100 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-100 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-50 p-6 flex flex-col justify-between">
                <div class="mb-6">
                    @if (session('success'))
                        <div class="mb-6 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 shadow-sm"
                            x-data="{ show: true }" x-show="show">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-green-600 hover:text-green-800">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>

                <footer class="mt-auto border-t border-gray-200 pt-6">
                    <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-500">
                        <div class="mb-2 md:mb-0">
                            &copy; {{ date('Y') }} <span class="font-semibold text-indigo-600">Informatics Study
                                Club</span>.
                            <span class="hidden md:inline">|</span>
                            <span>All rights reserved.</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1">
                                Dibuat dengan <span class="text-red-500 animate-pulse">❤</span> oleh
                                <a href="#"
                                    class="font-medium text-gray-700 hover:text-indigo-600 transition">Divisi
                                    Website</a>
                            </span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
</body>

</html>
