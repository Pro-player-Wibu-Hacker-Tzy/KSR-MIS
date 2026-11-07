<?php

class Menu
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function render(): string
    {
        $output = '';

        foreach ($this->items as $item) {
            if (!isset($item['url'], $item['label'])) {
                continue;
            }

            $url = htmlspecialchars(
                (string) $item['url'],
                ENT_QUOTES,
                'UTF-8'
            );

            $label = htmlspecialchars(
                (string) $item['label'],
                ENT_QUOTES,
                'UTF-8'
            );

            $style = !empty($item['active'])
                ? 'block rounded-lg bg-white px-3 py-2 text-sm font-semibold text-red-700'
                : 'block rounded-lg px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700';

            $output .= '<li>';
            $output .= '<a href="' . $url . '" class="' . $style . '">';
            $output .= $label;
            $output .= '</a>';
            $output .= '</li>';
        }

        return $output;
    }
}
