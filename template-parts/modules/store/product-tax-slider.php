<?php

use KarsaStart\Helpers;

/**
 * Section: Product tax slider
 * @package KarsaStart
 */

$section_classes = $args['section_classes'] ?? 'bg-surface';
$tax = $args['tax'] ?? [];
$title = $args['title'] ?? __('Judul Section', 'karsa_start');
?>

<?php if (!empty($tax)): ?>
  <section class="py-8 md:py-12  <?= esc_attr($section_classes) ?>">
    <div class="container flex flex-col gap-6">
      <div class="">
        <h2><?= esc_html($title) ?></h2>
      </div>

      <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-none">
        <?php foreach ($tax as $term):

          Helpers::component('cards/card-term', [
            'term' => $term
          ]);

        endforeach; ?>
      </div>

    </div>
  </section>
<?php endif ?>