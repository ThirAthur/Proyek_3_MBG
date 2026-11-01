
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan - MBG Report</title>

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

        nav a { color: white; text-decoration: none; }

        .container {
            max-width: 750px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 14px;
        }

        h1 { color: #183b63; }

        .form-group { margin-bottom: 20px; }

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
        }

        .hint { font-size: 12px; color: #667085; }

        .error { color: #dc2626; font-size: 13px; }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
        }

        button, .back {
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button { background: #1766a8; color: white; }

        .back { background: #e4e7ec; color: #344054; }
    </style>
</head>

<body>

<nav>
    <strong>MBG REPORT</strong>
    &nbsp; | &nbsp;
    <a href="{{ route('user.reports.index') }}">Kembali</a>
</nav>

<div class="container">

    <div class="card">

        <h1>Edit Laporan #{{ $report->id }}</h1>

        <p>Perbarui informasi laporan sebelum diperiksa admin.</p>

        @if($errors->any())
            <div class="alert">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form
            action="{{ route('user.reports.update', $report->id) }}"
            method="POST"
            enctype="multipart/form-data"
            onsubmit="return confirm(
                'Apakah semua perubahan sudah benar?'
            )"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Pelapor</label>
                <input
                    type="text"
                    name="reporter_name"
                    value="{{ old('reporter_name', $report->reporter_name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nama Siswa yang Terdampak</label>
                <input
                    type="text"
                    name="student_name"
                    value="{{ old('student_name', $report->student_name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Asal Sekolah Siswa</label>
                <select name="school_id" id="school_id" required style="width:100%;padding:13px;border:1px solid #d0d5dd;border-radius:8px">
                    <option value="">Pilih sekolah</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" data-sppgs='@json($school->sppgs->pluck("id"))' {{ old('school_id', $report->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
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
                <label for="incident_type">Kronologi Kejadian</label>
                <select name="incident_type" id="incident_type" required style="width:100%;padding:13px;border:1px solid #d0d5dd;border-radius:8px;background:#fff">
                    <option value="">Pilih kronologi kejadian</option>
                    @foreach(['Keracunan', 'Makanan tidak layak', 'Makanan tidak datang'] as $type)
                        <option value="{{ $type }}" {{ old('incident_type', $report->incident_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <p class="hint">Pilih kategori kejadian yang paling sesuai dengan laporan.</p>
            </div>

            <div class="form-group">
                <label>Tanggal Kejadian</label>
                <input
                    type="date"
                    name="incident_date"
                    value="{{ old('incident_date', $report->incident_date->format('Y-m-d')) }}"
                    max="{{ date('Y-m-d') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Lampiran Bukti Baru (Opsional)</label>

                <input
                    type="file"
                    name="evidence"
                    accept=".png,.jpg,.jpeg,.pdf"
                >

                <p class="hint">
                    Kosongkan jika tidak ingin mengganti bukti.
                    Format PNG, JPG, JPEG, PDF. Maksimal 2 MB.
                </p>

                @if($report->evidence)
                    <a href="{{ route('user.reports.evidence', $report->id) }}">
                        Unduh bukti saat ini
                    </a>
                @endif
            </div>

            <a href="{{ route('user.reports.index') }}" class="back">
                Kembali
            </a>

            <button type="submit">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>


<script>
(function () {
    const schoolSelect = document.getElementById('school_id');
    const sppgSelect = document.getElementById('sppg_id');
    const selectedSppg = @json(old("sppg_id", $report->sppg_id));
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
