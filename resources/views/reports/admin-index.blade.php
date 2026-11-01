
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Periksa Laporan - MBG Report</title>

    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            margin: 0;
            background: #f3f6fb;
            color: #344054;
        }

        nav {
            background: #123c70;
            color: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 { color: #183b63; }

        .report {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        .report h3 { color: #183b63; }

        .detail {
            color: #667085;
            font-size: 14px;
            line-height: 1.9;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin: 12px 0;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .reviewed {
            background: #dcfce7;
            color: #166534;
        }

        .btn {
            display: inline-block;
            background: #1766a8;
            color: white;
            padding: 11px 17px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<nav>
    <strong>MBG REPORT - ADMIN</strong>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
</nav>

<div class="container">

    <h1>Periksa Laporan</h1>

    <p>Daftar seluruh laporan yang diajukan oleh pengguna.</p>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($reports->count() > 0)

        @foreach($reports as $report)

            <div class="report">

                <h3>Laporan #{{ $report->id }}</h3>

                <div class="detail">

                    <strong>Nama Pelapor:</strong>
                    {{ $report->reporter_name }}<br>

                    <strong>Nama Siswa:</strong>
                    {{ $report->student_name }}<br>

                    <strong>Asal Sekolah:</strong>
                    {{ optional($report->school)->name ?? 'Belum ditentukan' }}<br>
                    <strong>SPPG:</strong> {{ $report->sppg?->name ?? 'Belum dipetakan' }}<br>

                    <strong>Tanggal Kejadian:</strong>
                    {{ $report->incident_date->format('d-m-Y') }}<br>

                    <strong>Dikirim oleh:</strong>
                    {{ $report->user->name }}<br>

                    <strong>Tanggal Pengajuan:</strong>
                    {{ $report->created_at->format('d-m-Y H:i') }}

                </div>

                @if($report->status === 'belum_diperiksa')
                    <div class="status pending">
                        Belum Diperiksa
                    </div>
                @else
                    <div class="status reviewed">
                        Sudah Diperiksa
                    </div>
                @endif

                <br>

                <form
                    action="{{ route('admin.reports.review', $report->id) }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit" class="btn">
                        Periksa Laporan
                    </button>
                </form>

            </div>

        @endforeach

        {{ $reports->links() }}

    @else

        <div class="empty">
            <h3>Belum Ada Laporan</h3>
            <p>Belum ada laporan yang diajukan oleh pengguna.</p>
        </div>

    @endif

</div>

</body>
</html>
