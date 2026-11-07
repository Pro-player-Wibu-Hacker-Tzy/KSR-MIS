<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/Controller.php';
require_once dirname(__DIR__) . '/Models/ApiFeatureModel.php';

class GenericFeatureController extends Controller
{
    public function __construct(
        ApiClient $apiClient,
        private string $endpoint,
        private string $featureTitle,
        private string $activeRoute
    ) {
        parent::__construct($apiClient);
    }

    public function index(): void
    {
        try {
            $model = new ApiFeatureModel($this->apiClient);

            $records = $model->getAll($this->endpoint);

            $errorMessage = null;
        } catch (Throwable $exception) {
            $records = [];

            $errorMessage = $exception->getMessage();
        }

        $this->render(
            'shared/api-list',
            [
                'pageTitle' => $this->featureTitle . ' | KSR-MIS',
                'activePage' => $this->activeRoute,
                'featureTitle' => $this->featureTitle,
                'endpoint' => $this->endpoint,
                'records' => $records,
                'errorMessage' => $errorMessage,
            ]
        );
    }
}