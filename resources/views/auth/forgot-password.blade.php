<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Informatics Study Club</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@500;700;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* (Pastikan Anda meng-copy style CSS dari file register sebelumnya ke sini agar desainnya sama) */
        :root {
            --primary: #0f204b;
            --primary-dark: #050914;
            --accent: #d4af37;
            --text-grey: #94a3b8;
            --white: #ffffff;
            --error: #ef4444;
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
            color: var(--white);
        }

        .login-box {
            position: relative;
            width: 400px;
            padding: 50px 40px 40px;
            background: rgba(15, 32, 75, 0.4);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }

        .login-box h2 {
            color: var(--accent);
            text-align: center;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 10px;
        }

        .user-box {
            position: relative;
            margin-bottom: 10px;
            padding-bottom: 20px;
        }

        .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            transition: 0.3s;
            outline: none;
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

        .user-box input:focus~label,
        .user-box input:valid~label {
            top: -20px;
            color: var(--accent);
            font-size: 12px;
        }

        .user-box input:focus,
        .user-box input:valid {
            border-bottom-color: var(--accent);
        }

        .btn-submit {
            padding: 12px 20px;
            color: var(--primary);
            font-size: 15px;
            background: var(--accent);
            border: none;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #fff;
            box-shadow: 0 0 15px var(--accent);
        }

        .error-text {
            position: absolute;
            bottom: 0;
            left: 0;
            color: var(--error);
            font-size: 11px;
        }

        .user-box.has-error input {
            border-bottom-color: var(--error);
        }

        .user-box.has-error input:focus~label,
        .user-box.has-error input:valid~label {
            color: var(--error);
        }

        .status-msg {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid #22c55e;
            color: #4ade80;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <a href="{{ route('login') }}"
            style="position: absolute; top: 20px; left: 20px; color: #94a3b8; text-decoration: none;"><i
                class="ri-arrow-left-line"></i></a>

        <h2>LUPA PASSWORD</h2>
        <p style="text-align: center; font-size: 12px; color: #94a3b8; margin-bottom: 25px;">Masukkan email Anda. Kami
            akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>

        @if (session('status'))
            <div class="status-msg"><i class="ri-mail-send-line"></i> {{ session('status') }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="user-box @error('email') has-error @enderror">
                <input type="email" name="email" value="{{ old('email') }}" required>
                <label>Alamat Email</label>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-submit">Kirim Link Reset</button>
        </form>
    </div>
</body>

</html>
