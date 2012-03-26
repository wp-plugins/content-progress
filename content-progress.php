<?php
/*
Plugin Name: Content Progress
Plugin URI: http://www.joedolson.com/articles/content-progress/
Description: Adds a column to each post/page or custom post type indicating whether content has been added to the page.
Version: 1.2.0
Author: Joseph Dolson
Author URI: http://www.joedolson.com/
*/
/*  Copyright 2008-2012  Joseph C Dolson  (email : plugins@joedolson.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Prepend the new column to the columns array
global $cp_version;
$cp_version = '1.2.0';

load_plugin_textdomain( 'content-progress', false, dirname( plugin_basename( __FILE__ ) ) );


function cp_column($cols) {
	$cols['cp'] = __('Flag','content-progress');
	$cols['cp_notes'] = __('Notes','content-progress');
	return $cols;
}

// Echo the ID for the new column
function cp_value($column_name, $id) {
	if ($column_name == 'cp') {
		$post = get_post($id);
		$marked = get_post_meta($id,'_cp_incomplete',true);
		$content = $post->post_content;
		if ( $content == '' && $marked=='default' ) {
			echo "<img src='".plugins_url( 'images/empty.png', __FILE__ )."' alt='".__('Document is empty','content-progress')."' class='$marked' title='".__('Document is empty','content-progress')."' />";
		} else if ( strlen($content) < 60 && $marked=='default' ) {
			echo "<img src='".plugins_url( 'images/partial.png', __FILE__ )."' alt='".__('Document has less than 60 characters of content.','content-progress')."' class='$marked' title='".__('Document has less than 60 characters of content.','content-progress')."' />";	
		} else if ( $marked == 'true' ) {
			echo "<img src='".plugins_url( 'images/incomplete.png', __FILE__ )."' alt='".__('Manually marked incomplete.','content-progress')."' class='$marked' title='".__('Manually marked incomplete.','content-progress')."' />";
		} else if ( $marked == 'complete' ) {
			echo "<img src='".plugins_url( 'images/complete.png', __FILE__ )."' alt='".__('Manually marked complete.','content-progress')."' class='$marked' title='".__('Manually marked complete.','content-progress')."' />";
		} else if ( $marked == 'review' ) {
			echo "<img src='".plugins_url( 'images/review.png', __FILE__ )."' alt='".__('Needs Editorial Review.','content-progress')."' class='$marked' title='".__('Needs Editorial Review.','content-progress')."' />";
		}		
	}
	if ($column_name == 'cp_notes') {
		$notes = get_post_meta( $id, '_cp_notes',true );
		echo "$notes";
	}
}

function cp_return_value($value, $column_name, $id) {
	if ( $column_name == 'cp' || $column_name == 'cp_notes' ) {
		$value = $id;
	}
	return $value;
}

// Output CSS for width of new column
function cp_css() {
?>
<style type="text/css">
#cp { width: 40px; } 
#cp_notes { width: 120px; }
.inline-edit-col-left legend { text-transform:uppercase; font-weight: 700; }	
</style>
<?php	
}

// Actions/Filters for various tables and the css output
function cp_add() {
	$settings = get_option( 'cp_settings' );
	add_action('admin_head', 'cp_css');
	
	if ( in_array( 'post', $settings ) ) {
		add_filter('manage_posts_columns', 'cp_column');
		add_action('manage_posts_custom_column', 'cp_value', 10, 2);
	}
	if ( in_array( 'page', $settings ) ) {
		add_filter('manage_pages_columns', 'cp_column');
		add_action('manage_pages_custom_column', 'cp_value', 10, 2);
	}
	foreach ( get_post_types() as $types ) {
		if ( in_array( $types, $settings ) ) {
			add_action("manage_${types}_columns", 'cp_column');			
			add_filter("manage_${types}_custom_column", 'cp_return_value', 10, 3);
		}
	}

}

add_action('admin_init', 'cp_add');

function cp_list_empty_pages( $post_type, $group ) {
	if ( is_user_logged_in() ) {
	$posts = get_posts( array( 'post_type'=>$post_type,'numberposts'=>-1,'orderby'=>'title' ) ); 
		foreach ( $posts as $post ) {
			switch ($group) {
				case 'empty':
				if ( $post->post_content == '' && get_post_meta($post->ID,'_cp_incomplete',true ) != 'complete' ) {
					$return .= "<li><a href='".esc_url(get_permalink( $post->ID ))."'>$post->post_title</a></li>";
				}
				break;
				case 'incomplete':
				if ( strlen($post->post_content) < 60 && get_post_meta($post->ID,'_cp_incomplete',true ) != 'complete' ) {
					$return .= "<li><a href='".esc_url(get_permalink( $post->ID ))."'>$post->post_title</a></li>";
				}				
				break;
				case 'partial':
				if ( get_post_meta($post->ID,'_cp_incomplete',true ) == 'true' ) {
					$return .= "<li><a href='".esc_url(get_permalink( $post->ID ))."'>$post->post_title</a></li>";
				}				
				break;
				case 'review':
				if ( get_post_meta($post->ID,'_cp_incomplete',true ) == 'review' ) {
					$return .= "<li><a href='".esc_url(get_permalink( $post->ID ))."'>$post->post_title</a></li>";
				}				
				break;				
			}
		}
		$group_string = ucfirst($group);
	return "<h2>$group_string pages:</h2> <ul>".$return."</ul>";
	}
}

//Shortcodes:  [empty], [partial], and [incomplete]
function list_empty($atts) {
	extract(shortcode_atts(array(
				'post_type' => 'page',
				'group' => 'empty'
			), $atts));
	return cp_list_empty_pages($type, $group);
}
add_shortcode('empty','list_empty');

function list_partial($atts) {
	extract(shortcode_atts(array(
				'post_type' => 'page',
				'group' => 'partial'
			), $atts));
	return cp_list_empty_pages($type, $group);
}
add_shortcode('partial','list_partial');

function list_incomplete($atts) {
	extract(shortcode_atts(array(
				'post_type' => 'page',
				'group' => 'incomplete'
			), $atts));
	return cp_list_empty_pages($type, $group);
}
add_shortcode('incomplete','list_incomplete');

function list_review($atts) {
	extract(shortcode_atts(array(
				'post_type' => 'page',
				'group' => 'review'
			), $atts));
	return cp_list_empty_pages($type, $group);
}
add_shortcode('needs_review','list_review');

add_action('quick_edit_custom_box', 'cp_quickedit_show', 10, 2);
 
function cp_quickedit_show( $col, $type ) {
	$settings = get_option( 'cp_settings' );
	if ( in_array( $type, $settings ) ) {
		if ( $col == 'cp' ) {
			$label = 'Flag';
			$name = '_cp_incomplete';
			$field = "<select name='$name' id='$name'>
						<option value='review'>Needs Review</option>
						<option value='true'>Mark as incomplete</option>
						<option value='complete'>Mark as complete</option>
						<option value='default'>Default</option>
					</select>";
			$fieldset = "<fieldset class=\"inline-edit-col-left inline-edit-$type\"><legend>".__('Content Progress','content-progress')."</legend>";
			$close_fieldset = "";		
		} else if ( $col == 'cp_notes' ) {
			$label = 'Notes';
			$name = '_cp_notes';
			$field = "<textarea rows='1' cols='22' name='$name' id='$name'></textarea>";
			$fieldset = '';
			$close_fieldset = "</fieldset>";
		}
	}
?>
<?php echo $fieldset; ?>
<div class="inline-edit-col inline-edit-<?php echo $col; ?>">
<div class="inline-edit-group"><label for="<?php echo $name; ?>"><span class="title"><?php echo $label; ?></span></label>
 <?php echo $field; ?>
</div>
</div><?php echo $close_fieldset; ?>
<?php 
}

add_action('admin_footer-edit.php', 'cp_admin_edit_foot', 11 );

/* load scripts in the footer */
function cp_admin_edit_foot() {
    echo '<script type="text/javascript" src="', plugins_url('scripts/admin_edit.js', __FILE__), '"></script>';
}

