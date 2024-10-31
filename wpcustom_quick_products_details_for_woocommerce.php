<?php
/**
 * Plugin Name: Quick Products Details For WooCommerce
 * Plugin URI: https://wpcustom.ca/
 * Description: Quick Products Details For WooCommerce
 * Author: Wpcustom.ca
 * Author URI: https://wpcustom.ca/author_url
 * GitHub Plugin https://wpcustom.ca/git_hub
 * Domain Path: /languages/
 * Version: 1.0.0
 * License: GPL v2 or later
 * Stable tag: 1.0.0
 * License URI: https://wpcustom.ca/license
 * Tags: Quick products, Details Quick View ,Hover Effect , Product Details
 * @package Quick products Details for WooCommerce
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class wpcustom_quick_products_details_for_woocommerce {

    const VERSION = '1.0.0';
    const TEXT_DOMAIN = 'quick-products-details-for-woocommerce'; // Change this to your actual text domain

    /**
     * Constructor to initialize the plugin.
     */
    public function __construct() {
        // Check if WooCommerce is active
        if ($this->is_woocommerce_active()) {
            $this->setup_actions();
        } else {
            // Display notice if WooCommerce is not active
            add_action('admin_notices', array($this, 'woocommerce_not_active_notice'));

            // Deactivate the plugin
            add_action('admin_init', array($this, 'deactivate_plugin'));
        }
    }

    /**
     * Setup actions and hooks for the plugin.
     */
    private function setup_actions() {
        // Register activation, deactivation, and uninstall hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall')); // Use __CLASS__ for static method

        // Include additional files
        $this->include_additional_files();
    }

    /**
     * Include additional files required by the plugin.
     */
    private function include_additional_files() {
        require_once(dirname(__FILE__) . "/wpcustom_quick_products_details_for_woocommerce_setting_page.php");
        require_once(dirname(__FILE__) . "/wpcustom_quick_products_details_for_woocommerce_functions.php");
        //require_once(dirname(__FILE__) . "/wpcustom_visual_opinion_weaver_for_woocommerce_ajax.php");
    }

    /**
     * Activation hook callback - used for setting up the plugin on activation.
     */
    public function activate() {
        global $wpdb;

        // Define table name and charset collate
        $table_name = $wpdb->prefix . "wpcustom_quick_pro_details_silder";
        $charset_collate = $wpdb->get_charset_collate();

        // SQL query for creating the database table
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            pro_id mediumint(9) NOT NULL,
            pro_value VARCHAR(255) NOT NULL,
            s_status VARCHAR(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        // Include necessary upgrade script
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Execute the database query
        dbDelta($sql);

        $array_to_store = array(
        'price_checkbox' => 1,
        'product_name_checkbox' => 1,
        'product_description_checkbox' => 1,
        'short_description_checkbox' => 1,
        'sku_checkbox' => 1,
        'product_type_checkbox' => 1,
        'add_to_cart_button' => 1
        );

        update_option('quick_products_details_checkbox_values', $array_to_store);

    }

    /**
     * Deactivation hook callback - used for actions on deactivation.
     */
    public function deactivate() {
        // Deactivation code goes here
    }

    /**
     * Uninstall hook callback - used for actions on uninstallation.
     */
    public static function uninstall() {
        // Uninstall code goes here
    }

    /**
     * Check if WooCommerce is active.
     *
     * @return bool Whether WooCommerce is active.
     */
    private function is_woocommerce_active() {
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
    }

    /**
     * Display a notice if WooCommerce is not active.
     */
    public function woocommerce_not_active_notice() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php esc_html_e('Quick products Details for WooCommerce requires WooCommerce to be active. Please activate WooCommerce.', 'quick-products-details-for-woocommerce'); ?></p>
        </div>
        <?php
    }

    /**
     * Deactivate the plugin and display a notice.
     */
    public function deactivate_plugin() {
        deactivate_plugins(plugin_basename(__FILE__));
        add_action('admin_notices', array($this, 'plugin_deactivated_notice'));
    }

    /**
     * Display a notice after the plugin is deactivated.
     */
    public function plugin_deactivated_notice() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php esc_html_e('Quick products Details for WooCommerce has been deactivated because WooCommerce is not active.','quick-products-details-for-woocommerce'); ?></p>
        </div>
        <?php
    }
}

// Initialize the Seat Reservation plugin
new wpcustom_quick_products_details_for_woocommerce();
