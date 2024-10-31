<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
function qdpdh_display_custom_button() {
    
    global $product;
    $custom_action_url = 'Products Details';
    echo '<a href="' . esc_url($custom_action_url) . '" class="custom-button">Products Details</a>';
}

add_action('woocommerce_after_shop_loop_item', 'qdpdh_display_custom_button', 15);

function qdpdh_custom_post_types_quick_display() {

    $labels = array(
        'name'                  => _x( 'Quick Display Products Details Hover', 'Post Type General Name', 'quick-products-details-for-woocommerce' ),
        'singular_name'         => _x( 'Quick Display Products Details Hover', 'Post Type Singular Name', 'quick-products-details-for-woocommerce' ),
        'menu_name'             => __( 'Quick Display Products Details Hover', 'quick-products-details-for-woocommerce' ),
        'name_admin_bar'        => __( 'Quick Display Products Details Hover', 'quick-products-details-for-woocommerce' ),
        'archives'              => __( 'Item Archives', 'quick-products-details-for-woocommerce' ),
        'attributes'            => __( 'Item Attributes', 'quick-products-details-for-woocommerce' ),
        'parent_item_colon'     => __( 'Parent Item:', 'quick-products-details-for-woocommerce' ),
        'all_items'             => __( 'Quick Display Products Details Hover', 'quick-products-details-for-woocommerce' ),
        'add_new_item'          => __( 'Add New Item', 'quick-products-details-for-woocommerce' ),
        'add_new'               => __( 'Add New', 'quick-products-details-for-woocommerce' ),
        'new_item'              => __( 'New Item', 'quick-products-details-for-woocommerce' ),
        'edit_item'             =>  false,
        'update_item'           => false,
        'view_item'             => false,
        'view_items'            => false,
        'search_items'          => false,
        'not_found'             => __( 'Not found', 'quick-products-details-for-woocommerce' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'quick-products-details-for-woocommerce' ),
        'featured_image'        => __( 'Featured Image', 'quick-products-details-for-woocommerce' ),
        'set_featured_image'    => __( 'Set featured image', 'quick-products-details-for-woocommerce' ),
        'remove_featured_image' => __( 'Remove featured image', 'quick-products-details-for-woocommerce' ),
        'use_featured_image'    => __( 'Use as featured image', 'quick-products-details-for-woocommerce' ),
        'insert_into_item'      => __( 'Insert into item', 'quick-products-details-for-woocommerce' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'quick-products-details-for-woocommerce' ),
        'items_list'            => __( 'Items list', 'quick-products-details-for-woocommerce' ),
        'items_list_navigation' => __( 'Items list navigation', 'quick-products-details-for-woocommerce' ),
        'filter_items_list'     => __( 'Filter items list', 'quick-products-details-for-woocommerce' ),
    );
    $args = array(
        'label'                 => __( 'Quick Display Products Details Hover', 'quick-products-details-for-woocommerce' ),
        'description'           => __( 'Quick Display Products Details Hover', 'quick-products-details-for-woocommerce' ),
        'labels'                => $labels,
        'supports'              => array( 'title'),
        //'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => 'woocommerce',
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-post', // You can use a custom icon or dashicons (WordPress icons).
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type( 'cptqpdh', $args );

}
add_action( 'init', 'qdpdh_custom_post_types_quick_display', 0 );

// Modify columns
// Customize default columns
function qdpdh_custom_columns_head($defaults) {
    // Change the default title column name
    $defaults['title'] = 'Products Title';

    $defaults['shortcode'] = 'Shortcodes';

    return $defaults;
}
add_filter('manage_cptqpdh_posts_columns', 'qdpdh_custom_columns_head');

function qdpdh_custom_columns_content($column_name, $post_id) {

    if ($column_name === 'shortcode') {
        echo '[qdpdh_cptqpdh_shortcode post_id="' . esc_attr($post_id) . '"]';
    }
   
}
add_action('manage_cptqpdh_posts_custom_column', 'qdpdh_custom_columns_content', 10, 2);

function qdpdh_custom_columns_for_cptqpdh($columns) {
    
    unset($columns['date']);
    $columns['title'];
    unset($columns['cb']);
    $columns['date'] = 'Date';

    return $columns;
}

add_filter('manage_cptqpdh_posts_columns', 'qdpdh_custom_columns_for_cptqpdh');

function qdpdh_custom_product_meta_box() {
    add_meta_box(
        'qdpdh_custom_product_meta_box',
        __('Quick Display Products Details Hover', 'quick-products-details-for-woocommerce'), // Update text domain here
        'qdpdh_render_custom_product_meta_box',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'qdpdh_custom_product_meta_box');

function qdpdh_render_custom_product_meta_box($post) {
$product_id = $post->ID;

global $wpdb;
$table_name = $wpdb->prefix . 'posts'; // Adjust table prefix if necessary

$custom_posts = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE post_type = %s",
        'cptqpdh'
    )
);

wp_nonce_field('custom_product_meta_nonce', 'custom_product_meta_nonce');
?>
<select name="quick_display_products_details_hover_select">
    <option value="0">None</option>
    <?php
    if ($custom_posts) {
        foreach ($custom_posts as $custom_post) {
            $custom_post_title = $custom_post->post_title;
            $custom_post_id    = $custom_post->ID;
            ?>
            <option value="<?php echo esc_attr($custom_post_id); ?>"><?php echo esc_html(ucwords($custom_post_title)); ?></option>
            <?php
        }
    }
    ?>
</select>
<?php
}


