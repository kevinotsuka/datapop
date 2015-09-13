<?php

// =============================================================================
// VIEWS/RENEW/TEMPLATE-LAYOUT-PORTFOLIO.PHP
// -----------------------------------------------------------------------------
// Portfolio page output for Renew.
// =============================================================================

?>

<?php get_header(); ?>

  <div class="x-container max width offset">
    <div class="<?php x_main_content_class(); ?>" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
<?php x_get_view( 'renew', 'content', 'page' ); ?>
<?php endwhile; ?>

      <?php x_get_view( 'global', '_portfolio' ); ?>

    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>