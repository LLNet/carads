<?php
get_header();
$connector        = new CarAds\Connector();
$products         = $connector->search();
$archive_slug     = get_option('car-ads')['archive_slug'] ?? 'biler';
$single_slug      = get_option('car-ads')['single_slug'] ?? 'bil';
$filters          = $connector->filters();
$availableFilters = $connector->availableFilters($products);
?>
    <form action="<?php echo home_url(); ?>/<?php echo $archive_slug; ?>/" method="get" class="car-filters-form">
        <?php include("components/filters.php"); ?>
        <div class="cars">
            <div class="car-row">

                <div class="car-col-12">
                    <div class="container">

                        <?php
                        if (is_post_type_archive('bil')) {
                            ?>
                            <div class="car-sorting">
                                <div>
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
                                <div>
                                    <?php
                                    if (property_exists($products, 'summary')) {
                                        echo "<span>" . $products->summary->totalItems . " " . __('biler', 'car-ads') . "</span>";
                                        echo "&nbsp;" . __('matcher din søgning', 'car-ads');
                                    }
                                    ?>
                                </div>
                                <div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="car-row car-list">
                            <?php
                            if ($products) {
                                foreach ($products->items as $key => $product) {
                                    include("components/product-grid.php");
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
            </div>

        </div>
    </form>
<?php
get_footer();