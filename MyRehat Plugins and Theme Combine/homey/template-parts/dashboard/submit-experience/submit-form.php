<?php
global $homey_local, $hide_fields, $homey_booking_type;
$layout_order = homey_option('experience_form_sections');
$layout_order = $layout_order['enabled'];

$homey_booking_type = homey_booking_type();

if( isset($_GET['mode']) && $_GET['mode'] != '' ) {
    $homey_booking_type = $_GET['mode'];
}

//Get Current Host
global $current_user;

$userID         = $current_user->ID;
$user_login     = $current_user->user_login;

//Link for Upload ID, Contact Number ID, Payment Setup ID
$profile_link  = homey_get_template_link('template/dashboard-profile.php');
$verification_link = $profile_link . '?dpage=' . 'verification';
$payment_link = $profile_link . '?dpage=' . 'payment-method';

if(homey_is_host() ) {
    $args['author'] = $userID;
    $author_id = $userID;
    $author_meta = get_user_meta( $author_id );
    // Add User Meta for Host
    $user_meta = homey_get_author_by_id('100', '100', 'img-circle', $userID);
    $author = homey_get_author_by_id('70', '70', 'img-circle media-object avatar', $author_id);
    $author_picture_id = get_the_author_meta( 'homey_author_picture_id' , $userID );

    $host_name = $user_meta['em_contact_name'];
    $host_email= $user_meta['em_email'];
    $host_phone = $user_meta['em_phone'];

    //Email and Doc Verified
    $emailverified = (homey_is_verified_by_email($userID));
    $doc_verified = $author['doc_verified'];

    $user_document_ids = get_user_meta( $userID, 'homey_user_document_id' );
    $is_doc_verified_request = get_the_author_meta( 'id_doc_verified_request' , $userID );
    $is_doc_verified = get_the_author_meta( 'doc_verified' , $userID );
    
    $verified = false;
    if($doc_verified) {
        $verified = true;
    }

    // Beneficiary Information
    $ben_first_name = $user_meta['ben_first_name'];
    $ben_last_name = $user_meta['ben_last_name'];
    $ben_company_name = $user_meta['ben_company_name'];
    $ben_tax_number = $user_meta['ben_tax_number'];
    $ben_street_address = $user_meta['ben_street_address'];
    $ben_apt_suit = $user_meta['ben_apt_suit'];
    $ben_city = $user_meta['ben_city'];
    $ben_state = $user_meta['ben_state'];
    $ben_zip_code = $user_meta['ben_zip_code'];

    //Wire Transfer Information
    $bank_account = $user_meta['bank_account'];
    $swift = $user_meta['swift'];
    $bank_name = $user_meta['bank_name'];
}

