<?php
/*
Plugin Name: PureTheme's Team Members
Plugin URI: http://plugins.zinan.me/purethemes-team-members
Description: Providing a convenient way to show your team members. Custom post types, drag and drop re-arrange system, shortcode activation, Easiest admin setting panel.
Version: 1.1.1
Author: Developer Zinan
Author URI: http://www.zinan.me/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


/* Adding Latest jQuery from Wordpress */
function pure_members_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'pure_members_latest_jquery');

/* Main Setting Class */
class PMSFTest {

    private $plugin_path;
    private $plugin_url;
    private $l10n;
    private $PMSF;

    function __construct() 
    {	
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        $this->l10n = 'pure-themes-settings-framework';
        add_action( 'admin_menu', array(&$this, 'admin_menu'), 99 );
        
        // Include and create a new Pure_Member_Settings_Framework
        require_once( $this->plugin_path .'pure-themes-settings-framework.php' );
		
		/*Some Set-up*/

		define('PURE_MEMBERS_HOOK', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
		wp_enqueue_style('pure_members-css-font-awesome', PURE_MEMBERS_HOOK.'css/font-awesome.min.css');
		wp_enqueue_style('pure_members-css-main-css', PURE_MEMBERS_HOOK.'css/plugins-main.css');

		function pure_members_active_hook() {?>
			<script type="text/javascript">

			function hex2rgba(hex, opacity)
			{
				//extract the two hexadecimal digits for each color
				var patt = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
				var matches = patt.exec(hex);
				
				//convert them to decimal
				var r = parseInt(matches[1], 16);
				var g = parseInt(matches[2], 16);
				var b = parseInt(matches[3], 16);
				
				//create rgba string
				var rgba = "rgba(" + r + "," + g + "," + b + "," + opacity + ")";
				
				//return rgba colour
				return rgba;
			}
			jQuery(document).ready(function() {
			 jQuery('.member_single,.pure_member_h').css("border-color", hex2rgba("<?php echo PMSF_get_setting( 'pure_plugin', 'general', 'border-color' ); ?>", 0.7));
			 jQuery('.member_single').find('.member_bottom').css("background-color", hex2rgba("<?php echo PMSF_get_setting( 'pure_plugin', 'general', 'color' ); ?>", 0.4));
			 jQuery('.member_single').hover(
				 function () {
				   jQuery(this).find('.member_bottom').css("background-color", hex2rgba("<?php echo PMSF_get_setting( 'pure_plugin', 'general', 'hover-color' ); ?>", 0.5));
				 }, 
				 function () {
				   jQuery(this).find('.member_bottom').css("background-color", hex2rgba("<?php echo PMSF_get_setting( 'pure_plugin', 'general', 'color' ); ?>", 0.4));
				 }
			 );

		    });
			</script>
		<?php
		}
		add_action('wp_head', 'pure_members_active_hook');
		
		
		function pure_members_custom_css() {?>
			<style type="text/css">
				<?php echo PMSF_get_setting( 'pure_plugin', 'general', 'custom-css' ); ?>
			</style>
		
		<?php
		}
		add_action('wp_head', 'pure_members_custom_css');
		
        $this->PMSF = new Pure_Member_Settings_Framework( $this->plugin_path .'settings/settings-general.php' );
        // Add an optional settings validation filter (recommended)
        add_filter( $this->PMSF->get_option_group() .'_settings_validate', array(&$this, 'validate_settings') );
    }
    
    function admin_menu()
    {
        $page_hook = add_menu_page( __( 'Member Settings', $this->l10n ), __( 'Member Settings', $this->l10n ), 'update_core', 'Member Settings', array(&$this, 'settings_page') );
        add_submenu_page( 'PMSF', __( 'Settings', $this->l10n ), __( 'Settings', $this->l10n ), 'update_core', 'PMSF', array(&$this, 'settings_page') );
    }
    
    function settings_page()
	{
	    // Your settings page
	    ?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2>PureTheme's Team Member Settings</h2>
			<?php 
			// Output your settings form
			$this->PMSF->settings(); 
			?>
		</div>
		<?php
		
		// Get settings
		//$settings = PMSF_get_settings( $this->plugin_path .'settings/settings-general.php' );
		//echo '<pre>'.print_r($settings,true).'</pre>';
		
		// Get individual setting
		//$setting = PMSF_get_setting( PMSF_get_option_group( $this->plugin_path .'settings/settings-general.php' ), 'general', 'text' );
		//var_dump($setting);
	}
	
	function validate_settings( $input )
	{
	    // Do your settings validation here
	    // Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
    	return $input;
	}

}


require_once( 'pure-themes-member-settings.php' );
require_once( 'custom-post-types-order.php' );



/* PureMembers Loop */
function pure_get_member(){
	$sectiontitle = PMSF_get_setting( 'pure_plugin', 'general', 'title-text' );
	$puremember = '<div class="pure_member_area">
					<div class="pure_container">
						<div class="pure_row">
							<div class="pure_col-lg-12 center">
								<h1 class="pure_member_h">'.$sectiontitle.'</h1>
							</div>
						</div>
					</div>
					<div class="pure_container">
						<div class="pure_row">';
	$efs_query = "post_type=pure-members&posts_per_page=4";
	query_posts($efs_query);
	if (have_posts()) : while (have_posts()) : the_post(); 
		$img = get_the_post_thumbnail( $post->ID, 'pure-member-img' );	
		$membername = get_the_title(); 
		$memberdes = get_post_meta( get_the_ID(), 'pure-member-designation', true);
		$facebooklink = get_post_meta( get_the_ID(), 'pure-member-facebook-link', true);
		$twitterlink = get_post_meta( get_the_ID(), 'pure-member-twitter-link', true);
		$dribbblelink = get_post_meta( get_the_ID(), 'pure-member-dribbble-link', true);
		$membercontent = get_the_content();
		$puremember.='<div class="pure_col-lg-3 pure_col-md-3 pure_col-sm-6 pure_col-xs-12">
						<div class="member_single" id="grow">
							<div class="member_name">
								<h2>'.$membername.'</h2>
							</div>
							<div class="member_photo">
								'.$img.'
							</div>
							<div class="member_bottom">
								<div class="member_des">
									<h3>'.$memberdes.'</h3>
								</div>
								<div class="member_social">
									<a class="facebook" href="'.$facebooklink.'" target="_blank"><i class="fa fa-facebook"></i></a>
									<a class="twitter" href="'.$twitterlink.'" target="_blank"><i class="fa fa-twitter"></i></a>
									<a class="dribbble" href="'.$dribbblelink.'" target="_blank"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
						</div>
					</div>';		
	endwhile; endif; wp_reset_query();
	$puremember.= '</div></div></div>';
	return $puremember;
}

/**add the shortcode for the content- for use in editor**/
function pure_insert_member($atts, $content=null){
	$puremember= pure_get_member();
	return $puremember;
}
add_shortcode('pure_all_members', 'pure_insert_member');
add_filter('widget_text', 'do_shortcode');

/**add template tag- for use in themes**/
function pure_member(){
	print pure_get_member();
}

new PMSFTest();

?>