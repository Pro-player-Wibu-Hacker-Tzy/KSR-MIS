<?php

declare(strict_types=1);

class InfoLomba
{
    // PROPERTY (Encapsulation)
    private int $id;
    private string $namaLomba;
    private string $penyelenggara;
    private string $tanggal;
    private string $lokasi;
    private string $status;

    // CONSTRUCTOR
    public function __construct(
        int $id,
        string $namaLomba,
        string $penyelenggara,
        string $tanggal,
        string $lokasi,
        string $status
    ) {
        $this->id = $id;
        $this->namaLomba = $namaLomba;
        $this->penyelenggara = $penyelenggara;
        $this->tanggal = $tanggal;
        $this->lokasi = $lokasi;
        $this->status = $status;
    }

    // GETTER
    public function getId(): int
    {
        return $this->id;
    }

    public function getNamaLomba(): string
    {
        return $this->namaLomba;
    }

    public function getPenyelenggara(): string
    {
        return $this->penyelenggara;
    }

    public function getTanggal(): string
    {
        return $this->tanggal;
    }

    public function getLokasi(): string
    {
        return $this->lokasi;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // OOP DATA PROCESSING
    public function getInformasi(): string
    {
        return sprintf(
            'Lomba: %s | Penyelenggara: %s | Tanggal: %s | Lokasi: %s | Status: %s',
            $this->namaLomba,
            $this->penyelenggara,
            $this->tanggal !== '' ? $this->tanggal : '-',
            $this->lokasi !== '' ? $this->lokasi : '-',
            $this->status
        );
    }

    // DYNAMIC HTML
    public function render(): string
    {
        $id = htmlspecialchars((string) $this->id, ENT_QUOTES, 'UTF-8');
        $namaLomba = htmlspecialchars($this->namaLomba, ENT_QUOTES, 'UTF-8');
        $penyelenggara = htmlspecialchars($this->penyelenggara, ENT_QUOTES, 'UTF-8');
        $tanggal = htmlspecialchars(
            $this->tanggal !== '' ? $this->tanggal : '-',
            ENT_QUOTES,
            'UTF-8'
        );
        $lokasi = htmlspecialchars(
            $this->lokasi !== '' ? $this->lokasi : '-',
            ENT_QUOTES,
            'UTF-8'
        );
        $status = htmlspecialchars($this->status, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900">$namaLomba</h3>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>ID: $id</p>
                <p>Penyelenggara: $penyelenggara</p>
                <p>Tanggal: $tanggal</p>
                <p>Lokasi: $lokasi</p>
                <p>Status: $status</p>
            </div>
        </article>
        HTML;
    }
}