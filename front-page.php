<?php
/**
 * Template: Root Front Page
 * @package KarsaStart
 */

use KarsaStart\Helpers;

?>

<?php get_header(); ?>

<!-- Front Page Template Here -->
<?php Helpers::view('store/front-page'); ?>

<?php get_footer(); ?>