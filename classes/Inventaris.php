<?php

declare(strict_types=1);

class Inventaris
{
    // PROPERTY (Encapsulation)
    private int $id;
    private string $nama;
    private int $jumlah;
    private string $kondisi;
    private string $status;

    // CONSTRUCTOR
    public function __construct(
        int $id,
        string $nama,
        int $jumlah,
        string $kondisi,
        string $status
    ) {
        $this->id = $id;
        $this->nama = $nama;
        $this->jumlah = $jumlah;
        $this->kondisi = $kondisi;
        $this->status = $status;
    }

    // GETTER
    public function getId(): int
    {
        return $this->id;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getJumlah(): int
    {
        return $this->jumlah;
    }

    public function getKondisi(): string
    {
        return $this->kondisi;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // OOP DATA PROCESSING
    public function getInformasi(): string
    {
        return sprintf(
            'Inventaris: %s | Jumlah: %d | Kondisi: %s | Status: %s',
            $this->nama,
            $this->jumlah,
            $this->kondisi,
            $this->status
        );
    }

    // DYNAMIC HTML
    public function render(): string
    {
        $id = htmlspecialchars((string) $this->id, ENT_QUOTES, 'UTF-8');
        $nama = htmlspecialchars($this->nama, ENT_QUOTES, 'UTF-8');
        $jumlah = htmlspecialchars((string) $this->jumlah, ENT_QUOTES, 'UTF-8');
        $kondisi = htmlspecialchars($this->kondisi, ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($this->status, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900">$nama</h3>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>ID: $id</p>
                <p>Jumlah: $jumlah</p>
                <p>Kondisi: $kondisi</p>
                <p>Status: $status</p>
            </div>
        </article>
        HTML;
    }
}