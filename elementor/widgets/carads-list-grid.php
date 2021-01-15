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

class CarAdsListGrid extends Widget_Base
{

    public static $slug = 'car-ads-list-grid';

    public function get_name()
    {
        return self::$slug;
    }

    public function get_title()
    {
        return __('Car Ads List/Grid', self::$slug);
    }

    public function get_keywords()
    {
        return ['slider', 'car-ads', 'car ads', 'carads'];
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {


        $this->start_controls_section(
            'section_car',
            [
                'label' => __('Indstillinger for visning', 'elementor'),
            ]
        );

        /** Car options */
        $connector        = new Connector();
        $products         = $connector->search(true);
        $availableFilters = $connector->getDropdownValuesForElementor($products);

        $this->add_control(
            'post_type',
            [
                'label'   => __('Type'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'bil'    => 'Biler',
                    'tilbud' => 'Tilbud',

                ],
                'default' => 'bil',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'       => __('Antal biler'),
                'description' => 'Antal biler der skal vises i slideren',
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
                'condition'   => [
                    'post_type' => ['bil'],
                ],
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label'       => __('Antal indlæg'),
                'description' => 'Antal indlæg der skal vises',
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => -1,
                'condition'   => [
                    'post_type' => ['tilbud'],
                ],
            ]
        );

        $this->add_control(
            'brands',
            [
                'label'     => 'Vælg Mærke(r)',
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'multiple'  => true,
                'default'   => '',
                'options'   => $availableFilters['brands'],
                'condition' => [
                    'post_type' => ['bil'],
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'     => 'Vælg Model(ler)',
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'multiple'  => true,
                'default'   => '',
                'options'   => $availableFilters['categories'],
                'condition' => [
                    'post_type' => ['bil'],
                ],
            ]
        );
        $this->add_control(
            'properties',
            [
                'label'     => 'Vælg Properites',
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'multiple'  => true,
                'default'   => '',
                'options'   => $availableFilters['properties'],
                'condition' => [
                    'post_type' => ['bil'],
                ],
            ]
        );

        $this->add_control(
            'sort_by',
            [
                'label'     => __('Sortering'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    'price:asc'                 => 'Pris (Billigste først)',
                    'price:desc'                => 'Pris (Dyreste først)',
                    'name:asc'                  => 'Navn (A-Å)',
                    'name:desc'                 => 'Navn (Å-A)',
                    'customFields.mileage:asc'  => 'Kilometer (lav til høj)',
                    'customFields.mileage:desc' => 'Kilometer (høj til lav)',
                    'updated:asc'               => 'Opdateret (Nyeste først)',
                    'updated:desc'              => 'Opdateret (Ældste først)',
                    'created:asc'               => 'Oprettet (Nyeste først)',
                    'created:desc'              => 'Oprettet (Ældste først)',
                ],
                'default'   => 'name:asc',
                'condition' => [
                    'post_type' => ['bil'],
                ],
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label'   => __('Vis som'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'grid' => 'Grid',
                    'list' => 'Liste',
                ],
                'default' => 'grid',
                'condition' => [
                'post_type' => ['bil'],
            ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_readmore',
            [
                'label'     => __('Læs mere?', 'elementor'),
                'condition' => [
                    'post_type' => ['bil'],
                ],
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
                'description' => 'Skal der vises en læs mere knap',
                'condition'   => [
                    'post_type' => ['bil'],
                ],
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
                    'post_type'       => ['bil'],
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
                    'post_type'       => ['bil'],
                ],
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

        if ($settings['post_type'] === "bil") {
            $connector    = new Connector();
            $params       = [
                'size'       => $settings['size'] ?? 10,
                'brands'     => $settings['brands'] ?? null,
                'categories' => $settings['categories'] ?? null,
                'properties' => $settings['properties'] ?? null,
                'sort_by'    => $settings['sort_by']
            ];
            $products     = $connector->getCarsFromElementor($params);
            $archive_slug = get_option('car-ads')['archive_slug'] ?? 'biler';
            $single_slug  = get_option('car-ads')['single_slug'] ?? 'bil';

            if ($products) {
                $classes = "";
                if ($settings['display_type'] === "grid") {
                    $classes = "ca-grid ca-grid-cols-1 sm:ca-grid-cols-2 md:ca-grid-cols-2 lg:ca-grid-cols-3 ca-gap-8 ca-pt-4";
                }
                ?>
                <div class="car-ads-slider relative <?php echo $classes; ?>">
                    <?php
                    foreach ($products->items as $key => $product) {
                        include(__DIR__ . "/../../template-parts/components/product-{$settings['display_type']}.php");
                    }
                    ?>
                </div>
                <?php
            }
            if ($settings['readmore_active'] == "yes") {
                ?>
                <div class="ca-flex ca-items-center ca-justify-center ca-mt-4 ca-mb-4">
                    <a href="<?php echo $settings['readmore_url']; ?>"
                       class="ca-h-10 ca-bg-primary hover:ca-bg-gray-900 ca-text-white ca-uppercase ca-text-sm ca-rounded ca-inline-flex ca-items-center ca-font-medium
                       ca-justify-center ca-px-6 ca-border ca-border-primary hover:ca-border-gray-900 ca-transition ca-duration-150 ca-ease-in-out
                       h-10 bg-primary hover:bg-gray-900 text-white uppercase text-sm rounded inline-flex items-center  font-medium justify-center px-6 border border-primary hover:border-gray-900 transition duration-150 ease-in-out">
                        <?php echo !empty($settings['readmore_label']) ? $settings['readmore_label'] : __('Læs mere', 'indexed'); ?>
                    </a>
                </div>
                <?php
            }
        }

        if ($settings['post_type'] === "tilbud") {
            $language = substr(get_locale(), 0, 2);
            $args     = [
                'post_type'      => $settings['post_type'],
                'posts_per_page' => $settings['posts_per_page'],
                'lang'           => $language,
            ];

            $posts = new WP_Query($args);

            if ($posts->have_posts()) {
                ?>
                <div class="car-ads--tilbud-grid relative ca-grid ca-grid-cols-1 sm:ca-grid-cols-2 md:ca-grid-cols-2 lg:ca-grid-cols-3 ca-gap-8 ca-pt-4">
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
        }


        print ob_get_clean();
    }
}