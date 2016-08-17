<?php
/**
 * Redq rental product add to cart
 *
 * @author 		redq-team
 * @package 	RedqTeam/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce, $product;

?>


<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data'>	

	<div class="date-time-picker">
		<h5><?php _e('Check In Date & Time','redq-rental'); ?></h5>
		<span class="pick-up-date-picker">
			<i class="fa fa-calendar"></i>
			<input type="text" name="pickup_date" id="pickup-date" placeholder="<?php _e('Arrival date','redq-rental') ?>" value="">
		</span>
		<span class="pick-up-time-picker">
			<i class="fa fa-clock-o"></i>
			<input type="text" name="pickup_time" id="pickup-time" placeholder="<?php _e('Arrival time','redq-rental') ?>" value="">
		</span>
	</div>

	<div class="date-time-picker">
		<h5><?php _e('Check Out Date & Time','redq-rental'); ?></h5>
		<span class="drop-off-date-picker">
			<i class="fa fa-calendar"></i>
			<input type="text" name="dropoff_date" id="dropoff-date" placeholder="<?php _e('Departure date','redq-rental'); ?>" value="">
		</span>
		<span class="drop-off-time-picker">
			<i class="fa fa-clock-o"></i>
			<input type="text" name="dropoff_time" id="dropoff-time" placeholder="<?php _e('Departure time','redq-rental'); ?>" value="">
		</span>
	</div>

	
	<input type="hidden" name="currency-symbol" class="currency-symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>">

	<!-- Thomas hide here <h3 class="booking_cost" style="display: none"><?php _e('Total Booking Cost : ','redq-rental'); ?><span style="float: right;"></span></h3> -->

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
	<button style="margin-top: 15px" type="submit" class="single_add_to_cart_button btn-book-now button alt"><?php _e('Book Now','redq-rental'); ?></button>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>



