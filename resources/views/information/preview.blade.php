@extends('landing.master')

@section('title', 'Lihat Dokumen')

@section('content')
    <main class="main">
        <div style="padding-top: 80px"></div>

        <section class="section">
            <div class="container text-center">
                <h2 class="mb-4">{{ $document->name }}</h2>

                @if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <iframe src="{{ $fileUrl }}" width="100%" height="800px" style="border:none;"></iframe>
                @elseif (in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                    <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%"
                        height="800px" frameborder="0"></iframe>
                @else
                    <p>File ini tidak dapat ditampilkan. Silakan unduh untuk melihatnya.</p>
                @endif

                <div class="mt-4">
                    <a href="{{ asset($document->file) }}" download class="btn btn-primary">
                        <i class="bx bx-download"></i> Download
                    </a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </section>
    </main>
@endsection
