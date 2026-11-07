<?php

class ProgramPrioritas
{
    public function __construct(
        public readonly int $id,
        public readonly string $namaProgram,
        public readonly string $kategori,
        public readonly string $penanggungJawab,
        public readonly string $tanggalMulai,
        public readonly string $targetSelesai,
        public readonly string $status,
        public readonly int $progress,
        public readonly string $deskripsi
    ) {
        if ($this->progress < 0 || $this->progress > 100) {
            throw new InvalidArgumentException(
                'Progress harus berada di antara 0 sampai 100.'
            );
        }

        $statusValid = ['Akan Datang', 'Berlangsung', 'Selesai'];

        if (!in_array($this->status, $statusValid, true)) {
            throw new InvalidArgumentException('Status program tidak valid.');
        }
    }

    public function renderStatusBadge(): string
    {
        $status = htmlspecialchars($this->status, ENT_QUOTES, 'UTF-8');

        $warna = match ($this->status) {
            'Akan Datang' => 'bg-orange-100 text-orange-700',
            'Berlangsung' => 'bg-blue-100 text-blue-700',
            'Selesai' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700'
        };

        return '<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold '
            . $warna . '">' . $status . '</span>';
    }

    public function formatTanggal(string $tanggal): string
    {
        if (empty($tanggal)) {
            return '-';
        }

        $timestamp = strtotime($tanggal);

        if ($timestamp === false) {
            return htmlspecialchars($tanggal, ENT_QUOTES, 'UTF-8');
        }

        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $hari = date('j', $timestamp);
        $namaBulan = $bulan[(int) date('n', $timestamp)];
        $tahun = date('Y', $timestamp);

        return $hari . ' ' . $namaBulan . ' ' . $tahun;
    }

    public function renderCard(int $nomor): string
    {
        $nama = htmlspecialchars($this->namaProgram, ENT_QUOTES, 'UTF-8');
        $kategori = htmlspecialchars($this->kategori, ENT_QUOTES, 'UTF-8');
        $deskripsi = htmlspecialchars($this->deskripsi, ENT_QUOTES, 'UTF-8');
        $pj = htmlspecialchars($this->penanggungJawab, ENT_QUOTES, 'UTF-8');
        $target = $this->formatTanggal($this->targetSelesai);
        $progress = $this->progress;
        $badge = $this->renderStatusBadge();

        return <<<HTML
        <article class="flex flex-col justify-between rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
            <div>
                <div class="mb-3 flex items-start justify-between gap-2">
                    <span class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700">
                        #{$nomor}
                    </span>
                    {$badge}
                </div>

                <span class="mb-1 block text-xs font-medium uppercase tracking-wider text-gray-500">
                    {$kategori}
                </span>

                <h3 class="mb-2 text-lg font-bold text-gray-900">
                    {$nama}
                </h3>

                <p class="mb-4 text-sm text-gray-600">
                    {$deskripsi}
                </p>
            </div>

            <div>
                <div class="mb-4">
                    <div class="mb-1 flex justify-between text-xs font-semibold text-gray-600">
                        <span>Progres</span>
                        <span>{$progress}%</span>
                    </div>

                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-red-600"
                             style="width: {$progress}%"></div>
                    </div>
                </div>

                <div class="space-y-1 border-t border-gray-100 pt-3 text-xs text-gray-500">
                    <p><strong class="text-gray-700">PJ:</strong> {$pj}</p>
                    <p><strong class="text-gray-700">Target:</strong> {$target}</p>
                </div>
            </div>
        </article>
        HTML;
    }

    public function renderTableRow(int $nomor): string
    {
        $nama = htmlspecialchars($this->namaProgram, ENT_QUOTES, 'UTF-8');
        $kategori = htmlspecialchars($this->kategori, ENT_QUOTES, 'UTF-8');
        $pj = htmlspecialchars($this->penanggungJawab, ENT_QUOTES, 'UTF-8');
        $target = $this->formatTanggal($this->targetSelesai);
        $progress = $this->progress;
        $badge = $this->renderStatusBadge();

        return <<<HTML
        <tr class="transition hover:bg-gray-50">
            <td class="whitespace-nowrap px-4 py-3 text-gray-600">{$nomor}</td>
            <td class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900">{$nama}</td>
            <td class="whitespace-nowrap px-4 py-3 text-gray-600">{$kategori}</td>
            <td class="whitespace-nowrap px-4 py-3 text-gray-600">{$pj}</td>
            <td class="whitespace-nowrap px-4 py-3 text-gray-600">{$target}</td>
            <td class="whitespace-nowrap px-4 py-3 font-medium">{$progress}%</td>
            <td class="whitespace-nowrap px-4 py-3">{$badge}</td>
        </tr>
        HTML;
    }
}