function cp_post_meta( $id ) {
	if ( isset( $_POST['_cp_incomplete'] ) ) {
		$incomplete = $_POST[ '_cp_incomplete' ];
		update_post_meta( $id, '_cp_incomplete', $incomplete );			
	}
	if ( isset( $_POST['_cp_notes'] ) ) {
		$notes = $_POST[ '_cp_notes' ];
		update_post_meta( $id, '_cp_notes', $notes );
	}
}

add_action( 'save_post','cp_post_meta', 10 );

add_action( 'in_plugin_update_message-content-progress/content-progress.php', 'cp_plugin_update_message' );
function cp_plugin_update_message() {
	global $cp_version;
	define('CP_PLUGIN_README_URL',  'http://svn.wp-plugins.org/content-progress/trunk/readme.txt');
	$response = wp_remote_get( CP_PLUGIN_README_URL, array ('user-agent' => 'WordPress/Content Progress' . $cp_version . '; ' . get_bloginfo( 'url' ) ) );
	if ( ! is_wp_error( $response ) || is_array( $response ) ) {
		$data = $response['body'];
		$bits=explode('== Upgrade Notice ==',$data);
		echo '<div id="mc-upgrade"><p><strong style="color:#c22;">Upgrade Notes:</strong> '.nl2br(trim($bits[1])).'</p></div>';
	} else {
		printf(__('<br /><strong>Note:</strong> Please review the <a class="thickbox" href="%1$s">changelog</a> before upgrading.','content-progress'),'plugin-install.php?tab=plugin-information&amp;plugin=content-progress&amp;TB_iframe=true&amp;width=640&amp;height=594');
	}
}

