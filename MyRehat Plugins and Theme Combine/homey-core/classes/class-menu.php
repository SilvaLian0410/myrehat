<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homey_Menu {

    public $slug = 'homey-listings';
    public $experiences_slug = 'homey-experiences';
    public $capability = 'edit_posts';
    public static $instance;

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'setup_menu' ) );
        add_action( 'admin_menu', array( $this, 'setup_experiences_menu' ) );
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setup_menu() {

        $submenus = array();

        $menu_name = apply_filters('homey_listings_menu_label', esc_html__( 'Listings', 'homey-core' ));
        add_menu_page(
            $menu_name,
            $menu_name,
            $this->capability,
            $this->slug,
            '',
            'dashicons-admin-multisite',
            '6'
        );

        $submenus['addnew'] = array(
            $this->slug,
            esc_html__( 'Add New', 'homey-core' ),
            esc_html__( 'New Listing', 'homey-core' ),
            $this->capability,
            'post-new.php?post_type=listing',
        );

        // Property post type taxonomies
        $taxonomies = get_object_taxonomies( 'listing', 'objects' );
        foreach ( $taxonomies as $single_tax ) {
            $submenus[ $single_tax->name ] = array(
                $this->slug,
                $single_tax->labels->add_new_item,
                $single_tax->labels->name,
                $this->capability,
                'edit-tags.php?taxonomy=' . $single_tax->name . '&post_type=listing',
            );
        }

        

        $submenus['homey_reservation'] = array(
            $this->slug,
            esc_html__( 'Reservations', 'homey-core' ),
            esc_html__( 'Reservations', 'homey-core' ),
            $this->capability,
            'edit.php?post_type=homey_reservation',
        );


        // Add filter for third party scripts
        $submenus = apply_filters( 'homey_admin_lisitngs_menu', $submenus );

        if ( $submenus ) {
            foreach ( $submenus as $sub_menu ) {
                call_user_func_array( 'add_submenu_page', $sub_menu );
            }
        } // end $submenus
    }

    public function setup_experiences_menu() {

        $submenus = array();

        $menu_name = apply_filters('homey_experiences_menu_label', esc_html__( 'Experiences', 'homey-core' ));
        add_menu_page(
            $menu_name,
            $menu_name,
            $this->capability,
            $this->experiences_slug,
            '',
            'dashicons-buddicons-activity',
            '6'
        );

        $submenus['addnew_experience'] = array(
            $this->experiences_slug,
            esc_html__( 'Add New', 'homey-core' ),
            esc_html__( 'New Experience', 'homey-core' ),
            $this->capability,
            'post-new.php?post_type=experience',
        );

        // Property post type taxonomies
        $taxonomies = get_object_taxonomies( 'experience', 'objects' );
        foreach ( $taxonomies as $single_tax ) {
            $submenus[ $single_tax->name ] = array(
                $this->experiences_slug,
                $single_tax->labels->add_new_item,
                $single_tax->labels->name,
                $this->capability,
                'edit-tags.php?taxonomy=' . $single_tax->name . '&post_type=experience',
            );
        }

        

        $submenus['homey_e_reservation'] = array(
            $this->experiences_slug,
            esc_html__( 'Reservations', 'homey-core' ),
            esc_html__( 'Reservations', 'homey-core' ),
            $this->capability,
            'edit.php?post_type=homey_e_reservation',
        );


        // Add filter for third party scripts
        $submenus = apply_filters( 'homey_admin_experiences_menu', $submenus );

        if ( $submenus ) {
            foreach ( $submenus as $sub_menu ) {
                call_user_func_array( 'add_submenu_page', $sub_menu );
            }
        } // end $submenus
    }

}