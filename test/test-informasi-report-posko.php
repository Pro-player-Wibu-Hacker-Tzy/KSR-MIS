<?php

declare(strict_types=1);

require_once __DIR__ . '/../classes/Informasi.php';
require_once __DIR__ . '/../classes/ReportPosko.php';

function expectSame(mixed $expected, mixed $actual, string $test): void
{
    if ($expected !== $actual) {
        throw new RuntimeException(sprintf(
            "%s failed.\nExpected: %s\nActual: %s",
            $test,
            var_export($expected, true),
            var_export($actual, true)
        ));
    }
}

function expectContains(string $needle, string $haystack, string $test): void
{
    if (!str_contains($haystack, $needle)) {
        throw new RuntimeException("$test failed: expected output to contain '$needle'.");
    }
}

$informasi = new Informasi(
    1,
    'Pelatihan Pertolongan Pertama',
    'Pelatihan dibuka untuk anggota.',
    '2026-11-07',
    'Pelatihan'
);

expectSame(1, $informasi->getId(), 'Informasi getter id');
expectSame('Pelatihan Pertolongan Pertama', $informasi->getJudul(), 'Informasi getter judul');
expectSame('Pelatihan dibuka untuk anggota.', $informasi->getIsi(), 'Informasi getter isi');
expectSame('2026-11-07', $informasi->getTanggal(), 'Informasi getter tanggal');
expectSame('Pelatihan', $informasi->getKategori(), 'Informasi getter kategori');
expectSame(
    'Informasi: Pelatihan Pertolongan Pertama | Kategori: Pelatihan | Tanggal: 2026-11-07 | Isi: Pelatihan dibuka untuk anggota.',
    $informasi->getInformasi(),
    'Informasi summary'
);
expectContains('<article', $informasi->render(), 'Informasi HTML');

$unsafeInformasi = new Informasi(2, '<script>alert(1)</script>', 'Isi & detail', '', 'Umum');
$unsafeInformasiHtml = $unsafeInformasi->render();
expectContains('&lt;script&gt;alert(1)&lt;/script&gt;', $unsafeInformasiHtml, 'Informasi title escaping');
expectContains('Isi &amp; detail', $unsafeInformasiHtml, 'Informasi body escaping');
expectSame(false, str_contains($unsafeInformasiHtml, '<script>'), 'Informasi excludes raw script');

$report = new ReportPosko(
    3,
    'Posko Kampus',
    'Universitas Muhammadiyah Malang',
    '2026-11-07',
    5,
    'Aman',
    'Operasional berjalan lancar.'
);

expectSame(3, $report->getId(), 'Report getter id');
expectSame('Posko Kampus', $report->getNamaPosko(), 'Report getter nama posko');
expectSame('Universitas Muhammadiyah Malang', $report->getLokasi(), 'Report getter lokasi');
expectSame('2026-11-07', $report->getTanggal(), 'Report getter tanggal');
expectSame(5, $report->getJumlahPetugas(), 'Report getter jumlah petugas');
expectSame('Aman', $report->getKondisi(), 'Report getter kondisi');
expectSame('Operasional berjalan lancar.', $report->getKeterangan(), 'Report getter keterangan');
expectSame(
    'Report Posko: Posko Kampus | Lokasi: Universitas Muhammadiyah Malang | Tanggal: 2026-11-07 | Petugas: 5 | Kondisi: Aman | Keterangan: Operasional berjalan lancar.',
    $report->getInformasi(),
    'Report summary'
);
expectSame('Posko dalam kondisi aman.', $report->getStatusKondisi(), 'Safe condition status');
expectContains('<article', $report->render(), 'Report HTML');

$conditionCases = [
    'Perlu Perhatian' => 'Posko memerlukan perhatian.',
    'Darurat' => 'Posko dalam kondisi darurat.',
    'Kondisi lainnya' => 'Kondisi posko belum diketahui.',
    ' aMaN ' => 'Posko dalam kondisi aman.',
];

foreach ($conditionCases as $condition => $expectedStatus) {
    $conditionReport = new ReportPosko(4, 'Posko Uji', 'Malang', '2026-11-07', 0, $condition, '-');
    expectSame($expectedStatus, $conditionReport->getStatusKondisi(), "Condition status: $condition");
    expectContains('<article', $conditionReport->render(), "Condition render: $condition");
}

$unsafeReport = new ReportPosko(5, 'Posko <B>', 'Malang & Batu', '', 2, 'Darurat', '<img src=x>');
$unsafeReportHtml = $unsafeReport->render();
expectContains('Posko &lt;B&gt;', $unsafeReportHtml, 'Report name escaping');
expectContains('Malang &amp; Batu', $unsafeReportHtml, 'Report location escaping');
expectContains('&lt;img src=x&gt;', $unsafeReportHtml, 'Report note escaping');
expectSame(false, str_contains($unsafeReportHtml, '<img'), 'Report excludes raw image tag');

echo "Semua test Informasi dan ReportPosko berhasil.\n";
