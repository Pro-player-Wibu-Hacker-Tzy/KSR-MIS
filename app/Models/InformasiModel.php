<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';
require_once dirname(__DIR__, 2) . '/classes/Informasi.php';

class InformasiModel
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    /**
     * @return Informasi[]
     */
    public function getAll(): array
    {
        $response = $this->apiClient->get('/api/informasi');
        $records = $this->extractRecords($response);
        $items = [];

        foreach ($records as $record) {
            if (!is_array($record)) {
                throw new RuntimeException('Format data informasi dari API tidak valid.');
            }

            $items[] = new Informasi(
                $this->integerField($record, 'id'),
                $this->stringField($record, 'judul'),
                $this->stringField($record, 'isi'),
                $this->stringField($record, 'tanggal'),
                $this->stringField($record, 'kategori')
            );
        }

        return $items;
    }

    /**
     * @param Informasi[] $items
     * @return array{total: int, pelatihan: int, kegiatan: int}
     */
    public function getSummary(array $items): array
    {
        $summary = [
            'total' => count($items),
            'pelatihan' => 0,
            'kegiatan' => 0,
        ];

        foreach ($items as $item) {
            if (!$item instanceof Informasi) {
                throw new InvalidArgumentException('Ringkasan hanya menerima object Informasi.');
            }

            $kategori = mb_strtolower(trim($item->getKategori()), 'UTF-8');

            if ($kategori === 'pelatihan') {
                $summary['pelatihan']++;
            } elseif ($kategori === 'kegiatan') {
                $summary['kegiatan']++;
            }
        }

        return $summary;
    }

    private function extractRecords(array $response): array
    {
        if (array_is_list($response)) {
            return $response;
        }

        if (isset($response['data']) && is_array($response['data']) && array_is_list($response['data'])) {
            return $response['data'];
        }

        throw new RuntimeException('Format data informasi dari API tidak valid.');
    }

    private function integerField(array $record, string $field): int
    {
        if (!array_key_exists($field, $record) || filter_var($record[$field], FILTER_VALIDATE_INT) === false) {
            throw new RuntimeException("Field {$field} pada data informasi tidak valid.");
        }

        return (int) $record[$field];
    }

    private function stringField(array $record, string $field): string
    {
        if (!array_key_exists($field, $record) || !is_scalar($record[$field])) {
            throw new RuntimeException("Field {$field} pada data informasi tidak valid.");
        }

        return (string) $record[$field];
    }
}
