@extends('landing.master')

@section('title', 'Beranda - Informatics Study Club')

@section('content')
    <main class="main">

        @include('landing.hero')

        @include('landing.about')

        @include('landing.visi')

        @include('landing.stats')

        {{-- ! ini kerja terakhir --}}
        {{-- @include('landing.event') --}}

        @include('landing.faq')

        @include('landing.project')

        @include('landing.testimonial')

        @include('landing.mentor')

        @include('landing.logo')

        @include('landing.blog-recent')

        {{-- * sepertinya tidak diperlukan --}}
        {{-- @include('landing.contact') --}}

    </main>
@endsection
