@extends('landing.master')

@section('title', 'Voting Karya - Informatics Study Club')

@section('content')
    <main class="main">
        <div style="padding-top: 100px"></div>

        <section class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Voting Karya</h2>
                <p>Pilih karya favoritmu</p>
            </div>

            <div class="container">
                <div class="row gy-4">

                    <!-- CARD TEMPLATE -->
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="team-member d-flex flex-column w-100 h-100"
                                style="background:white; border-radius:12px; padding:15px; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.06);">

                                <!-- IMAGE SAME HEIGHT -->
                                <div style="width:100%; height:300px; overflow:hidden; border-radius:10px;">
                                    <img src="" alt="Karya {{ $i }}"
                                        style="width:100%; height:100%; object-fit:cover;">
                                </div>

                                <!-- INFO (FLEX COLUMN) -->
                                <div class="member-info d-flex flex-column justify-content-between flex-grow-1 mt-3">

                                    <div>
                                        <h4 style="color:#263C8F;">Judul Karya {{ $i }}</h4>
                                        <p class="text-muted" style="font-size:14px;">
                                            Deskripsi contoh untuk memastikan card seragam.
                                        </p>
                                    </div>

                                    <!-- BUTTON ALWAYS AT BOTTOM -->
                                    <button class="btn mt-3"
                                        style="background-color:#263C8F; color:white; border-radius:6px; width:100%;">
                                        Vote Karya Ini
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endfor

                </div>
            </div>

        </section>
    </main>
@endsection
