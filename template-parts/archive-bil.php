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

            <div class="ca-container ca-mx-auto">

                <?php
                if (is_post_type_archive('bil')) {
                    ?>
                    <div class="car-sorting ca-flex lg:ca-flex-row ca-px-4 md:ca-px-8">
                        <div class="car-sorting--sort_by ca-flex ca-flex-col ca-my-2 ca-order-2 lg:ca-order-1 ca-w-1/2 lg:ca-w-1/3 ca-items-end lg:ca-items-start">
                            <label for="sort_by" class="ca-text-sm">Sorter efter:</label>
                            <select name="sort_by" id="sort_by">
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
                        <div class="car-sorting--summary ca-flex ca-flex-col lg:ca-flex-row ca-my-2 ca-order-1 lg:ca-order-2 ca-w-1/2 lg:ca-w-1/3 lg:ca-justify-center lg:ca-items-center">
                            <?php
                            if (property_exists($products, 'summary')) {
                                echo "<span class='ca-leading-6 lg:ca-leading-normal ca-text-primary ca-mr-1 ca-text-3xl lg:ca-text-base ca-font-bold'>" . $products->summary->totalItems . " " . __('biler', 'car-ads') . "</span> ";
                                echo "<span class='ca-leading-6 lg:ca-leading-normal ca-text-text lg:ca-text-base'>" . __('matcher din søgning', 'car-ads') . "</span>";
                            }
                            ?>
                        </div>
                        <div class="car-sorting--grid-toggle ca-order-3 lg:ca-w-1/3 lg:ca-items-end">

                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="car-row car-list">
                    <?php
                    if ($products) {
                        foreach ($products->items as $key => $product) {
                            include("components/product-list.php");
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