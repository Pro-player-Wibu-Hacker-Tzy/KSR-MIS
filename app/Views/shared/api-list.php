<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| DEFAULT DATA
|--------------------------------------------------------------------------
*/

if (!isset($featureTitle) || !is_string($featureTitle)) {
    $featureTitle = 'Fitur KSR-MIS';
}

if (!isset($endpoint) || !is_string($endpoint)) {
    $endpoint = '';
}

if (!isset($records) || !is_array($records)) {
    $records = [];
}

if (
    !isset($errorMessage)
    || !is_string($errorMessage)
) {
    $errorMessage = null;
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

?>

<!-- JUDUL HALAMAN -->
<section class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
        <?= $e($featureTitle) ?>
    </h2>

    <p class="mt-2 text-gray-600">
        Data fitur dari backend Express KSR-MIS.
    </p>

    <p class="mt-1 text-sm text-gray-500">
        Endpoint:
        <code><?= $e($endpoint) ?></code>
    </p>
</section>

<!-- PESAN ERROR API -->
<?php if ($errorMessage !== null): ?>

    <section
        class="rounded-xl border border-red-200 bg-red-50
        p-5 text-red-800"
    >
        <h3 class="font-bold">
            API belum dapat diakses
        </h3>

        <p class="mt-2 text-sm">
            <?= $e($errorMessage) ?>
        </p>

        <p class="mt-2 text-sm">
            Pastikan backend Express berjalan, kemudian
            muat ulang halaman.
        </p>
    </section>

<!-- DATA KOSONG -->
<?php elseif (count($records) === 0): ?>

    <section
        class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200"
    >
        Belum ada data pada endpoint ini.
    </section>

<!-- DATA TERSEDIA -->
<?php else: ?>

    <?php
    $firstRecord = (array) $records[0];
    $columns = array_keys($firstRecord);
    ?>

    <section
        class="overflow-hidden rounded-xl bg-white
        shadow-sm ring-1 ring-gray-200"
    >
        <div class="overflow-x-auto">

            <table
                class="min-w-full divide-y divide-gray-200 text-left text-sm"
            >

                <thead
                    class="bg-gray-50 text-xs font-semibold
                    uppercase text-gray-500"
                >
                    <tr>
                        <?php foreach ($columns as $column): ?>

                            <th class="px-4 py-3">
                                <?= $e($column) ?>
                            </th>

                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    <?php foreach ($records as $record): ?>

                        <?php $record = (array) $record; ?>

                        <tr class="transition hover:bg-gray-50">

                            <?php foreach ($columns as $column): ?>

                                <?php
                                $value = $record[$column] ?? '';

                                if (is_array($value) || is_object($value)) {
                                    $value = json_encode(
                                        $value,
                                        JSON_UNESCAPED_UNICODE
                                        | JSON_UNESCAPED_SLASHES
                                        | JSON_INVALID_UTF8_SUBSTITUTE
                                    );

                                    if ($value === false) {
                                        $value = '';
                                    }
                                }
                                ?>

                                <td
                                    class="max-w-sm px-4 py-3
                                    align-top text-gray-700"
                                >
                                    <?= $e($value) ?>
                                </td>

                            <?php endforeach; ?>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </section>

<?php endif; ?>

<!-- KETERANGAN FALLBACK -->
<div
    class="mt-6 rounded-lg border border-amber-200
    bg-amber-50 p-4 text-sm text-amber-900"
>
    Ini adalah tampilan fallback sementara.
    Controller, Model, dan View khusus dari kontributor
    akan menggantikan tampilan ini setelah integrasi.
</div>