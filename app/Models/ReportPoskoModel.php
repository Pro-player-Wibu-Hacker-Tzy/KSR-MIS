<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/Core/ApiClient.php';
require_once dirname(__DIR__, 2) . '/classes/ReportPosko.php';

class ReportPoskoModel
{
    public function __construct(private ApiClient $apiClient)
    {
    }

    /**
     * @return ReportPosko[]
     */
    public function getAll(): array
    {
        $response = $this->apiClient->get('/api/report-posko');
        $records = $this->extractRecords($response);
        $items = [];

        foreach ($records as $record) {
            if (!is_array($record)) {
                throw new RuntimeException('Format data report posko dari API tidak valid.');
            }

            $items[] = new ReportPosko(
                $this->integerField($record, 'id'),
                $this->stringField($record, 'namaPosko'),
                $this->stringField($record, 'lokasi'),
                $this->stringField($record, 'tanggal'),
                $this->integerField($record, 'jumlahPetugas'),
                $this->stringField($record, 'kondisi'),
                $this->stringField($record, 'keterangan')
            );
        }

        return $items;
    }

    /**
     * @param ReportPosko[] $items
     * @return array{total: int, aman: int, perluPerhatian: int, darurat: int}
     */
    public function getSummary(array $items): array
    {
        $summary = [
            'total' => count($items),
            'aman' => 0,
            'perluPerhatian' => 0,
            'darurat' => 0,
        ];

        foreach ($items as $item) {
            if (!$item instanceof ReportPosko) {
                throw new InvalidArgumentException('Ringkasan hanya menerima object ReportPosko.');
            }

            $kondisi = mb_strtolower(trim($item->getKondisi()), 'UTF-8');

            if ($kondisi === 'aman') {
                $summary['aman']++;
            } elseif ($kondisi === 'perlu perhatian') {
                $summary['perluPerhatian']++;
            } elseif ($kondisi === 'darurat') {
                $summary['darurat']++;
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

        throw new RuntimeException('Format data report posko dari API tidak valid.');
    }

    private function integerField(array $record, string $field): int
    {
        if (!array_key_exists($field, $record) || filter_var($record[$field], FILTER_VALIDATE_INT) === false) {
            throw new RuntimeException("Field {$field} pada data report posko tidak valid.");
        }

        return (int) $record[$field];
    }

    private function stringField(array $record, string $field): string
    {
        if (!array_key_exists($field, $record) || !is_scalar($record[$field])) {
            throw new RuntimeException("Field {$field} pada data report posko tidak valid.");
        }

        return (string) $record[$field];
    }
}
