
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - MBG Report</title>

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

        .container {
            max-width: 900px;
            margin: 60px auto;
            padding: 30px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        h1 {
            color: #183b63;
            margin-bottom: 15px;
        }

        p {
            color: #667085;
            line-height: 1.8;
        }

        .role {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 7px 14px;
            border-radius: 20px;
            margin: 18px 0;
            font-size: 13px;
            font-weight: bold;
        }

        button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 7px;
            cursor: pointer;
        }

        button:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

    <nav>
        <h2>MBG REPORT</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <div class="container">

        <div class="card">

            <h1>
                Selamat Datang, {{ Auth::user()->name }}!
            </h1>

            <p>
                Kamu berhasil login ke aplikasi
                Pelaporan dan Pemantauan Keamanan
                Makanan MBG.
            </p>

            <div class="role">
                {{ ucfirst(Auth::user()->role) }}
            </div>

            <p>
                Email: {{ Auth::user()->email }}
            </p>

        </div>

    </div>

</body>
</html>

