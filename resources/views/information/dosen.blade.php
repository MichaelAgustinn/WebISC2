@extends('landing.master')

@section('title', 'Dosen Pembimbing - Informatics Study Club')

@section('content')
    <main class="main">
        <div style="padding-top: 100px"></div>

        <section class="team section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Dosen Pembimbing</h2>
                <p>Dosen Pembimbing Informatics Study Club</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    @foreach ($mentors as $index => $member)
                        @php
                            // index mulai dari 0, jadi 0,1,2 = 3 data pertama
                            $colClass = $index < 3 ? 'col-lg-4' : 'col-lg-3';
                            // delay animasi bertambah 100ms tiap item
                            $delay = 100 + $index * 100;
                        @endphp
                        <div class=" {{ $colClass }} " class="col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="{{ $delay }}">
                            <div class="team-member">
                                {{-- <div> --}}
                                <img src="{{ asset($member->image) }}" class="img-fluid" alt="{{ $member->name }}"
                                    style="max-height: 300px; max-width: 300px;">
                                {{-- </div> --}}
                                <div class="member-info">
                                    <h4>{{ $member->name }}</h4>
                                    <span>{{ $member->jabatan }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </section><!-- /Team Section -->

    </main>
@endsection
