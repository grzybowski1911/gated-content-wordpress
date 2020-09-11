<?php 

function gated_admin_js( $hook ) {
    wp_register_script('gated_admin_js', WPPLUGIN_URL . 'admin/js/admin.js', []);

    // add variable to script that access like an API 
    wp_localize_script('gated_admin_js','gated_plugin_backend', [
        'page_slug' => $hook
    ] );

    // adding script to any admin page that has gated_plugin in slug
    if (strpos($hook, 'gated_plugin')) {
        wp_enqueue_script('gated_admin_js'); 
    }
}

add_action('admin_enqueue_scripts', 'gated_admin_js');

function gated_front_js() {
    wp_enqueue_script('gated_front_js', WPPLUGIN_URL . 'frontend/js/front.js');
}

add_action('wp_enqueue_scripts', 'gated_front_js');