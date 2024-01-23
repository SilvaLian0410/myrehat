<?php
/*-----------------------------------------------------------------------------------*/
/*	Experiences
/*-----------------------------------------------------------------------------------*/
if( !function_exists('homey_experiences') ) {
	function homey_experiences($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'experience_style' => '',
			'loadmore' => '',
			'experience_type' => '',
            'experience_country' => '',
			'experience_state' => '',
			'experience_city' => '',
			'experience_area' => '',
			'featured_experience' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => ''
		), $atts));

		ob_start();
		global $paged, $template_args;

		$template_args = array( 'listing-item-view' => 'item-grid-view' );

		if ( $experience_style == 'list' || $experience_style == 'list-v2' ) {
		    $template_args = array( 'listing-item-view' => 'item-list-view' );
		} elseif ( $experience_style == 'card' ) {
		    $template_args = array( 'listing-item-view' => 'item-card-view' );
		}

		if(empty($experience_area)) {
			$experience_area = "";
		}
		if(empty($experience_city)) {
			$experience_city = "";
		}
		if(empty($experience_country)) {
			$experience_country = "";
		}
		if(empty($experience_state)) {
			$experience_state = "";
		}
		if(empty($experience_type)) {
			$experience_type = "";
		}

		$local = homey_get_localization();

		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}

		//do the query
		$the_query = Homey_Exp_Query::get_wp_query($atts, $paged); //by ref  do the query

        $grid_or_card = 'grid';
        if($experience_style == 'card') { $grid_or_card = 'card'; }
		?>

		<div id="experiences_module_section" class="listing-page listing-page-full-width module-wrap module-wrap property-module-<?php echo esc_attr($experience_style);?>">
			<div class="listing-wrap which-layout-<?php echo $experience_style;?> <?php if(str_contains($experience_style, '2')){ echo 'item-'.grid_list_or_card($experience_style, 1).'-view'; } ?> item-<?php echo esc_attr($experience_style);?>-view">
				<div id="module_experiences" class="row exp-experiences <?php echo $experience_style; ?>">
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
						get_template_part('template-parts/experience/experience-none');
					endif;
					?>
				</div>
				
				<?php if($loadmore == 'enable') { ?>
				<div class="homey-loadmore loadmore text-center">
					<a
					data-paged="2" 
                    data-limit="<?php esc_attr_e($posts_limit); ?>" 
                    data-style="<?php esc_attr_e($experience_style); ?>" 
                    data-type="<?php esc_attr_e($experience_type); ?>"
                    data-country="<?php esc_attr_e($experience_country); ?>"
                    data-state="<?php esc_attr_e($experience_state); ?>" 
                    data-city="<?php esc_attr_e($experience_city); ?>" 
                    data-area="<?php esc_attr_e($experience_area); ?>" 
                    data-featured="<?php esc_attr_e($featured_experience); ?>" 
                    data-offset="<?php esc_attr_e($offset); ?>"
                    data-sortby="<?php esc_attr_e($sort_by); ?>"
                    href="#" 
					class="btn btn-primary btn-long">
						<i id="spinner-icon" class="homey-icon homey-icon-loading-half fa-pulse fa-spin fa-fw" style="display: none;"></i>
						<?php esc_attr_e($local['loadmore_btn']); ?>
					</a>
				</div>
				<?php } ?>


			</div><!-- grid-experience-page -->
		</div>
		
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('homey-experiences', 'homey_experiences');
}
?>