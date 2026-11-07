<?php

declare(strict_types=1);

$informasi = $informasi ?? [];
$summary = $summary ?? [];
$errorMessage = $errorMessage ?? null;

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

?>

<section class="space-y-6">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Informasi</h2>
            <p class="mt-1 text-sm text-gray-500">
                Informasi dan pengumuman KSR-PMI Unit UMM.
            </p>
        </div>
        <span class="rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
            Informasi KSR
        </span>
    </div>

    <?php if ($errorMessage !== null): ?>
        <div class="rounded-xl border border-red-200 bg-red-50 p-5">
            <h3 class="font-bold text-red-800">Gagal Memuat Informasi</h3>
            <p class="mt-2 text-sm text-red-700"><?= $e($errorMessage) ?></p>
            <p class="mt-2 text-xs text-red-600">
                Pastikan backend Express berjalan pada localhost:3000.
            </p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Informasi</p>
                <p class="mt-2 text-3xl font-bold text-gray-900"><?= $e($summary['total'] ?? 0) ?></p>
            </article>
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Kategori Pelatihan</p>
                <p class="mt-2 text-3xl font-bold text-blue-600"><?= $e($summary['pelatihan'] ?? 0) ?></p>
            </article>
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Kategori Kegiatan</p>
                <p class="mt-2 text-3xl font-bold text-green-600"><?= $e($summary['kegiatan'] ?? 0) ?></p>
            </article>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 p-5">
                <h3 class="text-lg font-bold text-gray-900">Daftar Informasi</h3>
                <p class="mt-1 text-sm text-gray-500">Data diambil langsung dari backend KSR-MIS.</p>
            </div>

            <?php if ($informasi === []): ?>
                <div class="p-10 text-center">
                    <h3 class="font-semibold text-gray-700">Belum Ada Informasi</h3>
                    <p class="mt-2 text-sm text-gray-500">Informasi belum tersedia pada API.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($informasi as $item): ?>
                        <article class="rounded-xl border border-gray-200 p-5 transition hover:border-red-200 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3">
                                <h4 class="text-lg font-bold text-gray-900">
                                    <?= $e($item->getJudul()) ?>
                                </h4>
                                <span class="shrink-0 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                    <?= $e($item->getKategori()) ?>
                                </span>
                            </div>
                            <p class="mt-3 text-xs text-gray-400">
                                ID #<?= $e($item->getId()) ?>
                                <span class="px-1">·</span>
                                <?= $item->getTanggal() !== '' ? $e($item->getTanggal()) : 'Tanggal belum ditentukan' ?>
                            </p>
                            <p class="mt-4 whitespace-pre-line border-t border-gray-100 pt-4 text-sm leading-6 text-gray-600"><?= $e($item->getIsi()) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
