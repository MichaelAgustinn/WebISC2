<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')
    <title>Informatics Study Club</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@500;700;900&family=Playfair+Display:ital,wght@1,600&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        /* =========================================
        1. RESET, VARIABEL & GLOBAL
        ========================================= */
        :root {
            /* Warna Utama */
            --primary: #0f204b;
            --primary-light: #1e3a8a;
            --accent: #d4af37;
            /* Emas */
            --accent-light: #f3e5ab;

            /* Tipografi & Latar */
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --bg-light: #f8fafc;

            /* Efek */
            --shadow: 0 10px 30px -10px rgba(15, 32, 75, 0.2);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
            /* Mencegah judul tertutup navbar */
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            color: var(--primary);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        img {
            width: 100%;
            display: block;
        }

        /* =========================================
        2. NAVBAR & NAVIGATION
        ========================================= */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: transparent;
            /* Default transparan di Home */
            transition: var(--transition);
        }

        /* Navbar saat discroll (Solid) */
        .navbar.scrolled {
            background: rgba(15, 32, 75, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            padding: 1rem 5%;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .menu-toggle {
            display: none;
            color: var(--accent);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Tombol Login Khusus */
        .nav-links .login-btn {
            background-color: var(--accent);
            color: var(--primary) !important;
            padding: 0.6rem 1.8rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            margin-left: 10px;
        }

        .nav-links .login-btn::after {
            display: none;
        }

        .nav-links .login-btn:hover {
            background-color: var(--white);
            color: var(--primary) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
        }

        /* Dropdown Menu (Desktop) */
        .dropdown-item {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .dropdown-item>a {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Cari bagian ini di CSS Anda dan GANTI dengan yang baru ini */
        .dropdown-menu {
            position: absolute;
            top: 100%;

            /* PERUBAHAN 1: MENGGESER KE KIRI */
            /* Menggunakan left: auto dan right: 0 agar dropdown rata kanan dengan teks menu */
            /* Ini akan membuat kotaknya "tumbuh" ke arah kiri, menjauhi tombol login */
            left: auto;
            right: 0;

            /* Opsional: Jika masih kurang ke kiri, bisa pakai margin-right */
            /* margin-right: 20px; */

            /* PERUBAHAN 2: MEMBAWA KE DEPAN (LAYER ATAS) */
            z-index: 9999;

            background-color: var(--white);
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;

            /* Animasi Awal (Tersembunyi) */
            transform: translateY(20px);
            transition: all 0.3s ease;
            border-top: 3px solid var(--accent);
            display: block !important;
        }

        .dropdown-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li {
            display: block;
            margin: 0;
        }

        .dropdown-menu li a {
            color: var(--text-dark);
            padding: 10px 20px;
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dropdown-menu li a::after {
            display: none;
        }

        .dropdown-menu li a:hover {
            background-color: var(--bg-light);
            color: var(--primary);
            padding-left: 25px;
        }

        .dropdown-item>a i {
            transition: transform 0.3s ease;
            transform: rotate(0deg);
        }

        /* =========================================
        3. SHARED SECTION STYLES
        ========================================= */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .section-header .line {
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 0 auto;
            border-radius: 2px;
        }

        .section-divider {
            position: relative;
            height: 120px;
            background-color: var(--primary);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image:
                linear-gradient(rgba(212, 175, 55, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212, 175, 55, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .section-divider::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.7;
            box-shadow: 0 0 10px var(--accent);
        }

        .divider-icon {
            color: var(--accent);
            font-size: 1.8rem;
            background: var(--primary);
            padding: 0 20px;
            z-index: 2;
            position: relative;
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 4px;
        }

        /* =========================================
        4. HOME PAGE SECTIONS
        ========================================= */

        /* Hero Section */
        #home {
            position: relative;
            height: 100vh;
            width: 100%;
            background: radial-gradient(circle at center, #1a3a6e, var(--primary));
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: none;
        }

        #smokeCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 15vw;
            color: rgba(255, 255, 255, 0.03);
            white-space: nowrap;
            z-index: 0;
            user-select: none;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 4;
            color: var(--white);
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s forwards 0.5s;
            color: var(--white);
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .hero-title span {
            color: var(--accent);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s forwards 0.8s;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* About Section */
        #about {
            padding: 5rem 10%;
            background: var(--white);
            position: relative;
            z-index: 5;
        }

        .about-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-img-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 2px solid var(--accent);
        }

        .about-img-wrapper img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .about-text h3 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .about-text p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        /* Visi Misi Section */
        #visi-misi {
            padding: 5rem 10%;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            color: var(--white);
        }

        .vm-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .vm-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 2.5rem;
            border-radius: 15px;
            transition: var(--transition);
        }

        .vm-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .vm-icon {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .vm-card h3 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }

        .vm-card ul li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        .vm-card ul li i {
            color: var(--accent);
            margin-top: 5px;
        }

        /* Creation Section */
        #creation {
            padding: 5rem 5%;
            background: var(--bg-light);
        }

        .filter-menu {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .filter-btn {
            border: none;
            background: transparent;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid #ddd;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary);
            color: var(--accent);
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(15, 32, 75, 0.3);
        }

        .creation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .creation-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border-bottom: 3px solid transparent;
        }

        .creation-card.hide {
            display: none;
        }

        .creation-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow);
            border-bottom-color: var(--accent);
        }

        .card-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .creation-card:hover .card-img img {
            transform: scale(1.1);
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-tag {
            font-size: 0.8rem;
            color: var(--accent);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        /* Team Section */
        #team {
            padding: 5rem 5%;
            background: var(--white);
        }

        .team-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .team-card {
            flex: 0 1 250px;
            min-width: 250px;
            background: var(--white);
            border-radius: 15px;
            padding: 2rem 1rem;
            text-align: center;
            border: 1px solid #eee;
            transition: var(--transition);
        }

        .team-card:hover {
            border-color: var(--accent);
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .team-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            object-fit: cover;
            border: 3px solid var(--accent);
            padding: 3px;
            background: white;
        }

        .team-name {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 0.2rem;
        }

        .team-role {
            font-size: 0.9rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* FAQ Section */
        #faq {
            padding: 5rem 5%;
            background: var(--white);
        }

        .faq-container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        .faq-item {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: var(--transition);
        }

        .faq-item:hover {
            border-color: var(--accent);
        }

        .faq-question {
            background: #fff;
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--primary);
            transition: var(--transition);
        }

        .faq-question:hover {
            background: var(--bg-light);
        }

        .faq-question i {
            color: var(--accent);
            transition: transform 0.3s ease;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            padding: 0 1.5rem;
            background: #f8fafc;
            color: var(--text-light);
            transition: all 0.3s ease;
            opacity: 0;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
            padding: 1rem 1.5rem 1.5rem;
            opacity: 1;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        /* =========================================
        5. BLOG SYSTEM (GRID & PAGE)
        ========================================= */

        /* Blog Preview (Home Section) */
        #blog {
            padding: 5rem 5%;
            background: var(--bg-light);
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .blog-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            border-bottom: 3px solid transparent;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-bottom-color: var(--accent);
        }

        .blog-date {
            padding: 1rem 1.5rem 0;
            font-size: 0.85rem;
            color: var(--accent);
            font-weight: 600;
        }

        .blog-content {
            padding: 1rem 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .read-more {
            color: var(--primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: auto;
        }

        .read-more:hover {
            color: var(--accent);
        }

        /* Button View All (Home) */
        .btn-view-all-wrapper {
            text-align: center;
            margin-top: 3rem;
        }

        .btn-view-all {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 35px;
            border: 2px solid var(--primary);
            border-radius: 50px;
            color: var(--primary);
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-view-all i {
            transition: transform 0.3s ease;
        }

        .btn-view-all:hover {
            background-color: var(--primary);
            color: var(--accent);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(15, 32, 75, 0.2);
            border-color: var(--primary);
        }

        .btn-view-all:hover i {
            transform: translateX(5px);
        }

        /* --- SPECIFIC FULL BLOG PAGE STYLES --- */

        .blog-header {
            padding: 140px 5% 60px;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            text-align: center;
            color: var(--white);
        }

        .blog-header h1 {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .blog-header p {
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.1rem;
        }

        .blog-container {
            width: 95%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 4rem 0;
        }

        .blog-wrapper {
            display: grid;
            grid-template-columns: 3.5fr 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        .blog-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        /* Blog Meta & Categories */
        .category-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .blog-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 0.8rem;
        }

        .blog-meta i {
            color: var(--accent);
            margin-right: 5px;
        }

        .blog-desc {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        /* Sidebar & Widgets */
        .sidebar {
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            min-width: 300px;
        }

        .sidebar-widget {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--accent);
            display: inline-block;
            color: var(--primary);
        }

        /* Widget Search */
        .search-form {
            display: flex;
            position: relative;
        }

        .search-form input {
            width: 100%;
            padding: 12px 15px;
            padding-right: 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: var(--transition);
        }

        .search-form input:focus {
            border-color: var(--primary);
        }

        .search-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            width: 35px;
            height: 35px;
            background: var(--primary);
            color: var(--accent);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-form button:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Widget Recent Post */
        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 1.2rem;
            align-items: center;
        }

        .recent-post-item:last-child {
            margin-bottom: 0;
        }

        .rp-thumb {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .rp-info h5 {
            font-size: 0.95rem;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .rp-info h5 a {
            color: var(--primary);
            font-weight: 600;
        }

        .rp-info h5 a:hover {
            color: var(--accent);
        }

        .rp-date {
            font-size: 0.75rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rp-date i {
            color: var(--accent);
        }

        /* Widget Category */
        .category-list li {
            border-bottom: 1px solid #eee;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 5px;
            font-weight: 500;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .category-list a:hover {
            color: var(--primary);
            padding-left: 10px;
        }

        .cat-count {
            background: var(--bg-light);
            color: var(--primary);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .category-list a:hover .cat-count {
            background: var(--accent);
            color: var(--primary);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 4rem;
            grid-column: 1 / -1;
        }

        .page-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: var(--white);
            color: var(--primary);
            font-weight: 600;
        }

        .page-link:hover,
        .page-link.active {
            background: var(--primary);
            color: var(--accent);
            border-color: var(--primary);
        }

        /* =========================================
        6. FOOTER
        ========================================= */
        footer {
            background: var(--primary);
            color: var(--white);
            padding-top: 4rem;
            font-size: 0.95rem;
            border-top: 4px solid var(--accent);
            position: relative;
            z-index: 2;
        }

        .footer-container {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 3rem;
            padding: 0 5% 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-col h3 {
            color: var(--accent);
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contact-info li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #cbd5e1;
        }

        .contact-info i {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .footer-nav {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .footer-nav a {
            color: #cbd5e1;
            transition: 0.3s;
        }

        .footer-nav a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--accent);
            font-size: 1.2rem;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .social-links a:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            background: #081226;
            text-align: center;
            padding: 1.5rem;
            color: #94a3b8;
            font-size: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* =========================================
        7. RESPONSIVE MEDIA QUERIES
        ========================================= */

        /* Tablet & Small Desktop (Max 1024px) */
        @media (max-width: 1024px) {
            .blog-wrapper {
                grid-template-columns: 1fr;
                /* Blog layout jadi 1 kolom (stack) */
            }

            .sidebar {
                min-width: auto;
                position: static;
                margin-top: 2rem;
            }

            .blog-container {
                width: 90%;
            }
        }

        /* Mobile (Max 768px) */
        @media (max-width: 768px) {

            /* Navbar Mobile */
            .navbar.scrolled,
            .navbar {
                background: var(--primary);
                padding: 1rem 5%;
            }

            .nav-links {
                position: absolute;
                top: 70px;
                right: 0;
                width: 100%;
                background: var(--primary);
                flex-direction: column;
                align-items: center;
                padding: 2rem 0;
                transform: translateY(-150%);
                transition: transform 0.3s ease-in-out;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .nav-links.active {
                transform: translateY(0);
            }

            .menu-toggle {
                display: block;
            }

            /* Login Button Fix */
            .nav-links .login-btn {
                display: inline-block;
                width: auto;
                min-width: 200px;
                margin: 1.5rem auto 0 auto;
                padding: 15px 30px;
                text-align: center;
                background-color: var(--accent);
                color: var(--primary) !important;
                white-space: nowrap;
            }

            .nav-links li {
                width: 100%;
                text-align: center;
            }

            /* Dropdown Mobile Fix */
            .dropdown-item {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .dropdown-item>a {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                gap: 5px;
            }

            .dropdown-menu {
                position: static;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.05);
                width: 100%;
                opacity: 1;
                visibility: visible;
                transform: none;
                border-top: none;
                padding: 0;
                margin-top: 10px;
                display: none !important;
                /* JS Toggle required to show */
                text-align: center;
            }

            .dropdown-item.active .dropdown-menu {
                display: block !important;
                animation: fadeIn 0.3s ease;
            }

            .dropdown-item.active>a i {
                transform: rotate(180deg);
            }

            .dropdown-menu li {
                width: 100%;
            }

            .dropdown-menu li a {
                color: rgba(255, 255, 255, 0.7);
                padding: 10px 0;
                display: block;
                text-align: center;
            }

            .dropdown-menu li a:hover {
                color: var(--accent);
                background: transparent;
                padding-left: 0;
            }

            /* Content Adjustments */
            .about-container {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
            }

            .about-container p {
                text-align: justify;
                hyphens: auto;
            }

            .about-img-wrapper img {
                height: 250px;
            }

            .vm-container,
            .footer-container,
            .faq-container {
                grid-template-columns: 1fr;
            }

            .hero-title,
            .blog-header h1 {
                font-size: 2.5rem;
            }

            section,
            .blog-container {
                padding: 3rem 5% !important;
            }
        }

        /* =========================================
           10. TAMBAHAN: AUTO SCROLL REVEAL STYLES
           ========================================= */

        /* Class awal (tersembunyi) */
        .js-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: opacity, transform;
        }

        /* Class saat muncul (GANTI NAMA jadi .revealed) */
        .js-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* KHUSUS CREATION CARD:
           Agar animasi filter lebih mulus, kita timpa transisi scroll */
        .creation-card {
            transition: all 0.4s ease-in-out !important;
        }

        /* =========================================
   BACK TO TOP BUTTON
   ========================================= */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--accent);
            /* Warna Emas */
            color: var(--primary);
            /* Warna Biru Tua */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.5rem;
            z-index: 999;
            /* Pastikan di atas elemen lain */
            opacity: 0;
            /* Tersembunyi saat awal */
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        /* Keadaan Aktif (Muncul) */
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Efek Hover */
        .back-to-top:hover {
            background-color: var(--primary);
            color: var(--accent);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(15, 32, 75, 0.5);
        }
    </style>

    @stack('styles')
</head>
