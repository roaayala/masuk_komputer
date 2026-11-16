<?php

use KarsaStart\ArchiveFilter;

/**
 * Project Hooks
 * @package KarsaStart
 */


if (!defined('ABSPATH')) {
  exit;
}

add_action('pre_get_posts', function (\WP_Query $query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }
  if (!is_post_type_archive('product') && !is_tax(['product-category', 'product-brand'])) {
    return;
  }

  ArchiveFilter::apply($query, [
    'search' => 'q',
    'limits' => [6, 12, 24],
    'taxonomies' => [
      'category' => 'product-category',
      'brand' => 'product-brand',
    ],
    'meta' => [
      'stock' => [
        'key' => 'stock_status',
        'allowed' => ['ready', 'indent', 'out_of_stock'],
      ],
    ],
    'flags' => [
      'on_sale' => [
        'key' => 'discount_rate',
        'value' => 0,
        'compare' => '>',
        'type' => 'NUMERIC',
      ],
    ],
    'sorts' => [
      'price_asc' => ['meta_key' => 'price', 'orderby' => 'meta_value_num', 'order' => 'ASC'],
      'price_desc' => ['meta_key' => 'price', 'orderby' => 'meta_value_num', 'order' => 'DESC'],
    ],
  ]);
});

