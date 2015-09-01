<?php

// =============================================================================
// VIEWS/ICON/TEMPLATE-BLANK-4.PHP (No Container | Header, Footer)
// -----------------------------------------------------------------------------
// A blank page for creating unique layouts.
// =============================================================================

?>

<?php get_header(); ?>

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