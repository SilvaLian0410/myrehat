<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('homey_listings') ) {
	function homey_listings($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'listing_style' => '',
			'booking_type' => '',
			'loadmore' => '',
			'listing_type' => '',
			'room_type' => '',
			'listing_country' => '',
			'listing_state' => '',
			'listing_city' => '',
			'listing_area' => '',
			'featured_listing' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => ''
		), $atts));

		ob_start();
		global $paged, $template_args;

		if(empty($listing_area)) {
			$listing_area = "";
		}
		if(empty($listing_city)) {
			$listing_city = "";
		}
		if(empty($listing_country)) {
			$listing_country = "";
		}
		if(empty($listing_state)) {
			$listing_state = "";
		}
		if(empty($listing_type)) {
			$listing_type = "";
		}

		if(empty($room_type)) {
			$room_type = "";
		}

		$local = homey_get_localization();

		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}

		//do the query
		$the_query = Homey_Query::get_wp_query($atts, $paged); //by ref  do the query
        $grid_or_card = 'grid';
        if($listing_style == 'card') { $grid_or_card = 'card'; }

        $template_args = array( 'listing-item-view' => 'item-grid-view' );

		if ( $listing_style == 'list' || $listing_style == 'list-v2' ) {
		    $template_args = array( 'listing-item-view' => 'item-list-view' );
		} elseif ( $listing_style == 'card' ) {
		    $template_args = array( 'listing-item-view' => 'item-card-view' );
		}
		?>

		<div id="listings_module_section" data-in-vc-core="1" class="listing-page listing-page-full-width module-wrap property-module-<?php echo esc_attr($listing_style);?>">
			<div data-in-vc-core="1" class="listing-wrap which-layout-<?php echo $listing_style;?> <?php if(str_contains($listing_style, '2')){ echo 'item-'.grid_list_or_card($listing_style, 1).'-view'; } ?> item-<?php echo esc_attr($listing_style);?>-view">
				<div id="module_listings" class="row">
					<?php
					if ($the_query->have_posts()) :
						while ($the_query->have_posts()) : $the_query->the_post();

                            if($listing_style == 'card') {
                                get_template_part('template-parts/listing/listing-card', '', $template_args);
                            }elseif($listing_style == 'grid-v2' || $listing_style == 'list-v2') {
                                get_template_part('template-parts/listing/listing-item-v2', '', $template_args);
                            } else {
                                get_template_part('template-parts/listing/listing-item', '', $template_args);
                            }

						endwhile;
						Homey_Query::loop_reset_postdata();
					else:
						get_template_part('template-parts/listing/listing-none');
					endif;
					?>
				</div>
				
				<?php if($loadmore == 'enable') { ?>
				<div class="homey-loadmore loadmore text-center">
					<a
					data-paged="2" 
                    data-limit="<?php esc_attr_e($posts_limit); ?>" 
                    data-style="<?php esc_attr_e($listing_style); ?>" 
                    data-booking_type="<?php esc_attr_e($booking_type); ?>" 
                    data-type="<?php esc_attr_e($listing_type); ?>" 
                    data-roomtype="<?php esc_attr_e($room_type); ?>"
                    data-country="<?php esc_attr_e($listing_country); ?>"  
                    data-state="<?php esc_attr_e($listing_state); ?>" 
                    data-city="<?php esc_attr_e($listing_city); ?>" 
                    data-area="<?php esc_attr_e($listing_area); ?>" 
                    data-featured="<?php esc_attr_e($featured_listing); ?>" 
                    data-offset="<?php esc_attr_e($offset); ?>"
                    data-sortby="<?php esc_attr_e($sort_by); ?>"
                    href="#" 
					class="btn btn-primary btn-long">
						<i id="spinner-icon" class="homey-icon homey-icon-loading-half fa-pulse fa-spin fa-fw" style="display: none;"></i>
						<?php esc_attr_e($local['loadmore_btn']); ?>
					</a>
				</div>
				<?php } ?>


			</div><!-- grid-listing-page -->
		</div>
		
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('homey-listings', 'homey_listings');
}
?>