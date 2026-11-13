<?php
/**
 * View: About us Page
 * @package KarsaStart
 */

use KarsaStart\Helpers;

get_header();

// Page View Here 
while (have_posts()):
  the_post(); ?>
  <!-- Hero -->
  <?php Helpers::module('hero', [
    'title' => get_the_title(),
    'leading_text' => __(
      'Selamat datang di MasukKomputer. Kami adalah platform penyedia informasi, katalog komponen komputer, dan simulasi perakitan PC yang dirancang untuk membantu antusias teknologi, gamer, creator, hingga profesional dalam menemukan perangkat keras terbaik sesuai kebutuhan.',
      'karsa_start'
    ),
  ]) ?>

  <!-- Visi dan Misi  -->
  <?php
  $vision_mission_contents = [
    [
      'icon' => 'eye',
      'title' => __('Kemudahan Akses Informasi', 'karsa_start'),
      'description' => __(
        'Menyajikan katalog komponen komputer yang lengkap, transparan, dan mudah dinavigasi.',
        'karsa_start'
      )
    ],
    [
      'icon' => 'component',
      'title' => __('Simulasi Perakitan PC', 'karsa_start'),
      'description' => __(
        'Memberikan pengalaman simulasi rakit PC yang presisi untuk memudahkan pengguna mengukur estimasi biaya dan kompatibilitas antar-komponen.',
        'karsa_start'
      )
    ],
    [
      'icon' => 'lightbulb',
      'title' => __('Edukasi Teknologi', 'karsa_start'),
      'description' => __(
        'Membantu pengguna dari berbagai tingkat pemahaman hardware untuk membuat keputusan pembelian secara bijak.',
        'karsa_start'
      )
    ]
  ];

  Helpers::module('feature-grid', [
    'title' => __('Visi dan Misi Kami', 'karsa_start'),
    'title_classes' => 'text-center',
    'items' => $vision_mission_contents
  ]);
  ?>

  <!-- Layanan Utama -->
  <?php
  $main_service_contents = [
    [
      'icon' => 'list',
      'title' => __('Katalog Komponen', 'karsa_start'),
      'description' => __(
        'Daftar lengkap Processor, VGA, Motherboard, RAM, Storage, hingga elektronik lain-lain terbaru.',
        'karsa_start'
      )
    ],
    [
      'icon' => 'mouse-pointer-click',
      'title' => __('Simulasi Rakit PC', 'karsa_start'),
      'description' => __(
        'Fitur kalkulator simulasi rakitan PC secara interaktif dan real-time.',
        'karsa_start'
      )
    ],
    [
      'icon' => 'user-group',
      'title' => __('Dukungan Komunitas', 'karsa_start'),
      'description' => __(
        'Pusat informasi dan panduan teknis seputar dunia IT dan hardware komputer..',
        'karsa_start'
      )
    ]
  ];

  Helpers::module('feature-grid', [
    'wrapper_classes' => 'bg-surface-bright',
    'title' => __('Layanan Utama', 'karsa_start'),
    'title_classes' => 'text-center',
    'items' => $main_service_contents
  ]);
  ?>



<?php endwhile;
get_footer();