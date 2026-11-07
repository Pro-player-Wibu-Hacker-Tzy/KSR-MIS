
<?php

// Memuat class milik programmer 1
require_once __DIR__ . '/classes/Menu.php';
require_once __DIR__ . '/classes/Layanan.php';
require_once __DIR__ . '/classes/ProgramPrioritas.php';

/*
|--------------------------------------------------------------------------
| INTEGRASI CLASS KONTRIBUTOR
|--------------------------------------------------------------------------
| File dimuat jika sudah dibuat oleh kontributor.
| Nama class diperiksa tanpa mengasumsikan constructor atau method-nya.
*/

$classKontributor = [
    'Inventaris' => [
        'file' => __DIR__ . '/classes/Inventaris.php',
        'class' => 'Inventaris'
    ],
    'KerjaSama' => [
        'file' => __DIR__ . '/classes/KerjaSama.php',
        'class' => 'KerjaSama'
    ],
    'InfoLomba' => [
        'file' => __DIR__ . '/classes/InfoLomba.php',
        'class' => 'InfoLomba'
    ],
    'Informasi' => [
        'file' => __DIR__ . '/classes/Informasi.php',
        'class' => 'Informasi'
    ],
    'ReportPosko' => [
        'file' => __DIR__ . '/classes/ReportPosko.php',
        'class' => 'ReportPosko'
    ]
];

$statusKontributor = [];

foreach ($classKontributor as $nama => $data) {
    if (file_exists($data['file'])) {
        require_once $data['file'];
    }

    $statusKontributor[$nama] = [
        'file' => file_exists($data['file']),
        'class' => class_exists($data['class'])
    ];
}

// Membuat object Menu
$menu = new Menu([
    [
        'label' => 'Beranda',
        'url' => 'index.php'
    ],
    [
        'label' => 'Program Prioritas',
        'url' => 'frontend/Pages/program-prioritas.php'
    ],
    [
        'label' => 'Demo OOP',
        'url' => 'oop-demo.php',
        'active' => true
    ]
]);

// Membuat object Layanan
$layanan = [
    new Layanan(
        'Inventaris',
        'Melihat dan mengelola informasi inventaris KSR-PMI Unit UMM.',
        'frontend/Pages/inventaris.html',
        'Lihat Inventaris'
    ),
    new Layanan(
        'Kerja Sama',
        'Mengelola informasi dan pengajuan kerja sama.',
        'frontend/Pages/kerjasama.html',
        'Lihat Kerja Sama'
    ),
    new Layanan(
        'Program Prioritas',
        'Melihat daftar program kerja prioritas organisasi.',
        'frontend/Pages/program-prioritas.php',
        'Lihat Program'
    )
];

// Membuat object ProgramPrioritas
$programDemo = new ProgramPrioritas(
    99,
    'Demonstrasi Penerapan OOP',
    'Teknologi & Informasi',
    'Tim Pengembang KSR-MIS',
    '2026-01-01',
    '2026-12-31',
    'Berlangsung',
    75,
    'Contoh object ProgramPrioritas yang menampilkan penggunaan constructor, property, dan method.'
);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demonstrasi OOP | KSR-MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 font-sans text-gray-800">

<header class="bg-red-700 px-4 py-6 text-center text-white">
    <h1 class="text-3xl font-bold">KSR-MIS</h1>
    <p class="mt-1 text-sm text-red-100">
        Demonstrasi Object-Oriented Programming PHP
    </p>
</header>

<nav class="bg-red-800 shadow-md">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap justify-center gap-1 py-2 sm:gap-3">
            <?= $menu->render() ?>
        </ul>
    </div>
