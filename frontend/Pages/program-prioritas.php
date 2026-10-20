<?php
// 1. DATA ARRAY MULTIDIMENSI (PHP PROGRAM PRIORITAS)
$programPrioritas = [
    [
        "id" => 1,
        "namaProgram" => "Pengadaan Ambulans KSR-PMI Unit UMM",
        "kategori" => "Fasilitas & Inventaris",
        "penanggungJawab" => "Divisi Inventaris",
        "tanggalMulai" => "2026-01-10",
        "targetSelesai" => "2026-06-30",
        "status" => "Berlangsung",
        "progress" => 65,
        "deskripsi" => "Pengadaan dan penyiapan unit ambulans operasional untuk pertolongan pertama siaga tanggap darurat kampus."
    ],
    [
        "id" => 2,
        "namaProgram" => "Pelatihan Pertolongan Pertama (PP) Nasional",
        "kategori" => "Diklat & Pelatihan",
        "penanggungJawab" => "Divisi Pendidikan",
        "tanggalMulai" => "2026-02-01",
        "targetSelesai" => "2026-04-15",
        "status" => "Akan Datang",
        "progress" => 25,
        "deskripsi" => "Penyelenggaraan pelatihan sertifikasi pertolongan pertama tingkat nasional untuk anggota aktif KSR."
    ],
    [
        "id" => 3,
        "namaProgram" => "Digitalisasi Sistem Management KSR-MIS",
        "kategori" => "Teknologi & Informasi",
        "penanggungJawab" => "Divisi Humas & IT",
        "tanggalMulai" => "2026-01-05",
        "targetSelesai" => "2026-03-20",
        "status" => "Selesai",
        "progress" => 100,
        "deskripsi" => "Pengembangan platform web terintegrasi untuk pengelolaan data inventaris, posko, kerja sama, dan info lomba."
    ],
    [
        "id" => 4,
        "namaProgram" => "Renovasi & Standarisasi Posko Siaga Bencana",
        "kategori" => "Infrastruktur Posko",
        "penanggungJawab" => "Divisi Logistik",
        "tanggalMulai" => "2026-03-01",
        "targetSelesai" => "2026-05-10",
        "status" => "Berlangsung",
        "progress" => 40,
        "deskripsi" => "Peningkatan kelayakan dan kapasitas ruang penyimpanan alat medis serta ruang siaga petugas posko."
    ],
    [
        "id" => 5,
        "namaProgram" => "Kemitraan Strategis Donor Darah Rutin PMI",
        "kategori" => "Kerja Sama & Pengabdian",
        "penanggungJawab" => "Divisi Kerjasama",
        "tanggalMulai" => "2026-01-15",
        "targetSelesai" => "2026-12-31",
        "status" => "Berlangsung",
        "progress" => 80,
        "deskripsi" => "Program rutin donor darah 3 bulanan berkolaborasi dengan PMI Kota Malang dan PMI Jawa Timur."
    ]
];

// 2. PROCESS DATA WITH PHP (KALKULASI STATISTIK & FUNGSI)

// Perhitungan Statistik
$totalProgram   = count($programPrioritas);
$totalBerlangsung = count(array_filter($programPrioritas, fn($item) => $item['status'] === 'Berlangsung'));
$totalSelesai   = count(array_filter($programPrioritas, fn($item) => $item['status'] === 'Selesai'));
$totalAkanDatang = count(array_filter($programPrioritas, fn($item) => $item['status'] === 'Akan Datang'));

// Fungsi Conditional Status / Badge HTML
function renderStatusBadge($status) {
    switch ($status) {
        case 'Akan Datang':
            return '<span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">Akan Datang</span>';
        case 'Berlangsung':
            return '<span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">Berlangsung</span>';
        case 'Selesai':
            return '<span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Selesai</span>';
        default:
            return '<span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">' . htmlspecialchars($status) . '</span>';
    }
}

