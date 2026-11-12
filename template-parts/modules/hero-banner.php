<?php

use KarsaStart\Helpers;
/**
 * Module: Store hero banner
 * @package KarsaStart
 */

$section_classes = $args['section_classes'] ?? 'bg-surface';
$slides = $args['slides'] ?? [];

// Fallback
if (empty($slides)) {
  $slides = [
    [
      'title' => __('Banner 1', 'karsa_start'),
      'subtitle' => __('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem minus obcaecati voluptatum.', 'karsa_start'),
      'badge' => __('Badge', 'karsa_start'),
      'button_text' => __('Button Text', 'karsa_start'),
      'button_url' => '#',
    ],
    [
      'title' => __('Banner 2', 'karsa_start'),
      'subtitle' => __('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem minus obcaecati voluptatum.', 'karsa_start'),
      'badge' => __('Badge', 'karsa_start'),
      'button_text' => __('Button Text', 'karsa_start'),
      'button_url' => '#',
    ],
  ];
}
?>

<section class="py-8 md:py-12 <?= esc_attr($section_classes) ?>">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

      <!-- LEFT SIDE: SLIDER PROMO (2 COLUMNS ON DESKTOP) -->
      <div x-data="{ 
            active: 0, 
            total: <?= count($slides) ?>,
            timer: null,
            next() { this.active = (this.active + 1) % this.total },
            prev() { this.active = (this.active - 1 + this.total) % this.total },
            startTimer() { this.timer = setInterval(() => this.next(), 6000) },
            stopTimer() { clearInterval(this.timer) }
           }" x-init="startTimer()" @mouseenter="stopTimer()" @mouseleave="startTimer()"
        class="md:col-span-2 rounded-lg border border-outline/20 overflow-hidden flex flex-col gap-6  justify-between p-6 md:p-8 bg-surface-bright shadow-sm">

        <?php foreach ($slides as $index => $slide): ?>
          <div x-show="active === <?= $index ?>" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="flex flex-col justify-between h-full">

            <div>
              <?php if (!empty($slide['badge'])): ?>
                <div class="mb-4">
                  <span class="badge badge--primary">
                    <span class="label"><?= esc_html($slide['badge']) ?></span>
                  </span>
                </div>
              <?php endif; ?>

              <div class="flex flex-col gap-1 mb-4">
                <h2 class="font-bold text-3xl sm:text-4xl">
                  <?= esc_html($slide['title']) ?>
                </h2>

                <?php if (!empty($slide['subtitle'])): ?>
                  <p class="text-base text-on-surface-variant lg:max-w-2xl">
                    <?= esc_html($slide['subtitle']) ?>
                  </p>
                <?php endif; ?>
              </div>

              <div>
                <a href="<?= esc_url($slide['button_url'] ?? '#') ?>" class="btn btn--primary">
                  <span class="label">
                    <?= esc_html($slide['button_text']) ?>
                  </span>
                  <i data-lucide="arrow-right" class="icon"></i>
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

        <!-- SLIDER INDICATORS & CONTROLS -->
        <div class="flex items-center justify-between pt-4 border-t border-outline/20">
          <div class="flex items-center gap-2">
            <?php foreach ($slides as $index => $slide): ?>
              <button @click="active = <?= $index ?>" type="button" aria-label="Go to slide <?= $index + 1 ?>"
                class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                :class="active === <?= $index ?> ? 'w-6 bg-primary' : 'w-2 bg-surface-container'">
              </button>
            <?php endforeach; ?>
          </div>

          <div class="flex items-center gap-2">
            <button @click="prev()" type="button" aria-label="Previous slide"
              class="btn btn--neutral btn--outline h-8 w-8">
              <i data-lucide="chevron-left" class="icon"></i>
            </button>
            <button @click="next()" type="button" aria-label="Next slide" class="btn btn--neutral btn--outline h-8 w-8">
              <i data-lucide="chevron-right" class="icon"></i>
            </button>
          </div>
        </div>

      </div>

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

        <!-- <a href="#" class="md:flex-1 h-full">
    
        </a> -->
      </div>

    </div>
  </div>
</section>