<?php
require_once __DIR__ . '/classes/Menu.php';
require_once __DIR__ . '/classes/Layanan.php';
$menu = new Menu([
 ['label'=>'Beranda','url'=>'index.php','active'=>true],
 ['label'=>'Inventaris','url'=>'frontend/Pages/inventaris.html'],
 ['label'=>'Kerja Sama','url'=>'frontend/Pages/kerjasama.html'],
 ['label'=>'Info Lomba','url'=>'frontend/Pages/info-lomba.html'],
 ['label'=>'Informasi','url'=>'frontend/Pages/informasi.html'],
 ['label'=>'Report Posko','url'=>'frontend/Pages/report-posko.html'],
 ['label'=>'Program Prioritas','url'=>'frontend/Pages/program-prioritas.php']
]);
$layanan = [
 new Layanan('Inventaris','Melihat dan mengelola informasi inventaris KSR-PMI Unit UMM.','frontend/Pages/inventaris.html','Lihat Inventaris'),
 new Layanan('Kerja Sama','Mengelola informasi dan pengajuan kerja sama dengan KSR-PMI Unit UMM.','frontend/Pages/kerjasama.html','Lihat Kerja Sama'),
 new Layanan('Info Lomba','Menyediakan informasi mengenai lomba dan kegiatan yang relevan.','frontend/Pages/info-lomba.html','Lihat Info Lomba'),
 new Layanan('Informasi','Menampilkan informasi dan pengumuman dari KSR-PMI Unit UMM.','frontend/Pages/informasi.html','Lihat Informasi'),
 new Layanan('Report Posko','Fitur pelaporan posko yang hanya dapat diakses oleh pengguna yang memiliki hak akses.','frontend/Pages/report-posko.html','Report Posko')
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KSR-MIS | KSR-PMI Unit UMM</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 font-sans">

    <!-- HEADER (Center, sama seperti pages) -->
    <header class="bg-red-700 px-4 py-6 text-center text-white">
        <h1 class="text-3xl font-bold">KSR-MIS</h1>
        <p class="mt-1 text-sm text-red-100 sm:text-base">
            KSR-PMI Unit UMM Management Information System
        </p>
    </header>


<!-- Navigation -->
<nav class="bg-red-800 shadow-md">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap justify-center gap-1 py-2 sm:gap-3">
<?= $menu->render() ?>
</ul>
    </div>
</nav>


    <!-- MAIN (Tidak diubah sama sekali) -->
    <main class="mx-auto max-w-6xl px-5 py-8 sm:px-6 sm:py-10 md:px-10">

        <!-- WELCOME -->
        <section class="mb-10">
            <div class="mb-6">
                <h2 class="mb-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                    Selamat Datang di KSR-MIS
                </h2>
                <p class="text-gray-600">
                    Sistem informasi terintegrasi untuk mendukung pengelolaan
                    layanan, informasi, dan aktivitas KSR-PMI Unit UMM.
                </p>
            </div>

            <!-- SELECT + CHANGE -->
            <div class="rounded-xl border border-red-100 bg-red-50 p-5 sm:p-6">
                <label for="kategori" class="mb-2 block font-semibold text-gray-800">
                    Pilih layanan KSR-MIS
                </label>

                <!-- SELECT (Dikomentari sesuai kode asli) 
                <select id="kategori" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-800 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 sm:max-w-md">
                    <option value="">-- Pilih layanan --</option>
                    <option value="Inventaris">Inventaris</option>
                    <option value="Kerja Sama">Kerja Sama</option>
                    <option value="Info Lomba">Info Lomba</option>
                    <option value="Informasi">Informasi</option>
                    <option value="Report Posko">Report Posko</option>
                </select>
                -->

                <p id="hasilKategori" class="mt-3 text-sm font-medium text-red-700">
                    Silakan pilih salah satu layanan.
                </p>
            </div>
        </section>


        <!-- LAYANAN UTAMA -->
        <section>
            <div class="mb-6">
                <h2 class="mb-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                    Layanan Utama
                </h2>
                <p class="text-gray-600">
                    Akses berbagai fitur KSR-PMI Unit UMM.
                </p>
            </div>

            <!-- RESPONSIVE GRID -->
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

                <?php foreach ($layanan as $item): ?>
                    <?= $item->render() ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>


    <!-- FOOTER (Tidak diubah) -->
    <footer class="mt-10 bg-gray-900 px-5 py-6 text-center text-sm text-gray-300 sm:px-10">
        <p>
            &copy; 2026 KSR-PMI Unit UMM. KSR-MIS.
        </p>
    </footer>


    <!-- JAVASCRIPT (Tidak diubah) -->
    <script src="script.js"></script>

</body>
</html>