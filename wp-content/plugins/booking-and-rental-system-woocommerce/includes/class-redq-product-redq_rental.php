<?php

class WC_Product_Redq_Rental extends WC_Product {
	public function __construct( $product ) {
		$this->product_type = 'redq_rental';
		parent::__construct( $product );
	}
}




