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

  if (is_post_type_archive('product') || is_tax(['product-category', 'product-brand'])) {
    $allowed_limits = [6, 12, 24];
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 12;
    $query->set('posts_per_page', in_array($limit, $allowed_limits, true) ? $limit : 12);

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
  }
});