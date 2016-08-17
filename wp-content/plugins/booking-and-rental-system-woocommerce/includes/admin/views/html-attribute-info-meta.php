<?php 

	if(isset($attribute['name']) && !empty($attribute['name'])){
		$attribute_name = $attribute['name'];
	}else{
		$attribute_name = '';
	}

	if(isset($attribute['value']) && !empty($attribute['value'])){
		$attribute_value = $attribute['value'];
	}else{
		$attribute_value = '';
	}

	if(isset($attribute['icon']) && !empty($attribute['icon'])){
		$attribute_icon = $attribute['icon'];
	}else{
		$attribute_icon = '';
	}

?>

<div class="general_attribute_group redq-remove-rows sort ui-state-default postbox" style="background: none; border: none;">
	
	<div class="attribute-bar redq-show-bar">
		<h4 class="redq-headings"><?php echo esc_attr($attribute_name); ?>
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
					'id' => 'attribute_name', 
					'name' => 'redq_attribute_name[]',
					'label' => __( 'Attribute Name', 'redq-rental' ), 
					'placeholder' => __( 'Attribute Name', 'redq-rental' ), 
					'type' => 'text',
					'value' => $attribute_name, 				
				) 
			); 
			woocommerce_wp_text_input( 
				array( 
					'id' => 'attribute_value', 
					'name' => 'redq_attribute_value[]',
					'label' => __( 'Attribute Value', 'redq-rental' ), 
					'placeholder' => __( 'attribute value', 'redq-rental' ), 
					'type' => 'text',
					'value' => $attribute_value, 				 
				) 
			);

			woocommerce_wp_text_input( 
				array( 
					'id' => 'icon', 
					'name' => 'redq_font_awesome_icon[]',
					'label' => __( 'Font Awesome Icon Name', 'redq-rental' ), 
					'placeholder' => __( 'fa-car', 'redq-rental' ), 
					'type' => 'text',
					'value' => $attribute_icon, 				 
				) 
			);
			
		?>
		
	</div>
	
	
</div>