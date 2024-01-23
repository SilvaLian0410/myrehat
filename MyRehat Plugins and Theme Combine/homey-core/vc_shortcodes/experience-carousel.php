<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('homey_experience_carousel') ) {
	function homey_experience_carousel($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'experience_style' => '',
			//'booking_type' => '',
			'experience_type' => '',
			'experience_country' => '',
			'experience_state' => '',
			'experience_city' => '',
			'experience_area' => '',
			'featured_experience' => '',
			'experience_ids' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => '',
			'slides_to_show' => '',
			'slides_to_scroll' => '',
			'slide_infinite' => '',
			'slide_auto' => '',
			'auto_speed' => '',
			'navigation' => '',
			'slide_dots' => '',
			'token' => ''
		), $atts));

		ob_start();

		global $template_args;

        $template_args = array( 'listing-item-view' => 'item-grid-view' );

        if ( $experience_style == 'list' || $experience_style == 'list-v2' ) {
            $template_args = array( 'listing-item-view' => 'item-list-view' );
        } elseif ( $experience_style == 'card' ) {
            $template_args = array( 'listing-item-view' => 'item-card-view' );
        }
        
		//do the query
		$the_query = Homey_Exp_Query::get_wp_query($atts); //by ref  do the query

		if($experience_style == 'card') {
			$main_classes = 'property-module-card experience-carousel-next-prev-'.$token.' property-module-card-slider property-module-card-slider-'.esc_attr__($slides_to_show);
			$sub_classes = 'item-card-slider-view item-card-slider-view-'.esc_attr__($slides_to_show);
		} else {
			$main_classes = 'property-module-grid experience-carousel-next-prev-'.$token.' property-module-grid-slider property-module-grid-slider-'.esc_attr__($slides_to_show);
			$sub_classes = 'item-grid-slider-view item-grid-slider-view-'.esc_attr__($slides_to_show);
		}

		
		wp_register_script('experience_caoursel', get_template_directory_uri() . '/js/experience-carousel.js', array('jquery'), HOMEY_THEME_VERSION, true);
		$local_args = array(
			'slides_to_show' => $slides_to_show,
			'slides_to_scroll' => $slides_to_scroll,
			'slide_auto' => $slide_auto,
			'auto_speed' => $auto_speed,
			'slide_dots' => $slide_dots,
			'slide_infinite' => $slide_infinite,
			'navigation' => $navigation,
			'experience_style' => $experience_style
		);
		wp_localize_script('experience_caoursel', 'experience_caoursel_' . $token, $local_args);
		wp_enqueue_script('experience_caoursel');
		?>

		<div class="module-wrap <?php esc_attr_e($main_classes);?>">
			 <div class="experience-wrap which-layout-<?php echo $experience_style;?> <?php if(str_contains($experience_style, '2')){ echo 'item-'.grid_list_or_card($experience_style, 1).'-view'; } ?> item-<?php esc_attr_e($experience_style);?>-view">
				<div id="homey-experience-carousel-<?php esc_attr_e($token);?>" data-token="<?php esc_attr_e($token); ?>" class="homey-carousel homey-carouse-elementor <?php esc_attr_e($sub_classes);?>">
						<?php
						if ($the_query->have_posts()) :
							while ($the_query->have_posts()) : $the_query->the_post();

								if($experience_style == 'card') {
									get_template_part('template-parts/experience/experience', 'card', $template_args);
								}elseif($experience_style == 'grid-v2' || $experience_style == 'list-v2') {
	                                get_template_part('template-parts/experience/experience', 'item-v2', $template_args);
	                            } else {
									get_template_part('template-parts/experience/experience', 'item', $template_args);
								}

							endwhile;
							Homey_Exp_Query::loop_reset_postdata();
						else:
							//get_template_part('template-parts/property', 'none');
						endif;
						?>
				</div>
			</div><!-- grid-experience-page -->
		</div>
		
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('homey-experience-carousel', 'homey_experience_carousel');
}
?>