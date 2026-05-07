@extends('landing.master')

@push('styles')
    <style>
        /* Desain Khusus Card Event */
        .event-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary, #e2e8f0);
        }

        .event-img-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .event-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .event-card:hover .event-img-wrapper img {
            transform: scale(1.08);
        }

        .exclusive-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .event-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .event-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px dashed #e2e8f0;
        }

        .event-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .event-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .event-desc {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* Tombol Interaktif */
        .btn-event {
            width: 100%;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-event:active {
            transform: scale(0.97);
        }

        .btn-disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .btn-register {
            background: var(--primary, #4f46e5);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-register:hover {
            background: var(--accent);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            background: #20bd5a;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }
    </style>
@endpush

@section('content')
    <header class="blog-header">
        <h1>Event & Kegiatan</h1>
        <p>Temukan berbagai kegiatan seru. Eksklusif untuk anggota Informatics Study Club.</p>
    </header>

    <section class="blog-container">
        <div class="blog-wrapper">

            <!-- BAGIAN KIRI: DAFTAR EVENT -->
            <div class="blog-main">

                @if (session('success'))
                    <div
                        style="background: #ecfdf5; color: #059669; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 10px; font-weight: 500;">
                        <i class="ri-checkbox-circle-fill" style="font-size: 1.5rem;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="blog-list">
                    @forelse($events as $event)
                        <article class="event-card">
                            <div class="event-img-wrapper">
                                <!-- Tag Eksklusif -->
                                <span class="exclusive-badge">
                                    <i class="ri-vip-crown-fill"></i> Eksklusif
                                </span>
                                <img src="{{ asset($event->photo) }}" alt="{{ $event->name }}">
                            </div>

                            <div class="event-body">
                                <div class="event-meta">
                                    <span><i class="ri-calendar-event-line text-indigo-500"></i>
                                        {{ $event->created_at->format('d M Y') }}</span>
                                    <span><i class="ri-group-fill text-green-500"></i> {{ $event->users->count() }}
                                        Terdaftar</span>
                                </div>

                                <h3 class="event-title">{{ $event->name }}</h3>
                                <p class="event-desc">{{ Str::limit($event->deskripsi, 90, '...') }}</p>

                                <div style="margin-top: auto;">
                                    <a href="{{ route('landing.events.show', $event->slug) }}"
                                        class="btn-event btn-register" style="text-align: center; justify-content: center;">
                                        <i class="ri-eye-line" style="font-size: 1.2rem;"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div
                            style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;">
                            <div
                                style="background: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                <i class="ri-calendar-close-line" style="font-size: 2.5rem; color: #94a3b8;"></i>
                            </div>
                            <h3 style="color: #1e293b; margin-bottom: 8px; font-weight: 700;">Belum ada event tersedia</h3>
                            <p style="color: #64748b;">Nantikan kegiatan seru dari kami selanjutnya!</p>
                        </div>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                <div class="pagination mt-5" style="display: flex; justify-content: center;">
                    {{ $events->withQueryString()->links('vendor.pagination.custom') }}
                </div>
            </div>

            <!-- BAGIAN KANAN: SIDEBAR -->
            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h4 class="widget-title">Cari Event</h4>
                    <form class="search-form" action="{{ route('events.public') }}" method="GET">
                        <input type="text" name="search" placeholder="Ketik nama event..."
                            value="{{ request('search') }}">
                        <button type="submit"><i class="ri-search-2-line"></i></button>
                    </form>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Event Terbaru</h4>
                    @forelse ($recentEvents as $recent)
                        <div class="recent-post-item"
                            style="transition: background 0.3s ease; border-radius: 8px; padding: 5px;">
                            <img src="{{ asset($recent->photo) }}" alt="{{ $recent->name }}" class="rp-thumb"
                                style="object-fit: cover; border-radius: 6px;">
                            <div class="rp-info">
                                <h5 style="margin-bottom: 4px; line-height: 1.3;">
                                    <a href="#"
                                        style="color: #1e293b; font-weight: 600;">{{ Str::limit($recent->name, 35) }}</a>
                                </h5>
                                <span class="rp-divisi" style="font-size: 0.75rem; color: #64748b;">
                                    <i class="ri-time-line"></i> {{ $recent->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p style="font-size: 0.9rem; color: #64748b; text-align: center;">Belum ada event.</p>
                    @endforelse
                </div>
            </aside>

        </div>
    </section>
@endsection
