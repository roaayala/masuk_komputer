<?php

/**
 * Component: Navigation menu dropdown for desktop
 * @package KarsaStart
 */

$items = $args['items'] ?? [];
$label = $args['label'] ?? __('Label', 'karsa_start');

if (empty($items)) {
  return;
}
?>

<div x-data="{ expanded: false }" @click.outside="expanded = false" class="relative">
  <button @click="expanded = !expanded" type="button"
    class="cursor-pointer flex items-center gap-1 text-sm text-on-surface hover:underline">
    <span :class=" { 'underline' : expanded }">
      <?= esc_html($label) ?>
    </span>
    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }"></i>
  </button>

  <div x-show="expanded"
    class="absolute top-full right-0 z-50 mt-2 min-w-60 bg-surface-bright p-6 border border-outline/40 rounded-lg shadow-lg flex flex-col gap-4">
    <?php foreach ($items as $item): ?>
      <div class="flex flex-col gap-3">
        <a href="<?= esc_url($item['url']) ?>" class="flex text-sm text-on-surface-variant hover:underline">
          <?= esc_html($item['label']) ?>
        </a>
        <?php if (!empty($item['children'])): ?>
          <div class="pl-4 flex flex-col gap-2">
            <?php foreach ($item['children'] as $child): ?>
              <a href="<?= esc_url($child['url']) ?>" class="text-sm text-on-surface-subtle hover:underline">
                <?= esc_html($child['label']) ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>