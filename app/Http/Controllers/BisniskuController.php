<?php

namespace App\Http\Controllers;

use App\Models\SpendingItem;
use App\Models\StudentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BisniskuController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $submissions = StudentSubmission::where('user_id', $userId)
            ->pluck('step_key')
            ->toArray();

        $progress = [
            'ide_bisnis' => in_array('ide_bisnis', $submissions),
            'rencana_keuangan' => in_array('hitung_modal', $submissions) || in_array('game_belanja', $submissions),
            'pengembangan_bisnis' => in_array('studi_kasus_investasi', $submissions),
        ];

        return view('bisnisku.index', compact('progress'));
    }

    public function ideBisnis()
    {
        $submission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'ide_bisnis')
            ->latest()
            ->first();

        return view('bisnisku.ide-bisnis', compact('submission'));
    }

    public function submitIdeBisnis(Request $request)
    {
        $request->validate([
            'ide' => ['required', 'string', 'max:2000'],
            'alasan' => ['required', 'string', 'max:2000'],
        ]);

        StudentSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_key' => 'ide_bisnis',
            ],
            [
                'payload' => [
                    'ide' => $request->input('ide'),
                    'alasan' => $request->input('alasan'),
                ],
                'answer_text' => 'Ide: '.$request->input('ide')."\n\nAlasan: ".$request->input('alasan'),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Jawaban berhasil disimpan!',
        ]);
    }

    public function rencanaKeuangan()
    {
        $items = SpendingItem::where('is_active', true)
            ->orderBy('order_num')
            ->get();

        $gameSubmission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'game_belanja')
            ->latest()
            ->first();

        $modalSubmission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'hitung_modal')
            ->latest()
            ->first();

        return view('bisnisku.rencana-keuangan', compact('items', 'gameSubmission', 'modalSubmission'));
    }

    public function checkGameBelanja(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);
        
        if (!is_array($selectedIds) || count($selectedIds) !== 3) {
            return response()->json([
                'status' => 'error',
                'is_correct' => false,
                'title' => 'Maaf, Jawaban Kurang Tepat!',
                'message' => 'Maaf, jawaban kurang tepat, coba lagi! Pilihlah tepat 3 kategori pengeluaran untuk produksi.',
            ]);
        }

        $correctIds = SpendingItem::where('is_active', true)
            ->where('is_correct', true)
            ->pluck('id')
            ->toArray();

        $allMatch = count(array_intersect($selectedIds, $correctIds)) === 3;

        if ($allMatch) {
            $totalSpending = SpendingItem::whereIn('id', $selectedIds)->sum('price');

            StudentSubmission::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'step_key' => 'game_belanja',
                ],
                [
                    'payload' => [
                        'selected_ids' => $selectedIds,
                        'total_spending' => $totalSpending,
                    ],
                    'answer_text' => 'Item ID: '.implode(',', $selectedIds).' (Total: Rp'.number_format($totalSpending, 0, ',', '.').')',
                ]
            );

            return response()->json([
                'status' => 'success',
                'is_correct' => true,
                'total_spending' => $totalSpending,
                'title' => 'Kamu Hebat!',
                'message' => 'Kamu hebat! Pilihan belanjamu sangat bijak dan sesuai dengan kebutuhan usaha kerajinan kerang.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'is_correct' => false,
            'title' => 'Maaf, Jawaban Kurang Tepat!',
            'message' => 'Maaf, jawaban kurang tepat, coba lagi! Coba periksa kembali pilihan pengeluaranmu. Ingat kita sudah punya alat utama dan modal awal Rp1.000.000.',
        ]);
    }

    public function submitHitungModal(Request $request)
    {
        $rawAnswer = preg_replace('/[^0-9]/', '', (string)$request->input('answer', ''));
        $numericAnswer = (int)$rawAnswer;

        // Modal awal = 1.000.000, Total Pengeluaran = 700.000 -> Sisa = 300.000
        $expectedAnswer = 300000;

        $isCorrect = ($numericAnswer === $expectedAnswer);

        StudentSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_key' => 'hitung_modal',
            ],
            [
                'payload' => [
                    'input_answer' => $request->input('answer'),
                    'numeric_answer' => $numericAnswer,
                    'is_correct' => $isCorrect,
                ],
                'answer_text' => 'Jawaban: Rp'.number_format($numericAnswer, 0, ',', '.').' ('.($isCorrect ? 'Benar' : 'Salah').')',
            ]
        );

        if ($isCorrect) {
            return response()->json([
                'status' => 'success',
                'is_correct' => true,
                'title' => 'Kamu Hebat!',
                'message' => 'Kamu hebat! Perhitunganmu sangat tepat. Sisa modal usahamu adalah Rp300.000.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'is_correct' => false,
            'title' => 'Maaf, Jawaban Kurang Tepat!',
            'message' => 'Maaf, jawaban kurang tepat! Coba hitung kembali: Modal Awal (Rp1.000.000) dikurangi Total Pengeluaran (Rp700.000).',
        ]);
    }

    public function pengembanganBisnis()
    {
        $hitungTotalSubmission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'hitung_total_usaha')
            ->latest()
            ->first();

        $tabunganSubmission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'studi_kasus_tabungan')
            ->latest()
            ->first();

        $investasiSubmission = StudentSubmission::where('user_id', Auth::id())
            ->where('step_key', 'studi_kasus_investasi')
            ->latest()
            ->first();

        return view('bisnisku.pengembangan-bisnis', compact('hitungTotalSubmission', 'tabunganSubmission', 'investasiSubmission'));
    }

    public function submitHitungTotalUsaha(Request $request)
    {
        $request->validate([
            'jawaban' => ['required', 'string'],
        ]);

        $cleaned = (int) preg_replace('/[^0-9]/', '', $request->input('jawaban'));
        $expected = 1800000;

        if ($cleaned === $expected) {
            StudentSubmission::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'step_key' => 'hitung_total_usaha',
                ],
                [
                    'payload' => [
                        'pendapatan' => 1500000,
                        'sisa_modal' => 300000,
                        'total_usaha' => $cleaned,
                    ],
                    'answer_text' => (string) $cleaned,
                ]
            );

            return response()->json([
                'status' => 'success',
                'is_correct' => true,
                'title' => 'Kamu Hebat!',
                'message' => 'Hebat! Hitunganmu tepat. Total uang usahamu sekarang menjadi Rp1.800.000.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'is_correct' => false,
            'title' => 'Maaf, Jawaban Kurang Tepat!',
            'message' => 'Maaf jawaban kurang tepat, coba lagi! Coba jumlahkan Pendapatan (Rp1.500.000) + Sisa Modal Sebelumnya (Rp300.000).',
        ]);
    }

    public function submitStudiKasusTabungan(Request $request)
    {
        $request->validate([
            'jawaban' => ['required', 'string', 'max:2000'],
        ]);

        StudentSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_key' => 'studi_kasus_tabungan',
            ],
            [
                'payload' => [
                    'jawaban' => $request->input('jawaban'),
                ],
                'answer_text' => $request->input('jawaban'),
            ]
        );

        return response()->json([
            'status' => 'success',
            'title' => 'Kamu Hebat!',
            'message' => 'Hebat! Jawaban studi kasus tabunganmu telah tersimpan.',
        ]);
    }

    public function submitStudiKasusInvestasi(Request $request)
    {
        $request->validate([
            'jawaban' => ['required', 'string', 'max:2000'],
        ]);

        StudentSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_key' => 'studi_kasus_investasi',
            ],
            [
                'payload' => [
                    'jawaban' => $request->input('jawaban'),
                ],
                'answer_text' => $request->input('jawaban'),
            ]
        );

        return response()->json([
            'status' => 'success',
            'title' => 'Kamu Hebat!',
            'message' => 'Selamat! Kamu telah menyelesaikan seluruh tahapan materi Bisnisku dengan luar biasa.',
        ]);
    }
}
