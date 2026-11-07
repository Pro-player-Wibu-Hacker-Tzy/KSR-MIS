<?php

declare(strict_types=1);

$inventaris = $inventaris ?? [];
$summary = $summary ?? [];
$errorMessage = $errorMessage ?? null;

// Fungsi untuk mengamankan output HTML.
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
                Data Inventaris
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pengelolaan perlengkapan dan inventaris
                KSR-PMI Unit UMM.
            </p>
        </div>

        <span class="rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
            Divisi Inventaris
        </span>

    </div>


    <!-- PESAN ERROR API -->
    <?php if ($errorMessage !== null): ?>

        <div class="rounded-xl border border-red-200 bg-red-50 p-5">

            <h3 class="font-bold text-red-800">
                Gagal Memuat Data Inventaris
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
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total Jenis Barang
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    <?= $e($summary['totalJenis'] ?? 0) ?>
                </p>
            </div>


            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total Unit Barang
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600">
                    <?= $e($summary['totalUnit'] ?? 0) ?>
                </p>
            </div>


            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Barang Tersedia
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    <?= $e($summary['tersedia'] ?? 0) ?>
                </p>
            </div>


            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Barang Dipinjam
                </p>

                <p class="mt-2 text-3xl font-bold text-orange-500">
                    <?= $e($summary['dipinjam'] ?? 0) ?>
                </p>
            </div>

        </div>


        <!-- TABEL INVENTARIS -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 p-5">

                <h3 class="text-lg font-bold text-gray-900">
                    Daftar Inventaris
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Data diambil langsung dari backend KSR-MIS.
                </p>

            </div>


            <?php if (empty($inventaris)): ?>

                <div class="p-10 text-center">

                    <h3 class="font-semibold text-gray-700">
                        Belum Ada Data Inventaris
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Data inventaris belum tersedia pada API.
                    </p>

                </div>

            <?php else: ?>

                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">

                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Nama Barang</th>
                                <th class="px-6 py-4">Jumlah</th>
                                <th class="px-6 py-4">Kondisi</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            <?php foreach ($inventaris as $item): ?>

                                <tr class="transition hover:bg-gray-50">

                                    <td class="px-6 py-4 font-medium text-gray-700">
                                        <?= $e($item->getId()) ?>
                                    </td>


                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $e($item->getNama()) ?>
                                    </td>


                                    <td class="px-6 py-4 text-gray-600">
                                        <?= $e($item->getJumlah()) ?> unit
                                    </td>


                                    <td class="px-6 py-4 text-gray-600">
                                        <?= $e($item->getKondisi()) ?>
                                    </td>


                                    <td class="px-6 py-4">

                                        <?php
                                        $status = strtolower(
                                            $item->getStatus()
                                        );

                                        $statusClass = $status === 'tersedia'
                                            ? 'bg-green-100 text-green-700'
                                            : (
                                                $status === 'dipinjam'
                                                    ? 'bg-orange-100 text-orange-700'
                                                    : 'bg-gray-100 text-gray-700'
                                            );
                                        ?>

                                        <span class="rounded-full px-3 py-1 text-xs font-semibold <?= $statusClass ?>">
                                            <?= $e($item->getStatus()) ?>
                                        </span>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</section>