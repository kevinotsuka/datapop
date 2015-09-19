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

      <?php x_get_view( 'global', '_portfolio' ); ?>

    </div>

    <?php get_sidebar(); ?>

<!---adding multi filter ------>

<?php if ( x_get_content_layout() != 'full-width' ) : ?>

<!----- START : THIS IS FILTER FORM UNDER wp-sidebar.php -------->
<form action="<?php echo home_url()?>">
<?php 
  $categories = get_categories(); 
  foreach ($categories as $category) {
  echo '<input type="checkbox" name="cat_select[]" value="'.$category->cat_ID.'"> '.$category->category_nicename.'<br />';
  }
?>
<button type="submit">Filter</button>
</form>

<!----- END : THIS IS FILTER FORM UNDER wp-sidebar.php -------->

  <aside class="<?php x_sidebar_class(); ?>" role="complementary">
    <?php if ( get_option( 'ups_sidebars' ) != array() ) : ?>
      <?php dynamic_sidebar( apply_filters( 'ups_sidebar', 'sidebar-main' ) ); ?>
    <?php else : ?>
      <?php dynamic_sidebar( 'sidebar-main' ); ?>
    <?php endif; ?>
  </aside>

<?php endif; ?>
<!---adding multi filter end ------>

  </div>

<?php get_footer(); ?>

