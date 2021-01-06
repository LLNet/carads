<?php

if (!class_exists('CarAdsSettings')):
    class CarAdsSettings
    {

        private $settings_api;

        function __construct()
        {
            $this->settings_api = new CarAdsSettings_API;

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
        }

        function admin_init()
        {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            //initialize settings
            $this->settings_api->admin_init();
        }

        function admin_menu()
        {
            add_options_page('CarAds Settings', 'CarAds Settings', 'delete_posts', 'car-ads-settings', array($this, 'plugin_page'));
        }

        function get_settings_sections()
        {
            $sections = array(
                array(
                    'id' => 'car-ads',
                    'title' => __('Generelt', 'car-ads')
                ),
                array(
                    'id' => 'car-ads-single-car',
                    'title' => __('Single Car', 'car-ads')
                ),
//                array(
//                    'id' => 'car-ads-theming',
//                    'title' => __('Theme Colors', 'car-ads')
//                ),
            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields()
        {
            return [
                'car-ads' => [
                    [
                        'name' => 'consumer_key',
                        'label' => __('Consumer Key', 'car-ads'),
                        'desc' => __('Enter the Consumer Key from CarAds', 'car-ads'),
                        'placeholder' => __('ck_', 'car-ads'),
                        'type' => 'text',
                        'default' => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name' => 'consumer_secret',
                        'label' => __('Consumer Secret', 'car-ads'),
                        'desc' => __('Enter the Consumer Secret from CarAds', 'car-ads'),
                        'placeholder' => __('cs_', 'car-ads'),
                        'type' => 'text',
                        'default' => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name' => 'public_token',
                        'label' => __('Public Token', 'car-ads'),
                        'desc' => __('Enter the Public Token from CarAds', 'car-ads'),
                        'placeholder' => __('pt_', 'car-ads'),
                        'type' => 'text',
                        'default' => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name' => 'single_slug',
                        'label' => __('Single Page Slug', 'car-ads'),
                        'desc' => __('http://domain.com/<strong>slug</strong>/audi/a4/bilens-egen-slug', 'car-ads'),
                        'placeholder' => __('bil', 'car-ads'),
                        'type' => 'text',
                        'default' => 'bil',
                        'required' => true,
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name' => 'archive_slug',
                        'label' => __('Archive Page Slug', 'car-ads'),
                        'desc' => __('http://domain.com/<strong>slug</strong>/audi/a4/', 'car-ads'),
                        'placeholder' => __('biler', 'car-ads'),
                        'type' => 'text',
                        'default' => 'biler',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                ],
                'car-ads-single-car' => [
                    [
                        'name' => 'phonenumber',
                        'label' => __('Telefonnummer til kontakt', 'car-ads'),
                        'desc' => __('Skriv dit telefonnummer. Kun tal og uden "+45" foran.', 'car-ads'),
                        'placeholder' => __('', 'car-ads'),
                        'type' => 'text',
                        'sanitize_callback' => 'sanitize_number_field',
                    ],
                    [
                        'name' => 'contactform_shortcode',
                        'label' => __('Kontakt formular shortcode', 'car-ads'),
                        'desc' => __('Skriv din Kontaktformular shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Skriv besked til os\']', 'car-ads'),
                        'type' => 'textarea',
                        'default' => '',
                    ],
                    [
                        'name' => 'testdrive_shortcode',
                        'label' => __('Bestil prøvetur shortcode', 'car-ads'),
                        'desc' => __('Skriv din Bestil prøvetur shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Book prøvetur\']', 'car-ads'),
                        'type' => 'textarea',
                        'default' => '',
                    ],
                    [
                        'name' => 'byttepris_shortcode',
                        'label' => __('Beregn byttepris shortcode', 'car-ads'),
                        'desc' => __('Skriv din Beregn byttepris shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Beregn byttepris\']', 'car-ads'),
                        'type' => 'textarea',
                        'default' => '',
                    ],

                ],
                'car-ads-theming' => [
                    [
                        'name' => 'byttepris_shortcode',
                        'label' => __('Beregn byttepris shortcode', 'car-ads'),
                        'desc' => __('Skriv din Beregn byttepris shortcode her', 'car-ads'),
                        'placeholder' => '',
                        'type' => 'color',
                        'default' => '',
                    ],
                ]
            ];
        }

        function plugin_page()
        {
            echo '<div class="wrap">';

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();

            echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages()
        {
            $pages = get_pages();
            $pages_options = array();
            if ($pages) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }

    new CarAdsSettings();
endif;
