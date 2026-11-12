<?php
/**
 * Template: Header for store
 * @package KarsaStart
 */

use KarsaStart\Helpers;
$categories = Helpers::get_active_taxonomy_tree('product-category');
$brands = Helpers::get_active_taxonomy_tree('product-brand');
$nav_items = [
  [
    'type' => 'dropdown',
    'label' => __('Kategori', 'karsa_start'),
    'items' => $categories,
  ],
  [
    'type' => 'dropdown',
    'label' => __('Brand', 'karsa_start'),
    'items' => $brands,
  ],
  [
    'type' => 'link',
    'label' => __('Semua Produk', 'karsa_start'),
    'url' => get_post_type_archive_link('product'),
  ],
  [
    'type' => 'dropdown',
    'label' => __('Tentang Kami', 'karsa_start'),
    'items' => [
      [
        'label' => __('Tentang Kami', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('about-us')),
      ],
      [
        'label' => __('Syarat dan Ketentuan', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('terms-and-conditions')),
      ],
      [
        'label' => __('Kebijakan Privasi', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('privacy-policy')),
      ],
    ],
  ],
];

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

  </div>
</header>