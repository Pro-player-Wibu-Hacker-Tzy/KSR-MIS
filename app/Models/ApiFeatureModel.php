<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';

class ApiFeatureModel
{
    public function __construct(
        private ApiClient $apiClient
    ) {
    }

    public function getAll(string $endpoint): array
    {
        $data = $this->apiClient->get($endpoint);

        if (!array_is_list($data)) {
            return [$data];
        }

        return $data;
    }
}