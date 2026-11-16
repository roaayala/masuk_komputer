<?php

namespace KarsaStart;

class Breadcrumb
{
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
      // add CPT $labels
      $items[] = [
        'label' => $all_label,
        'url' => null,
      ];

      return $items;
    }

    // is taxonomies valid
    if (!empty($taxonomies) && is_tax($taxonomies)) {
      // add CPT $labels
      if ($archive_url) {
        $items[] = [
          'label' => $root_label,
          'url' => $archive_url,
        ];
      }

      // the taxonomy / term object
      $term = get_queried_object();
      if ($term instanceof \WP_Term) {
        // add parent if current term is child
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

        // add current term
        $items[] = [
          'label' => $term->name,
          'url' => null,
        ];
      }
    }

    return $items;
  }

}