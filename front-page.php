<?php
/**
 * Template: Root Front Page
 * @package KarsaStart
 */

use KarsaStart\Helpers;

?>

<?php get_header(); ?>

<!-- Front Page Template Here -->
<?php
$hero_slides = [
  [
    'title' => __('Promo Perakitan PC & Hardware', 'karsa_start'),
    'subtitle' => __('Dapatkan penawaran harga terbaik untuk racikan PC impianmu bulan ini.', 'karsa_start'),
    'badge' => __('Promo Spesial', 'karsa_start'),
    'button_text' => __('Lihat Produk Promo', 'karsa_start'),
    'button_url' => get_post_type_archive_link('product') ?: '#',
  ],
  [
    'title' => __('Ready Stock Komponen Terbaru', 'karsa_start'),
    'subtitle' => __('Processor, Motherboard, dan VGA card performa tinggi garansi resmi.', 'karsa_start'),
    'badge' => __('Stok Baru', 'karsa_start'),
    'button_text' => __('Jelajahi Katalog', 'karsa_start'),
    'button_url' => get_post_type_archive_link('product') ?: '#',
  ],
];

// Query Args: Products
$products_args = [
  'post_type' => 'product',
  'posts_per_page' => 6,
  'post_status' => 'publish',
  'orderby' => 'date',
  'order' => 'DESC',
  'meta_query' => [
    [
      'key' => 'stock_status',
      'value' => 'ready',
      'compare' => '='
    ]
  ]
];

// Query Args: Discounted products
$discount_products_args = $products_args;
$discount_products_args['meta_query'] = [
  'relation' => 'AND',
  [
    'key' => 'discount_rate',
    'type' => 'NUMERIC',
    'value' => 0,
    'compare' => '>'
  ],
  [
    'key' => 'stock_status',
    'value' => 'ready',
    'compare' => '='
  ]
];

// Tax Terms
$product_categories = get_terms([
  'taxonomy' => 'product-category',
  'hide_empty' => true,
  'parent' => 0,
  'orderby' => 'name',
  'order' => 'ASC',
]);

$product_brands = get_terms([
  'taxonomy' => 'product-brand',
  'hide_empty' => true,
  'parent' => 0,
  'orderby' => 'name',
  'order' => 'ASC',
]);

$featured_categories = !is_wp_error($product_categories) ? array_slice($product_categories, 0, 3) : [];

// MODULES LIST
// 1. HERO BANNER
Helpers::module('hero-banner', [

]);

// 2. CATEGORIES TAXONOMY SLIDER
Helpers::module('store/product-tax-slider', [
  'section_classes' => 'bg-surface-bright',
  'tax' => $product_categories,
  'title' => __('Cari berdasarkan kategori!', 'karsa_start')
]);


// 3. DISCOUNTED PRODUCTS SLIDER
$discount_products = new WP_Query($discount_products_args);
Helpers::module('store/product-slider', [
  'section_classes' => 'bg-surface',
  'title' => __('Lagi diskon!', 'karsa_start'),
  'url_link' => get_post_type_archive_link('product') ?: '#',
  'url_label' => __('Lebih Banyak', 'karsa_start'),
  'products' => $discount_products
]);
wp_reset_postdata();

// 4. NEWEST PRODUCTS SLIDER
$newest_products = new WP_Query($products_args);
Helpers::module('store/product-slider', [
  'section_classes' => 'bg-surface-bright',
  'title' => __('Baru banget di toko!', 'karsa_start'),
  'url_link' => get_post_type_archive_link('product') ?: '#',
  'url_label' => __('Lebih Banyak', 'karsa_start'),
  'products' => $newest_products
]);
wp_reset_postdata();

// 5. BRANDS TAXONOMY SLIDER
Helpers::module('store/product-tax-slider', [
  'section_classes' => 'bg-surface',
  'tax' => $product_brands,
  'title' => __('Cari berdasarkan brand!', 'karsa_start')
]);

// 6. FEATURED CATEGORIES LOOP
foreach ($featured_categories as $index => $category) {
  $product_in_category_args = $products_args;
  $product_in_category_args['tax_query'] = [
    [
      'taxonomy' => 'product-category',
      'field' => 'term_id',
      'terms' => $category->term_id,
    ]
  ];
  $product_in_category = new WP_Query($product_in_category_args);

  // Alternating background color based on index
  $bg_class = ($index % 2 === 0) ? 'bg-surface-bright' : 'bg-surface';

  Helpers::module('store/product-slider', [
    'section_classes' => $bg_class,
    'title' => sprintf(__('Terbaru di %s', 'karsa_start'), $category->name),
    'url_link' => get_term_link($category),
    'url_label' => __('Lebih Banyak', 'karsa_start'),
    'products' => $product_in_category
  ]);

  wp_reset_postdata();
}

// 7. CTA MARKETPLACES
Helpers::module('store/marketplace-cta', [
  'title' => __('Kami juga ada di marketplace favorit kamu!', 'karsa_start'),
  'section_classes' => 'bg-surface-bright border-t border-outline/20'
]);
?>

<?php get_footer(); ?>