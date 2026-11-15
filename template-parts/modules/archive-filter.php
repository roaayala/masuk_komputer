<?php
/**
 * Module: Archive Filter Bar
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$dropdowns = $args['dropdowns'] ?? [];
$checkboxes = $args['checkboxes'] ?? [];
$reset_url = $args['reset_url'] ?? '';
$reset_label = $args['reset_label'] ?? __('Bersihkan Filter', 'karsa_start');
$wrapper_class = $args['wrapper_class'] ?? '';

$active_dropdowns = array_filter($dropdowns, fn($item) => !empty($item['options']));

if (empty($active_dropdowns) && empty($checkboxes)) {
  return;
}
?>

<div class="flex flex-wrap items-center gap-4 <?= esc_attr($wrapper_class); ?>">
  <?php foreach ($active_dropdowns as $dropdown): ?>
    <?php Helpers::component('select-dropdown', [
      'id' => $dropdown['id'] ?? wp_unique_id('filter-'),
      'name' => $dropdown['name'] ?? '',
      'label' => $dropdown['label'] ?? '',
      'placeholder' => $dropdown['placeholder'] ?? '',
      'selected' => $dropdown['selected'] ?? '',
      'options' => $dropdown['options'],
      'auto_submit' => true,
    ]); ?>
  <?php endforeach; ?>

  <?php foreach ($checkboxes as $checkbox): ?>
    <label
      class="inline-flex items-center gap-1.5 text-xs text-on-surface cursor-pointer select-none px-2 py-1 rounded-md border border-outline/40 bg-surface hover:border-primary/60 transition-colors">
      <input
        type="checkbox"
        name="<?= esc_attr($checkbox['name'] ?? ''); ?>"
        value="<?= esc_attr((string) ($checkbox['value'] ?? '1')); ?>"
        onchange="this.form.submit()"
        <?php checked(!empty($checkbox['checked']), true); ?>
        class="rounded border-outline/40 text-primary focus:ring-primary">
      <span>
        <?= esc_html($checkbox['label'] ?? ''); ?>
      </span>
    </label>
  <?php endforeach; ?>

  <?php if ($reset_url !== ''): ?>
    <a href="<?= esc_url($reset_url); ?>" class="text-xs font-medium text-primary hover:underline">
      <?= esc_html($reset_label); ?>
    </a>
  <?php endif; ?>
</div>