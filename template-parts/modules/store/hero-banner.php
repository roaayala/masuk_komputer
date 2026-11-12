<?php
/**
 * Module: Store hero banner
 * @package KarsaStart
 */

$section_classes = $args['section_classes'] ?? 'py-8 bg-surface';
$slides = $args['slides'] ?? [];

// Fallback
if (empty($slides)) {
  $slides = [
    [
      'title' => __('Promo Perakitan PC & Hardware', 'karsa_start'),
      'subtitle' => __('Dapatkan penawaran harga terbaik untuk racikan PC impianmu bulan ini.', 'karsa_start'),
      'badge' => __('Promo Spesial', 'karsa_start'),
      'button_text' => __('Lihat Promo', 'karsa_start'),
      'button_url' => get_post_type_archive_link('product') ?: '#',
    ],
    [
      'title' => __('Ready Stock Komponen Terbaru', 'karsa_start'),
      'subtitle' => __('Processor, Motherboard, dan VGA card performa tinggi garansi resmi.', 'karsa_start'),
      'badge' => __('Stok Baru', 'karsa_start'),
      'button_text' => __('Jelajahi Katalog', 'karsa_start'),
      'button_url' => get_post_type_archive_link('product') ?: '#',
    ],
  ];
}
?>

<section class="<?= esc_attr($section_classes) ?>">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">

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
        class="lg:col-span-2 relative min-h-[300px] md:min-h-[360px] rounded-lg border border-outline/30 overflow-hidden flex flex-col justify-between p-6 md:p-8 bg-surface-bright shadow-sm">

        <?php foreach ($slides as $index => $slide): ?>
          <div x-show="active === <?= $index ?>" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="flex flex-col justify-between h-full z-10">

            <div class="max-w-xl">
              <?php if (!empty($slide['badge'])): ?>
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-primary/10 text-primary mb-3">
                  <?= esc_html($slide['badge']) ?>
                </span>
              <?php endif; ?>

              <h2 class="text-2xl md:text-4xl font-extrabold text-on-surface mb-2 tracking-tight leading-tight">
                <?= esc_html($slide['title']) ?>
              </h2>

              <?php if (!empty($slide['subtitle'])): ?>
                <p class="text-sm md:text-base text-on-surface-variant leading-relaxed">
                  <?= esc_html($slide['subtitle']) ?>
                </p>
              <?php endif; ?>
            </div>

            <div class="mt-6">
              <a href="<?= esc_url($slide['button_url'] ?? '#') ?>"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-on-primary font-medium text-sm rounded-lg hover:opacity-90 transition-opacity">
                <span><?= esc_html($slide['button_text'] ?? __('Lihat Detail', 'karsa_start')) ?></span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- SLIDER INDICATORS & CONTROLS -->
        <div class="flex items-center justify-between pt-4 border-t border-outline/20 z-10 mt-6">
          <div class="flex items-center gap-1.5">
            <?php foreach ($slides as $index => $slide): ?>
              <button @click="active = <?= $index ?>" type="button" aria-label="Go to slide <?= $index + 1 ?>"
                class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                :class="active === <?= $index ?> ? 'w-6 bg-primary' : 'w-2 bg-outline/40'">
              </button>
            <?php endforeach; ?>
          </div>

          <div class="flex items-center gap-2">
            <button @click="prev()" type="button" aria-label="Previous slide"
              class="p-2 rounded-lg border border-outline/30 text-on-surface hover:bg-surface-variant transition-colors cursor-pointer">
              <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            <button @click="next()" type="button" aria-label="Next slide"
              class="p-2 rounded-lg border border-outline/30 text-on-surface hover:bg-surface-variant transition-colors cursor-pointer">
              <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
          </div>
        </div>

      </div>

      <!-- RIGHT SIDE: QUICK ACTION CARDS (1 COLUMN ON DESKTOP) -->
      <div class="flex flex-col gap-4">

        <!-- CARD 1: SIMULASI RAKIT PC -->
        <a href="<?= esc_url(home_url('/rakit-pc')) ?>"
          class="group flex-1 p-6 bg-surface-bright border border-outline/30 rounded-2xl flex flex-col justify-between hover:border-primary/50 transition-colors shadow-sm">
          <div class="flex items-start justify-between">
            <div
              class="p-3 bg-primary/10 text-primary rounded-xl group-hover:bg-primary group-hover:text-on-primary transition-colors">
              <i data-lucide="cpu" class="w-6 h-6"></i>
            </div>
            <i data-lucide="external-link"
              class="w-4 h-4 text-on-surface-subtle group-hover:text-primary transition-colors"></i>
          </div>
          <div class="mt-4">
            <h3 class="font-bold text-base text-on-surface group-hover:text-primary transition-colors">
              <?= __('Simulasi Rakit PC', 'karsa_start') ?>
            </h3>
            <p class="text-xs text-on-surface-variant mt-1">
              <?= __('Kalkulasi komponen & estimasi daya watt secara presisi.', 'karsa_start') ?>
            </p>
          </div>
        </a>

        <!-- CARD 2: DOWNLOAD PRICELIST -->
        <a href="<?= esc_url(home_url('/pricelist')) ?>"
          class="group flex-1 p-6 bg-surface-bright border border-outline/30 rounded-2xl flex flex-col justify-between hover:border-primary/50 transition-colors shadow-sm">
          <div class="flex items-start justify-between">
            <div
              class="p-3 bg-surface-variant text-on-surface-variant rounded-xl group-hover:bg-primary group-hover:text-on-primary transition-colors">
              <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <i data-lucide="download"
              class="w-4 h-4 text-on-surface-subtle group-hover:text-primary transition-colors"></i>
          </div>
          <div class="mt-4">
            <h3 class="font-bold text-base text-on-surface group-hover:text-primary transition-colors">
              <?= __('Download Price List', 'karsa_start') ?>
            </h3>
            <p class="text-xs text-on-surface-variant mt-1">
              <?= __('Dapatkan katalog daftar harga komponen update terbaru.', 'karsa_start') ?>
            </p>
          </div>
        </a>

      </div>

    </div>
  </div>
</section>