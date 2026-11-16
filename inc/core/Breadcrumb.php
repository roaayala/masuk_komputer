<?php

namespace KarsaStart;

class Breadcrumb
{
  // append term ancestors and the term itself into $items
  private static function append_term_hierarchy(array &$items, \WP_Term $term, bool $link_self = false): void
  {
    if ($term->parent !== 0) {
      $ancestors = array_reverse(get_ancestors($term->term_id, $term->taxonomy, 'taxonomy'));

      foreach ($ancestors as $ancestor_id) {
        $ancestor = get_term($ancestor_id, $term->taxonomy);
        if ($ancestor instanceof \WP_Term && !is_wp_error($ancestor)) {
          $ancestor_link = get_term_link($ancestor);
          $items[] = [
            'label' => $ancestor->name,
            'url' => !is_wp_error($ancestor_link) ? $ancestor_link : null,
          ];
        }
      }
    }

    $term_url = null;
    if ($link_self) {
      $term_link = get_term_link($term);
      $term_url = !is_wp_error($term_link) ? $term_link : null;
    }

    $items[] = [
      'label' => $term->name,
      'url' => $term_url,
    ];
  }

  // compose breadcrumb items for an CPT archive page
  public static function archive(
    string $post_type, // CPT: 'product'
    array $taxonomies = [], // Taxonomies: ['brand', 'category']
    array $labels = [] // Labels: ['root' => 'Product', 'all' => 'All Product']
  ): array {

    $items = [];
    $post_type_obj = get_post_type_object($post_type); // is valid CPT
    $archive_url = get_post_type_archive_link($post_type) ?: null; // return the CPT's url

    // $labels format
    $root_label = $labels['root'] ?? ($post_type_obj->labels?->name ?? ucfirst($post_type));
    $all_label = $labels['all'] ?? sprintf(__('Semua %s', 'karsa_start'), mb_strtolower($root_label));

    // is current page is desired CPT
    if (is_post_type_archive($post_type)) {
      $items[] = [
        'label' => $all_label,
        'url' => null,
      ];

      return $items;
    }

    // is current page a valid taxonomy archive
    if (!empty($taxonomies) && is_tax($taxonomies)) {
      if ($archive_url) {
        $items[] = [
          'label' => $root_label,
          'url' => $archive_url,
        ];
      }

      // the taxonomy / term object
      $term = get_queried_object();
      if ($term instanceof \WP_Term) {
        self::append_term_hierarchy($items, $term, false);
      }
    }

    return $items;
  }

  // compose breadcrumb items for an CPT single page
  public static function single(
    string $post_type, // CPT: 'product'
    string $taxonomy = '', // Primary taxonomy: 'product-category'
    string|array $labels = '' // Label string 'Produk' or ['root' => 'Produk']
  ): array {
    $items = [];
    $post_type_obj = get_post_type_object($post_type);
    $archive_url = get_post_type_archive_link($post_type) ?: null;

    // resolve root label (supports both string and ['root' => '...'] like archive)
    $custom_root = is_array($labels) ? ($labels['root'] ?? '') : $labels;
    $root_label = $custom_root !== '' ? $custom_root : ($post_type_obj->labels?->name ?? ucfirst($post_type));

    if (!is_singular($post_type)) {
      return $items;
    }

    // add CPT archive root
    if ($archive_url) {
      $items[] = [
        'label' => $root_label,
        'url' => $archive_url,
      ];
    }

    // add primary taxonomy hierarchy (parent -> child)
    if ($taxonomy !== '') {
      $terms = get_the_terms(get_the_ID() ?: 0, $taxonomy);
      if (!empty($terms) && !is_wp_error($terms)) {
        // prioritize deepest child term so full hierarchy is displayed
        usort($terms, fn($a, $b) => $b->parent <=> $a->parent);
        $primary_term = $terms[0];

        if ($primary_term instanceof \WP_Term) {
          self::append_term_hierarchy($items, $primary_term, true);
        }
      }
    }

    // add current post title
    $items[] = [
      'label' => get_the_title(),
      'url' => null,
    ];

    return $items;
  }

}