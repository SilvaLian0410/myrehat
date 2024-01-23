<?php
/**
 * Plugin rewrite functions.
 *
 * @package    Houzez
 * @subpackage houzez theme functionality
 * @author     Waqas Riaz <waqas@favethemes.com>
 * @copyright  Copyright (c) 2016, Waqas Riaz
 * @link       http://favethemes.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the property rewrite slug used for single projects.
 *
 * @since  1.2.0
 * @access public
 * @return string
 */

function homey_get_listing_rewrite_slug() {
	$slug = homey_get_listing_rewrite_base();

	return apply_filters( 'homey_get_listing_rewrite_slug', $slug );
}

function homey_get_listing_type_rewrite_slug() {
	$slug = homey_get_listing_type_rewrite_base();

	return apply_filters( 'homey_get_listing_type_rewrite_slug', $slug );
}

function homey_get_room_type_rewrite_slug() {
	$slug = homey_get_room_type_rewrite_base();

	return apply_filters( 'homey_get_room_type_rewrite_slug', $slug );
}

function homey_get_amenity_rewrite_slug() {
	$slug = homey_get_amenity_rewrite_base();

	return apply_filters( 'homey_get_amenity_rewrite_slug', $slug );
}

function homey_get_facility_rewrite_slug() {
	$slug = homey_get_facility_rewrite_base();

	return apply_filters( 'homey_get_facility_rewrite_slug', $slug );
}

function homey_get_country_rewrite_slug() {
	$slug = homey_get_country_rewrite_base();

	return apply_filters( 'homey_get_country_rewrite_slug', $slug );
}

function homey_get_state_rewrite_slug() {
	$slug = homey_get_state_rewrite_base();

	return apply_filters( 'homey_get_state_rewrite_slug', $slug );
}

function homey_get_city_rewrite_slug() {
	$slug = homey_get_city_rewrite_base();

	return apply_filters( 'homey_get_city_rewrite_slug', $slug );
}

function homey_get_area_rewrite_slug() {
	$slug = homey_get_area_rewrite_base();

	return apply_filters( 'homey_get_area_rewrite_slug', $slug );
}

// experiences  rewrite slugs

function homey_get_experience_rewrite_slug() {
    $slug = homey_get_experience_rewrite_base();

    return apply_filters( 'homey_get_experience_rewrite_slug', $slug );
}

function homey_get_experience_type_rewrite_slug() {
    $slug = homey_get_experience_type_rewrite_base();

    return apply_filters( 'homey_get_experience_type_rewrite_slug', $slug );
}

function homey_get_experience_language_rewrite_slug() {
    $slug = homey_get_experience_language_rewrite_base();

    return apply_filters( 'homey_get_experience_language_rewrite_base', $slug );
}

function homey_get_what_bring_item_type_rewrite_slug() {
    $slug = homey_get_experience_what_bring_item_type_rewrite_base();

    return apply_filters( 'homey_get_experience_what_bring_item_type_rewrite_base', $slug );
}

function homey_get_what_provided_item_type_rewrite_slug() {
    $slug = homey_get_experience_what_provided_item_type_rewrite_base();

    return apply_filters( 'homey_get_experience_what_provided_item_type_rewrite_slug', $slug );
}

function homey_get_experience_amenity_rewrite_slug() {
    $slug = homey_get_experience_amenity_rewrite_base();

    return apply_filters( 'homey_get_experience_amenity_rewrite_slug', $slug );
}

function homey_get_experience_facility_rewrite_slug() {
    $slug = homey_get_experience_facility_rewrite_base();

    return apply_filters( 'homey_get_experience_facility_rewrite_slug', $slug );
}

function homey_get_experience_country_rewrite_slug() {
    $slug = homey_get_experience_country_rewrite_base();

    return apply_filters( 'homey_get_experience_country_rewrite_slug', $slug );
}

function homey_get_experience_state_rewrite_slug() {
    $slug = homey_get_experience_state_rewrite_base();

    return apply_filters( 'homey_get_experience_state_rewrite_slug', $slug );
}

function homey_get_experience_city_rewrite_slug() {
    $slug = homey_get_experience_city_rewrite_base();

    return apply_filters( 'homey_get_experience_city_rewrite_slug', $slug );
}

function homey_get_experience_area_rewrite_slug() {
    $slug = homey_get_experience_area_rewrite_base();

    return apply_filters( 'homey_get_experience_area_rewrite_slug', $slug );
}


