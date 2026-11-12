<?php

use KarsaStart\Helpers;

/**
 * View: Page default for store
 * @package KarsaStart
 */

$has_content = !empty(get_the_content());
$title = $args['title'] ?? get_the_title();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('flex-1 py-8 bg-surface-bright'); ?>>
  <div class="container content-container flex flex-col gap-8">

    <!-- Page Header -->
    <?php Helpers::module('headers/page-header', [
      'title' => $title,
      'show_meta' => true
    ]) ?>

    <!-- Page Content (Gutenberg Output) -->

    <?php if ($has_content): ?>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    <?php endif; ?>
  </div>
</article>