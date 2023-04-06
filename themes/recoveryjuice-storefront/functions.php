<?php
/* add_action( 'wp_enqueue_scripts', 'recovery_juice_theme_enqueue_styles');

function recovery_juice_theme_enqueue_styles() {	
   wp_enqueue_style( 'recoveryjuice-child-style', get_stylesheet_directory_uri().'/style.css');
} */

/**
 * Load child theme structure
 */
$theme_dir = get_theme_file_path();
require $theme_dir . '/inc/storefront-woocommerce-template-functions.php'; 
require $theme_dir . '/inc/storefront-template-functions.php'; 

function remove_storefront_default_actions() {
	remove_action( 'storefront_header' , 'storefront_secondary_navigation' , 30 );
    remove_action( 'storefront_header' , 'storefront_header_container' , 0 );
    remove_action( 'storefront_header' , 'storefront_header_container_close' , 41 );
    remove_action( 'storefront_page', 'storefront_page_header', 10 );
    add_action( 'storefront_before_content', 'storefront_page_header', 8 );
}
add_action( 'init', 'remove_storefront_default_actions' );

?>

<?php

// Change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_bucket_single' );
function woocommerce_add_to_bucket_single() {
    return __( 'Add To Bucket', 'woocommerce' );
}

// Change add to cart text on product archives page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_bucket_archives' );
function woocommerce_add_to_bucket_archives() {
    return __( 'Add To Bucket', 'woocommerce' );
}

//removing breadcrumb
add_action( 'storefront_before_content', 'recovery_juice_remove_storefront_breadcrumbs_checkout', 1 );
function recovery_juice_remove_storefront_breadcrumbs_checkout() {
   if ( is_checkout() || is_cart() || is_account_page()) {
      remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );
   }
}

//removing shop page title
add_filter( 'woocommerce_show_page_title', 'recovery_juice_hide_shop_page_title' );
 function recovery_juice_hide_shop_page_title( $title ) {
   if ( is_shop() || is_archive()) $title = false;
   return $title;
}


//Removing default sorting and result count on shop/archive pages
add_action( 'init', 'recovery_juice_remove_default_sorting_storefront' );
function recovery_juice_remove_default_sorting_storefront() {
   remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
}

add_action( 'after_setup_theme', function() {
  remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
   remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
   remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );
} );


?>
