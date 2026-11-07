<?php

require_once __DIR__ . '/../classes/Inventaris.php';
require_once __DIR__ . '/../classes/KerjaSama.php';
require_once __DIR__ . '/../classes/InfoLomba.php';

// TEST INVENTARIS
echo "=== TEST INVENTARIS ===\n";

$inventaris = new Inventaris(
    1,
    "Kotak P3K",
    10,
    "Baik",
    "Tersedia"
);

echo $inventaris->getInformasi() . "\n";
echo "Nama: " . $inventaris->getNama() . "\n";
echo "HTML berhasil dibuat: " .
    (str_contains($inventaris->render(), '<article') ? 'YA' : 'TIDAK') . "\n\n";


// TEST KERJASAMA
echo "=== TEST KERJASAMA ===\n";

$kerjasama = new KerjaSama(
    2,
    "PMI Kota Malang",
    "Pelatihan",
    "2026-11-07",
    "Aktif"
);

echo $kerjasama->getInformasi() . "\n";
echo "Instansi: " . $kerjasama->getNamaInstansi() . "\n";
echo "HTML berhasil dibuat: " .
    (str_contains($kerjasama->render(), '<article') ? 'YA' : 'TIDAK') . "\n\n";


// TEST INFO LOMBA
echo "=== TEST INFO LOMBA ===\n";

$lomba = new InfoLomba(
    3,
    "Lomba Pertolongan Pertama",
    "PMI",
    "2026-12-01",
    "Malang",
    "Akan Datang"
);

echo $lomba->getInformasi() . "\n";
echo "Nama Lomba: " . $lomba->getNamaLomba() . "\n";
echo "HTML berhasil dibuat: " .
    (str_contains($lomba->render(), '<article') ? 'YA' : 'TIDAK') . "\n\n";

echo "=== SEMUA TEST SELESAI ===\n";

?>