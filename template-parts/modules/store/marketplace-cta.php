<?php

/**
 * Section: List of marketplaces
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$section_classes = $args['section_classes'] ?? 'bg-surface';
$title = $args['title'] ?? __('Judul Section', 'karsa_start');

$marketplaces = [
  [
    'key' => 'shopee',
    'url' => '#'
  ],
  [
    'key' => 'tokopedia',
    'url' => '#'
  ],
  [
    'key' => 'blibli',
    'url' => '#'
  ],
  [
    'key' => 'lazada',
    'url' => '#'
  ]
];
?>

<section class="py-8 md:py-12 <?= esc_attr($section_classes) ?>">
  <div class="container flex flex-col items-center text-center gap-6">

    <div class="max-w-md">
      <h2>
        <?= esc_html($title) ?>
      </h2>
    </div>

    <div class="w-full grid grid-cols-2 sm:grid-cols-4 gap-4">
      <?php foreach ($marketplaces as $marketplace): ?>

        <a href="<?= esc_url($marketplace['url']) ?>" class="group block" target="_blank">
          <div
            class="w-full h-20 sm:h-30 p-4 bg-surface-bright rounded-lg border border-outline/20 hover:border-outline/60 shadow-sm flex items-center justify-center transition-border duration-150">
            <?= Helpers::get_icon(
              $marketplace['key'],
              $marketplace['key'] == 'tokopedia'
              ? 'h-6 sm:h-8 mt-1'
              : ($marketplace['key'] ? 'h-7 sm:h-9' : 'h-8 sm:h-10')
            ) ?>
          </div>
        </a>

      <?php endforeach ?>
    </div>

  </div>
</section>