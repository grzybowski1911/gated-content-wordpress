<?php

function gated_admin_styles( $hook ) {
    wp_register_style('gated-admin-style', WPPLUGIN_URL . 'admin/css/admin.css', [] );

    //var_dump($hook);
    
    if (strpos($hook, 'gated_plugin')) {
        wp_enqueue_style('gated-admin-style'); 
    }
}

add_action('admin_enqueue_scripts', 'gated_admin_styles');

function gated_frontend_styles() {
    wp_register_style('gated-frontend-style', WPPLUGIN_URL . 'frontend/css/style.css', [] );
    // adding script to single posts and pages 
    if ( is_single() || is_page() ) {
        wp_enqueue_style('gated-frontend-style');
    }
}

add_action('wp_enqueue_scripts', 'gated_frontend_styles', 100);