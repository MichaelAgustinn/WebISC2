<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menunggu Verifikasi</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@500;700;900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0f204b;
            --primary-dark: #050914;
            --accent: #d4af37;
            --text-grey: #94a3b8;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: var(--white);
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

        .waiting-box {
            position: relative;
            z-index: 10;
            width: 420px;
            background: rgba(15, 32, 75, 0.4);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .waiting-content {
            padding: 50px 40px;
            text-align: center;
        }

        .waiting-box>span {
            position: absolute;
            display: block;
            z-index: 1;
            pointer-events: none;
        }

        .waiting-box>span:nth-of-type(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent));
            animation: btn-anim1 6s linear infinite;
        }

        .waiting-box>span:nth-of-type(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, var(--accent));
            animation: btn-anim2 6s linear infinite;
            animation-delay: 1.5s;
        }

        .waiting-box>span:nth-of-type(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, var(--accent));
            animation: btn-anim3 6s linear infinite;
            animation-delay: 3s;
        }

        .waiting-box>span:nth-of-type(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, var(--accent));
            animation: btn-anim4 6s linear infinite;
            animation-delay: 4.5s;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }

            50%,
            100% {
                left: 100%;
            }
        }

        @keyframes btn-anim2 {
            0% {
                top: -100%;
            }

            50%,
            100% {
                top: 100%;
            }
        }

        @keyframes btn-anim3 {
            0% {
                right: -100%;
            }

            50%,
            100% {
                right: 100%;
            }
        }

        @keyframes btn-anim4 {
            0% {
                bottom: -100%;
            }

            50%,
            100% {
                bottom: 100%;
            }
        }

        .waiting-logo {
            width: 90px;
            height: 90px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 100px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .waiting-logo i {
            font-size: 45px;
            color: var(--accent);
        }

        h1 {
            color: var(--accent);
            font-family: 'Poppins', sans-serif;
            font-size: 1.7rem;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        p {
            color: var(--text-grey);
            line-height: 1.8;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 50px;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--accent);
            font-size: 14px;
            font-weight: 600;
        }

        .back-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background: var(--accent);
            color: var(--primary);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            transition: 0.3s;
        }

        .back-button:hover {
            background: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <canvas id="smokeCanvas"></canvas>

    <div class="waiting-box">

        <span></span>
        <span></span>
        <span></span>
        <span></span>

        <div class="waiting-content">

            <div class="waiting-logo">
                <i class="ri-time-line"></i>
            </div>

            <h1>AKUN MENUNGGU VERIFIKASI</h1>

            <p>
                Mohon Hubungi Admin Atau Pengurus Informatics Study Club
            </p>

            <div class="status-badge">
                Status : Pending Verification
            </div>

            <br>

            <a href="/" class="back-button">
                Kembali ke Beranda
            </a>

        </div>

    </div>

    <script>
        const canvas = document.getElementById('smokeCanvas');
        const ctx = canvas.getContext('2d');

        let width, height;
        let particles = [];

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }

        resize();

        window.addEventListener('resize', resize);

        class Particle {

            constructor(x, y) {

                this.x = x;
                this.y = y;

                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;

                this.size = Math.random() * 20 + 10;
                this.life = 100;

            }

            update() {

                this.x += this.vx;
                this.y += this.vy;

                this.life--;

            }

            draw() {

                ctx.beginPath();

                ctx.fillStyle = `rgba(212,175,55,${this.life / 200})`;

                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);

                ctx.fill();

            }

        }

        window.addEventListener('mousemove', (e) => {

            for (let i = 0; i < 3; i++) {

                particles.push(new Particle(e.clientX, e.clientY));

            }

        });

        function animate() {

            ctx.clearRect(0, 0, width, height);

            for (let i = 0; i < particles.length; i++) {

                particles[i].update();
                particles[i].draw();

                if (particles[i].life <= 0) {

                    particles.splice(i, 1);
                    i--;

                }

            }

            requestAnimationFrame(animate);

        }

        animate();
    </script>

</body>

</html>
