<?php
class HOMEY_advanced_exp_search_form extends WP_Widget {


    /**
     * Register widget
     **/
    public function __construct() {

        parent::__construct(
            'homey_experience_advanced_search_form', // Base ID
            esc_html__( 'Homey: Experience Advanced Search Form', 'homey' ), // Name
            array( 'description' => esc_html__( 'Advance Search Form Widget widget', 'homey' ), 'classname' => 'widget widget-advanced-search widget-advanced-search-experiences' ) // Args
        );

    }

    /**
     * Front-end display of widget
     **/
    public function widget( $args, $instance ) {
        global $before_widget, $after_widget, $before_title, $after_title, $post;
        $term_limit = 5;

        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );
        //hide sections
        $hide_title = $instance[ 'hide_title' ];
        $hide_where_section = $instance[ 'hide_where_section' ];
        $hide_price_section = $instance[ 'hide_price_section' ];
        $hide_amenities_section = $instance[ 'hide_amenities_section' ];
        $hide_facilities_section = $instance[ 'hide_facilities_section' ];
        //$hide_host_rules_section = $instance[ 'hide_host_rules_section' ];
        $hide_host_languages_section = $instance[ 'hide_host_languages_section' ];

        $allowed_html_array = array(
            'div' => array(
                'id' => array(),
                'class' => array()
            ),
            'h3' => array(
                'class' => array()
            )
        );

