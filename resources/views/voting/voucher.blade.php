<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('admin/assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Input Voucher - Informatics Study Club</title>

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

                        <h4 class="mb-2 text-center">Masukkan Kode Voucher 🎟️</h4>
                        <p class="mb-4 text-center">Gunakan voucher yang diberikan panitia untuk melakukan voting</p>

                        <!-- FORM INPUT VOUCHER -->
                        <form class="mb-3" method="GET" action="{{ route('voting.index') }}">

                            <!-- Input Voucher -->
                            <div class="mb-3">
                                <label for="voucher" class="form-label">Kode Voucher</label>
                                <input type="text" class="form-control" id="voucher" name="code"
                                    placeholder="Masukkan kode voucher..." required autofocus autocomplete="off" />

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol -->
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    Masuk Voting
                                </button>
                            </div>
                            <p class="text-center">
                                Kembali Ke Beranda?
                                @if (Route::has('register'))
                                    <a href="{{ route('landing') }}">klik disini</a>
                                @endif
                            </p>
                        </form>

                        <!-- Pesan error global -->
                        @if (session('error'))
                            <p class="text-danger text-center">{{ session('error') }}</p>
                        @endif

                    </div>
                </div>
                <!-- /Card -->
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
</body>

</html>
