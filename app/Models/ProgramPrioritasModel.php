<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2)
    . '/classes/program-prioritas.php';

class ProgramPrioritasModel
{
    /**
     * Data Program Prioritas dari proyek KSR-MIS.
     *
     * @return ProgramPrioritas[]
     */
    public function getAll(): array
    {
        return [
            new ProgramPrioritas(
                1,
                'Pengadaan Ambulans KSR-PMI Unit UMM',
                'Fasilitas & Inventaris',
                'Divisi Inventaris',
                '2026-01-10',
                '2026-06-30',
                'Berlangsung',
                65,
                'Pengadaan dan penyiapan unit ambulans '
                . 'operasional untuk pertolongan pertama '
                . 'siaga tanggap darurat kampus.'
            ),

            new ProgramPrioritas(
                2,
                'Pelatihan Pertolongan Pertama (PP) Nasional',
                'Diklat & Pelatihan',
                'Divisi Pendidikan',
                '2026-02-01',
                '2026-04-15',
                'Akan Datang',
                25,
                'Penyelenggaraan pelatihan sertifikasi '
                . 'pertolongan pertama tingkat nasional '
                . 'untuk anggota aktif KSR.'
            ),

            new ProgramPrioritas(
                3,
                'Digitalisasi Sistem Management KSR-MIS',
                'Teknologi & Informasi',
                'Divisi Humas & IT',
                '2026-01-05',
                '2026-03-20',
                'Selesai',
                100,
                'Pengembangan platform web terintegrasi '
                . 'untuk pengelolaan data inventaris, posko, '
                . 'kerja sama, dan info lomba.'
            ),

            new ProgramPrioritas(
                4,
                'Renovasi & Standarisasi Posko Siaga Bencana',
                'Infrastruktur Posko',
                'Divisi Logistik',
                '2026-03-01',
                '2026-05-10',
                'Berlangsung',
                40,
                'Peningkatan kelayakan dan kapasitas ruang '
                . 'penyimpanan alat medis serta ruang siaga '
                . 'petugas posko.'
            ),

            new ProgramPrioritas(
                5,
                'Kemitraan Strategis Donor Darah Rutin PMI',
                'Kerja Sama & Pengabdian',
                'Divisi Kerjasama',
                '2026-01-15',
                '2026-12-31',
                'Berlangsung',
                80,
                'Program rutin donor darah tiga bulanan '
                . 'berkolaborasi dengan PMI Kota Malang '
                . 'dan PMI Jawa Timur.'
            ),
        ];
    }

    public function getSummary(): array
    {
        $programs = $this->getAll();

        $summary = [
            'totalProgram' => count($programs),
            'totalBerlangsung' => 0,
            'totalSelesai' => 0,
            'totalAkanDatang' => 0,
        ];

        foreach ($programs as $program) {
            switch ($program->status) {
                case 'Berlangsung':
                    $summary['totalBerlangsung']++;
                    break;

                case 'Selesai':
                    $summary['totalSelesai']++;
                    break;

                case 'Akan Datang':
                    $summary['totalAkanDatang']++;
                    break;
            }
        }

        return $summary;
    }
}