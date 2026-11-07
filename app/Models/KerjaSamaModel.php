<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';
require_once dirname(__DIR__, 2) . '/classes/Kerjasama.php';

class KerjaSamaModel
{
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Mengambil seluruh data kerja sama dari API.
     *
     * @return KerjaSama[]
     */
    public function getAll(): array
    {
        $response = $this->apiClient->get('/api/kerjasama');

        // Mendukung array langsung maupun
        // respons dengan pembungkus data.
        if (!array_is_list($response)) {
            if (
                isset($response['data'])
                && is_array($response['data'])
            ) {
                $response = $response['data'];
            } else {
                throw new RuntimeException(
                    'Format data kerja sama dari API tidak valid.'
                );
            }
        }

        $kerjasama = [];

        foreach ($response as $item) {
            if (!is_array($item)) {
                continue;
            }

            $kerjasama[] = new KerjaSama(
                (int) ($item['id'] ?? 0),
                (string) ($item['namaInstansi'] ?? ''),
                (string) ($item['jenisKerjasama'] ?? ''),
                (string) ($item['tanggal'] ?? ''),
                (string) ($item['status'] ?? '')
            );
        }

        return $kerjasama;
    }

    /**
     * Menghitung ringkasan kerja sama.
     */
    public function getSummary(): array
    {
        $items = $this->getAll();

        $summary = [
            'totalKerjasama' => count($items),
            'aktif' => 0,
            'nonaktif' => 0,
        ];

        foreach ($items as $item) {
            $status = strtolower($item->getStatus());

            if ($status === 'aktif') {
                $summary['aktif']++;
            } else {
                $summary['nonaktif']++;
            }
        }

        return $summary;
    }
}