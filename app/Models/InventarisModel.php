<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';
require_once dirname(__DIR__, 2) . '/classes/Inventaris.php';

class InventarisModel
{
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Mengambil seluruh data inventaris dari API.
     *
     * @return Inventaris[]
     */
    public function getAll(): array
    {
        $response = $this->apiClient->get('/api/inventaris');

        // Mendukung respons array langsung maupun
        // respons dengan pembungkus data.
        if (!array_is_list($response)) {
            if (
                isset($response['data'])
                && is_array($response['data'])
            ) {
                $response = $response['data'];
            } else {
                throw new RuntimeException(
                    'Format data inventaris dari API tidak valid.'
                );
            }
        }

        $inventaris = [];

        foreach ($response as $item) {
            if (!is_array($item)) {
                continue;
            }

            $inventaris[] = new Inventaris(
                (int) ($item['id'] ?? 0),
                (string) ($item['nama'] ?? ''),
                (int) ($item['jumlah'] ?? 0),
                (string) ($item['kondisi'] ?? ''),
                (string) ($item['status'] ?? '')
            );
        }

        return $inventaris;
    }

    /**
     * Menghitung ringkasan inventaris.
     */
    public function getSummary(): array
    {
        $items = $this->getAll();

        $summary = [
            'totalJenis' => count($items),
            'totalUnit' => 0,
            'tersedia' => 0,
            'dipinjam' => 0,
        ];

        foreach ($items as $item) {
            $summary['totalUnit'] += $item->getJumlah();

            $status = strtolower($item->getStatus());

            if ($status === 'tersedia') {
                $summary['tersedia']++;
            } elseif ($status === 'dipinjam') {
                $summary['dipinjam']++;
            }
        }

        return $summary;
    }
}