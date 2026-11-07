
<?php

require_once __DIR__ . '/../../classes/ProgramPrioritas.php';

$programPrioritas = [
    new ProgramPrioritas(
        1,
        "Pengadaan Ambulans KSR-PMI Unit UMM",
        "Fasilitas & Inventaris",
        "Divisi Inventaris",
        "2026-01-10",
        "2026-06-30",
        "Berlangsung",
        65,
        "Pengadaan dan penyiapan unit ambulans operasional untuk pertolongan pertama siaga tanggap darurat kampus."
    ),
    new ProgramPrioritas(
        2,
        "Pelatihan Pertolongan Pertama (PP) Nasional",
        "Diklat & Pelatihan",
        "Divisi Pendidikan",
        "2026-02-01",
        "2026-04-15",
        "Akan Datang",
        25,
        "Penyelenggaraan pelatihan sertifikasi pertolongan pertama tingkat nasional untuk anggota aktif KSR."
    ),
    new ProgramPrioritas(
        3,
        "Digitalisasi Sistem Management KSR-MIS",
        "Teknologi & Informasi",
        "Divisi Humas & IT",
        "2026-01-05",
        "2026-03-20",
        "Selesai",
        100,
        "Pengembangan platform web terintegrasi untuk pengelolaan data inventaris, posko, kerja sama, dan info lomba."
    ),
    new ProgramPrioritas(
        4,
        "Renovasi & Standarisasi Posko Siaga Bencana",
        "Infrastruktur Posko",
        "Divisi Logistik",
        "2026-03-01",
        "2026-05-10",
        "Berlangsung",
        40,
        "Peningkatan kelayakan dan kapasitas ruang penyimpanan alat medis serta ruang siaga petugas posko."
    ),
    new ProgramPrioritas(
        5,
        "Kemitraan Strategis Donor Darah Rutin PMI",
        "Kerja Sama & Pengabdian",
        "Divisi Kerjasama",
        "2026-01-15",
        "2026-12-31",
        "Berlangsung",
        80,
        "Program rutin donor darah 3 bulanan berkolaborasi dengan PMI Kota Malang dan PMI Jawa Timur."
    ),
];

$totalProgram = count($programPrioritas);
$totalBerlangsung = 0;
$totalSelesai = 0;
$totalAkanDatang = 0;

foreach ($programPrioritas as $program) {
    if ($program->status === 'Berlangsung') {
        $totalBerlangsung++;
    } elseif ($program->status === 'Selesai') {
        $totalSelesai++;
    } elseif ($program->status === 'Akan Datang') {
        $totalAkanDatang++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Prioritas | KSR-MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 font-sans text-gray-800">

<header class="bg-red-700 px-4 py-6 text-center text-white">
    <h1 class="text-3xl font-bold">KSR-MIS</h1>
    <p class="mt-1 text-sm text-red-100 sm:text-base">
        KSR-PMI Unit UMM Management Information System
    </p>
</header>

<nav class="bg-red-800 shadow-md">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap justify-center gap-1 py-2 sm:gap-3">
            <li><a href="../../index.php" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Beranda</a></li>
            <li><a href="inventaris.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Inventaris</a></li>
            <li><a href="kerjasama.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Kerja Sama</a></li>
            <li><a href="info-lomba.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Info Lomba</a></li>
            <li><a href="informasi.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Informasi</a></li>
            <li><a href="report-posko.html" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Report Posko</a></li>
            <li><a href="program-prioritas.php" class="block rounded-lg bg-white px-3 py-2 text-sm font-semibold text-red-700">Program Prioritas</a></li>
            <li><a href="../../oop-demo.php" class="block rounded-lg px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Demo OOP</a></li>
        </ul>
    </div>
</nav>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Program Prioritas Organisasi
        </h2>
        <p class="mt-2 text-gray-600">
            Daftar agenda dan program kerja unggulan KSR-PMI Unit UMM.
        </p>
    </section>

    <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-4">
        <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
            <p class="text-sm font-medium text-gray-500">Total Program</p>
            <strong class="mt-2 block text-3xl font-bold"><?= $totalProgram ?></strong>
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

    <section class="mb-12">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Kartu Program Prioritas</h2>
            <p class="text-sm text-gray-600">
                Kartu dibuat melalui method renderCard() dari object ProgramPrioritas.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($programPrioritas as $index => $program): ?>
                <?= $program->renderCard($index + 1) ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900">Ringkasan Tabel Program</h2>
            <p class="text-sm text-gray-600">
                Baris tabel dibuat melalui method renderTableRow().
            </p>
        </div>

        <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-500">
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
                        <?php foreach ($programPrioritas as $index => $program): ?>
                            <?= $program->renderTableRow($index + 1) ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>

</main>

<footer class="mt-12 bg-gray-900 px-4 py-6 text-center text-sm text-gray-400">
    <p>&copy; 2026 KSR-PMI Unit UMM. KSR-MIS.</p>
</footer>

</body>
</html>
