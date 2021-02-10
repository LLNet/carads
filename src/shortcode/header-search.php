<?php

use CarAds\Connector;

if (!class_exists('CarAdsAppQuickSearch')) {


    class CarAdsAppQuickSearch
    {

        public function __construct()
        {
            // Shortcode
            add_shortcode('car-ads-quick-search', [$this, 'render']);

            // Ajax function
            add_action('wp_ajax_carads_quicksearch_get_categories', [$this, 'carads_quicksearch_get_categories']);
            add_action('wp_ajax_nopriv_carads_quicksearch_get_categories', [$this, 'carads_quicksearch_get_categories']);
        }

        public function render()
        {
            ob_start();
            $connector        = new Connector();
            $products         = $connector->search();
            $availableFilters = $connector->getDropdownValuesForElementor($products);
            ?>

            <div class="car-ads-quick-search__header ca-flex ca-justify-center">
                <div class="ca-w-auto car-ads-quick-inner_container">
                    <div class="ca-text-white ca-text-3xl ca-font-medium ca-mb-4 car-ads-quick-search_title">
                        <span class="car-ads-quick-search_title--first">Vi har <?php echo $products->summary->totalItems; ?> <?php echo __('biler', 'car-ads'); ?> på lager</span>
                        <span class="car-ads-quick-search_title--second">- Find din næste bil her</span>
                    </div>
                    <form class="ca-grid ca-grid-cols-1 md:ca-grid-cols-3 ca-gap-2"
                          action="/<?php echo get_option('car-ads')['archive_slug']; ?>" method="get">

                        <select id="car-ads-quick-search__brands" name="brands[]"
                                class="ca-rounded ca-w-full ca-h-10 ca-w-40 ca-bg-white ca-items-center ca-px-2">
                            <option selected disabled><?php echo __('Vælg bilmærke', 'car-ads'); ?></option>
                            <?php
                            foreach ($availableFilters['brands'] as $slug => $brand) {
                                ?>
                                <option value="<?php echo $slug; ?>"><?php echo $brand; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <select id="car-ads-quick-search__categories" name="categories[]"
                                class="ca-rounded ca-w-full ca-h-10 ca-w-40 ca-bg-white ca-items-center ca-px-2">
                            <option selected disabled><?php echo __('Vælg model', 'car-ads'); ?></option>
                            <?php
                            foreach ($availableFilters['categories'] as $slug => $categories) {
                                ?>
                                <option value="<?php echo $slug; ?>"><?php echo $categories; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <button id="car-ads-quick-search__submit"
                                type="submit"
                                class="ca-rounded ca-h-10 ca-bg-secondary ca-px-2 bg-secondary font-medium ca-font-medium ca-uppercase ca-text-white">
                            <?php echo __('Søg', 'car-ads'); ?>
                        </button>

                    </form>
                </div>
            </div>
            <script>
                jQuery(function () {
                    jQuery('#car-ads-quick-search__brands').on('change', function (e) {
                        e.preventDefault();
                        let valueSelected = this.value;

                        jQuery.ajax({
                            type: "post",
                            dataType: "json",
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {
                                action: "carads_quicksearch_get_categories",
                                brand: valueSelected,
                            },
                            beforeSend: function () {

                                jQuery("#car-ads-quick-search__submit").html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
                            },
                            success: function (response) {

                                if (response.length) {
                                    jQuery('#car-ads-quick-search__categories').children().remove().end().append(jQuery('<option value="">Alle modeller</option>'));
                                    jQuery.each(response, function (id, item) {
                                        jQuery('#car-ads-quick-search__categories').append(jQuery('<option>', {
                                            value: item.slug,
                                            text: item.name
                                        }));
                                    });
                                    jQuery("#car-ads-quick-search__submit").text("Vis biler").prop('disabled', false);
                                } else {
                                    jQuery('#car-ads-quick-search__categories')
                                        .children().remove().end()
                                        .append(jQuery('<option>Ingen modeller fundet</option>'));
                                    jQuery("#car-ads-quick-search__submit").text("Ingen modeller fundet").prop('disabled', true);
                                    console.error("Ingen modeller fundet for: " + valueSelected)
                                }
                            },
                        });

                    });
                })
            </script>

            <?php
            return ob_get_clean();
        }


        public function carads_quicksearch_get_categories()
        {

            $connector = new Connector();
            $response  = $connector->get_brands_categories((string) $_POST['brand']);

            print json_encode($response);
            wp_die();
        }

    }


    new CarAdsAppQuickSearch();
}