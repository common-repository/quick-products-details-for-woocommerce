<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1">Settings</label>
  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2">Customization</label>
  <!-- Tab 3 -->
<!-- <input type="radio" name="tabset" id="tab3" aria-controls="dunkles">
  <label for="tab3">Template Design</label> -->
  
  <div class="tab-panels">


    <section id="marzen" class="tab-panel">
             <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('submit_quick_products_details_form', 'quick_products_details_nonce'); ?>
    <input type="hidden" name="action" value="save_quick_products_details">
    <h3>Which label do you not want to show to your users?</h3>
    <table>
        <tr>
            <td><label for="price_checkbox">Price</label></td>
            <td><input type="checkbox" id="price_checkbox" name="price_checkbox" <?php checked(1, $checkbox_values['price_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="product_name_checkbox">Product Name</label></td>
            <td><input type="checkbox" id="product_name_checkbox" name="product_name_checkbox" <?php checked(1, $checkbox_values['product_name_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="product_description_checkbox">Products Description</label></td>
            <td><input type="checkbox" id="product_description_checkbox" name="product_description_checkbox" <?php checked(1, $checkbox_values['product_description_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="short_description_checkbox">Products Short Description</label></td>
            <td><input type="checkbox" id="short_description_checkbox" name="short_description_checkbox" <?php checked(1, $checkbox_values['short_description_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="sku_checkbox">Sku</label></td>
            <td><input type="checkbox" id="sku_checkbox" name="sku_checkbox" <?php checked(1, $checkbox_values['sku_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="product_type_checkbox">Product Type</label></td>
            <td><input type="checkbox" id="product_type_checkbox" name="product_type_checkbox" <?php checked(1, $checkbox_values['product_type_checkbox']); ?>></td>
        </tr>
        <tr>
            <td><label for="add_to_cart_button">Add To Cart</label></td>
            <td><input type="checkbox" id="add_to_cart_button" name="add_to_cart_button" <?php checked(1, $checkbox_values['add_to_cart_button']); ?>></td>
        </tr>
    </table>
    <input style="margin-top: 10px;" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','quick-products-details-for-woocommerce'); ?>">
</form>
  	</section>

    <section id="rauchbier" class="tab-panel">
      <h2>Customization </h2>
     <!--  <p></p> -->

 <?php
// Check if the form is submitted
if ( isset( $_POST['save_and_change'] ) ) {
    // Verify nonce
   if ( isset( $_POST['wp_verify_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wp_verify_nonce'] ) ), 'customization_settings_nonce' ) ) {
 
        $add_cart_button_title = wp_unslash( sanitize_text_field( $_POST['add_cart_button_title'] ) );
        $products_list_title = wp_unslash( sanitize_text_field( $_POST['products_list_title'] ) );

        // Create an array with form data
        $form_data = array(
            'add_cart_button_title' => $add_cart_button_title,
            'products_list_title' => $products_list_title
        );

        // Update options in wp_options table
        update_option( 'quick_products_details_for_woocommerce', $form_data );

        // Redirect after saving
        wp_redirect( admin_url( 'admin.php?page=quick-products-details-for-woocommerce&status=success' ) );
        exit;
    } else {
        // Nonce verification failed, handle accordingly (e.g., show an error message)
        echo 'Nonce verification failed.';
        exit;
    }
}
?>

<form action="<?php echo esc_url( admin_url( 'admin.php?page=quick-products-details-for-woocommerce' ) ); ?>" method="post">
    <?php wp_nonce_field( 'customization_settings_nonce', 'wp_verify_nonce' ); ?>

    <div style="margin-top: 10px;">
        <label for="add_cart_button_title">Add To Cart Button Title</label>
        <input type="text" name="add_cart_button_title" id="add_cart_button_title" value="<?php echo isset( get_option( 'quick_products_details_for_woocommerce')['add_cart_button_title'] ) ? esc_attr( get_option( 'quick_products_details_for_woocommerce')['add_cart_button_title'] ) : ''; ?>">
    </div>

    <div style="margin-top: 10px;">
        <label for="products_list_title">Products List Title</label>
        <input type="text" name="products_list_title" id="products_list_title" value="<?php echo isset( get_option( 'quick_products_details_for_woocommerce')['products_list_title'] ) ? esc_attr( get_option( 'quick_products_details_for_woocommerce')['products_list_title'] ) : ''; ?>">
    </div>

    <div>
        <input type="submit" name="save_and_change" class="button-primary" value="<?php esc_attr_e('Save Changes','quick-products-details-for-woocommerce'); ?>">
    </div>
</form>



    </section>


<!-- <section id="dunkles" class="tab-panel">
      <h2>Template Design</h2>
      <p></p>
</section> -->


  </div>
  
</div>