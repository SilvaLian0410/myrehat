<?php
if( !function_exists('homey_experience_by_id') ) {
    function homey_experience_by_id($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'experience_style' => '',
            'experience_id' => ''
        ), $atts));

        ob_start();

        global $template_args;

        $template_args = array( 'listing-item-view' => 'item-grid-view' );

        if ( $experience_style == 'list' || $experience_style == 'list-v2' ) {
            $template_args = array( 'listing-item-view' => 'item-list-view' );
        } elseif ( $experience_style == 'card' ) {
            $template_args = array( 'listing-item-view' => 'item-card-view' );
        }

        $args = array(
            'post_type' => 'experience',
            'post__in' => array($experience_id),
            'post_status' => 'publish'
        );

        //do the query
        $the_query = New WP_Query($args);
        ?>

        <div class="module-wrap property-module-by-id">
            <div class="experience-wrap which-layout-<?php echo $experience_style;?> <?php if(str_contains($experience_style, '2')){ echo 'item-'.grid_list_or_card($experience_style, 1).'-view'; } ?> item-<?php esc_attr_e($experience_style);?>-view">
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
                    get_template_part('template-parts/experience/experience', 'none');
                endif;
                ?>
            </div><!-- grid-experience-page -->
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('homey-experience-by-id', 'homey_experience_by_id');
}
?>
