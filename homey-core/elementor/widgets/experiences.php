<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Experiences Widget.
 * @since 1.0.1
 */
class Homey_Elementor_Experiences extends Widget_Base {

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
        return 'homey_elementor_experiences';
    }

    /**
     * Get widget title.
     * @since 1.0.1
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Experiences', 'homey-core' );
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
        return 'eicon-post-list';
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


        $sort_by = array( 
            '' => esc_html__('Default', 'homey'), 
            'a_price' => esc_html__('Price (Low to High)', 'homey'), 
            'd_price' => esc_html__('Price (High to Low)', 'homey'),
            'a_date' => esc_html__('Date (Old to New)', 'homey'),
            'd_date' => esc_html__('Date (New to Old)', 'homey'),
            'featured_top' => esc_html__('Featured on Top', 'homey'),
            'random' => esc_html__('Random', 'homey'),
        );

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

        $sort_by = array( 
            '' => esc_html__('Default', 'homey-core'), 
            'a_price' => esc_html__('Price (Low to High)', 'homey-core'), 
            'd_price' => esc_html__('Price (High to Low)', 'homey-core'),
            'a_date' => esc_html__('Date Old to New', 'homey-core'),
            'd_date' => esc_html__('Date New to Old', 'homey-core'),
            'featured_top' => esc_html__('Featured on Top', 'homey-core'),
            'random' => esc_html__('Random', 'homey-core')
        );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'experience_style',
            [
                'label'     => esc_html__( 'Experience style', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid'  => 'Grid View',
                    'grid-v2'  => 'Grid View v2',
                    'card'    => 'Card View',
                    'list'    => 'List View',
                ],
                'description' => esc_html__("Choose grid/list/card style, default will be list view", "homey"),
                'default' => 'list',
            ]
        );

        $this->add_control(
            'experience_type',
            [
                'label'     => esc_html__( 'Experience Type', 'homey-core' ),
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
                'label'     => esc_html__( 'Experience Country', 'homey-core' ),
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
                'label'     => esc_html__( 'Experience State', 'homey-core' ),
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
                'label'     => esc_html__( 'Experience City', 'homey-core' ),
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
                'label'     => esc_html__( 'Experience Area', 'homey-core' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $experience_area,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );


        $this->add_control(
            'featured_experience',
            [
                'label'     => esc_html__( 'Featured experiences', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''  => esc_html__( '- Any -', 'homey-core'),
                    'no'    => esc_html__('Without Featured', 'homey'),
                    'yes'  => esc_html__('Only Featured', 'homey')
                ],
                "description" => esc_html__("You can make a post featured by clicking the featured experiences checkbox while add/edit post", "homey-core"),
                'default' => '',
            ]
        );

        $this->add_control(
            'loadmore',
            [
                'label'     => esc_html__( 'Load More', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'enable'    => esc_html__('Enable', 'homey'),
                    'disable'  => esc_html__('Disable', 'homey')
                ],
                "description" => esc_html__("Show load more pagination", "homey-core"),
                'default' => 'enable',
            ]
        );

        $this->add_control(
            'sort_by',
            [
                'label'     => esc_html__( 'Sort By', 'homey-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $sort_by,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of properties', 'homey-core'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '9',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'     => 'Offset',
                'type'      => Controls_Manager::TEXT,
                'description' => '',
            ]
        );
        
        $this->end_controls_section();



        /*--------------------------------------------------------------------------------
        * Styling
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'typography_section',
            [
                'label'     => esc_html__( 'Typography', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_property_title',
                'label'    => esc_html__( 'Listing Title', 'homey-core' ),
                'selector' => '{{WRAPPER}} .experience-item .title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_prop_address',
                'label'    => esc_html__( 'Address', 'homey-core' ),
                'selector' => '{{WRAPPER}} address.item-address',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_price',
                'label'    => esc_html__( 'Price', 'homey-core' ),
                'selector' => '{{WRAPPER}} .item-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_types',
                'label'    => esc_html__( 'Type', 'homey-core' ),
                'selector' => '{{WRAPPER}} .item-type',
            ]
        );
    
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Margin and Spacing
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_spacing_margin_section',
            [
                'label'     => esc_html__( 'Spaces & Sizes', 'homey-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'experience_style!' => 'card',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_title_margin_bottom',
            [
                'label' => esc_html__( 'Title Margin Bottom(px)', 'homey-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .experience-item .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_address_margin_bottom',
            [
                'label' => esc_html__( 'Address Margin Bottom(px)', 'homey-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'hz_content_padding',
            [
                'label'      => esc_html__( 'Content Area Padding', 'homey-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .item-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Box Shadow
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_grid_box_shadow',
            [
                'label' => esc_html__( 'Box', 'homey-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'grid_bg_color',
            [
                'label'     => esc_html__( 'Background', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-body' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .item-wrap.item-grid-view .property-item' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .item-wrap.item-list-view .property-item' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'experience_style!' => 'card',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_box_radius',
            [
                'label'      => esc_html__( 'Radius', 'homey-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .item-wrap.item-grid-view .property-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .item-list-view .item-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .item-card-view .item-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'homey-core' ),
                'selector' => '{{WRAPPER}} .item-wrap.item-grid-view .property-item',
                'condition' => [
                    'experience_style' => 'grid',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow_card',
                'label'    => esc_html__( 'Box Shadow', 'homey-core' ),
                'selector' => '{{WRAPPER}} .item-card-view .item-wrap',
                'condition' => [
                    'experience_style' => 'card',
                ],
            ]
        );

        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Colors
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_grid_colors',
            [
                'label' => esc_html__( 'Colors', 'homey-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'address_color',
            [
                'label'     => esc_html__( 'Address Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-address' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icons_color',
            [
                'label'     => esc_html__( 'Icons', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} i.homey-icon' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->add_control(
            'labels_color',
            [
                'label'     => esc_html__( 'Labels', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} span.star-text-right' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .item-type' => 'color: {{VALUE}}',
                    '{{WRAPPER}} span.star-text-right a' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Pagination
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_pagination',
            [
                'label' => esc_html__( 'Pagination', 'homey-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'pagi_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'pagi_color',
            [
                'label'     => esc_html__( 'Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagi_bg_color_hover',
            [
                'label'     => esc_html__( 'Background Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'pagi_color_hover',
            [
                'label'     => esc_html__( 'Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagi_bg_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'pagi_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .homey-loadmore .btn:hover' => 'border-color: {{VALUE}}',
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

        $args['experience_type']    =  $experience_type;
        $args['experience_country'] =  $experience_country;
        $args['experience_state']   =  $experience_state;
        $args['experience_city']    =  $experience_city;
        $args['experience_area']    =  $experience_area;

        $args['experience_style'] =  $settings['experience_style'];
        $args['featured_experience'] =  $settings['featured_experience'];
        $args['posts_limit'] =  $settings['posts_limit'];
        $args['sort_by'] =  $settings['sort_by'];
        $args['offset'] =  $settings['offset'];
        $args['loadmore'] =  $settings['loadmore'];
//        $args['booking_type'] =  $settings['booking_type'];

        if( function_exists( 'homey_experiences' ) ) {
            echo homey_experiences( $args );
        }else{
            //echo homey_experiences( );
           // dd('dilbeeee 33 ');
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Homey_Elementor_Experiences );
