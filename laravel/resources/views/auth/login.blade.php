<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Sneakerness Rotterdam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #0d0e12;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-wrapper {
            max-width: 440px;
            width: 100%;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo-text {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .brand-sub {
            display: block;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 4px;
            color: #ff3b30;
            margin-top: 4px;
        }

        .login-card {
            background-color: #16181e;
            border: 1px solid #262933;
            border-radius: 16px;
            padding: 36px 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .login-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
            text-align: center;
        }

        .alert-box {
            background-color: rgba(255, 59, 48, 0.12);
            border: 1px solid rgba(255, 59, 48, 0.4);
            color: #ff6b63;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-success-box {
            background-color: rgba(52, 199, 89, 0.12);
            border: 1px solid rgba(52, 199, 89, 0.4);
            color: #34c759;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #a0a5b5;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background-color: #0d0e12;
            border: 1px solid #2e3340;
            border-radius: 8px;
            color: #ffffff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #ff3b30;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0a5b5;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .toggle-password:hover {
            color: #ffffff;
        }

        .btn-submit {
            width: 100%;
            background-color: #ff3b30;
            color: #ffffff;
            border: none;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background-color: #e03126;
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .test-credentials {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #262933;
            font-size: 12px;
            color: #707585;
        }

        .test-credentials code {
            color: #ff3b30;
            background-color: #0d0e12;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="brand-header">
            <span class="brand-logo-text">SNEAKERNESS</span>
            <span class="brand-sub">ROTTERDAM</span>
        </div>

        <div class="login-card">
            <h1 class="login-title">Inloggen</h1>

            @if (session('success'))
                <div class="alert-success-box">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-box">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-box">
                    @foreach ($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="login" class="form-label">E-mailadres of Gebruikersnaam</label>
                    <input type="text" id="login" name="login" class="form-control" value="{{ old('login') }}" required autofocus placeholder="bijv. admin_rotterdam of e-mail">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Uw wachtwoord">
                        <button type="button" class="toggle-password" id="togglePasswordBtn" onclick="togglePasswordVisibility()">TONEN</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span id="btnText">INLOGGEN</span>
                </button>
            </form>

            <div class="test-credentials">
                <p><strong>Testaccounts (Lokale Ontwikkelomgeving):</strong></p>
                <p>• Admin: <code>admin_rotterdam</code> / <code>Secret123!</code></p>
                <p>• Klant: <code>jan_devries</code> / <code>Secret123!</code></p>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePasswordBtn');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = 'VERBERGEN';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = 'TONEN';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            submitBtn.disabled = true;
            btnText.textContent = 'INLOGGEN BEZIG...';
        });
    </script>
</body>
</html>
