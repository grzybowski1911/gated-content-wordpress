<?php 

/* 
 * Plugin Name:       Gated Content
 * Plugin URI:        bgrzdesigns.com/gated-content
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ben Grzybowski
 * Author URI:        bgrzdesigns.com/about
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gated-content
 * Domain Path:       /languages
*/


// if accessed directly abort 

if ( ! defined('WPINC')) {
    die;
}

function gated_content_menu_settings() {

    //examples of other functions that will place menu items in different locations in the dashboard menu
    //add_pages_page() <- adds item under pages dropdown
    //add_options_page() <- adds item under settings dropdown
    //add_users_page() <- adds item under user dropdown
    //add_menu_page() <- adds item under menu dropdown, use for higher level plugins that need dedicated menu space

    add_menu_page (
        __('Gated Content', 'gated_plugin'),
        __('Gated Content', 'gated_plugin'),
        'manage_options',
        'gated_plugin_home',
        'gated_content_markup',
        'dashicons-shield-alt',
        100
    );
    add_submenu_page (
        'gated_plugin_home',
        __('Gated Content Sub Page', 'gated_plugin'),
        __('Sub Page', 'gated_plugin'),
        'manage_options',
        'gated_content_sub_page',
        'sub_page_markup'
    );
}

//hook to add item to admin menu
add_action('admin_menu', 'gated_content_menu_settings');

function gated_content_markup () {
    if ( !current_user_can ('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( get_admin_page_title()); ?></h1>
    </div>
    <?php
}

function sub_page_markup() {
    if ( !current_user_can ('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( get_admin_page_title()); ?></h1>
    </div>
    <?php
}

// add link to the settings for plugin in plugins menu list

function gated_content_settings_link ( $links ) {
    $settings_link = '<a href="admin.php?page=gated_plugin_home">' . __('Settings','gated_plugin') . '</a>';
    // incoming link variable contains deactivate plugin options, array_push settings option to that 
    array_push($links, $settings_link );
    return($links);
}

$filter_name = "plugin_action_links_" . plugin_basename(__FILE__);
add_filter($filter_name, 'gated_content_settings_link');