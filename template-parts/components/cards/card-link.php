<?php
/**
 * Component: Card link
 * @package KarsaStart
 */

$url = $args['url'] ?? '#';
$icon = $args['icon'] ?? null;
$title = $args['title'] ?? __('Judul', 'karsa_start');
$description = $args['description'] ?? __(
  'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores ullam harum omnis.',
  'karsa_start'
);

?>

<a href="<?= esc_url($url) ?>" class="block">
  <div
    class="h-full w-full p-6 flex flex-col gap-6 bg-surface-bright rounded-lg shadow-sm border border-outline/20 hover:border-primary/40">
    <div class="flex flex-col gap-4">

      <!-- Icon Container / Badge -->
      <?php if ($icon): ?>
        <div class="inline-flex self-start justify-center">
          <i data-lucide="<?= esc_attr($icon) ?>" class="w-5 h-5" aria-hidden="true"></i>
        </div>
      <?php endif; ?>

      <!-- Title & Description -->
      <div class="flex flex-col gap-1">
        <h3 class="text-base">
          <?= esc_html($title) ?>
        </h3>
        <p class="text-xs text-on-surface-subtle">
          <?= esc_html($description) ?>
        </p>
      </div>

    </div>

  </div>

</a>