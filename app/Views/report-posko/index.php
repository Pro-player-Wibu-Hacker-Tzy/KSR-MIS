<?php

declare(strict_types=1);

$reportPosko = $reportPosko ?? [];
$summary = $summary ?? [];
$errorMessage = $errorMessage ?? null;

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

?>

<section class="space-y-6">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Report Posko</h2>
            <p class="mt-1 text-sm text-gray-500">
                Laporan kondisi posko KSR-PMI Unit UMM.
            </p>
        </div>
        <span class="rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
            Laporan Posko
        </span>
    </div>

    <?php if ($errorMessage !== null): ?>
        <div class="rounded-xl border border-red-200 bg-red-50 p-5">
            <h3 class="font-bold text-red-800">Gagal Memuat Report Posko</h3>
            <p class="mt-2 text-sm text-red-700"><?= $e($errorMessage) ?></p>
            <p class="mt-2 text-xs text-red-600">
                Pastikan backend Express berjalan pada localhost:3000.
            </p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Posko</p>
                <p class="mt-2 text-3xl font-bold text-gray-900"><?= $e($summary['total'] ?? 0) ?></p>
            </article>
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Kondisi Aman</p>
                <p class="mt-2 text-3xl font-bold text-green-600"><?= $e($summary['aman'] ?? 0) ?></p>
            </article>
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Perlu Perhatian</p>
                <p class="mt-2 text-3xl font-bold text-yellow-600"><?= $e($summary['perluPerhatian'] ?? 0) ?></p>
            </article>
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Darurat</p>
                <p class="mt-2 text-3xl font-bold text-red-600"><?= $e($summary['darurat'] ?? 0) ?></p>
            </article>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 p-5">
                <h3 class="text-lg font-bold text-gray-900">Daftar Report Posko</h3>
                <p class="mt-1 text-sm text-gray-500">Data diambil langsung dari backend KSR-MIS.</p>
            </div>

            <?php if ($reportPosko === []): ?>
                <div class="p-10 text-center">
                    <h3 class="font-semibold text-gray-700">Belum Ada Report Posko</h3>
                    <p class="mt-2 text-sm text-gray-500">Laporan posko belum tersedia pada API.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">
                    <?php foreach ($reportPosko as $item): ?>
                        <?php
                        $kondisi = mb_strtolower(trim($item->getKondisi()), 'UTF-8');
                        $kondisiClass = match ($kondisi) {
                            'aman' => 'bg-green-100 text-green-700',
                            'perlu perhatian' => 'bg-yellow-100 text-yellow-700',
                            'darurat' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                        ?>
                        <article class="rounded-xl border border-gray-200 p-5 transition hover:border-red-200 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Nama Posko
                                    </p>
                                    <h4 class="mt-2 text-lg font-bold text-gray-900">
                                        <?= $e($item->getNamaPosko()) ?>
                                    </h4>
                                </div>
                                <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold <?= $kondisiClass ?>">
                                    <?= $e($item->getKondisi()) ?>
                                </span>
                            </div>
                            <dl class="mt-5 space-y-3 border-t border-gray-100 pt-4 text-sm">
                                <div>
                                    <dt class="text-xs text-gray-400">Lokasi</dt>
                                    <dd class="mt-1 font-medium text-gray-700"><?= $e($item->getLokasi()) ?></dd>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <dt class="text-xs text-gray-400">Tanggal</dt>
                                        <dd class="mt-1 font-medium text-gray-700">
                                            <?= $item->getTanggal() !== '' ? $e($item->getTanggal()) : 'Belum ditentukan' ?>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-400">Jumlah Petugas</dt>
                                        <dd class="mt-1 font-medium text-gray-700"><?= $e($item->getJumlahPetugas()) ?> orang</dd>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-400">Status Kondisi</dt>
                                    <dd class="mt-1 font-medium text-gray-700"><?= $e($item->getStatusKondisi()) ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-400">Keterangan</dt>
                                    <dd class="mt-1 whitespace-pre-line text-gray-700"><?= $e($item->getKeterangan()) ?></dd>
                                </div>
                            </dl>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
