<!DOCTYPE html>
<html lang="en">

@include('landing.head')

<body class="index-page">
    @include('landing.header')

    @yield('content')

    @include('landing.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('landing.script')

</body>

</html>
