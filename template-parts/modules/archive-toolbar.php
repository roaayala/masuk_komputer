<?php
/**
 * Module: Archive Toolbar (Counter, Limit, Sort and Reset)
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$total = (int) ($args['total'] ?? $GLOBALS['wp_query']->found_posts ?? 0);
$item_label = $args['item_label'] ?? __('item', 'karsa_start');

$limit = $args['limit'] ?? [];

$sort = $args['sort'] ?? [];

$reset_url = $args['reset_url'] ?? '';
$reset_label = $args['reset_label'] ?? __('Bersihkan Filter', 'karsa_start');

$wrapper_class = $args['wrapper_class'] ?? '';

?>

<div class="flex flex-wrap gap-4 items-center justify-between <?= esc_attr($wrapper_class); ?>">
  <p class="text-sm text-on-surface-variant mr-2">
    <?= sprintf(
      wp_kses(
        __('Menampilkan <strong class="font-semibold text-on-surface">%1$d</strong> %2$s', 'karsa_start'),
        ['strong' => ['class' => []]]
      ),
      $total,
      esc_html($item_label)
    ); ?>
  </p>

  <div class="flex flex-wrap items-center gap-4">
    <?php if (!empty($limit['options'])): ?>
      <?php Helpers::component('select-dropdown', [
        'id' => $limit['id'] ?? 'limit-items',
        'name' => $limit['name'] ?? 'limit',
        'label' => $limit['label'] ?? __('Tampilkan:', 'karsa_start'),
        'selected' => $limit['selected'] ?? '',
        'options' => $limit['options'],
        'auto_submit' => true,
      ]); ?>
    <?php endif; ?>

    <?php if (!empty($sort['options'])): ?>
      <?php Helpers::component('select-dropdown', [
        'id' => $sort['id'] ?? 'sort-items',
        'name' => $sort['name'] ?? 'sort',
        'label' => $sort['label'] ?? __('Urutkan:', 'karsa_start'),
        'selected' => $sort['selected'] ?? '',
        'options' => $sort['options'],
        'auto_submit' => true,
      ]); ?>
    <?php endif; ?>

    <?php if ($reset_url !== ''): ?>
      <a href="<?= esc_url($reset_url); ?>" class="text-xs font-medium text-primary hover:underline">
        <?= esc_html($reset_label); ?>
      </a>
    <?php endif; ?>
  </div>
</div>