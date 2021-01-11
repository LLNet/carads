<?php

namespace Indexed;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use \WP_Query;
use CarAds\Connector;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class CarAdsSlider extends Widget_Base
{

    public static $slug = 'car-ads-slider';

    public function get_name()
    {
        return self::$slug;
    }

    public function get_title()
    {
        return __('Car Ads Slider', self::$slug);
    }

    public function get_keywords()
    {
        return ['slider', 'car-ads', 'car ads', 'carads'];
    }

    public function get_icon()
    {
        return 'fa fa-th';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('CPT Slider', 'elementor'),
            ]
        );

        $terms             = get_terms(array(
            'taxonomy'   => 'afdeling',
            'hide_empty' => false,
        ));
        $categories        = [];
        $categories['---'] = 'Ingen';
        foreach ($terms as $key => $term) {
            $categories[$term->term_id] = $term->name;
        }

        $this->add_control(
            'post_type',
            [
                'label'   => __('Vælg Custom Post Type'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'page'        => 'Sider',
                    'post'        => 'Indlæg',
                    'bil'         => 'Biler',
                    'medarbejder' => 'Medarbejdere',
                    'tilbud'      => 'Tilbud',
                ],
                'default' => 'bil',
            ]
        );

        $this->add_control(
            'category',
            [
                'label'     => __('Vælg afdeling'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => $categories,
                'default'   => 'Randers',
                'condition' => [
                    'post_type' => ['medarbejder'],
                ],
            ]
        );

        $this->add_control(
            'count',
            [
                'label'       => __('Antal'),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => '10',
                'min'         => -1,
                'description' => 'Antal vist. Vælg -1 for alle!'
            ]
        );


        $this->add_control(
            'readmore_active',
            [
                'label'       => __('Læs mere knap aktiv?'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'no',
                'options'     => [
                    'yes' => 'Ja',
                    'no'  => 'Nej',
                ],
                'description' => 'Skal der vises en læs mere knap'
            ]
        );

        $this->add_control(
            'readmore_label',
            [
                'label'     => 'Læs mere knap tekst',
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Se flere', 'elementor'),
                'condition' => [
                    'readmore_active' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'readmore_url',
            [
                'label'     => 'Læs mere knap url',
                'type'      => Controls_Manager::TEXT,
                'default'   => __('https://', 'elementor'),
                'condition' => [
                    'readmore_active' => ['yes'],
                ],
            ]
        );

        /** Car options */
        $connector        = new Connector();
        $products         = $connector->search(true);
        $availableFilters = $connector->getDropdownValuesForElementor($products);

        $this->add_control(
            'size',
            [
                'label'       => __('Antal biler'),
                'description' => 'Antal biler der skal vises i slideren',
                'condition'   => [
                    'post_type' => ['bil'],
                ],
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
            ]

        );

        $this->add_control(
            'brands',
            [
                'label'     => 'Vælg Mærke(r)',
                'condition' => [
                    'post_type' => ['bil'],
                ],
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'multiple'  => true,
                'default'   => '',
                'options'   => $availableFilters['brands']
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'     => 'Vælg Model(ler)',
                'condition' => [
                    'post_type' => ['bil'],
                ],
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'multiple'  => true,
                'default'   => '',
                'options'   => $availableFilters['categories']
            ]
        );


        $this->end_controls_section();


    }


    private function has_field($settings, $field)
    {
        return (!empty($settings[$field]));
    }

    private function get_field($settings, $field)
    {
        return $settings[$field];
    }

    protected function render()
    {
        ob_start();
        $settings = $this->get_settings_for_display();


        $id_int = substr($this->get_id_int(), 0, 3);
        ?>

        <script>
            jQuery(function () {
                jQuery('.multiple-items-<?php echo $id_int; ?>').slick({
                    infinite: true,
                    autoplay: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    nextArrow: jQuery('#next-<?php echo $id_int; ?>'),
                    prevArrow: jQuery('#prev-<?php echo $id_int; ?>'),
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        </script>
        <?php
        if ($settings['post_type'] !== "bil") {
            $language = substr(get_locale(), 0, 2);
            $args     = [
                'post_type'      => $settings['post_type'],
                'posts_per_page' => $settings['count'],
                'lang'           => $language,
            ];
            if (!empty($settings['category']) && $settings['category'] !== '---') {
                $args['tax_query'] = [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'afdeling',
                        'field'    => 'term_id',
                        'terms'    => $settings['category']
                    ]
                ];
            }

            $posts = new WP_Query($args);

            if ($posts->have_posts()) {
                // Kalender layout

                ?>
                <div class="car-ads-slider multiple-items-<?php echo $id_int; ?> relative">
                    <?php
                    while ($posts->have_posts()) {
                        $posts->the_post();

                        ?>
                        <div class="flex flex-col">
                            <div class="flex lg:h-72">
                                <?php the_post_thumbnail('full', ['class' => 'object-cover w-full']); ?>
                            </div>
                            <div class="bg-lightgrey text-center p-2 h-32 flex items-center justify-center">
                                <div>
                                    <?php
                                    if ($settings['post_type'] === "medarbejder") {
                                        ?>

                                        <h3 class="font-medium text-text text-xl md:text-lg lg:text-2xl"><?php echo get_the_title(); ?></h3>
                                        <div class="mb-4 px-4 text-base text-center font-thin"><?php echo get_field('stilling', get_the_ID()); ?></div>

                                        <?php
                                    }
                                    if ($settings['post_type'] === "tilbud") {
                                        ?>
                                        <h3 class="font-medium text-text text-md md:text-lg lg:text-xl opacity-75 leading-5"><?php echo get_the_title(); ?></h3>
                                        <div class="px-4 text-text text-center text-xl md:text-lg lg:text-2xl font-bold"><?php echo get_field('pris', get_the_ID()); ?></div>
                                        <a href="<?php echo get_the_permalink(); ?>"
                                           class="text-center text-primary text-sm my-2">
                                            <i class="fa fa-chevron-right"></i> <?php echo __('Læs mere', 'indexed'); ?>
                                        </a>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php


            }
            wp_reset_query();
            wp_reset_postdata();
        } else {
            // Importer
//            require __DIR__ . '/../../src/classes/class.connector.php';
            $connector = new Connector();

            $params = [
                'size'       => $settings['size'] ?? 10,
                'brands'     => $settings['brands'] ?? null,
                'categories' => $settings['categories'] ?? null
            ];

            $products = $connector->getCarsFromElementor($params);

            $archive_slug = get_option('car-ads')['archive_slug'] ?? 'biler';
            $single_slug  = get_option('car-ads')['single_slug'] ?? 'bil';

            if ($products) {
                ?>
                <div class="car-ads-slider multiple-items-<?php echo $id_int; ?> relative">
                    <?php
                    foreach ($products->items as $key => $product) {
                        include(__DIR__ . "/../../template-parts/components/product-grid.php");
                    }
                    ?>
                </div>
                <?php
            }

        }

        if ($posts->post_count > 3 || $settings['size'] > 3) {
            ?>
            <div class="ca-flex ca-items-center ca-justify-center ca-h-24 flex items-center justify-center h-24">
                <button id="prev-<?php echo $id_int; ?>"
                        class="slick-prev slick-arrow
                        ca-z-20 ca-mr-6  ca-h-10 ca-w-10 ca-bg-white ca-border ca-border-primary ca-rounded-full ca-flex ca-items-center ca-justify-center
                        ca-text-primary ca-translate ca-transform focus:ca-bg-primary focus:ca-text-white hover:ca-bg-primary hover:ca-text-white
                        z-20 mr-6 mr-6 h-10 w-10 bg-white border border-primary rounded-full flex items-center justify-center
                        text-primary translate transform focus:bg-primary focus:text-white hover:bg-primary hover:text-white">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <?php
                if ($settings['readmore_active'] == "yes") {
                    ?>
                    <a href="<?php echo $settings['readmore_url']; ?>"
                       class="ca-h-10 ca-bg-primary hover:ca-bg-gray-900 ca-text-white ca-uppercase ca-text-sm ca-rounded ca-inline-flex ca-items-center ca-font-medium
                       ca-justify-center ca-px-6 ca-border ca-border-primary hover:ca-border-gray-900 ca-transition ca-duration-150 ca-ease-in-out
                       h-10 bg-primary hover:bg-gray-900 text-white uppercase text-sm rounded inline-flex items-center  font-medium justify-center px-6 border border-primary hover:border-gray-900 transition duration-150 ease-in-out">
                        <?php echo !empty($settings['readmore_label']) ? $settings['readmore_label'] : __('Læs mere', 'indexed'); ?>
                    </a>
                    <?php
                }
                ?>
                <button id="next-<?php echo $id_int; ?>"
                        class="slick-next slick-arrow
                        ca-z-20 ca-ml-6 ca-h-10 ca-w-10 ca-bg-white ca-border ca-border-primary ca-rounded-full ca-flex ca-items-center ca-justify-center ca-text-primary
                        ca-translate ca-transform focus:ca-bg-primary focus:ca-text-white hover:ca-bg-primary hover:ca-text-white
                        z-20 ml-6 h-10 w-10 bg-white border border-primary rounded-full flex items-center justify-center text-primary translate
                        transform focus:bg-primary focus:text-white hover:bg-primary hover:text-white">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <?php
        }
        ?>


        <?php
        print ob_get_clean();
    }
}