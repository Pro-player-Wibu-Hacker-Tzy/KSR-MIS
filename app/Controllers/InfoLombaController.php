<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/InfoLombaModel.php';

class InfoLombaController extends Controller
{
    public function index(): void
    {
        try {
            $model = new InfoLombaModel($this->apiClient);
            $infoLomba = $model->getAll();
            $summary = $model->getSummary($infoLomba);
            $errorMessage = null;
        } catch (Throwable $exception) {
            $infoLomba = [];
            $summary = [
                'total' => 0,
                'akanDatang' => 0,
                'selesai' => 0,
            ];
            $errorMessage = $exception->getMessage();
        }

        $this->render(
            'info-lomba/index',
            [
                'pageTitle' => 'Info Lomba | KSR-MIS',
                'activePage' => 'info-lomba',
                'infoLomba' => $infoLomba,
                'summary' => $summary,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}
