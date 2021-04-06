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
                    'id'    => 'car-ads',
                    'title' => __('Generelt', 'car-ads')
                ),
                array(
                    'id'    => 'car-ads-single-car',
                    'title' => __('Bilkort (Single)', 'car-ads')
                ),
                array(
                    'id'    => 'car-ads-archive',
                    'title' => __('Billiste (Archive)', 'car-ads')
                ),
                array(
                    'id'    => 'car-ads-theming',
                    'title' => __('Tema/Elementor', 'car-ads')
                ),
                array(
                    'id'    => 'car-ads-cpt',
                    'title' => __('Custom Post Types', 'car-ads')
                ),
            );
            return apply_filters('car_ads_settings_sections', $sections);
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields()
        {
            $fields = [
                'car-ads'            => [
                    [
                        'name'              => 'consumer_key',
                        'label'             => __('Consumer Key', 'car-ads'),
                        'desc'              => __('Enter the Consumer Key from CarAds', 'car-ads'),
                        'placeholder'       => __('ck_', 'car-ads'),
                        'type'              => 'text',
                        'default'           => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name'              => 'consumer_secret',
                        'label'             => __('Consumer Secret', 'car-ads'),
                        'desc'              => __('Enter the Consumer Secret from CarAds', 'car-ads'),
                        'placeholder'       => __('cs_', 'car-ads'),
                        'type'              => 'text',
                        'default'           => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name'              => 'public_token',
                        'label'             => __('Public Token', 'car-ads'),
                        'desc'              => __('Enter the Public Token from CarAds', 'car-ads'),
                        'placeholder'       => __('pt_', 'car-ads'),
                        'type'              => 'text',
                        'default'           => '',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name'              => 'single_slug',
                        'label'             => __('Single Page Slug', 'car-ads'),
                        'desc'              => __('http://domain.com/<strong>slug</strong>/audi/a4/bilens-egen-slug', 'car-ads'),
                        'placeholder'       => __('bil', 'car-ads'),
                        'type'              => 'text',
                        'default'           => 'bil',
                        'required'          => true,
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                    [
                        'name'              => 'archive_slug',
                        'label'             => __('Archive Page Slug', 'car-ads'),
                        'desc'              => __('http://domain.com/<strong>slug</strong>/audi/a4/', 'car-ads'),
                        'placeholder'       => __('biler', 'car-ads'),
                        'type'              => 'text',
                        'default'           => 'biler',
                        'sanitize_callback' => 'sanitize_text_field'
                    ],
                ],
                'car-ads-single-car' => [
                    [
                        'name'              => 'phonenumber',
                        'label'             => __('Telefonnummer til kontakt', 'car-ads'),
                        'desc'              => __('Skriv dit telefonnummer. Kun tal og uden "+45" foran.', 'car-ads'),
                        'placeholder'       => __('', 'car-ads'),
                        'type'              => 'text',
                        'sanitize_callback' => 'sanitize_number_field',
                    ],
                    [
                        'name'        => 'contactform_shortcode',
                        'label'       => __('Kontakt formular shortcode', 'car-ads'),
                        'desc'        => __('Skriv din Kontaktformular shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Skriv besked til os\']', 'car-ads'),
                        'type'        => 'textarea',
                        'default'     => '',
                    ],
                    [
                        'name'        => 'testdrive_shortcode',
                        'label'       => __('Bestil prøvetur shortcode', 'car-ads'),
                        'desc'        => __('Skriv din Bestil prøvetur shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Book prøvetur\']', 'car-ads'),
                        'type'        => 'textarea',
                        'default'     => '',
                    ],
                    [
                        'name'        => 'byttepris_shortcode',
                        'label'       => __('Beregn byttepris shortcode', 'car-ads'),
                        'desc'        => __('Skriv din Beregn byttepris shortcode her', 'car-ads'),
                        'placeholder' => __('[contact-form-7 id=\'5066\' title=\'Beregn byttepris\']', 'car-ads'),
                        'type'        => 'textarea',
                        'default'     => '',
                    ],
                    [
                        'name'    => 'show_back_to_archive',
                        'label'   => __('Vis link tilbage til oversigten', 'car-ads'),
                        'desc'    => __('Skal der vises et link tilbage til oversigten?', 'car-ads'),
                        'type'    => 'select',
                        'default' => 'no',
                        'options' => [
                            'yes' => 'Ja',
                            'no'  => 'Nej'
                        ]
                    ],

                ],
                'car-ads-archive'    => [
                    [
                        'name'        => 'includeDisabled',
                        'label'       => __('Inkluder solgte biler', 'car-ads'),
                        'desc'        => __('Skal der vises solgte biler i feedet?', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'select',
                        'default'     => 'yes',
                        'options'     => [
                            'true'  => 'Ja',
                            'false' => 'Nej'
                        ]
                    ],
                    [
                        'name'        => 'includeDisabledSince',
                        'label'       => __('Hvor mange dage tilbage?', 'car-ads'),
                        'desc'        => __('Hvor mange dage tilbage skal de solgte biler vises i feedet?', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'select',
                        'default'     => '7',
                        'options'     => [
                            '7'  => '7 dage',
                            '14' => '14 dage',
                            '30' => '1 måned',
                        ]
                    ],
                    [
                        'name'        => 'showLocation',
                        'label'       => __('Image Label?', 'car-ads'),
                        'desc'        => __('Visning af label nederst på en bils billede.', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'select',
                        'default'     => 'location',
                        'options'     => [
                            'no'  => 'Ingen',
                            'location' => 'Placering',
                            'type' => 'Bilens type',
                        ]
                    ],

                    [
                        'name'        => 'usePriceType',
                        'label'       => __('Pristype', 'car-ads'),
                        'desc'        => __('Vis kun biler med denne pristype på billisten', 'car-ads'),
                        'type'    => 'multicheck',
                        'default' => 'pricetype-retailprice',
                        'options' => array(
                            'pricetype-retailprice'           => 'Retail pris',
                            'pricetype-leasing'               => 'Leasing pris',
                            'pricetype-retailpricewithouttax' => 'Momsfri pris',
                            'pricetype-callforprice'          => 'Ring for pris',
                            'pricetype-wholesale'             => 'Engros',
                        )
                    ],
                    [
                        'name'        => 'archiveSeoText',
                        'label'       => __('Arkiv SEO Tekst', 'car-ads'),
                        'desc'        => __('Skriv din SEO tekst til Billisten her. Denne fremkommer under alle biler på billisten.', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'wysiwyg',
                        'default'     => '',

                    ],
                ],
                'car-ads-theming'    => [
                    [
                        'name'        => 'locations',
                        'label'       => __('Flere afdelinger?', 'car-ads'),
                        'desc'        => __('Har din forretning flere afdelinger (eks. flere CVR numre) hvor bilerne kan være placeret? Så kan du angive disse Bynavne adskilt af komma (,) her', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'text',
                        'default'     => '',
                    ],
                ],
                'car-ads-cpt' => [
                    [
                        'name'        => 'cpt_medarbejdere',
                        'label'       => __('Medarbejdere', 'car-ads'),
                        'desc'        => __('Skal denne custom post type være aktiv?', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'select',
                        'default'     => 'inactive',
                        'options'     => [
                            'inactive'  => 'Ikke aktiv',
                            'active' => 'Aktiv'
                        ]
                    ],
                    [
                        'name'        => 'cpt_tilbud',
                        'label'       => __('Aktuelle tilbud', 'car-ads'),
                        'desc'        => __('Skal denne custom post type være aktiv?', 'car-ads'),
                        'placeholder' => '',
                        'type'        => 'select',
                        'default'     => 'inactive',
                        'options'     => [
                            'inactive'  => 'Ikke aktiv',
                            'active' => 'Aktiv'
                        ]
                    ],
                ],
            ];

            return apply_filters('car_ads_settings_fields', $fields);
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
            $pages         = get_pages();
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
