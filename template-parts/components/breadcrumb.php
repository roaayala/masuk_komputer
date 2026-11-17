<?php
/**
 * Component: Breadcrumb
 * @package KarsaStart
 */

if (is_front_page()) {
  return;
}

$wrapper_classes = $args['wrapper_classes'] ?? '';
$custom_items = $args['items'] ?? null;

$items = [
  [
    'label' => __('Beranda', 'karsa_start'),
    'url' => home_url('/'),
  ],
];

if (is_array($custom_items) && !empty($custom_items)) {
  $items = array_merge($items, $custom_items);
} else {
  if (is_page()) {
    $post_id = get_the_ID();
    $parents = array_reverse(get_post_ancestors($post_id));

    foreach ($parents as $parent_id) {
      $items[] = [
        'label' => get_the_title($parent_id),
        'url' => get_permalink($parent_id),
      ];
    }

    $items[] = [
      'label' => get_the_title(),
      'url' => null,
    ];

  }
}

$last_index = count($items) - 1;


?>

<nav aria-label="Breadcrumb" class="<?= esc_attr($wrapper_classes) ?>">
  <ol class="flex flex-wrap items-center gap-1 text-xs text-on-surface-subtle">
    <?php foreach ($items as $index => $item):
      $is_last = ($index === $last_index);
      ?>

      <li class="flex items-center gap-1">
        <?php if (!$is_last && !empty($item['url'])): ?>
          <a href="<?= esc_url($item['url']) ?>" class="hover:text-primary">
            <?= esc_html($item['label']) ?>
          </a>
        <?php else: ?>
          <span class="font-medium text-on-surface-variant">
            <?= esc_html($item['label']) ?>
          </span>
        <?php endif; ?>

        <?php if (!$is_last): ?>
          <i data-lucide="chevron-right" class="w-3 h-3 text-outline shrink-0" aria-hidden="true"></i>
        <?php endif; ?>
      </li>

    <?php endforeach; ?>
  </ol>
</nav>