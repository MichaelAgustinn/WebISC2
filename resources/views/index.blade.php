@extends('landing.master')

@section('content')
    @include('landing.hero')

    <div class="section-divider">
        <i class="ri-code-s-slash-line divider-icon"></i>
    </div>

    @include('landing.about')

    @include('landing.visi-misi')

    @include('landing.creation')

    <div class="section-divider">
        <i class="ri-cpu-line divider-icon"></i>
    </div>

    @include('landing.typing-leaderboard')

    <div class="section-divider">
        <i class="ri-base-station-line divider-icon"></i>
    </div>

    @include('landing.team')

    @include('landing.blog')

    @include('landing.faq')
    <a href="#" id="backToTop" class="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </a>
@endsection
