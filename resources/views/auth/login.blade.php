<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Informatics Study Club</title>
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

        .login-box {
            position: relative;
            z-index: 10;
            width: 400px;
            padding: 60px 40px 40px;
            background: rgba(15, 32, 75, 0.4);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            overflow: hidden;
            cursor: default;
            transition: transform 0.3s ease;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--text-grey);
            font-size: 1.5rem;
            text-decoration: none;
            transition: 0.3s;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-arrow:hover {
            color: var(--accent);
        }

        .login-box span {
            position: absolute;
            display: block;
            z-index: 1;
        }

        .login-box span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent));
            animation: btn-anim1 6s linear infinite;
        }

        .login-box span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, var(--accent));
            animation: btn-anim2 6s linear infinite;
            animation-delay: 1.5s;
        }

        .login-box span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, var(--accent));
            animation: btn-anim3 6s linear infinite;
            animation-delay: 3s;
        }

        .login-box span:nth-child(4) {
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

        .login-logo {
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 100px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .login-box h2 {
            margin: 0 0 30px;
            color: var(--accent);
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
            font-size: 1.5rem;
        }

        .user-box {
            position: relative;
            margin-bottom: 30px;
        }

        .user-box input {
            width: 100%;
            padding: 10px 0;
            padding-right: 35px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            outline: none;
            background: transparent;
            transition: 0.3s;
        }

        .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
            transition: .5s;
        }

        .user-box input:focus,
        .user-box input:valid {
            border-bottom-color: var(--accent);
        }

        .user-box input:focus~label,
        .user-box input:valid~label {
            top: -20px;
            left: 0;
            color: var(--accent);
            font-size: 12px;
        }

        .password-toggle {
            position: absolute;
            right: 5px;
            top: 10px;
            color: var(--text-grey);
            cursor: pointer;
            transition: 0.3s;
            font-size: 1.2rem;
            z-index: 5;
        }

        .password-toggle:hover {
            color: var(--accent);
        }

        .forgot-pass {
            display: block;
            text-align: right;
            margin-top: -20px;
            margin-bottom: 25px;
            font-size: 0.8rem;
            color: var(--text-grey);
            text-decoration: none;
            transition: 0.3s;
        }

        .forgot-pass:hover {
            color: var(--accent);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-grey);
        }

        .register-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            padding: 12px 20px;
            color: var(--primary);
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: var(--accent);
            border: none;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .btn-submit:hover {
            background: #fff;
            color: var(--primary);
            box-shadow: 0 0 25px var(--accent);
            transform: translateY(-2px);
        }

        /* Error Message Style */
        .error-text {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>
    <canvas id="smokeCanvas"></canvas>

    <div class="login-box" id="loginCard">
        <a href="/" class="back-arrow" title="Kembali ke Beranda">
            <i class="ri-arrow-left-line"></i>
        </a>
        <span></span><span></span><span></span><span></span>

        <div class="login-logo">
            <img src="{{ asset('Assets/all-logo.png') }}" alt="Logo" style="height: 130px">
        </div>

        <h2 style="padding-top: 40px; padding-bottom: 20px;">LOGIN</h2>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf <div class="user-box">
                <input type="text" name="email" value="{{ old('email') }}" required>
                <label>Email</label>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="user-box">
                <input type="password" name="password" id="passwordInput" required>
                <label>Password</label>
                <i class="ri-eye-off-line password-toggle" id="togglePassword"></i>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <a href="#" class="forgot-pass">Lupa sandi?</a>

            <button type="submit" class="btn-submit">Masuk Sekarang</button>

            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Buat akun</a>
            </div>
        </form>
    </div>

    <script>
        const canvas = document.getElementById('smokeCanvas');
        const ctx = canvas.getContext('2d');
        const loginCard = document.getElementById('loginCard');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        let width, height;
        let particles = [],
            orbs = [];

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('ri-eye-off-line');
            this.classList.toggle('ri-eye-line');
        });

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        class Orb {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 0.3;
                this.vy = (Math.random() - 0.5) * 0.3;
                this.size = Math.random() * 100 + 150;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                if (this.x < -this.size) this.vx *= -1;
                if (this.x > width + this.size) this.vx *= -1;
                if (this.y < -this.size) this.vy *= -1;
                if (this.y > height + this.size) this.vy *= -1;
            }
            draw() {
                let gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
                gradient.addColorStop(0, 'rgba(212, 175, 55, 0.08)');
                gradient.addColorStop(1, 'rgba(0,0,0,0)');
                ctx.fillStyle = gradient;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }
        class Particle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 20 + 15;
                this.life = 100;
                const hue = 40 + Math.random() * 10;
                this.color = `hsla(${hue}, 100%, 50%,`;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.life -= 0.5;
                this.size += 0.05;
            }
            draw() {
                ctx.beginPath();
                let gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
                gradient.addColorStop(0, this.color + (this.life / 100 * 0.5) + ')');
                gradient.addColorStop(1, this.color + '0)');
                ctx.fillStyle = gradient;
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }
        for (let i = 0; i < 5; i++) {
            orbs.push(new Orb());
        }
        window.addEventListener('mousemove', (e) => {
            const rect = loginCard.getBoundingClientRect();
            if (e.clientX >= rect.left && e.clientX <= rect.right && e.clientY >= rect.top && e.clientY <= rect
                .bottom) {
                document.body.style.cursor = 'default';
            } else {
                document.body.style.cursor = 'none';
                for (let i = 0; i < 3; i++) {
                    particles.push(new Particle(e.clientX, e.clientY));
                }
            }
        });

        function animate() {
            ctx.clearRect(0, 0, width, height);
            orbs.forEach(orb => {
                orb.update();
                orb.draw();
            });
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
