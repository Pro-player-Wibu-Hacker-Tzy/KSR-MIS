<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/KerjaSamaModel.php';

class KerjasamaController extends Controller
{
    public function index(): void
    {
        try {
            // Membuat Model menggunakan ApiClient.
            $model = new KerjaSamaModel($this->apiClient);

            // Mengambil data kerja sama.
            $kerjasama = $model->getAll();

            // Mengambil ringkasan data.
            $summary = $model->getSummary();

            $errorMessage = null;

        } catch (Throwable $exception) {

            $kerjasama = [];

            $summary = [
                'totalKerjasama' => 0,
                'aktif' => 0,
                'nonaktif' => 0,
            ];

            $errorMessage = $exception->getMessage();
        }

        // Mengirim data ke View.
        $this->render(
            'kerjasama/index',
            [
                'pageTitle' => 'Kerja Sama | KSR-MIS',
                'activePage' => 'kerjasama',
                'kerjasama' => $kerjasama,
                'summary' => $summary,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}