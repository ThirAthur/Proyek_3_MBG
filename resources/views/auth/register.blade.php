
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - MBG Report</title>

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

        .register-card {
            width: 100%;
            max-width: 440px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0,0,0,.06);
        }

        .register-card h2 {
            font-size: 28px;
            color: #183b63;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #7b8794;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 19px;
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

        .btn-register {
            width: 100%;
            border: none;
            background: #1766a8;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn-register:hover {
            background: #104e84;
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            color: #667085;
            font-size: 14px;
        }

        .login-link a {
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

        .role-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 13px;
            border-radius: 8px;
            font-size: 13px;
            color: #1e40af;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        @media(max-width: 800px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
            }

            .register-card {
                padding: 28px;
            }
        }
    </style>
</head>

<body>

    <div class="left-panel">

        <div class="brand">MBG REPORT</div>

        <h1>
            Mari Berpartisipasi
            Menjaga Keamanan
            Makanan
        </h1>

        <p>
            Buat akun untuk melaporkan kejadian
            terkait keamanan makanan MBG serta
            memantau perkembangan laporan yang
            telah kamu kirimkan.
        </p>

    </div>

    <div class="right-panel">

        <div class="register-card">

            <h2>Buat Akun</h2>

            <p class="subtitle">
                Daftarkan diri untuk menggunakan MBG Report.
            </p>

            @if($errors->any())
                <div class="alert">
                    <ul style="padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="role-info">
                <strong>Jenis akun: Pelapor</strong><br>
                Akun yang dibuat melalui registrasi
                akan memiliki akses sebagai Pelapor.
            </div>

            <form action="{{ route('register.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password"
                        required
                    >
                </div>

                <button type="submit" class="btn-register">
                    Daftar Sekarang
                </button>

            </form>

            <div class="login-link">
                Sudah memiliki akun?
                <a href="{{ route('login') }}">
                    Login
                </a>
            </div>

        </div>

    </div>

</body>
</html>
