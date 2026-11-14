<?php
/**
 * View: Root header
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

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="page" class="min-h-screen flex flex-col">

    <!-- Header Template Here -->
    <?php Helpers::view('header', [
      'nav_items' => $nav_items
    ]); ?>

    <main id="content" class="flex-1 flex flex-col">