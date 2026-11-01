
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - MBG Report</title>

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
            align-items: center;
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

        h1 {
            color: #183b63;
            margin-top: 0;
        }

        .description {
            color: #667085;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 9px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #1766a8;
        }

        .hint {
            font-size: 12px;
            color: #667085;
            margin-top: 7px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 7px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        button, .back {
            border: none;
            padding: 13px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        button {
            background: #1766a8;
            color: white;
        }

        .back {
            background: #e4e7ec;
            color: #344054;
        }

        button:hover {
            background: #104e84;
        }
    </style>
</head>

<body>

<nav>
    <strong>MBG REPORT</strong>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
</nav>

<div class="container">

    <div class="card">

        <h1>Buat Laporan Kejadian</h1>

        <p class="description">
            Silakan isi informasi kejadian terkait keamanan
            makanan MBG dengan benar.
        </p>

        @if($errors->any())
            <div class="alert">
                <strong>Periksa kembali isian:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('user.reports.store') }}"
            method="POST"
            enctype="multipart/form-data"
            onsubmit="return confirmReport()"
        >
            @csrf

            <div class="form-group">
                <label>Nama Pelapor</label>

                <input
                    type="text"
                    name="reporter_name"
                    value="{{ old('reporter_name', Auth::user()->name) }}"
                    placeholder="Masukkan nama pelapor"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nama Siswa yang Terdampak</label>

                <input
                    type="text"
                    name="student_name"
                    value="{{ old('student_name') }}"
                    placeholder="Masukkan nama siswa"
                    required
                >
            </div>

            <div class="form-group">
                <label>Asal Sekolah Siswa</label>
                <select name="school_id" id="school_id" required style="width:100%;padding:13px;border:1px solid #d0d5dd;border-radius:8px">
                    <option value="">Pilih sekolah</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" data-sppgs='@json($school->sppgs->pluck("id"))' {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>SPPG / Dapur Penyedia</label>
                <select name="sppg_id" id="sppg_id" required style="width:100%;padding:13px;border:1px solid #d0d5dd;border-radius:8px">
                    <option value="">Pilih sekolah terlebih dahulu</option>
                </select>
                <p class="hint">Pilihan SPPG dibatasi sesuai sekolah yang dipilih.</p>
            </div>

            <div class="form-group">
                <label>Tanggal Kejadian</label>

                <input
                    type="date"
                    name="incident_date"
                    value="{{ old('incident_date') }}"
                    max="{{ date('Y-m-d') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Lampiran Bukti</label>

                <input
                    type="file"
                    name="evidence"
                    accept=".png,.jpg,.jpeg,.pdf"
                >

                <p class="hint">
                    Format: PNG, JPG, JPEG, PDF.
                    Maksimal ukuran file 2 MB.
                </p>
            </div>

            <div class="actions">

                <a href="{{ route('user.dashboard') }}" class="back">
                    Kembali
                </a>

                <button type="submit">
                    Kirim Laporan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function confirmReport() {
        return confirm(
            'Apakah semua informasi laporan sudah benar?\n\n' +
            'Pastikan nama pelapor, nama siswa, sekolah, ' +
            'tanggal kejadian, dan lampiran sudah sesuai.'
        );
    }
</script>


<script>
(function () {
    const schoolSelect = document.getElementById('school_id');
    const sppgSelect = document.getElementById('sppg_id');
    const selectedSppg = @json(old("sppg_id"));
    const allSppgs = @json($schools->flatMap(fn($school) => $school->sppgs)->unique('id')->map(fn($sppg) => ['id'=>$sppg->id,'name'=>$sppg->name])->values());
    function refreshSppgs() {
        const option = schoolSelect.options[schoolSelect.selectedIndex];
        const allowed = option && option.dataset.sppgs ? JSON.parse(option.dataset.sppgs) : [];
        sppgSelect.innerHTML = '<option value="">Pilih SPPG</option>';
        allSppgs.filter(item => allowed.includes(item.id)).forEach(item => {
            const opt = document.createElement('option'); opt.value = item.id; opt.textContent = item.name;
            if (String(item.id) === String(selectedSppg)) opt.selected = true;
            sppgSelect.appendChild(opt);
        });
        sppgSelect.disabled = allowed.length === 0;
    }
    schoolSelect.addEventListener('change', refreshSppgs); refreshSppgs();
})();
</script>

</body>
</html>
