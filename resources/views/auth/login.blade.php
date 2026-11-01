
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - MBG Report</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #f3f6fb;
        }

        .left-panel {
            width: 50%;
            background: linear-gradient(145deg, #123c70, #1766a8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 70px;
        }

        .brand {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .left-panel h1 {
            font-size: 42px;
            line-height: 1.25;
            margin-bottom: 20px;
        }

        .left-panel p {
            font-size: 16px;
            line-height: 1.8;
            color: #dceafa;
            max-width: 450px;
        }

        .right-panel {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0,0,0,.06);
        }

        .login-card h2 {
            font-size: 28px;
            color: #183b63;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #7b8794;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #344054;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d9e0e8;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #2877bd;
            box-shadow: 0 0 0 3px rgba(40,119,189,.1);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #667085;
        }

        .remember input {
            width: auto;
        }

        .btn-login {
            width: 100%;
            border: none;
            background: #1766a8;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #104e84;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #667085;
            font-size: 14px;
        }

        .register-link a {
            color: #1766a8;
            font-weight: bold;
            text-decoration: none;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 7px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        @media(max-width: 800px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
            }

            .login-card {
                padding: 28px;
            }
        }
    </style>
</head>

<body>

    <div class="left-panel">
        <div class="brand">MBG REPORT</div>

        <h1>
            Bersama Menjaga
            Keamanan Makanan
        </h1>

        <p>
            Platform pelaporan dan pemantauan keamanan
            makanan Program Makan Bergizi Gratis (MBG).
            Laporkan kejadian dan pantau perkembangan
            penanganannya secara terstruktur.
        </p>
    </div>

    <div class="right-panel">

        <div class="login-card">

            <h2>Selamat Datang</h2>

            <p class="subtitle">
                Silakan login untuk melanjutkan ke aplikasi.
            </p>

            @if(session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="remember">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        value="1"
                    >

                    <label for="remember" style="margin:0">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Login
                </button>

            </form>

            <div class="register-link">
                Belum memiliki akun?
                <a href="{{ route('register') }}">
                    Daftar sekarang
                </a>
            </div>

        </div>

    </div>

</body>
</html>
