<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 50%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header .icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3273dc, #00d1b2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(50, 115, 220, 0.4);
        }

        .login-header h1 {
            color: #f5f5f5;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
        }

        .field {
            margin-bottom: 1.5rem;
        }

        .label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #f5f5f5;
            border-radius: 12px;
            padding: 1.25rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00d1b2;
            box-shadow: 0 0 0 3px rgba(0, 209, 178, 0.2);
        }

        .input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .control.has-icons-left .icon {
            color: rgba(255, 255, 255, 0.4);
            height: 3rem;
        }

        .control.has-icons-left .input {
            padding-left: 3rem;
        }

        .button.is-primary {
            background: linear-gradient(135deg, #3273dc, #00d1b2);
            border: none;
            border-radius: 12px;
            padding: 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .button.is-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(50, 115, 220, 0.5);
        }

        .notification {
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="icon-wrapper">
                    <i class="fas fa-book-open"></i>
                </div>
                <h1>Sistem Perpustakaan</h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            @if($errors->any())
            <div class="notification is-danger is-light">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label class="label">Username</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        <span class="icon is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left">
                        <input class="input" type="password" name="password" placeholder="Masukkan password" required>
                        <span class="icon is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>

                <div class="field" style="margin-top: 2rem;">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                        <span>Login</span>
                    </button>
                </div>
            </form>

            <p class="footer-text">
                &copy; {{ date('Y') }} Sistem Informasi Perpustakaan
            </p>
        </div>
    </div>
</body>

</html>