<?php 
/**
 * Init Styles & scripts
 *
 * @return void
 */
function dhat_public_styles_scripts() {
    wp_enqueue_style( 'myplugin-public-style', DHAT_PLUGIN_URL . 'public/css/public.css', '', rand());
    wp_enqueue_style( 'myplugin-bs-style', DHAT_PLUGIN_URL . 'public/css/bs.css', '', rand());
    wp_enqueue_style( 'myplugin-w3-style', DHAT_PLUGIN_URL . 'admin/css/w3.css', '', rand());
    wp_enqueue_style('myplugin-fa-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_script('dapi-gmaps-js', DHAT_PLUGIN_URL . 'public/js/dapi-gmaps.js', array( 'jquery' ), rand());
}
add_action( 'wp_enqueue_scripts', 'dhat_public_styles_scripts');


// function isGoogleMapsLoaded() {
//     return wp_script_is('google-maps-api', 'done');
// }

// function enqueue_google_maps_api() {
//     if (!isGoogleMapsLoaded()) {
//         // Replace 'YOUR_GOOGLE_MAPS_API_KEY' with your actual API key
//         $api_key = '';

//         // Enqueue Google Maps API with your API key
//         wp_enqueue_script('google-maps-api', "https://maps.googleapis.com/maps/api/js?key=$api_key", array(), null, false);
//     }
// }
// add_action('wp_enqueue_scripts', 'enqueue_google_maps_api');