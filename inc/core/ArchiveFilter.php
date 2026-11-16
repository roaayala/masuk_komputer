<?php

namespace KarsaStart;

class ArchiveFilter
{
  public static function apply(\WP_Query $query, array $config): void
  {
    // 1. LIMIT ITEM
    if (!empty($config['limits'])) {
      $default = $config['limits'][1];
      $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : $default;
      $query->set('posts_per_page', in_array($limit, $config['limits'], true) ? $limit : $default);
    }

    // 2. SORTING
    $sort = sanitize_text_field(wp_unslash($_GET['sort'] ?? ''));
    if ($sort !== '' && isset($config['sorts'][$sort])) {
      foreach ($config['sorts'][$sort] as $key => $value) {
        $query->set($key, $value);
      }
    }

    // 3. TAXONOMY FILTER ('param_url' => 'taxonomy_name')
    $tax_query = (array) ($query->get('tax_query') ?: []);

    foreach ($config['taxonomies'] ?? [] as $param => $taxonomy) {
      $slug = sanitize_title(wp_unslash($_GET[$param] ?? ''));
      if ($slug !== '' && !is_tax($taxonomy)) {
        $tax_query[] = [
          'taxonomy' => $taxonomy,
          'field' => 'slug',
          'terms' => $slug,
        ];
      }
    }

    if (!empty($tax_query)) {
      $tax_query['relation'] = 'AND';
      $query->set('tax_query', $tax_query);
    }

    // 4. META FILTER (Dropdown & Checkbox Flag)
    $meta_query = (array) ($query->get('meta_query') ?: []);

    foreach ($config['meta'] ?? [] as $param => $rule) {
      $val = sanitize_text_field(wp_unslash($_GET[$param] ?? ''));
      $allowed = $rule['allowed'] ?? [];

      if ($val !== '' && (empty($allowed) || in_array($val, $allowed, true))) {
        $meta_query[] = [
          'key' => $rule['key'],
          'value' => $val,
          'compare' => $rule['compare'] ?? '=',
        ];
      }
    }

    foreach ($config['flags'] ?? [] as $param => $rule) {
      if (!empty($_GET[$param])) {
        $meta_query[] = [
          'key' => $rule['key'],
          'value' => $rule['value'] ?? 1,
          'compare' => $rule['compare'] ?? '=',
          'type' => $rule['type'] ?? 'CHAR',
        ];
      }
    }

    if (!empty($meta_query)) {
      $meta_query['relation'] = 'AND';
      $query->set('meta_query', $meta_query);
    }
  }
}