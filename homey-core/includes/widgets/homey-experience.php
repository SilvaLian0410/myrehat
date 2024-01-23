<?php
/*
 * Widget Name: Featured Experiences
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class Homey_experience extends WP_Widget {

	/**
	 * Register widget
	 **/
	public function __construct() {

		parent::__construct(
			'Homey_experience', // Base ID
			esc_html__( 'Homey: Experience Card', 'homey' ), // Name
			array( 'description' => esc_html__( 'Show experience card', 'homey' ), 'classname' => 'widget-card-properties widget-latest-properties') // Args
		);

	}


	/**
	 * Front-end display of widget
	 **/
	public function widget( $args, $instance ) {

		global $before_widget, $after_widget, $before_title, $after_title, $post;
		extract( $args );

		$homey_local = homey_get_localization();

		$allowed_html_array = array(
			'div' => array(
				'id' => array(),
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			)
		);

		$title = apply_filters('widget_title', $instance['title'] );
		$items_num = $instance['items_num'];
		$widget_type = $instance['widget_type'];
		$experience_type = isset( $instance['experience_type'] ) ? $instance['experience_type'] : '';
		$room_type = isset( $instance['room_type'] ) ? $instance['room_type'] : '';
		$experience_city = isset( $instance['experience_city'] ) ? $instance['experience_city'] : '';
		$experience_area = isset( $instance['experience_area'] ) ? $instance['experience_area'] : '';
		$experience_state = isset( $instance['experience_state'] ) ? $instance['experience_state'] : '';
		$featured = $instance[ 'featured' ] == "on"? 'true' : 'false';

		echo wp_kses( $before_widget, $allowed_html_array );


		if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
		?>

		<?php

		$tax_query = array();
		$meta_query = array();

		if (!empty($experience_type)) {
			$tax_query[] = array(
				'taxonomy' => 'experience_type',
				'field' => 'slug',
				'terms' => $experience_type
			);
		}
		if (!empty($room_type)) {
			$tax_query[] = array(
				'taxonomy' => 'room_type',
				'field' => 'slug',
				'terms' => $room_type
			);
		}
		if (!empty($experience_city)) {
			$tax_query[] = array(
				'taxonomy' => 'experience_city',
				'field' => 'slug',
				'terms' => $experience_city
			);
		}
		if (!empty($experience_area)) {
			$tax_query[] = array(
				'taxonomy' => 'experience_area',
				'field' => 'slug',
				'terms' => $experience_area
			);
		}
		if (!empty($experience_state)) {
			$tax_query[] = array(
				'taxonomy' => 'experience_state',
				'field' => 'slug',
				'terms' => $experience_state
			);
		}

		if($featured == 'true') {
			$meta_query[] = array(
	            'key' => 'homey_featured',
	            'value' => '1',
	            'compare' => '='
	        );
		}

        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }

		$tax_count = count( $tax_query );
		if( $tax_count > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		$wp_qry = new WP_Query(
			array(
				'post_type' => 'experience',
				'posts_per_page' => $items_num,
				'ignore_sticky_posts' => 1,
				'post_status' => 'publish',
				'tax_query' => $tax_query,
				'meta_query' => $meta_query
			)
		);

		$token = wp_generate_password(5, false, false);
        if (is_rtl()) {
            $homey_rtl = "true";
        } else {
            $homey_rtl = "false";
        }

		$slider_class = $slider_id = '';
		if($widget_type == 'slider') { ?>

			<script>
				jQuery(document).ready(function(){
			        jQuery('#widget-slider-<?php echo $token; ?>').slick({
			        	rtl: <?php echo esc_attr( $homey_rtl ); ?>,
			            lazyLoad: 'ondemand',
			            infinite: true,
			            speed: 300,
			            slidesToShow: 1,
			            arrows: true,
			            adaptiveHeight: true
			        });
			    });
			</script>

		<?php
		$slider_class = 'widget-slider';	
		$slider_id = 'widget-slider-'.$token;	
		}

		?>

		<div class="widget-body">
	        <div id="<?php echo esc_attr($slider_id); ?>" class="<?php echo esc_attr($slider_class); ?> item-card-view">
			<?php 
			if( $wp_qry->have_posts() ): 
				while( $wp_qry->have_posts() ): $wp_qry->the_post(); 
					
					get_template_part('template-parts/experience/experience-card');
				endwhile; 
			endif;
			wp_reset_postdata(); 
			?>			
    
	        </div>
	    </div><!-- item-list-view -->


		<?php
		echo wp_kses( $after_widget, $allowed_html_array );

	}


	/**
	 * Sanitize widget form values as they are saved
	 **/
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		$instance['experience_type'] = strip_tags( $new_instance['experience_type'] );
		$instance['room_type'] = strip_tags( $new_instance['room_type'] );
		$instance['experience_city'] = strip_tags( $new_instance['experience_city'] );
		$instance['experience_area'] = strip_tags( $new_instance['experience_area'] );
		$instance['experience_state'] = isset($new_instance['experience_state']) ? strip_tags( $new_instance['experience_state'] ) : '';
		$instance['widget_type'] = isset($new_instance['widget_type']) ? strip_tags( $new_instance['widget_type'] ) : '';
		$instance['featured'] = isset($new_instance['featured']) ? $new_instance['featured'] : 'false';

		return $instance;

	}

	/**
	 * Back-end widget form
	 **/
	public function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'title' => 'Experiences',
			'widget_type' => '',
			'items_num' => '5',
			'experience_type' => '',
			'room_type' => '',
			'experience_city' => '',
			'experience_area' => '',
			'experience_state' => '',
			'featured' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$all = esc_html__('All', 'homey');

		$experience_types = homey_get_taxonomies_slug_array('experience_type', $all);
		$room_type = homey_get_taxonomies_slug_array('room_type', $all);
		$experience_city = homey_get_taxonomies_slug_array('experience_city', $all);
		$experience_area = homey_get_taxonomies_slug_array('experience_area', $all);
		$experience_state = homey_get_taxonomies_slug_array('experience_state', $all);

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'homey'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'experience_type' ) ); ?>"><?php esc_html_e('Experience Type filter:', 'homey'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'experience_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'experience_type' ) ); ?>">

				<?php

				foreach ( $experience_types as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['experience_type'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'room_type' ) ); ?>"><?php esc_html_e('Room Type filter:', 'homey'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'room_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'room_type' ) ); ?>">

				<?php

				foreach ( $room_type as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['room_type'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'experience_city' ) ); ?>"><?php esc_html_e('Experience City filter:', 'homey'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'experience_city' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'experience_city' ) ); ?>">

				<?php

				foreach ( $experience_city as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['experience_city'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'experience_area' ) ); ?>"><?php esc_html_e('Experience Area filter:', 'homey'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'experience_area' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'experience_area' ) ); ?>">

				<?php

				foreach ( $experience_area as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['experience_area'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'experience_state' ) ); ?>"><?php esc_html_e('Experience State filter:', 'homey'); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'experience_state' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'experience_state' ) ); ?>">

				<?php

				foreach ( $experience_state as $key => $value ) :

					echo '<option value="' . $value . '" ' . selected( $instance['experience_state'], $value, true ) . '>' . $key . '</option>';

				endforeach;

				?>

			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>"><?php esc_html_e('Maximum posts to show:', 'homey'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items_num' ) ); ?>" value="<?php echo esc_attr( $instance['items_num'] ); ?>" size="1" />
		</p>
		<p>
			<input type="radio" id="<?php echo esc_attr( $this->get_field_id( 'slider' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_type' ) ); ?>" <?php if ($instance["widget_type"] == 'slider')  echo 'checked="checked"'; ?> value="slider" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'slider' ) ); ?>"><?php esc_html_e( 'Display Experiences as Slider', 'homey' ); ?></label><br />

			<input type="radio" id="<?php echo esc_attr( $this->get_field_id( 'entries' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_type' ) ); ?>" <?php if ($instance["widget_type"] == 'entries') echo 'checked="checked"'; ?> value="entries" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'entries' ) ); ?>"><?php esc_html_e( 'Display Experiences as List', 'homey' ); ?></label>
		</p>

		<p>
			<input type="checkbox" <?php checked( $instance[ 'featured' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featured' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>"><?php esc_html_e('Show only featured:', 'homey'); ?></label>
		</p>

		<?php
	}

}

if ( ! function_exists( 'Homey_experience_loader' ) ) {
	function Homey_experience_loader (){
		register_widget( 'Homey_experience' );
	}
	add_action( 'widgets_init', 'Homey_experience_loader' );
}