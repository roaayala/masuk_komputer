<?php
/**
 * View: Product Archive and Taxonomy
 * @package KarsaStart
 */

use KarsaStart\Helpers;

global $wp_query;
$total_products = $wp_query->found_posts;
$current_sort = $_GET['sort'] ?? 'newest';

?>

<div class="flex-1 bg-surface">

  <!-- 1. PAGE HEADER -->
  <?php Helpers::module('headers/page-header', [
    'title' => get_the_archive_title(),
    'subtitle' => wp_strip_all_tags(get_the_archive_description()),
  ]); ?>

  <section class="py-8 md:py-12">
    <div class="container flex flex-col gap-6">

      <!-- 2. TOOLBAR (JUMLAH PRODUK & SORTING) -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-outline/20">
        <p class="text-sm text-on-surface-variant">
          <?= sprintf(
            __('Menampilkan <strong class="text-on-surface">%d</strong> produk', 'karsa_start'),
            $total_products
          ); ?>
        </p>

        <!-- Form Sorting Sederhana (Reload dengan query param ?sort=...) -->
        <form method="get" class="flex items-center gap-2">
          <label for="sort-products" class="text-xs text-on-surface-variant">
            <?= __('Urutkan:', 'karsa_start') ?>
          </label>
          <select id="sort-products" name="sort" onchange="this.form.submit()"
            class="text-sm bg-surface-bright border border-outline/40 rounded-lg px-3 py-1.5 text-on-surface focus:outline-none focus:border-primary">
            <option value="newest" <?php selected($current_sort, 'newest'); ?>>
              <?= __('Terbaru', 'karsa_start') ?>
            </option>
            <option value="price_asc" <?php selected($current_sort, 'price_asc'); ?>>
              <?= __('Harga Terendah', 'karsa_start') ?>
            </option>
            <option value="price_desc" <?php selected($current_sort, 'price_desc'); ?>>
              <?= __('Harga Tertinggi', 'karsa_start') ?>
            </option>
          </select>
        </form>
      </div>

      <!-- 3. PRODUCT GRID (MAIN LOOP) -->
      <?php if (have_posts()): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
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

        <!-- 4. PAGINATION -->
        <div class="pt-6 border-t border-outline/20 flex justify-center">
          <?php
          the_posts_pagination([
            'mid_size' => 2,
            'prev_text' => __('&larr; Sebelumnya', 'karsa_start'),
            'next_text' => __('Berikutnya &rarr;', 'karsa_start'),
          ]);
          ?>
        </div>

      <?php else: ?>
        <!-- EMPTY STATE -->
        <div class="py-16 text-center bg-surface-bright rounded-2xl border border-outline/30 p-6">
          <p class="text-base font-semibold text-on-surface">
            <?= __('Belum ada produk di kategori ini.', 'karsa_start') ?>
          </p>
          <p class="text-sm text-on-surface-variant mt-1 mb-6">
            <?= __('Coba cek kembali nanti atau jelajahi semua katalog produk kami.', 'karsa_start') ?>
          </p>
          <a href="<?= esc_url(get_post_type_archive_link('product')) ?>"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-on-primary text-sm font-medium rounded-lg">
            <?= __('Lihat Semua Produk', 'karsa_start') ?>
          </a>
        </div>
      <?php endif; ?>

    </div>
  </section>
</div>