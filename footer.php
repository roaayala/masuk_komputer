<?php
/**
 * View: Root footer
 * @package KarsaStart
 */

?>
</main>

<footer id="footer" class="py-8 bg-surface border-t border-outline/40">
  <div class="container">
    <?php if (is_front_page()): ?>
      <h1 class="font-bold text-xl"><?php bloginfo('name'); ?></h1>
    <?php else: ?>
      <h2 class="font-bold text-xl"><?php bloginfo('name'); ?></h2>
    <?php endif ?>
  </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>

</html>