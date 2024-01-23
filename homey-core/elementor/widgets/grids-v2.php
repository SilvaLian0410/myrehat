<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Grids Widget.
 * @since 1.0.1
 */
class Homey_Elementor_Grids_v2 extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'homey_elementor_grids_v2';
    }

    /**
     * Get widget title.
     * @since 1.0.1
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Homey Grids v2', 'homey-core' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 1.0.1
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'homey-elements' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function register_controls() {

        $listing_type = array();
        $room_type = array();
        $listing_country = array();
        $listing_state = array();
        $listing_city = array();
        $listing_area = array();
        homey_get_terms_array_elementor( 'listing_type', $listing_type );
        homey_get_terms_array_elementor( 'room_type', $room_type );
        homey_get_terms_array_elementor( 'listing_country', $listing_country );
        homey_get_terms_array_elementor( 'listing_state', $listing_state );
        homey_get_terms_array_elementor( 'listing_city', $listing_city );
        homey_get_terms_array_elementor( 'listing_area', $listing_area );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'homey_grid_type',
            [
                'label'     => esc_html__( 'Choose Grid', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid-v1'  => 'Version v1',
                    'grid-v2'    => 'Version v2',
                ],
                'description' => '',
                'default' => 'grid-v1',
            ]
        );

        $this->add_control(
            'homey_grid_from',
            [
                'label'     => esc_html__( 'Choose Taxonomy', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'listing_type' => 'Listing Types',
                    'room_type' => 'Room Type',
                    'listing_country' => 'Listing Country',
                    'listing_state' => 'Listing State',
                    'listing_city' => 'Listing City',
                    'listing_area' => 'Listing Area',
                ],
                'description' => '',
                'default' => 'listing_type',
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'     => esc_html__( 'Listing Type', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $listing_type,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'listing_type',
                ],
            ]
        );

        $this->add_control(
            'room_type',
            [
                'label'     => esc_html__( 'Room Type', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $room_type,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'room_type',
                ],
            ]
        );

        $this->add_control(
            'listing_country',
            [
                'label'     => esc_html__( 'Listing Country', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $listing_country,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'listing_country',
                ],
            ]
        );

        $this->add_control(
            'listing_state',
            [
                'label'     => esc_html__( 'Listing State', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $listing_state,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'listing_state',
                ],
            ]
        );

        $this->add_control(
            'listing_city',
            [
                'label'     => esc_html__( 'Listing City', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $listing_city,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'listing_city',
                ],
            ]
        );

        $this->add_control(
            'listing_area',
            [
                'label'     => esc_html__( 'Listing Area', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $listing_area,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'homey_grid_from' => 'listing_area',
                ],
            ]
        );

        

        $this->add_control(
            'homey_show_child',
            [
                'label'     => esc_html__( 'Show Child', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0'  => esc_html__( 'No', 'homey-core'),
                    '1'    => esc_html__( 'Yes', 'homey-core')
                ],
                'description' => '',
                'default' => '0',
            ]
        );

        $this->add_control(
            'homey_hide_empty',
            [
                'label'     => esc_html__( 'Hide Empty', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0'  => esc_html__( 'No', 'homey-core'),
                    '1'    => esc_html__( 'Yes', 'homey-core')
                ],
                'description' => '',
                'default' => '1',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order By', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'name'  => esc_html__( 'Name', 'homey-core'),
                    'count'    => esc_html__( 'Count', 'homey-core'),
                    'id'    => esc_html__( 'ID', 'homey-core')
                ],
                'description' => '',
                'default' => 'name',
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'ASC'  => esc_html__( 'ASC', 'homey-core'),
                    'DESC'  => esc_html__( 'DESC', 'homey-core')
                ],
                'default' => 'ASC',
            ]
        );


        $this->add_control(
            'no_of_terms',
            [
                'label'     => esc_html__('Number of Items to Show', 'homey-core'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '',
            ]
        );
        
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Styling
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'style_secingion',
            [
                'label'     => esc_html__( 'Style', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tax_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item-v2 .taxonomy-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tax_count_color',
            [
                'label'     => esc_html__( 'Count Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tax_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item-v2' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'tax_box_radius',
            [
                'label'      => esc_html__( 'Box Radius', 'homey-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .taxonomy-item-v2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tax_image_radius',
            [
                'label'      => esc_html__( 'Image Radius', 'homey-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2-grid-v1 .taxonomy-item-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .taxonomy-grid-module-v2-grid-v2 .taxonomy-item-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'label'    => esc_html__( 'Shadow', 'homey-core' ),
                'selector' => '{{WRAPPER}} .taxonomy-item-v2',
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $listing_type = $room_type = $listing_country = $listing_state = $listing_city = $listing_area = array();

        if(!empty($settings['listing_type'])) {
            $listing_type = implode (",", $settings['listing_type']);
        }

        if(!empty($settings['room_type'])) {
            $room_type = implode (",", $settings['room_type']);
        }

        if(!empty($settings['listing_country'])) {
            $listing_country = implode (",", $settings['listing_country']);
        }

        if(!empty($settings['listing_state'])) {
            $listing_state = implode (",", $settings['listing_state']);
        }

        if(!empty($settings['listing_city'])) {
            $listing_city = implode (",", $settings['listing_city']);
        }

        if(!empty($settings['listing_area'])) {
            $listing_area = implode (",", $settings['listing_area']);
        }

        $args['homey_grid_type'] =  $settings['homey_grid_type'];
        $args['homey_grid_from'] =  $settings['homey_grid_from'];
        $args['homey_show_child'] =  $settings['homey_show_child'];
        $args['orderby'] =  $settings['orderby'];
        $args['order'] =  $settings['order'];
        $args['homey_hide_empty'] =  $settings['homey_hide_empty'];
        $args['no_of_terms'] =  $settings['no_of_terms'];

        $args['listing_type']    =  $listing_type;
        $args['room_type']       =  $room_type;
        $args['listing_country'] =  $listing_country;
        $args['listing_state']   =  $listing_state;
        $args['listing_city']    =  $listing_city;
        $args['listing_area']    =  $listing_area;
       
        if( function_exists( 'homey_grids_v2' ) ) {
            echo homey_grids_v2( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register( new Homey_Elementor_Grids_v2 );