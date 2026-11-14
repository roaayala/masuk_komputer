<?php
use KarsaStart\Helpers;
/**
 * Module: Page header
 * @package KarsaStart
 */

$breadcrumb_items = $args['breadchumb_items'] ?? [];
$title = $args['title'] ?? 'Title';
?>

<header>
  <div class="container">
    <div class="flex flex-col gap-2">
      <?php if (!empty($breadcrumb_items)):
        Helpers::component('breadchumb', ['items' => $breadcrumb_items]);
      endif; ?>

      <div>
        <h1> <?= esc_html($title) ?></h1>
      </div>
    </div>
  </div>
</header>