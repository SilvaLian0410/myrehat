<?php
/**
 * Run cron Jobs for different events
 */

/*-----------------------------------------------------------------------------------*/
// Add Weekly crop interval
/*-----------------------------------------------------------------------------------*/
add_filter( 'cron_schedules', 'homey_add_weekly_cron_schedule' );
if( !function_exists('homey_add_weekly_cron_schedule') ):
    function homey_add_weekly_cron_schedule( $schedules ) {

        $schedules['weekly'] = array(
            'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
            'display'  => 'Once Weekly',
        );
        $schedules['one_minute'] = array(
            'interval' => 30,
            'display'  => 'One minute',
        );

        return $schedules;
    }
endif;

add_action( 'homey_reservation_declined', 'homey_reservation_declined_callback' );
if( !function_exists('homey_reservation_declined_callback') ) {
    function homey_reservation_declined_callback () {
        //reservation_status 
        $args = array(
            'post_type' => 'homey_reservation',
            'post_status' => 'publish'
        );

        $args['meta_key'] = 'reservation_status';
        $args['meta_value'] = 'available';

        $listing_selection = new WP_Query($args);

        if($listing_selection->have_posts()):
            while ($listing_selection->have_posts()): $listing_selection->the_post();

                $reservation_id = get_the_ID();
                $listing_id = get_post_meta($reservation_id, 'reservation_listing_id', true);
                $booked_on = get_post_meta($reservation_id, 'reservation_confirm_date_time', true);

                $num_hours = homey_option('num_0f_hours_to_remove_pending_resrv');
                if($num_hours >  0){
                    $num_hours = $num_hours - 1;
                }

                $booked_on_timestamp = strtotime($booked_on);
                $current_time = current_time('timestamp');

                $booked_on_datetime = date('Y-m-d H:i:s', $booked_on_timestamp);
                $now = date('Y-m-d H:i:s', $current_time);

                $t1 = $booked_on_timestamp;
                $t2 = strtotime($now);
                $diff = $t2 - $t1;
                $hours = $diff / ( 60 * 60 );

                if ($hours > $num_hours) {
                    //Remove Pending Dates
                    $pending_dates_array = homey_remove_booking_pending_days($listing_id, $reservation_id);
                    update_post_meta($listing_id, 'reservation_pending_dates', $pending_dates_array);
                    update_post_meta($reservation_id, 'reservation_status', 'declined');
                    update_post_meta($reservation_id, 'reservation_declined', $now->toDateTimeString());

                    $listing_owner = get_post_meta($reservation_id, 'listing_owner', true);
                    $renter = homey_usermeta($listing_owner);
                    $renter_email = $renter['email'];

                    $email_args = array('reservation_detail_url' => reservation_detail_link($reservation_id) );
                    homey_email_composer( $renter_email, 'cancelled_reservation', $email_args );
                }
            endwhile;
        endif;
    }
}


add_action( 'homey_featured_listing_expire_check', 'homey_featured_listing_expire_callback' );
if( !function_exists('homey_featured_listing_expire_callback') ) {
    function homey_featured_listing_expire_callback () {

        $featured_listing_expire = intval ( homey_option('featured_listing_expire') );


        if ( $featured_listing_expire > 0 ) {

            $args = array(
                'post_type' => 'listing',
                'post_status' => 'publish'
            );

            $args['meta_key'] = 'homey_featured';
            $args['meta_value'] = '1';

            $listing_selection = new WP_Query($args);
            while ($listing_selection->have_posts()): $listing_selection->the_post();

                $the_id = get_the_ID();

                $prop_listed_date = get_post_meta($the_id, 'homey_featured_datetime', true);

                $prop_listed_date = strtotime($prop_listed_date);

                $expiration_date = $prop_listed_date + $featured_listing_expire * 24 * 60 * 60;

                $today = strtotime(date( 'Y-m-d G:i:s', current_time( 'timestamp', 0 ) ));

                $user_id = homey_get_author_by_post_id($the_id);
                $user = new WP_User($user_id); //administrator
                $user_role = $user->roles[0];

                if(!empty($prop_listed_date)) {
                    //if ($user_role != 'administrator') {
                    if ($expiration_date < $today) {
                        homey_listing_set_to_expire($the_id);
                    }
                    //}
                }
            endwhile;
        }
    }
}


/* -----------------------------------------------------------------------------------------------------------
 *  Set Listings as expire for featured - keep
 -------------------------------------------------------------------------------------------------------------*/
if( !function_exists('homey_listing_set_to_expire') ):
    function homey_listing_set_to_expire($post_id) {

        update_post_meta( $post_id, 'homey_featured', 0 );
        delete_post_meta( $post_id, 'homey_featured_datetime' );

    }
endif;

/* -----------------------------------------------------------------------------------------------------------
 *  Set Earnings after Guest Checked Out
 -------------------------------------------------------------------------------------------------------------*/
 add_action( 'homey_add_earnings_sched', 'homey_add_earning_scheduled' );
