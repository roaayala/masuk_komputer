<?php
/**
 * Module: Hero
 */

use KarsaStart\Helpers;

$wrapper_classes = $args['wrapper_classes'] ?? 'bg-surface-bright';
$title = $args['title'] ?? __('Judul Hero', 'karsa_start');
$leading_text = $args['leading_text'] ?? __(
  'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores ullam harum omnis.',
  'karsa_start'
);

// BUTTON
// Primary
$cta_primary_label = $args['cta_primary_label'] ?? __('Jelajahi Sekarang', 'karsa_start');
$cta_primary_url = $args['cta_primary_url'] ?? '';
// Secondary
$cta_secondary_label = $args['cta_secondary_label'] ?? '';
$cta_secondary_url = $args['cta_secondary_url'] ?? '';

// IMAGE
$image_url = $args['image_url'] ?? Helpers::get_image_placeholder_url('fallback-2-undraw');
$image_alt = $args['image_alt'] ?? 'Hero Image';

?>

<section class="py-8 md:py-12 <?= esc_attr($wrapper_classes) ?>">
  <div class="container">
    <div class="grid md:grid-cols-12 gap-8 items-center">

      <!-- LEFT COLUMN: TEXT & CTA -->
      <div class="md:col-span-5 lg:col-span-6 xl:col-span-7 flex flex-col gap-4">
        <div class="flex flex-col gap-3">
          <h1>
            <?= esc_html($title) ?>
          </h1>
          <p class="text-on-surface-subtle">
            <?= esc_html($leading_text) ?>
          </p>
        </div>

        <!-- BUTTON GROUP -->
        <?php if (!empty($cta_primary_url) || !empty($cta_secondary_url)): ?>
          <div class="flex flex-wrap items-center gap-4">

            <?php if (!empty($cta_primary_url)): ?>
              <a href="<?= esc_url($cta_primary_url) ?>" class="btn primary">
                <span class="label">
                  <?= esc_html($cta_primary_label) ?>
                </span>
                <i data-lucide="arrow-right" class="icon"></i>
              </a>
            <?php endif; ?>

            <?php if (!empty($cta_secondary_url)): ?>
              <a href="<?= esc_url($cta_secondary_url) ?>" class="btn primary inverse">
                <span class="label">
                  <?= esc_html($cta_secondary_label) ?>
                </span>
              </a>
            <?php endif; ?>

          </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT COLUMN: HERO IMAGE -->
      <div class="md:col-span-7 lg:col-span-6 xl:col-span-5">
        <div class="relative">
          <img src="<?= esc_url($image_url) ?>" alt="<?= esc_attr($image_alt) ?>" loading="eager"
            class="w-full h-auto aspect-4/3 xs:aspect-video md:aspect-4/3 object-contain mx-auto">
        </div>
      </div>

    </div>
  </div>
</section>