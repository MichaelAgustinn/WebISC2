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
            display: flex;
        }

        /* STYLE HURUF */
        .char {
            position: relative;
            transition: color 0.1s, background-color 0.1s;
            border-bottom: 2px solid transparent;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Huruf Aktif (Kursor & Underscore) */
        .char.current::before {
            content: "";
            position: absolute;
            left: -1px;
            top: 10%;
            height: 80%;
            width: 2px;
            background-color: var(--primary);
            animation: blink 1s infinite;
        }

        .char.current-right::after {
            content: "";
            position: absolute;
            right: -2px;
            top: 10%;
            height: 80%;
            width: 2px;
            background-color: var(--primary);
            animation: blink 1s infinite;
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

        .char.extra {
            color: #7f1d1d;
            background-color: #fca5a5;
        }

        .char.incorrect {
            color: #ef4444;
            background-color: #fee2e2;
            border-radius: 2px;
        }

        .word.error-word .char {
            text-decoration: underline;
            text-decoration-color: #ef4444;
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

        .language-selector {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1001;
            /* Fix klik dropdown */
        }

        .language-selector select {
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: var(--white);
            color: var(--primary);
            font-weight: 600;
            outline: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .language-selector select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(8, 18, 38, 0.08);
        }

        /* == RESPONSIVE DESIGN (TABLET & MOBILE) ==*/
        @media (max-width: 1024px) {
            .typing-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .typing-header {
                padding: 100px 5% 40px;
            }

            .typing-header h1 {
                font-size: 1.8rem;
            }

            .typing-card {
                padding: 1.2rem;
            }

            .language-selector {
                justify-content: center;
                width: 100%;
            }

            .language-selector select {
                width: 100%;
                text-align: center;
            }

            .stats-bar {
                flex-wrap: wrap;
                gap: 15px;
                padding: 1rem;
                justify-content: space-around;
            }

            .stat-item {
                flex: 1 1 40%;
            }

            .stat-item h4 {
                font-size: 0.75rem;
            }

            .stat-item span {
                font-size: 1.3rem;
            }

            .typing-box {
                padding: 1.2rem 1rem;
                font-size: 1.2rem;
                line-height: 1.8;
                min-height: 180px;
                max-height: 250px;
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

                    <div class="language-selector">
                        <select id="languageSelect">
                            <option value="indonesia">Bahasa Indonesia</option>
                            <option value="java">Java</option>
                            <option value="php">PHP</option>
                            <option value="flutter">Dart / Flutter</option>
                        </select>
                    </div>

                    <div class="stats-bar">
                        <div class="stat-item">
                            <h4>Sisa Waktu</h4>
                            <span class="timer-circle" id="timeLeft">60s</span>
                        </div>
                        <div class="stat-item">
                            <h4>Mistakes</h4>
                            <span id="mistakes">0</span>
                        </div>
                        <span hidden id="wpm">0</span>
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
                        @foreach (['indonesia', 'java', 'php', 'flutter'] as $lang)
                            <ul class="leaderboard-list lang-list lang-{{ $lang }}"
                                style="display: {{ $lang == 'indonesia' ? 'block' : 'none' }}">
                                @forelse($leaderboards[$lang]['weekly'] as $index => $score)
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
                                    <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data untuk bahasa
                                        ini.</li>
                                @endforelse
                            </ul>
                        @endforeach
                    </div>

                    {{-- TAB MONTHLY --}}
                    <div id="monthly" class="tab-content">
                        @foreach (['indonesia', 'java', 'php', 'flutter'] as $lang)
                            <ul class="leaderboard-list lang-list lang-{{ $lang }}"
                                style="display: {{ $lang == 'indonesia' ? 'block' : 'none' }}">
                                @forelse($leaderboards[$lang]['monthly'] as $index => $score)
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
                                    <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data untuk bahasa
                                        ini.</li>
                                @endforelse
                            </ul>
                        @endforeach
                    </div>

                    {{-- TAB ALLTIME --}}
                    <div id="alltime" class="tab-content">
                        @foreach (['indonesia', 'java', 'php', 'flutter'] as $lang)
                            <ul class="leaderboard-list lang-list lang-{{ $lang }}"
                                style="display: {{ $lang == 'indonesia' ? 'block' : 'none' }}">
                                @forelse($leaderboards[$lang]['alltime'] as $index => $score)
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
                                    <li style="padding: 20px; text-align: center; color: #aaa;">Belum ada data untuk bahasa
                                        ini.</li>
                                @endforelse
                            </ul>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- =========================================
       2. JAVASCRIPT LOGIC
    ========================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
            const languageSelect = document.querySelector("#languageSelect");

            let isTabPressed = false;
            let timer;
            let maxTime = 60;
            let timeLeft = maxTime;
            let wordIndex = 0;
            let mistakes = 0;
            let correctKeystrokes = 0;
            let correctWordsCount = 0;
            let isTyping = false;
            let previousTypedValue = "";

            const wordListFlutter = [
                "flutter", "dart", "widget", "state", "stateless", "stateful", "build", "context",
                "materialapp", "scaffold", "appbar", "container", "column", "row", "stack",
                "expanded", "padding", "margin", "center", "align", "text", "icon", "image",
                "button", "elevatedbutton", "textbutton", "iconbutton", "floatingactionbutton",
                "listview", "gridview", "builder", "navigator", "route", "page", "screen",
                "drawer", "bottomnavigationbar", "tabbar", "tabview", "textfield", "form",
                "validator", "textfieldcontroller", "setstate", "future", "async", "await",
                "stream", "snapshot", "futurebuilder", "streambuilder", "provider", "bloc",
                "riverpod", "getx", "controller", "model", "service", "repository", "json",
                "encode", "decode", "http", "api", "dio", "sharedpreferences", "sqflite",
                "firebase", "authentication", "firestore", "storage", "animation", "hero",
                "theme", "darkmode", "lightmode", "mediaquery", "layoutbuilder", "responsive",
                "gesturedetector", "inkwell", "listtile", "card", "dialog", "snackbar",
                "bottomsheet", "safearea", "scrollview", "singlechildscrollview", "customscrollview",
                "sliverappbar", "cliprrect", "opacity", "transform", "lifecycle", "dispose",
                "initstate", "hotreload", "pubspec", "package", "plugin", "dependency",
                "debug", "release", "emulator"
            ];

            const wordListPhp = [
                "php", "echo", "print", "variable", "string", "integer", "float", "boolean",
                "array", "object", "function", "class", "interface", "trait", "namespace",
                "include", "require", "include_once", "require_once", "if", "else", "elseif",
                "switch", "case", "for", "foreach", "while", "do", "break", "continue",
                "return", "public", "private", "protected", "static", "final", "abstract",
                "extends", "implements", "new", "this", "parent", "self", "const", "define",
                "isset", "empty", "unset", "null", "true", "false", "try", "catch", "finally",
                "throw", "exception", "mysqli", "pdo", "query", "database", "select", "insert",
                "update", "delete", "fetch", "session", "cookie", "header", "json", "encode",
                "decode", "html", "form", "post", "get", "request", "response", "server",
                "client", "upload", "download", "file", "directory", "path", "url", "router",
                "middleware", "controller", "model", "view", "template", "blade", "composer",
                "autoload", "artisan", "laravel", "symfony", "codeigniter", "api", "token",
                "authentication", "authorization", "validation"
            ];

            const wordListJava = [
                "class", "object", "method", "variable", "string", "integer", "double", "float",
                "boolean", "char", "array", "loop", "for", "while", "if", "else", "switch",
                "case", "break", "continue", "return", "public", "private", "protected",
                "static", "final", "void", "new", "this", "super", "extends", "implements",
                "interface", "abstract", "package", "import", "scanner", "system", "println",
                "print", "input", "output", "constructor", "getter", "setter", "instance",
                "inheritance", "polymorphism", "encapsulation", "abstraction", "exception",
                "try", "catch", "finally", "throw", "throws", "thread", "runnable", "lambda",
                "stream", "list", "arraylist", "linkedlist", "map", "hashmap", "set", "hashset",
                "iterator", "collection", "collections", "comparable", "comparator", "random",
                "math", "file", "reader", "writer", "buffer", "inputstream", "outputstream",
                "bufferedreader", "bufferedwriter", "serialization", "generic", "annotation",
                "reflection", "enum", "record", "module", "jvm", "jdk", "jre", "bytecode",
                "compile", "runtime", "debug", "syntax", "parameter", "argument", "function",
                "statement", "expression"
            ];

            const wordList = [
                "aku", "kamu", "dia", "kami", "kita", "mereka", "ini", "itu", "ada", "tidak", "sudah",
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
            let activeWordList = wordList;

            function addWords(count) {
                for (let i = 0; i < count; i++) {
                    let randomWord = activeWordList[Math.floor(Math.random() * activeWordList.length)];
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
                previousTypedValue = "";

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
                let originalChars = currentWordDiv.querySelectorAll(".char:not(.extra)");

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

                if (typedValue === " ") {
                    inpField.value = "";
                    return;
                }

                if (typedValue.endsWith(" ")) {
                    let inputTrimmed = typedValue.trim();
                    let targetWord = "";
                    originalChars.forEach(char => targetWord += char.innerText);

                    if (inputTrimmed === targetWord) {
                        currentWordDiv.classList.add("correct");
                        correctWordsCount++;
                    } else {
                        currentWordDiv.classList.add("error-word");
                        mistakes++;
                    }

                    currentWordDiv.classList.remove("active");
                    currentWordDiv.querySelectorAll(".char").forEach(c => c.classList.remove("current",
                        "current-right"));

                    wordIndex++;
                    previousTypedValue = "";
                    inpField.value = "";

                    if (allWords[wordIndex]) {
                        allWords[wordIndex].classList.add("active");
                        let firstChar = allWords[wordIndex].querySelector(".char");
                        if (firstChar) firstChar.classList.add("current");

                        allWords[wordIndex].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    updateStats();
                    return;
                }

                if (typedValue.length > previousTypedValue.length) {
                    let addedCharIndex = typedValue.length - 1;
                    let expectedChar = originalChars[addedCharIndex] ? originalChars[addedCharIndex].innerText :
                        null;

                    if (typedValue[addedCharIndex] !== expectedChar) {} else {
                        correctKeystrokes++;
                    }
                }
                previousTypedValue = typedValue;

                currentWordDiv.querySelectorAll(".extra").forEach(el => el.remove());

                originalChars.forEach((charSpan, index) => {
                    let inputChar = typedValue[index];
                    charSpan.classList.remove("correct", "incorrect", "current", "current-right");

                    if (inputChar) {
                        if (inputChar === charSpan.innerText) {
                            charSpan.classList.add("correct");
                        } else {
                            charSpan.classList.add("incorrect");
                        }
                    }
                });

                if (typedValue.length > originalChars.length) {
                    for (let i = originalChars.length; i < typedValue.length; i++) {
                        let extraSpan = document.createElement("span");
                        extraSpan.innerText = typedValue[i];
                        extraSpan.classList.add("char", "incorrect", "extra");
                        currentWordDiv.appendChild(extraSpan);
                    }
                }

                let updatedAllChars = currentWordDiv.querySelectorAll(".char");
                updatedAllChars.forEach(c => c.classList.remove("current", "current-right"));

                if (typedValue.length < originalChars.length) {
                    originalChars[typedValue.length].classList.add("current");
                } else {
                    if (updatedAllChars.length > 0) {
                        updatedAllChars[updatedAllChars.length - 1].classList.add("current-right");
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

                // Simpan skor
                saveScore(finalWpm, finalAcc);

                // Tambahkan ID "scorecard-export" pada div pembungkus utama
                // Kita juga menambahkan sedikit watermark "ISC Typing Test" di bawahnya
                const customHtml = `
                    <div id="scorecard-export" style="background: #f8fafc; border-radius: 15px; padding: 30px 20px; margin-bottom: 15px; border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
                        <div style="font-size: 4rem; font-weight: 900; color: var(--accent, #f59e0b); line-height: 1; text-shadow: 2px 2px 0px rgba(0,0,0,0.1);">${finalWpm}</div>
                        <div style="font-size: 1.2rem; color: var(--primary, #081226); font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px;">WPM</div>
                        
                        <div style="display: flex; justify-content: space-around; font-size: 0.95rem; background: white; padding: 15px; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                <span style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Kata Typo</span>
                                <div><span style="color: #ef4444; font-weight: 900; font-size: 1.3rem;">${mistakes}</span></div>
                            </div>
                            <div style="width: 2px; background: #e2e8f0; border-radius: 5px;"></div>
                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                <span style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Akurasi</span>
                                <div><span style="color: #22c55e; font-weight: 900; font-size: 1.3rem;">${finalAcc}%</span></div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px; font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="ri-keyboard-line"></i> ISC Typing Test
                        </div>
                    </div>
                    
                    <style>
                        @keyframes spin { 100% { transform: rotate(360deg); } }
                    </style>

                    <button id="btnShare" style="width: 100%; padding: 14px; background: var(--primary, #081226); color: #fff; border: none; border-radius: 50px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; display: flex; justify-content: center; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(8, 18, 38, 0.2);">
                        <i class="ri-camera-lens-fill"></i> Bagikan Gambar 🚀
                    </button>
                `;

                Swal.fire({
                    title: '<span style="color: var(--primary, #081226); font-weight: 800;">Waktu Habis! ⏱️</span>',
                    html: customHtml,
                    backdrop: `rgba(8, 18, 38, 0.85)`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowOutsideClick: false,
                    focusConfirm: false,
                    allowEnterKey: false,
                    allowEscapeKey: false,
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: () => {
                        const btnShare = document.getElementById('btnShare');
                        const scorecard = document.getElementById('scorecard-export');

                        btnShare.addEventListener('click', async () => {
                            const originalText = btnShare.innerHTML;
                            btnShare.innerHTML =
                                `<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i> Memproses...`;
                            btnShare.style.opacity = "0.7";
                            btnShare.disabled = true;

                            try {
                                const canvas = await html2canvas(scorecard, {
                                    scale: 3,
                                    backgroundColor: "#ffffff",
                                    useCORS: true
                                });

                                canvas.toBlob(async (blob) => {
                                    const file = new File([blob],
                                        `ISC_Score_${finalWpm}WPM.png`, {
                                            type: 'image/png'
                                        });
                                    const shareText =
                                        `Kalahkan Skorku ${finalWpm} WPM dan Akurasi ${finalAcc}%. \n\nCoba tesnya di sini: ${window.location.href}`;
                                    const shareData = {
                                        title: 'Skor Kecepatan Ketik ISC',
                                        text: `Kalahkan Skorku ${finalWpm} WPM dan Akurasi ${finalAcc}%. Coba tesnya di sini: ${window.location.href}`,
                                        files: [file]
                                    };

                                    if (navigator.canShare && navigator
                                        .canShare({
                                            files: [file]
                                        })) {
                                        try {
                                            await navigator.share(shareData);
                                            resetShareButton(btnShare,
                                                originalText);
                                        } catch (err) {
                                            resetShareButton(btnShare,
                                                originalText);
                                        }
                                    } else {
                                        const url = URL.createObjectURL(blob);
                                        const a = document.createElement('a');
                                        a.href = url;
                                        a.download = file.name;
                                        document.body.appendChild(a);
                                        a.click();
                                        document.body.removeChild(a);
                                        URL.revokeObjectURL(url);

                                        btnShare.innerHTML =
                                            `<i class="ri-check-double-line"></i> Gambar Diunduh!`;
                                        btnShare.style.background = "#22c55e";
                                        btnShare.style.opacity = "1";

                                        setTimeout(() => {
                                            btnShare.innerHTML =
                                                originalText;
                                            btnShare.style.background =
                                                "var(--primary, #081226)";
                                            btnShare.disabled = false;
                                        }, 2500);
                                    }
                                }, 'image/png');

                            } catch (error) {
                                console.error('Gagal membuat gambar:', error);
                                btnShare.innerHTML =
                                    `<i class="ri-error-warning-line"></i> Gagal Memproses`;
                                setTimeout(() => resetShareButton(btnShare, originalText),
                                    2000);
                            }
                        });

                        function resetShareButton(btn, text) {
                            btn.innerHTML = text;
                            btn.style.opacity = "1";
                            btn.disabled = false;
                        }

                        // Efek Hover
                        btnShare.addEventListener("mouseenter", () => btnShare.style.transform =
                            "translateY(-3px)");
                        btnShare.addEventListener("mouseleave", () => btnShare.style.transform =
                            "translateY(0)");
                    }
                }).then(() => {
                    window.location.reload();
                });
            }

            function saveScore(wpm, accuracy) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    "{{ csrf_token() }}";
                const selectedLang = languageSelect.value;

                fetch("{{ route('typing.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            wpm: wpm,
                            accuracy: accuracy,
                            language: selectedLang
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
                    })
                    .catch(err => {
                        console.error(err);
                    });
            }
            // Events
            inpField.addEventListener("input", initTyping);
            if (btnRestart) btnRestart.addEventListener("click", resetGame);

            languageSelect.addEventListener("change", (e) => {
                const selected = e.target.value;

                if (selected === "java") {
                    activeWordList = wordListJava;
                } else if (selected === "php") {
                    activeWordList = wordListPhp;
                } else if (selected === "flutter") {
                    activeWordList = wordListFlutter;
                } else {
                    activeWordList = wordList;
                }

                document.querySelectorAll('.lang-list').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.lang-' + selected).forEach(el => el.style.display = 'block');

                resetGame();
            });

            inpField.addEventListener("focus", () => typingBox.classList.add("active"));
            inpField.addEventListener("blur", () => typingBox.classList.remove("active"));

            document.addEventListener("keydown", (e) => {

                if (timeLeft <= 0) return;

                if (e.key === "Tab") {
                    isTabPressed = true;
                    e.preventDefault();
                    return;
                }


                if (e.key === "Enter" && isTabPressed) {
                    e.preventDefault();
                    resetGame();
                    isTabPressed = false;
                    return;
                }

                if (e.key !== "Tab") {
                    isTabPressed = false;
                }

                if (document.activeElement === languageSelect) return;
                if (document.activeElement === btnRestart) return;

                if (e.target.tagName !== "INPUT" && e.target.tagName !== "TEXTAREA") {
                    inpField.focus();
                }
            });

            document.addEventListener("keyup", (e) => {
                if (e.key === "Tab") {
                    isTabPressed = false;
                }
            });

            loadGame();
        });
    </script>
@endsection
