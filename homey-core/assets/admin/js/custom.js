( function( $ ) {
    'use strict';

    $( function() {

        $('.homey-clone').cloneya();

        if(typeof $('input[name="taxonomy"]') != 'undefined'){
            if( $('input[name="taxonomy"]').val() == 'listing_amenity' || $('input[name="taxonomy"]').val() == 'listing_facility') {
                $("#description-description").text('You can put your icon class here.');
            }
        }

        $( '.homey-fbuilder-js-on-change' ).change( function() {
            var field_type = $( this ).val();
            $('.homey-clone').cloneya();

            if(field_type == 'select') {
                $.post( ajaxurl, { action: 'homey_load_select_options', type: field_type }, function( response ) {
                    $( '.homey_select_options_loader_js' ).html( response );
                    $('.homey-clone').cloneya();
                } );
            } else {
                $( '.homey_select_options_loader_js' ).html('');
            }
        } );

        $(document).on('click', '.admin_verify_user_code_manually', function () { //// verify user code manaully
            let initiator = $(this),
                data = {
                    'action': 'homey_verify_user_manually',
                    'user_id': initiator.data('userId'),
                    'hash': initiator.data('hash')
                };
            $.ajax({
                url: ajaxurl,
                method : "POST",
                data: data,
                beforeSend: function (xhr) {
                    initiator.text('...');
                },
                success: function (response) {
                    initiator.text('Verified');
                },
                error: function (response) {
                    initiator.text('Something wrong! Try again.');
                }
            });
        });// verify user code manaully

        //cancel the subscription stripe
        $(document).on('click', '.cancel_subscriptions_of_user', function () { //// verify user code manaully
            let initiator = $(this),
                data = {
                    'action': 'cancel_subscriptions_of_user',
                    'user_id': initiator.data('userId'),
                    'subscriptionId': initiator.data('subscriptionId'),
                    'hash': initiator.data('hash')
                };
            $.ajax({
                url: ajaxurl,
                method : "POST",
                data: data,
                beforeSend: function (xhr) {
                    initiator.text('...');
                },
                success: function (response) {
                    initiator.text('Subscription Updated.');
                },
                error: function (response) {
                    initiator.text('Something wrong! Try again.');
                }
            });
        });//end of cancel the subscription stripe

    } );
} )( jQuery );