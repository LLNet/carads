<?php
get_header();
$connector        = new CarAds\Connector();
$products         = $connector->search();
$archive_slug     = get_option('car-ads')['archive_slug'] ?? 'biler';
$single_slug      = get_option('car-ads')['single_slug'] ?? 'bil';
$filters          = $connector->filters();
$availableFilters = $connector->availableFilters($products);
?>
    <form action="<?php echo home_url(); ?>/<?php echo $archive_slug; ?>/" method="get"
          class="car-filters-form relative">
        <?php include("components/filters.php"); ?>
        <div class="cars">

            <div class="ca-container ca-mx-auto ">

                <?php
                if (is_post_type_archive('bil')) {
                    ?>
                    <div class="car-sorting ca-flex lg:ca-flex-row ca-py-4 ca-px-4 md:ca-px-8 ca-rounded-lg ca-bg-primary-dark ca-text-white md:ca-mb-4">
                        <div class="car-sorting--sort_by ca-flex ca-bg-white ca-order-2 lg:ca-order-1 ca-w-1/2 lg:ca-w-1/5 ca-items-end lg:ca-items-center">
                            <select name="sort_by" id="sort_by" class="ca-h-10 ca-rounded-lg ca-text-text">
                                <option disabled unselectable="">Sorter efter</option>
                                <option value="price:asc" <?php echo 'price:asc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Billigste
                                </option>
                                <option value="price:desc" <?php echo 'price:desc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Dyreste
                                </option>
                                <option value="name:asc" <?php echo 'name:asc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Navn A-Å
                                </option>
                                <option value="name:desc" <?php echo 'name:desc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Navn Å-A
                                </option>
                                <option value="customFields.mileage:asc" <?php echo 'customFields.mileage:asc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Kilometer (lav til høj)
                                </option>
                                <option value="customFields.mileage:desc" <?php echo 'customFields.mileage:desc' == $filters['sort_by'] ? 'selected' : ''; ?>>
                                    Kilometer (høj til lav)
                                </option>
                            </select>
                        </div>
                        <div class="car-sorting--summary ca-flex ca-my-2 ca-order-1 lg:ca-order-2 ca-w-1/2 lg:ca-w-3/5 lg:ca-justify-center lg:ca-items-center">
                            <?php

                            if (property_exists($products, 'summary')) {
                                echo "<div>";
                                echo "<span class='number-of-cars-found ca-leading-6 lg:ca-leading-normal ca-text-primary ca-mr-2 ca-text-3xl lg:ca-text-3xl ca-font-bold'>" . $products->summary->totalItems . " " . __('biler', 'car-ads') . "</span> ";
                                echo "<span class='ca-leading-6 lg:ca-leading-normal ca-text-white lg:ca-text-3xl'>" . __('matcher din søgning', 'car-ads') . "</span>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                        <div class="car-sorting--grid-toggle ca-order-3 lg:ca-w-1/5 ca-flex md:ca-justify-end ca-items-center">
                            <div class="ca-ml-auto lg:ca-items-center ca-justify-end ca-flex  ca-h-10">
                                <?php
                                $car_view = $_COOKIE['car_view'] ?? 'list';
                                ?>
                                <a href=""
                                   data-view="list"
                                   class="car_view_change <?php if ($car_view === "list") { ?>ca-bg-primary ca-text-white<?php } else { ?> ca-bg-white ca-text-text <?php } ?> ca-flex ca-items-center ca-justify-center ca-h-10 ca-w-10 ca-rounded-l-lg hover:ca-bg-primary-dark hover:ca-text-white ca-transition ca-duration-300 ca-ease-in-out"><i
                                            class="fa fa-navicon"></i></a>
                                <a href=""
                                   data-view="grid"
                                   class="car_view_change <?php if ($car_view === "grid") { ?>ca-bg-primary ca-text-white<?php } else { ?> ca-bg-white ca-text-text <?php } ?> ca-flex ca-items-center ca-justify-center ca-h-10 ca-w-10 ca-rounded-r-lg hover:ca-bg-primary-dark hover:ca-text-white ca-transition ca-duration-300 ca-ease-in-out"><i
                                            class="fa fa-th"></i></a>
                            </div>
                            <script>
                                jQuery(function () {

                                });
                            </script>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                $view_mode = $_COOKIE['car_view'] ?? 'list';
                if ($view_mode === "list") {
                    ?>
                    <div class="car-row car-list">
                    <?php
                }
                if ($view_mode === "grid") {
                    ?>
                    <div class="ca-grid ca-grid-cols-1 sm:ca-grid-cols-2 md:ca-grid-cols-3 ca-gap-8 ca-pt-4">
                    <?php
                }
                ?>

                    <?php
                    if ($products) {
                        foreach ($products->items as $key => $product) {

                            include("components/product-" . $view_mode . ".php");
                        }
                    }
                    ?>


                    </div>

                    <div class="car-row">
                        <div class="car-col-12" style="padding:10px;text-align: center;">
                            <div>
                                <?php
                                if (property_exists($products, 'navigation')) {
                                    if (property_exists($products->navigation, 'previous')) {
                                        ?>
                                        <a href="<?php echo $products->navigation->previous; ?>"><?php _e('Previous', 'car-ads'); ?></a>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if (property_exists($products->navigation, 'next')) {
                                        ?>
                                        <a href="<?php echo $products->navigation->next; ?>"><?php _e('Next', 'car-ads'); ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </form>
<?php
get_footer();