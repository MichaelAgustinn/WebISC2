<!DOCTYPE html>
<html lang="id">

@include('landing.head')

<body>

    @include('landing.nav')

    @yield('content')

    @include('landing.footer')
    @include('landing.script')
</body>

</html>
