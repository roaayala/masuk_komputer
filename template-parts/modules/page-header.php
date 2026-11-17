<?php
use KarsaStart\Helpers;
/**
 * Module: Page header
 * @package KarsaStart
 */

$breadcrumb_items = $args['breadcrumb_items'] ?? [];
$show_breadcrumb = $args['show_breadcrumb'] ?? true;
$title = $args['title'] ?? 'Title';
?>

<header>
  <div class="container">
    <div class="flex flex-col gap-4">
      <?php if ($show_breadcrumb):
        Helpers::component('breadcrumb', ['items' => $breadcrumb_items]);
      endif; ?>

      <div>
        <h1><?= esc_html($title) ?></h1>
      </div>
    </div>
  </div>
</header>