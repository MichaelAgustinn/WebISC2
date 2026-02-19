<section id="typing-test" style="background: var(--bg-light); padding: 5rem 0;">

    <div class="section-header">
        <h2>Typing Challenge</h2>
        <div class="line"></div>
        <p style="margin-top: 1rem; color: var(--text-light);">
            Uji kecepatan jarimu dan raih peringkat tertinggi di Leaderboard ISC.
        </p>
    </div>

    <div class="typing-teaser-container">
        <div class="typing-teaser-wrapper">

            <div class="teaser-cta">
                <div class="cta-content">
                    <h3>Seberapa Cepat Kamu Mengetik?</h3>
                    <p>Tantang dirimu sendiri dan teman-temanmu. Dapatkan lencana khusus jika kamu berhasil menembus Top
                        3 Minggu Ini!</p>

                    <div class="cta-stats">
                        <div class="cta-stat-item">
                            <i class="ri-timer-flash-line"></i>
                            <span>60 Detik</span>
                        </div>
                        <div class="cta-stat-item">
                            <i class="ri-keyboard-box-line"></i>
                            <span>Akurasi</span>
                        </div>
                        <div class="cta-stat-item">
                            <i class="ri-trophy-line"></i>
                            <span>Rank</span>
                        </div>
                    </div>

                    <a href="{{ route('typing.index') }}" class="btn-start-test">
                        Mulai Tes Sekarang <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
                <div class="cta-img">
                    <img src="https://img.freepik.com/free-vector/typing-concept-illustration_114360-3996.jpg"
                        alt="Typing Illustration">
                </div>
            </div>

            <aside class="leaderboard-sidebar">
                <div class="leaderboard-card">

                    <div class="leaderboard-header-tab">
                        <button class="tab-link active" onclick="switchTeaserTab(event, 'teaser-weekly')">
                            Minggu Ini
                        </button>
                        <button class="tab-link" onclick="switchTeaserTab(event, 'teaser-alltime')">
                            All Time
                        </button>
                    </div>

                    <ul id="teaser-weekly" class="leaderboard-list teaser-list active">
                        @forelse($weeklyTop as $score)
                            <li class="rank-item">
                                <span
                                    class="rank-number {{ $loop->iteration <= 3 ? ['text-gold', 'text-silver', 'text-bronze'][$loop->iteration - 1] : '' }}">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="rank-user">
                                    @if ($score->user->profile && $score->user->profile->photo)
                                        <img src="{{ asset('uploads/profiles/' . $score->user->profile->photo) }}"
                                            class="rank-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($score->user->name) }}&background=0f204b&color=fff"
                                            class="rank-avatar">
                                    @endif
                                    <div class="rank-info">
                                        <h5>{{ Str::limit($score->user->name, 12) }}</h5>
                                        <span>{{ $score->wpm }} WPM</span>
                                    </div>
                                </div>
                                @if ($loop->iteration == 1)
                                    <i class="ri-vip-crown-fill text-gold rank-icon"></i>
                                @endif
                            </li>
                        @empty
                            <li class="rank-item" style="justify-content: center; color: #aaa; padding: 30px;">
                                Belum ada skor minggu ini.
                            </li>
                        @endforelse
                    </ul>

                    <ul id="teaser-alltime" class="leaderboard-list teaser-list" style="display: none;">
                        @forelse($allTimeTop as $score)
                            <li class="rank-item">
                                <span
                                    class="rank-number {{ $loop->iteration <= 3 ? ['text-gold', 'text-silver', 'text-bronze'][$loop->iteration - 1] : '' }}">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="rank-user">
                                    @if ($score->user->profile && $score->user->profile->photo)
                                        <img src="{{ asset('uploads/profiles/' . $score->user->profile->photo) }}"
                                            class="rank-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($score->user->name) }}&background=random"
                                            class="rank-avatar">
                                    @endif
                                    <div class="rank-info">
                                        <h5>{{ Str::limit($score->user->name, 12) }}</h5>
                                        <span>{{ $score->wpm }} WPM</span>
                                    </div>
                                </div>
                                @if ($loop->iteration == 1)
                                    <i class="ri-medal-fill text-gold rank-icon"></i>
                                @endif
                            </li>
                        @empty
                            <li class="rank-item" style="justify-content: center; color: #aaa; padding: 30px;">
                                Belum ada data.
                            </li>
                        @endforelse
                    </ul>

                    <div class="leaderboard-footer">
                        <a href="{{ route('typing.index') }}">Lihat Leaderboard Lengkap</a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