// Fungsi Format Tanggal Bahasa Indonesia
function formatTanggalIndo($tanggal) {
    if (!$tanggal) return '-';
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $split = explode('-', $tanggal);
    if (count($split) !== 3) return htmlspecialchars($tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Prioritas | KSR-MIS</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 font-sans">

    <!-- Header (Sama seperti struktur Week 4) -->
    <header class="bg-red-700 px-4 py-6 text-center text-white">
        <h1 class="text-3xl font-bold">KSR-MIS</h1>
        <p class="mt-1 text-sm text-red-100 sm:text-base">KSR-PMI Unit UMM Management Information System</p>
    </header>

    <!-- Navigation (Sama seperti struktur Week 4) -->
    <nav class="bg-red-800 shadow-md">
        <div class="mx-auto max-w-7xl px-4">
            <ul class="flex flex-wrap justify-center gap-1 py-2 sm:gap-3">
                <li><a href="../../index.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Beranda</a></li>
                <li><a href="inventaris.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Inventaris</a></li>
                <li><a href="kerjasama.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Kerja Sama</a></li>
                <li><a href="info-lomba.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Info Lomba</a></li>
                <li><a href="informasi.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Informasi</a></li>
                <li><a href="report-posko.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">Report Posko</a></li>
                <li><a href="program-prioritas.php" class="block rounded-lg bg-white px-3 py-2 text-sm font-semibold text-red-700">Program Prioritas (PHP SSR)</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        
        <!-- Header Halaman -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Program Prioritas Organisasi</h2>
            <p class="mt-2 text-gray-600">Daftar agenda dan program kerja unggulan KSR-PMI Unit UMM (Server-Side Rendering dengan PHP).</p>
        </section>

        <!-- Dynamic Statistics Cards (Processed by PHP) -->
        <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-4">
            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <p class="text-sm font-medium text-gray-500">Total Program</p>
                <strong class="mt-2 block text-3xl font-bold text-gray-900"><?= $totalProgram ?></strong>
            </article>
            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <p class="text-sm font-medium text-gray-500">Berlangsung</p>
                <strong class="mt-2 block text-3xl font-bold text-blue-600"><?= $totalBerlangsung ?></strong>
            </article>
            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <p class="text-sm font-medium text-gray-500">Selesai</p>
                <strong class="mt-2 block text-3xl font-bold text-green-600"><?= $totalSelesai ?></strong>
            </article>
            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <p class="text-sm font-medium text-gray-500">Akan Datang</p>
                <strong class="mt-2 block text-3xl font-bold text-orange-500"><?= $totalAkanDatang ?></strong>
            </article>
        </section>

        <!-- 3. BUILD DYNAMIC SERVER-SIDE CONTENT (SSR DYNAMIC GRID CARDS) -->
        <section class="mb-12">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Kartu Program Prioritas</h2>
                    <p class="text-sm text-gray-600">Dynamic Grid Cards dirender langsung oleh Server PHP.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($programPrioritas as $index => $program) : ?>
                    <article class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md flex flex-col justify-between">
                        <div>
                            <!-- Header Card: Penomoran & Badge Status Conditional -->
                            <div class="mb-3 flex items-start justify-between gap-2">
                                <span class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/20">
                                    #<?= $index + 1 ?>
                                </span>
                                <?= renderStatusBadge($program['status']) ?>
                            </div>

                            <!-- Judul & Kategori -->
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block mb-1">
                                <?= htmlspecialchars($program['kategori']) ?>
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                <?= htmlspecialchars($program['namaProgram']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                <?= htmlspecialchars($program['deskripsi']) ?>
                            </p>
                        </div>

                        <div>
                            <!-- Progress Bar Dinamis PHP -->
                            <div class="mb-4">
                                <div class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                                    <span>Progres</span>
                                    <span><?= $program['progress'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-red-600 h-2 rounded-full transition-all duration-300" style="width: <?= $program['progress'] ?>%"></div>
                                </div>
                            </div>

                            <!-- Detail Tanggal & PJ -->
                            <div class="border-t border-gray-100 pt-3 text-xs text-gray-500 space-y-1">
                                <p><strong class="text-gray-700">PJ:</strong> <?= htmlspecialchars($program['penanggungJawab']) ?></p>
                                <p><strong class="text-gray-700">Target:</strong> <?= formatTanggalIndo($program['targetSelesai']) ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- LOOP PENOMORAN PADA TABEL RINGKASAN (SSR TABLE) -->
        <section>
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900">Ringkasan Tabel Program</h2>
                <p class="text-sm text-gray-600">Tampilan data tabular dengan loop penomoran PHP berurutan.</p>
            </div>

            <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Program</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Penanggung Jawab</th>
                                <th class="px-4 py-3">Target Selesai</th>
                                <th class="px-4 py-3">Progres</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php 
                            $no = 1; // Inisialisasi loop penomoran
                            foreach ($programPrioritas as $program) : 
                            ?>
                                <tr class="transition hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600 font-medium"><?= $no++ ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900"><?= htmlspecialchars($program['namaProgram']) ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600"><?= htmlspecialchars($program['kategori']) ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600"><?= htmlspecialchars($program['penanggungJawab']) ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600"><?= formatTanggalIndo($program['targetSelesai']) ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-800"><?= $program['progress'] ?>%</td>
                                    <td class="whitespace-nowrap px-4 py-3"><?= renderStatusBadge($program['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

    </main>

    <!-- Footer (Sama seperti struktur Week 4) -->
    <footer class="mt-12 bg-gray-900 px-4 py-6 text-center text-sm text-gray-400">
        <p>&copy; 2026 KSR-PMI Unit UMM. KSR-MIS.</p>
    </footer>

</body>
</html>