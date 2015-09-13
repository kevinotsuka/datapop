<?php

define('Pure_Member_CPTPATH',   plugin_dir_path(__FILE__));
define('Pure_Member_CPTURL',    plugins_url('', __FILE__));


add_filter('posts_orderby', 'custom_posts_order');
function custom_posts_order($orderBy) 
    {
        global $wpdb;
        $orderBy = "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";
        return($orderBy);
    }

if (is_admin())
	add_action( 'plugins_loaded', 'init_custom_posts_order' );
	
function init_custom_posts_order() 
    {
	    global $custom_post_type_order;
	    $custom_post_type_order = new Pure_Member_CPT();
    }
    
    
class Pure_Member_Custom_Type_Order_Walker extends Walker 
    {
        /**
         * @see Walker::$tree_type
         * @since 2.1.0
         * @var string
         */
        var $tree_type = 'page';

        /**
         * @see Walker::$db_fields
         * @since 2.1.0
         * @todo Decouple this.
         * @var array
         */
        var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');

        /**
         * @see Walker::start_lvl()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class='children'>\n";
        }

        /**
         * @see Walker::end_lvl()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function end_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        /**
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $page Page data object.
         * @param int $depth Depth of page. Used for padding.
         * @param int $current_page Page ID.
         * @param array $args
         */
        function start_el(&$output, $page, $depth, $args) {
            if ( $depth )
                $indent = str_repeat("\t", $depth);
            else
                $indent = '';

            extract($args, EXTR_SKIP);

            $output .= $indent . '<li id="item_'.$page->ID.'"><span>'.apply_filters( 'the_title', $page->post_title, $page->ID ).'</span>';
        }

        /**
         * @see Walker::end_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $page Page data object. Not used.
         * @param int $depth Depth of page. Not Used.
         */
        function end_el(&$output, $page, $depth) {
            $output .= "</li>\n";
        }

    }


