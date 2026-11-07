<?php
declare(strict_types=1);

require_once __DIR__ . '/app/Core/ApiClient.php';

require_once __DIR__
    . '/app/Controllers/ProgramPrioritasController.php';

require_once __DIR__
    . '/app/Controllers/GenericFeatureController.php';

$apiClient = new ApiClient();

$routes = [
    'program-prioritas' => [
        'title' => 'Program Prioritas',
        'endpoint' => null,
        'controllerFile' =>
            __DIR__ . '/app/Controllers/ProgramPrioritasController.php',
        'controllerClass' =>
            'ProgramPrioritasController',
    ],

    'inventaris' => [
        'title' => 'Inventaris',
        'endpoint' => '/api/inventaris',
        'controllerFile' =>
            __DIR__ . '/app/Controllers/InventarisController.php',
        'controllerClass' =>
            'InventarisController',
    ],

    'kerjasama' => [
        'title' => 'Kerja Sama',
        'endpoint' => '/api/kerjasama',
        'controllerFile' =>
            __DIR__ . '/app/Controllers/KerjasamaController.php',
        'controllerClass' =>
            'KerjasamaController',
    ],

    'info-lomba' => [
        'title' => 'Info Lomba',
        'endpoint' => '/api/info-lomba',
        'controllerFile' =>
            __DIR__ . '/app/Controllers/InfoLombaController.php',
        'controllerClass' =>
            'InfoLombaController',
    ],

    'informasi' => [
        'title' => 'Informasi',
        'endpoint' => '/api/informasi',
        'controllerFile' =>
            __DIR__ . '/app/Controllers/InformasiController.php',
        'controllerClass' =>
            'InformasiController',
    ],

    'report-posko' => [
        'title' => 'Report Posko',
        'endpoint' => '/api/report-posko',
        'controllerFile' =>
            __DIR__ . '/app/Controllers/ReportPoskoController.php',
        'controllerClass' =>
            'ReportPoskoController',
    ],
];

$page = (
    isset($_GET['page'])
    && is_string($_GET['page'])
)
    ? trim($_GET['page'])
    : 'program-prioritas';

/*
|--------------------------------------------------------------------------
| 1. Periksa route
|--------------------------------------------------------------------------
*/

if (!isset($routes[$page])) {
    http_response_code(404);

    $pageTitle = '404 | KSR-MIS';
    $activePage = '';

    require __DIR__ . '/app/Views/layouts/header.php';
    ?>

    <section class="rounded-xl bg-white p-8 shadow-sm">
        <h2 class="text-2xl font-bold">
            404 - Halaman tidak ditemukan
        </h2>

        <p class="mt-2 text-gray-600">
            Route yang diminta tidak tersedia.
        </p>

        <a class="mt-4 inline-block text-red-700 underline"
           href="index.php">
            Kembali ke Beranda
        </a>
    </section>

    <?php
    require __DIR__ . '/app/Views/layouts/footer.php';
    exit;
}

$route = $routes[$page];

/*
|--------------------------------------------------------------------------
| 2. Jalankan Controller
|--------------------------------------------------------------------------
*/

try {
    // Route Program Prioritas milik Programmer 1.
    if ($page === 'program-prioritas') {
        $controller = new ProgramPrioritasController($apiClient);
        $controller->index();
        exit;
    }

    /*
     * Kalau controller khusus kontributor sudah tersedia,
     * gunakan controller tersebut terlebih dahulu.
     */
    if (is_file($route['controllerFile'])) {
        require_once $route['controllerFile'];

        $controllerClass = $route['controllerClass'];

        if (
            class_exists($controllerClass)
            && is_callable([$controllerClass, 'index'])
        ) {
            $controller = new $controllerClass($apiClient);
            $controller->index();
            exit;
        }
    }

    /*
     * Kalau belum tersedia, gunakan controller fallback.
     */
    $controller = new GenericFeatureController(
        $apiClient,
        $route['endpoint'],
        $route['title'],
        $page
    );

    $controller->index();

} catch (Throwable $exception) {
    http_response_code(500);

    $pageTitle = 'Terjadi Kesalahan | KSR-MIS';
    $activePage = $page;
    $errorMessage = $exception->getMessage();

    require __DIR__ . '/app/Views/layouts/header.php';
    ?>

    <section class="rounded-xl border border-red-200 bg-red-50 p-6 text-red-800">
        <h2 class="text-xl font-bold">
            Halaman gagal diproses
        </h2>

        <p class="mt-2">
            <?= htmlspecialchars(
                $errorMessage,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>
    </section>

    <?php
    require __DIR__ . '/app/Views/layouts/footer.php';
}