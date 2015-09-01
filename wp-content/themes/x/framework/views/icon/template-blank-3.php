<?php

// =============================================================================
// VIEWS/ICON/TEMPLATE-BLANK-3.PHP (Container | No Header, No Footer)
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
          <div class="x-container-fluid max width">
            <?php x_get_view( 'global', '_content', 'the-content' ); ?>
          </div>
          <?php x_google_authorship_meta(); ?>
        </article>

      <?php endwhile; ?>

    </div>

    <?php x_get_view( 'icon', '_template-blank-sidebar' ); ?>

  </div> <!-- end .site -->

<?php x_get_view( 'global', '_footer', 'scroll-top' ); ?>
<?php x_get_view( 'global', '_footer' ); ?>