</nav>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">
            Demonstrasi Konsep OOP
        </h2>
        <p class="mt-2 text-gray-600">
            Halaman ini memperlihatkan penerapan class, object, property,
            constructor, dan method pada proyek KSR-MIS.
        </p>
    </section>

    <!-- Class dan Object -->
    <section class="mb-8">
        <h3 class="mb-4 text-xl font-bold text-gray-900">
            1. Demonstrasi Class dan Object
        </h3>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <h4 class="mb-2 font-bold text-red-700">Object Menu</h4>
                <p class="mb-3 text-sm text-gray-600">
                    Object dibuat menggunakan constructor Menu.
                    Method render() menghasilkan navigasi HTML.
                </p>
                <div class="rounded-lg bg-red-800 p-3">
                    <ul class="flex flex-wrap gap-2">
                        <?= $menu->render() ?>
                    </ul>
                </div>
            </article>

            <article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <h4 class="mb-2 font-bold text-red-700">Object Layanan</h4>
                <p class="mb-3 text-sm text-gray-600">
                    Beberapa object Layanan dibuat dengan data berbeda,
                    kemudian ditampilkan menggunakan method render().
                </p>
                <div class="space-y-3">
                    <?php foreach ($layanan as $item): ?>
                        <?= $item->render() ?>
                    <?php endforeach; ?>
                </div>
            </article>
        </div>
    </section>

    <!-- Property dan Method -->
    <section class="mb-8">
        <h3 class="mb-4 text-xl font-bold text-gray-900">
            2. Demonstrasi Property dan Method
        </h3>

        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
            <h4 class="mb-2 text-lg font-bold">
                <?= htmlspecialchars($programDemo->namaProgram, ENT_QUOTES, 'UTF-8') ?>
            </h4>

            <p class="mb-3 text-sm text-gray-600">
                <?= htmlspecialchars($programDemo->deskripsi, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <div class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                <p><strong>ID:</strong> <?= $programDemo->id ?></p>
                <p><strong>Kategori:</strong> <?= htmlspecialchars($programDemo->kategori, ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Penanggung Jawab:</strong> <?= htmlspecialchars($programDemo->penanggungJawab, ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Status:</strong> <?= $programDemo->renderStatusBadge() ?></p>
                <p><strong>Tanggal Mulai:</strong> <?= htmlspecialchars($programDemo->formatTanggal($programDemo->tanggalMulai), ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Target Selesai:</strong> <?= htmlspecialchars($programDemo->formatTanggal($programDemo->targetSelesai), ENT_QUOTES, 'UTF-8') ?></p>
            </div>

            <div class="mt-4">
                <div class="mb-1 flex justify-between text-xs font-semibold">
                    <span>Progress</span>
                    <span><?= $programDemo->progress ?>%</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-red-600"
                         style="width: <?= $programDemo->progress ?>%"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Integrasi class kontributor -->
    <section class="mb-8">
        <h3 class="mb-4 text-xl font-bold text-gray-900">
            3. Integrasi Class dari Kontributor
        </h3>

        <p class="mb-4 text-sm text-gray-600">
            Sistem memeriksa file dan class milik dua kontributor.
            Class akan terdeteksi setelah file tersedia dan nama class
            di dalamnya sesuai.
        </p>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Nama Class</th>
                            <th class="px-4 py-3">File PHP</th>
                            <th class="px-4 py-3">Status Class</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($statusKontributor as $nama => $status): ?>
                            <tr>
                                <td class="px-4 py-3 font-semibold">
                                    <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?= $status['file'] ? 'File tersedia' : 'Belum tersedia' ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($status['class']): ?>
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Class terdeteksi
                                        </span>
                                    <?php else: ?>
                                        <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                            Menunggu class
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Penjelasan OOP -->
    <section class="rounded-xl border border-red-100 bg-red-50 p-5">
        <h3 class="mb-3 text-lg font-bold text-red-800">
            Kesimpulan Penerapan OOP
        </h3>

        <ul class="list-disc space-y-2 pl-5 text-sm text-gray-700">
            <li><strong>Class:</strong> cetak biru untuk membuat object.</li>
            <li><strong>Object:</strong> instance dari class Menu, Layanan, dan ProgramPrioritas.</li>
            <li><strong>Property:</strong> menyimpan data yang dimiliki object.</li>
            <li><strong>Constructor:</strong> mengisi data saat object dibuat.</li>
            <li><strong>Method:</strong> menjalankan fungsi yang dimiliki object, seperti render().</li>
            <li><strong>Encapsulation:</strong> property Menu dan Layanan disimpan sebagai private.</li>
        </ul>
    </section>

</main>

<footer class="mt-12 bg-gray-900 px-4 py-6 text-center text-sm text-gray-400">
    <p>&copy; 2026 KSR-PMI Unit UMM. KSR-MIS.</p>
</footer>

</body>
</html>
