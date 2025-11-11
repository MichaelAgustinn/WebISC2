@extends('landing.master')

@section('title', 'Download Dokumen - Informatics Study Club')

@section('content')
    <main class="main">
        <div style="padding-top: 80px"></div>

        <section class="section">
            <div class="container text-center" data-aos="fade-up">
                <h2>Download Dokumen</h2>
                <p class="text-muted">Dokumen-dokumen yang mungkin Anda butuhkan</p>

                <div class="row justify-content-center mt-5">
                    <div class="col-lg-6">
                        <div class="list-group shadow-sm">
                            @forelse ($information as $item)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bx bx-file me-2"></i> {{ $item->name }}
                                    </div>
                                    <div class="d-flex gap-2">
                                        {{-- Tombol Download --}}
                                        <a href="{{ asset($item->file) }}" download class="btn btn-sm btn-primary">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">
                                    Belum ada dokumen yang tersedia untuk diunduh.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div style="padding-bottom: 80px"></div>
    </main>
@endsection
