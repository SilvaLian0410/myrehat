<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homey_Experience_Post_Type {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
      
        add_action( 'init', array( __CLASS__, 'experience_type' ) );

        add_action( 'init', array( __CLASS__, 'experience_language' ) );

        //add_action( 'init', array( __CLASS__, 'what_bring_item_type' ) );
        //add_action( 'init', array( __CLASS__, 'what_provided_item_type' ) );

        add_action( 'init', array( __CLASS__, 'experience_amenities' ) );
        add_action( 'init', array( __CLASS__, 'experience_facilities' ) );

        add_action( 'init', array( __CLASS__, 'experience_country' ) );
        add_action( 'init', array( __CLASS__, 'experience_state' ) );
        add_action( 'init', array( __CLASS__, 'experience_city' ) );
        add_action( 'init', array( __CLASS__, 'experience_area' ) );

        add_action( 'save_post', array( __CLASS__, 'save_experience_post_type' ), 10, 3 );

        add_action( 'added_post_meta', array( __CLASS__, 'save_guests_meta' ), 10, 4 );
        add_action( 'updated_post_meta', array( __CLASS__, 'save_guests_meta' ), 10, 4 );

        add_filter( 'manage_edit-experience_columns', array( __CLASS__, 'custom_experience_columns' ) );
        add_action( 'manage_pages_custom_column', array( __CLASS__, 'custom_experience_columns_manage' ) );

        add_filter('manage_edit-experience_area_columns', array( __CLASS__, 'experienceArea_columns_head' ));
        add_filter('manage_experience_area_custom_column',array( __CLASS__, 'experienceArea_columns_content_taxonomy' ), 10, 3);

        add_filter('manage_edit-experience_city_columns', array( __CLASS__, 'experienceCity_columns_head' ));
        add_filter('manage_experience_city_custom_column',array( __CLASS__, 'experienceCity_columns_content_taxonomy' ), 10, 3);

        add_filter('manage_edit-experience_state_columns', array( __CLASS__, 'experienceState_columns_head' ));
        add_filter('manage_experience_state_custom_column',array( __CLASS__, 'experienceState_columns_content_taxonomy' ), 10, 3);

        add_action('admin_init', array( __CLASS__, 'homey_approve_experience' ));
        add_action('admin_init', array( __CLASS__, 'homey_expire_experience' ));
    
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name' => esc_html__( 'Experiences','homey-core'),
            'singular_name' => esc_html__( 'Experience','homey-core' ),
            'add_new' => esc_html__('Add New','homey-core'),
            'add_new_item' => esc_html__('Add New','homey-core'),
            'edit_item' => esc_html__('Edit Experience','homey-core'),
            'new_item' => esc_html__('New Experience','homey-core'),
            'view_item' => esc_html__('View Experience','homey-core'),
            'search_items' => esc_html__('Search Experience','homey-core'),
            'not_found' =>  esc_html__('No Experience found','homey-core'),
            'not_found_in_trash' => esc_html__('No Experience found in Trash','homey-core'),
            'parent_item_colon' => ''
          );

        $labels = apply_filters( 'homey_experience_post_type_labels', $labels );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => 'homey-experiences',
            'query_var' => true,
            'has_archive' => true,
            'capability_type' => 'post',
            'map_meta_cap'    => true,
            'hierarchical' => true,
            'menu_icon' => 'dashicons-location',
            'menu_position' => 20,
            'can_export' => true,
            'show_in_rest'       => true,
            'rest_base'          => 'experiences',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title','editor','thumbnail','revisions','author','page-attributes','excerpt'),

             // The rewrite handles the URL structure.
            'rewrite' => array(
                  'slug'       => homey_get_experience_rewrite_slug(),
                  'with_front' => false,
                  'pages'      => true,
                  'feeds'      => true,
                  'ep_mask'    => EP_PERMALINK,
            ),
        );

        $args = apply_filters( 'homey_experience_post_type_args', $args );

        register_post_type('experience',$args);
    }

    public static function experience_type() {

        $type_labels = array(
            'name'              => esc_html__('Experience Type','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New Experience Type','homey-core')
        );
        $type_labels = apply_filters( 'experience_type_labels', $type_labels );

        $args = array(
            'labels' => $type_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_type',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_type_rewrite_slug() )
        );

        $args = apply_filters( 'experience_type_args', $args );

        register_taxonomy('experience_type', 'experience', $args);
    }

    public static function experience_language() {

        $experience_language_labels = array(
            'name'              => esc_html__('Experience Language','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New Experience Language','homey-core')
        );
        $experience_language_labels = apply_filters( 'experience_language_labels', $experience_language_labels );

        $args = array(
            'labels' => $experience_language_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_language',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_language_rewrite_slug() )
        );

        $args = apply_filters( 'experience_language_args', $args );

        register_taxonomy('experience_language', 'experience', $args );


    }

    public static function what_bring_item_type() {

        $what_bring_item_type_labels = array(
            'name'              => esc_html__('What Bring Item Type','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New What Bring Item Type','homey-core')
        );
        $what_bring_item_type_labels = apply_filters( 'what_bring_item_type_labels', $what_bring_item_type_labels );

        $args = array(
            'labels' => $what_bring_item_type_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'what_bring_item_type',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_what_bring_item_type_rewrite_slug() )
        );

        $args = apply_filters( 'what_bring_item_type_args', $args );

        register_taxonomy('what_bring_item_type', 'experience', $args );
    }

    public static function what_provided_item_type() {

        $what_provided_item_type_labels = array(
            'name'              => esc_html__('What Provided Item Type','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New What Provided Item Type','homey-core')
        );
        $what_provided_item_type_labels = apply_filters( 'what_provided_item_type_labels', $what_provided_item_type_labels );

        $args = array(
            'labels' => $what_provided_item_type_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'what_provided_item_type',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_what_provided_item_type_rewrite_slug() )
        );

        $args = apply_filters( 'what_provided_item_type_args', $args );

        register_taxonomy('what_provided_item_type', 'experience', $args );
    }

    public static function experience_amenities() {

        $experience_amenity_labels = array(
            'name'              => esc_html__('Amenities','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New Amenity','homey-core')
        );
        $experience_amenity_labels = apply_filters( 'experience_amenity_labels', $experience_amenity_labels );

        $args = array(
            'labels' => $experience_amenity_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_amenities',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_amenity_rewrite_slug() )
        );
        $args = apply_filters( 'experience_amenity_args', $args );

        register_taxonomy('experience_amenity', 'experience', $args);
    }

    public static function experience_facilities() {

        $experience_facility_labels = array(
            'name'              => esc_html__('Facilities','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New Facility','homey-core')
        );
        $experience_facility_labels = apply_filters( 'experience_facility_labels', $experience_facility_labels );

        $args =  array(
            'labels' => $experience_facility_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_facilities',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_facility_rewrite_slug() )
        );
        $args = apply_filters( 'experience_facility_argss', $args );

        register_taxonomy('experience_facility', 'experience', $args);
    }

    public static function experience_country() {

        $experience_country_labels = array(
            'name'              => esc_html__('Country','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New Country','homey-core')
        );
        $experience_country_labels = apply_filters( 'experience_country_labels', $experience_country_labels );

        $args = array(
            'labels' => $experience_country_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_countries',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_country_rewrite_slug() )
        );
        $args = apply_filters( 'experience_country_args', $args );

        register_taxonomy('experience_country', 'experience', $args);
    }

    public static function experience_state() {

        $experience_state_labels = array(
            'name'              => esc_html__('State','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New State','homey-core')
        );
        $experience_state_labels = apply_filters( 'experience_state_labels', $experience_state_labels );

        $args = array(
            'labels' => $experience_state_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_states',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_state_rewrite_slug() )
        );
        $args = apply_filters( 'experience_state_args', $args );

        register_taxonomy('experience_state', 'experience', $args);
    }

    public static function experience_city() {

        $experience_city_labels = array(
            'name'              => esc_html__('City','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New City','homey-core')
        );
        $experience_city_labels = apply_filters( 'experience_city_labels', $experience_city_labels );

        $args = array(
            'labels' => $experience_city_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_cities',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_city_rewrite_slug() )
        );
        $args = apply_filters( 'experience_city_args', $args );

        register_taxonomy('experience_city', 'experience', $args);
    }

    public static function experience_area() {

        $experience_area_labels = array(
            'name'              => esc_html__('Area','homey-core'),
            'add_new_item'      => esc_html__('Add New','homey-core'),
            'new_item_name'     => esc_html__('New area','homey-core')
        );
        $experience_area_labels = apply_filters( 'experience_area_labels', $experience_area_labels );
        
        $args = array(
            'labels' => $experience_area_labels,
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'          => true,
            'rest_base'             => 'experience_areas',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite'       => array( 'slug' => homey_get_experience_area_rewrite_slug() )
        );
        $args = apply_filters( 'experience_area_args', $args );

        register_taxonomy('experience_area', 'experience', $args);
    }

    /**
     * Update post meta associated info when post updated
     *
     * @access public
     * @return
     */
    public static function save_experience_post_type($post_id, $post, $update) {

        if(isset($_POST) && $_POST && !defined( 'DOING_AJAX' )) {
            // If this is just a revision, don't send the email.
            if ( wp_is_post_revision( $post_id ) )
            return;

            if (!is_object($post) || !isset($post->post_type)) {
                return;
            }

            $checkPost = get_post($post_id);
            

            $slug = 'experience';
            // If this isn't a 'book' post, don't update it.
            if ($slug != $post->post_type) {
                return;
            }

            $experience_total_rating = get_post_meta( $post_id, 'experience_total_rating', true );
            if( $experience_total_rating === '') {
                update_post_meta($post_id, 'experience_total_rating', '0');
            }

            $lat_long = get_post_meta( $post_id, 'homey_experience_location', true );
            if( isset($lat_long) && !empty($lat_long)) {
                $lat_long = explode(',', $lat_long);
                $lat = $lat_long[0];
                $long = $lat_long[1];

                update_post_meta($post_id, 'homey_geolocation_lat', $lat);
                update_post_meta($post_id, 'homey_geolocation_long', $long);

                if( $checkPost->post_modified_gmt == $checkPost->post_date_gmt ){
                    self::insert_lat_long($lat, $long, $post_id);
                }else{
                    self::update_lat_long($lat, $long, $post_id);
                }

            }
        }
    }


    public static function save_guests_meta($meta_id, $property_id, $meta_key, $meta_value) {
        if ( empty( $meta_id ) || empty( $property_id ) || empty( $meta_key ) ) {
            return;
        }

        $total_guests = 0;

        $guests  = get_post_meta( $property_id, 'homey_guests', true );
        if( !empty($guests)) {
            $total_guests = $guests;
        }
        $additional_guests  = get_post_meta( $property_id, 'homey_num_additional_guests', true );

        if( !empty($additional_guests) ) {
            $total_guests += $additional_guests;
        }

        update_post_meta( $property_id, 'homey_total_guests_plus_additional_guests', $total_guests );


    }

    public static function insert_lat_long($lat, $long, $list_id) {
        global $wpdb;
        $table_name  = $wpdb->prefix . 'homey_map';

        $wpdb->insert( 
            $table_name, 
            array( 
                'latitude' => $lat,
                'longitude' => $long, 
                'experience_id' => $list_id 
            ), 
            array( 
                '%s',
                '%s', 
                '%d' 
            ) 
        );
        return true;
    }

    public static function update_lat_long($lat, $long, $list_id) {
        
        global $wpdb;
        $table_name  = $wpdb->prefix . 'homey_map';

        $myRow = $wpdb->get_row( "SELECT * FROM $table_name WHERE experience_id = $list_id" );

        if ( null !== $myRow ) {
          $wpdb->update( 
                $table_name, 
                array( 
                    'latitude' => $lat,  // string
                    'longitude' => $long   // integer (number) 
                ), 
                array( 'experience_id' => $list_id ), 
                array( 
                    '%s',   // value1
                    '%s'    // value2
                ), 
                array( '%d' ) 
            );
        } else {
          self::insert_lat_long($lat, $long, $list_id);
        }

        return true;
    }

    /**
     * Custom admin columns for post type
     *
     * @access public
     * @return array
     */
    public static function custom_experience_columns() {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => esc_html__( 'Title','homey-core' ),
            "thumbnail" => esc_html__( 'Thumbnail','homey-core' ),
            "type" => esc_html__('Type','homey-core'),
            "price" => esc_html__('Price','homey-core'), 
            "featured" => esc_html__( 'Featured','homey-core' ),
            //"status" => esc_html__('Status','homey-core'),
            //"experience_posted" => esc_html__( 'Posted','homey-core' ),
            //"experience_expiry" => esc_html__( 'Expires','homey-core' ),
            //"original_id" => esc_html__( 'ID','homey-core' ),
            "experience_id" => esc_html__( 'Experience ID','homey-core' ),
            "date" => esc_html__( 'Date','homey-core' ),
            "homey_actions" => esc_html__( 'Actions','homey-core' ),
        );

        $columns = apply_filters( 'homey_custom_post_experience_columns', $columns );

        return $columns;
        
    }

    /**
     * Custom admin columns for area taxonomy
     *
     * @access public
     * @return array
     */
    
    public static function experienceArea_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => esc_html__('Name','homey-core'),
            'city'          => esc_html__('City','homey-core'),
            'header_icon'   => '',
            'slug'          => esc_html__('Slug','homey-core'),
            'posts'         => esc_html__('Posts','homey-core')
        );


        return $new_columns;
    }


    public static function experienceArea_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'city') {
            $term_meta= get_option( "_homey_experience_area_$term_id");
            $term = get_term_by('slug', $term_meta['parent_city'], 'experience_city'); 
            if(!empty($term)) {
                print stripslashes( $term->name );
            }
            return;
        }
    }

    /**
     * Custom admin columns for city taxonomy
     *
     * @access public
     * @return array
     */
    public static function experienceCity_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => esc_html__('Name','homey-core'),
            'county_state'          => esc_html__('County/State','homey-core'),
            'header_icon'   => '',
            'slug'          => esc_html__('Slug','homey-core'),
            'posts'         => esc_html__('Posts','homey-core')
        );


        return $new_columns;
    }


    public static function experienceCity_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'county_state') {
            $term_meta= get_option( "_homey_experience_city_$term_id");
            if(isset($term_meta['parent_state'])){
                $term = get_term_by('slug', $term_meta['parent_state'], 'experience_state');
                if(!empty($term)) {
                    print stripslashes( $term->name );
                }
            }
            return;
        }
    }



    /**
     * Custom admin columns for state taxonomy
     *
     * @access public
     * @return array
     */
    public static function experienceState_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => esc_html__('Name','homey-core'),
            'country'       => esc_html__('Country','homey-core'),
            'header_icon'   => '',
            'slug'          => esc_html__('Slug','homey-core'),
            'posts'         => esc_html__('Posts','homey-core')
        );


        return $new_columns;
    }


    public static function experienceState_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'country') {
            $term_meta = get_option( "_homey_experience_state_$term_id");
            if (is_array($term_meta)){
                $term = get_term_by('slug', $term_meta['parent_country'], 'experience_country');
                if(!empty($term)) {
                    print stripslashes( $term->name );
                }
            }
            return;
        }
    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_experience_columns_manage( $column ) {
        global $post;

        if($post->post_type == 'experience'){
            $prefix = 'homey_';
            switch ($column)
            {
                case 'thumbnail':
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'thumbnail', array(
                            'class'     => 'attachment-thumbnail attachment-thumbnail-small',
                        ) );
                    } else {
                        echo '-';
                    }
                    break;

                case 'experience_id':
                    echo get_the_ID();
                    break;
                case 'featured':
                    $featured = get_post_meta($post->ID, $prefix.'featured',true);
                    if($featured != 1 ) {
                        _e( 'No', 'homey-core' );
                    } else {
                        _e( 'Yes', 'homey-core' );
                    }
                    break;
                case 'address':
                    $address = get_post_meta($post->ID, $prefix.'experience_address',true);
                    if(!empty($address)){
                        echo esc_attr( $address );
                    }
                    else{
                        _e('No Address Provided!','homey-core');
                    }
                    break;
                case 'type':
                    echo Homey::admin_taxonomy_terms ( $post->ID, 'experience_type', 'experience' );
                    break;
                case 'status':

                    break;
                case 'price':
                    $price = homey_exp_get_price_by_id($post->ID);
                    if(!empty($price)){
                        echo homey_formatted_price( $price, true );
                    }
                    else{
                        echo '-';
                    }
                    break;
                case 'bedrooms':
                    $bed = get_post_meta($post->ID, $prefix.'experience_bedrooms',true);
                    if(!empty($bed)){
                        echo esc_attr( $bed );
                    }
                    else{
                        _e('NA','homey-core');
                    }
                    break;
                case 'baths':
                    $bath = get_post_meta($post->ID, $prefix.'baths',true);
                    if(!empty($bath)){
                        echo esc_attr( $bath );
                    }
                    else{
                        _e('NA','homey-core');
                    }
                    break;
                case 'guests':
                    $guests = get_post_meta($post->ID, $prefix.'guests',true);
                    if(!empty($guests)){
                        echo esc_attr( $guests );
                    }
                    else{
                        _e('NA','homey-core');
                    }
                    break;
                case 'homey_actions':
                    echo '<div class="actions">';
                    $admin_actions = apply_filters( 'post_row_actions', array(), $post );

                    $user = wp_get_current_user();

                    if ( in_array( $post->post_status, array( 'pending' ) ) && in_array( 'administrator', (array) $user->roles ) ) {
                        $admin_actions['approve']   = array(
                            'action'  => 'approve',
                            'name'    => esc_html__( 'Approve', 'homey-core' ),
                            'url'     =>  wp_nonce_url( add_query_arg( 'approve_experience', $post->ID ), 'approve_experience' )
                        );
                    }

                    $admin_actions = apply_filters( 'homey_admin_actions', $admin_actions, $post );

                    foreach ( $admin_actions as $action ) {
                        if ( is_array( $action ) ) {
                            printf( '<a class="button button-icon tips icon-%1$s" href="%2$s" data-tip="%3$s">%4$s</a>', $action['action'], esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_html( $action['name'] ) );
                        } else {
                            //echo str_replace( 'class="', 'class="button ', $action );
                        }
                    }

                    echo '</div>';

                    break;
                case "experience_posted" :
                    echo '<p>' . date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $post->post_date ) ) . '</p>';
                    echo '<p>'.( empty( $post->post_author ) ? esc_html__( 'by a guest', 'homey-core' ) : sprintf( esc_html__( 'by %s', 'homey-core' ), '<a href="' . esc_url( add_query_arg( 'author', $post->post_author ) ) . '">' . get_the_author() . '</a>' ) ) . '</p>';
                    break;
                case "experience_expiry" :
                    if( homey_user_role_by_post_id($post->ID) != 'administrator' && get_post_status ( $post->ID ) == 'publish' ) {
                        homey_experience_expire();

                    }
                    break;
            }
        }
    }

    public static function homey_approve_experience()
    {
        if (!empty($_GET['approve_experience']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'approve_experience') && current_user_can('publish_post', $_GET['approve_experience'])) {
            $post_id = absint($_GET['approve_experience']);
            $experience_data = array(
                'ID' => $post_id,
                'post_status' => 'publish'
            );
            wp_update_post($experience_data);

            $author_id = get_post_field ('post_author', $post_id);
            $user           =   get_user_by('id', $author_id );
            $user_email     =   $user->user_email;

            $args = array(
                'experience_title' => get_the_title($post_id),
                'experience_url' => get_permalink($post_id)
            );
            //homey_email_type( $user_email,'experience_approved', $args );

            wp_redirect(remove_query_arg('approve_experience', add_query_arg('approve_experience', $post_id, admin_url('edit.php?post_type=experience'))));
            exit;
        }
    }

    public static function homey_expire_experience() {

        if (!empty($_GET['expire_experience']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'expire_experience') && current_user_can('publish_post', $_GET['expire_experience'])) {
            $post_id = absint($_GET['expire_experience']);
            $experience_data = array(
                'ID' => $post_id,
                'post_status' => 'expired'
            );
            wp_update_post($experience_data);

            $author_id = get_post_field ('post_author', $post_id);
            $user           =   get_user_by('id', $author_id );
            $user_email     =   $user->user_email;

            $args = array(
                'experience_title' => get_the_title($post_id),
                'experience_url' => get_permalink($post_id)
            );
            //homey_email_type( $user_email,'experience_expired', $args );

            wp_redirect(remove_query_arg('expire_experience', add_query_arg('expire_experience', $post_id, admin_url('edit.php?post_type=experience'))));
            exit;
        }
    }


}