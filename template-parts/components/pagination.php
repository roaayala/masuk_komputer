<?php
/**
 * Component: Pagination
 * 
 * @package KarsaStart
 */

$total_pages = $args['total'] ?? $GLOBALS['wp_query']->max_num_pages ?? 1;
$current_page = $args['current'] ?? max(1, get_query_var('paged'));

if ($total_pages <= 1) {
  return;
}

$links = paginate_links([
  'total' => $total_pages,
  'current' => $current_page,
  'type' => 'array',
  'format' => '?paged=%#%',
  'prev_text' => sprintf(
    '<i data-lucide="move-left" class="w-4 h-4 shrink-0 leading-none"></i><span class="hidden sm:inline leading-none">%s</span>',
    __('Kembali', 'karsa_start')
  ),
  'next_text' => sprintf(
    '<span class="hidden sm:inline leading-none">%s</span><i data-lucide="move-right" class="w-4 h-4 shrink-0 leading-none"></i>',
    __('Selanjutnya', 'karsa_start')
  ),
]);

if (empty($links)) {
  return;
}


$prev_link_class = 'inline-flex items-center justify-end gap-4 min-w-28 text-base text-on-surface hover:text-primary transition-colors';
$next_link_class = 'inline-flex items-center justify-start gap-4 min-w-28 text-base text-on-surface hover:text-primary transition-colors';
$current_page_class = 'inline-flex items-center justify-center h-8 w-8 rounded-lg text-base font-semibold bg-primary text-on-primary';
$dots_class = 'inline-flex items-center justify-center text-base text-on-surface-subtle';
$page_numbers_class = 'inline-flex items-center justify-center h-8 w-8 rounded-lg text-base text-on-surface hover:bg-surface-container transition-colors';
?>

<nav class="flex items-center justify-center gap-2" aria-label="<?php esc_attr_e('Pagination', 'karsa_start'); ?>">
  <?php foreach ($links as $link): ?>
    <?php
    $styled_link = match (true) {
      // 1. PREV LINK
      str_contains($link, 'prev') => str_replace(
        'class="prev page-numbers"',
        "class=\"{$prev_link_class}\"",
        $link
      ),
      // 2. NEXT LINK 
      str_contains($link, 'next') => str_replace(
        'class="next page-numbers"',
        "class=\"{$next_link_class}\"",
        $link
      ),
      // 3. CURRENT PAGE
      str_contains($link, 'current') => str_replace(
        'class="page-numbers current"',
        "class=\"{$current_page_class}\"",
        $link
      ),
      // 4. DOTS (...)
      str_contains($link, 'dots') => str_replace(
        'class="page-numbers dots"',
        "class=\"{$dots_class}\"",
        $link
      ),
      // 5. REGULAR PAGE NUMBERS
      default => str_replace(
        'class="page-numbers"',
        "class=\"{$page_numbers_class}\"",
        $link
      ),
    };
    ?>
    <?= $styled_link; ?>
  <?php endforeach; ?>
</nav>