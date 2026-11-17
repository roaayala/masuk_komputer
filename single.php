<?php

use KarsaStart\Breadcrumb;
use KarsaStart\Helpers;
/**
 * Template: Single
 * @package KarsaStart
 */

?>

<?php get_header(); ?>

<!-- Single Template Here -->
<div class="container">
  <?php Helpers::component('breadcrumb', [
    'items' =>
      Breadcrumb::single(
        'product',
        'product-category',
        __('Produk', 'karsa_start')
      )

  ]) ?>
  <h1>
    <?= get_the_title() ?>
  </h1>
</div>


<?php get_footer(); ?>