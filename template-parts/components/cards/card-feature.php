<?php
/**
 * Component: Card feature
 * @package KarsaStart
 */

$icon = $args['icon'] ?? 'lightbulb';
$title = $args['title'] ?? __('Judul Fitur', 'karsa_start');
$description = $args['description'] ?? __(
  'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores ullam harum omnis.',
  'karsa_start'
);

?>

<div
  class="h-full p-6 flex flex-col gap-6 bg-surface-bright rounded-2xl shadow-sm border border-outline/20 hover:border-primary/40">
  <div class="flex flex-col gap-4">

    <!-- Icon Container / Badge -->
    <div class="p-3 rounded-lg bg-primary-container text-on-primary-container inline-flex self-start justify-center">
      <i data-lucide="<?= esc_attr($icon) ?>" class="w-5 h-5" aria-hidden="true"></i>
    </div>

    <!-- Title & Description -->
    <div class="flex flex-col gap-1">
      <h3 class="text-lg">
        <?= esc_html($title) ?>
      </h3>
      <p class="text-sm text-on-surface-subtle">
        <?= esc_html($description) ?>
      </p>
    </div>

  </div>
</div>