function cp_add_outer_box() {
	if ( function_exists( 'add_meta_box' )) {
		foreach ( get_post_types() as $value) {
			add_meta_box( 'cp_div','Content Progress', 'cp_add_inner_box', $value, 'side' );
		}
	}
}
function cp_add_inner_box() {
	global $post_id;
	$cp = get_post_meta($post_id, '_cp_incomplete',true );
	$notes = get_post_meta($post_id, '_cp_notes',true );
	if ( $cp == 'true' ) { $tchecked = ' checked="checked"'; } else { $tchecked = ''; }
	if ( $cp == 'complete' ) { $cchecked = ' checked="checked"'; } else { $cchecked = ''; }
	if ( $cp == 'review' ) { $rchecked = ' checked="checked"'; } else { $rchecked = ''; }	
	if ( $cp == 'default' || !$cp ) { $dchecked = ' checked="checked"'; } else { $dchecked = ''; }
	echo "<ul>";
	echo "<li><input type='radio' name='_cp_incomplete' value='true' id='_cp_incomplete'$tchecked /> <label for='_cp_incomplete'>".__('Mark as incomplete','content-progress')."</label></li>";
	echo "<li><input type='radio' name='_cp_incomplete' value='complete' id='_cp_incomplete'$cchecked /> <label for='_cp_incomplete'>".__('Mark as complete','content-progress')."</label></li>";
	echo "<li><input type='radio' name='_cp_incomplete' value='review' id='_cp_incomplete'$rchecked /> <label for='_cp_incomplete'>".__('Mark as "Needs Review"','content-progress')."</label></li>";	
	echo "<li><input type='radio' name='_cp_incomplete' value='default' id='_cp_incomplete'$dchecked /> <label for='_cp_incomplete'>".__('Default','content-progress')."</label></li>";
	echo "</ul>";
	echo "<p><label for='_cp_notes'>".__('Notes:','content-progress')."</label><br /><textarea name='_cp_notes' id='_cp_notes'>$notes</textarea></p>";
}
add_action( 'admin_menu','cp_add_outer_box' );

