<?php
class Menu {
    public function __construct(private array $items) {}
    public function render(): string {
        $output = '';
        foreach ($this->items as $item) {
            $url = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
            $label = htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8');
            $style = !empty($item['active'])
                ? 'block rounded-lg bg-white px-3 py-2 text-sm font-semibold text-red-700'
                : 'block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700';
            $output .= '<li><a href="'.$url.'" class="'.$style.'">'.$label.'</a></li>';
        }
        return $output;
    }
}
