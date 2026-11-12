<?php
/**
 * Component: Menu list
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$items = $args['items'] ?? [];
$is_mobile = $args['is_mobile'] ?? false;

if (empty($items)) {
  return;
}
?>

<div class="<?= $is_mobile ? 'flex flex-col gap-6' : 'flex flex-row items-center gap-4' ?>">
  <?php foreach ($items as $item): ?>

    <?php if ($item['type'] === 'dropdown'): ?>
      <?php
      $dropdown_component = $is_mobile ? 'nav/menu-dropdown-mobile' : 'nav/menu-dropdown-desktop';
      $normalized_sub_items = Helpers::normalize_menu_items($item['items'] ?? []);

      Helpers::component($dropdown_component, [
        'items' => $normalized_sub_items,
        'label' => $item['label'],
      ]);
      ?>

    <?php elseif ($item['type'] === 'link'): ?>
      <div>
        <?php Helpers::component('nav/menu-link', [
          'url' => $item['url'],
          'label' => $item['label'],
        ]); ?>
      </div>
    <?php endif; ?>

  <?php endforeach; ?>
</div>