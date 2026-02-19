@extends('landing.master')

@push('styles')
    <style>
        /* 1. HEADER HALAMAN */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            padding: 150px 5% 80px;
            text-align: center;
            color: var(--white);
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .page-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* 2. SEARCH BAR */
        .search-container {
            margin-top: -30px;
            padding: 0 5%;
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
        }

        .search-bar {
            background: var(--white);
            padding: 10px 15px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 600px;
            border: 1px solid #eee;
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 15px;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .search-bar button {
            background: var(--primary);
            color: var(--white);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .search-bar button:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* 3. DOC SECTION */
        .doc-section {
            padding: 5rem 5%;
            background: var(--bg-light);
            min-height: 60vh;
        }

        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .doc-card {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #eee;
            position: relative;
            overflow: hidden;
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(15, 32, 75, 0.15);
            border-color: var(--accent);
        }

        .doc-icon-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .doc-icon-wrapper i {
            font-size: 2.5rem;
            color: var(--primary);
            transition: 0.3s;
        }

        /* Logic Warna Ikon */
        .doc-card[data-type="pdf"] .doc-icon-wrapper i {
            color: #dc2626;
        }

        .doc-card[data-type="doc"] .doc-icon-wrapper i {
            color: #2563eb;
        }

        .doc-card[data-type="xls"] .doc-icon-wrapper i {
            color: #16a34a;
        }

        .doc-card[data-type="img"] .doc-icon-wrapper i {
            color: #9333ea;
        }

        .doc-category {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-light);
            font-weight: 700;
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .doc-info {
            flex: 1;
        }

        .doc-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .doc-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        .doc-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-download:hover {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 5px 15px rgba(15, 32, 75, 0.2);
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 120px 5% 60px;
            }

            .page-header h1 {
                font-size: 2.2rem;
            }

            .doc-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .doc-meta {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <header class="page-header">
        <h1>Dokumen & Arsip</h1>
        <div style="width: 80px; height: 4px; background: var(--accent); margin: 0 auto 1.5rem auto; border-radius: 2px;">
        </div>
        <p>Unduh formulir, panduan akademik, dan dokumen penting organisasi di sini.</p>
    </header>

    <div class="search-container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari nama dokumen (misal: KRS, Seminar)...">
            <button><i class="ri-search-line"></i></button>
        </div>
    </div>

    <section class="doc-section">
        <div class="doc-grid" id="docGrid">

            @forelse($documents as $doc)
                @php
                    $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                    $fileType = 'doc';
                    $icon = 'ri-file-text-line';

                    // Deteksi Ikon & Tipe CSS
                    if (in_array(strtolower($ext), ['pdf'])) {
                        $fileType = 'pdf';
                        $icon = 'ri-file-pdf-2-line';
                    } elseif (in_array(strtolower($ext), ['xls', 'xlsx', 'csv'])) {
                        $fileType = 'xls';
                        $icon = 'ri-file-excel-2-line';
                    } elseif (in_array(strtolower($ext), ['doc', 'docx'])) {
                        $fileType = 'doc';
                        $icon = 'ri-file-word-2-line';
                    } elseif (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
                        $fileType = 'img';
                        $icon = 'ri-image-line';
                    }

                    // Hitung Size Manusiawi
                    $sizeDisplay = '0 KB';
                    if (Storage::disk('public')->exists($doc->file_path)) {
                        $bytes = Storage::disk('public')->size($doc->file_path);
                        $sizeDisplay =
                            $bytes >= 1048576
                                ? number_format($bytes / 1048576, 2) . ' MB'
                                : number_format($bytes / 1024, 2) . ' KB';
                    }
                @endphp

                <div class="doc-card" data-type="{{ $fileType }}">
                    <div class="doc-icon-wrapper">
                        <span class="doc-category">{{ str_replace('_', ' ', $doc->type) }}</span>
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div class="doc-info">
                        <h3 class="doc-title">{{ $doc->name }}</h3>
                        <div class="doc-meta">
                            <span><i class="ri-file-line"></i> {{ strtoupper($ext) }}</span>
                            <span><i class="ri-hard-drive-2-line"></i> {{ $sizeDisplay }}</span>
                        </div>
                        <a href="{{ route('documents.download', $doc->id) }}" class="btn-download">Download <i
                                class="ri-download-line"></i></a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-light); padding: 3rem;">
                    <p class="text-lg">Belum ada dokumen yang tersedia.</p>
                </div>
            @endforelse

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const docGrid = document.getElementById('docGrid');

            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    const term = e.target.value.toLowerCase();
                    const cards = docGrid.getElementsByClassName('doc-card');

                    Array.from(cards).forEach(card => {
                        const title = card.querySelector('.doc-title').textContent.toLowerCase();
                        const category = card.querySelector('.doc-category').textContent
                            .toLowerCase();

                        if (title.includes(term) || category.includes(term)) {
                            card.style.display = "flex";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            }
        });
    </script>
@endsection
