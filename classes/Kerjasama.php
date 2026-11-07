<?php

declare(strict_types=1);

class KerjaSama
{
    // PROPERTY (Encapsulation)
    private int $id;
    private string $namaInstansi;
    private string $jenisKerjasama;
    private string $tanggal;
    private string $status;

    // CONSTRUCTOR
    public function __construct(
        int $id,
        string $namaInstansi,
        string $jenisKerjasama,
        string $tanggal,
        string $status
    ) {
        $this->id = $id;
        $this->namaInstansi = $namaInstansi;
        $this->jenisKerjasama = $jenisKerjasama;
        $this->tanggal = $tanggal;
        $this->status = $status;
    }

    // GETTER
    public function getId(): int
    {
        return $this->id;
    }

    public function getNamaInstansi(): string
    {
        return $this->namaInstansi;
    }

    public function getJenisKerjasama(): string
    {
        return $this->jenisKerjasama;
    }

    public function getTanggal(): string
    {
        return $this->tanggal;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // OOP DATA PROCESSING
    public function getInformasi(): string
    {
        return sprintf(
            'Kerja sama dengan %s | Jenis: %s | Tanggal: %s | Status: %s',
            $this->namaInstansi,
            $this->jenisKerjasama,
            $this->tanggal !== '' ? $this->tanggal : '-',
            $this->status
        );
    }

    // DYNAMIC HTML
    public function render(): string
    {
        $id = htmlspecialchars((string) $this->id, ENT_QUOTES, 'UTF-8');
        $namaInstansi = htmlspecialchars($this->namaInstansi, ENT_QUOTES, 'UTF-8');
        $jenisKerjasama = htmlspecialchars($this->jenisKerjasama, ENT_QUOTES, 'UTF-8');
        $tanggal = htmlspecialchars(
            $this->tanggal !== '' ? $this->tanggal : '-',
            ENT_QUOTES,
            'UTF-8'
        );
        $status = htmlspecialchars($this->status, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900">$namaInstansi</h3>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>ID: $id</p>
                <p>Jenis Kerja Sama: $jenisKerjasama</p>
                <p>Tanggal: $tanggal</p>
                <p>Status: $status</p>
            </div>
        </article>
        HTML;
    }
}