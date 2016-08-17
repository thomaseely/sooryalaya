<div id="general_product_data" class="show_if_redq_rental hide_if_variable hide_if_simple hide_if_external">
	<h4 class="redq-headings">Product Attributes</h4>
	<div class="redq_general_info_group">
		<div class="table_grid sortable" id="sortable">
			<table class="widefat">				
				<tfoot>
					<tr>
						<th>
							<a href="#" class="button button-primary add_redq_row" data-row="<?php
								ob_start();
								include( 'html-attribute-info-meta.php' );
								$html = ob_get_clean();
								echo esc_attr( $html );
							?>"><?php _e( 'Add Attributes', 'redq-rental' ); ?></a>
						</th>
					</tr>
				</tfoot>
				<tbody id="general_info_rows">
					<?php
						$attributes = get_post_meta($post_id , 'redq_attributes' , true);
						if ( ! empty( $attributes ) && is_array( $attributes ) ) {
							foreach ( $attributes as $attribute ) {
								include( 'html-attribute-info-meta.php' );
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>


	<h4 class="redq-headings">Additional Features</h4>
	<div class="redq_additional_feature_group">
		<div class="table_grid">
			<table class="widefat">				
				<tfoot>
					<tr>
						<th>
							<a href="#" class="button button-primary add_redq_row" data-row="<?php
								ob_start();
								include( 'html-additional-feature-meta.php' );
								$html = ob_get_clean();
								echo esc_attr( $html );
							?>"><?php _e( 'Add Additional Features', 'redq-rental' ); ?></a>
						</th>
					</tr>
				</tfoot>
				<tbody id="general_info_rows">
					<?php
						$features = get_post_meta($post_id , 'redq_additional_features' , true);
						if ( ! empty( $features ) && is_array( $features ) ) {
							foreach ( $features as $feature ) {
								include( 'html-additional-feature-meta.php' );
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

</div>