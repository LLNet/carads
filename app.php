<?php
/*************************
 * Plugin Name: PLUGIN_TITLE
 * Description: PLUGIN_DESCRIPTION
 * Version: PLUGIN_VERSIONING
 * Author: CarAds.io
 * Author URI: https://carads.io
 * Text Domain: PLUGIN_NAME
 *************************/

require __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://plugins.indexed.dk/json/car-app.json',
    __FILE__,
    'car-app'
);

if (!class_exists('CarAdsApp')) {

    class CarAdsApp
    {

        private $post_type = "bil";
        protected static $instance = null;
        public $archive_slug;
        public $single_slug;

        public function __construct()
        {

            define('__CAR_ADS_DIR__', WP_PLUGIN_DIR . "/car-app/");

            // Vendor autoload
            require __DIR__ . '/vendor/autoload.php';

            // Settings
            require __DIR__ . '/src/classes/class.settings-api.php';
            require __DIR__ . '/src/classes/class.settings.php';

            // Custom Post Type
            require __DIR__ . '/src/cpt.php';
            require __DIR__ . '/src/shortcode/header-search.php';
            require __DIR__ . '/src/extra_custom_post_types.php';

            // Importer
            require __DIR__ . '/src/classes/class.connector.php';

            // Scripts
            add_action('wp_enqueue_scripts', [$this, 'add_styles_and_scripts']);

            // Activation
            register_activation_hook(__FILE__, [$this, 'plugin_activate']);

            // Filters
            add_filter('single_template', [$this, 'single_car_template']);
            add_filter('archive_template', [$this, 'car_archive_template']);

            // Register Activation / Deactivation
            register_deactivation_hook(__FILE__, [$this, 'cronstarter_deactivate']);
            register_activation_hook(__FILE__, [$this, 'cronstarter_activation']);
//            add_action('wp', [$this, 'cronstarter_activation']);

            // Rewrite rules
            add_action('init', [$this, 'carads_rewrite_rules']);
            add_filter('generate_rewrite_rules', [$this, 'resources_cpt_generating_rule']);
            add_action('init', function () {
                flush_rewrite_rules();
            });

            // Change links from backend taxonomy overview
            add_filter('term_link', [$this, 'carads_term_link_filter'], 10, 3);

            // Set default slugs
            if (!empty(get_option('car-ads')['archive_slug'])) {
                $this->archive_slug = get_option('car-ads')['archive_slug'];
            } else {
                $this->archive_slug = "biler";
            }
            if (!empty(get_option('car-ads')['single_slug'])) {
                $this->single_slug = get_option('car-ads')['single_slug'];
            } else {
                $this->single_slug = "bil";
            }

            // Include elementor modules if elementor is installed and active
            if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {

                require __DIR__ . '/elementor/custom_widgets.php';
            }

            // Load optional translations
            load_plugin_textdomain('car-ads');
//            add_action('widgets_init', [$this, 'carads_widgets_areas']);

            // Add meta tags to head
            add_action('wp_head', [$this, 'meta_tags']);

            // Registrer sidebar widget areas
            add_action('widgets_init', [$this, 'register_sidebar_widget_areas']);

        }

        public function register_sidebar_widget_areas()
        {
            register_sidebar(array(
                'name'          => 'Bilkort Sidebar #1',
                'description'   => 'Området lige efter Quick Details',
                'id'            => 'carads-single-sidebar-1',
                'before_widget' => '<div class="ca-w-full ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">',
                'after_widget'  => '</div>',
                'before_title'  => '<p class="ca-title-font ca-font-medium ca-text-2xl ca-mb-3">',
                'after_title'   => '</p>',
            ));
            register_sidebar(array(
                'name'          => 'Bilkort Sidebar #2',
                'description'   => 'Området lige efter Santander',
                'id'            => 'carads-single-sidebar-2',
                'before_widget' => '<div class="ca-w-full ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">',
                'after_widget'  => '</div>',
                'before_title'  => '<p class="ca-title-font ca-font-medium ca-text-2xl ca-mb-3">',
                'after_title'   => '</p>',
            ));
            register_sidebar(array(
                'name'          => 'Bilkort Sidebar #3',
                'id'            => 'carads-single-sidebar-3',
                'description'   => 'Området lige efter Find leasing beregner og før kontaktformular',
                'before_widget' => '<div class="ca-w-full ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">',
                'after_widget'  => '</div>',
                'before_title'  => '<p class="ca-title-font ca-font-medium ca-text-2xl ca-mb-3">',
                'after_title'   => '</p>',
            ));
        }

        public function meta_tags()
        {
            if (is_single(get_the_ID()) && get_post_type(get_the_ID()) == "bil") {
                ?>
                <meta name="robots" content="noindex"/>
                <link rel="dns-prefetch" href="https://api.carads.io">
                <link rel="preconnect" href="https://api.carads.io">
                <?php
            }
        }

        public function carads_widgets_areas()
        {

            /*
            register_sidebar(array(
                'name'          => 'Under Billiste',
                'id'            => 'carads_below_archive',
                'before_widget' => '<div class="pr-0 md:pr-20 lg:pr-8 text-left mb-16 md:mb-0 text-base">',
                'after_widget'  => '</div>',
                'before_title'  => '<h1 class="title-font font-light text-text text-2xl mb-8 pr-4">',
                'after_title'   => '</h1>',
            ));
            */

        }


        public function cronstarter_deactivate()
        {
            $timestamp = wp_next_scheduled('car-ads');
            wp_unschedule_event($timestamp, 'car-ads');
        }

        public function cronstarter_activation()
        {
            if (!wp_next_scheduled('car-ads')) {
                wp_schedule_event(time(), 'hourly', 'car-ads');
            }
        }

        public function plugin_activate()
        {

            /**
             * Set default options for slugs if nothing has been set yet!
             * @FIX Find en anden metode til at tjekke om disse er gemt.
             */
//            if (!get_option('car-ads')) {
//                update_option('car-ads', [
//                    'single_slug'  => 'bil',
//                    'archive_slug' => 'brugte-biler'
//                ]);
//            }
//            if (!get_option('car-ads-single-car')) {
//                update_option('car-ads-single-car', [
//                    'show_back_to_archive' => 'no',
//                ]);
//            }
//            if (!get_option('car-ads-archive')) {
//                update_option('car-ads-archive', [
//                    'includeDisabled'      => 'yes',
//                    'includeDisabledSince' => '7',
//                    'showLocation'         => 'yes',
//                ]);
//            }
//            if (!get_option('car-ads-cpt')) {
//                update_option('car-ads-cpt', [
//                    'cpt_medarbejdere' => 'inactive',
//                    'cpt_tilbud'       => 'inactive',
//                ]);
//            }

        }

        /**
         * Adding styles and scripts to frontend
         */
        public function add_styles_and_scripts()
        {
            wp_enqueue_style('car-slick', "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css", '', '');
            wp_enqueue_script('car-slick', "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", array('jquery'), '', true);


            if (is_single(get_the_ID()) && get_post_type(get_the_ID()) == "bil") {
                wp_enqueue_style('car-santander', "//api.scb.nu/SCBDK.Dealer.ExternalCalc/v2/Content/scbdk.dealer.externalcalc.css", '', '');
                wp_enqueue_script('car-santander', "//api.scb.nu/SCBDK.Dealer.ExternalCalc/v2/Scripts/scbdk.dealer.externalcalc.js", array('jquery'), '', true);
                wp_enqueue_script('car-popper', "//cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js", array('jquery'), '', true);
                wp_enqueue_style('car-slick', "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css", '', '');
                wp_enqueue_script('car-slick', "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", array('jquery'), '', true);
                wp_enqueue_script('car-alpinejs', "//cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.0/alpine.js", '', '', false);
                wp_enqueue_style('car-lightbox2', plugin_dir_url(__FILE__) . "assets/css/vendor/lightbox.min.css", '', '');
                wp_enqueue_script('car-lightbox2', plugin_dir_url(__FILE__) . "assets/js/vendor/lightbox.js", array('jquery'), '', true);
            }

            if (is_post_type_archive('bil')) {
                wp_enqueue_style('car-slider', "//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css", '', '');
                wp_enqueue_script('car-slider', "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js", array('jquery'), '', false);
                wp_enqueue_style('car-multiselect', "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css", '', '');
                wp_enqueue_script('car-multiselect', "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js", array('jquery'), '', true);
            }

            wp_enqueue_style('car', plugin_dir_url(__FILE__) . "assets/css/app.css", '', time(), '');
            wp_enqueue_script('car', plugin_dir_url(__FILE__) . "assets/js/app.js", array('jquery'), time(), true);
            wp_localize_script('car', 'indexed', array('ajaxurl' => admin_url('admin-ajax.php')));


        }

        public function single_car_template($template)
        {
            global $post;
            $theme_files = array('single-' . $this->post_type . '.php', 'car-ads/single-' . $this->post_type . '.php');

            if ($this->post_type === $post->post_type) {

                $exists_in_theme = locate_template($theme_files, false);
                if ($exists_in_theme != '') {
                    return $exists_in_theme;
                } else {
                    return plugin_dir_path(__FILE__) . 'template-parts/single-' . $this->post_type . '.php';
                }
            }

            return $template;
        }

        public function car_archive_template($template)
        {

            $post_type = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];

            if (($post_type === $this->post_type or is_post_type_archive('bil')) && is_archive()) {

                $theme_files     = array('archive-' . $this->post_type . '.php', 'car-ads/archive-' . $this->post_type . '.php');
                $exists_in_theme = locate_template($theme_files, false);
                if ($exists_in_theme != '') {
                    return $exists_in_theme;
                } else {
                    return plugin_dir_path(__FILE__) . 'template-parts/archive-' . $this->post_type . '.php';
                }
            }
            return $template;
        }


        /**
         * CarAds.io rewrite rules
         */

        public function carads_rewrite_rules()
        {
            add_rewrite_tag("%car_brand%", '(\d+)');
            add_rewrite_tag("%car_model%", '(\d+)');
            add_rewrite_rule('^' . $this->archive_slug . '/([^/]*)/([^/]*)/?', 'index.php?car_brand=$matches[1]&car_model=$matches[2]', 'top');
            add_rewrite_rule('^' . $this->archive_slug . '/([^/]*)/?', 'index.php?car_brand=$matches[1]', 'top');
        }

        public function resources_cpt_generating_rule($wp_rewrite)
        {
            $rules            = array();
            $terms            = get_terms(array(
                'taxonomy'   => 'car_brand',
                'hide_empty' => false,
            ));
            $terms_car_models = get_terms(array(
                'taxonomy'   => 'car_model',
                'hide_empty' => false,
            ));

            $post_type = 'bil';

            foreach ($terms as $term) {

                foreach ($terms_car_models as $terms_car_model) {
                    $rules[$this->single_slug . '/' . $term->slug . '/' . $terms_car_model->slug . '/([^/]*)$'] = 'index.php?post_type=' . $post_type . '&car_brand=$matches[1]&name=$matches[1]';
                }
            }

            // merge with global rules
            return $wp_rewrite->rules = $rules + $wp_rewrite->rules;
        }


        public function carads_term_link_filter($url, $term, $taxonomy)
        {

            // change the industry to the name of your taxonomy
            if ('car_brand' === $taxonomy) {
                $url = home_url() . '/' . $this->archive_slug . '/' . $term->slug;
            }
            if ('car_model' === $taxonomy) {
                $url = home_url() . '/' . $this->archive_slug . '/?car_model=' . $term->slug;
            }
            return $url;
        }

    }


    new CarAdsApp();
}