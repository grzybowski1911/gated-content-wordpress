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
// constant for url path of plugin 

define ('WPPLUGIN_URL', plugin_dir_url(__FILE__));

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
        'gated_plugin_sub_page',
        'sub_page_markup'
    );
}

//hook to add item to admin menu
add_action('admin_menu', 'gated_content_menu_settings');

// Settings fields 

function gated_plugin_settings() {
    // if no settings then create them 
    if(!get_option('gated_plugin_option')) {
        add_option('gated_plugin_option');
    }
    //adding settings field
    add_settings_field(
        'gated_plugin_custom_text',
        __('Custom Text', 'gated_plugin'),
        'gated_plugin_custom_text_callback',
        'gated_plugin_home',
        'gated_plugin_section'
    );
    // register setting
    register_setting(
        'gated_plugin_section',
        'gated_plugin_section'
    );
    // add the setting section
    add_settings_section(
        'gated_plugin_section',
        __('The First Option','gated_plugin'),
        'gated_plugin_setting_callback',
        'gated_plugin_home'
    );
}

add_action('admin_init', 'gated_plugin_settings');

function gated_plugin_custom_text_callback() {

    $option = get_option('gated_plugin_option');
    $custom_text = '';
    if (isset($option)){
        $custom_text = esc_html($option['gated_plugin_option']);
    };

    echo '<input type="text" id="gated_plugin_custom_text" name="gated_plugin_[custom_text]" value="'. $custom_text . '">';
}

function gated_plugin_setting_callback() {
    esc_html_e('Things and Stuff', 'gated_plugin');
}

// add to the DB 

function gated_plugin_options() {

    $options = [];
    $options['name'] = 'Ben';
    $options['location'] = 'Portland, OR';
    $options['job'] = 'The Boss';

    add_option('gated_plugin_option', 'Gated Plugin Options');
    //update_option('gated_plugin_option', 'fucl');

    //$new_thing = 'the end of the world';
    //add_option('gated_plugin_option_2', 'Gated Plugin Options 2');
    //update_option('gated_plugin_option_2', $new_thing);
}

add_action('admin_init', 'gated_plugin_options');

// main settings page mark up 

function gated_content_markup () {
    if ( !current_user_can ('manage_options')) {
        return;
    }
    //$options = get_option('gated_plugin_option');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( get_admin_page_title()); ?></h1>
        <form method="posy" action="options.php">
            <?php settings_fields('gated_plugin_settings'); ?>
            <?php do_settings_sections('gated_plugin_home');?>
            <?php submit_button(); ?>
        </form> 
    </div>
    <?php
}

// sub page mark up

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

// accessing file paths 

$gated_plugin_basename = plugin_basename(__FILE__);
$gated_plugin_dir_path = plugin_dir_path(__FILE__);
$gated_plugins_url_default = plugins_url();
$gated_plugins_url_inc = plugins_url('includes', __FILE__);
$gated_plugin_dir_url = plugin_dir_url(__FILE__);

// include enqueue files

include($gated_plugin_dir_path .'includes/styles.php');

include($gated_plugin_dir_path .'includes/scripts.php');

// footer admin page for shits n gigs 

function footer_change() {
    $option_test = esc_html(get_option('gated_plugin_option_2'));
    //echo '<p style="position:absolute;bottom:0;">'. $option_test .'</p>';
    return $option_test;
}

add_filter('admin_footer_text', 'footer_change');

