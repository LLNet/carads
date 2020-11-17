<?php
function cptui_register_my_cpts_bil() {

    /**
     * Post Type: Biler.
     */

    $labels = [
        "name" => __( "Biler", "car-ads" ),
        "singular_name" => __( "Bil", "car-ads" ),
        "menu_name" => __( "Biler", "car-ads" ),
        "all_items" => __( "Alle Biler", "car-ads" ),
        "add_new" => __( "Tilføj bil", "car-ads" ),
        "add_new_item" => __( "Tilføj ny bil", "car-ads" ),
        "edit_item" => __( "Rediger bil", "car-ads" ),
        "new_item" => __( "Ny bil", "car-ads" ),
        "view_item" => __( "Vis bil", "car-ads" ),
        "view_items" => __( "Vis biler", "car-ads" ),
        "search_items" => __( "Søg biler", "car-ads" ),
        "not_found" => __( "Ingen biler fundet", "car-ads" ),
        "not_found_in_trash" => __( "Ingen biler fundet i papirkurven", "car-ads" ),
        "parent" => __( "Forældre bil", "car-ads" ),
        "featured_image" => __( "Udvalgt billede til denne bil", "car-ads" ),
        "set_featured_image" => __( "Indstil udvalgt billede til denne bil", "car-ads" ),
        "remove_featured_image" => __( "Fjern udvalgt billede til denne bil", "car-ads" ),
        "use_featured_image" => __( "Brug som udvalgt billede til denne bil", "car-ads" ),
        "archives" => __( "Bil arkiv", "car-ads" ),
        "insert_into_item" => __( "Indsæt til bil", "car-ads" ),
        "uploaded_to_this_item" => __( "Upload til bilen", "car-ads" ),
        "filter_items_list" => __( "Filtrer bil", "car-ads" ),
        "items_list_navigation" => __( "Bil liste navigation", "car-ads" ),
        "items_list" => __( "Biler", "car-ads" ),
        "attributes" => __( "Bilers egenskaber", "car-ads" ),
        "name_admin_bar" => __( "Bil", "car-ads" ),
        "item_published" => __( "Bil udgivet", "car-ads" ),
        "item_published_privately" => __( "Bil udgivet privat", "car-ads" ),
        "item_reverted_to_draft" => __( "Bil omdannet til kladde", "car-ads" ),
        "item_scheduled" => __( "Bil planlagt", "car-ads" ),
        "item_updated" => __( "Bil opdateret", "car-ads" ),
        "parent_item_colon" => __( "Forældre bil", "car-ads" ),
    ];

    $args = [
        "label" => __( "Biler", "car-ads" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => get_option('car-ads')['archive_slug'] ?? "biler",
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => [ "slug" => get_option('car-ads')['single_slug'] ?? "bil", "with_front" => true ],
        "query_var" => true,
        "menu_icon" => "dashicons-car",
        "supports" => [ "title" ],
    ];

    register_post_type( "bil", $args );
}

add_action( 'init', 'cptui_register_my_cpts_bil' );


function cptui_register_my_taxes_car_brand() {

    /**
     * Taxonomy: Brands.
     */

    $labels = [
        "name" => __( "Brands", "car-ads" ),
        "singular_name" => __( "Brand", "car-ads" ),
    ];

    $args = [
        "label" => __( "Brands", "car-ads" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'brand', 'with_front' => true, ],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "car_brand",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy( "car_brand", [ "bil" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_car_brand' );

function cptui_register_my_taxes_car_model() {

    /**
     * Taxonomy: Modeller.
     */

    $labels = [
        "name" => __( "Modeller", "car-ads" ),
        "singular_name" => __( "Model", "car-ads" ),
    ];

    $args = [
        "label" => __( "Modeller", "car-ads" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'car_model', 'with_front' => true, ],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "car_model",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy( "car_model", [ "bil" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_car_model' );

