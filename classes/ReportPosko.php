<?php

declare(strict_types=1);

class ReportPosko
{
    private int $id;
    private string $namaPosko;
    private string $lokasi;
    private string $tanggal;
    private int $jumlahPetugas;
    private string $kondisi;
    private string $keterangan;

    public function __construct(
        int $id,
        string $namaPosko,
        string $lokasi,
        string $tanggal,
        int $jumlahPetugas,
        string $kondisi,
        string $keterangan
    ) {
        $this->id = $id;
        $this->namaPosko = $namaPosko;
        $this->lokasi = $lokasi;
        $this->tanggal = $tanggal;
        $this->jumlahPetugas = $jumlahPetugas;
        $this->kondisi = $kondisi;
        $this->keterangan = $keterangan;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNamaPosko(): string
    {
        return $this->namaPosko;
    }

    public function getLokasi(): string
    {
        return $this->lokasi;
    }

    public function getTanggal(): string
    {
        return $this->tanggal;
    }

    public function getJumlahPetugas(): int
    {
        return $this->jumlahPetugas;
    }

    public function getKondisi(): string
    {
        return $this->kondisi;
    }

    public function getKeterangan(): string
    {
        return $this->keterangan;
    }

    public function getInformasi(): string
    {
        return sprintf(
            'Report Posko: %s | Lokasi: %s | Tanggal: %s | Petugas: %d | Kondisi: %s | Keterangan: %s',
            $this->namaPosko,
            $this->lokasi,
            $this->tanggal !== '' ? $this->tanggal : '-',
            $this->jumlahPetugas,
            $this->kondisi,
            $this->keterangan
        );
    }

    public function getStatusKondisi(): string
    {
        return match (mb_strtolower(trim($this->kondisi), 'UTF-8')) {
            'aman' => 'Posko dalam kondisi aman.',
            'perlu perhatian' => 'Posko memerlukan perhatian.',
            'darurat' => 'Posko dalam kondisi darurat.',
            default => 'Kondisi posko belum diketahui.',
        };
    }

    public function render(): string
    {
        $id = htmlspecialchars((string) $this->id, ENT_QUOTES, 'UTF-8');
        $namaPosko = htmlspecialchars($this->namaPosko, ENT_QUOTES, 'UTF-8');
        $lokasi = htmlspecialchars($this->lokasi, ENT_QUOTES, 'UTF-8');
        $tanggal = htmlspecialchars(
            $this->tanggal !== '' ? $this->tanggal : '-',
            ENT_QUOTES,
            'UTF-8'
        );
        $jumlahPetugas = htmlspecialchars(
            (string) $this->jumlahPetugas,
            ENT_QUOTES,
            'UTF-8'
        );
        $kondisi = htmlspecialchars($this->kondisi, ENT_QUOTES, 'UTF-8');
        $keterangan = nl2br(htmlspecialchars($this->keterangan, ENT_QUOTES, 'UTF-8'));
        $statusKondisi = htmlspecialchars($this->getStatusKondisi(), ENT_QUOTES, 'UTF-8');
        $kondisiClass = match (mb_strtolower(trim($this->kondisi), 'UTF-8')) {
            'aman' => 'bg-green-50 text-green-700',
            'perlu perhatian' => 'bg-yellow-50 text-yellow-700',
            'darurat' => 'bg-red-50 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };

        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <h3 class="text-lg font-bold text-gray-900">$namaPosko</h3>
                <span class="rounded-full px-3 py-1 text-xs font-semibold $kondisiClass">$kondisi</span>
            </div>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>ID: $id</p>
                <p>Lokasi: $lokasi</p>
                <p>Tanggal: $tanggal</p>
                <p>Jumlah Petugas: $jumlahPetugas</p>
                <p>$statusKondisi</p>
                <p>Keterangan: $keterangan</p>
            </div>
        </article>
        HTML;
    }
}
