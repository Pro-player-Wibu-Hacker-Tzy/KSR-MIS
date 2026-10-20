<?php
class Layanan {
    public function __construct(private string $nama, private string $deskripsi, private string $url, private string $tombol) {}
    public function render(): string {
        $nama = htmlspecialchars($this->nama, ENT_QUOTES, 'UTF-8');
        $deskripsi = htmlspecialchars($this->deskripsi, ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $tombol = htmlspecialchars($this->tombol, ENT_QUOTES, 'UTF-8');
        return <<<HTML
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg sm:p-6">
            <h3 class="mb-2 text-lg font-bold text-gray-900">{$nama}</h3>
            <p class="mb-5 text-sm text-gray-600">{$deskripsi}</p>
            <a href="{$url}" class="inline-block rounded-lg bg-red-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-800">{$tombol}</a>
        </article>
        HTML;
    }
}