class Pure_Member_CPT 
    {
	    var $current_post_type = null;
	    
	    function Pure_Member_CPT() 
            {
		        add_action( 'admin_init', array(&$this, 'registerJavaScript'), 11 );
                add_action( 'admin_init', array(&$this, 'checkPost'), 10 );
		        add_action( 'admin_menu', array(&$this, 'addMenu') );
                
                
		        
		        add_action( 'wp_ajax_update-custom-type-order', array(&$this, 'saveAjaxOrder') );
	        }

	    function registerJavaScript() 
            {
		        if ( $this->current_post_type != null ) 
                    {
                        wp_enqueue_script('jQuery');
                        wp_enqueue_script('jquery-ui-sortable');
                        
                        wp_register_style('Pure_Member_CPTStyleSheets', Pure_Member_CPTURL . '/css/Pure_Member_CPT.css');
                        wp_enqueue_style( 'Pure_Member_CPTStyleSheets');

		            }
	        }
	    
	    function checkPost() 
            {
		        if ( isset($_GET['page']) && substr($_GET['page'], 0, 16) == 'order-post-type-' ) 
                    {
			            $this->current_post_type = get_post_type_object(str_replace( 'order-post-type-', '', $_GET['page'] ));
			            if ( $this->current_post_type == null) 
                            {
				                wp_die('Invalid post type');
			                }
		            }
	        }
	    
	    function saveAjaxOrder() 
            {
		        global $wpdb;
		        
		        parse_str($_POST['order'], $output);
		        
		        if (is_array($output))
                foreach($output as $key => $values ) 
                    {
			            if ( $key == 'item' ) 
                            {
				                foreach( $values as $position => $id ) 
                                    {
					                    $wpdb->update( $wpdb->posts, array('menu_order' => $position, 'post_parent' => 0), array('ID' => $id) );
				                    } 
			                } 
                        else 
                            {
				                foreach( $values as $position => $id ) 
                                    {
					                    $wpdb->update( $wpdb->posts, array('menu_order' => $position, 'post_parent' => str_replace('item_', '', $key)), array('ID' => $id) );
				                    }
			                }
		            }
	        }
	    

	    function addMenu() 
            {
		        //put a menu for all custom_type
                $post_types = get_post_types();
                foreach( $post_types as $post_type_name ) 
                    {
                        if ($post_type_name == 'post')
                            continue;
						if ($post_type_name == 'pure-members')
							add_submenu_page('edit.php?post_type='.$post_type_name, 'Re-Order', 'Re-Order', 'manage_options', 'order-post-type-'.$post_type_name, array(&$this, 'pageManage') );
		            }
	        }
	    

	    function pageManage() {
		    ?>
		    <div class="wrap">
			    <div class="icon32" id="icon-edit"><br></div>
                <h2><?php echo $this->current_post_type->labels->singular_name . ' -  Re-order '?></h2>

			    <div id="ajax-response"></div>
			    
			    <noscript>
				    <div class="error message">
					    <p>This plugin can't work without javascript, because it's use drag and drop and AJAX.</p>
				    </div>
			    </noscript>
			    
			    <div id="order-post-type">
				    <ul id="sortable">
					    <?php $this->listPages('hide_empty=0&title_li=&post_type='.$this->current_post_type->name); ?>
				    </ul>
				    
				    <div class="clear"></div>
			    </div>
			    
			    <p class="submit">
				    <a href="#" id="save-order" class="button-primary">Update</a>
			    </p>
			    
			    <script type="text/javascript">
				    jQuery(document).ready(function() {
					    jQuery("#sortable").sortable({
						    'tolerance':'intersect',
						    'cursor':'pointer',
                            'grid': [50, 10],
						    'items':'li',
						    'placeholder':'placeholder',
						    'nested': 'ul'
					    });
					    
					    jQuery("#sortable").disableSelection();
					    jQuery("#save-order").bind( "click", function() {
						    jQuery.post( ajaxurl, { action:'update-custom-type-order', order:jQuery("#sortable").sortable("serialize") }, function() {
							    jQuery("#ajax-response").html('<div class="message updated fade"><p>Items Order Updates</p></div>');
							    jQuery("#ajax-response div").delay(3000).hide("slow");
						    });
					    });
				    });
			    </script>

		    </div>
		    <?php
	    }

	    function listPages($args = '') 
            {
		        $defaults = array(
			        'depth' => 0, 'show_date' => '',
			        'date_format' => get_option('date_format'),
			        'child_of' => 0, 'exclude' => '',
			        'title_li' => __('Pages'), 'echo' => 1,
			        'authors' => '', 'sort_column' => 'menu_order',
			        'link_before' => '', 'link_after' => '', 'walker' => ''
		        );

		        $r = wp_parse_args( $args, $defaults );
		        extract( $r, EXTR_SKIP );

		        $output = '';
	        
		        $r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);
		        $exclude_array = ( $r['exclude'] ) ? explode(',', $r['exclude']) : array();
		        $r['exclude'] = implode( ',', apply_filters('wp_list_pages_excludes', $exclude_array) );

		        // Query pages.
		        $r['hierarchical'] = 0;
                $args = array(
                            'sort_column'   =>  'menu_order',
                            'post_type'     =>  $post_type,
                            'posts_per_page' => -1
                );
                
                $the_query = new WP_Query($args);
                $pages = $the_query->posts;

		        if ( !empty($pages) ) {
			        if ( $r['title_li'] )
				        $output .= '<li class="pagenav intersect">' . $r['title_li'] . '<ul>';
				        
			        $output .= $this->walkTree($pages, $r['depth'], $r);

			        if ( $r['title_li'] )
				        $output .= '</ul></li>';
		        }

		        $output = apply_filters('wp_list_pages', $output, $r);

		        if ( $r['echo'] )
			        echo $output;
		        else
			        return $output;
	        }
	    
	    function walkTree($pages, $depth, $r) 
            {
		        if ( empty($r['walker']) )
			        $walker = new Pure_Member_Custom_Type_Order_Walker;
		        else
			        $walker = $r['walker'];

		        $args = array($pages, $depth, $r);
		        return call_user_func_array(array(&$walker, 'walk'), $args);
	        }
    }

?>