function qdpdh_save_custom_product_meta($post_id) {
    
   if ( ! isset( $_POST['custom_product_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_product_meta_nonce'] ) ), 'custom_product_meta_nonce' ) ) {

        return $post_id;
    }


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

   
    if (empty($_POST['post_type']) || 'product' != $_POST['post_type']) {
        return $post_id;
    }

    
    $selected_value = sanitize_text_field($_POST['quick_display_products_details_hover_select']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpcustom_quick_pro_details_silder';

    $data = array(
        'pro_id'  => $selected_value,
        'pro_value' => $post_id,
        's_status' => '1',
    );

    $wpdb->insert( $table_name, $data );
}

add_action('save_post', 'qdpdh_save_custom_product_meta');

add_action('wp_trash_post', 'qdpdh_delete_data_on_trash');

function qdpdh_delete_data_on_trash($post_id) {
  
    $post_type = get_post_type($post_id);
    if ($post_type === 'cptqpdh') {
        global $wpdb;
        $custom_table_name = $wpdb->prefix . 'wpcustom_quick_pro_details_silder';
        $custom_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$custom_table_name} WHERE pro_id = %d", $post_id));

        if ($custom_data) {
            $wpdb->delete($custom_table_name, array('pro_id' => $post_id), array('%d'));
        }
    }
}

add_action( 'edit_form_after_editor', 'qdpdh_display_custom_table_after_editor' );

function qdpdh_display_custom_table_after_editor() {
    global $post, $wpdb;

    if ($post->post_type == 'cptqpdh') {
        $post_id = $post->ID;
        $table_name = $wpdb->prefix . 'wpcustom_quick_pro_details_silder';
        $results = $wpdb->get_results($wpdb->prepare("SELECT pro_id, pro_value FROM {$table_name} WHERE pro_id = %d", $post_id), ARRAY_A);

        $products = array_map('wc_get_product', wp_list_pluck($results, 'pro_value'));
        ?>
        <table class="wp-list-table widefat fixed striped table-view-list pages">
            <h1>Products List</h1>
            <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Action</th>
            </tr>
            <?php
            $key = 1;
            foreach ($products as $product) {
                if ($product) {
                    ?>
                    <tr data-pro-id="<?php echo esc_attr($results[$key - 1]['pro_id']); ?>" data-pro-value="<?php echo esc_attr($product->get_id()); ?>">
                        <td><?php echo esc_html($key); ?></td>
                        <td><?php echo esc_html(ucwords($product->get_name())); ?></td>
                        <td><button class="delete-button"  id="delete_button_qpduh">Delete</button></td>
                    </tr>
                    <?php
                    $key++;
                }
            }
            ?>
        </table>

        <script>
            jQuery(document).ready(function ($) {
               $('.delete-button').on('click', function (event) {
        event.preventDefault(); // Prevent default button behavior (page reload)

        var row = $(this).closest('tr');
        var proId = row.data('pro-id');
        var proValue = row.data('pro-value');
        var data = {
            'action': 'delete_product_entry',
            'pro_value': proValue,
            'proId': proId,
            'security': '<?php echo esc_attr(wp_create_nonce("delete_product_entry")); ?>'
        };
        $.post(ajaxurl, data, function (response) {
            if (response.success) {
                row.remove();
            } else {
                console.log('Error: ' + response.data);
            }
        });
    });
            });
        </script>
        <?php
    }
}

add_action('wp_ajax_delete_product_entry', 'qdpdh_delete_product_entry_callback');

function qdpdh_delete_product_entry_callback() {
    check_ajax_referer('delete_product_entry', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission Denied');
    }

    global $wpdb;

    // Get the current post ID
    

    // Sanitize and unslash the pro_value
    $pro_value = isset($_POST['pro_value']) ? sanitize_text_field($_POST['pro_value']) : '';
    $proId = isset($_POST['proId']) ? sanitize_text_field($_POST['proId']) : '';

//proId
    if ($pro_value) {
        $table_name = $wpdb->prefix . 'wpcustom_quick_pro_details_silder';
        
        // Escape the pro_value
        $result = $wpdb->delete(
            $table_name,
            array(
                'pro_value' => $pro_value,
                'pro_id' => $proId  // Include the post ID in the delete query
            ),
            array('%s', '%d') // Data types of pro_value and pro_id
        );
        
        if ($result !== false) {
            wp_send_json_success('Product entry deleted successfully');
        } else {
            wp_send_json_error('Failed to delete product entry');
        }
    } else {
        wp_send_json_error('Invalid product value');
    }
}