//Check for Mobile and PC
function isMobileDevice() {
    return preg_match('/(android|webos|iphone|ipod|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
}

$displayBlockPC = 'block'; // Default display for block-pc
$displayBlockMobile = 'none'; // Default display for block-mobile

if (isMobileDevice()) {
    $displayBlockPC = 'none';
    $displayBlockMobile = 'block';
}

?>

<?php
if (homey_is_host()){

    if (
        empty($author_picture_id) || empty($ben_first_name) || empty($ben_last_name) || empty($ben_company_name) ||
        empty($bank_account) || empty($swift) || empty($bank_name) || empty($host_name) || empty($host_email) || empty($host_phone) || ($verified == false && empty($verified))
    ) {
        ?>
        <div class = "block-mobile" style="display: <?php echo $displayBlockPC; ?>;">
            <div class="block">
            <div class="block-head">
                <?php
                if (!empty($ben_first_name) && !empty($ben_last_name) && !empty($ben_company_name) &&
                !empty($bank_account) && !empty($swift) && !empty($bank_name) && !empty($host_name) && !empty($host_email) && !empty($host_phone) && $is_doc_verified_request && !empty( $author_picture_id )) { ?>
                
                <h2 class="title text-center" style = "color:#3ED135;">Nice!, Please Wait, we are waitting</h2>
    
                <?php } else {?>
    
                <h2 class="title text-center" style = "color:red;">Oops you did not meet MyRehat's Credentials</h2>
    
                <?php } ?>
            </div>
            <div class="block-verify">
                <div class="block-col block-col-33">
                    <h3>Contact Information</h3>
                    <div id="homey_user_doc" class="profile-image" style = "display:inline;">
                    <?php
                    if( !empty( $author_picture_id ) ) {
                            $author_picture_id = intval( $author_picture_id );
                            if ( $author_picture_id ) {
                               echo '<img style="display:inline;" src="'.$author['photo']; 
                            }
                        } else { ?>
                            <h5 style = "color:red;"> ( Profile Photo Not Set ) </h5>
                        <?php } ?>
                    </div>
                    <p>Name : <?php echo $host_name; ?></p>
                    <p>Email : <?php echo $host_email; ?></p>
                    <p>Phone Number : <?php echo $host_phone; ?></p>
                    <a href="<?= $profile_link; ?>">Setup Now >></a>
                </div>
                <div class="block-col block-col-33">
                    <h3>Benefinitionary Information</h3>
                    <p>First Name: <?php echo $ben_first_name; ?></p>
                    <p>Last Name:<?php echo $ben_last_name; ?></p>
                    <p>Company Name: <?php echo $ben_company_name; ?></p>
                    <h3>Bank Details</h3>
                    <p>Bank Account: <?php echo $bank_account; ?></p>
                    <p>Bank Swift: <?php echo $swift; ?></p>
                    <p>Bank Name: <?php echo $bank_name; ?></p>
                    <a href="<?= $payment_link; ?>">Setup Now >></a>
                </div>
                <div class="block-col block-col-33">
                    <h3>ID/Business Verification</h3>
                    <div id="homey_user_doc" class="profile-image">
                        <?php
                        if( !empty( $user_document_ids ) ) {
                            foreach ($user_document_ids as $key => $user_document_id ){
                                $user_document_id = intval( $user_document_id );
                                if ( $user_document_id ) {
                                    echo homey_user_document_for_verification($user_document_id);
                                    echo '<input type="hidden" class="profile-doc-id" id="profile-doc-id" name="profile-doc-id" value="' . esc_attr( $user_document_id ).'"/>';
                                }
                            }
    
                        } else {
                            echo '<img src="http://place-hold.it/100x100" width="100" height="100" alt="profile image">';
                        }
                        ?>
                    </div>
                     <?php if($is_doc_verified_request) { ?>
                                <div class="not-verified">
                                    <span class="btn btn-full-width" href="#"> <?php esc_html_e('Pending', 'homey'); ?></span>
                                </div>
                            <?php } ?>
                    <a href="<?= $verification_link; ?>">Setup Now >></a>
                </div>
            </div>
        </div>
        </div>
    
        <div class = "block-pc" style="display: <?php echo $displayBlockMobile; ?>;">
        <div class="block">
            <div class="block-head">
                <?php
    if (!empty($ben_first_name) && !empty($ben_last_name) && !empty($ben_company_name) &&
    !empty($bank_account) && !empty($swift) && !empty($bank_name) && !empty($host_name) && !empty($host_email) && !empty($host_phone) && $is_doc_verified_request && !empty( $author_picture_id )) { ?>
                
                <h2 class="title text-center" style = "color:#3ED135;">Nice!, Please Wait, we are checking your info</h2>
    
                <?php } else {?>
    
                <h2 class="title text-center" style = "color:red;">Oops you did not meet MyRehat's Credentials, Please Fill in the : </h2>
    
                <?php } ?>
            </div>
            <div class="block">
                <div class="block-head" style="text-align: center;">
                    <h3>Contact Information</h3>
                    <div id="homey_user_doc" class="profile-image" style = "display:inline;">
                    <?php
                    if( !empty( $author_picture_id ) ) {
                            $author_picture_id = intval( $author_picture_id );
                            if ( $author_picture_id ) {
                               echo '<img style="display:inline;" src="'.$author['photo']; 
                            }
                        } else { ?>
                            <h5 style = "color:red;"> ( Profile Photo Not Set )</h5>
                        <?php } ?>
                    </div>
                    <p>Name : <?php echo $host_name; ?></p>
                    <p>Email : <?php echo $host_email; ?></p>
                    <p>Phone Number : <?php echo $host_phone; ?></p>
                    <a href="<?= $profile_link; ?>">Setup Now >></a>
                </div>
                <div class="block-head" style="text-align: center;">
                    <h3>Benefinitionary Information</h3>
                    <p>First Name: <?php echo $ben_first_name; ?></p>
                    <p>Last Name:<?php echo $ben_last_name; ?></p>
                    <p>Company Name: <?php echo $ben_company_name; ?></p>
                    <h3>Bank Details</h3>
                    <p>Bank Account: <?php echo $bank_account; ?></p>
                    <p>Bank Swift: <?php echo $swift; ?></p>
                    <p>Bank Name: <?php echo $bank_name; ?></p>
                    <a href="<?= $payment_link; ?>">Setup Now >></a>
                </div>
                <div class="block-head" style="text-align: center;">
                    <h3>ID/Business Verification</h3>
                    <div id="homey_user_doc" class="profile-image">
                        <?php
                        if( !empty( $user_document_ids ) ) {
                            foreach ($user_document_ids as $key => $user_document_id ){
                                $user_document_id = intval( $user_document_id );
                                if ( $user_document_id ) {
                                    echo homey_user_document_for_verification($user_document_id);
                                    echo '<input type="hidden" class="profile-doc-id" id="profile-doc-id" name="profile-doc-id" value="' . esc_attr( $user_document_id ).'"/>';
                                }
                            }
    
                        } else {
                            echo '<img src="http://place-hold.it/100x100" width="100" height="100" alt="profile image">';
                        }
                        ?>
                    </div>
                    <a href="<?= $verification_link; ?>">Setup Now >></a>
                </div>
    
            </div>
        </div>
        </div>
    <?php
    } else { ?>

<form autocomplete="off" id="submit_experience_form" name="new_post" method="post" action="#" enctype="multipart/form-data" class="add-frontend-property">
                                
    <?php
    if ($layout_order) {
        foreach ($layout_order as $key=>$value) {
            switch($key) {
                case 'price_terms':
                    get_template_part('template-parts/dashboard/submit-experience/price-terms');
                    break;

                case 'information':
                    get_template_part('template-parts/dashboard/submit-experience/information');
                break;

                case 'what_provided':
                    get_template_part('template-parts/dashboard/submit-experience/what-is-provided');
                break;

                case 'pricing':
                    get_template_part('template-parts/dashboard/submit-experience/pricing');
                break;

                case 'time':
                    get_template_part('template-parts/dashboard/submit-experience/time');
                break;

                case 'media':
                    get_template_part('template-parts/dashboard/submit-experience/media');
                break;

                case 'features':
                    get_template_part('template-parts/dashboard/submit-experience/features');
                break;

                case 'location':
                    get_template_part('template-parts/dashboard/submit-experience/location');
                break;

                case 'services':
                    get_template_part('template-parts/dashboard/submit-experience/services');
                break;

                case 'term_rules':
                    get_template_part('template-parts/dashboard/submit-experience/terms');
                break;
            }
        }
    }
    ?>

    <div class="steps-nav">
        <button type="button" class="btn btn-grey-outlined btn-step-back btn-xs-full-width action"><?php echo esc_attr($homey_local['back_btn']); ?></button>

        <button id="save_as_draft_exp" type="button" class="btn btn-grey-outlined btn-xs-full-width"><?php esc_html_e('Save as Draft', 'homey'); ?></button>
        
        <button type="button" class="btn btn-success btn-step-next btn-xs-full-width action"><?php echo esc_attr($homey_local['continue_btn']); ?></button>
        <button type="submit" class="btn btn-success btn-step-submit btn-xs-full-width action"><?php echo esc_attr($homey_local['submit_btn']); ?></button>
    </div><!-- steps-nav -->

    <?php wp_nonce_field('submit_experience', 'homey_add_experience_nonce'); ?>

    <input type="hidden" name="experience_featured" value="0"/>
    <input type="hidden" name="booking_type" value="<?php echo esc_attr($homey_booking_type); ?>"/>
    <input type="hidden" name="action" value="homey_add_experience"/>

</form><!-- #add-property-form -->

<?php } ?>
<?php
} else {
        ?>

<form autocomplete="off" id="submit_experience_form" name="new_post" method="post" action="#" enctype="multipart/form-data" class="add-frontend-property">
                                
                                <?php
                                if ($layout_order) {
                                    foreach ($layout_order as $key=>$value) {
                                        switch($key) {
                                            case 'price_terms':
                                                get_template_part('template-parts/dashboard/submit-experience/price-terms');
                                                break;
                            
                                            case 'information':
                                                get_template_part('template-parts/dashboard/submit-experience/information');
                                            break;
                            
                                            case 'what_provided':
                                                get_template_part('template-parts/dashboard/submit-experience/what-is-provided');
                                            break;
                            
                                            case 'pricing':
                                                get_template_part('template-parts/dashboard/submit-experience/pricing');
                                            break;
                            
                                            case 'time':
                                                get_template_part('template-parts/dashboard/submit-experience/time');
                                            break;
                            
                                            case 'media':
                                                get_template_part('template-parts/dashboard/submit-experience/media');
                                            break;
                            
                                            case 'features':
                                                get_template_part('template-parts/dashboard/submit-experience/features');
                                            break;
                            
                                            case 'location':
                                                get_template_part('template-parts/dashboard/submit-experience/location');
                                            break;
                            
                                            case 'services':
                                                get_template_part('template-parts/dashboard/submit-experience/services');
                                            break;
                            
                                            case 'term_rules':
                                                get_template_part('template-parts/dashboard/submit-experience/terms');
                                            break;
                                        }
                                    }
                                }
                                ?>
                            
                                <div class="steps-nav">
                                    <button type="button" class="btn btn-grey-outlined btn-step-back btn-xs-full-width action"><?php echo esc_attr($homey_local['back_btn']); ?></button>
                            
                                    <button id="save_as_draft_exp" type="button" class="btn btn-grey-outlined btn-xs-full-width"><?php esc_html_e('Save as Draft', 'homey'); ?></button>
                                    
                                    <button type="button" class="btn btn-success btn-step-next btn-xs-full-width action"><?php echo esc_attr($homey_local['continue_btn']); ?></button>
                                    <button type="submit" class="btn btn-success btn-step-submit btn-xs-full-width action"><?php echo esc_attr($homey_local['submit_btn']); ?></button>
                                </div><!-- steps-nav -->
                            
                                <?php wp_nonce_field('submit_experience', 'homey_add_experience_nonce'); ?>
                            
                                <input type="hidden" name="experience_featured" value="0"/>
                                <input type="hidden" name="booking_type" value="<?php echo esc_attr($homey_booking_type); ?>"/>
                                <input type="hidden" name="action" value="homey_add_experience"/>
                            
                            </form><!-- #add-property-form -->

                            <?php    
}
?>