<?php

/**
 * Template: Single
 * @package KarsaStart
 */

use KarsaStart\Breadcrumb;
use KarsaStart\Format;
use KarsaStart\Helpers;

$product_id = get_the_ID();

// price and discount
$initial_price = (int) get_field('price', $product_id);
$discount_rate = (int) get_field('discount_rate', $product_id);
$has_discount = $initial_price > 0 && $discount_rate > 0;
$price = $has_discount
  ? $initial_price - ($initial_price * ($discount_rate / 100))
  : $initial_price;

// gallery
$gallery_images = [];
$gallery_field = get_field('gallery', $product_id);
if (!empty($gallery_field)) {
  foreach ($gallery_field as $image) {
    $id = $image['attachment']->ID;
    $url = wp_get_attachment_image_url($id, 'large');

    $gallery_images[] = [
      'url' => $url,
      'alt' => get_the_title($product_id)
    ];
  }
}

// WA
$wa_url = '#';
$raw_wa = get_field('wa_number', $product_id);
$wa_number = preg_replace('/\D+/', '', (string) $raw_wa);

if ($wa_number !== '') {
  if (str_starts_with($wa_number, '0')) {
    $wa_number = '62' . substr($wa_number, 1);
  }

  $wa_text = sprintf(
    "Halo, saya tertarik dengan produk *%s*.\n%s",
    get_the_title($product_id),
    get_permalink($product_id)
  );
  $wa_url = 'https://wa.me/' . $wa_number . '?text=' . rawurlencode($wa_text);
}

// marketplaces
$marketplaces = [
  'shopee' => ['label' => 'Shopee', 'url' => get_field('shopee_link', $product_id)],
  'tokopedia' => ['label' => 'Tokopedia', 'url' => get_field('tokopedia_link', $product_id)],
  'blibli' => ['label' => 'Blibli', 'url' => get_field('blibli_link', $product_id)],
  'lazada' => ['label' => 'Lazada', 'url' => get_field('lazada_link', $product_id)],
];

?>

<?php get_header(); ?>

<!-- Single Template Here -->
<article id="post-<?php the_ID(); ?>" <?php post_class('flex-1 py-8 md:py-12 bg-surface-bright'); ?>>
  <div class="container flex flex-col gap-8">
    <!-- Breadcrumb -->
    <?php Helpers::component('breadcrumb', [
      'items' => Breadcrumb::single(
        'product',
        'product-category',
        __('Produk', 'karsa_start')
      ),
      'title' => get_the_title()
    ]) ?>

    <!-- Main Layout: Gallery + Product Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-8">
      <!-- Gallery -->
      <section class="grid gap-4 rounded-lg overflow-hidden">
        <?php foreach ($gallery_images as $image): ?>
          <img class="w-full aspect-video object-contain" src="<?= esc_url($image['url']) ?>"
            alt="<?= esc_attr($image['alt']) ?>">
        <?php endforeach ?>
      </section>

      <!-- Title & Actions -->
      <section class="flex flex-col gap-6 lg:sticky lg:top-24">
        <div class="flex flex-col gap-2">
          <h1 class="text-lg"><?= esc_html(get_the_title($product_id)) ?></h1>

          <div class="flex flex-col">
            <?php if ($discount_rate > 0): ?>
              <span class="font-normal text-xs text-on-surface-variant line-through">
                <?= esc_html(Format::rupiah($initial_price)) ?>
              </span>
              <span class="font-semibold text-lg text-primary">
                <?= esc_html(Format::rupiah($price)) ?>
              </span>
            <?php else: ?>
              <span class="font-semibold text-lg text-primary">
                <?= esc_html(Format::rupiah($price)) ?>
              </span>
            <?php endif ?>
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <div>
            <a href="<?= esc_url($wa_url) ?>" target="_blank" class="btn btn--primary">
              <i data-lucide="phone" class="icon"></i>
              <span class="label">
                <?php _e('Hubungi kami', 'karsa_start') ?>
              </span>
            </a>
          </div>

          <div class="flex flex-wrap gap-2 items-center">
            <?php foreach ($marketplaces as $slug => $mp): ?>
              <a class="btn btn--neutral btn--outline" href="<?= esc_url($mp['url']) ?>" target="_blank"
                rel="noopener noreferrer"
                aria-label="<?= esc_attr($mp['label']) ?>">
                <?= Helpers::get_icon($slug, 'h-4 w-auto') ?>
              </a>
            <?php endforeach ?>
          </div>
        </div>
      </section>
    </div>
  </div>
</article>

<?php get_footer(); ?>