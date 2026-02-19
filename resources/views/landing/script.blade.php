<script>
    document.addEventListener('DOMContentLoaded', () => {

        // =========================================
        // 1. SELECTORS & NAVBAR
        // =========================================
        const navbar = document.querySelector('.navbar');
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenu = document.querySelector('.nav-links');
        const navLinksList = document.querySelectorAll('.nav-links a, .logo, .footer-nav a');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }

        // =========================================
        // 2. DROPDOWN (MOBILE)
        // =========================================
        const dropdownToggle = document.querySelector('.dropdown-item > a');
        const dropdownItem = document.querySelector('.dropdown-item');

        if (dropdownToggle && dropdownItem) {
            dropdownToggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    dropdownItem.classList.toggle('active');
                }
            });
            document.addEventListener('click', function(e) {
                if (!dropdownItem.contains(e.target) && window.innerWidth <= 768) {
                    dropdownItem.classList.remove('active');
                }
            });
        }

        // =========================================
        // 3. SMOOTH SCROLL
        // =========================================
        navLinksList.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId.startsWith('#') && targetId.length > 1) {
                    e.preventDefault();
                    const targetSection = document.querySelector(targetId);
                    if (targetSection) {
                        if (mobileMenu) mobileMenu.classList.remove('active');
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // =========================================
        // 4. SEARCH FILTER (BLOG)
        // =========================================
        const searchInput = document.getElementById('searchInput');
        const docCards = document.querySelectorAll('.blog-card, .doc-card');
        if (searchInput && docCards.length > 0) {
            searchInput.addEventListener('keyup', function(e) {
                const term = e.target.value.toLowerCase();
                docCards.forEach(card => {
                    const titleEl = card.querySelector('.blog-title, .doc-title');
                    const catEl = card.querySelector('.category-tag, .doc-category');
                    const title = titleEl ? titleEl.textContent.toLowerCase() : '';
                    const category = catEl ? catEl.textContent.toLowerCase() : '';

                    if (title.includes(term) || category.includes(term)) {
                        card.style.display = "flex";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        }

        // =========================================
        // 5. CREATION FILTER
        // =========================================
        const filterBtns = document.querySelectorAll('.filter-btn');
        const creationCards = document.querySelectorAll('.creation-card');

        if (filterBtns.length > 0) {
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-filter');

                    creationCards.forEach(card => {
                        const category = card.getAttribute('data-category');
                        card.classList.remove('js-reveal');
                        card.classList.add('revealed');

                        if (filterValue !== 'all' && category !== filterValue) {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.8)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 400);
                        }
                    });

                    setTimeout(() => {
                        creationCards.forEach(card => {
                            const category = card.getAttribute('data-category');
                            if (filterValue === 'all' || category ===
                                filterValue) {
                                card.style.display = 'block';
                                setTimeout(() => {
                                    card.style.opacity = '1';
                                    card.style.transform =
                                        'scale(1) translateY(0)';
                                }, 50);
                            }
                        });
                    }, 400);
                });
            });
        }

        // =========================================
        // 6. FAQ ACCORDION
        // =========================================
        const faqItems = document.querySelectorAll('.faq-item');
        if (faqItems.length > 0) {
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', () => {
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) otherItem.classList.remove('active');
                    });
                    item.classList.toggle('active');
                });
            });
        }

        // =========================================
        // 7. CANVAS SMOKE (UPDATED: MATCHING LOGIN STYLE)
        // =========================================
        const canvas = document.getElementById('smokeCanvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let width, height, particles = [];
            const heroSection = document.getElementById('home');
            const mouse = {
                x: 0,
                y: 0
            };

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }
            window.addEventListener('resize', resize);
            resize();

            if (heroSection) {
                heroSection.addEventListener('mousemove', (e) => {
                    const rect = heroSection.getBoundingClientRect();
                    mouse.x = e.clientX - rect.left;
                    mouse.y = e.clientY - rect.top;
                    // Menggunakan 3 partikel (seperti di script login)
                    for (let i = 0; i < 3; i++) particles.push(new Particle(mouse.x, mouse.y));
                });
            }

            // CLASS PARTICLE DIPERBARUI (Sesuai Script Login)
            class Particle {
                constructor(x, y) {
                    this.x = x;
                    this.y = y;
                    // REVISI KECEPATAN: Sangat lambat agar tidak menyebar cepat (0.5)
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.size = Math.random() * 20 + 15; // Ukuran awal sedikit lebih besar
                    this.life = 100;
                    // Warna Emas Pekat
                    const hue = 40 + Math.random() * 10;
                    this.color = `hsla(${hue}, 100%, 50%,`;
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    // Decay lambat (tahan lama)
                    this.life -= 0.5;
                    // Pertumbuhan ukuran sangat lambat
                    this.size += 0.05;
                }

                draw() {
                    ctx.beginPath();
                    // Menggunakan Radial Gradient (Asap Halus)
                    let gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
                    gradient.addColorStop(0, this.color + (this.life / 100 * 0.5) + ')');
                    gradient.addColorStop(1, this.color + '0)');
                    ctx.fillStyle = gradient;
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();
                    // Cek life <= 0 (Sesuai script login)
                    if (particles[i].life <= 0) {
                        particles.splice(i, 1);
                        i--;
                    }
                }
                requestAnimationFrame(animate);
            }
            animate();
        }

        // =========================================
        // 8. AUTO SCROLL REVEAL
        // =========================================
        function initAutoScrollReveal() {
            const targetSelectors = [
                '.hero-content', '.section-header',
                '.about-img-wrapper', '.about-text',
                '.vm-card', '.filter-menu', '.creation-card',
                '.team-card', '.blog-card', '.faq-item',
                '.btn-view-all-wrapper'
            ];

            const elements = document.querySelectorAll(targetSelectors.join(','));

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            });

            elements.forEach(el => {
                el.classList.add('js-reveal');
                observer.observe(el);
            });
        }

        initAutoScrollReveal();

    });

    // =========================================
    // BACK TO TOP LOGIC
    // =========================================
    const backToTopBtn = document.getElementById('backToTop');

    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('active');
            } else {
                backToTopBtn.classList.remove('active');
            }
        });

        backToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
</script>
