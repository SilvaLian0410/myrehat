<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Text with icon Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.1
 */
class Homey_Elementor_Icon_Box extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve Features Block widget name.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'homey_elementor_icon_box';
    }

    /**
     * Get widget title.
     *
     * Retrieve Features Block widget title.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Icon Box', 'homey-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Features Block widget icon.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-icon-box';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Features Section widget belongs to.
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
     * Register Features Block widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function register_controls() {

        //Content
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'homey-core' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__( 'Icon Type', 'homey-core' ),
                'type' => Controls_Manager::SELECT,
                'options'   => [
                    'fontawesome_icon_n'  => 'Font Awesome - New',
                    'custom_icon'    => 'Custom Icon',
                    'fontawesome_icon'  => 'FontAwesome - Old',
                ],
                'default' => 'fontawesome_icon_n'
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'icon_type' => 'fontawesome_icon_n',
                ],
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Fontawesome Icon', 'homey-core' ),
                'type'  => Controls_Manager::ICON,
                'condition' => [
                    'icon_type' => 'fontawesome_icon',
                ],
            ]
        );

        $repeater->add_control(
            'custom_icon',
            [
                'label' => esc_html__( 'Custom Icon', 'homey-core' ),
                'type'  => Controls_Manager::MEDIA,
                'condition' => [
                    'icon_type' => 'custom_icon',
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homey-core' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'homey-core' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );
        $repeater->add_control(
            'read_more_text',
            [
                'label' => esc_html__( 'Read More Text', 'homey-core' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'read_more_link',
            [
                'label' => esc_html__( 'Read More Link', 'homey-core' ),
                'type'  => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'icon_boxes',
            [
                'label'       => esc_html__( 'Icon Box', 'homey-core' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => ' {{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_settings',
            [
                'label' => esc_html__( 'Icons Boxes Settings', 'homey-core' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_boxes_style',
            [
                'label'     => 'Style',
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'style_one'  => 'Style One',
                    'style3'    => 'Stype Two'
                ],
                'description' => '',
                'default' => 'style_one',
            ]
        );
        $this->add_control(
            'icon_boxes_columns',
            [
                'label'     => 'Columns',
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'three_columns'  => 'Three Columns',
                    'four_columns'    => 'Four Columns'
                ],
                'description' => '',
                'default' => 'three_columns',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'iconbox_section',
            [
                'label' => esc_html__( 'Box', 'homey-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ]
            ]
        );

        $this->add_control(
            'iconbox_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .services-module .service-block' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'iconbox_padding',
            [
                'label'      => esc_html__( 'Padding', 'homey-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .services-module .service-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'iconbox_shadow',
                'label'    => esc_html__( 'Shadow', 'homey-core' ),
                'selector' => '{{WRAPPER}} .services-module .service-block',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Title', 'homey-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'iconbox_title_typo',
                'label'    => esc_html__( 'Typography', 'homey-core' ),
                'selector' => '{{WRAPPER}} .services-module .module-item .block-content h3',
            ]
        );

        $this->add_control(
            'iconbox_title_color',
            [
                'label'     => esc_html__( 'Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .services-module .module-item .block-content h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'text_content_section',
            [
                'label' => esc_html__( 'Content', 'homey-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'iconbox_text_typo',
                'label'    => esc_html__( 'Typography', 'homey-core' ),
                'selector' => '{{WRAPPER}} .services-module .module-item .block-content p',
            ]
        );

        $this->add_control(
            'iconbox_text_color',
            [
                'label'     => esc_html__( 'Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .services-module .module-item .block-content p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'readmore_content_section',
            [
                'label' => esc_html__( 'Read More', 'homey-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'readmore_text_typo',
                'label'    => esc_html__( 'Typography', 'homey-core' ),
                'selector' => '{{WRAPPER}} .services-module .module-item .block-content a',
            ]
        );

        $this->add_control(
            'readmore_text_color',
            [
                'label'     => esc_html__( 'Color', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .services-module .module-item .block-content a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'readmore_text_color_hover',
            [
                'label'     => esc_html__( 'Color :Hover', 'homey-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .services-module .module-item .block-content a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


    }

    /**
     * Render Features Block widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $icon_boxes_style = $settings['icon_boxes_style'];
        $icon_boxes_columns = $settings['icon_boxes_columns'];

        if( $icon_boxes_style == 'style3' ) { $no_margin = ''; } else { $no_margin = 'no-margin'; }
        ?>
        <div class="homey-module service-blocks-main services-module <?php echo esc_attr( $icon_boxes_columns ).' '.esc_attr( $icon_boxes_style ); ?>">
            <div class="row <?php echo esc_attr( $no_margin ); ?>">
            <?php
            foreach (  $settings['icon_boxes'] as $icon_box ) { 

                $read_more_link = $icon_box['read_more_link']['url'];
                $is_external = $icon_box['read_more_link']['is_external'];
                $icon_type = $icon_box['icon_type'];
                $custom_icon_id = isset( $icon_box['custom_icon']['id'] ) ? $icon_box['custom_icon']['id'] : '';

                $icon_image = '';
                if( ! empty( $custom_icon_id ) ) {
                    $icon_image = wp_get_attachment_image( $icon_box['custom_icon']['id'] );
                }
                $icon_fontawesome = esc_attr($icon_box['icon']); 

                $migration_allowed = Icons_Manager::is_migration_allowed();

                // add old default
                if ( ! isset( $icon_box['icon'] ) && ! $migration_allowed ) {
                    $icon_box['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
                }

                $migrated = isset( $icon_box['__fa4_migrated']['selected_icon'] );
                $is_new = ! isset( $icon_box['icon'] ) && $migration_allowed;

                ?>

                <div class="module-item">
                    <div class="service-block">
                        <div class="block-icon">
                            

                            <?php
                            if( $icon_type == "fontawesome_icon" ) { ?>
                                <div class="icon-div">
                                    <i class="<?php echo esc_attr($icon_fontawesome); ?>"></i>
                                </div>
                            <?php 
                            } else if( $icon_type == "fontawesome_icon_n" ) {
                                
                                if ( ! empty( $icon_box['icon'] ) || ( ! empty( $icon_box['selected_icon']['value'] ) && $is_new ) ) {

                                    if ( $is_new || $migrated ) { ?>
                                        
                                        <div class="icon-div">
                                            <?php Icons_Manager::render_icon( $icon_box['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        </div>

                                    <?php
                                    } else { ?>
                                            <div class="icon-div">
                                                <i class="<?php echo esc_attr( $icon_box['icon'] ); ?>" aria-hidden="true"></i>
                                            </div>
                                    <?php }
                                }

                            } else {
                                echo $icon_image;
                            }
                            ?>
                        </div>
                        <div class="block-content">
                        <h3> <?php echo esc_attr($icon_box['title']); ?></h3>
                            <p><?php echo wp_kses_post($icon_box['text']); ?></p>
                        <?php if( $read_more_link != '' ) { ?>
                            <a href="<?php echo esc_url($read_more_link); ?>"  <?php if($is_external == 'on') { echo 'target="_blank"'; } ?> class="read-more"><?php echo esc_attr( $icon_box['read_more_text'] ); ?></a>
                        <?php } ?>
                        
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
            </div>
        </div>
    <?php

    }

}

Plugin::instance()->widgets_manager->register( new Homey_Elementor_Icon_Box); 