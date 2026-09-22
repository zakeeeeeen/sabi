<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentSubmission;
use App\Services\StudentSubmissionExportService;
use Illuminate\Http\Request;

class AdminSubmissionController extends AdminController
{
    public function index(Request $request)
    {
        $stepFilter = $request->query('module');
        $search = $request->query('q');

        $query = StudentSubmission::with('user')->latest();

        if ($stepFilter) {
            $query->where('step_key', $stepFilter);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => StudentSubmission::count(),
            'ide_bisnis' => StudentSubmission::where('step_key', 'ide_bisnis')->count(),
            'game_belanja' => StudentSubmission::where('step_key', 'game_belanja')->count(),
            'hitung_modal' => StudentSubmission::where('step_key', 'hitung_modal')->count(),
            'hitung_total_usaha' => StudentSubmission::where('step_key', 'hitung_total_usaha')->count(),
            'studi_kasus_tabungan' => StudentSubmission::where('step_key', 'studi_kasus_tabungan')->count(),
            'studi_kasus_investasi' => StudentSubmission::where('step_key', 'studi_kasus_investasi')->count(),
        ];

        return view('admin.submissions.index', compact('submissions', 'counts', 'stepFilter', 'search'));
    }

    public function exportExcel(StudentSubmissionExportService $exportService)
    {
        return $exportService->export();
    }

    public function destroy($id)
    {
        $submission = StudentSubmission::findOrFail($id);
        $submission->delete();

        return back()->with('status', 'Jawaban siswa berhasil dihapus.');
    }
}
