<?php
namespace KarsaStart;

class Helpers
{
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

  public static function wa_url()
  {

  }

}