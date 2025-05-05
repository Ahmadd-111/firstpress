<?php
/**
 * Plugin Name: IP Location Info
 * Description: Displays detailed IP location information using a shortcode [ip_location_info ip="x.x.x.x"].
 * Version: 1.1
 * Author: Ahmad
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Shortcode to display IP location information.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output with location data or an error message.
 */
function ip_location_info_shortcode( $atts ) {
    // Set default IP value.
    $atts = shortcode_atts(
        array(
            'ip' => '',
        ),
        $atts,
        'ip_location_info'
    );

    $ip = sanitize_text_field( $atts['ip'] );

    // If no IP is provided, display a warning message.
    if ( empty( $ip ) ) {
        return '<div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <div style="background-color: #f8d7da; padding: 20px; border-radius: 10px; border: 1px solid #f5c6cb; width: 80%; max-width: 600px;">
                        <strong style="color: #721c24;">⚠️ No IP address provided in the shortcode.</strong>
                    </div>
                </div>';
    }

    // Make the API request to ip-api.com.
    $response = wp_remote_get( "http://ip-api.com/json/{$ip}?fields=66846719" );

    if ( is_wp_error( $response ) ) {
        return 'Unable to retrieve location.';
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    // Check if API response is successful.
    if ( ! empty( $data ) && isset( $data['status'] ) && $data['status'] === 'success' ) {
        ob_start(); // Start output buffering.

        // Display the IP location info in a styled container.
        echo '<div style="background:#f9f9f9;padding:20px;border:1px solid #ccc;border-radius:10px;font-family:Arial,sans-serif;">';
        echo '<h2>IP Location Info</h2>';

        echo "<strong>Provided IP:</strong> " . esc_html( $data['query'] ) . "<br>";

        // Display IP Info.
        echo '<h3>IP Info</h3><ul>';
        echo '<li><strong>IP:</strong> ' . esc_html( $data['query'] ) . '</li>';
        echo '<li><strong>ASN:</strong> ' . esc_html( $data['as'] ) . '</li>';
        echo '<li><strong>AS Name:</strong> ' . esc_html( $data['asname'] ) . '</li>';
        echo '<li><strong>ISP:</strong> ' . esc_html( $data['isp'] ) . '</li>';
        echo '<li><strong>Organization:</strong> ' . esc_html( $data['org'] ) . '</li>';
        echo '<li><strong>Status:</strong> ' . esc_html( $data['status'] ) . '</li>';
        echo '</ul>';

        // Display Location Info.
        echo '<h3>Location</h3><ul>';
        echo '<li><strong>City:</strong> ' . esc_html( $data['city'] ) . '</li>';
        echo '<li><strong>Region Name:</strong> ' . esc_html( $data['regionName'] ) . '</li>';
        echo '<li><strong>Region :</strong> ' . esc_html( $data['region'] ) . '</li>';
        echo '<li><strong>Country:</strong> ' . esc_html( $data['country'] ) . '</li>';
        echo '<li><strong>Country Code:</strong> ' . esc_html( $data['countryCode'] ) . '</li>';
        echo '<li><strong>Continent:</strong> ' . esc_html( $data['continent'] ) . '</li>';
        echo '<li><strong>Continent Code:</strong> ' . esc_html( $data['continentCode'] ) . '</li>';
        echo '<li><strong>Postal Code:</strong> ' . esc_html( $data['zip'] ) . '</li>';
        echo '<li><strong>Timezone:</strong> ' . esc_html( $data['timezone'] ) . '</li>';
        echo '<li><strong>Latitude:</strong> ' . esc_html( $data['lat'] ) . '</li>';
        echo '<li><strong>Longitude:</strong> ' . esc_html( $data['lon'] ) . '</li>';
        echo '</ul>';

        // Display Other Details.
        echo '<h3>Other Details</h3><ul>';
        echo '<li><strong>Mobile:</strong> ' . ( isset( $data['mobile'] ) && $data['mobile'] ? 'Yes' : 'No' ) . '</li>';
        echo '<li><strong>Proxy:</strong> ' . ( isset( $data['proxy'] ) && $data['proxy'] ? 'Yes' : 'No' ) . '</li>';
        echo '<li><strong>Hosting:</strong> ' . ( isset( $data['hosting'] ) && $data['hosting'] ? 'Yes' : 'No' ) . '</li>';
        echo '<li><strong>Currency:</strong> ' . esc_html( $data['currency'] ) . '</li>';
        echo '<li><strong>Offset:</strong> ' . esc_html( $data['offset'] ) . '</li>';
        echo '</ul>';

        echo '</div>';

        return ob_get_clean(); // Return the buffered output.
    } else {
        return '⚠️ Location data not found.';
    }
}

add_shortcode( 'ip_location_info', 'ip_location_info_shortcode' );