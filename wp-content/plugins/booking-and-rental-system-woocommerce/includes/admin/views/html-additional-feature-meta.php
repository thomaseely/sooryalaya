<?php 

	if(isset($feature) && !empty($feature)){
		$feature_name = $feature;
	}else{
		$feature_name = '';
	}	

?>


<div class="additional_feature_group redq-remove-rows sort ui-state-default postbox" style="background: none; border: none;">

	<div class="features-bar redq-show-bar">
		<h4 class="redq-headings"><?php echo esc_attr($feature_name); ?>
			<button style="float: right" type="button" class="remove_row button"><i class="fa fa-trash-o"></i><?php _e('Remove','redq-rental'); ?></button>
			<button type="button" class="handlediv button-link" aria-expanded="true">
				<span class="screen-reader-text">Toggle panel: Product Image</span>
				<span class="handlediv toggle-indicator show-or-hide" title="Click to toggle"></span>
			</button>
		</h4>		
	</div>
	
	<div class="general_attribute redq-hide-row" style="margin: 15px;">
	<?php
		
		woocommerce_wp_text_input( 
			array( 
				'id' => 'feature_name', 
				'name' => 'redq_feature_name[]',
				'label' => __( 'Feature Name', 'redq-rental' ), 
				'placeholder' => __( 'Feature Name', 'redq-rental' ), 
				'type' => 'text',
				'value' => $feature_name				
			) 
		); 		
		
	?>
	</div>
</div>