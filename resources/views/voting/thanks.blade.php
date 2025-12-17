<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('admin/assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Terima Kasih - Voting ISC</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('landing/assets/img/logo-isc.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">

                <!-- Card -->
                <div class="card">
                    <div class="card-body text-center">

                        <!-- Icon -->
                        <div class="mb-3">
                            <i class="bx bx-check-circle" style="font-size: 80px; color: #263C8F;"></i>
                        </div>

                        <h3 class="mb-2" style="color:#263C8F;">Terima Kasih! 🎉</h3>
                        <p class="mb-3">Voting kamu telah berhasil direkam.</p>

                        @if (session('success'))
                            <p class="text-success mb-3">{{ session('success') }}</p>
                        @endif

                        <p class="text-muted">
                            Kamu sudah memberikan suara terbaikmu pada karya favorit.<br>
                            Terima kasih telah berpartisipasi dalam kegiatan Informatics Study Club.
                        </p>

                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="btn btn-primary"
                                style="background-color:#263C8F; border-color:#263C8F;">
                                Kembali ke Beranda
                            </a>
                        </div>

                    </div>
                </div>
                <!-- /Card -->

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
</body>

</html>
