<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - Informatics Study Club</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('landing/assets/img/logo-isc.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}" />

    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Card -->
                <div class="card">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-3">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('landing/assets/img/semua-logo.png') }}" alt="Logo"
                                    height="100">
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2 text-center">Selamat Datang 👋</h4>
                        <p class="mb-4 text-center">Tolong Sign In Untuk Melanjutkan</p>

                        <!-- Laravel login form -->
                        <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan Email" required autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            <small>Lupa Sandi?</small>
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="••••••••••" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                    <label class="form-check-label" for="remember"> Remember Me </label>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Belum punya akun?</span>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Buat Akun</a>
                            @endif
                        </p>
                    </div>
                </div>
                <!-- /Card -->
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
</body>

</html>
