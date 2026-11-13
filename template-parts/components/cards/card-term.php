<?php

/**
 * Component: Card for given term
 * @package KarsaStart
 */


$term = $args['term'] ?? null;

if (!$term)
  return;

$url = get_term_link($term);
$title = $term->name;

if (is_wp_error($url))
  return;
?>

<a href="<?= esc_url($url) ?>" class="group block">
  <div
    class="aspect-video w-40 p-6 bg-surface-bright border border-outline/20 hover:border-primary/40 shadow-sm rounded-lg flex flex-col gap-4 justify-between transition-border duration-150">

    <h3 class="text-base group-hover:text-primary transition-colors">
      <?= esc_html($title) ?>
    </h3>

    <i data-lucide="arrow-right" class="w-4 h-4 text-on-surface self-end"></i>

  </div>
</a>