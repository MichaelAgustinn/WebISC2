@extends('landing.master')

@section('title', 'Anggota - Informatics Study Club')

@section('content')
    <style>
        .team .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Pusatkan isi row */
        }

        .team .col-lg-3,
        .team .col-md-6 {
            display: flex;
            justify-content: center;
            /* Pusatkan isi kolom */
        }

        .team-member {
            width: 100%;
            max-width: 250px;
            /* batas maksimal lebar card biar rapi */
        }
    </style>
    <main class="main">
        <div style="padding-top: 80px"></div>
        <section class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Anggota ISC</h2>
                <p>Anggota Informatics Study Club</p>
            </div><!-- End Section Title -->

            <div class="container text-center">

                <div class="container text-center">
                    <form action="{{ route('information.anggota') }}" method="GET"
                        class="mb-4 d-flex justify-content-center">
                        <input type="text" name="search" class="form-control w-50 me-2"
                            placeholder="Cari nama, divisi, atau angkatan..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>

                        @if (request('search'))
                            <a href="{{ route('information.anggota') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                        @endif
                    </form>
                    <div class="row gy-4 justify-content-center">
                        @foreach ($anggota as $index => $item)
                            @php
                                $delay = 100 + $index * 100;
                            @endphp

                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                                data-aos-delay="{{ $delay }}">
                                <div class="team-member shadow-sm border rounded-3 bg-white text-center p-3"
                                    style="transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;"
                                    onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.1)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">

                                    <div class="member-img mb-3">
                                        <img src="{{ asset($item->profile->image ?? 'images/default-profile.jpg') }}"
                                            class="img-fluid rounded-circle border" alt="{{ $item->name }}"
                                            style="width: 200px; height: 200px; object-fit: cover;">
                                    </div>

                                    <div class="member-info">
                                        <h4 class="fw-bold mb-1">{{ $item->name }}</h4>
                                        <span
                                            class="text-muted d-block mb-2">{{ $item->profile->position ?? 'Anggota' }}</span>
                                        <p class="text-secondary small">Divisi:
                                            {{ $item->profile->divisi ?? 'Belum ada divisi' }}</p>
                                        <p class="text-secondary small">Angkatan:
                                            {{ $item->profile->angkatan ?? 'Tidak Diketahui' }}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="padding-top: 80px"></div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $anggota->onEachSide(1)->links('vendor.pagination.custom') }}
                    </div>

                </div>

        </section><!-- /Team Section -->

    </main>
@endsection
