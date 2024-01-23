<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Grids Widget.
 * @since 1.0.1
 */
class Homey_Elementor_Experience_Grids_v2_Carousel extends Widget_Base {

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
        return 'homey_elementor_experience_grids_v2_carousel';
    }

    /**
     * Get widget title.
     * @since 1.0.1
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Experience Grids v2 Carousel', 'homey-core' );
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
        return 'eicon-slider-push';
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

        $experience_type = array();
        $experience_country = array();
        $experience_state = array();
        $experience_city = array();
        $experience_area = array();
        homey_get_terms_array_elementor( 'experience_type', $experience_type );
        homey_get_terms_array_elementor( 'experience_country', $experience_country );
        homey_get_terms_array_elementor( 'experience_state', $experience_state );
        homey_get_terms_array_elementor( 'experience_city', $experience_city );
        homey_get_terms_array_elementor( 'experience_area', $experience_area );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'homey_grid_from',
            [
                'label'     => esc_html__( 'Choose Taxonomy', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'experience_type' => 'Types',
                    'experience_country' => 'Country',
                    'experience_state' => 'State',
                    'experience_city' => 'City',
                    'experience_area' => 'Area',
                ],
                'description' => '',
                'default' => 'experience_type',
            ]
        );

        $this->add_control(
            'experience_type',
            [
                'label'     => esc_html__( 'Type', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_type,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'experience_country',
            [
                'label'     => esc_html__( 'Country', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_country,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'experience_state',
            [
                'label'     => esc_html__( 'State', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_state,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'experience_city',
            [
                'label'     => esc_html__( 'City', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_city,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'experience_area',
            [
                'label'     => esc_html__( 'Area', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_area,
                'description' => '',
                'multiple' => true,
                'default' => '',
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

        /*--------------------------------------------------------------------------------
        * Next Prev button
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_next_prev',
            [
                'label' => esc_html__( 'Next/Prev buttons', 'homey-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'np_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'np_color',
            [
                'label'     => esc_html__( 'Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow' => 'border: 1px solid {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_bg_color_hover',
            [
                'label'     => esc_html__( 'Background Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'np_color_hover',
            [
                'label'     => esc_html__( 'Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-grid-module-v2 .slick-arrow:hover' => 'border: 1px solid {{VALUE}}',
                ],
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
        $experience_type = $experience_country = $experience_state = $experience_city = $experience_area = array();

        if(!empty($settings['experience_type'])) {
            $experience_type = implode (",", $settings['experience_type']);
        }

        if(!empty($settings['experience_country'])) {
            $experience_country = implode (",", $settings['experience_country']);
        }

        if(!empty($settings['experience_state'])) {
            $experience_state = implode (",", $settings['experience_state']);
        }

        if(!empty($settings['experience_city'])) {
            $experience_city = implode (",", $settings['experience_city']);
        }

        if(!empty($settings['experience_area'])) {
            $experience_area = implode (",", $settings['experience_area']);
        }

        $args['homey_grid_from'] =  $settings['homey_grid_from'];
        $args['homey_show_child'] =  $settings['homey_show_child'];
        $args['orderby'] =  $settings['orderby'];
        $args['order'] =  $settings['order'];
        $args['homey_hide_empty'] =  $settings['homey_hide_empty'];
        $args['no_of_terms'] =  $settings['no_of_terms'];

        $args['experience_type']    =  $experience_type;
        $args['experience_country'] =  $experience_country;
        $args['experience_state']   =  $experience_state;
        $args['experience_city']    =  $experience_city;
        $args['experience_area']    =  $experience_area;
       
        if( function_exists( 'homey_experience_grids_v2_carousel' ) ) {
            echo homey_experience_grids_v2_carousel( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Homey_Elementor_Experience_Grids_v2_Carousel );