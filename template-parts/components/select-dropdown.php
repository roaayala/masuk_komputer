<?php
/**
 * Component: Select Dropdown
 * @package KarsaStart
 */

$id = $args['id'] ?? wp_unique_id('select-');
$name = $args['name'] ?? '';
$label = $args['label'] ?? '';

$options = $args['options'] ?? [];
$selected = (string) ($args['selected'] ?? '');
$placeholder = $args['placeholder'] ?? '';
$auto_submit = (bool) ($args['auto_submit'] ?? false);

$wrapper_class = $args['wrapper_class'] ?? '';
$select_class = $args['select_class'] ?? '';
$attributes = $args['attributes'] ?? [];

if (empty($options) && empty($placeholder)) {
  return;
}

$extra_attrs = '';
foreach ($attributes as $attr_key => $attr_val) {
  if (is_bool($attr_val)) {
    if ($attr_val) {
      $extra_attrs .= ' ' . esc_attr($attr_key);
    }
  } else {
    $extra_attrs .= sprintf(' %s="%s"', esc_attr($attr_key), esc_attr((string) $attr_val));
  }
}

?>

<div class="flex items-center gap-2 <?= esc_attr($wrapper_class) ?>">
  <?php if ($label !== ''): ?>
    <label for="<?= esc_attr($id); ?>" class="text-xs text-on-surface-subtle">
      <?= esc_html($label); ?>
    </label>
  <?php endif; ?>

  <div class="relative inline-flex items-center">
    <select
      id="<?= esc_attr($id) ?>"
      name="<?= esc_attr($name) ?>"
      <?= $auto_submit ? 'onchange="this.form.submit()"' : ''; ?>
      class="appearance-none text-xs bg-surface border border-outline/40 rounded-md pl-2 pr-7 py-1 text-on-surfacefocus:outline-none focus:border-primary cursor-pointer <?= esc_attr($select_class); ?>"
      <?= $extra_attrs; ?>>

      <?php if ($placeholder !== ''): ?>
        <option value="" <?php selected($selected, ''); ?>>
          <?= esc_html($placeholder); ?>
        </option>
      <?php endif; ?>

      <?php foreach ($options as $key => $option): ?>
        <?php if (is_array($option)): ?>
          <optgroup label="<?= esc_attr((string) $key); ?>">
            <?php foreach ($option as $value => $option_label): ?>
              <option value="<?= esc_attr((string) $value); ?>" <?php selected($selected, (string) $value); ?>>
                <?= esc_html($option_label); ?>
              </option>
            <?php endforeach; ?>
          </optgroup>
        <?php else: ?>
          <option value="<?= esc_attr((string) $key); ?>" <?php selected($selected, (string) $key); ?>>
            <?= esc_html($option); ?>
          </option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
    <i
      data-lucide="chevron-down"
      class="w-4 h-4 text-on-surface-subtle absolute right-2 pointer-events-none"
      aria-hidden="true"></i>
  </div>
</div>