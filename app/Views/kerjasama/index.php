<?php

declare(strict_types=1);

$kerjasama = $kerjasama ?? [];
$summary = $summary ?? [];
$errorMessage = $errorMessage ?? null;

// Mengamankan output HTML.
$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

?>

<section class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Data Kerja Sama
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pengelolaan hubungan dan kerja sama
                KSR-PMI Unit UMM dengan instansi lain.
            </p>

        </div>

        <span class="rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
            Divisi Kerja Sama
        </span>

    </div>


    <!-- PESAN ERROR -->
    <?php if ($errorMessage !== null): ?>

        <div class="rounded-xl border border-red-200 bg-red-50 p-5">

            <h3 class="font-bold text-red-800">
                Gagal Memuat Data Kerja Sama
            </h3>

            <p class="mt-2 text-sm text-red-700">
                <?= $e($errorMessage) ?>
            </p>

            <p class="mt-2 text-xs text-red-600">
                Pastikan backend Express berjalan
                pada localhost:3000.
            </p>

        </div>

    <?php else: ?>


        <!-- STATISTIK -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Total Kerja Sama
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    <?= $e($summary['totalKerjasama'] ?? 0) ?>
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Kerja Sama Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    <?= $e($summary['aktif'] ?? 0) ?>
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Kerja Sama Nonaktif
                </p>

                <p class="mt-2 text-3xl font-bold text-orange-500">
                    <?= $e($summary['nonaktif'] ?? 0) ?>
                </p>

            </div>

        </div>


        <!-- DAFTAR KERJA SAMA -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 p-5">

                <h3 class="text-lg font-bold text-gray-900">
                    Daftar Mitra Kerja Sama
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Informasi instansi yang bekerja sama
                    dengan KSR-PMI Unit UMM.
                </p>

            </div>


            <?php if (empty($kerjasama)): ?>

                <div class="p-10 text-center">

                    <h3 class="font-semibold text-gray-700">
                        Belum Ada Data Kerja Sama
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Data kerja sama belum tersedia pada API.
                    </p>

                </div>

            <?php else: ?>

                <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                    <?php foreach ($kerjasama as $item): ?>

                        <article class="rounded-xl border border-gray-200 p-5 transition hover:border-red-200 hover:shadow-md">

                            <!-- NAMA INSTANSI -->
                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Mitra Kerja Sama
                                    </p>

                                    <h4 class="mt-2 text-lg font-bold text-gray-900">
                                        <?= $e($item->getNamaInstansi()) ?>
                                    </h4>

                                </div>

                                <?php
                                $status = strtolower(
                                    $item->getStatus()
                                );

                                $statusClass = $status === 'aktif'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-700';
                                ?>

                                <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold <?= $statusClass ?>">
                                    <?= $e($item->getStatus()) ?>
                                </span>

                            </div>


                            <!-- INFORMASI -->
                            <div class="mt-5 space-y-3 border-t border-gray-100 pt-4">

                                <div>

                                    <p class="text-xs text-gray-400">
                                        ID Kerja Sama
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        #<?= $e($item->getId()) ?>
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-400">
                                        Jenis Kerja Sama
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        <?= $e($item->getJenisKerjasama()) ?>
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-400">
                                        Tanggal Kerja Sama
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-700">

                                        <?php if ($item->getTanggal() !== ''): ?>

                                            <?= $e(
                                                date(
                                                    'd-m-Y',
                                                    strtotime($item->getTanggal())
                                                )
                                            ) ?>

                                        <?php else: ?>

                                            Belum ditentukan

                                        <?php endif; ?>

                                    </p>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</section>