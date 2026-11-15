<?php
/**
 * View: Product Archive and Taxonomy
 * @package KarsaStart
 */

use KarsaStart\Helpers;

global $wp_query;
$total_products = $wp_query->found_posts;
$allowed_limits = [6, 12, 24];
$raw_limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 12;
$current_limit = in_array($raw_limit, $allowed_limits, true) ? $raw_limit : 12;
$current_sort = sanitize_text_field(wp_unslash($_GET['sort'] ?? 'newest'));
$base_archive_url = strtok(get_pagenum_link(1), '?');

$has_active_filter = ($current_sort !== 'newest') || ($current_limit !== 12);
?>
<div class="flex-1 py-8 md:py-12 bg-surface-bright flex flex-col gap-8">
  <!-- PAGE HEADER -->
  <?php
  $title = '';

  if (is_post_type_archive('product')) {
    $title = __('Semua produk', 'karsa_start');
  } elseif (is_tax('product-category')) {
    $title = sprintf(__('Semua %s', 'karsa_start'), mb_strtolower(single_term_title('', false)));
  } elseif (is_tax('product-brand')) {
    $title = sprintf(__('Semua %s', 'karsa_start'), single_term_title('', false));
  }

  Helpers::module('page-header', [
    'breadcrumb_items' => Helpers::get_archive_breadcrumb_items(
      'product',
      ['product-category', 'product-brand'],
      [
        'root' => __('Produk', 'karsa_start'),
        'all' => __('Semua produk', 'karsa_start'),
      ]
    ),
    'title' => $title
  ]);
  ?>

  <!-- PRODUCT GRID -->
  <section>
    <div class="container flex flex-col gap-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-outline/20">
        <p class="text-sm text-on-surface-variant">
          <?= sprintf(
            wp_kses(__('Menampilkan <strong class="font-semibold text-on-surface">%d</strong> produk', 'karsa_start'), ''),
            $total_products
          ); ?>
        </p>

        <form method="get" action="<?= esc_url($base_archive_url); ?>" class="flex flex-wrap items-center gap-4">

          <?php Helpers::component('select-dropdown', [
            'id' => 'limit-products',
            'name' => 'limit',
            'label' => __('Tampilkan:', 'karsa_start'),
            'selected' => $current_limit,
            'auto_submit' => true,
            'options' => [
              '6' => '6',
              '12' => '12',
              '24' => '24',
            ],
          ]);

          Helpers::component('select-dropdown', [
            'id' => 'sort-products',
            'name' => 'sort',
            'label' => __('Urutkan:', 'karsa_start'),
            'selected' => $current_sort,
            'auto_submit' => true,
            'options' => [
              'newest' => __('Terbaru', 'karsa_start'),
              'price_asc' => __('Harga Terendah', 'karsa_start'),
              'price_desc' => __('Harga Tertinggi', 'karsa_start'),
            ],
          ]);
          ?>

          <?php if ($has_active_filter): ?>
            <a href=<?= esc_url($base_archive_url); ?>" class="text-xs text-on-surface-subtle hover:text-primary">
              <?= esc_html__('Bersihkan Filter', 'karsa_start'); ?>
            </a>
          <?php endif ?>
        </form>
      </div>

      <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php while (have_posts()):
          the_post(); ?>

          <?php
          Helpers::component('cards/card-product', [
            'name' => get_the_title(),
            'url' => get_the_permalink(),
            'image_url' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            'discount_rate' => get_field('discount_rate'),
            'price' => get_field('price'),
            'brands' => get_the_terms(get_the_ID(), 'product-brand'),
            'categories' => get_the_terms(get_the_ID(), 'product-category'),
            'stock_status' => get_field('stock_status'),
            'tokopedia_link' => get_field('tokopedia_link'),
            'shopee_link' => get_field('shopee_link'),
            'lazada_link' => get_field('lazada_link'),
            'blibli_link' => get_field('blibli_link'),
          ]);
          ?>
        <?php endwhile; ?>
      </div>

      <!-- Pagination -->
      <?php Helpers::component('pagination') ?>

    </div>
  </section>




</div>