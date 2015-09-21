<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );


// Additional Functions
// =============================================================================

/**
 * Portfolio Categories widget class
 */
class Custom_WP_Widget_Categories extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "A list or dropdown of categories." ) );
    parent::__construct('x_categories', __('Portfolio Categories'), $widget_ops);
  }

  public function widget( $args, $instance ) {

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );

    $c = ! empty( $instance['count'] ) ? '1' : '0';
    $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
    $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

    $cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'portfolio-category');

    if ( $d ) {
      $cat_args['show_option_none'] = __('Select Category');
      wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
?>

<script type='text/javascript'>
/* <![CDATA[ */
  var dropdown = document.getElementById("cat");
  function onCatChange() {
    if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
      location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
    }
  }
  dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php
    } else {
?>
    <ul>
<?php
    $cat_args['title_li'] = '';
    wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
?>
    </ul>
<?php
    }

    echo $args['after_widget'];
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
    $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
    $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

    return $instance;
  }

  public function form( $instance ) {
    //Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
    $title = esc_attr( $instance['title'] );
    $count = isset($instance['count']) ? (bool) $instance['count'] :false;
    $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
    $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
    <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
    <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
<?php
  }

}

function custom_category_register_widgets() {
  register_widget( 'Custom_WP_Widget_Categories' );
}

add_action( 'widgets_init', 'custom_category_register_widgets' );

// Entry Author Meta
// =============================================================================

if ( ! function_exists( 'x_renew_entry_meta' ) ) :
  function x_renew_entry_meta() {

    //
  //
    // Author.
    //

    $author = sprintf( '<span><a href="%1$s">%2$s</a></span>',
      get_author_posts_url( get_the_author_meta( 'ID' ) ),
      get_the_author()
    );

    //
    // Date.
    //

    $date = sprintf( '<span><time class="entry-date" datetime="%1$s"><i class="x-icon-calendar" data-icon=""></i> %2$s</time></span>',
      esc_attr( get_the_date( 'c' ) ),
      esc_html( get_the_date() )
    );

    //
    // Categories.
    //

    if ( get_post_type() == 'x-portfolio' ) {
      if ( has_term( '', 'portfolio-category', NULL ) ) {
        $categories        = get_the_terms( get_the_ID(), 'portfolio-category' );
        $separator         = ', ';
        $categories_output = '';
        foreach ( $categories as $category ) {
          $categories_output .= '<a href="'
                              . get_term_link( $category->slug, 'portfolio-category' )
                              . '" title="'
                              . esc_attr( sprintf( __( "View all posts in: &ldquo;%s&rdquo;", '__x__' ), $category->name ) )
                              . '"><i class="x-icon-bookmark" data-icon=""></i> '
                              . $category->name
                              . '</a>'
                              . $separator;
        }

        $categories_list = sprintf( '<span>%s</span>',
          trim( $categories_output, $separator )
        );
      } else {
        $categories_list = '';
      }
    } else {
      $categories        = get_the_category();
      $separator         = ', ';
      $categories_output = '';
      foreach ( $categories as $category ) {
        $categories_output .= '<a href="'
                            . get_category_link( $category->term_id )
                            . '" title="'
                            . esc_attr( sprintf( __( "View all posts in: &ldquo;%s&rdquo;", '__x__' ), $category->name ) )
                            . '"><i class="x-icon-bookmark" data-icon=""></i> '
                            . $category->name
                            . '</a>'
                            . $separator;
      }

      $categories_list = sprintf( '<span>%s</span>',
        trim( $categories_output, $separator )
      );
    }

    //
    // Comments link.
    //

    if ( comments_open() ) {

      $title  = apply_filters( 'x_entry_meta_comments_title', get_the_title() );
      $link   = apply_filters( 'x_entry_meta_comments_link', get_comments_link() );
      $number = apply_filters( 'x_entry_meta_comments_number', get_comments_number() );

      if ( $number == 0 ) {
        $text = __( 'Leave a Comment' , '__x__' );
      } else if ( $number == 1 ) {
        $text = $number . ' ' . __( 'Comment' , '__x__' );
      } else {
        $text = $number . ' ' . __( 'Comments' , '__x__' );
      }

      $comments = sprintf( '<span><a href="%1$s" title="%2$s" class="meta-comments"><i class="x-icon-comments" data-icon=""></i> %3$s</a></span>',
        esc_url( $link ),
        esc_attr( sprintf( __( 'Leave a comment on: &ldquo;%s&rdquo;', '__x__' ), $title ) ),
        $text
      );

    } else {

      $comments = '';

    }

    //
    // Output.
    //

    if ( x_does_not_need_entry_meta() ) {
      return;
    } else {
      printf( '<p class="p-meta">%1$s%2$s%3$s%4$s</p>',
        $author,
        $date,
        $categories_list,
        $comments
      );
    }

  }
endif;