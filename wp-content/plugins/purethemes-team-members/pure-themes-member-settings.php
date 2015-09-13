<?php

/**
 * Adds a meta box to the post editing screen
 */
function pure_member_custom_meta() {
    add_meta_box( 'pure_member_meta', __( 'Member Additional Data', 'pure-member-textdomain' ), 'pure_member_meta_callback', 'pure-members' );
}
add_action( 'add_meta_boxes', 'pure_member_custom_meta' );


/**
 * Outputs the content of the meta box
 */
function pure_member_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'pure_member_nonce' );
    $pure_member_stored_meta = get_post_meta( $post->ID );
    ?>
 
    <p>
        <label for="pure-member-designation" style="display: block;float: left;width: 28%;"><?php _e( 'Member Designation', 'pure-member-designation' )?></label>
        <input style="width:70%" type="text" name="pure-member-designation" id="pure-member-designation" value="<?php if ( isset ( $pure_member_stored_meta['pure-member-designation'] ) ) echo $pure_member_stored_meta['pure-member-designation'][0]; ?>" />
    </p>    
	<p>
        <label for="pure-member-facebook-link" style="display: block;float: left;width: 28%;"><?php _e( 'Facebook Profile Link', 'pure-member-facebook-link' )?></label>
        <input style="width:70%" type="text" name="pure-member-facebook-link" id="pure-member-facebook-link" value="<?php if ( isset ( $pure_member_stored_meta['pure-member-facebook-link'] ) ) echo $pure_member_stored_meta['pure-member-facebook-link'][0]; ?>" />
    </p>	
	<p>
        <label for="pure-member-twitter-link" style="display: block;float: left;width: 28%;"><?php _e( 'Twitter Profile Link', 'pure-member-twitter-link' )?></label>
        <input style="width:70%" type="text" name="pure-member-twitter-link" id="pure-member-twitter-link" value="<?php if ( isset ( $pure_member_stored_meta['pure-member-twitter-link'] ) ) echo $pure_member_stored_meta['pure-member-twitter-link'][0]; ?>" />
    </p>	
	<p>
        <label for="pure-member-dribbble-link" style="display: block;float: left;width: 28%;"><?php _e( 'Dribbble Profile Link', 'pure-member-dribbble-link' )?></label>
        <input style="width:70%" type="text" name="pure-member-dribbble-link" id="pure-member-dribbble-link" value="<?php if ( isset ( $pure_member_stored_meta['pure-member-dribbble-link'] ) ) echo $pure_member_stored_meta['pure-member-dribbble-link'][0]; ?>" />
    </p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function pure_member_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'pure_member_nonce' ] ) && wp_verify_nonce( $_POST[ 'pure_member_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'pure-member-designation' ] ) ) {
        update_post_meta( $post_id, 'pure-member-designation', sanitize_text_field( $_POST[ 'pure-member-designation' ] ) );
    }    
	if( isset( $_POST[ 'pure-member-facebook-link' ] ) ) {
        update_post_meta( $post_id, 'pure-member-facebook-link', sanitize_text_field( $_POST[ 'pure-member-facebook-link' ] ) );
    }	
	if( isset( $_POST[ 'pure-member-twitter-link' ] ) ) {
        update_post_meta( $post_id, 'pure-member-twitter-link', sanitize_text_field( $_POST[ 'pure-member-twitter-link' ] ) );
    }	
	if( isset( $_POST[ 'pure-member-dribbble-link' ] ) ) {
        update_post_meta( $post_id, 'pure-member-dribbble-link', sanitize_text_field( $_POST[ 'pure-member-dribbble-link' ] ) );
    }
 
}
add_action( 'save_post', 'pure_member_meta_save' );


/* Add Post Thumbnail*/
add_theme_support( 'post-thumbnails', array( 'pure-members' ) );
add_image_size( 'pure-member-img', 260, 300, true  );
 
 
/* Some setup */
define('PURE_MEMBER_NAME', "Member Details");
define('PURE_MEMBER_SINGLE', "Member Details");
define('PURE_MEMBER_TYPE', "pure-members");
define('PURE_MEMBER_ADD_NEW_ITEM', "Add New Member Details");
define('PURE_MEMBER_EDIT_ITEM', "Edit Member Details");
define('PURE_MEMBER_NEW_ITEM', "New Member Details");
define('PURE_MEMBER_VIEW_ITEM', "View Member Details");

/* Register custom post for carousel images*/
function pure_member_custom_post_register() {  
    $args = array(  
        'labels' => array (
			'name' => __( PURE_MEMBER_NAME ),
			'singular_label' => __(PURE_MEMBER_SINGLE),  
			'add_new_item' => __(PURE_MEMBER_ADD_NEW_ITEM),
			'edit_item' => __(PURE_MEMBER_EDIT_ITEM),
			'new_item' => __(PURE_MEMBER_NEW_ITEM),
			'view_item' => __(PURE_MEMBER_VIEW_ITEM),
		), 
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => true,  
        'supports' => array('title', 'thumbnail')  
       );  
    register_post_type(PURE_MEMBER_TYPE , $args );  
}
add_action('init', 'pure_member_custom_post_register');

/* Move featured image box under title */
add_action('do_meta_boxes', 'pure_member_image_box');
function pure_member_image_box()
{
    remove_meta_box( 'postimagediv', 'pure-members', 'side' );
    add_meta_box('postimagediv', __('Upload Member Image'), 'post_thumbnail_meta_box', 'pure-members', 'normal', 'high');
}

/* Showing featured image in admin panel area */
add_filter('manage_pure-members_posts_columns', 'posts_columns', 10, 2);
add_action('manage_pure-members_posts_custom_column', 'posts_custom_columns', 10, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Featured Images');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
        if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( array('75, 120') );
    }
}

?>