<?php

use KarsaStart\Helpers;
/**
 * View: Root page
 * @package KarsaStart
 */

get_header();

// Page View Here 
while (have_posts()):
  the_post();

  $slug = get_post_field('post_name', get_post());
  $title = get_the_title();
  $has_content = !empty(get_the_content());

  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class('flex-1 py-8 bg-surface-bright'); ?>>
    <div class="container">
      <div class="flex flex-col gap-8">
        <header class="flex flex-col gap-2">
          <h1>
            <?= esc_html($title) ?>
          </h1>

          <div>
            <span class="text-sm text-on-surface-subtle">
              <?= _e('Dipublikasikan pada', 'karsa_start') ?>
              <?= get_the_date() ?>
            </span>
          </div>
        </header>

        <?php if ($has_content): ?>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </article>

<?php endwhile;

get_footer();