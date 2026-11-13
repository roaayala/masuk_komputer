<?php
/**
 * Section: Item tax slider
 * @package KarsaStart
 */

use KarsaStart\Helpers;

$wrapper_classes = $args['wrapper_classes'] ?? 'bg-surface';
$tax = $args['tax'] ?? [];
$title = $args['title'] ?? __('Daftar Tax Item', 'karsa_start');
?>

<?php if (!empty($tax) || !is_wp_error($tax)): ?>
  <section class="py-8 md:py-12  <?= esc_attr($wrapper_classes) ?>">
    <div class="container">
      <div class="flex flex-col gap-6">
        <div>
          <h2>
            <?= esc_html($title) ?>
          </h2>
        </div>

        <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-none">
          <?php foreach ($tax as $term):
            Helpers::component('cards/card-term', [
              'term' => $term
            ]);
          endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif ?>