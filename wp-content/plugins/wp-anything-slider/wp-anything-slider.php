<?php
/*
Plugin Name: Wp anything slider
Plugin URI: http://www.gopiplus.com/work/2012/04/20/wordpress-plugin-wp-anything-slider/
Description: Wp anything slider plug-in let you to create the sliding slideshow gallery into your posts and pages. In the admin we have Tiny MCE HTML editor to add, update the content. using this HTML editor we can add HTML text and can upload the images and video files.
Author: Gopi Ramasamy
Version: 7.8
Author URI: http://www.gopiplus.com/work/2012/04/20/wordpress-plugin-wp-anything-slider/
Donate link: http://www.gopiplus.com/work/2012/04/20/wordpress-plugin-wp-anything-slider/
Tags: Wordpress, plugin, slider
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-anything-slider
Domain Path: /languages
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_ANYTHING_SETTINGS", $wpdb->prefix . "wpanything_settings");
define("WP_ANYTHING_CONTENT", $wpdb->prefix . "wpanything_content");
define('Wp_wpanything_FAV', 'http://www.gopiplus.com/work/2012/04/20/wordpress-plugin-wp-anything-slider/');

if ( ! defined( 'WP_wpanything_BASENAME' ) )
	define( 'WP_wpanything_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_wpanything_PLUGIN_NAME' ) )
	define( 'WP_wpanything_PLUGIN_NAME', trim( dirname( WP_wpanything_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_wpanything_PLUGIN_URL' ) )
	define( 'WP_wpanything_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_wpanything_PLUGIN_NAME );
	
if ( ! defined( 'WP_wpanything_ADMIN_URL' ) )
	define( 'WP_wpanything_ADMIN_URL', get_option('siteurl') . '/wp-admin/options-general.php?page=wp-anything-slider' );

function wpanything($setting) 
{
	global $wpdb;
	$sSql = "select wpanything_sid, wpanything_sname, wpanything_sdirection,";
	$sSql = $sSql . " wpanything_sspeed, wpanything_stimeout, wpanything_srandom from ". WP_ANYTHING_SETTINGS ." where 1=1";
	$sSql = $sSql . " and wpanything_sname='".strtoupper($setting)."'";
	$wpcycletxt_settings = $wpdb->get_results($sSql);
	if ( ! empty($wpcycletxt_settings) ) 
	{
			$settings = $wpcycletxt_settings[0];
			$wpanything_sname = $settings->wpanything_sname; 
			$wpanything_sdirection = $settings->wpanything_sdirection; 
			$wpanything_sspeed = $settings->wpanything_sspeed; 
			$wpanything_stimeout = $settings->wpanything_stimeout; 
			$wpanything_srandom = $settings->wpanything_srandom; 
	}
	?>
	<!-- begin WP-ANYTHING -->
	<div id="WP-ANYTHING-<?php echo $wpanything_sname; ?>">
	<?php
	$sSql = "select wpanything_cid, wpanything_ctitle from ". WP_ANYTHING_CONTENT ." where 1=1";
	//$sSql = $sSql . " and (`wpanything_cstartdate` <= NOW() and `wpanything_cenddate` >= NOW())";
	$sSql = $sSql . " and wpanything_csetting='".strtoupper($setting)."'";
	$wpcycletxt = $wpdb->get_results($sSql);
	if ( ! empty($wpcycletxt) ) 
	{
		foreach ( $wpcycletxt as $text ) 
		{
			$wpanything_ctitle = stripslashes($text->wpanything_ctitle);
			?>
            <div id="anything"><?php echo $wpanything_ctitle; ?></div>
			<?php 
		}
	}
	?>
	</div>
    <script type="text/javascript">
    jQuery(function() {
	jQuery('#WP-ANYTHING-<?php echo strtoupper($setting); ?>').cycle({
		fx: '<?php echo @$wpanything_sdirection; ?>',
		speed: <?php echo @$wpanything_sspeed; ?>,
		timeout: <?php echo @$wpanything_stimeout; ?>
	});
	});
	</script>
    <!-- end WP-ANYTHING -->
	<?php
}

function wpanything_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_ANYTHING_SETTINGS . "'") != WP_ANYTHING_SETTINGS) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_ANYTHING_SETTINGS . "` (
			  `wpanything_sid` int(11) NOT NULL auto_increment,
			  `wpanything_sname` VARCHAR( 10 ) NOT NULL,
			  `wpanything_sdirection` VARCHAR( 12 ) NOT NULL default 'scrollLeft',
			  `wpanything_sspeed` int(11) NOT NULL default '700',
			  `wpanything_stimeout` int(11) NOT NULL default '5000',
			  `wpanything_srandom` VARCHAR( 3 ) NOT NULL default 'YES',
			  `wpanything_sextra` VARCHAR( 100 ) NOT NULL,
			  PRIMARY KEY  (`wpanything_sid`) )
			");
		$iIns = "INSERT INTO `". WP_ANYTHING_SETTINGS . "` (`wpanything_sname`)"; 
		
		for($i=1; $i<=10; $i++)
		{
			$sSql = $iIns . " VALUES ('SETTING".$i."')";
			$wpdb->query($sSql);
		}
	}
	if($wpdb->get_var("show tables like '". WP_ANYTHING_CONTENT . "'") != WP_ANYTHING_CONTENT) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_ANYTHING_CONTENT . "` (
			  `wpanything_cid` int(11) NOT NULL auto_increment,
			  `wpanything_ctitle` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
			  `wpanything_cstartdate` datetime NOT NULL default '2012-01-01 00:00:00',
			  `wpanything_cenddate` datetime NOT NULL default '2020-12-30 00:00:00',
			  `wpanything_csetting` VARCHAR( 12 ) NOT NULL,
			  PRIMARY KEY  (`wpanything_cid`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			");
		$iIns = "INSERT INTO `". WP_ANYTHING_CONTENT . "` (`wpanything_ctitle`, `wpanything_csetting`)"; 
		
		for($i=1; $i<=6; $i++)
		{
			if($i >= 1 and $i<=2) { $j = 1; } elseif ($i >= 3 and $i<=4) { $j = 2; } else { $j = 3; }
			$sSql = $iIns . " VALUES ('Lorem Ipsum is simply dummy text of the printing industry ".$i.".', 'SETTING".$j."')";
			$wpdb->query($sSql);
		}
	}
	add_option('wpanything_title', "Announcement");
}

function wpanything_control() 
{
	$wpanything_title = get_option('wpanything_title');
	if (isset($_POST['wpanything_submit'])) 
	{
		$wpanything_title = stripslashes($_POST['wpanything_title']);
		update_option('wpanything_title', $wpanything_title );
	}
	
	echo '<p>'.__('Title:', 'wp-anything-slider').'<br><input  style="width: 200px;" type="text" value="';
	echo $wpanything_title . '" name="wpanything_title" id="vsrru_title" /></p>';
	echo '<input type="hidden" id="wpanything_submit" name="wpanything_submit" value="1" />';
}

function wpanything_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('wpanything_title');
	echo $after_title;
	wpanything('setting1');
	echo $after_widget;
}

function wpanything_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'add':
			include('pages/content-add.php');
			break;
		case 'edit':
			include('pages/content-edit.php');
			break;
		case 'editcycle':
			include('pages/cycle-setting-edit.php');
			break;
		case 'showcycle':
			include('pages/cycle-setting-show.php');
			break;
		default:
			include('pages/content-show.php');
			break;
	}
}

function wpanything_shortcode( $atts ) 
{
	global $wpdb;

	// [wp-anything-slider setting="SETTING1"]	
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$setting = $atts['setting'];
	
	$wpcycle = "";
	$sSql = "select wpanything_sid, wpanything_sname, wpanything_sdirection,";
	$sSql = $sSql . " wpanything_sspeed, wpanything_stimeout, wpanything_srandom from ". WP_ANYTHING_SETTINGS ." where 1=1";
	$sSql = $sSql . " and wpanything_sname='".strtoupper($setting)."'";
	$wpcycletxt_settings = $wpdb->get_results($sSql);
	if ( ! empty($wpcycletxt_settings) ) 
	{
			$settings = $wpcycletxt_settings[0];
			$wpanything_sname = $settings->wpanything_sname; 
			$wpanything_sdirection = $settings->wpanything_sdirection; 
			$wpanything_sspeed = $settings->wpanything_sspeed; 
			$wpanything_stimeout = $settings->wpanything_stimeout; 
			$wpanything_srandom = $settings->wpanything_srandom; 
	}
	$wpcycle = $wpcycle . '<div id="WP-ANYTHING-'.$wpanything_sname.'">';
	$sSql = "select wpanything_cid, wpanything_ctitle from ". WP_ANYTHING_CONTENT ." where 1=1";
	//$sSql = $sSql . " and (`wpanything_cstartdate` <= NOW() and `wpanything_cenddate` >= NOW())";
	$sSql = $sSql . " and wpanything_csetting='".strtoupper($setting)."'";
	$wpcycletxt = $wpdb->get_results($sSql);
	if ( ! empty($wpcycletxt) ) 
	{
		foreach ( $wpcycletxt as $text ) 
		{
			$wpanything_ctitle = stripslashes($text->wpanything_ctitle);
            $wpcycle = $wpcycle . '<div id="anything">' . $wpanything_ctitle . '</div>';
		}
	}

	$wpcycle = $wpcycle . '</div>';
	$wpcycle = $wpcycle . '<script type="text/javascript">';
    $wpcycle = $wpcycle . 'jQuery(function() {';
	$wpcycle = $wpcycle . "jQuery('#WP-ANYTHING-".strtoupper($setting)."').cycle({fx: '".$wpanything_sdirection."',speed: " . $wpanything_sspeed . ",timeout: " . $wpanything_stimeout . "";
	$wpcycle = $wpcycle . '});';
	$wpcycle = $wpcycle . '});';
	$wpcycle = $wpcycle . '</script>';
	
	return $wpcycle;
}

function wpanything_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget( __('Wp Anything Slider', 'wp-anything-slider'), 
				__('Wp Anything Slider', 'wp-anything-slider'), 'wpanything_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control( __('Wp Anything Slider', 'wp-anything-slider'), 
				array( __('Wp Anything Slider', 'wp-anything-slider'), 'widgets'), 'wpanything_control');
	} 
}

function wpanything_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page( __('Wp Anything Slider', 'wp-anything-slider'), 
				__('Wp Anything Slider', 'wp-anything-slider'), 'manage_options', 'wp-anything-slider', 'wpanything_admin_options' );
	}
}

function wpanything_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'jquery.cycle.all.min', WP_wpanything_PLUGIN_URL.'/js/jquery.cycle.all.min.js');
		wp_enqueue_style( 'wp-anything-slider', WP_wpanything_PLUGIN_URL.'/wp-anything-slider.css');
	}	
}

function wpanything_deactivation() 
{
	// No action required.
}

function wpanything_textdomain() 
{
	  load_plugin_textdomain( 'wp-anything-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'wpanything_textdomain');
add_shortcode( 'wp-anything-slider', 'wpanything_shortcode' );
add_action('admin_menu', 'wpanything_add_to_menu');
add_action('wp_enqueue_scripts', 'wpanything_add_javascript_files');
add_action("plugins_loaded", "wpanything_init");
register_activation_hook(__FILE__, 'wpanything_install');
register_deactivation_hook(__FILE__, 'wpanything_deactivation');
?>