<?php 
/**
 * Init Styles & scripts
 *
 * @return void
 */
function dhat_admin_styles_scripts() {
    wp_enqueue_style( 'myplugin-admin-style', DHAT_PLUGIN_URL . 'admin/css/admin.css', '', rand());    
    wp_enqueue_style( 'myplugin-adminw3-style', DHAT_PLUGIN_URL . 'admin/css/w3.css', '', rand());

    wp_enqueue_style( 'myplugin-colorpicker-css', DHAT_PLUGIN_URL . 'admin/colorpicker/css/colorpicker.css', '', rand());


    wp_enqueue_script( 'myplugin-colorpicker-js', DHAT_PLUGIN_URL . 'admin/colorpicker/js/colorpicker.js', array('jquery'), rand(), true );

    wp_enqueue_script( 'myplugin-colorpicker-eye', DHAT_PLUGIN_URL . 'admin/colorpicker/js/eye.js', array('jquery'), rand(), true );

    wp_enqueue_script( 'myplugin-colorpicker-utils', DHAT_PLUGIN_URL . 'admin/colorpicker/js/utils.js', array('jquery'), rand(), true );
    
    wp_enqueue_script( 'myplugin-admin-script', DHAT_PLUGIN_URL . 'admin/js/admin.js', array('jquery'), rand(), true );
}
add_action( 'admin_enqueue_scripts', 'dhat_admin_styles_scripts' );