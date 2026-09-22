<?php

namespace App\Services;

use App\Models\StudentSubmission;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentSubmissionExportService
{
    /**
     * Generate and stream the Excel (.xlsx) file download.
     */
    public function export(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Remove default empty sheet

        // Fetch users and submissions with eager loading
        $users = User::where('is_admin', 0)
            ->orWhereNull('is_admin')
            ->with(['submissions' => function ($q) {
                $q->latest();
            }])
            ->orderBy('name')
            ->get();

        $allSubmissions = StudentSubmission::with('user')
            ->latest()
            ->get();

        // 1. Create Sheet: Rekapitulasi Siswa
        $this->createRekapSiswaSheet($spreadsheet, $users);

        // 2. Create Sheet: Semua Jawaban (Log)
        $this->createAllSubmissionsSheet($spreadsheet, $allSubmissions);

        // 3. Create Sheet: Modul 1 (Ide Bisnis)
        $this->createIdeBisnisSheet($spreadsheet, $allSubmissions->where('step_key', 'ide_bisnis'));

        // 4. Create Sheet: Modul 2 (Rencana Keuangan)
        $this->createRencanaKeuanganSheet($spreadsheet, $users);

        // 5. Create Sheet: Modul 3 (Pengembangan Bisnis)
        $this->createPengembanganBisnisSheet($spreadsheet, $users);

        // Set active sheet to the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'Laporan_Jawaban_Siswa_SABI_' . date('Y-m-d_His') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Sheet 1: Matrix Rekapitulasi per Siswa (Tanpa Email & Tanpa Skor Evaluasi)
     */
    private function createRekapSiswaSheet(Spreadsheet $spreadsheet, $users): void
    {
        $sheet = new Worksheet($spreadsheet, 'Rekap Progres Siswa');
        $spreadsheet->addSheet($sheet);

        $this->applySheetHeaderBanner(
            $sheet,
            'REKAPITULASI PROGRES & JAWABAN SISWA - MEDIA SABI',
            'Data kumulatif pengerjaan dan hasil jawaban siswa di seluruh modul bisnisku',
            'G'
        );

        // Column Headers
        $headers = [
            'A4' => 'No.',
            'B4' => 'Nama Siswa',
            'C4' => '1. Ide Bisnis',
            'D4' => '2. Game Belanja',
            'E4' => '2. Hitung Sisa Modal',
            'F4' => '3. Hitung Uang Usaha',
            'G4' => '3. Solusi Tabungan & Investasi',
        ];

        $this->applyTableHeaders($sheet, $headers, 'A4:G4', '0077B6');

        $row = 5;
        $no = 1;

        foreach ($users as $user) {
            $subs = $user->submissions->keyBy('step_key');

            $ideSub = $subs->get('ide_bisnis');
            $gameSub = $subs->get('game_belanja');
            $modalSub = $subs->get('hitung_modal');
            $totalSub = $subs->get('hitung_total_usaha');
            $tabunganSub = $subs->get('studi_kasus_tabungan');
            $investasiSub = $subs->get('studi_kasus_investasi');

            // Ide text
            $ideText = '-';
            if ($ideSub) {
                $payload = $ideSub->payload ?? [];
                $ide = $payload['ide'] ?? '';
                $alasan = $payload['alasan'] ?? '';
                $ideText = ($ide ? "Ide: {$ide}" : '') . ($alasan ? "\nAlasan: {$alasan}" : '');
                if (!$ideText) {
                    $ideText = $ideSub->answer_text ?? 'Selesai';
                }
            }

            // Game belanja text
            $gameText = '-';
            if ($gameSub) {
                $gamePayload = $gameSub->payload ?? [];
                $totalSpend = $gamePayload['total_spending'] ?? null;
                $gameText = 'Selesai (3 Kategori Tepat)' . ($totalSpend ? "\nTotal: Rp " . number_format($totalSpend, 0, ',', '.') : '');
            }

            // Hitung modal text
            $modalText = '-';
            if ($modalSub) {
                $mPayload = $modalSub->payload ?? [];
                $isCorrect = $mPayload['is_correct'] ?? false;
                $numAnswer = $mPayload['numeric_answer'] ?? $modalSub->answer_text;
                $modalText = 'Jawaban: ' . ($numAnswer ? "Rp " . number_format((int)$numAnswer, 0, ',', '.') : '-') . "\nStatus: " . ($isCorrect ? 'Tepat (Sisa Rp300rb)' : 'Perlu Perbaikan');
            }

            // Hitung total usaha text
            $totalUsahaText = '-';
            if ($totalSub) {
                $tPayload = $totalSub->payload ?? [];
                $tot = $tPayload['total_usaha'] ?? $totalSub->answer_text;
                $totalUsahaText = 'Total: Rp ' . number_format((int)$tot, 0, ',', '.') . ' (Tepat)';
            }

            // Tabungan & Investasi text
            $kasusText = [];
            if ($tabunganSub) {
                $kasusText[] = 'Tabungan: ' . ($tabunganSub->answer_text ?? 'Selesai');
            }
            if ($investasiSub) {
                $kasusText[] = 'Investasi: ' . ($investasiSub->answer_text ?? 'Selesai');
            }
            $kasusCombined = !empty($kasusText) ? implode("\n---\n", $kasusText) : '-';

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $user->name ?? 'Tamu');
            $sheet->setCellValue("C{$row}", $ideText);
            $sheet->setCellValue("D{$row}", $gameText);
            $sheet->setCellValue("E{$row}", $modalText);
            $sheet->setCellValue("F{$row}", $totalUsahaText);
            $sheet->setCellValue("G{$row}", $kasusCombined);

            $this->applyDataRowStyle($sheet, $row, 'A', 'G', ($no % 2 === 0));

            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        if ($users->isEmpty()) {
            $sheet->setCellValue("A5", "Belum ada data siswa terdaftar.");
            $sheet->mergeCells("A5:G5");
            $sheet->getStyle("A5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(5)->setRowHeight(30);
        }

        $this->setColumnWidths($sheet, [
            'A' => 6,
            'B' => 26,
            'C' => 38,
            'D' => 28,
            'E' => 28,
            'F' => 26,
            'G' => 44,
        ]);

        $sheet->setAutoFilter('A4:G' . max(4, $row - 1));
        $sheet->freezePane('A5');
    }

    /**
     * Sheet 2: Log Semua Submission (Tanpa Email)
     */
    private function createAllSubmissionsSheet(Spreadsheet $spreadsheet, $submissions): void
    {
        $sheet = new Worksheet($spreadsheet, 'Semua Log Jawaban');
        $spreadsheet->addSheet($sheet);

        $this->applySheetHeaderBanner(
            $sheet,
            'LOG DETAIL SEMUA JAWABAN SISWA - SABI',
            'Daftar kronologis seluruh rekaman pengumpulan jawaban siswa di setiap tahapan materi',
            'E'
        );

        $headers = [
            'A4' => 'No.',
            'B4' => 'Nama Siswa',
            'C4' => 'Modul / Tahapan',
            'D4' => 'Isi Jawaban Siswa',
            'E4' => 'Waktu Masuk',
        ];

        $this->applyTableHeaders($sheet, $headers, 'A4:E4', '023E8A');

        $row = 5;
        $no = 1;

        foreach ($submissions as $sub) {
            $moduleName = match ($sub->step_key) {
                'ide_bisnis' => '1. Ide Bisnis',
                'game_belanja' => '2. Game Belanja',
                'hitung_modal' => '2. Hitung Sisa Modal',
                'hitung_total_usaha' => '3. Hitung Total Usaha',
                'studi_kasus_tabungan' => '3. Studi Tabungan',
                'studi_kasus_investasi' => '3. Studi Investasi',
                default => $sub->step_key
            };

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $sub->user->name ?? 'Siswa (Telah Dihapus)');
            $sheet->setCellValue("C{$row}", $moduleName);
            $sheet->setCellValue("D{$row}", $sub->answer_text ?? '-');
            $sheet->setCellValue("E{$row}", $sub->created_at ? $sub->created_at->translatedFormat('d M Y, H:i:s') : '-');

            $this->applyDataRowStyle($sheet, $row, 'A', 'E', ($no % 2 === 0));

            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        if ($submissions->isEmpty()) {
            $sheet->setCellValue("A5", "Belum ada log jawaban tersimpan.");
            $sheet->mergeCells("A5:E5");
            $sheet->getStyle("A5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(5)->setRowHeight(30);
        }

        $this->setColumnWidths($sheet, [
            'A' => 6,
            'B' => 26,
            'C' => 24,
            'D' => 52,
            'E' => 22,
        ]);

        $sheet->setAutoFilter('A4:E' . max(4, $row - 1));
        $sheet->freezePane('A5');
    }

    /**
     * Sheet 3: Detail Modul 1 - Ide Bisnis
     */
    private function createIdeBisnisSheet(Spreadsheet $spreadsheet, $submissions): void
    {
        $sheet = new Worksheet($spreadsheet, '1. Ide Bisnis');
        $spreadsheet->addSheet($sheet);

        $this->applySheetHeaderBanner(
            $sheet,
            'DETAIL JAWABAN: 1. IDE BISNISKU',
            'Rincian gagasan usaha dan alasan pemilihan ide bisnis yang dirancang oleh siswa',
            'E'
        );

        $headers = [
            'A4' => 'No.',
            'B4' => 'Nama Siswa',
            'C4' => 'Ide Bisnis / Usaha',
            'D4' => 'Alasan Memilih Ide Tersebut',
            'E4' => 'Waktu Submit',
        ];

        $this->applyTableHeaders($sheet, $headers, 'A4:E4', 'D97706'); // Warm Amber theme

        $row = 5;
        $no = 1;

        foreach ($submissions as $sub) {
            $payload = $sub->payload ?? [];
            $ide = $payload['ide'] ?? $sub->answer_text ?? '-';
            $alasan = $payload['alasan'] ?? '-';

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $sub->user->name ?? 'Siswa (Telah Dihapus)');
            $sheet->setCellValue("C{$row}", $ide);
            $sheet->setCellValue("D{$row}", $alasan);
            $sheet->setCellValue("E{$row}", $sub->created_at ? $sub->created_at->translatedFormat('d M Y, H:i:s') : '-');

            $this->applyDataRowStyle($sheet, $row, 'A', 'E', ($no % 2 === 0));

            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        if ($submissions->isEmpty()) {
            $sheet->setCellValue("A5", "Belum ada jawaban ide bisnis.");
            $sheet->mergeCells("A5:E5");
            $sheet->getStyle("A5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(5)->setRowHeight(30);
        }

        $this->setColumnWidths($sheet, [
            'A' => 6,
            'B' => 26,
            'C' => 45,
            'D' => 45,
            'E' => 22,
        ]);

        $sheet->setAutoFilter('A4:E' . max(4, $row - 1));
        $sheet->freezePane('A5');
    }

    /**
     * Sheet 4: Detail Modul 2 - Rencana Keuangan
     */
    private function createRencanaKeuanganSheet(Spreadsheet $spreadsheet, $users): void
    {
        $sheet = new Worksheet($spreadsheet, '2. Rencana Keuangan');
        $spreadsheet->addSheet($sheet);

        $this->applySheetHeaderBanner(
            $sheet,
            'DETAIL JAWABAN: 2. RENCANA KEUANGAN',
            'Rincian simulasi game belanja kebutuhan produksi dan perhitungan sisa modal usaha',
            'F'
        );

        $headers = [
            'A4' => 'No.',
            'B4' => 'Nama Siswa',
            'C4' => 'Pilihan Belanja Kebutuhan',
            'D4' => 'Total Belanja',
            'E4' => 'Perhitungan Sisa Modal (Modal Awal Rp1jt)',
            'F4' => 'Status Perhitungan',
        ];

        $this->applyTableHeaders($sheet, $headers, 'A4:F4', '059669'); // Emerald Green theme

        $row = 5;
        $no = 1;

        foreach ($users as $user) {
            $subs = $user->submissions->keyBy('step_key');
            $gameSub = $subs->get('game_belanja');
            $modalSub = $subs->get('hitung_modal');

            if (!$gameSub && !$modalSub) {
                continue;
            }

            $gamePayload = $gameSub->payload ?? [];
            $totalSpend = $gamePayload['total_spending'] ?? null;
            $selectedIds = $gamePayload['selected_ids'] ?? [];

            $modalPayload = $modalSub->payload ?? [];
            $numericAnswer = $modalPayload['numeric_answer'] ?? null;
            $isCorrect = $modalPayload['is_correct'] ?? false;

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $user->name ?? 'Tamu');
            $sheet->setCellValue("C{$row}", !empty($selectedIds) ? "3 Item Kategori Produksi Terpilih (ID: " . implode(', ', $selectedIds) . ")" : 'Belum Selesai');
            $sheet->setCellValue("D{$row}", $totalSpend ? 'Rp ' . number_format($totalSpend, 0, ',', '.') : '-');
            $sheet->setCellValue("E{$row}", $numericAnswer ? 'Jawaban Siswa: Rp ' . number_format((int)$numericAnswer, 0, ',', '.') : ($modalSub->answer_text ?? 'Belum Selesai'));
            $sheet->setCellValue("F{$row}", $modalSub ? ($isCorrect ? 'Benar (Sisa Rp300.000)' : 'Perlu Diperbaiki') : '-');

            $this->applyDataRowStyle($sheet, $row, 'A', 'F', ($no % 2 === 0));

            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        if ($no === 1) {
            $sheet->setCellValue("A5", "Belum ada data pengerjaan rencana keuangan.");
            $sheet->mergeCells("A5:F5");
            $sheet->getStyle("A5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(5)->setRowHeight(30);
        }

        $this->setColumnWidths($sheet, [
            'A' => 6,
            'B' => 26,
            'C' => 38,
            'D' => 18,
            'E' => 34,
            'F' => 24,
        ]);

        $sheet->setAutoFilter('A4:F' . max(4, $row - 1));
        $sheet->freezePane('A5');
    }

    /**
     * Sheet 5: Detail Modul 3 - Pengembangan Bisnis
     */
    private function createPengembanganBisnisSheet(Spreadsheet $spreadsheet, $users): void
    {
        $sheet = new Worksheet($spreadsheet, '3. Pengembangan Bisnis');
        $spreadsheet->addSheet($sheet);

        $this->applySheetHeaderBanner(
            $sheet,
            'DETAIL JAWABAN: 3. PENGEMBANGAN BISNIS',
            'Rincian perhitungan total modal akhir serta analisis studi kasus tabungan dan investasi',
            'E'
        );

        $headers = [
            'A4' => 'No.',
            'B4' => 'Nama Siswa',
            'C4' => 'Hitung Total Uang Usaha (Rp1.5jt + Rp300rb)',
            'D4' => 'Jawaban Kasus Tabungan',
            'E4' => 'Jawaban Kasus Investasi',
        ];

        $this->applyTableHeaders($sheet, $headers, 'A4:E4', '7C3AED'); // Purple theme

        $row = 5;
        $no = 1;

        foreach ($users as $user) {
            $subs = $user->submissions->keyBy('step_key');
            $totalSub = $subs->get('hitung_total_usaha');
            $tabunganSub = $subs->get('studi_kasus_tabungan');
            $investasiSub = $subs->get('studi_kasus_investasi');

            if (!$totalSub && !$tabunganSub && !$investasiSub) {
                continue;
            }

            $totalText = '-';
            if ($totalSub) {
                $tPayload = $totalSub->payload ?? [];
                $tot = $tPayload['total_usaha'] ?? $totalSub->answer_text;
                $totalText = 'Rp ' . number_format((int)$tot, 0, ',', '.') . ' (Tepat)';
            }

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $user->name ?? 'Tamu');
            $sheet->setCellValue("C{$row}", $totalText);
            $sheet->setCellValue("D{$row}", $tabunganSub->answer_text ?? '-');
            $sheet->setCellValue("E{$row}", $investasiSub->answer_text ?? '-');

            $this->applyDataRowStyle($sheet, $row, 'A', 'E', ($no % 2 === 0));

            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        if ($no === 1) {
            $sheet->setCellValue("A5", "Belum ada data pengerjaan pengembangan bisnis.");
            $sheet->mergeCells("A5:E5");
            $sheet->getStyle("A5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(5)->setRowHeight(30);
        }

        $this->setColumnWidths($sheet, [
            'A' => 6,
            'B' => 26,
            'C' => 28,
            'D' => 45,
            'E' => 45,
        ]);

        $sheet->setAutoFilter('A4:E' . max(4, $row - 1));
        $sheet->freezePane('A5');
    }

    /**
     * Reusable Sheet Top Banner with title & timestamp
     */
    private function applySheetHeaderBanner(Worksheet $sheet, string $title, string $subtitle, string $lastCol): void
    {
        $sheet->setShowGridLines(true);

        // Row 1: Main Title
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getRowDimension(1)->setRowHeight(34);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0F172A'], // Dark Slate Navy
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Row 2: Subtitle & Timestamp
        $timestamp = 'Waktu Ekspor: ' . date('d F Y, H:i') . ' WIB  •  ' . $subtitle;
        $sheet->setCellValue('A2', $timestamp);
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'italic' => true,
                'size' => 9.5,
                'color' => ['rgb' => '475569'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F1F5F9'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Row 3: Spacing
        $sheet->getRowDimension(3)->setRowHeight(10);
    }

    /**
     * Reusable Table Headers style
     */
    private function applyTableHeaders(Worksheet $sheet, array $headers, string $range, string $bgColorHex): void
    {
        foreach ($headers as $cell => $label) {
            $sheet->setCellValue($cell, $label);
        }

        $sheet->getRowDimension(4)->setRowHeight(28);

        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'bold' => true,
                'size' => 10.5,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bgColorHex],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
        ]);
    }

    /**
     * Reusable Data Row Styling with Zebra striping & wrap text
     */
    private function applyDataRowStyle(Worksheet $sheet, int $row, string $startCol, string $endCol, bool $isZebra): void
    {
        $sheet->getRowDimension($row)->setRowHeight(-1); // Auto row height based on content

        $bgRgb = $isZebra ? 'F8FAFC' : 'FFFFFF';

        $sheet->getStyle("{$startCol}{$row}:{$endCol}{$row}")->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'size' => 10,
                'color' => ['rgb' => '1E293B'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bgRgb],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ]);
    }

    /**
     * Set specific column widths
     */
    private function setColumnWidths(Worksheet $sheet, array $widths): void
    {
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }
    }
}
