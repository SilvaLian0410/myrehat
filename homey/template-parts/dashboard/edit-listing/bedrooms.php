<?php 
global $homey_prefix, $homey_local, $listing_data;
$accomodation = get_post_meta($listing_data->ID, $homey_prefix.'accomodation', true);
$class = '';
if(isset($_GET['tab']) && $_GET['tab'] == 'bedrooms') {
    $class = 'in active';
}
$hello = 2;
$test = date( 'Y-m-d', strtotime( '- $hello Days' ) );

$cancellation_policy = get_post_meta($listing_data->ID, $homey_prefix.'cancellation_policy', true);

if (!empty($cancellation_policy)) {
    if ($cancellation_policy == 26640) {
        $cancellation_content = 'Flexible';
		$tomorrow = date('Y-m-d', strtotime($test . ' + 3 days'));
    } elseif ($cancellation_policy == 26645) {
        // Get content for post ID 26645
        $cancellation_content = 'Moderate';
		$tomorrow = date('Y-m-d', strtotime($test . ' + 5 days'));
    } elseif ($cancellation_policy == 27593) {
        $cancellation_content = 'Strict';
		$tomorrow = date('Y-m-d', strtotime($test . ' + 10 days'));
    } else {
        $cancellation_content = 'Strict';
    }
} else {
    $cancellation_content = 'None';
	$tomorrow = $test;
}

function testing() {
    return 1;
}


function get_all_post_ids_from_listing_query() {
    // Define the query arguments
    $query_args = array(
        'post_type' => 'listing',
        'posts_per_page' => -1, // Retrieve all posts
        'fields' => 'ids', // Only retrieve post IDs to reduce overhead
    );

    // Get the post IDs based on the query
    $post_ids = get_posts($query_args);

    // Return the array of post IDs
    return $post_ids;
}

$all_post_ids = get_all_post_ids_from_listing_query();

?>

<div id="bedrooms-tab" class="tab-pane fade <?php echo esc_attr($class); ?>">
    <div class="block-title visible-xs">
        <h3 class="title"><?php echo esc_html(homey_option('ad_bedrooms_text')); ?></h3>
    </div>
    <div class="block-body">
        <div id="more_bedrooms_main">
            <?php 
            $count = 0;
            if(!empty($accomodation)) {
                foreach($accomodation as $acc):
                ?>
                    <div class="more_rooms_wrap">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="acc_bedroom_name"><?php?></label>
                                    <input type="text" name="homey_accomodation[<?php echo intval($count); ?>][acc_bedroom_name]" value="<?php echo sanitize_text_field( $acc['acc_bedroom_name'] ); ?>" class="form-control" placeholder="<?php echo esc_attr(homey_option('ad_acc_bedroom_name_plac')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="acc_guests"> <?php echo $cancellation_policy; ?> </label>
                                    <input type="text" name="homey_accomodation[<?php echo intval($count); ?>][acc_guests]" value="<?php echo sanitize_text_field( $acc['acc_guests'] ); ?>" class="form-control" placeholder="<?php echo esc_attr(homey_option('ad_acc_guests_plac')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="acc_no_of_beds"><?php echo $tomorrow; ?> </label>
                                    <input type="text" name="homey_accomodation[<?php echo intval($count); ?>][acc_no_of_beds]" value="<?php echo sanitize_text_field( $acc['acc_no_of_beds'] ); ?>" class="form-control" placeholder="<?php echo esc_attr(homey_option('ad_acc_no_of_beds_plac')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="acc_bedroom_type"><?php echo $cancellation_content; ?></label>
                                    <input type="text" name="homey_accomodation[<?php echo intval($count); ?>][acc_bedroom_type]" value="<?php echo sanitize_text_field( $acc['acc_bedroom_type'] ); ?>" class="form-control" placeholder="<?php echo esc_attr(homey_option('ad_acc_bedroom_type_plac')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <button type="button" data-remove="<?php echo esc_attr( $count-1 ); ?>" class="btn btn-primary remove-beds"><?php echo esc_attr(homey_option('ad_acc_btn_remove_room'));?></button>
                            </div>
                        </div>
                        <hr>
                    </div>
             <?php  $count++;
                endforeach; 
            } ?>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12 text-right">
                <button type="button" id="add_more_bedrooms" data-increment="<?php echo esc_attr( $count-1 ); ?>" class="btn btn-primary"><i class="homey-icon homey-icon-add"></i> <?php echo esc_attr(homey_option('ad_acc_btn_add_other')); ?></button>
            </div>
        </div>
		
		<div class="row">
			<?php 
			
			if ($all_post_ids) {
    // Loop through each post ID
    foreach ($all_post_ids as $post_id) {
        echo "Post ID: " . $post_id . "<br>";
    }
} else {
    // No posts found
    echo "No posts found.";
}
			
			?>
        </div>
    </div>
</div>