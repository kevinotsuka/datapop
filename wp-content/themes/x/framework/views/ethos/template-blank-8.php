<?php

// =============================================================================
// VIEWS/ETHOS/TEMPLATE-BLANK-8.PHP (No Container | No Header, Footer)
// -----------------------------------------------------------------------------
// A blank page for creating unique layouts.
// =============================================================================

?>

<?php x_get_view( 'global', '_header' ); ?>

  <div id="top" class="site">
    <?php x_get_view( 'global', '_slider-revolution-above' ); ?>
    <?php x_get_view( 'global', '_slider-revolution-below' ); ?>
    <div class="x-main full" role="main">
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">

          <?php while ( have_posts() ) : the_post(); ?>
            <?php the_content(); ?>
            <?php x_link_pages(); ?>
          <?php endwhile; ?>

        </div>
        <?php x_google_authorship_meta(); ?>
      </article>
    </div>

<?php get_footer(); ?>