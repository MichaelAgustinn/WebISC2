<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru</title>
    <style>
        /* (Sama seperti style di atas) */
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
            margin-bottom: 25px;
            font-size: 1.5rem;
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
    </style>
</head>

<body>
    <div class="login-box">
        <h2>PASSWORD BARU</h2>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="user-box @error('email') has-error @enderror">
                <input type="email" name="email" value="{{ $_GET['email'] ?? old('email') }}" required readonly
                    style="color: #94a3b8;" hidden>
                {{-- <label>Email</label> --}}
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="user-box @error('password') has-error @enderror">
                <input type="password" name="password" required>
                <label>Password Baru</label>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="user-box">
                <input type="password" name="password_confirmation" required>
                <label>Ulangi Password Baru</label>
            </div>

            <button type="submit" class="btn-submit">Simpan Password Baru</button>
        </form>
    </div>
</body>

</html>
