<?php
/**
 * View: Root archive
 * @package KarsaStart
 */

use KarsaStart\Helpers;
get_header();

// Archive view here
$is_store_archive = is_post_type_archive('product') || is_tax(['product-brand', 'product-category']);

if ($is_store_archive) {
  Helpers::view('archive-product');
}

get_footer();