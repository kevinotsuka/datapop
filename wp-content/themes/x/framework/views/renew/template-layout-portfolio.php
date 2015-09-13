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
	<?php $id = 205; $p = get_page($id); echo apply_filters(‘the_content’, $p->post_content); ?>

      <?php x_get_view( 'global', '_portfolio' ); ?>

    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>