<script>
    function switchTeaserTab(evt, listId) {
        // Hide semua list
        document.querySelectorAll('.teaser-list').forEach(el => el.style.display = 'none');
        // Remove active class dari tombol
        document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));

        // Show target
        document.getElementById(listId).style.display = 'block';
        // Add active class ke tombol yang diklik
        evt.currentTarget.classList.add('active');
    }
</script>

@push('styles')
    <style>
        /* CSS SAMA SEPERTI YANG ANDA BERIKAN */
        .typing-teaser-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .typing-teaser-wrapper {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .teaser-cta {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        .cta-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .cta-content h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .cta-content p {
            color: var(--text-light);
            margin-bottom: 2rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        .cta-img {
            width: 150px;
            opacity: 0.8;
            display: none;
        }

        @media(min-width: 768px) {
            .cta-img {
                display: block;
            }
        }

        .cta-img img {
            width: 100%;
            height: auto;
            mix-blend-mode: multiply;
        }

        .cta-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 2rem;
        }

        .cta-stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .cta-stat-item i {
            font-size: 1.5rem;
            color: var(--accent);
            background: rgba(212, 175, 55, 0.1);
            padding: 8px;
            border-radius: 8px;
        }

        .cta-stat-item span {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .btn-start-test {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: var(--primary);
            color: var(--white);
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(15, 32, 75, 0.2);
        }

        .btn-start-test:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-3px);
        }

        .leaderboard-card {
            background: var(--white);
            border-radius: 15px;
            border: 1px solid #eee;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .leaderboard-header {
            background: var(--primary);
            padding: 1.2rem;
            text-align: center;
            color: var(--white);
        }

        .leaderboard-header h3 {
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .leaderboard-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        /* Styling Header Tab */
        .leaderboard-header-tab {
            display: flex;
            background: var(--primary);
            padding: 0;
        }

        .tab-link {
            flex: 1;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            padding: 15px;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: 0.3s;
        }

        .tab-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .tab-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 3px solid var(--accent);
            /* Garis Emas */
        }

        /* Pastikan List tampil rapi */
        .leaderboard-list {
            min-height: 300px;
            /* Menjaga tinggi agar tidak lompat saat ganti tab */
        }

        .rank-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s;
        }

        .rank-item:hover {
            background: var(--bg-light);
        }

        .rank-number {
            width: 25px;
            font-weight: 800;
            font-style: italic;
            color: var(--text-light);
        }

        .text-gold {
            color: #FFD700;
        }

        .text-silver {
            color: #C0C0C0;
        }

        .text-bronze {
            color: #CD7F32;
        }

        .rank-user {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rank-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f1f5f9;
        }

        .rank-info h5 {
            margin: 0;
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 700;
        }

        .rank-info span {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
        }

        .rank-icon {
            font-size: 1.2rem;
        }

        .leaderboard-footer {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            border-top: 1px solid #eee;
        }

        .leaderboard-footer a {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
        }

        .leaderboard-footer a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .typing-teaser-wrapper {
                grid-template-columns: 1fr;
            }

            .teaser-cta {
                text-align: center;
                flex-direction: column;
            }

            .cta-stats {
                justify-content: center;
            }
        }
    </style>
@endpush
