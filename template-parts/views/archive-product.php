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
$current_category = sanitize_title(wp_unslash($_GET['category'] ?? ''));
$current_brand = sanitize_title(wp_unslash($_GET['brand'] ?? ''));
$current_stock = sanitize_text_field(wp_unslash($_GET['stock'] ?? ''));
$is_on_sale = !empty($_GET['on_sale']);

$base_archive_url = strtok(get_pagenum_link(1), '?');

$has_active_filter = ($current_sort !== 'newest')
  || ($current_limit !== 12)
  || ($current_category !== '')
  || ($current_brand !== '')
  || ($current_stock !== '')
  || $is_on_sale;


$category_options = [];
if (!is_tax('product-category')) {
  $terms = get_terms(['taxonomy' => 'product-category', 'hide_empty' => true]);
  if (!is_wp_error($terms)) {
    foreach ($terms as $term) {
      $category_options[$term->slug] = $term->name;
    }
  }
}

$brand_options = [];
if (!is_tax('product-brand')) {
  $terms = get_terms(['taxonomy' => 'product-brand', 'hide_empty' => true]);
  if (!is_wp_error($terms)) {
    foreach ($terms as $term) {
      $brand_options[$term->slug] = $term->name;
    }
  }
}
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
      <!-- Unified Filter, Sort & Limit Form -->
      <form method="get" action="<?= esc_url($base_archive_url); ?>"
        class="flex flex-col gap-4 pb-6 border-b border-outline/20">

        <p class="text-sm text-on-surface-variant mr-2">
          <?= sprintf(
            wp_kses(
              __('Menampilkan <strong class="font-semibold text-on-surface">%d</strong> produk', 'karsa_start'),
              ['strong' => ['class' => []]]
            ),
            $total_products
          ); ?>
        </p>

        <div class="flex flex-wrap items-center gap-4">
          <?php if (!empty($category_options)): ?>
            <?php Helpers::component('select-dropdown', [
              'id' => 'filter-category',
              'name' => 'category',
              'placeholder' => __('Semua Kategori', 'karsa_start'),
              'selected' => $current_category,
              'auto_submit' => true,
              'options' => $category_options,
            ]); ?>
          <?php endif; ?>

          <?php if (!empty($brand_options)): ?>
            <?php Helpers::component('select-dropdown', [
              'id' => 'filter-brand',
              'name' => 'brand',
              'placeholder' => __('Semua Brand', 'karsa_start'),
              'selected' => $current_brand,
              'auto_submit' => true,
              'options' => $brand_options,
            ]); ?>
          <?php endif; ?>

          <?php Helpers::component('select-dropdown', [
            'id' => 'filter-stock',
            'name' => 'stock',
            'placeholder' => __('Semua Status', 'karsa_start'),
            'selected' => $current_stock,
            'auto_submit' => true,
            'options' => [
              'ready' => __('Stok Tersedia', 'karsa_start'),
              'indent' => __('Stok Indent', 'karsa_start'),
              'out_of_stock' => __('Stok Habis', 'karsa_start'),
            ],
          ]); ?>

          <label
            class="inline-flex items-center gap-1.5 text-xs text-on-surface cursor-pointer select-none px-2.5 py-1.5 rounded-md border border-outline/40 bg-surface hover:border-primary/60">
            <input type="checkbox" name="on_sale" value="1" onchange="this.form.submit()"
              <?php checked($is_on_sale, true); ?>
              class="rounded border-outline/40 text-primary focus:ring-primary">
            <span><?= esc_html__('Diskon', 'karsa_start'); ?></span>
          </label>
        </div>

        <div class="flex flex-wrap items-center gap-4">
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
          ]); ?>

          <?php Helpers::component('select-dropdown', [
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
          ]); ?>

          <?php if ($has_active_filter): ?>
            <a href="<?= esc_url($base_archive_url); ?>" class="text-xs font-medium text-primary hover:underline">
              <?= esc_html__('Bersihkan Filter', 'karsa_start'); ?>
            </a>
          <?php endif; ?>
        </div>
      </form>

      <!-- Grid Produk / Empty State -->
      <?php if (have_posts()): ?>
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
        <?php Helpers::component('pagination'); ?>

      <?php else: ?>
        <div
          class="py-16 px-8 text-center bg-surface rounded-lg border border-outline/20 shadow-sm flex flex-col items-center gap-4">
          <p class="text-lg text-on-surface">
            <?= esc_html__('Tidak ada produk yang cocok dengan filter ini.', 'karsa_start'); ?>
          </p>
          <a href="<?= esc_url($base_archive_url); ?>" class="text-xs text-primary hover:underline">
            <?= esc_html__('Reset semua filter', 'karsa_start'); ?>
          </a>
        </div>
      <?php endif; ?>

    </div>
  </section>

</div>