<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? 'KSR-MIS';
$activePage = $activePage ?? '';

$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

$navItems = [
    ['label' => 'Beranda', 'url' => 'index.php', 'key' => 'home'],
    ['label' => 'Inventaris', 'url' => 'mvc.php?page=inventaris', 'key' => 'inventaris'],
    ['label' => 'Kerja Sama', 'url' => 'mvc.php?page=kerjasama', 'key' => 'kerjasama'],
    ['label' => 'Info Lomba', 'url' => 'mvc.php?page=info-lomba', 'key' => 'info-lomba'],
    ['label' => 'Informasi', 'url' => 'mvc.php?page=informasi', 'key' => 'informasi'],
    ['label' => 'Report Posko', 'url' => 'mvc.php?page=report-posko', 'key' => 'report-posko'],
    ['label' => 'Program Prioritas', 'url' => 'mvc.php?page=program-prioritas', 'key' => 'program-prioritas'],
    ['label' => 'Demo OOP', 'url' => 'oop-demo.php', 'key' => 'oop-demo'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $e($pageTitle) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 font-sans text-gray-800">

<header class="bg-red-700 px-4 py-6 text-center text-white">
    <h1 class="text-3xl font-bold">KSR-MIS</h1>
    <p class="mt-1 text-sm text-red-100 sm:text-base">
        KSR-PMI Unit UMM Management Information System
    </p>
</header>

<nav class="bg-red-800 shadow-md" aria-label="Navigasi utama">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap justify-center gap-1 py-2 sm:gap-3">
            <?php foreach ($navItems as $item): ?>
                <li>
                    <a
                        href="<?= $e($item['url']) ?>"
                        class="block rounded-lg px-3 py-2 text-sm font-medium
                        <?= $activePage === $item['key']
                            ? 'bg-white text-red-700'
                            : 'text-white transition hover:bg-red-700' ?>"
                    >
                        <?= $e($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"></main>