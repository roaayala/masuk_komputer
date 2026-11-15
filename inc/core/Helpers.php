<?php
namespace KarsaStart;

class Helpers
{
  public static function format_rupiah($price): string
  {
    if (empty($price) || !is_numeric($price)) {
      return 'Hubungi Kami';
    }

    $price = (float) $price;

    return 'Rp' . number_format($price, 0, ',', '.');
  }

  public static function get_icon(string $name, string $class = ''): string
  {

    $path = get_theme_file_path("public/icons/{$name}.svg");


    if (!file_exists($path)) {
      return '';
    }

    $svg = file_get_contents($path);

    if (!empty($class)) {
      $svg = preg_replace('/<svg /', '<svg class="' . esc_attr($class) . '" ', $svg, 1);
    }

    return $svg;
  }

  public static function get_image_placeholder_url(string $name): string
  {
    if (!isset($name))
      return '';

    return get_theme_file_uri("public/images/{$name}.png");
  }

  private static function render(string $path, array $args = []): void
  {
    $clean_path = ltrim($path, '/');
    get_template_part("template-parts/{$clean_path}", null, $args);
  }

  public static function component(string $name, array $args = []): void
  {
    self::render("components/{$name}", $args);
  }

  public static function module(string $name, array $args = []): void
  {
    self::render("modules/{$name}", $args);
  }

  public static function view(string $name, array $args = []): void
  {
    self::render("views/{$name}", $args);
  }

  public static function get_active_taxonomy_tree(string $taxonomy): array
  {
    // get all taxonomy that already have posts
    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
      'orderby' => 'name',
      'order' => 'ASC',
    ]);

    if (is_wp_error($terms) || empty($terms)) {
      return [];
    }

    $indexed = [];

    foreach ($terms as $term) {
      $term->children = []; // add blank children array
      $indexed[$term->term_id] = $term; // register each term to $indexed and use the term_id as key
    }

    $tree = [];

    foreach ($indexed as $term) {
      if ($term->parent != 0 && isset($indexed[$term->parent])) {
        $indexed[$term->parent]->children[] = $term; // add term to it respective parent
      } else {
        $tree[] = $term; // if parent, then set is as a root
      }
    }

    return $tree;

  }

  /**
   * Normalisasi item navigasi (WP_Term, WP_Post, atau Array) 
   * menjadi struktur terstandarisasi: ['label', 'url', 'children']
   */
  public static function normalize_menu_items(array $items): array
  {
    $normalize = function ($item) use (&$normalize) {
      if (is_object($item)) {
        if ($item instanceof \WP_Term) {
          $link = get_term_link($item);
          $url = !is_wp_error($link) ? $link : '#';
          $label = $item->name;
        } else {
          $url = $item->url ?? get_permalink($item) ?? '#';
          $label = $item->title ?? $item->name ?? $item->post_title ?? '';
        }
        $children = $item->children ?? [];
      } else {
        $label = $item['label'] ?? $item['name'] ?? $item['title'] ?? '';
        $url = $item['url'] ?? $item['link'] ?? '#';
        $children = $item['children'] ?? [];
      }

      return [
        'label' => $label,
        'url' => $url,
        'children' => array_map($normalize, $children),
      ];
    };

    return array_map($normalize, $items);
  }

  public static function get_archive_breadcrumb_items(
    string $post_type,
    array $taxonomies = [],
    array $labels = []
  ): array {
    $items = [];
    $post_type_obj = get_post_type_object($post_type);
    $archive_url = get_post_type_archive_link($post_type) ?: null;

    $root_label = $labels['root'] ?? ($post_type_obj->labels?->name ?? ucfirst($post_type));
    $all_label = $labels['all'] ?? sprintf(__('Semua %s', 'karsa_start'), mb_strtolower($root_label));

    if (is_post_type_archive($post_type)) {
      $items[] = [
        'label' => $all_label,
        'url' => null,
      ];
      return $items;
    }

    if (!empty($taxonomies) && is_tax($taxonomies)) {
      if ($archive_url) {
        $items[] = [
          'label' => $root_label,
          'url' => $archive_url,
        ];
      }

      $term = get_queried_object();
      if ($term instanceof \WP_Term) {
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

        $items[] = [
          'label' => $term->name,
          'url' => null,
        ];
      }
    }

    return $items;
  }

  /**
   * Mengambil daftar term sebagai array ['slug' => 'Nama Term'] untuk select-dropdown.
   */
  public static function get_term_options(string $taxonomy, bool $grouped = true): array
  {
    if (is_tax($taxonomy)) {
      return [];
    }

    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
      return [];
    }

    if (!$grouped || !is_taxonomy_hierarchical($taxonomy)) {
      return wp_list_pluck($terms, 'name', 'slug');
    }

    $terms_by_id = [];
    foreach ($terms as $term) {
      $terms_by_id[$term->term_id] = $term;
    }

    $root_terms = [];
    $children_by_root = [];

    foreach ($terms as $term) {
      if ($term->parent === 0 || !isset($terms_by_id[$term->parent])) {
        $root_terms[$term->term_id] = $term;
        continue;
      }

      $ancestor_id = $term->parent;
      $depth = 1;
      while (
        isset($terms_by_id[$ancestor_id]) &&
        $terms_by_id[$ancestor_id]->parent !== 0 &&
        isset($terms_by_id[$terms_by_id[$ancestor_id]->parent])
      ) {

        $ancestor_id = $terms_by_id[$ancestor_id]->parent;
        $depth++;
      }

      $prefix = $depth > 1 ? str_repeat('— ', $depth - 1) : '';
      $children_by_root[$ancestor_id][$term->slug] = $prefix . $term->name;
    }

    $options = [];
    foreach ($root_terms as $root_id => $root_term) {
      if (!empty($children_by_root[$root_id])) {
        $options[$root_term->name] = array_merge(
          [$root_term->slug => sprintf(__('Semua %s', 'karsa_start'), $root_term->name)],
          $children_by_root[$root_id]
        );
      } else {
        $options[$root_term->slug] = $root_term->name;
      }
    }
    return $options;
  }
}