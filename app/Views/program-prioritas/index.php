<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| DEFAULT DATA
|--------------------------------------------------------------------------
| Mencegah Undefined variable pada Intelephense.
| Data asli dari Controller tetap digunakan jika tersedia.
*/

if (!isset($summary) || !is_array($summary)) {
    $summary = [];
}

$summary = array_merge(
    [
        'totalProgram' => 0,
        'totalBerlangsung' => 0,
        'totalSelesai' => 0,
        'totalAkanDatang' => 0,
    ],
    $summary
);

if (
    !isset($programPrioritas)
    || !is_array($programPrioritas)
) {
    $programPrioritas = [];
}

/*
|--------------------------------------------------------------------------
| HTML ESCAPE
|--------------------------------------------------------------------------
*/

$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

/*
|--------------------------------------------------------------------------
| FORMAT TANGGAL
|--------------------------------------------------------------------------
*/

$formatDate = static function (string $date): string {
    if ($date === '') {
        return '-';
    }

    $timestamp = strtotime($date);

    if ($timestamp === false) {
        return $date;
    }

    $months = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    return date('j', $timestamp)
        . ' '
        . $months[(int) date('n', $timestamp)]
        . ' '
        . date('Y', $timestamp);
};

/*
|--------------------------------------------------------------------------
| STATUS STYLES
|--------------------------------------------------------------------------
*/

$statusClasses = [
    'Akan Datang' => 'bg-orange-100 text-orange-700',
    'Berlangsung' => 'bg-blue-100 text-blue-700',
    'Selesai' => 'bg-green-100 text-green-700',
];

?>

<!-- JUDUL HALAMAN -->
<section class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
        Program Prioritas Organisasi
    </h2>

    <p class="mt-2 text-gray-600">
        Daftar agenda dan program kerja unggulan
        KSR-PMI Unit UMM.
    </p>
</section>

<!-- RINGKASAN PROGRAM -->
<section
    class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
>
    <?php
    $summaryCards = [
        [
            'label' => 'Total Program',
            'value' => $summary['totalProgram'],
            'color' => 'text-gray-900',
        ],
        [
            'label' => 'Berlangsung',
            'value' => $summary['totalBerlangsung'],
            'color' => 'text-blue-600',
        ],
        [
            'label' => 'Selesai',
            'value' => $summary['totalSelesai'],
            'color' => 'text-green-600',
        ],
        [
            'label' => 'Akan Datang',
            'value' => $summary['totalAkanDatang'],
            'color' => 'text-orange-500',
        ],
    ];
    ?>

    <?php foreach ($summaryCards as $card): ?>
        <article
            class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200"
        >
            <p class="text-sm font-medium text-gray-500">
                <?= $e($card['label']) ?>
            </p>

            <strong
                class="mt-2 block text-3xl font-bold <?= $e($card['color']) ?>"
            >
                <?= $e($card['value']) ?>
            </strong>
        </article>
    <?php endforeach; ?>
</section>

<!-- KARTU PROGRAM -->
<section class="mb-12">
    <h2 class="mb-2 text-xl font-bold text-gray-900">
        Kartu Program Prioritas
    </h2>

    <p class="mb-6 text-sm text-gray-600">
        Informasi program dan progres pelaksanaan.
    </p>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

        <?php foreach ($programPrioritas as $index => $program): ?>

            <?php
            $progress = max(
                0,
                min(100, (int) $program->progress)
            );

            $statusClass = $statusClasses[$program->status]
                ?? 'bg-gray-100 text-gray-700';
            ?>

            <article
                class="flex flex-col justify-between rounded-xl
                bg-white p-6 shadow-sm ring-1 ring-gray-200
                transition hover:-translate-y-0.5 hover:shadow-md"
            >
                <div>
                    <div class="mb-3 flex items-start justify-between gap-2">

                        <span
                            class="rounded-md bg-red-50 px-2.5 py-1
                            text-xs font-bold text-red-700"
                        >
                            #<?= $e($index + 1) ?>
                        </span>

                        <span
                            class="inline-flex rounded-full px-2.5 py-1
                            text-xs font-semibold <?= $e($statusClass) ?>"
                        >
                            <?= $e($program->status) ?>
                        </span>

                    </div>

                    <span
                        class="mb-1 block text-xs font-medium
                        uppercase tracking-wider text-gray-500"
                    >
                        <?= $e($program->kategori) ?>
                    </span>

                    <h3 class="mb-2 text-lg font-bold text-gray-900">
                        <?= $e($program->namaProgram) ?>
                    </h3>

                    <p class="mb-4 text-sm text-gray-600">
                        <?= $e($program->deskripsi) ?>
                    </p>
                </div>

                <div>
                    <div
                        class="mb-1 flex justify-between
                        text-xs font-semibold text-gray-600"
                    >
                        <span>Progres</span>
                        <span><?= $e($progress) ?>%</span>
                    </div>

                    <div
                        class="mb-4 h-2 w-full overflow-hidden
                        rounded-full bg-gray-200"
                    >
                        <div
                            class="h-2 rounded-full bg-red-600"
                            style="width: <?= $e($progress) ?>%"
                        ></div>
                    </div>

                    <div
                        class="space-y-1 border-t border-gray-100
                        pt-3 text-xs text-gray-500"
                    >
                        <p>
                            <strong class="text-gray-700">PJ:</strong>
                            <?= $e($program->penanggungJawab) ?>
                        </p>

                        <p>
                            <strong class="text-gray-700">Target:</strong>
                            <?= $e(
                                $formatDate($program->targetSelesai)
                            ) ?>
                        </p>
                    </div>
                </div>
            </article>

        <?php endforeach; ?>

        <?php if (count($programPrioritas) === 0): ?>
            <p class="col-span-full rounded-xl bg-white p-6 text-gray-600">
                Belum ada data Program Prioritas.
            </p>
        <?php endif; ?>

    </div>
</section>

<!-- TABEL PROGRAM -->
<section>
    <h2 class="mb-2 text-xl font-bold text-gray-900">
        Ringkasan Tabel Program
    </h2>

    <p class="mb-4 text-sm text-gray-600">
        Daftar program, penanggung jawab, dan target penyelesaian.
    </p>

    <article
        class="overflow-hidden rounded-xl bg-white
        shadow-sm ring-1 ring-gray-200"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">

                <thead
                    class="bg-gray-50 text-xs font-semibold
                    uppercase text-gray-500"
                >
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

                        <?php
                        $statusClass = $statusClasses[$program->status]
                            ?? 'bg-gray-100 text-gray-700';
                        ?>

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-4 py-3 text-gray-600">
                                <?= $e($index + 1) ?>
                            </td>

                            <td class="px-4 py-3 font-semibold text-gray-900">
                                <?= $e($program->namaProgram) ?>
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                <?= $e($program->kategori) ?>
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                <?= $e($program->penanggungJawab) ?>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-gray-600">
                                <?= $e(
                                    $formatDate($program->targetSelesai)
                                ) ?>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 font-medium">
                                <?= $e($program->progress) ?>%
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">
                                <span
                                    class="inline-flex rounded-full
                                    px-2.5 py-1 text-xs font-semibold
                                    <?= $e($statusClass) ?>"
                                >
                                    <?= $e($program->status) ?>
                                </span>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    <?php if (count($programPrioritas) === 0): ?>
                        <tr>
                            <td
                                colspan="7"
                                class="px-4 py-6 text-center text-gray-500"
                            >
                                Belum ada data Program Prioritas.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </article>
</section>