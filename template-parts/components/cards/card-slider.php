<?php
/**
 * Component: Card slider
 */

$wrapper_classes = $args['wrapper_classes'] ?? '';
$slides = $args['slides'] ?? [];

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

<div x-data="{ 
            active: 0, 
            total: <?= count($slides) ?>,
            timer: null,
            next() { this.active = (this.active + 1) % this.total },
            prev() { this.active = (this.active - 1 + this.total) % this.total },
            startTimer() { this.timer = setInterval(() => this.next(), 6000) },
            stopTimer() { clearInterval(this.timer) }
           }" x-init="startTimer()" @mouseenter="stopTimer()" @mouseleave="startTimer()"
  class="<?= esc_attr($wrapper_classes) ?> rounded-lg border border-outline/20 overflow-hidden flex flex-col gap-6 justify-between p-6 md:p-8 bg-surface-bright shadow-sm">

  <?php foreach ($slides as $index => $slide): ?>
    <div x-show="active === <?= $index ?>" x-cloak x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">

      <div class="flex flex-col gap-4">
        <?php if (!empty($slide['badge'])): ?>
          <div>
            <span class="badge badge--primary">
              <span class="label">
                <?= esc_html($slide['badge']) ?>
              </span>
            </span>
          </div>
        <?php endif; ?>

        <div class="flex flex-col gap-2">
          <h2 class="font-bold text-3xl sm:text-4xl max-w-md">
            <?= esc_html($slide['title']) ?>
          </h2>

          <?php if (!empty($slide['subtitle'])): ?>
            <p class="text-base text-on-surface-variant max-w-2xl">
              <?= esc_html($slide['subtitle']) ?>
            </p>
          <?php endif; ?>
        </div>

        <div>
          <a href="<?= esc_url($slide['button_url'] ?? '#') ?>" class="btn btn--primary w-full xs:w-auto">
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
      <button @click="prev()" type="button" aria-label="Previous slide" class="btn btn--neutral btn--outline h-8 w-8">
        <i data-lucide="chevron-left" class="icon"></i>
      </button>
      <button @click="next()" type="button" aria-label="Next slide" class="btn btn--neutral btn--outline h-8 w-8">
        <i data-lucide="chevron-right" class="icon"></i>
      </button>
    </div>
  </div>

</div>