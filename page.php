<?php
/**
 * View: Root page
 * @package KarsaStart
 */

get_header();

// Page View Here 
while (have_posts()):
  the_post();
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class('flex-1 py-8 bg-surface-bright'); ?>>
    <div class="container content-container">
      <div class="flex flex-col gap-8">
        <header class="flex flex-col gap-2">
          <h1>
            <?= esc_html(get_the_title()) ?>
          </h1>

          <div>
            <span class="text-sm text-on-surface-subtle">
              <?= __('Dipublikasikan pada', 'karsa_start') ?>
              <?= esc_html(get_the_date()) ?>
            </span>
          </div>
        </header>

        <?php if (!empty(get_the_content())): ?>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </article>

<?php endwhile;

get_footer();