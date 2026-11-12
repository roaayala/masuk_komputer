<?php

use KarsaStart\Helpers;
/**
 * Template: Root page
 * @package KarsaStart
 */

get_header();

// Page Template Here 
while (have_posts()):
  the_post();

  $slug = get_post_field('post_name', get_post());

  $relative_view_path = "store/page-{$slug}";

  $full_file_path = get_template_directory() . "/template-parts/views/{$relative_view_path}.php";

  if (file_exists($full_file_path)) {
    Helpers::view($relative_view_path);
  } else {
    Helpers::view('store/page-default');
  }

endwhile;

get_footer();