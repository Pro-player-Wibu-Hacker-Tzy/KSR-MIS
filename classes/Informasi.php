<?php

declare(strict_types=1);

class Informasi
{
    private int $id;
    private string $judul;
    private string $isi;
    private string $tanggal;
    private string $kategori;

    public function __construct(
        int $id,
        string $judul,
        string $isi,
        string $tanggal,
        string $kategori
    ) {
        $this->id = $id;
        $this->judul = $judul;
        $this->isi = $isi;
        $this->tanggal = $tanggal;
        $this->kategori = $kategori;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getJudul(): string
    {
        return $this->judul;
    }

    public function getIsi(): string
    {
        return $this->isi;
    }

    public function getTanggal(): string
    {
        return $this->tanggal;
    }

    public function getKategori(): string
    {
        return $this->kategori;
    }

    public function getInformasi(): string
    {
        return sprintf(
            'Informasi: %s | Kategori: %s | Tanggal: %s | Isi: %s',
            $this->judul,
            $this->kategori,
            $this->tanggal !== '' ? $this->tanggal : '-',
            $this->isi
        );
    }

    public function render(): string
    {
        $id = htmlspecialchars((string) $this->id, ENT_QUOTES, 'UTF-8');
        $judul = htmlspecialchars($this->judul, ENT_QUOTES, 'UTF-8');
        $isi = nl2br(htmlspecialchars($this->isi, ENT_QUOTES, 'UTF-8'));
        $tanggal = htmlspecialchars(
            $this->tanggal !== '' ? $this->tanggal : '-',
            ENT_QUOTES,
            'UTF-8'
        );
        $kategori = htmlspecialchars($this->kategori, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <h3 class="text-lg font-bold text-gray-900">$judul</h3>
                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">$kategori</span>
            </div>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>ID: $id</p>
                <p>Tanggal: $tanggal</p>
                <p class="whitespace-pre-line">$isi</p>
            </div>
        </article>
        HTML;
    }
}
