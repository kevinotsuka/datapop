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
<?php x_get_view( 'global', '_content', 'the-content' ); ?>

    </div>
          <?php x_get_view( 'global', '_mfilters' ); ?>
      <?php x_get_view( 'global', '_portfolio' ); ?>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>