function cp_get_support_form() {
global $current_user, $cp_version;
get_currentuserinfo();
	// send fields for Content Progress
	$version = $cp_version;
	// send fields for all plugins
	$wp_version = get_bloginfo('version');
	$home_url = home_url();
	$wp_url = get_bloginfo('wpurl');
	$language = get_bloginfo('language');
	$charset = get_bloginfo('charset');
	// server
	$php_version = phpversion();

	// theme data
	$theme_path = get_stylesheet_directory().'/style.css';
	$theme = get_theme_data($theme_path);
		$theme_name = $theme['Name'];
		$theme_uri = $theme['URI'];
		$theme_parent = $theme['Template'];
		$theme_version = $theme['Version'];
	// plugin data
	$plugins = get_plugins();
	$plugins_string = '';
		foreach( array_keys($plugins) as $key ) {
			if ( is_plugin_active( $key ) ) {
				$plugin =& $plugins[$key];
				$plugin_name = $plugin['Name'];
				$plugin_uri = $plugin['PluginURI'];
				$plugin_version = $plugin['Version'];
				$plugins_string .= "$plugin_name: $plugin_version; $plugin_uri\n";
			}
		}
	$data = "
================ Installation Data ====================
==Content Progress:==
Version: $version

==WordPress:==
Version: $wp_version
URL: $home_url
Install: $wp_url
Language: $language
Charset: $charset

==Extra info:==
PHP Version: $php_version
Server Software: $_SERVER[SERVER_SOFTWARE]
User Agent: $_SERVER[HTTP_USER_AGENT]

==Theme:==
Name: $theme_name
URI: $theme_uri
Parent: $theme_parent
Version: $theme_version

==Active Plugins:==
$plugins_string
";
	if ( isset($_POST['cp_support']) ) {
		$nonce=$_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce,'content-progress-nonce') ) die("Security check failed");	
		$request = stripslashes($_POST['support_request']);
		$has_donated = ( $_POST['has_donated'] == 'on')?"Donor":"No donation";
		$has_read_faq = ( $_POST['has_read_faq'] == 'on')?"Read FAQ":true; // has no faq, for now.
		$subject = "Content Progress support request. $has_donated";
		$message = $request ."\n\n". $data;
		$from = "From: \"$current_user->display_name\" <$current_user->user_email>\r\n";

		if ( !$has_read_faq ) {
			echo "<div class='message error'><p>".__('Please read the FAQ and other Help documents before making a support request.','content-progress')."</p></div>";
		} else {
			wp_mail( "plugins@joedolson.com",$subject,$message,$from );
		
			if ( $has_donated == 'Donor' ) {
				echo "<div class='message updated'><p>".__('Thank you for supporting the continuing development of this plug-in! I\'ll get back to you as soon as I can.','content-progress')."</p></div>";		
			} else {
				echo "<div class='message updated'><p>".__('I\'ll get back to you as soon as I can, after dealing with any support requests from plug-in supporters.','content-progress')."</p></div>";				
			}
		}
	} else {
		$request = '';
	}
	echo "
	<form method='post' action='".admin_url('options-general.php?page=content-progress/content-progress.php')."'>
		<div><input type='hidden' name='_wpnonce' value='".wp_create_nonce('content-progress-nonce')."' /></div>
		<div>
		<p>".
		__('Please note: I do keep records of those who have donated, but if your donation came from somebody other than your account at this web site, please note this in your message.','content-progress')
		."<!--<p>
		<input type='checkbox' name='has_read_faq' id='has_read_faq' value='on' /> <label for='has_read_faq'>".__('I have read <a href="http://www.joedolson.com/articles/content-progress/">the FAQ for this plug-in</a>.','content-progress')." <span>(required)</span></label>
		</p>-->
		<p>
		<input type='checkbox' name='has_donated' id='has_donated' value='on' /> <label for='has_donated'>".__('I have <a href="http://www.joedolson.com/donate.php">made a donation to help support this plug-in</a>.','content-progress')."</label>
		</p>
		<p>
		<label for='support_request'>Support Request:</label><br /><textarea name='support_request' id='support_request' cols='80' rows='10'>".stripslashes($request)."</textarea>
		</p>
		<p>
		<input type='submit' value='".__('Send Support Request','content-progress')."' name='cp_support' class='button-primary' />
		</p>
		<p>".
		__('The following additional information will be sent with your support request:','content-progress')
		."</p>
		<div class='cp_support'>
		".wpautop($data)."
		</div>
		</div>
	</form>";
}


function cp_settings() {
	if ( isset($_POST['cp_settings']) ) {
		$nonce=$_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce,'content-progress-nonce') ) die("Security check failed");	
		$settings = $_POST['cp_post_types'];
		update_option( 'cp_settings', $settings );
	}
	$settings = get_option( 'cp_settings' );
	$post_types = get_post_types( array('public'=>true), 'objects' );
	$cp_post_types = $settings;
	$my_post_types = '';
		foreach( $post_types as $type ) {
			if ( in_array(  $type->name , $cp_post_types ) || empty($cp_post_types) ) { $selected = ' selected="selected"'; } else { $selected = ''; }
			$my_post_types .= "<option value='$type->name'$selected>$type->name</option>";
		}				

	
	echo "
	<form method='post' action='".admin_url('options-general.php?page=content-progress/content-progress.php')."'>
		<div><input type='hidden' name='_wpnonce' value='".wp_create_nonce('content-progress-nonce')."' /></div>
		<div>
		<p>
		<label for='post_types'>".__('Enabled for these post types:','content-progress')."</label><br />
		<select multiple='multiple' name='cp_post_types[]' id='post_types'>
		$my_post_types;
		</select>
		</p>
		<p>
		<input type='submit' value='".__('Update Settings','content-progress')."' name='cp_settings' class='button-primary' />
		</p>
		</div>
	</form>";
}

