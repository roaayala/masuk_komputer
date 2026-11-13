<?php
/**
 * Component: Card link
 * @package KarsaStart
 */

$url = $args['url'] ?? 'arrow-right';
$icon = $args['icon'] ?? null;
$title = $args['title'] ?? __('Judul', 'karsa_start');
$description = $args['description'] ?? __(
  'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores ullam harum omnis.',
  'karsa_start'
);

?>

<a href="<?= esc_url($url) ?>" class="block group">
  <div
    class="h-full w-full p-6 flex flex-col gap-6 bg-surface-bright rounded-lg shadow-sm border border-outline/20 hover:border-primary/40">
    <div class="flex flex-col gap-4">

      <!-- Icon Container / Badge -->
      <div class="inline-flex self-end justify-center">
        <i data-lucide="<?= esc_attr($icon) ?>" class="w-5 h-5 text-on-surface group-hover:text-primary"
          aria-hidden="true"></i>
      </div>

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