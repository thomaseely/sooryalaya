<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* woo-commmercerce meta boxes for redq rental
*/
class Redq_Rental_Meta_Boxes{
	
	function __construct(){
		add_filter( 'product_type_selector' , array( $this, 'redq_rental_product_type' ) );
		add_filter( 'woocommerce_product_data_tabs' , array( $this, 'redq_rental_additional_tabs' ) );
		add_action( 'woocommerce_product_write_panels', array( $this, 'redq_rental_additional_tabs_panel' ) );
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'redq_rental_general_tab_info' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'redq_rental_save_meta' ) );
		add_action( 'save_post', array($this, 'redq_save_post'));
	}

	public function redq_rental_product_type($product_types){
		$product_types['redq_rental'] = __( 'Rental Product', 'redq-rental' );
		return $product_types;
	}


	public function redq_rental_additional_tabs($product_tabs){
		
		$product_tabs['price_calculation'] = array(
			'label'  => __( 'Price Calculation', 'redq-rental' ),
			'target' => 'price_calculation_product_data',
			'class'  => array( 'hide_if_grouped','show_if_redq_rental','hide_if_simple','hide_if_external','hide_if_variable' ),
		);

		$product_tabs['availability'] = array(
			'label'  => __( 'Availability', 'redq-rental' ),
			'target' => 'availability_product_data',
			'class'  => array( 'hide_if_grouped' ,'show_if_redq_rental','hide_if_simple','hide_if_external','hide_if_variable'  ),
		);
		

		return $product_tabs;
	}


	public function redq_rental_general_tab_info(){
		global $post;
		$post_id = $post->ID;
		include( 'views/redq-rental-general-tab.php' );
	}


	public function redq_rental_additional_tabs_panel() {		
		global $post;
		$post_id = $post->ID;
		include( 'views/redq-rental-additional-tabs-panel.php' );		
	}

	public function redq_save_post($post_id){

		$pricing_type = get_post_meta(get_the_ID(),'pricing_type',true);

		if($pricing_type == 'general_pricing'){
			$general_pricing = get_post_meta($post_id,'general_price',true);
			update_post_meta($post_id,'_price',$general_pricing);			
		}		

	}


	public function redq_rental_save_meta($post_id){

		if(isset($_POST['pricing_type'])){
			update_post_meta( $post_id, 'pricing_type', $_POST['pricing_type'] );
		}

		if(isset($_POST['general_price'])){
			update_post_meta( $post_id, 'general_price', $_POST['general_price'] );
		}

		if(isset($_POST['hourly_price'])){
			update_post_meta( $post_id, 'hourly_price', $_POST['hourly_price'] );
		}

		

		// Own availability checking
		$rental_availability = array();
		if(isset($_POST['redq_rental_availability_type']) && isset($_POST['redq_rental_availability_from']) && isset($_POST['redq_rental_availability_to']) && isset($_POST['redq_availability_rentable'])){
			$availability_type = $_POST['redq_rental_availability_type'];
			$availability_from = $_POST['redq_rental_availability_from'];
			$availability_to = $_POST['redq_rental_availability_to'];
			$availability_rentable = $_POST['redq_availability_rentable'];
			for($i=0; $i<sizeof($availability_type); $i++){
				$rental_availability[$i]['type'] = $availability_type[$i];
				$rental_availability[$i]['from'] = $availability_from[$i];
				$rental_availability[$i]['to'] = $availability_to[$i];
				$rental_availability[$i]['rentable'] = $availability_rentable[$i];
			}			
		}
		if(isset($rental_availability)){
			update_post_meta( $post_id, 'redq_rental_availability', $rental_availability );
		}

		// General tab data
		$redq_attributes = array();
		if(isset($_POST['redq_attribute_name']) && isset($_POST['redq_attribute_value'])){			
			$attribute_name = $_POST['redq_attribute_name'];
			$attriute_value = $_POST['redq_attribute_value'];
			$attriute_icon = $_POST['redq_font_awesome_icon'];
			for($i=0; $i<sizeof($attribute_name); $i++){
				$redq_attributes[$i]['name'] = $attribute_name[$i];
				$redq_attributes[$i]['value'] = $attriute_value[$i];
				$redq_attributes[$i]['icon'] = $attriute_icon[$i];			
			}			
		}
		if(isset($redq_attributes)){
			update_post_meta( $post_id, 'redq_attributes', $redq_attributes );
		}
		if(isset($_POST['redq_feature_name'])){
			update_post_meta( $post_id, 'redq_additional_features', $_POST['redq_feature_name'] );
		}
		

		// save all data
		$redq_booking_data = array();

		$redq_booking_data['pricing_type'] = $_POST['pricing_type'];
		$redq_booking_data['general_pricing'] = $_POST['general_price'];
		$redq_booking_data['hourly_pricing'] = $_POST['hourly_price'];

		$redq_booking_data['block_rental_dates'] = $_POST['block_rental_dates'];
		
		if(isset($rental_availability)){
			$redq_booking_data['rental_availability'] = $rental_availability;
		}
		if(isset($redq_attributes)){
			$redq_booking_data['attributes'] = $redq_attributes;
		}	
		if(isset($_POST['redq_feature_name'])){
			$redq_booking_data['features'] = $_POST['redq_feature_name'];
		}	


		update_post_meta( $post_id, 'redq_all_data', $redq_booking_data );		

	}


}

new Redq_Rental_Meta_Boxes();
