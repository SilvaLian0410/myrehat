<?php
/**
 * Widget Name: Taxonomies For Experience
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 12/01/16
 * Time: 11:58 PM
 */
class HOMEY_taxonomies_cards_exp extends WP_Widget {

    /**
     * Register widget
     **/
    public function __construct() {

        parent::__construct(
            'homey_taxonomies_cards_exp', // Base ID
            esc_html__( 'Homey: Taxonomies Cards Experience', 'homey' ), // Name
            array( 'classname' => 'widget-taxonomies-card widget-categories', 'description' => esc_html__( 'Show experience type, room type, countries, cities, areas', 'homey' ), ) // Args
        );

    }


    /**
     * Front-end display of widget
     **/
    public function widget( $args, $instance ) {

        global $before_widget, $after_widget, $before_title, $after_title, $post;
        extract( $args );

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
        $experience_taxonomy = $instance['taxonomy'];
        $tax_count = $instance['tax_count'];
        $items_num = $instance['items_num'];

        if( $tax_count == 'yes' ) { $show_count = true; } else { $show_count = false; }


        echo wp_kses( $before_widget, $allowed_html_array );

        if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );

        echo '<div class="widget-body">';
            homey_experience_taxonomies_cards_exp( $experience_taxonomy, $show_count, $items_num );
        echo '</div>';

        echo wp_kses( $after_widget, $allowed_html_array );
    }


    /**
     * Sanitize widget form values as they are saved
     **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['taxonomy'] = $new_instance['taxonomy'];
        $instance['tax_count'] = $new_instance['tax_count'];
        $instance['items_num'] = $new_instance['items_num'];

        return $instance;

    }


    /**
     * Back-end widget form
     **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => '',
            'taxonomy' => 'experience_type',
            'tax_count' => 'yes',
            'items_num' => '3'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'homey'); ?></label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php esc_html_e( 'Taxonomy', 'homey' ); ?>
                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
                    
                    <option value="experience_type" <?php echo ($instance['taxonomy'] == 'experience_type') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Type', 'homey' ); ?></option>
                
                    
                    <option value="experience_country" <?php echo ($instance['taxonomy'] == 'experience_country') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Country', 'homey' ); ?></option>

                    <option value="experience_state" <?php echo ($instance['taxonomy'] == 'experience_state') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'State', 'homey' ); ?></option>
                    <option value="experience_city" <?php echo ($instance['taxonomy'] == 'experience_city') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'City', 'homey' ); ?></option>

                    <option value="experience_area" <?php echo ($instance['taxonomy'] == 'experience_area') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Area', 'homey' ); ?></option>
                    

                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tax_count' ) ); ?>"><?php esc_html_e( 'Count', 'homey' ); ?>
                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'tax_count' ) ); ?>">
                    <option value="yes" <?php echo ($instance['tax_count'] == 'yes') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Show Count', 'homey' ); ?></option>
                    <option value="no" <?php echo ($instance['tax_count'] == 'no') ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Hide Count', 'homey' ); ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>"><?php esc_html_e('Maximum posts to show:', 'homey'); ?></label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items_num' ) ); ?>" value="<?php echo esc_attr( $instance['items_num'] ); ?>" size="1" />
        </p>

        <?php
    }

}

if ( ! function_exists( 'HOMEY_taxonomies_cards_exp_loader' ) ) {
    function HOMEY_taxonomies_cards_exp_loader (){
        register_widget( 'HOMEY_taxonomies_cards_exp' );
    }
    add_action( 'widgets_init', 'HOMEY_taxonomies_cards_exp_loader' );
}

if(!function_exists('homey_experience_taxonomies_cards_exp')) {
    function homey_experience_taxonomies_cards_exp($tax, $show_count, $items_num) {
        $terms = get_terms( $tax , array( 'parent'=> 0 ));
        $tCount = '';

        $total = 0;
        if( !is_wp_error($terms) ) {
            $count = count($terms);
            if ( $count > 0 ){
                
                foreach ($terms as $term) {
                    
                    if($total == $items_num) {
                        break;
                    }

                    $attach_id = get_term_meta($term->term_id, 'homey_taxonomy_img_exp', true);
                    $attachment = wp_get_attachment_image_src( $attach_id, 'homey_thumb_360_120' );


                    if(empty($attachment)) {
                        $img_url = 'https://place-hold.it/360x120';
                        $img_width = '360';
                        $img_height = '120';
                    }else{
                        $img_url = $attachment['0'];
                        $img_width = $attachment['1'];
                        $img_height = $attachment['2'];
                    }

                    if( $show_count ) {
                        $tCount = '('.esc_attr( $term->count ).')';
                    }

                    echo '<div class="taxonomy-card">
                        <a class="taxonomy-link hover-effect" href="' . esc_url( get_term_link( $term->slug, $term->taxonomy ) ). '">
                            <div class="taxonomy-title">'.esc_attr( $term->name ).' '.$tCount.'</div>
                            <img class="img-responsive" src="'.esc_url($img_url).'" width="'.$img_width.'" height="'.$img_height.'" alt="'.esc_attr($term->name).'">
                        </a>
                    </div>
                    ';

                    $total++;
                }

            }
        }
    }
}
