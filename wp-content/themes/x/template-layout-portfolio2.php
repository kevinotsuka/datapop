<?php

// =============================================================================
// TEMPLATE NAME: Layout - Portfolio2
// -----------------------------------------------------------------------------
// Handles output the portfolio index page.
//
// Content is output based on which Stack has been selected in the Customizer.
// To view and/or edit the markup of your Stack's index, first go to "views"
// inside the "framework" subdirectory. Once inside, find your Stack's folder
// and look for a file called "template-archive-x-portfolio.php," where you'll
// be able to find the appropriate output.
// =============================================================================

?>

<?php get_header(); ?>

  <div class="x-container max width main">
    <div class="offset cf">
      <div class="<?php x_main_content_class(); ?>" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
        <?php x_get_view( 'renew', 'content', 'page' ); ?>
        <?php x_get_view( 'global', '_comments-template' ); ?>
      <?php endwhile; ?>
        <?php x_portfolio_filters(); ?>
        <?php x_get_view( 'global', '_portfolio' ); ?>

      </div>

      <?php get_sidebar(); ?>

    </div>
  </div>

<?php get_footer(); ?>