<?php
/**
 * Module: Store hero banner
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$wrapper_classes = $args['wrapper_classes'] ?? 'bg-surface';
$slides = $args['slides'] ?? [];
?>

<section class="py-8 md:py-12 <?= esc_attr($wrapper_classes) ?>">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

      <!-- LEFT SIDE: SLIDER PROMO (2 COLUMNS ON DESKTOP) -->
      <?php Helpers::component('cards/card-slider', [
        'slides' => $slides
      ]) ?>

      <!-- RIGHT SIDE: QUICK ACTION CARDS (1 COLUMN ON DESKTOP) -->
      <div class="flex flex-col gap-4">

        <!-- CARD 1: SIMULASI RAKIT PC -->
        <?php Helpers::component('cards/card-link', [
          'icon' => 'component',
          'title' => __('Simulasi Rakit PC', 'karsa_start'),
          'description' => __('Kalkulasi komponen & estimasi daya watt secara presisi.', 'karsa_start'),
        ]) ?>

        <!-- CARD 2: DOWNLOAD PRICELIST -->
        <?php Helpers::component('cards/card-link', [
          'icon' => 'download',
          'title' => __('Download Price List', 'karsa_start'),
          'description' => __('Dapatkan katalog daftar harga komponen update terbaru.', 'karsa_start')
        ]) ?>

        </a>
      </div>

    </div>
  </div>
</section>