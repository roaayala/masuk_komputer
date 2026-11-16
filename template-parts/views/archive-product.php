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

$current_search = sanitize_text_field(wp_unslash($_GET['q'] ?? ''));
$current_sort = sanitize_text_field(wp_unslash($_GET['sort'] ?? 'newest'));
$current_category = sanitize_title(wp_unslash($_GET['category'] ?? ''));
$current_brand = sanitize_title(wp_unslash($_GET['brand'] ?? ''));
$current_stock = sanitize_text_field(wp_unslash($_GET['stock'] ?? ''));
$is_on_sale = !empty($_GET['on_sale']);

$base_archive_url = strtok(get_pagenum_link(1), '?');

$category_options = Helpers::get_term_options('product-category');
$brand_options = Helpers::get_term_options('product-brand');

// Toolbar
$has_toolbar_filter = ($current_sort !== 'newest') || ($current_limit !== 12);
$reset_toolbar_url = Helpers::get_reset_url(['limit', 'sort'], $base_archive_url);

// Filter
$has_product_filter = ($current_search !== '')
  || ($current_category !== '')
  || ($current_brand !== '')
  || ($current_stock !== '')
  || $is_on_sale;

$reset_product_url = Helpers::get_reset_url(['q', 'category', 'brand', 'stock', 'on_sale'], $base_archive_url);

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
    <div class="container flex flex-col gap-6">
      <!-- Archive Toolbar -->
      <form method="get" action="<?= esc_url($base_archive_url); ?>"
        class="flex flex-col gap-6">

        <?php Helpers::render_hidden_query_inputs(['limit', 'sort']); ?>

        <?php Helpers::module('archive-toolbar', [
          'total' => $total_products,
          'item_label' => 'produk',
          'reset_url' => $has_toolbar_filter ? $reset_toolbar_url : '',
          'limit' => [
            'id' => 'limit-products',
            'selected' => $current_limit,
            'options' => [
              '6' => '6',
              '12' => '12',
              '24' => '24',
            ],
          ],
          'sort' => [
            'id' => 'sort-products',
            'selected' => $current_sort,
            'options' => [
              'newest' => __('Terbaru', 'karsa_start'),
              'price_asc' => __('Harga Terendah', 'karsa_start'),
              'price_desc' => __('Harga Tertinggi', 'karsa_start'),
            ],
          ],
        ]) ?>

      </form>


      <div class="flex flex-col items-start md:flex-row gap-8">
        <!-- Archive Filter -->
        <form method="get" action="<?= esc_url($base_archive_url); ?>"
          class="md:max-w-60 flex flex-col self-start md:sticky md:top-24 gap-4 bg-surface-bright rounded-lg">

          <h2 class="text-xl"><?= __('Cari berdasarkan') ?></h2>

          <?php Helpers::render_hidden_query_inputs(['q', 'category', 'brand', 'stock', 'on_sale']); ?>

          <?php Helpers::module('archive-filter', [
            'reset_url' => $has_product_filter ? $reset_product_url : '',
            'search' => [
              'name' => 'q',
              'value' => $current_search,
              'placeholder' => __('Cari nama produk...', 'karsa_start'),
            ],
            'dropdowns' => [
              [
                'id' => 'filter-category',
                'name' => 'category',
                'placeholder' => __('Semua Kategori', 'karsa_start'),
                'selected' => $current_category,
                'options' => $category_options,
              ],
              [
                'id' => 'filter-brand',
                'name' => 'brand',
                'placeholder' => __('Semua Brand', 'karsa_start'),
                'selected' => $current_brand,
                'options' => $brand_options,
              ],
              [
                'id' => 'filter-stock',
                'name' => 'stock',
                'placeholder' => __('Semua Status', 'karsa_start'),
                'selected' => $current_stock,
                'options' => [
                  'ready' => __('Tersedia', 'karsa_start'),
                  'indent' => __('Indent', 'karsa_start'),
                  'out_of_stock' => __('Habis', 'karsa_start'),
                ],
              ],
            ],
            'checkboxes' => [
              [
                'name' => 'on_sale',
                'label' => __('Diskon', 'karsa_start'),
                'checked' => $is_on_sale,
              ],
            ],
          ]);
          ?>

        </form>

        <!-- Empty State -->
        <?php if (have_posts()): ?>
          <div class="flex-1 flex flex-col gap-8">
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
          </div>
        <?php else: ?>
          <div
            class="flex-1 py-16 px-8 text-center bg-surface rounded-lg border border-outline/20 shadow-sm flex flex-col items-center gap-4">
            <p class="text-lg text-on-surface">
              <?= esc_html__('Tidak ada produk yang cocok dengan filter ini.', 'karsa_start'); ?>
            </p>
            <a href="<?= esc_url($base_archive_url); ?>" class="text-xs text-primary hover:underline">
              <?= esc_html__('Reset semua filter', 'karsa_start'); ?>
            </a>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>

</div>