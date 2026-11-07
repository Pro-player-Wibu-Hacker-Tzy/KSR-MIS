<?php
declare(strict_types=1);

require_once __DIR__ . '/ApiClient.php';

abstract class Controller
{
    protected ApiClient $apiClient;

    public function __construct(
        ?ApiClient $apiClient = null
    ) {
        $this->apiClient = $apiClient ?? new ApiClient();
    }

    protected function render(
        string $view,
        array $data = []
    ): void {
        $view = trim($view, '/');

        if ($view === '' || str_contains($view, '..')) {
            throw new InvalidArgumentException(
                'Nama View tidak valid.'
            );
        }

        $viewPath = dirname(__DIR__)
            . '/Views/'
            . $view
            . '.php';

        if (!is_file($viewPath)) {
            throw new RuntimeException(
                'View tidak ditemukan: ' . $view
            );
        }

        extract($data, EXTR_SKIP);

        $pageTitle = $pageTitle ?? 'KSR-MIS';
        $activePage = $activePage ?? '';

        $contentView = $viewPath;

        require dirname(__DIR__)
            . '/Views/layouts/header.php';

        require $contentView;

        require dirname(__DIR__)
            . '/Views/layouts/footer.php';
    }
}