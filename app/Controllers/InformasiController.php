<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/InformasiModel.php';

class InformasiController extends Controller
{
    public function index(): void
    {
        try {
            $model = new InformasiModel($this->apiClient);
            $informasi = $model->getAll();
            $summary = $model->getSummary($informasi);
            $errorMessage = null;
        } catch (Throwable $exception) {
            $informasi = [];
            $summary = [
                'total' => 0,
                'pelatihan' => 0,
                'kegiatan' => 0,
            ];
            $errorMessage = $exception->getMessage();
        }

        $this->render(
            'informasi/index',
            [
                'pageTitle' => 'Informasi | KSR-MIS',
                'activePage' => 'informasi',
                'informasi' => $informasi,
                'summary' => $summary,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}
