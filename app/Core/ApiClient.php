<?php
declare(strict_types=1);

class ApiClient
{
    private string $baseUrl;
    private int $timeout;

    public function __construct(
        ?string $baseUrl = null,
        int $timeout = 5
    ) {
        $this->baseUrl = rtrim(
            $baseUrl
                ?? (getenv('KSR_API_BASE_URL')
                    ?: 'http://localhost:3000'),
            '/'
        );

        $this->timeout = $timeout;
    }

    public function get(string $endpoint): array
    {
        $endpoint = '/' . ltrim(trim($endpoint), '/');
        $url = $this->baseUrl . $endpoint;

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => $this->timeout,
                'ignore_errors' => true,
                'header' => "Accept: application/json\r\n",
            ],
        ]);

        $body = @file_get_contents(
            $url,
            false,
            $context
        );

        if ($body === false) {
            throw new RuntimeException(
                'API tidak dapat dihubungi. '
                . 'Pastikan backend Express berjalan.'
            );
        }

        $statusCode = 0;

        foreach (($http_response_header ?? []) as $header) {
            if (
                preg_match(
                    '/^HTTP\/\S+\s+(\d{3})/',
                    $header,
                    $matches
                )
            ) {
                $statusCode = (int) $matches[1];
            }
        }

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'JSON API tidak valid: '
                . json_last_error_msg()
            );
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            $message = is_array($data)
                ? (string) ($data['message']
                    ?? 'Permintaan API gagal.')
                : 'Permintaan API gagal.';

            throw new RuntimeException(
                "HTTP {$statusCode}: {$message}"
            );
        }

        if (!is_array($data)) {
            throw new RuntimeException(
                'Respons API harus berupa array atau object JSON.'
            );
        }

        return $data;
    }
}