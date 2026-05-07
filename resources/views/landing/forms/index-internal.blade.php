@extends('landing.master')

@section('content')
    <header class="blog-header">
        <h1>Pendaftaran Komunitas</h1>

        <p>
            Daftar dan bergabung ke berbagai komunitas aktif
            Informatics Study Club.
        </p>
    </header>

    <section class="blog-container">

        <div class="blog-wrapper">

            <div class="blog-main">

                <div class="blog-list">

                    @forelse($communities as $community)
                        <article class="blog-card">

                            <div class="card-img">

                                <span class="category-tag">
                                    Komunitas
                                </span>

                                @if ($community->photo)
                                    <img src="{{ asset($community->photo) }}" alt="{{ $community->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" alt="Default">
                                @endif

                            </div>

                            <div class="blog-content">

                                <div class="blog-meta">

                                    <span>
                                        <i class="ri-calendar-line"></i>

                                        {{ $community->created_at->format('d M Y') }}
                                    </span>

                                </div>

                                <h3 class="blog-title">
                                    {{ $community->name }}
                                </h3>

                                <p class="blog-desc">
                                    {{ Str::limit($community->deskripsi, 120) }}
                                </p>

                                {{-- CEK SUDAH DAFTAR --}}
                                @php

                                    $isJoined = DB::table('community_user')
                                        ->where('community_id', $community->id)
                                        ->where('user_id', auth()->id())
                                        ->exists();

                                @endphp

                                @if ($isJoined)
                                    {{-- BUTTON GABUNG WA --}}
                                    <a href="{{ $community->link }}" target="_blank" class="join-wa-btn">

                                        <i class="ri-whatsapp-line"></i>

                                        Gabung Grup WhatsApp

                                    </a>
                                @else
                                    {{-- BUTTON DAFTAR --}}
                                    <form action="{{ route('community.join', $community->id) }}" method="POST"
                                        class="join-form">

                                        @csrf

                                        <button type="submit" class="register-btn">

                                            <i class="ri-user-add-line"></i>

                                            Daftar Sekarang

                                        </button>

                                    </form>
                                @endif

                            </div>

                        </article>

                    @empty

                        <div class="empty-state">

                            <h3>
                                Belum ada komunitas tersedia.
                            </h3>

                            <p>
                                Silakan kembali lagi nanti.
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </section>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.join-form').forEach(form => {

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Daftar Komunitas?',
                    text: 'Apakah anda yakin ingin bergabung ke komunitas ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Daftar!',
                    cancelButtonText: 'Batal',
                    borderRadius: '18px'

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });
    </script>

    <style>
        .join-wa-btn {

            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: #25D366;
            color: white;

            padding: 12px 18px;

            border-radius: 10px;

            text-decoration: none;
            font-weight: 600;

            transition: 0.3s;

        }

        .join-wa-btn:hover {

            transform: translateY(-2px);

            background: #1ebe5d;

        }

        .register-btn {

            border: none;

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            color: white;

            padding: 12px 18px;

            border-radius: 10px;

            cursor: pointer;

            font-weight: 600;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            transition: 0.3s;

        }

        .register-btn:hover {

            transform: translateY(-2px);

        }

        .empty-state {

            width: 100%;

            background: white;

            border-radius: 16px;

            padding: 50px;

            text-align: center;

        }
    </style>
@endsection
