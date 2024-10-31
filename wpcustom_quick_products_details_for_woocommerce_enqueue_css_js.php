<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
//wpcustom_quick_products_details_for_woocommerce_enqueue_css_js.php
function qdpdh_wcvow_enqueue_frontend_styles() {
    // Enqueue Frontend Styles
    if (file_exists(plugin_dir_path(__FILE__) . 'assets/css/frontend_style_css.css')) {
        wp_enqueue_style('qdpdh-wcvow_frontend_style', plugins_url('assets/css/frontend_style_css.css', __FILE__));
    }

    // Enqueue Frontend Scripts with jQuery dependency
    if (file_exists(plugin_dir_path(__FILE__) . 'assets/js/frontend_javascript.js')) {
        wp_enqueue_script('qdpdh-frontendajax-custom-js', plugins_url('assets/js/frontend_javascript.js', __FILE__), array('jquery'), wp_get_theme()->get('Version'), true);
    }
}

add_action('wp_enqueue_scripts', 'qdpdh_wcvow_enqueue_frontend_styles', PHP_INT_MAX);

function qdpdh_wcvow_enqueue_admin_scripts() {
   
    if (file_exists(plugin_dir_path(__FILE__) . 'assets/js/admin_javascript.js')) {
        wp_register_script('qdpdh_wcvow_admin_custom-js', plugins_url('assets/js/admin_javascript.js', __FILE__), array('jquery'), wp_get_theme()->get('Version'), true);
        wp_enqueue_script('wcvow_admin_custom-js');
    }


    if (file_exists(plugin_dir_path(__FILE__) . 'assets/css/admin_style_css.css')) {
        wp_enqueue_style('qdpdh_wcvow_admin_style_css', plugins_url('assets/css/admin_style_css.css', __FILE__));
    }
}

add_action('admin_enqueue_scripts', 'qdpdh_wcvow_enqueue_admin_scripts');