<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/ProgramPrioritasModel.php';

class ProgramPrioritasController extends Controller
{
    public function index(): void
    {
        $model = new ProgramPrioritasModel();

        $programPrioritas = $model->getAll();

        $summary = $model->getSummary();

        $this->render(
            'program-prioritas/index',
            [
                'pageTitle' => 'Program Prioritas | KSR-MIS',
                'activePage' => 'program-prioritas',
                'programPrioritas' => $programPrioritas,
                'summary' => $summary,
            ]
        );
    }
}