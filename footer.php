<?php
/**
 * View: Root footer
 * @package KarsaStart
 */

use KarsaStart\Taxonomy;

$categories = Taxonomy::normalize_menu_items(Taxonomy::get_active_tree('product-category'));
$brands = Taxonomy::normalize_menu_items(Taxonomy::get_active_tree('product-brand'));

$nav_items = [
  ['labels' => __('Kategori', 'karsa_start'), 'items' => $categories],
  ['labels' => __('Brand', 'karsa_start'), 'items' => $brands],
  [
    'labels' => __('Tentang Kami', 'karsa_start'),
    'items' => [
      [
        'label' => __('Tentang Kami', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('about-us')),
      ],
      [
        'label' => __('Syarat dan Ketentuan', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('terms-and-conditions')),
      ],
      [
        'label' => __('Kebijakan Privasi', 'karsa_start'),
        'url' => get_permalink(get_page_by_path('privacy-policy')),
      ],
    ],
  ]
];

?>

</main>

<footer id="footer" class="py-8 md:py-12 bg-surface border-t border-outline/40">
  <div class="container">
    <div class="flex gap-6 flex-col md:flex-row md:justify-between">
      <?php if (is_front_page()): ?>
        <h1 class="font-bold text-xl"><?php bloginfo('name'); ?></h1>
      <?php else: ?>
        <h2 class="font-bold text-xl"><?php bloginfo('name'); ?></h2>
      <?php endif ?>

      <?php if (!empty($nav_items)): ?>
        <ul class="grid gap-4 sm:grid-cols-3">
          <?php foreach ($nav_items as $items): ?>
            <li class="flex flex-col gap-2">
              <span class="font-semibold text-lg text-on-surface-variant">
                <?= esc_html($items['labels']) ?>
              </span>

              <?php if (!empty($items['items'])): ?>
                <ul class="flex flex-col gap-1">
                  <?php foreach ($items['items'] as $item): ?>
                    <li>
                      <a class="text-on-surface-subtle text-base"
                        href=" <?= esc_url($item['url']) ?>">
                        <?= esc_html($item['label']) ?>
                      </a>
                    </li>
                  <?php endforeach ?>
                </ul>
              <?php endif ?>
            </li>
          <?php endforeach ?>
        </ul>
      <?php endif ?>

    </div>
  </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>

</html>