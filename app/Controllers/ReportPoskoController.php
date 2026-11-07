<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/ReportPoskoModel.php';

class ReportPoskoController extends Controller
{
    public function index(): void
    {
        try {
            $model = new ReportPoskoModel($this->apiClient);
            $reportPosko = $model->getAll();
            $summary = $model->getSummary($reportPosko);
            $errorMessage = null;
        } catch (Throwable $exception) {
            $reportPosko = [];
            $summary = [
                'total' => 0,
                'aman' => 0,
                'perluPerhatian' => 0,
                'darurat' => 0,
            ];
            $errorMessage = $exception->getMessage();
        }

        $this->render(
            'report-posko/index',
            [
                'pageTitle' => 'Report Posko | KSR-MIS',
                'activePage' => 'report-posko',
                'reportPosko' => $reportPosko,
                'summary' => $summary,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}
