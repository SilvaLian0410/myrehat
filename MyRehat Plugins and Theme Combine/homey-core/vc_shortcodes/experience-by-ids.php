<?php
if( !function_exists('homey_experience_by_ids') ) {
    function homey_experience_by_ids($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'experience_style' => '',
            'experience_ids' => '',
            'columns' => ''
        ), $atts));

        ob_start();
        global $template_args;

        $template_args = array( 'listing-item-view' => 'item-grid-view' );

        if ( $experience_style == 'list' || $experience_style == 'list-v2' ) {
            $template_args = array( 'listing-item-view' => 'item-list-view' );
        } elseif ( $experience_style == 'card' ) {
            $template_args = array( 'listing-item-view' => 'item-card-view' );
        }

        $ids_array = explode(',', $experience_ids);

        if($columns == '2cols') {
            $column_class = 'col-sm-6';
        } else {
            $column_class = 'col-sm-4';
        }

        $args = array(
            'post_type' => 'experience',
            'post__in' => $ids_array,
            'post_status' => 'publish'
        );
        //do the query
        $the_query = New WP_Query($args);
        ?>

        <div class="module-wrap property-module-by-id property-module-by-id-<?php esc_attr_e($columns);?>">
            <div class="experience-wrap which-layout-<?php echo $experience_style;?> <?php if(str_contains($experience_style, '2')){ echo 'item-'.grid_list_or_card($experience_style, 1).'-view'; } ?> item-<?php esc_attr_e($experience_style);?>-view">
                    <?php
                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) : $the_query->the_post();

                            echo '<div class="'.$column_class.'">';
                            if($experience_style == 'card') {
                                get_template_part('template-parts/experience/experience', 'card', $template_args);
                            }elseif($experience_style == 'grid-v2' || $experience_style == 'list-v2') {
                                get_template_part('template-parts/experience/experience', 'item-v2', $template_args);
                            } else {
                                get_template_part('template-parts/experience/experience', 'item', $template_args);
                            }
                            echo '</div>';

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

    add_shortcode('homey-experience-by-ids', 'homey_experience_by_ids');
}
?>
