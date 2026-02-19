@extends('landing.master')

@section('content')
    {{-- =========================================
       1. STYLE CSS (Navy Theme + Underscore)
    ========================================= --}}
    <style>
        /* HEADER STYLE */
        .typing-header {
            padding: 160px 5% 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            color: var(--white);
            text-align: center;
        }

        .typing-header h1 {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        /* LAYOUT */
        .typing-container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 0;
            position: relative;
            z-index: 20;
        }

        .typing-wrapper {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .typing-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(15, 32, 75, 0.1);
            border: 1px solid #e2e8f0;
            position: relative;
        }

        /* STATS BAR */
        .stats-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            pointer-events: none;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item h4 {
            font-size: 0.85rem;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-item span {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .timer-circle {
            color: var(--accent) !important;
        }

        /* TYPING AREA */
        .typing-box {
            position: relative;
            min-height: 250px;
            max-height: 350px;
            overflow-y: hidden;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 2rem;
            font-family: 'Courier New', Courier, monospace;
            font-size: 1.6rem;
            line-height: 2.2;
            background: #fff;
            cursor: text;
        }

        .typing-box.active {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(8, 18, 38, 0.1);
        }

        .typing-text {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* STYLE KATA */
        .word {
            position: relative;
            border-radius: 4px;
            padding: 2px 0;
            color: #94a3b8;
            display: flex;
        }

        /* STYLE HURUF */
        .char {
            position: relative;
            transition: color 0.1s;
            border-bottom: 2px solid transparent;
        }

        /* Huruf Aktif (Kursor & Underscore) */
        .char.current {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
        }

        /* Kursor Caret */
        .char.current::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10%;
            height: 80%;
            width: 2px;
            background-color: var(--primary);
            animation: blink 1s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        .char.correct {
            color: #22c55e;
        }

        .char.incorrect {
            color: #ef4444;
            background-color: #fee2e2;
            border-radius: 2px;
        }

        .word.error-word .char {
            text-decoration: underline;
            text-decoration-color: red;
            text-decoration-style: wavy;
        }

        .input-field {
            position: absolute;
            z-index: 999;
            opacity: 0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: default;
        }

        /* TOMBOL RESTART */
        .btn-restart {
            margin-top: 2rem;
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            z-index: 1001;
            transition: 0.3s;
        }

        /* Efek Focus untuk Aksesibilitas Keyboard (Tab) */
        .btn-restart:focus {
            outline: 3px solid var(--accent);
            outline-offset: 2px;
        }

        .btn-restart:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Leaderboard CSS */
        .leaderboard-sidebar {
            position: relative;
            z-index: 20;
        }

        .leaderboard-card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(15, 32, 75, 0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            position: sticky;
            top: 100px;
        }

        .leaderboard-header {
            background: var(--primary);
            padding: 1.5rem;
            text-align: center;
            border-bottom: 3px solid var(--accent);
        }

        .leaderboard-header h3 {
            color: var(--white);
            margin: 0;
            font-size: 1.2rem;
        }

        .leaderboard-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 5px;
        }

        .tab-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 12px;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            border-radius: 8px;
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .leaderboard-list {
            padding: 0;
            margin: 0;
            list-style: none;
            max-height: 400px;
            overflow-y: auto;
        }

        .rank-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .rank-number {
            width: 30px;
            font-weight: 900;
            font-size: 1.1rem;
            color: var(--text-light);
        }

        .rank-item:nth-child(1) .rank-number {
            color: #FFD700;
        }

        .rank-item:nth-child(2) .rank-number {
            color: #C0C0C0;
        }

        .rank-item:nth-child(3) .rank-number {
            color: #CD7F32;
        }

        .rank-user {
            flex-grow: 1;
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
            font-size: 0.75rem;
            color: var(--text-light);
            text-transform: uppercase;
        }

        .rank-score {
            font-weight: 700;
            color: var(--accent);
            font-size: 0.9rem;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        @media (max-width: 1024px) {
            .typing-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <header class="typing-header">
        <h1>Uji Kecepatan Ketik</h1>
        <p>Seberapa cepat jari-jarimu menari di atas keyboard? Uji sekarang dan raih posisi puncak di ISC Leaderboard.</p>
    </header>

    <section class="typing-container">
        <div class="typing-wrapper">
            <div class="typing-area">
                <div class="typing-card">
                    <input type="text" class="input-field" autocomplete="off">

                    <div class="stats-bar">
                        <div class="stat-item">
                            <h4>Sisa Waktu</h4>
                            <span class="timer-circle" id="timeLeft">60s</span>
                        </div>
                        <div class="stat-item">
                            <h4>Mistakes</h4>
                            <span id="mistakes">0</span>
                        </div>
                        <div class="stat-item">
                            <h4>WPM</h4>
                            <span id="wpm">0</span>
                        </div>
                        <div class="stat-item">
                            <h4>Akurasi</h4>
                            <span id="accuracy">100%</span>
                        </div>
                    </div>

                    <div class="typing-box">
                        <div class="typing-text"></div>
                    </div>

                    <button class="btn-restart" id="btnRestart">
                        <i class="ri-refresh-line"></i> Ulangi Tes
                    </button>

                    @guest
                        <p style="text-align: center; margin-top: 15px; font-size: 0.85rem; color: #ef4444;">
                            *Login untuk menyimpan skor Anda ke leaderboard.
                        </p>
                    @endguest
                </div>
            </div>

            <aside class="leaderboard-sidebar">
                <div class="leaderboard-card">
                    <div class="leaderboard-header">
                        <h3><i class="ri-medal-fill"></i> Leaderboard</h3>
                    </div>

                    <div class="leaderboard-tabs">
                        <button class="tab-btn active" onclick="openTab(event, 'weekly')">Mingguan</button>
                        <button class="tab-btn" onclick="openTab(event, 'monthly')">Bulanan</button>
                        <button class="tab-btn" onclick="openTab(event, 'alltime')">All Time</button>
                    </div>

                    {{-- TAB WEEKLY --}}
                    <div id="weekly" class="tab-content active">
                        <ul class="leaderboard-list">
                            @forelse($weekly as $index => $score)
                                <li class="rank-item">
                                    <span class="rank-number">{{ $index + 1 }}</span>
                                    <div class="rank-user">
                                        @if ($score->user->profile && $score->user->profile->photo)
                                            <img src="{{ asset('uploads/profiles/' . $score->user->profile->photo) }}"
                                                class="rank-avatar">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($score->user->name) }}&background=0f204b&color=fff"
                                                class="rank-avatar">
                                        @endif
                                        <div class="rank-info">
                                            <h5>{{ Str::limit($score->user->name, 15) }}</h5>
                                            <span>{{ ucfirst($score->user->role) }}</span>
                                        </div>
                                    </div>
                                    <span class="rank-score">{{ $score->wpm }} WPM</span>
                                </li>
                            @empty
                                <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- TAB MONTHLY --}}
                    <div id="monthly" class="tab-content">
                        <ul class="leaderboard-list">
                            @forelse($monthly as $index => $score)
                                <li class="rank-item">
                                    <span class="rank-number">{{ $index + 1 }}</span>
                                    <div class="rank-user">
                                        @if ($score->user->profile && $score->user->profile->photo)
                                            <img src="{{ asset('uploads/profiles/' . $score->user->profile->photo) }}"
                                                class="rank-avatar">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($score->user->name) }}&background=0f204b&color=fff"
                                                class="rank-avatar">
                                        @endif
                                        <div class="rank-info">
                                            <h5>{{ Str::limit($score->user->name, 15) }}</h5>
                                            <span>{{ ucfirst($score->user->role) }}</span>
                                        </div>
                                    </div>
                                    <span class="rank-score">{{ $score->wpm }} WPM</span>
                                </li>
                            @empty
                                <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- TAB ALLTIME --}}
                    <div id="alltime" class="tab-content">
                        <ul class="leaderboard-list">
                            @forelse($alltime as $index => $score)
                                <li class="rank-item">
                                    <span class="rank-number">{{ $index + 1 }}</span>
                                    <div class="rank-user">
                                        @if ($score->user->profile && $score->user->profile->photo)
                                            <img src="{{ asset('uploads/profiles/' . $score->user->profile->photo) }}"
                                                class="rank-avatar">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($score->user->name) }}&background=0f204b&color=fff"
                                                class="rank-avatar">
                                        @endif
                                        <div class="rank-info">
                                            <h5>{{ Str::limit($score->user->name, 15) }}</h5>
                                            <span>{{ ucfirst($score->user->role) }}</span>
                                        </div>
                                    </div>
                                    <span class="rank-score">{{ $score->wpm }} WPM</span>
                                </li>
                            @empty
                                <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- =========================================
       2. JAVASCRIPT LOGIC
    ========================================= --}}
    <script>
        function openTab(evt, tabName) {
            if (evt) evt.preventDefault();
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.style.display = 'none');
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            document.getElementById(tabName).style.display = 'block';
            if (evt) evt.currentTarget.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {

            const typingText = document.querySelector(".typing-text");
            const inpField = document.querySelector(".input-field");
            const typingBox = document.querySelector(".typing-box");
            const btnRestart = document.getElementById("btnRestart");

            const timeTag = document.querySelector("#timeLeft");
            const mistakeTag = document.querySelector("#mistakes");
            const wpmTag = document.querySelector("#wpm");
            const accuracyTag = document.querySelector("#accuracy");

            let timer;
            let maxTime = 60;
            let timeLeft = maxTime;
            let wordIndex = 0;
            let mistakes = 0;
            let correctKeystrokes = 0;
            let correctWordsCount = 0;
            let isTyping = false;

            const wordList = [
                "aku", "kamu", "dia", "kami", "kita", "mereka", "ini", "itu", "ada", "tidak", "ya", "sudah",
                "belum", "makan", "minum", "pergi", "datang", "lihat", "tahu", "mau", "bisa", "harus", "akan",
                "jadi", "buat", "ambil", "beri", "pakai", "kerja", "main", "tidur", "bangun", "duduk",
                "berdiri", "jalan", "lari", "senyum", "tanya", "jawab", "pikir", "rasa", "cinta", "suka",
                "benci", "besar", "kecil", "panjang", "pendek", "tinggi", "rendah", "cepat", "lambat", "baru",
                "lama", "baik", "buruk", "benar", "salah", "mudah", "sulit", "dekat", "jauh", "banyak",
                "sedikit", "semua", "orang", "anak", "teman", "rumah", "sekolah", "kantor", "pasar", "kota",
                "desa", "negara", "dunia", "hari", "malam", "pagi", "siang", "sore", "minggu", "bulan", "tahun",
                "waktu", "air", "api", "tanah", "angin", "langit", "laut", "gunung", "sungai", "hutan", "hewan",
                "tani", "ikan", "nasi", "roti", "buah", "sayur", "daging", "gula", "garam", "kopi", "teh",
                "susu", "baju", "celana", "sepatu", "buku", "meja", "kursi", "pintu", "kaca", "mobil", "motor",
                "sepeda", "uang", "harga", "nama", "cerita", "lagu", "film", "gambar", "suara", "warna",
                "hitam", "putih", "merah", "biru", "hijau", "kuning", "coklat", "abu", "manis", "asin", "pahit",
                "pedas", "asam", "dingin", "panas", "hujan", "cerah", "gelap", "terang", "sehat", "sakit",
                "kuat", "lemah", "kaya", "miskin", "tua", "muda", "pria", "wanita", "guru", "murid", "dokter",
                "petani", "nelayan", "polisi", "tentara", "sopir", "tulis", "baca", "nyanyi", "main", "pimpin",
                "rakyat", "bahasa", "kata", "kalimat", "angka", "bentuk", "ukur", "contoh", "alasan", "tuju",
                "harap", "mimpi", "soal", "pilih", "putus", "bantu", "usaha", "hasil", "proses", "cara", "atur",
                "berita", "sejarah", "budaya", "agama", "giat", "jalan", "temu", "ubah", "tumbuh", "butuh"
            ];

            function addWords(count) {
                for (let i = 0; i < count; i++) {
                    let randomWord = wordList[Math.floor(Math.random() * wordList.length)];
                    let wordDiv = document.createElement("div");
                    wordDiv.classList.add("word");

                    randomWord.split("").forEach(char => {
                        let span = document.createElement("span");
                        span.innerText = char;
                        span.classList.add("char");
                        wordDiv.appendChild(span);
                    });
                    typingText.appendChild(wordDiv);
                }
            }

            function loadGame() {
                typingText.innerHTML = "";
                addWords(50);

                let firstWord = typingText.querySelectorAll(".word")[0];
                firstWord.classList.add("active");
                if (firstWord.querySelector(".char")) {
                    firstWord.querySelector(".char").classList.add("current");
                }

                typingBox.scrollTop = 0;
                inpField.value = "";
                inpField.focus();
            }

            function resetGame() {
                clearInterval(timer);
                timeLeft = maxTime;
                wordIndex = mistakes = correctKeystrokes = correctWordsCount = 0;
                isTyping = false;

                inpField.disabled = false;
                timeTag.innerText = timeLeft + "s";
                wpmTag.innerText = 0;
                mistakeTag.innerText = 0;
                accuracyTag.innerText = "100%";

                loadGame();
                typingBox.classList.add("active");
            }

            function initTyping() {
                let allWords = typingText.querySelectorAll(".word");
                let currentWordDiv = allWords[wordIndex];
                let currentWordChars = currentWordDiv.querySelectorAll(".char");

                let typedValue = inpField.value;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    finishGame();
                    return;
                }

                if (!isTyping) {
                    timer = setInterval(initTimer, 1000);
                    isTyping = true;
                }

                if (wordIndex > allWords.length - 15) {
                    addWords(20);
                    allWords = typingText.querySelectorAll(".word");
                }

                // --- SPASI (SUBMIT KATA) ---
                if (typedValue.endsWith(" ")) {
                    let inputTrimmed = typedValue.trim();

                    if (inputTrimmed.length === 0) {
                        inpField.value = "";
                        return;
                    }

                    let targetWord = "";
                    currentWordChars.forEach(char => targetWord += char.innerText);

                    if (inputTrimmed === targetWord) {
                        currentWordDiv.classList.add("correct");
                        correctWordsCount++;
                        correctKeystrokes += targetWord.length + 1;
                    } else {
                        currentWordDiv.classList.add("error-word");
                        mistakes++;
                    }

                    currentWordDiv.classList.remove("active");
                    currentWordChars.forEach(c => c.classList.remove("current"));

                    wordIndex++;

                    if (allWords[wordIndex]) {
                        allWords[wordIndex].classList.add("active");
                        let firstChar = allWords[wordIndex].querySelector(".char");
                        if (firstChar) firstChar.classList.add("current");

                        allWords[wordIndex].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }

                    inpField.value = "";

                } else {
                    // --- PER KARAKTER (VISUAL CHECK) ---
                    currentWordChars.forEach((charSpan, index) => {
                        let inputChar = typedValue[index];
                        charSpan.classList.remove("correct", "incorrect", "current");

                        if (inputChar) {
                            if (inputChar === charSpan.innerText) {
                                charSpan.classList.add("correct");
                            } else {
                                charSpan.classList.add("incorrect");
                            }
                        }
                    });

                    // Set Kursor (Underscore & Caret)
                    let nextCharIndex = typedValue.length;
                    if (currentWordChars[nextCharIndex]) {
                        currentWordChars[nextCharIndex].classList.add("current");
                    }
                }

                updateStats();
            }

            function updateStats() {
                let timeSpent = maxTime - timeLeft;
                if (timeSpent < 1) timeSpent = 1;

                let wpm = Math.round((correctKeystrokes / 5) / (timeSpent / 60));
                wpm = wpm < 0 || !wpm ? 0 : wpm;

                wpmTag.innerText = wpm;
                mistakeTag.innerText = mistakes;

                let totalAttempt = wordIndex;
                let accuracy = (totalAttempt > 0) ? Math.round((correctWordsCount / totalAttempt) * 100) : 100;
                accuracyTag.innerText = accuracy + "%";
            }

            function initTimer() {
                if (timeLeft > 0) {
                    timeLeft--;
                    timeTag.innerText = timeLeft + "s";
                    updateStats();
                } else {
                    clearInterval(timer);
                    finishGame();
                }
            }

            function finishGame() {
                inpField.disabled = true;
                inpField.value = "";

                const finalWpm = parseInt(wpmTag.innerText) || 0;
                const finalAccText = accuracyTag.innerText.replace('%', '');
                const finalAcc = parseInt(finalAccText) || 0;

                alert(`Waktu Habis!\nSkor Anda: ${finalWpm} WPM\nAkurasi: ${finalAcc}%`);
                saveScore(finalWpm, finalAcc);
            }

            function saveScore(wpm, accuracy) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    "{{ csrf_token() }}";

                fetch("{{ route('typing.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            wpm: wpm,
                            accuracy: accuracy
                        })
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Error');
                        return data;
                    })
                    .then(data => {
                        btnRestart.innerHTML = `<i class="ri-check-double-line"></i> Skor Tersimpan!`;
                        btnRestart.style.background = "#22c55e";
                        setTimeout(() => window.location.reload(), 1500);
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Gagal simpan skor: " + err.message);
                    });
            }

            // Events
            inpField.addEventListener("input", initTyping);
            if (btnRestart) btnRestart.addEventListener("click", resetGame);

            // Visual Focus
            inpField.addEventListener("focus", () => typingBox.classList.add("active"));
            inpField.addEventListener("blur", () => typingBox.classList.remove("active"));

            // --- PERBAIKAN STRUKTUR NAVIGASI KEYBOARD ---
            document.addEventListener("keydown", (e) => {
                // 1. Izinkan TAB untuk navigasi normal (Aksesibilitas)
                if (e.key === "Tab") return;

                // 2. Jika tombol Restart sedang fokus, biarkan Enter menekannya
                if (document.activeElement === btnRestart) return;

                // 3. Sisanya, paksa fokus ke input field agar bisa langsung ngetik
                if (e.target.tagName !== "INPUT" && e.target.tagName !== "TEXTAREA") {
                    inpField.focus();
                }
            });

            loadGame();
        });
    </script>
@endsection
