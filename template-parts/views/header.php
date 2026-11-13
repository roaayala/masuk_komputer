<?php
/**
 * View: Header
 * @package KarsaStart
 */

use KarsaStart\Helpers;
$nav_items = $args['nav_items'] ?? [];

?>

<header id="header" class="sticky top-0 z-40 bg-surface border-b border-outline/40 shadow-sm py-4">
  <div class="container relative flex items-center justify-between gap-4">

    <!-- LOGO AND SITE NAME -->
    <a href="<?= esc_url(home_url()) ?>" class="flex items-center gap-2">
      <span class="aspect-square p-1.5 font-bold text-xs/none bg-primary text-on-primary rounded-lg flex items-center">
        MK
      </span>
      <span class="font-semibold text-base text-on-surface">
        <?php bloginfo('name'); ?>
      </span>
    </a>

    <?php if (!empty($nav_items)): ?>
      <!-- Desktop navigation -->
      <nav class="hidden md:flex">
        <?php Helpers::component('nav/menu-list', [
          'items' => $nav_items,
          'is_mobile' => false,
        ]); ?>
      </nav>

      <!-- Mobile navigation -->
      <div x-data="{ open: false }" class="flex items-center md:hidden">

        <button @click="open = !open" type="button" class="cursor-pointer text-on-surface" aria-label="Toggle menu">
          <i x-show="!open" data-lucide="menu" class="w-5 h-5"></i>
          <i x-show="open" x-cloak data-lucide="x" class="w-5 h-5"></i>
        </button>

        <nav x-show="open" x-cloak @click.outside="open = false"
          class="absolute top-full left-4 sm:left-8 right-4 sm:right-8 mt-2 bg-surface-bright p-6 border border-outline/40 rounded-lg shadow-lg z-50 flex flex-col max-h-[80vh] overflow-y-auto">

          <?php Helpers::component('nav/menu-list', [
            'items' => $nav_items,
            'is_mobile' => true,
          ]); ?>

        </nav>
      </div>

    <?php endif ?>
  </div>
</header>