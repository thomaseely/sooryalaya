<?php
/**
 * Plugin Name: Woocomemrce Booking & Rental
 * Plugin URI: http://example.com
 * Description: Rental and booking with woocommerce
 * Version: 1.0.0
 * Author: RedQ Team
 * Author URI: http://redqteam.com
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: rental
 * Domain Path: /languages
 *
 */

if ( ! defined( 'ABSPATH' ) )
    exit;

/**
* RedQ_Rental_And_Bookings
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	class RedQ_Rental_And_Bookings{

		/**
		 * Plugin data from get_plugins()
		 *
		 * @since 1.0
		 * @var object
		 */
		public $plugin_data;

		/**
		 * Includes to load
		 *
		 * @since 1.0
		 * @var array
		 */
		public $includes;

		/**
		 * Plugin Action and Filter Hooks
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function __construct(){
			add_action('plugins_loaded' , array($this, 'redq_rental_set_plugins_data'), 1);
			add_action('plugins_loaded' , array($this, 'redq_rental_define_constants'), 1);
			add_action('plugins_loaded' , array($this, 'redq_rental_set_includes'), 1);
			add_action('plugins_loaded' , array($this, 'redq_rental_load_includes'), 1);
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles_and_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles_and_scripts' ) );
			add_action('woocommerce_redq_rental_add_to_cart', array($this, 'redq_add_to_cart'),30);
			add_action( 'plugins_loaded', array( $this, 'redq_support_multilanguages' ) );
		}


		public function redq_rental_set_plugins_data(){
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$plugin_dir = plugin_basename( dirname( __FILE__ ) );
			$plugin_data = current( get_plugins( '/' . $plugin_dir ) );
			$this->plugin_data = apply_filters( 'redq_plugin_data', $plugin_data );
		}


		/**
		 * Plugin constant define
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function redq_rental_define_constants(){
			define( 'REDQ_RENTAL_VERSION', 		$this->plugin_data['Version'] );					// plugin version
			define( 'REDQ_RENTAL_FILE', 		__FILE__ );											// plugin's main file path
			define( 'REDQ_RENTAL_DIR', 			dirname( plugin_basename( REDQ_RENTAL_FILE ) ) );			// plugin's directory
			define( 'REDQ_RENTAL_PATH',			untrailingslashit( plugin_dir_path( REDQ_RENTAL_FILE ) ) );	// plugin's directory path
			define( 'REDQ_RENTAL_URL', 			untrailingslashit( plugin_dir_url( REDQ_RENTAL_FILE ) ) );	// plugin's directory URL

			define( 'REDQ_RENTAL_INC_DIR',		'includes' );	// includes directory
			define( 'REDQ_RENTAL_ASSETS_DIR', 		'assets' );		// assets directory
			define( 'REDQ_RENTAL_LANG_DIR', 	'languages' );	// languages directory
			define( 'REDQ_ROOT_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
			define( 'REDQ_PACKAGE_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );
		}


		/**
		 * Plugin includes files
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function redq_rental_set_includes(){

			$this->includes = apply_filters('redq_rental' , array(
				'admin' => array(
					REDQ_RENTAL_INC_DIR . '/admin/class-redq-rental-meta-boxes.php',
				),
				'frontends' => array(
					REDQ_RENTAL_INC_DIR . '/class-redq-product-redq_rental.php',
					REDQ_RENTAL_INC_DIR . '/class-redq-product-cart.php',
					REDQ_RENTAL_INC_DIR . '/class-redq-product-tabs.php',
				)
			));
		}


		/**
		 * Plugin includes files
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function redq_rental_load_includes() {

			$includes = $this->includes;

			foreach ( $includes as $condition => $files ) {
				$do_includes = false;
				switch( $condition ) {
					case 'admin':
						if ( is_admin() ) {
							$do_includes = true;
						}
						break;
					case 'frontend':
						if ( ! is_admin() ) {
							$do_includes = true;
						}
						break;
					default:
						$do_includes = true;
						break;
				}

				if ( $do_includes ) {
					foreach ( $files as $file ) {
						require_once trailingslashit( REDQ_RENTAL_PATH ) . $file;
					}
				}
			}
		}


		/**
		 * Plugin enqueues admin stylesheet and scripts
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function admin_styles_and_scripts(){

			global $post, $woocommerce, $wp_scripts;

			wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css');


	  		wp_register_style('redq-admin', REDQ_ROOT_URL. '/assets/css/redq-admin.css', array(), $ver = false, $media = 'all');
	  		wp_enqueue_style('redq-admin');

	  		wp_register_script( 'icon-picker',REDQ_ROOT_URL . '/assets/js/icon-picker.js', array('jquery'), $ver = true, true);
			wp_enqueue_script( 'icon-picker' );

			wp_register_script( 'redq_rental_writepanel_js', REDQ_ROOT_URL . '/assets/js/writepanel.js', array( 'jquery', 'jquery-ui-datepicker' ), true );
			wp_enqueue_script('redq_rental_writepanel_js');

			wp_enqueue_script('jquery-ui-datepicker');

			$params = array(
				'post'                   => isset( $post->ID ) ? $post->ID : '',
				'plugin_url'             => $woocommerce->plugin_url(),
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'calendar_image'         => $woocommerce->plugin_url() . '/assets/images/calendar.png',
				'all_data' => $this->reqd_all_booking_data(),
			);


			wp_localize_script( 'redq_rental_writepanel_js', 'redq_rental_writepanel_js_params', $params );

		}


		/**
		 * Frontend enqueues front-end stylesheet and scripts
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function frontend_styles_and_scripts(){
			wp_register_script( 'jquery.datetimepicker.full', REDQ_ROOT_URL . '/assets/js/jquery.datetimepicker.full.js', array( 'jquery'), true );
			wp_enqueue_script('jquery.datetimepicker.full');

			wp_register_script( 'sweetalert.min', REDQ_ROOT_URL . '/assets/js/sweetalert.min.js', array( 'jquery'), true );
			wp_enqueue_script('sweetalert.min');

			wp_register_script( 'chosen.jquery', REDQ_ROOT_URL . '/assets/js/chosen.jquery.js', array( 'jquery'), true );
			wp_enqueue_script('chosen.jquery');

			wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css');

			wp_register_style('sweetalert', REDQ_ROOT_URL. '/assets/css/sweetalert.css', array(), $ver = false, $media = 'all');
	  		wp_enqueue_style('sweetalert');

	  		wp_register_style('chosen', REDQ_ROOT_URL. '/assets/css/chosen.css', array(), $ver = false, $media = 'all');
	  		wp_enqueue_style('chosen');

	  		// wp_register_style('rental-style', REDQ_ROOT_URL. '/assets/css/rental-style.css', array(), $ver = false, $media = 'all');
	  		// wp_enqueue_style('rental-style');

	  		wp_register_style('rental-style-two', REDQ_ROOT_URL. '/assets/css/rental-style-two.css', array(), $ver = false, $media = 'all');
	  		wp_enqueue_style('rental-style-two');

			wp_register_script( 'date', REDQ_ROOT_URL . '/assets/js/date.js', array( 'jquery'), true );
			wp_enqueue_script('date');

			wp_register_script( 'accounting', REDQ_ROOT_URL . '/assets/js/accounting.js', array( 'jquery'), true );
			wp_enqueue_script('accounting');

			wp_register_script( 'jquery.flip', REDQ_ROOT_URL . '/assets/js/jquery.flip.js', array( 'jquery'), true );
			wp_enqueue_script('jquery.flip');

			wp_register_script( 'front-end-scripts', REDQ_ROOT_URL . '/assets/js/main-script.js', array( 'jquery'), true );
			wp_enqueue_script('front-end-scripts');

			wp_register_script( 'cost-handle', REDQ_ROOT_URL . '/assets/js/cost-handle.js', array( 'jquery'), true );
			wp_enqueue_script('cost-handle');

			$block_dates = $this->calculate_block_dates();
			$this->redq_update_prices();

			wp_localize_script('cost-handle' , 'BOOKING_DATA', array(
					'all_data' => $this->reqd_all_booking_data(),
					'block_dates' => $block_dates
				));

			wp_localize_script('front-end-scripts' , 'BOOKING_DATA', array(
					'all_data' => $this->reqd_all_booking_data(),
					'block_dates' => $block_dates
				));

			wp_register_style( 'jquery.datetimepicker', REDQ_ROOT_URL . '/assets/css/jquery.datetimepicker.css', array(), $ver = false, $media = 'all' );
			wp_enqueue_style('jquery.datetimepicker');
		}


		/**
		 * Localize all booking data
		 *
		 * @since 1.0.0
		 * @return object
		 */
		public function reqd_all_booking_data(){
			return get_post_meta(get_the_ID(),'redq_all_data',true);
		}


		/**
		 * Calculate Block Dates
		 *
		 * @since 1.0.0
		 * @return object
		 */
		public function calculate_block_dates(){

			$block_dates = array();
			$block_dates_final = array();
			$all_data = get_post_meta(get_the_ID(),'redq_all_data',true);
			$output_date_format  = 'm/d/Y';
			$rental_availability = get_post_meta( get_the_ID(), 'redq_rental_availability', true );


			
			$rental_block = 'yes';
			


			if(isset($rental_block) && $rental_block === 'yes'){
				if(isset($rental_availability) && !empty($rental_availability)){
					foreach ($rental_availability as $key => $value) {
						$all_dates = $this->manage_all_dates($value['from'], $value['to'], 'no', $output_date_format);
						$block_dates[] = $all_dates;
					}
				}

				foreach ($block_dates as $block_date) {
					foreach ($block_date as $key => $value) {
						$block_dates_final[] = $value;
					}
				}
			}

			return $block_dates_final;
		}


		/**
		 * Manage all Block Dates
		 *
		 * @since 1.0.0
		 * @return object
		 */
		public function manage_all_dates($start_dates, $end_dates , $choose_euro_format, $output_format , $step = '+1 day'){

			$dates = array();

			if($choose_euro_format === 'no'){
				$current = strtotime($start_dates);
		    	$last = strtotime($end_dates);
			}else{
				$start  = date('Y/m/d', strtotime(str_replace('/', '-', $start_dates)));
				$end = date('Y/m/d', strtotime(str_replace('/', '-', $end_dates)));
				$current = strtotime($start);
		    	$last = strtotime($end);
			}

		    while( $current <= $last ) {

		        $dates[] = date($output_format, $current);
		        $current = strtotime($step, $current);
		    }

			return $dates;
		}


		/**
		 * Add to cart page show in fornt-end
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function redq_add_to_cart(){
			wc_get_template( 'single-product/add-to-cart/redq_rental.php',$args = array(), $template_path = '', REDQ_PACKAGE_TEMPLATE_PATH);
		}


		/**
		 * Update price according to pircing type
		 *
		 * @since 1.0.0
		 * @return null
		 */
		public function redq_update_prices(){
			$post_id = get_the_ID();
			$pricing_type = get_post_meta(get_the_ID(),'pricing_type',true);

			if($pricing_type == 'general_pricing'){
				$general_pricing = get_post_meta($post_id,'general_price',true);
				update_post_meta($post_id,'_price',$general_pricing);
			}

			
		}


		/**
		 * Support lagnuages
		 *
		 * @since 1.0.0
		 * @return null
		 */
        public function redq_support_multilanguages() {
            load_plugin_textdomain( 'redq-rental', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }



	}

	new RedQ_Rental_And_Bookings();

}else{
    function redq_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'Please Install WooCommerce First before activating this Plugin. You can download WooCommerce from <a href="http://wordpress.org/plugins/woocommerce/">here</a>.', 'redq-rental' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'redq_admin_notice' );
}
