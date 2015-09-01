<?php

// =============================================================================
// VIEWS/ICON/TEMPLATE-BLANK-8.PHP (No Container | No Header, Footer)
// -----------------------------------------------------------------------------
// A blank page for creating unique layouts.
// =============================================================================

?>

<?php x_get_view( 'global', '_header' ); ?>

  <div id="top" class="site">
    <?php x_get_view( 'global', '_slider-revolution-above' ); ?>
    <?php x_get_view( 'global', '_slider-revolution-below' ); ?>
    <div class="x-main full" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php x_get_view( 'global', '_content', 'the-content' ); ?>
          <?php x_google_authorship_meta(); ?>
        </article>

      <?php endwhile; ?>

    </div>

    <?php x_get_view( 'icon', '_template-blank-sidebar' ); ?>
<?php get_footer(); ?>