<?php
/**
 * Project: Custom Queries
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

  // 1. LIMIT ITEM
  $allowed_limits = [6, 12, 24];
  $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 12;
  $query->set('posts_per_page', in_array($limit, $allowed_limits, true) ? $limit : 12);

  // 2. SORTING
  $sort = sanitize_text_field(wp_unslash($_GET['sort'] ?? 'newest'));
  if ($sort === 'price_asc') {
    $query->set('meta_key', 'price');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
  } elseif ($sort === 'price_desc') {
    $query->set('meta_key', 'price');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'DESC');
  }

  // 3. TAXONOMY FILTER (Category & Brand)
  $tax_query = (array) ($query->get('tax_query') ?: []);

  $selected_cat = sanitize_title(wp_unslash($_GET['category'] ?? ''));
  if ($selected_cat !== '' && !is_tax('product-category')) {
    $tax_query[] = [
      'taxonomy' => 'product-category',
      'field' => 'slug',
      'terms' => $selected_cat,
    ];
  }

  $selected_brand = sanitize_title(wp_unslash($_GET['brand'] ?? ''));
  if ($selected_brand !== '' && !is_tax('product-brand')) {
    $tax_query[] = [
      'taxonomy' => 'product-brand',
      'field' => 'slug',
      'terms' => $selected_brand,
    ];
  }

  if (!empty($tax_query)) {
    $tax_query['relation'] = 'AND';
    $query->set('tax_query', $tax_query);
  }


  $meta_query = (array) ($query->get('meta_query') ?: []);

  $stock = sanitize_text_field(wp_unslash($_GET['stock'] ?? ''));
  if ($stock === 'ready') {
    $meta_query[] = [
      'key' => 'stock_status',
      'value' => 'ready',
      'compare' => '=',
    ];
  }

  if ($stock === 'indent') {
    $meta_query[] = [
      'key' => 'stock_status',
      'value' => 'indent',
      'compare' => '=',
    ];
  }

  if ($stock === 'out_of_stock') {
    $meta_query[] = [
      'key' => 'stock_status',
      'value' => 'out_of_stock',
      'compare' => '=',
    ];
  }

  if (!empty($_GET['on_sale'])) {
    $meta_query[] = [
      'key' => 'discount_rate',
      'value' => 0,
      'type' => 'NUMERIC',
      'compare' => '>',
    ];
  }

  if (!empty($meta_query)) {
    $meta_query['relation'] = 'AND';
    $query->set('meta_query', $meta_query);
  }

});