        echo wp_kses( $before_widget, $allowed_html_array );
        if ( $title and !$hide_title) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );

        $location_field = homey_option('location_field');
        if($location_field == 'geo_location') {
            $location_classes = "search-destination search-destination-js";
        } elseif($location_field == 'keyword') {
            $location_classes = "search-destination search-destination-js";
        } else {
            $location_classes = "search-destination with-select search-destination-js";
        }

        ?>

        <div class="widget-body">
            <form class="clearfix" action="<?php echo homey_get_search_result_exp_page(); ?>" method="GET">
                <?php if(!$hide_where_section):?>
                    <div class="widget-advanced-search-form clearfix">
                        <h4 class="widget-filter-title"><?php echo esc_html__('Search', 'homey'); ?></h4>
                        <div class="<?php echo esc_attr($location_classes); ?> clearfix">
                            <?php if($location_field == 'geo_location') { ?>
                                <label class="animated-label"><?php echo esc_attr(homey_option('srh_whr_to_go_exp')); ?></label>
                                <input type="text" name="location_search" autocomplete="off" id="location_search_banner" value="<?php echo esc_attr($location_search); ?>" class="form-control input-search" placeholder="<?php echo esc_attr(homey_option('srh_whr_to_go_exp')); ?>">
                                <input type="hidden" name="search_city" data-value="<?php echo esc_attr($city); ?>" value="<?php echo esc_attr($city); ?>">
                                <input type="hidden" name="search_area" data-value="<?php echo esc_attr($area); ?>" value="<?php echo esc_attr($area); ?>">
                                <input type="hidden" name="search_country" data-value="<?php echo esc_attr($country); ?>" value="<?php echo esc_attr($country); ?>">

                                <input type="hidden" name="lat" value="<?php echo esc_attr($lat); ?>">
                                <input type="hidden" name="lng" value="<?php echo esc_attr($lng); ?>">

                                <button type="reset" class="btn clear-input-btn"><i class="homey-icon homey-icon-close" aria-hidden="true"></i></button>

                            <?php }
                            elseif($location_field == 'keyword') { ?>

                                <label class="animated-label"><?php echo esc_attr(homey_option('srh_whr_to_go_exp')); ?></label>
                                <input type="text" name="keyword" autocomplete="off" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" class="form-control input-search" placeholder="<?php echo esc_attr(homey_option('srh_whr_to_go_exp')); ?>">

                            <?php }
                            elseif($location_field == 'country') { ?>

                                <select name="country" class="selectpicker" data-live-search="true">
                                    <?php
                                    // All Option
                                    echo '<option value="">'.esc_attr(homey_option('srh_whr_to_go_exp')).'</option>';

                                    $experience_country = get_terms (
                                        array(
                                            "experience_country"
                                        ),
                                        array(
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => false,
                                            'parent' => 0
                                        )
                                    );
                                    homey_hirarchical_options('experience_country', $experience_country, $experience_country_pre );
                                    ?>
                                </select>

                            <?php } elseif($location_field == 'state') { ?>

                                <select name="state" class="selectpicker" data-live-search="true">
                                    <?php
                                    // All Option
                                    echo '<option value="">'.esc_attr(homey_option('srh_whr_to_go_exp')).'</option>';

                                    $experience_state = get_terms (
                                        array(
                                            "experience_state"
                                        ),
                                        array(
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => false,
                                            'parent' => 0
                                        )
                                    );
                                    homey_hirarchical_options('experience_state', $experience_state, $experience_state_pre );
                                    ?>
                                </select>

                            <?php } elseif($location_field == 'city') { ?>

                                <select name="city" class="selectpicker" data-live-search="true">
                                    <?php
                                    // All Option
                                    echo '<option value="">'.esc_attr(homey_option('srh_whr_to_go_exp')).'</option>';

                                    $experience_city = get_terms (
                                        array(
                                            "experience_city"
                                        ),
                                        array(
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => false,
                                            'parent' => 0
                                        )
                                    );
                                    homey_hirarchical_options('experience_city', $experience_city, $experience_city_pre );
                                    ?>
                                </select>

                            <?php } elseif($location_field == 'area') { ?>

                                <select name="area" class="selectpicker" data-live-search="true">
                                    <?php
                                    // All Option
                                    echo '<option value="">'.esc_attr(homey_option('srh_whr_to_go_exp')).'</option>';

                                    $experience_area = get_terms (
                                        array(
                                            "experience_area"
                                        ),
                                        array(
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => false,
                                            'parent' => 0
                                        )
                                    );
                                    homey_hirarchical_options('experience_area', $experience_area, $experience_area_pre );
                                    ?>
                                </select>

                            <?php } ?>

                        </div>

                        <div class="search-date-range widget-main-search-date-range-js">
                            <div class="search-date-range-arrive">
                                <label class="animated-label"><?php echo esc_attr(homey_option('srh_arrive_label_exp')); ?></label>
                                <input name="arrive" autocomplete="off" value="<?php echo homey_format_date_simple(date('d-m-Y')); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr(homey_option('srh_arrive_label_exp')); ?>">
                            </div>
                            <?php get_template_part ('template-parts/search/search-calendar-exp'); ?>
                        </div>

                        <div class="search-guests search-guests-js">
                            <input name="guest" autocomplete="off" value="1" type="text" class="form-control" placeholder="<?php echo esc_html__(esc_attr(homey_option('srh_guests_label_exp')), 'homey'); ?>">
                            <?php get_template_part ('template-parts/search/search-guests'); ?>
                        </div>
                    </div><!-- widget-advanced-search-form -->
                <?php endif; ?>

                <?php if(!$hide_price_section): ?>
                    <div class="widget-advanced-search-filters widget-advanced-search-price">
                        <h4 class="widget-filter-title"><?php echo esc_html__('Price', 'homey'); ?></h4>

                        <?php
                        $experience_min_num_opt = get_option('experience_night_price_min', -1);
                        $experience_max_num_opt = get_option('experience_night_price_max', -1);

                        $experience_min_num = $experience_min_num_opt;
                        $experience_max_num = $experience_max_num_opt;

                        $experience_max_num = $experience_max_num > 10 ? $experience_max_num : 10;

                        $steps = 1;
                        if($experience_max_num > 10){
                            $steps = floor($experience_max_num / 10);
                        }

                        ?>
                        <select class="selectpicker" title="<?php echo esc_html__('Min.', 'homey'); ?>" name="min-price">
                            <option value="" selected="selected"><?php echo esc_html__('Select Min. Price', 'homey'); ?></option>

                            <?php for($experience_min_num; $experience_min_num <= $experience_max_num; $experience_min_num += $steps) { ?>
                                <option value="<?php echo $experience_min_num; ?>"><?php echo homey_formatted_price($experience_min_num); ?></option>
                            <?php } ?>
                            <option value="<?php echo $experience_max_num_opt; ?>"><?php echo homey_formatted_price($experience_max_num_opt); ?></option>

                        </select>
                        <?php
                        $experience_min_num = $experience_min_num_opt;
                        $experience_max_num = $experience_max_num_opt;
                        ?>
                        <select class="selectpicker" title="<?php echo esc_html__('Max.', 'homey'); ?>" name="max-price">
                            <option value="" selected="selected"><?php echo esc_html__('Select Max. Price', 'homey'); ?></option>

                            <?php for($experience_min_num; $experience_min_num <= $experience_max_num; $experience_min_num += $steps) { ?>
                                <option value="<?php echo $experience_min_num; ?>"><?php echo homey_formatted_price($experience_min_num); ?></option>
                            <?php } ?>
                            <option value="<?php echo $experience_max_num_opt; ?>"><?php echo homey_formatted_price($experience_max_num_opt); ?></option>

                        </select>
                    </div><!-- widget-advanced-search-filters widget-advanced-search-price -->
                <?php endif; ?>

                <?php if(!$hide_amenities_section): ?>
                    <div class="widget-advanced-search-filters widget-advanced-search-amenities">
                        <h4 class="widget-filter-title">Amenities</h4>
                        <div class="filters">
                            <?php
                            $terms = get_terms( array(
                                'taxonomy' => 'experience_amenity',
                                'number' => $term_limit,
                                'hide_empty' => false
                            ) );
                            foreach ($terms as $term){
                                ?>
                                <label class="control control--checkbox">
                                    <input id="host_facilities_<?php echo $term->term_id; ?>" name="amenity[]" type="checkbox" value="<?php echo $term->slug; ?>">
                                    <span class="control-text"><?php echo esc_html__($term->name, 'homey'); ?></span>
                                    <span class="control__indicator"></span>
                                </label>
                            <?php } ?>
                        </div><!-- filters -->

                        <div class="collapse" id="collapseAmenities-mobile">
                            <div class="filters">
                                <?php foreach ($terms as $term){  ?>
                                <label class="control control--checkbox">
                                    <input id="host_amenities_<?php echo $term->term_id; ?>" name="amenity[]" type="checkbox" value="<?php echo $term->slug; ?>">
                                    <span class="control-text"><?php echo esc_html__($term->name, 'homey'); ?></span>
                                    <span class="control__indicator"></span>
                                </label>
                                <?php } ?>
                            </div>
                        </div><!-- collapse -->

                        <div class="filters">
                            <a role="button" data-toggle="collapse" href="#collapseAmenities-mobile" aria-expanded="false" aria-controls="collapseAmenities-mobile">
                                <span class="filter-more-link"><?php echo esc_html__('More', 'homey'); ?></span>
                                <i class="homey-icon homey-icon-navigation-menu-horizontal-interface-essential" aria-hidden="true"></i>
                            </a>
                        </div><!-- filters -->
                    </div><!-- widget-advanced-search-filters widget-advanced-search-amenities -->
                <?php endif; ?>

                <?php if(!$hide_facilities_section): ?>
                    <div class="widget-advanced-search-filters widget-advanced-search-facilities">
                        <h4 class="widget-filter-title"><?php echo esc_html__('Facilities', 'homey'); ?></h4>
                        <div class="filters">
                            <?php
                                $terms = get_terms( array(
                                    'taxonomy' => 'experience_facility',
                                    'number' => $term_limit,
                                    'hide_empty' => false
                                ) );
                                foreach ($terms as $term){
                            ?>
                                <label class="control control--checkbox">
                                    <input id="host_facilities_<?php echo $term->term_id; ?>" name="facility[]" type="checkbox" value="<?php echo $term->slug; ?>">
                                    <span class="control-text"><?php echo esc_html__($term->name, 'homey'); ?></span>
                                    <span class="control__indicator"></span>
                                </label>
                            <?php } ?>
                        </div><!-- filters -->

                        <div class="collapse" id="collapseFacilities-mobile">
                            <div class="filters">
                                <?php foreach ($terms as $term){ ?>
                                <label class="control control--checkbox">
                                    <input id="host_facilities_<?php echo $term->term_id; ?>" name="facility[]" type="checkbox" value="<?php echo $term->slug; ?>">
                                    <span class="control-text"><?php echo esc_html__($term->name, 'homey'); ?></span>
                                    <span class="control__indicator"></span>
                                </label>
                                <?php } ?>
                            </div>
                        </div><!-- collapse -->

                        <div class="filters">
                            <a role="button" data-toggle="collapse" href="#collapseFacilities-mobile" aria-expanded="false" aria-controls="collapseFacilities-mobile">
                                <span class="filter-more-link"><?php echo esc_html__('More', 'homey'); ?></span>
                                <i class="homey-icon homey-icon-navigation-menu-horizontal-interface-essential" aria-hidden="true"></i>
                            </a>
                        </div><!-- filters -->
                    </div><!-- widget-advanced-search-filters widget-advanced-search-facilities -->
                <?php endif; ?>

                <?php if(1==2 && !$hide_host_rules_section): ?>
                    <div class="widget-advanced-search-filters widget-advanced-search-house-rules">
                        <h4 class="widget-filter-title">House Rules</h4>
                        <div class="filters">
                            <label class="control control--checkbox">
                                <input name="Option Name" type="checkbox">
                                <span class="contro-text">Option Name</span>
                                <span class="control__indicator"></span>
                            </label>
                            <label class="control control--checkbox">
                                <input name="Option Name" type="checkbox">
                                <span class="contro-text">Option Name</span>
                                <span class="control__indicator"></span>
                            </label>
                            <label class="control control--checkbox">
                                <input name="Option Name" type="checkbox">
                                <span class="contro-text">Option Name</span>
                                <span class="control__indicator"></span>
                            </label>
                            <label class="control control--checkbox">
                                <input name="Option Name" type="checkbox">
                                <span class="contro-text">Option Name</span>
                                <span class="control__indicator"></span>
                            </label>
                        </div><!-- filters -->
                    </div><!-- widget-advanced-search-filters widget-advanced-search-house-rules -->
                <?php endif; ?>

                <?php if(!$hide_host_languages_section): ?>
                    <div class="widget-advanced-search-filters widget-advanced-search-host-languages">
                        <h4 class="widget-filter-title"><?php echo esc_html__('Host Language', 'homey'); ?></h4>
                        <div class="filters">
                            <?php
                            $terms = get_terms( array(
                                'taxonomy' => 'experience_language',
                                'number' => $term_limit,
                                'hide_empty' => false
                            ) );
                            foreach ($terms as $term){
                                ?>
                                <label class="control control--checkbox">
                                    <input id="host_language_<?php echo $term->term_id; ?>" name="language[]" type="checkbox" value="<?php echo $term->slug; ?>">
                                    <span class="control-text"><?php echo $term->name; ?></span>
                                    <span class="control__indicator"></span>
                                </label>
                            <?php } ?>
                        </div><!-- filters -->
                    </div><!-- widget-advanced-search-filters widget-advanced-search-host-languages -->
                <?php endif; ?>

                <div class="search-button">
                    <button type="submit" class="btn btn-primary btn-full-width" style="padding: 0 30px"><?php echo esc_html__('Search', 'homey'); ?></button>
                </div>
            </form>
        </div>
        <?php
        echo wp_kses( $after_widget, $allowed_html_array );

    }


    /**
     * Sanitize widget form values as they are saved
     **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['hide_title'] = $new_instance[ 'hide_title' ] == "on"? true : false;
        $instance['hide_where_section'] = $new_instance[ 'hide_where_section' ] == "on"? true : false;
        $instance['hide_price_section'] = $new_instance[ 'hide_price_section' ] == "on"? true : false;
        $instance['hide_amenities_section'] = $new_instance[ 'hide_amenities_section' ] == "on"? true : false;
        $instance['hide_facilities_section'] = $new_instance[ 'hide_facilities_section' ] == "on"? true : false;
//        $instance['hide_host_rules_section'] = $new_instance[ 'hide_host_rules_section' ] == "on"? true : false;
        $instance['hide_host_languages_section'] = $new_instance[ 'hide_host_languages_section' ] == "on"? true : false;

        return $instance;

    }


    /**
     * Back-end widget form
     **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => 'Experience Advanced Search Form',
            'hide_title' => '',
            'hide_where_section' => '',
            'hide_price_section' => '',
            'hide_amenities_section' => '',
            'hide_facilities_section' => '',
//            'hide_host_rules_section' => '',
            'hide_host_languages_section' => ''
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'homey'); ?></label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_title'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_title' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>"><?php esc_html_e( 'Do not display the title', 'homey' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_where_section'] == true) echo 'checked amaz'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_where_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_where_section' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_where_section' ) ); ?>"><?php esc_html_e( 'Do not display the where section.', 'homey' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_price_section'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_price_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_price_section' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_price_section' ) ); ?>"><?php esc_html_e( 'Do not display the price section.', 'homey' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_amenities_section'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_amenities_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_amenities_section' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_amenities_section' ) ); ?>"><?php esc_html_e( 'Do not display the amenities section.', 'homey' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_facilities_section'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_facilities_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_facilities_section' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_facilities_section' ) ); ?>"><?php esc_html_e( 'Do not display the facilities section.', 'homey' ); ?></label>
        </p>

<!--        <p>-->
<!--            <input class="checkbox" type="checkbox" --><?php //if( $instance['hide_host_rules_section'] == true ) echo 'checked'; ?><!-- id="--><?php //echo esc_attr( $this->get_field_id( 'hide_host_rules_section' ) ); ?><!--" name="--><?php //echo esc_attr( $this->get_field_name( 'hide_host_rules_section' ) ); ?><!--" />-->
<!--            <label for="--><?php //echo esc_attr( $this->get_field_id( 'hide_host_rules_section' ) ); ?><!--">--><?php //esc_html_e( 'Do not display the rules section.', 'homey' ); ?><!--</label>-->
<!--        </p>-->

        <p>
            <input class="checkbox" type="checkbox" <?php if( $instance['hide_host_languages_section'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_host_languages_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_host_languages_section' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_host_languages_section' ) ); ?>"><?php esc_html_e( 'Do not display the languages section.', 'homey' ); ?></label>
        </p>

        <?php
    }
}

if ( ! function_exists( 'homey_experience_advanced_search_loader' ) ) {
    function homey_experience_advanced_search_loader (){
        register_widget( 'HOMEY_advanced_exp_search_form' );
    }
    add_action( 'widgets_init', 'homey_experience_advanced_search_loader' );
}