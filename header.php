<?php

use KarsaStart\Helpers;
/**
 * Template: Global Header
 * @package KarsaStart
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="page" class="min-h-screen flex flex-col">

    <!-- Header Template Here -->
    <?php Helpers::view('store/header'); ?>

    <main id="content" class="flex-1 flex flex-col">