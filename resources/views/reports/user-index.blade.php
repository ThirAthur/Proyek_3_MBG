
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Laporan - MBG Report</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        h1 {
            color: #183b63;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            background: #1766a8;
            font-size: 13px;
        }

        .report-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        .report-card h3 {
            color: #183b63;
            margin-top: 0;
        }

        .detail {
            line-height: 1.9;
            font-size: 14px;
            color: #667085;
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

        .edit {
            background: #1766a8;
        }

        .locked {
            background: #f2f4f7;
            color: #667085;
            display: inline-block;
            padding: 10px 14px;
            border-radius: 7px;
            font-size: 13px;
        }

        .success {
            padding: 13px;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .empty {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            color: #667085;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<nav>
    <strong>MBG REPORT</strong>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
</nav>

<div class="container">

    <div class="header">
        <div>
            <h1>Status Laporan Saya</h1>
            <p>Periksa perkembangan laporan yang telah dikirim.</p>
        </div>

        <a href="{{ route('user.reports.create') }}" class="btn">
            + Buat Laporan
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($reports->count() > 0)

        @foreach($reports as $report)

            <div class="report-card">

                <h3>
                    Laporan #{{ $report->id }}
                </h3>

                <div class="detail">
                    <strong>Nama Pelapor:</strong>
                    {{ $report->reporter_name }}<br>

                    <strong>Nama Siswa:</strong>
                    {{ $report->student_name }}<br>

                    <strong>Sekolah:</strong>
                    {{ optional($report->school)->name ?? 'Belum ditentukan' }}<br>
                    <strong>SPPG:</strong> {{ $report->sppg?->name ?? 'Belum dipetakan' }}<br>
                    <strong>Kronologi:</strong> {{ $report->incident_type ?? 'Belum diisi' }}<br>

                    <strong>Tanggal Kejadian:</strong>
                    {{ $report->incident_date->format('d-m-Y') }}<br>

                    <strong>Tanggal Laporan:</strong>
                    {{ $report->created_at->format('d-m-Y H:i') }}
                </div>

                @if($report->status === 'belum_diperiksa')

                    <div class="status pending">
                        Belum Diperiksa
                    </div>

                    <br>

                    <a
                        href="{{ route('user.reports.edit', $report->id) }}"
                        class="btn edit"
                    >
                        Edit Laporan
                    </a>

                @else

                    <div class="status reviewed">
                        Sudah Diperiksa
                    </div>

                    <br>

                    <span class="locked">
                        <i>Laporan terkunci dan tidak dapat diedit.</i>
                    </span>

                @endif

                @if($report->evidence)
                    <p>
                        <a href="{{ route('user.reports.evidence', $report->id) }}">
                            Lihat / Unduh Bukti
                        </a>
                    </p>
                @endif

            </div>

        @endforeach

        <div class="pagination">
            {{ $reports->links() }}
        </div>

    @else

        <div class="empty">
            <h3>Belum Ada Laporan</h3>
            <p>Kamu belum membuat laporan kejadian MBG.</p>
        </div>

    @endif

</div>

</body>
</html>
