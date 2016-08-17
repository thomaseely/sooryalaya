<?php 
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * Hande Dynamic Price
 *  
 * @version 1.0.0
 * @since 1.0.0
 */

class WC_Redq_Rental_Price {


	public function __construct(){	
		add_action( 'init', array( $this, 'redq_rental_udpate_pricing' ));
		add_action( 'woocommerce_product_tabs', array( $this, 'redq_rental_product_tabs' ));	
	}

	public function redq_rental_udpate_pricing(){
		if(!function_exists('_log')){
		  	function _log( $message ) {
			    if( WP_DEBUG === true ){
			      	if( is_array( $message ) || is_object( $message ) ){
			        	error_log( print_r( $message, true ) );
			      	} else {
			        	error_log( $message );
			      	}
			    }
		  	}
		}
	}


	public function redq_rental_product_tabs($tabs){


		$tabs['attributes'] = array(
	        'title'     => __( 'Attributes', 'redq-rental' ),
	        'priority'  => 5,
	        'callback'  => 'WC_Redq_Rental_Price::redq_attributes'
	    ); 

	    $tabs['features'] = array(
	        'title'     => __( 'Features', 'redq-rental' ),
	        'priority'  => 8,
	        'callback'  => 'WC_Redq_Rental_Price::redq_features'
	    );  

	    

	    return $tabs; 
	}


	public static function redq_attributes(){ ?>		

		<?php $item_attributes = get_post_meta(get_the_ID(),'redq_attributes',true); ?>
		<?php if(isset($item_attributes) && !empty($item_attributes)): ?>
		<div class="item-arrtributes">			
			<ul class="attributes">
				<?php foreach ($item_attributes as $key => $value) { ?>
					<li>
						<span class="attribute-icon"><i class="fa <?php echo esc_attr($value['icon']); ?>"></i></span>
						<span class="attribute-name"><?php echo esc_attr($value['name']); ?></span>
						<span class="attribute-vaue"> : <?php echo esc_attr($value['value']); ?></span>
					</li>	
				<?php } ?>		
			</ul>	
		</div>
		<?php endif; ?>
	<?}


	public static function redq_features(){ ?>

		<?php $additional_features = get_post_meta(get_the_ID(),'redq_additional_features',true); ?>
		<?php if(isset($additional_features) && !empty($additional_features)): ?>
		<div class="item-extras">			
			<ul class="attributes">
				<?php foreach ($additional_features as $key => $value) { ?>
					<li>
						<span class="attribute-name"><i class="fa fa-check"></i><?php echo esc_attr($value); ?></span>				
					</li>	
				<?php } ?>		
			</ul>	
		</div>
		<?php endif; ?>
		
	<?php }




}	

new WC_Redq_Rental_Price();