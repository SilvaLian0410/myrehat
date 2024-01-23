<?php
/*-----------------------------------------------------------------------------------*/
/*	Module 1
/*-----------------------------------------------------------------------------------*/
if( !function_exists('homey_grids_v2_carousel') ) {
	function homey_grids_v2_carousel($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'homey_grid_from' => '',
			'homey_show_child' => '',
			'orderby' 			=> '',
			'order' 			=> '',
			'homey_hide_empty' => '',
			'no_of_terms' 		=> '',
			'listing_type' => '',
			'room_type' => '',
			'listing_area' => '',
			'listing_state' => '',
			'listing_city' => '',
			'listing_country' => ''
		), $atts));

		ob_start();
		$module_type = '';
		$homey_local = homey_get_localization();

		$slugs = '';

		if( $homey_grid_from == 'listing_city' ) {
			$slugs = $listing_city;

		} else if ( $homey_grid_from == 'listing_area' ) {
			$slugs = $listing_area;

		} else if ( $homey_grid_from == 'room_type' ) {
			$slugs = $room_type;

		} else if ( $homey_grid_from == 'listing_state' ) {
			$slugs = $listing_state;

		} else if ( $homey_grid_from == 'listing_country' ) {
			$slugs = $listing_country;

		} else {
			$slugs = $listing_type;
		}

		if ($homey_show_child == 1) {
			$homey_show_child = '';
		}

		$custom_link_for = '';

		$tax_name = $homey_grid_from;
		$taxonomy = get_terms(array(
			'hide_empty' => $homey_hide_empty,
			'parent' => $homey_show_child,
			'slug' => homey_traverse_comma_string($slugs),
			'number' => $no_of_terms,
			'orderby' => $orderby,
			'order' => $order,
			'taxonomy' => $tax_name,
		));

		$token = wp_generate_password(10, false, false);
		?>

		<script>
			jQuery(document).ready(function($){
				var next_text = HOMEY_ajax_vars.next_text;
            	var prev_text = HOMEY_ajax_vars.prev_text;

		        $('.homey-tax-v2-js-<?php echo esc_attr($token); ?>').slick({
		            lazyLoad: 'ondemand',
		            infinite: true,
		            speed: 300,
		            slidesToShow: 4,
		            arrows: true,
		            adaptiveHeight: true,
		            dots: true,
		            appendArrows: '.homey-tax-v2-js-<?php echo esc_attr($token); ?>',
		            prevArrow: '<button type="button" class="slick-prev">'+prev_text+'</button>',
		            nextArrow: '<button type="button" class="slick-next">'+next_text+'</button>',
		            responsive: [
		            {
		                breakpoint: 992,
		                settings: {
		                    slidesToShow: 2,
		                    slidesToScroll: 2
		                }
		            },
		            {
		                breakpoint: 769,
		                settings: {
		                    slidesToShow: 1,
		                    slidesToScroll: 1
		                }
		            }]
		        });
		    });
		</script>

		<div class="module-wrap homey-tax-v2-js-<?php echo esc_attr($token); ?> taxonomy-grid-module-v2 taxonomy-grid-module-v2-grid-v2 taxonomy-grid-module-v2-grid-v2-slider">
			
			<?php
			if ( !is_wp_error( $taxonomy ) ) {
				$i = 0;
				$j = 0;

				foreach ($taxonomy as $term) {

				$i++;
				$j++;

				$attach_id = get_term_meta($term->term_id, 'homey_taxonomy_img', true);

				$attachment = wp_get_attachment_image_src( $attach_id, 'homey_thumb_360_360' );

				if(empty($attachment)) {
					$img_url = 'https://place-hold.it/360x360';
					$img_width = '360';
					$img_height = '360';
				}else{
                    $img_url = $attachment['0'];
                    $img_width = $attachment['1'];
                    $img_height = $attachment['2'];
                }
				
				$taxonomy_custom_link = '';

				if( !empty($taxonomy_custom_link) ) {
					$term_link = $taxonomy_custom_link;
				} else {
					$term_link = get_term_link($term, $tax_name);
				}
				?>
				<div class="taxonomy-grid-module-v2-slide-wrap">

					<div class="taxonomy-item taxonomy-item-v2">
						<div class="taxonomy-item-image">
							<a class="taxonomy-link hover-effect" href="<?php echo esc_url($term_link);?>">
								<img class="img-responsive" src="<?php echo esc_url($img_url); ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>" alt="<?php esc_attr_e($tax_name);?>">
							</a>	
						</div>
						<div class="taxonomy-item-content">
							<h3 class="taxonomy-title">
								<a href="<?php echo esc_url($term_link);?>"><?php echo esc_attr($term->name); ?></a>
							</h3>
							<div class="taxonomy-description">
								<?php echo esc_attr($term->count); ?>
								<?php
								if ($term->count < 2) {
									echo esc_html__('Listing', 'homey-core');
								} else {
									echo esc_html__('Listings', 'homey-core');
								}
								?>
							</div>
						</div>
					</div>

				</div>
			<?php } 
			}?>
            
		</div>
		
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('homey-grids-v2-carousel', 'homey_grids_v2_carousel');
}
?>