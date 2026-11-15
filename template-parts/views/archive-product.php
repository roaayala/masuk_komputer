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

        <form method="get" action="<?= esc_url($base_archive_url); ?>" class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <label for="sort-products" class="text-xs text-on-surface-subtle">
              <?= esc_html__('Tampilkan:', 'karsa_start'); ?>
            </label>

            <div class="relative inline-flex items-center">
              <select id="limit-products" name="limit" onchange="this.form.submit()"
                class="appearance-none text-xs bg-surface border border-outline/40 rounded-md pl-2 pr-6 py-1 text-on-surface focus:outline-none focus:border-primary cursor-pointer">
                <?php foreach ($allowed_limits as $limit_option): ?>
                  <option value="<?= esc_attr($limit_option); ?>" <?php selected($current_limit, $limit_option); ?>>
                    <?= esc_html($limit_option); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <i data-lucide="chevron-down" class="w-4 h-4 text-on-surface-subtle absolute right-2 pointer-events-none"
                aria-hidden="true"></i>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <label for="sort-products" class="text-xs text-on-surface-subtle">
              <?= esc_html__('Urutkan:', 'karsa_start'); ?>
            </label>

            <div class="relative inline-flex items-center">
              <select id="sort-products" name="sort" onchange="this.form.submit()"
                class="appearance-none text-xs bg-surface border border-outline/40 rounded-md pl-2 pr-6 py-1 text-on-surface focus:outline-none focus:border-primary cursor-pointer">
                <option value="newest" <?php selected($current_sort, 'newest'); ?>>
                  <?= esc_html__('Terbaru', 'karsa_start'); ?>
                </option>
                <option value="price_asc" <?php selected($current_sort, 'price_asc'); ?>>
                  <?= esc_html__('Harga Terendah', 'karsa_start'); ?>
                </option>
                <option value="price_desc" <?php selected($current_sort, 'price_desc'); ?>>
                  <?= esc_html__('Harga Tertinggi', 'karsa_start'); ?>
                </option>
              </select>

              <i data-lucide="chevron-down" class="w-4 h-4 text-on-surface-subtle absolute right-2 pointer-events-none"
                aria-hidden="true"></i>
            </div>

          </div>
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
      <?php
      $pagination_links = paginate_links([
        'type' => 'array',
        'mid_size' => 1,
        'prev_text' => '<i data-lucide="chevron-left" class="w-4 h-4"></i><span class="sr-only">' . esc_html__('Sebelumnya', 'karsa_start') . '</span>',
        'next_text' => '<i data-lucide="chevron-right" class="w-4 h-4"></i><span class="sr-only">' . esc_html__('Berikutnya', 'karsa_start') . '</span>',
      ]);
      ?>

      <?php if (!empty($pagination_links)): ?>
        <nav aria-label="<?= esc_attr__('Navigasi halaman produk', 'karsa_start'); ?>"
          class="pt-6 border-t border-outline/20 flex justify-center">
          <ul class="flex flex-wrap items-center gap-1.5">
            <?php foreach ($pagination_links as $link): ?>
              <?php
              $styled_link = str_replace(
                ['page-numbers current', 'page-numbers dots', 'page-numbers'],
                [
                  'inline-flex items-center justify-center min-w-9 h-9 px-3 rounded-lg text-xs font-semibold bg-primary text-on-primary',
                  'inline-flex items-center justify-center min-w-9 h-9 px-2 text-xs text-on-surface-subtle',
                  'inline-flex items-center justify-center min-w-9 h-9 px-3 rounded-lg text-xs font-medium bg-surface border border-outline/20 text-on-surface hover:border-primary/40 hover:text-primary transition-colors',
                ],
                $link
              );
              ?>
              <li><?= $styled_link; ?></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </section>




</div>