function cp_support_page() {
?>
<div class="wrap">
<div class="cp-settings" id="poststuff">
<div class="postbox" id="settings">
<h3><?php _e('Content Progress Settings','content-progress'); ?></h3>
<div class="inside">
<?php cp_show_support_box(); ?>

<?php cp_settings(); ?>

<h4><?php _e('Icon guide:','content-progress'); ?></h4>
<ul class="icon-guide">
<?php 
	echo "<li><img src='".plugins_url( 'images/empty.png', __FILE__ )."' alt='".__('Document is empty','content-progress')."' />".__('Document is empty','content-progress')."</li>
	<li><img src='".plugins_url( 'images/partial.png', __FILE__ )."' alt='".__('Document has less than 60 characters of content.','content-progress')."' />".__('Document has less than 60 characters of content.','content-progress')."</li>
	<li><img src='".plugins_url( 'images/incomplete.png', __FILE__ )."' alt='".__('Manually marked incomplete.','content-progress')."' />".__('Manually marked incomplete.','content-progress')."</li>
	<li><img src='".plugins_url( 'images/complete.png', __FILE__ )."' alt='".__('Manually marked complete.','content-progress')."' />".__('Manually marked complete.','content-progress')."</li>
	<li><img src='".plugins_url( 'images/review.png', __FILE__ )."' alt='".__('Needs Editorial Review.','content-progress')."' />".__('Needs Editorial Review.','content-progress')."</li>";
?>
</ul>
</div>
</div>
</div>
<div class="cp-support" id="poststuff">
<div class="postbox" id="get-support">
<h3><?php _e('Get Plug-in Support','content-progress'); ?></h3>
<div class="inside">
<?php cp_show_support_box(); ?>

<?php cp_get_support_form(); ?>
</div>
</div>
</div>
</div>
<?php
}

function cp_show_support_box() {
?>
<div id="support">
	<div class="resources">
	<ul>
		<li><strong><a href="http://www.joedolson.com/donate.php" rel="external"><?php _e("Make a Donation",'content-progress'); ?></a></strong></li>
		<li><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<div>
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="86NC6DRYKH5DS" />
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="Make a gift to support Content Progress!" />
			<img alt="" src="https://www.paypalobjects.com/WEBSCR-640-20110429-1/en_US/i/scr/pixel.gif" width="1" height="1" />
			</div>
		</form>
		</li>
		<li><a href="http://profiles.wordpress.org/users/joedolson/"><?php _e('Check out my other plug-ins','content-progress'); ?></a></li>
		<li><a href="http://wordpress.org/extend/plugins/content-progress/"><?php _e('Rate this plug-in','content-progress'); ?></a></li>		
	</ul>
	</div>
</div>
<?php
}

// Add the administrative settings to the "Settings" menu.
function cp_add_support_page() {
    if ( function_exists( 'add_submenu_page' ) ) {
		 $plugin_page = add_options_page( 'Content Progress Support', 'Content Progress', 'manage_options', __FILE__, 'cp_support_page' );
		 add_action( 'admin_head-'. $plugin_page, 'cp_styles' );
    }
 }
function cp_styles() {
	if ( $_GET['page'] == "content-progress/content-progress.php" ) {
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url('cp-styles.css', __FILE__ ).'" />';
	}
}
add_action( 'admin_menu', 'cp_add_support_page' );

function cp_plugin_action($links, $file) {
	if ($file == plugin_basename(dirname(__FILE__).'/content-progress.php')) {
		$links[] = "<a href='options-general.php?page=content-progress/content-progress.php'>" . __('Get Support', 'content-progress', 'content-progress') . "</a>";
		$links[] = "<a href='http://www.joedolson.com/donate.php'>" . __('Donate', 'content-progress', 'content-progress') . "</a>";
	}
	return $links;
}
//Add Plugin Actions to WordPress

add_filter('plugin_action_links', 'cp_plugin_action', -10, 2);