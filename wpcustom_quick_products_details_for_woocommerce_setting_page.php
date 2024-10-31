<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Main function to initialize the plugin
function qdpdh_wpcustom_quick_products_details_for_woocommerce_init() {
    add_action('admin_menu', 'wpcustom_quick_products_details_for_woocommerce_create_menu');
    add_action('admin_post_save_quick_products_details', 'save_quick_products_details_data');
}

// Function to create the admin menu under WooCommerce
function wpcustom_quick_products_details_for_woocommerce_create_menu() {
    add_submenu_page(
        'woocommerce',
        'Quick products Details Settings',
        'Quick products Details Settings',
        'administrator',
        'quick-products-details-for-woocommerce',
        'wpcustom_quick_products_details_for_woocommerce_settings_page'
    );
}

// Function to render the settings page
function wpcustom_quick_products_details_for_woocommerce_settings_page() {
    // Retrieve values from the database
    $checkbox_values = get_option('quick_products_details_checkbox_values', array());

    ?>
<div class="wrap">
        <h2><?php echo esc_html__('Quickly Display Product Details Using Hover Settings', 'quick-products-details-for-woocommerce'); ?></h2>
        <hr>
<?php
require 'wpcustom_admin_dashboard_tabs.php';
?>
</div>
<?php
}

// Function to handle form submission
function save_quick_products_details_data() {
    // Check if the nonce is valid
   if ( ! isset( $_POST['quick_products_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quick_products_details_nonce'] ) ), 'submit_quick_products_details_form' ) ) {
    wp_die( 'Security check' );
}


    // Initialize an array to store checkbox values
    $checkbox_values = array();

    // Check if each checkbox is checked, if yes, add to the array
    $checkboxes = array(
        'price_checkbox',
        'product_name_checkbox',
        'product_description_checkbox',
        'short_description_checkbox',
        'sku_checkbox',
        'product_type_checkbox',
        'add_to_cart_button'
    );

    foreach ($checkboxes as $checkbox) {
        $checkbox_values[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
    }

    // Update the option with the array of checkbox values
    update_option('quick_products_details_checkbox_values', $checkbox_values);

    // Redirect after handling the form data
    wp_redirect(admin_url('admin.php?page=quick-products-details-for-woocommerce'));
    exit;
}

// Initialize the plugin
qdpdh_wpcustom_quick_products_details_for_woocommerce_init();
