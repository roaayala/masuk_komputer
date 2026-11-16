<?php

namespace KarsaStart;

class ArchiveFilter
{
  public static function apply(\WP_Query $query, array $config): void
  {

    // KEYWORD SEARCH
    $search_param = $config['search'] ?? '';
    if ($search_param !== '') {
      $keyword = sanitize_text_field(wp_unslash($_GET[$search_param] ?? ''));
      if ($keyword !== '') {
        $query->set('s', $keyword);
      }
    }

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


  // menghasilkan URL halaman 1 dengan menghapus parameter query tertentu saja
  public static function get_reset_url(array $remove_keys, string $base_url = ''): string
  {
    $base_url = $base_url !== '' ? $base_url : strtok(get_pagenum_link(1), '?');
    $query = map_deep(wp_unslash($_GET), 'sanitize_text_field');

    $keys_to_strip = array_flip(array_merge(['paged'], $remove_keys));
    $remaining = array_diff_key($query, $keys_to_strip);

    return add_query_arg($remaining, $base_url);
  }

  // hidden input
  public static function render_hidden_query_inputs(array $exclude_keys = []): void
  {
    $query = map_deep(wp_unslash($_GET), 'sanitize_text_field');
    $exclude = array_flip(array_merge(['paged'], $exclude_keys));

    foreach ($query as $key => $value) {
      if (isset($exclude[$key]) || !is_scalar($value) || (string) $value === '') {
        continue;
      }

      printf(
        '<input type="hidden" name="%s" value="%s">' . "\n",
        esc_attr((string) $key),
        esc_attr((string) $value)
      );
    }
  }
}