<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function qdpdh_cptqpdh_shortcode_function($atts) {
    $checkbox_values = get_option('quick_products_details_checkbox_values', array());
    if($checkbox_values !== false && !empty($checkbox_values)) {
        $price_checkbox = $checkbox_values['price_checkbox'];
        $product_name_checkbox = $checkbox_values['product_name_checkbox'];
        $product_description_checkbox = $checkbox_values['product_description_checkbox'];
        $short_description_checkbox = $checkbox_values['short_description_checkbox'];
        $sku_checkbox = $checkbox_values['sku_checkbox'];
        $product_type_checkbox = $checkbox_values['product_type_checkbox']; 
        $add_to_cart_button = $checkbox_values['add_to_cart_button']; 
    }
    else{
        $price_checkbox = 1;
        $product_name_checkbox = 1;
        $product_description_checkbox = 1;
        $short_description_checkbox = 1;
        $sku_checkbox = 1;
        $product_type_checkbox = 1;
        $add_to_cart_button = 1; 
    }
  


    global $wpdb;
    $table_name = $wpdb->prefix . 'wpcustom_quick_pro_details_silder';
    $atts = shortcode_atts(
        array(
            'post_id' => get_the_ID(), // Default to the current post ID
        ),
        $atts,
        'qdpdh_cptqpdh_shortcode'
    );

    // Get post ID from the attribute or set a default value
    $post_id = empty($atts['post_id']) ? '' : absint($atts['post_id']);

    // Check if the provided post ID is valid
    if ($post_id && get_post_type($post_id) === 'cptqpdh') {
        $post = get_post($post_id);
        if ($post) {
            ob_start();
echo '<h2>' . esc_html(ucwords($post->post_title)) . '</h2>';
$option_value = get_option('quick_products_details_for_woocommerce');

if($option_value !== false && !empty($option_value)) {
    $add_cart_button_title = $option_value['add_cart_button_title'];
    $products_list_title = $option_value['products_list_title'];
   
} else {
    $add_cart_button_title ='Add To Cart';
    $products_list_title ='Products List';
}
?>
<div class="<?php echo esc_attr(ucwords($post->post_title)); ?>">
<div class="main_div_con">
    <img src="" id="main_img_con" class="main_img_con">
<div style="margin-left: 10px;">

    <?php
        if($price_checkbox == 1){
    ?>
    <div>
        <strong>Price:</strong>
        <span id="price_div">---</span>
    </div>
    <?php
    }
    ?>

    <?php
        if($product_name_checkbox == 1){
    ?>
    <div>
        <strong>Product Name:</strong>
        <span id="name_div">---</span>
    </div>
    <?php
    }
    ?>


    <?php
        if($product_description_checkbox == 1){
    ?>
    <div>
        <strong>Products Description: </strong>
        <span id="description_strong"></span>
    </div>
    <?php
    }
    ?>

    <?php
        if($short_description_checkbox == 1){
    ?>
     <div>
        <strong>Products Short Description: </strong>
        <span id="short_description_strong"></span>
    </div>
    <?php
    }
    ?>

    <?php
        if($sku_checkbox == 1){
    ?>
    <div>
        <strong>Sku: </strong>
        <span id="sku_strong"></span>
    </div>
    <?php
    }
    ?>

    <?php
        if($product_type_checkbox == 1){
    ?>
    <div>
        <strong>Product Type: </strong>
        <span id="product_type"></span>
    </div>
    <?php
    }
    ?>

    </div> 
</div>

<div><strong> <?php echo esc_html(ucwords($products_list_title));?> </strong></div>
<hr style="margin-bottom: 15px;">
<?php

$condition = "pro_id = %d";
$sql = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE $condition", $post->ID );

    $result = $wpdb->get_results( $sql );
    $pro_values_array = array();
    if ( $result ) {
        foreach ( $result as $row ) {
            // Access the data
            $pro_value = $row->pro_value;
            $pro_values_array[] = $pro_value;
        }

// Remove duplicate product IDs
$product_ids = array_unique($pro_values_array);

// Get products
$products = wc_get_products(array('include' => $product_ids));

// Loop through the products
foreach ($products as $key => $product) {
    // Access product information
    $product_id = $product->get_id();
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
    $product_description = $product->get_description();
    $product_description = wp_trim_words( $product_description, 70, '...' );
    $product_description_short = $product->get_short_description(); 
    $product_description_short = wp_trim_words( $product_description_short, 50, '...' );
    $product_sku = $product->get_sku();
    $product_type = $product->get_type(); 

    if(empty($image[0])){
        $plugin_uri = plugins_url('/', __FILE__);
        $image = $plugin_uri.'assets/images/logo_image_not_ava.jpg';
        
    }
    else{
        $image = $image[0];
    }

    $home_url = home_url().'/product/'.$product_name;

?>

<button 
class="bbhover"
id="<?php echo esc_attr(ucwords($product_id));?>" 
product_name="<?php echo esc_attr(ucwords($product_name));?>" 
product_price="<?php echo esc_attr(ucwords($product_price));?>" 
img="<?php echo esc_attr($image);?>"
description="<?php echo esc_attr(ucwords($product_description));?>" 
product_description_short="<?php echo esc_attr(ucwords($product_description_short));?>"
product_sku="<?php echo esc_attr(ucwords($product_sku));?>" 
product_type="<?php echo esc_attr(ucwords($product_type));?>" 
url="<?php echo esc_attr($home_url);?>" 
>
<img src="<?php echo esc_attr($image);?>" style="width: 100px; height: 100px; object-fit: cover;">
<?php
if($add_to_cart_button == 1){
    echo '<div style="margin-top: 10px;"></div>';
    echo '<a href="'.esc_url($home_url).'" style="color:#000; text-decoration: none;">'.esc_html(ucwords($add_cart_button_title)).'</a>';
}
?>
</button>
<?php
}
?>
<button 
class="starting_bbhover"
id="<?php echo esc_attr(ucwords($product_id));?>" 
product_name="<?php echo esc_attr(ucwords($product_name));?>" 
product_price="<?php echo esc_attr(ucwords($product_price));?>" 
img="<?php echo esc_attr($image);?>"
description="<?php echo esc_attr(ucwords($product_description));?>" 
product_description_short="<?php echo esc_attr(ucwords($product_description_short));?>"
product_sku="<?php echo esc_attr(ucwords($product_sku));?>"
product_type="<?php echo esc_attr(ucwords($product_type));?>"
url="<?php echo esc_attr($home_url);?>" 
>
<?php echo esc_html(ucwords($product_name));?>
</button>
</div>
<?php
} else {
    echo "No data found.";
}

            $content = ob_get_clean();
            return $content;
        } else {
            // Invalid or no post ID provided
            return esc_html('Invalid or missing post ID.');
        }
    } else {
        // Invalid or no post ID provided
        return esc_html('Invalid or missing post ID or incorrect post type.');
    }
}

// Register the shortcode with a dynamic name based on the custom post type
add_shortcode('qdpdh_cptqpdh_shortcode', 'qdpdh_cptqpdh_shortcode_function');

?>