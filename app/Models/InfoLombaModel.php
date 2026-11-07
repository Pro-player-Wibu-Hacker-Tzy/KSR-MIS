<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';
require_once dirname(__DIR__, 2) . '/classes/InfoLomba.php';

class InfoLombaModel
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    /**
     * @return InfoLomba[]
     */
    public function getAll(): array
    {
        $response = $this->apiClient->get('/api/info-lomba');
        $records = $this->extractRecords($response);
        $items = [];

        foreach ($records as $record) {
            if (!is_array($record)) {
                throw new RuntimeException('Format data info lomba dari API tidak valid.');
            }

            $items[] = new InfoLomba(
                $this->integerField($record, 'id'),
                $this->stringField($record, 'namaLomba'),
                $this->stringField($record, 'penyelenggara'),
                $this->stringField($record, 'tanggal'),
                $this->stringField($record, 'lokasi'),
                $this->stringField($record, 'status')
            );
        }

        return $items;
    }

    /**
     * @param InfoLomba[] $items
     * @return array{total: int, akanDatang: int, selesai: int}
     */
    public function getSummary(array $items): array
    {
        $summary = [
            'total' => count($items),
            'akanDatang' => 0,
            'selesai' => 0,
        ];

        foreach ($items as $item) {
            if (!$item instanceof InfoLomba) {
                throw new InvalidArgumentException('Ringkasan hanya menerima object InfoLomba.');
            }

            $status = mb_strtolower(trim($item->getStatus()), 'UTF-8');

            if ($status === 'akan datang') {
                $summary['akanDatang']++;
            } elseif ($status === 'selesai') {
                $summary['selesai']++;
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

        throw new RuntimeException('Format data info lomba dari API tidak valid.');
    }

    private function integerField(array $record, string $field): int
    {
        if (!array_key_exists($field, $record) || filter_var($record[$field], FILTER_VALIDATE_INT) === false) {
            throw new RuntimeException("Field {$field} pada data info lomba tidak valid.");
        }

        return (int) $record[$field];
    }

    private function stringField(array $record, string $field): string
    {
        if (!array_key_exists($field, $record) || !is_scalar($record[$field])) {
            throw new RuntimeException("Field {$field} pada data info lomba tidak valid.");
        }

        return (string) $record[$field];
    }
}
