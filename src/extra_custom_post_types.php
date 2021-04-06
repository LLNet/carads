<?php
if (get_option('car-ads-cpt')) {
    if (get_option('car-ads-cpt')['cpt_medarbejdere'] == "active") {
        function cptui_register_my_cpts_medarbejder()
        {

            /**
             * Post Type: Medarbejdere.
             */

            $labels = [
                "name"                     => __("Medarbejdere", "indexed"),
                "singular_name"            => __("Medarbejder", "indexed"),
                "menu_name"                => __("Medarbejdere", "indexed"),
                "all_items"                => __("All Medarbejdere", "indexed"),
                "add_new"                  => __("Add new", "indexed"),
                "add_new_item"             => __("Add new Medarbejder", "indexed"),
                "edit_item"                => __("Edit Medarbejder", "indexed"),
                "new_item"                 => __("New Medarbejder", "indexed"),
                "view_item"                => __("View Medarbejder", "indexed"),
                "view_items"               => __("View Medarbejdere", "indexed"),
                "search_items"             => __("Search Medarbejdere", "indexed"),
                "not_found"                => __("No Medarbejdere found", "indexed"),
                "not_found_in_trash"       => __("No Medarbejdere found in trash", "indexed"),
                "parent"                   => __("Parent Medarbejder:", "indexed"),
                "featured_image"           => __("Featured image for this Medarbejder", "indexed"),
                "set_featured_image"       => __("Set featured image for this Medarbejder", "indexed"),
                "remove_featured_image"    => __("Remove featured image for this Medarbejder", "indexed"),
                "use_featured_image"       => __("Use as featured image for this Medarbejder", "indexed"),
                "archives"                 => __("Medarbejder archives", "indexed"),
                "insert_into_item"         => __("Insert into Medarbejder", "indexed"),
                "uploaded_to_this_item"    => __("Upload to this Medarbejder", "indexed"),
                "filter_items_list"        => __("Filter Medarbejdere list", "indexed"),
                "items_list_navigation"    => __("Medarbejdere list navigation", "indexed"),
                "items_list"               => __("Medarbejdere list", "indexed"),
                "attributes"               => __("Medarbejdere attributes", "indexed"),
                "name_admin_bar"           => __("Medarbejder", "indexed"),
                "item_published"           => __("Medarbejder published", "indexed"),
                "item_published_privately" => __("Medarbejder published privately.", "indexed"),
                "item_reverted_to_draft"   => __("Medarbejder reverted to draft.", "indexed"),
                "item_scheduled"           => __("Medarbejder scheduled", "indexed"),
                "item_updated"             => __("Medarbejder updated.", "indexed"),
                "parent_item_colon"        => __("Parent Medarbejder:", "indexed"),
            ];

            $args = [
                "label"                 => __("Medarbejdere", "indexed"),
                "labels"                => $labels,
                "description"           => "",
                "public"                => true,
                "publicly_queryable"    => true,
                "show_ui"               => true,
                "show_in_rest"          => true,
                "rest_base"             => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "has_archive"           => false,
                "show_in_menu"          => true,
                "show_in_nav_menus"     => true,
                "delete_with_user"      => false,
                "exclude_from_search"   => false,
                "capability_type"       => "post",
                "map_meta_cap"          => true,
                "hierarchical"          => false,
                "rewrite"               => ["slug" => "medarbejder", "with_front" => true],
                "query_var"             => true,
                "supports"              => ["title", "editor", "thumbnail", "custom-fields"],
            ];

            register_post_type("medarbejder", $args);
        }

        add_action('init', 'cptui_register_my_cpts_medarbejder');


        if (function_exists('acf_add_local_field_group')):

            acf_add_local_field_group(array(
                'key'                   => 'group_5fd891adbfa40',
                'title'                 => 'Medarbejder info',
                'fields'                => array(
                    array(
                        'key'               => 'field_5fd891e1cec02',
                        'label'             => 'Stilling',
                        'name'              => 'stilling',
                        'type'              => 'text',
                        'instructions'      => 'Angiv medarbejderens stillingsbetegnelse',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'wrapper'           => array(
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ),
                        'default_value'     => '',
                        'placeholder'       => '',
                        'prepend'           => '',
                        'append'            => '',
                        'maxlength'         => '',
                    ),
                    array(
                        'key'               => 'field_6038ccdca59aa',
                        'label'             => 'E-mail',
                        'name'              => 'e-mail',
                        'type'              => 'text',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'wrapper'           => array(
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ),
                        'default_value'     => '',
                        'placeholder'       => '',
                        'prepend'           => '',
                        'append'            => '',
                        'maxlength'         => '',
                    ),
                    array(
                        'key'               => 'field_6038cce4a59ab',
                        'label'             => 'Telefon',
                        'name'              => 'telefon',
                        'type'              => 'text',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'wrapper'           => array(
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ),
                        'default_value'     => '',
                        'placeholder'       => '',
                        'prepend'           => '',
                        'append'            => '',
                        'maxlength'         => '',
                    ),
                ),
                'location'              => array(
                    array(
                        array(
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'medarbejder',
                        ),
                    ),
                ),
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'description'           => '',
            ));

        endif;


    }


    if (get_option('car-ads-cpt')['cpt_tilbud'] == "active") {
        function cptui_register_my_cpts_tilbud()
        {

            /**
             * Post Type: Aktuelle tilbud.
             */

            $labels = [
                "name"                     => __("Aktuelle tilbud", "indexed"),
                "singular_name"            => __("Aktuelle tilbud", "indexed"),
                "menu_name"                => __("Aktuelle tilbud", "indexed"),
                "all_items"                => __("All Aktuelle tilbud", "indexed"),
                "add_new"                  => __("Add new", "indexed"),
                "add_new_item"             => __("Add new Aktuelle tilbud", "indexed"),
                "edit_item"                => __("Edit Aktuelle tilbud", "indexed"),
                "new_item"                 => __("New Aktuelle tilbud", "indexed"),
                "view_item"                => __("View Aktuelle tilbud", "indexed"),
                "view_items"               => __("View Aktuelle tilbud", "indexed"),
                "search_items"             => __("Search Aktuelle tilbud", "indexed"),
                "not_found"                => __("No Aktuelle tilbud found", "indexed"),
                "not_found_in_trash"       => __("No Aktuelle tilbud found in trash", "indexed"),
                "parent"                   => __("Parent Aktuelle tilbud:", "indexed"),
                "featured_image"           => __("Featured image for this Aktuelle tilbud", "indexed"),
                "set_featured_image"       => __("Set featured image for this Aktuelle tilbud", "indexed"),
                "remove_featured_image"    => __("Remove featured image for this Aktuelle tilbud", "indexed"),
                "use_featured_image"       => __("Use as featured image for this Aktuelle tilbud", "indexed"),
                "archives"                 => __("Aktuelle tilbud archives", "indexed"),
                "insert_into_item"         => __("Insert into Aktuelle tilbud", "indexed"),
                "uploaded_to_this_item"    => __("Upload to this Aktuelle tilbud", "indexed"),
                "filter_items_list"        => __("Filter Aktuelle tilbud list", "indexed"),
                "items_list_navigation"    => __("Aktuelle tilbud list navigation", "indexed"),
                "items_list"               => __("Aktuelle tilbud list", "indexed"),
                "attributes"               => __("Aktuelle tilbud attributes", "indexed"),
                "name_admin_bar"           => __("Aktuelle tilbud", "indexed"),
                "item_published"           => __("Aktuelle tilbud published", "indexed"),
                "item_published_privately" => __("Aktuelle tilbud published privately.", "indexed"),
                "item_reverted_to_draft"   => __("Aktuelle tilbud reverted to draft.", "indexed"),
                "item_scheduled"           => __("Aktuelle tilbud scheduled", "indexed"),
                "item_updated"             => __("Aktuelle tilbud updated.", "indexed"),
                "parent_item_colon"        => __("Parent Aktuelle tilbud:", "indexed"),
            ];

            $args = [
                "label"                 => __("Aktuelle tilbud", "indexed"),
                "labels"                => $labels,
                "description"           => "",
                "public"                => true,
                "publicly_queryable"    => true,
                "show_ui"               => true,
                "show_in_rest"          => true,
                "rest_base"             => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "has_archive"           => false,
                "show_in_menu"          => true,
                "show_in_nav_menus"     => true,
                "delete_with_user"      => false,
                "exclude_from_search"   => false,
                "capability_type"       => "post",
                "map_meta_cap"          => true,
                "hierarchical"          => false,
                "rewrite"               => ["slug" => "tilbud", "with_front" => true],
                "query_var"             => true,
                "supports"              => ["title", "editor", "thumbnail", "custom-fields"],
            ];

            register_post_type("tilbud", $args);
        }

        add_action('init', 'cptui_register_my_cpts_tilbud');

        if (function_exists('acf_add_local_field_group')):

            acf_add_local_field_group(array(
                'key'                   => 'group_5fd897b3d665e',
                'title'                 => 'Aktuelle tilbud info',
                'fields'                => array(
                    array(
                        'key'               => 'field_5fd897d281fd3',
                        'label'             => 'Pris',
                        'name'              => 'pris',
                        'type'              => 'text',
                        'instructions'      => 'Angiv pris. Eks. Pris fra XXX kr./md.',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'wrapper'           => array(
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ),
                        'default_value'     => '',
                        'placeholder'       => '',
                        'prepend'           => '',
                        'append'            => '',
                        'maxlength'         => '',
                    ),
                ),
                'location'              => array(
                    array(
                        array(
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'tilbud',
                        ),
                    ),
                ),
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'description'           => '',
                'modified'              => 1608549381,
            ));

        endif;

    }

}