if(!function_exists('homey_add_earning_scheduled')) {
    function homey_add_earning_scheduled() {
        global $wpdb;
        $allowded_html = array();
        
        $table_name_date = $wpdb->prefix . 'homey_earnings_date';
        $table_name_earn = $wpdb->prefix . 'homey_earnings';

        //Add Today's Data 
        $current_date = date('Y-m-d');

        $rows = $wpdb->get_results("SELECT * FROM $table_name_date");
        
        foreach ($rows as $row) {
             // Assigning values to variables from each row
             $id = $row->id;
             $listing_host = $row->user_id;
             $listing_guest = $row->guest_id;
             $listing_id = $row->listing_id;
             $reservation_id = $row->reservation_id;
             $services_fee = $row->services_fee;
             $host_fee = $row->host_fee;
             $upfront_payment = $row->upfront_payment;
             $payment_due = $row->payment_due;
             $net_earnings = $row->net_earnings;
             $total_price = $row->total_amount;
             $security_deposit = $row->security_deposit;
             $chargeable_amount = $row->chargeable_amount;
             $host_fee_percent = $row->host_fee_percent;
             $check_in_date = $row->check_in_date;
             $check_out_date = $row->check_out_date;

        
            if ((string)$check_out_date == '2024-01-04') {
                // If $check_out_date matches $current_date for this row
                
                $is_added = $wpdb->query(
                    "SELECT * FROM $table_name_earn WHERE user_id = $listing_host AND  guest_id = $listing_guest AND listing_id = $listing_id AND reservation_id = $reservation_id AND check_in_date = $check_in_date AND check_out_date = $check_out_date"
                );
        
                if($is_added < 1){
                    $order_id = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $table_name_earn
                    ( user_id, guest_id, listing_id, reservation_id, services_fee, host_fee, upfront_payment, payment_due, net_earnings, total_amount, security_deposit, chargeable_amount, host_fee_percent, check_in_date, check_out_date )
                    VALUES ( %d, %d, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                        $listing_host,
                        $listing_guest,
                        $listing_id,
                        $reservation_id,
                        $services_fee,
                        $host_fee,
                        $upfront_payment,
                        $payment_due,
                        $net_earnings,
                        $total_price,
                        $security_deposit,
                        $chargeable_amount,
                        $host_fee_percent,
                        $check_in_date,
                        $check_out_date
                    ) );

                        $all_fees = $services_fee + $security_deposit + $host_fee;
                        $total_net_earnings = $total_price - $all_fees;
                        homey_add_host_earnings($listing_host, $net_earnings, $total_net_earnings);
                        homey_add_guest_security($listing_guest, $security_deposit);

                    // Delete the row from $table_name_date
            $wpdb->delete($table_name_date, array('id' => $id));
            }
        }
    }
}
}

/* -----------------------------------------------------------------------------------------------------------
 *  Set Earnings after Guest Checked Out for Experiences
 -------------------------------------------------------------------------------------------------------------*/
 add_action( 'homey_add_earnings_exp_sched', 'homey_add_earning_exp_scheduled' );
if(!function_exists('homey_add_earning_exp_scheduled')) {
    function homey_add_earning_exp_scheduled() {
        global $wpdb;
        $allowded_html = array();
        
        $table_name_date = $wpdb->prefix . 'homey_earnings_date';
        $table_name_earn = $wpdb->prefix . 'homey_earnings';

        //Add Today's Data 
        $current_date = date('Y-m-d');

        $rows = $wpdb->get_results("SELECT * FROM $table_name_date");
        
        foreach ($rows as $row) {
             // Assigning values to variables from each row
             $id = $row->id;
             $experience_host = $row->user_id;
             $expeirence_guest = $row->guest_id;
             $experience_id = $row->listing_id;
             $reservation_id = $row->reservation_id;
             $services_fee = $row->services_fee;
             $host_fee = $row->host_fee;
             $upfront_payment = $row->upfront_payment;
             $payment_due = $row->payment_due;
             $net_earnings = $row->net_earnings;
             $total_price = $row->total_amount;
             $security_deposit = $row->security_deposit;
             $chargeable_amount = $row->chargeable_amount;
             $host_fee_percent = $row->host_fee_percent;
             $check_in_date = $row->check_in_date;
             $check_out_date = $row->check_out_date;

        
            if ((string)$check_in_date == '2024-01-26') {
                // If $check_out_date matches $current_date for this row
                
                $is_added = $wpdb->query(
                    "SELECT * FROM $table_name_earn WHERE user_id = $experience_host AND  guest_id = $experience_guest AND listing_id = $experience_id AND reservation_id = $reservation_id AND check_in_date = $check_in_date AND check_out_date = $check_out_date"
                );
        
                if($is_added < 1){
                    $order_id = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $table_name_earn
                    ( user_id, guest_id, listing_id, reservation_id, services_fee, host_fee, upfront_payment, payment_due, net_earnings, total_amount, security_deposit, chargeable_amount, host_fee_percent, check_in_date, check_out_date )
                    VALUES ( %d, %d, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                        $experience_host,
                        $experience_guest,
                        $experience_id,
                        $reservation_id,
                        $services_fee,
                        $host_fee,
                        $upfront_payment,
                        $payment_due,
                        $net_earnings,
                        $total_price,
                        $security_deposit,
                        $chargeable_amount,
                        $host_fee_percent,
                        $check_in_date,
                        $check_out_date
                    ) );

                        $all_fees = (float)$services_fee + (float)$security_deposit + (float)$host_fee;
                        $total_net_earnings = (float)$total_price - (float)$all_fees;
                        homey_add_host_earnings((float)$experience_host, (float)$net_earnings, (float)$total_net_earnings);
                        homey_add_guest_security($experience_guest, (float)$security_deposit);

                    // Delete the row from $table_name_date
            $wpdb->delete($table_name_date, array('id' => $id));
            }
        }
    }
}
}