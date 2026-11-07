<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/InventarisModel.php';

class InventarisController extends Controller
{
    public function index(): void
    {
        try {
            // Membuat Model menggunakan ApiClient
            // dari Base Controller.
            $model = new InventarisModel($this->apiClient);

            // Mengambil data inventaris.
            $inventaris = $model->getAll();

            // Mengambil ringkasan data.
            $summary = $model->getSummary();

            $errorMessage = null;

        } catch (Throwable $exception) {

            $inventaris = [];

            $summary = [
                'totalJenis' => 0,
                'totalUnit' => 0,
                'tersedia' => 0,
                'dipinjam' => 0,
            ];

            $errorMessage = $exception->getMessage();
        }

        // Mengirim data ke View.
        $this->render(
            'inventaris/index',
            [
                'pageTitle' => 'Inventaris | KSR-MIS',
                'activePage' => 'inventaris',
                'inventaris' => $inventaris,
                'summary' => $summary,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}