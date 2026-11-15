<?php
/**
 * Component: Pagination
 * @package KarsaStart
 */

$total_pages = (int) ($args['total'] ?? $GLOBALS['wp_query']->max_num_pages ?? 1);
$current_page = (int) ($args['current'] ?? max(1, (int) get_query_var('paged'), (int) get_query_var('page')));
$wrapper_class = $args['wrapper_class'] ?? '';

if ($total_pages <= 1) {
  return;
}

$links = paginate_links([
  'total' => $total_pages,
  'current' => $current_page,
  'type' => 'array',
  'mid_size' => $args['mid_size'] ?? 1,
  'end_size' => $args['end_size'] ?? 1,
  'prev_text' => sprintf(
    '<i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i><span class="sr-only">%s</span>',
    esc_html__('Halaman sebelumnya', 'karsa_start')
  ),
  'next_text' => sprintf(
    '<i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i><span class="sr-only">%s</span>',
    esc_html__('Halaman berikutnya', 'karsa_start')
  ),
]);

if (empty($links)) {
  return;
}

$base_class = 'min-w-8 h-8 px-2 rounded-md inline-flex items-center justify-center text-sm transition-colors';
$default_class = "{$base_class} bg-transparent hover:bg-surface-dim text-on-surface-subtle";
$current_class = "{$base_class} bg-primary font-medium text-on-primary";
$dots_class = 'min-w-8 h-8 px-2 inline-flex items-center justify-center text-sm text-on-surface-subtle';
?>

<nav
  aria-label="<?= esc_attr__('Pagination', 'karsa_start'); ?>"
  class="flex flex-wrap items-center justify-center gap-1.5 <?= esc_attr($wrapper_class); ?>">
  <?php foreach ($links as $link):
    $processor = new \WP_HTML_Tag_Processor($link);

    if ($processor->next_tag()) {
      $target_class = match (true) {
        $processor->has_class('current') => $current_class,
        $processor->has_class('dots') => $dots_class,
        default => $default_class,
      };

      $processor->set_attribute('class', $target_class);
      $link = $processor->get_updated_html();
    }
    ?>
    <?= $link; ?>
  <?php endforeach; ?>
</nav>