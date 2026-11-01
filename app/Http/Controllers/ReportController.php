<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    // USER: Form pembuatan laporan
    public function create()
    {
        return view('reports.create', ['schools' => School::with('sppgs')->orderBy('name')->get()]);
    }

    // USER: Menyimpan laporan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'student_name' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id'],
            'sppg_id' => ['required', 'exists:sppgs,id'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'evidence' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $this->validateSchoolSppg($validated['school_id'], $validated['sppg_id']);

        if ($request->hasFile('evidence')) {
            $validated['evidence'] = $request->file('evidence')
                ->store('evidence', 'local');
        }

        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'belum_diperiksa';

        Report::create($validated);

        return redirect()
            ->route('user.reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    // USER: Melihat laporan miliknya
    public function index(Request $request)
    {
        $reports = $request->user()
            ->reports()
            ->with(['school', 'sppg'])
            ->latest()
            ->paginate(10);

        return view('reports.user-index', compact('reports'));
    }

    // USER: Form edit laporan
    public function edit(Report $report)
    {
        abort_unless(
            $report->user_id === auth()->id(),
            403
        );

        abort_if(
            $report->status !== 'belum_diperiksa',
            403,
            'Laporan sudah diperiksa dan tidak dapat diedit.'
        );

        return view('reports.edit', ['report' => $report, 'schools' => School::with('sppgs')->orderBy('name')->get()]);
    }

    // USER: Update laporan
    public function update(Request $request, Report $report)
    {
        abort_unless(
            $report->user_id === $request->user()->id,
            403
        );

        abort_if(
            $report->status !== 'belum_diperiksa',
            403,
            'Laporan sudah diperiksa dan tidak dapat diedit.'
        );

        $validated = $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'student_name' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id'],
            'sppg_id' => ['required', 'exists:sppgs,id'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'evidence' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $this->validateSchoolSppg($validated['school_id'], $validated['sppg_id']);

        if ($request->hasFile('evidence')) {

            if ($report->evidence) {
                Storage::disk('local')->delete($report->evidence);
            }

            $validated['evidence'] = $request->file('evidence')
                ->store('evidence', 'local');
        }

        $report->update($validated);

        return redirect()
            ->route('user.reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // ADMIN: Melihat seluruh laporan
    public function adminIndex()
    {
        $reports = Report::with(['user', 'school', 'sppg'])
            ->latest()
            ->paginate(10);

        return view('reports.admin-index', compact('reports'));
    }

    // ADMIN: Detail laporan

    public function show(Report $report)
    {
        // Ketika admin membuka laporan,
        // status langsung berubah menjadi diperiksa.

        if ($report->status === 'belum_diperiksa') {
            $report->update([
                'status' => 'diperiksa',
            ]);
        }

        return view('reports.admin-show', ['report' => $report->load(['user', 'school', 'sppg'])]);
    }


    // ADMIN: Mengubah status menjadi diperiksa
    public function markReviewed(Report $report)
    {
        if ($report->status === 'diperiksa') {
            return back()->with(
                'info',
                'Laporan sudah pernah diperiksa.'
            );
        }

        $report->update([
            'status' => 'diperiksa',
        ]);

        return redirect()
            ->route('admin.reports.show', $report->id)
            ->with('success', 'Laporan berhasil diperiksa.');
    }

    // Download bukti secara terotorisasi
    public function downloadEvidence(Report $report)
    {
        $user = auth()->user();

        abort_unless(
            in_array($user->role, ['admin', 'coordinator'], true) ||
            $report->user_id === $user->id,
            403
        );

        abort_unless(
            $report->evidence &&
            Storage::disk('local')->exists($report->evidence),
            404
        );

        return Storage::disk('local')->download(
            $report->evidence
        );
    }
    private function validateSchoolSppg(int $schoolId, int $sppgId): void
    {
        abort_unless(
            School::whereKey($schoolId)->whereHas('sppgs', fn ($query) => $query->whereKey($sppgId))->exists(),
            422,
            'SPPG yang dipilih tidak terdaftar untuk sekolah tersebut.'
        );
    }

}
