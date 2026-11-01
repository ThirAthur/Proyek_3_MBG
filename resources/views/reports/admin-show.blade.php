
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Laporan - MBG Report</title>

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
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 750px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        h1 { color: #183b63; }

        .detail {
            padding: 14px 0;
            border-bottom: 1px solid #eaecf0;
            line-height: 1.7;
        }

        .label {
            color: #667085;
            font-size: 13px;
        }

        .value {
            color: #183b63;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 9px 14px;
            border-radius: 20px;
            margin: 15px 0;
            font-size: 13px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            background: #1766a8;
            color: white;
            margin-top: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<nav>
    <strong>MBG REPORT - ADMIN</strong>
</nav>

<div class="container">

    <div class="card">

        <h1>Detail Laporan #{{ $report->id }}</h1>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="status">
            Status: Sudah Diperiksa
        </div>

        <div class="detail">
            <div class="label">Nama Pelapor</div>
            <div class="value">{{ $report->reporter_name }}</div>
        </div>

        <div class="detail">
            <div class="label">Nama Siswa Terdampak</div>
            <div class="value">{{ $report->student_name }}</div>
        </div>

        <div class="detail">
            <div class="label">Asal Sekolah</div>
            <div class="value">{{ optional($report->school)->name ?? 'Belum ditentukan' }}</div>
        </div>

        <div class="detail">
            <div class="label">SPPG / Dapur Penyedia</div>
            <div class="value">{{ $report->sppg?->name ?? 'Belum dipetakan' }}</div>
        </div>

        <div class="detail">
            <div class="label">Kronologi Kejadian</div>
            <div class="value">{{ $report->incident_type ?? 'Belum diisi (laporan lama)' }}</div>
        </div>

        <div class="detail">
            <div class="label">Tanggal Kejadian</div>
            <div class="value">
                {{ $report->incident_date->format('d-m-Y') }}
            </div>
        </div>

        <div class="detail">
            <div class="label">Tanggal Pengajuan</div>
            <div class="value">
                {{ $report->created_at->format('d-m-Y H:i') }}
            </div>
        </div>

        <div class="detail">
            <div class="label">Lampiran Bukti</div>

            @if($report->evidence)

                <a href="{{ route('admin.reports.evidence', $report->id) }}">
                    Unduh Lampiran Bukti
                </a>

            @else

                <span>Tidak ada lampiran.</span>

            @endif

        </div>

        <a href="{{ route('admin.reports.index') }}" class="btn">
            Kembali ke Daftar Laporan
        </a>

    </div>

</div>

</body>
</html>
