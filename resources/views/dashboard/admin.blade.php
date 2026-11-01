
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - MBG Report</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f6fb;
            min-height: 100vh;
        }

        nav {
            background: #123c70;
            color: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h2 {
            font-size: 22px;
        }

        .logout {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
        }

        .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
        }

        .welcome {
            margin-bottom: 35px;
        }

        .welcome h1 {
            color: #183b63;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #667085;
            line-height: 1.6;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 35px;
            max-width: 500px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .icon {
            font-size: 38px;
            margin-bottom: 20px;
        }

        .card h3 {
            color: #183b63;
            margin-bottom: 12px;
        }

        .card p {
            color: #667085;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            background: #1766a8;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 7px;
            font-size: 14px;
        }

        .btn:hover {
            background: #104e84;
        }
    </style>
</head>

<body>

    <nav>
        <h2>MBG REPORT - ADMIN</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout" type="submit">
                Logout
            </button>
        </form>
    </nav>

    <div class="container">

        <div class="welcome">

            <h1>
                Selamat Datang, {{ Auth::user()->name }}!
            </h1>

            <p>
                Dashboard administrator MBG Report.
                Kelola dan periksa laporan yang masuk
                dari pengguna.
            </p>

        </div>

        <div class="card">

            <div class="icon">📑</div>

            <h3>Periksa Laporan</h3>

            <p>
                Periksa seluruh laporan kejadian
                keamanan makanan MBG yang dikirimkan
                oleh pengguna. Tinjau informasi,
                sekolah, distribusi, dan bukti pendukung.
            </p>

            <a href="{{ route('admin.reports.index') }}"
               class="btn">
                Periksa Laporan
            </a>

        </div>

    </div>

</body>
</html>
