<?php
if (!is_post_type_archive('bil')) {
    return false;
}
?>
<div class="update-filters ca-hidden ca-bg-primary bg-primary ca-z-20 ca-h-14 ca-py-0 ca-px-4 ca-flex ca-fixed ca-top-0 ca-left-0 ca-w-full ca-items-center ca-justify-center ca-text-white ca-font-medium"
     id="update-filters">
    <div class="ca-container ca-mx-auto ca-flex ca-justify-center ca-items-center">
        <a href="#top" class="toggle-filters"><i class="fa fa-sliders"></i> Opdater søgning</a>
    </div>
</div>
<div class="car-filters ca-bg-secondary bg-secondary ca-p-4 md:ca-p-8" id="car-filters">
    <div class="ca-container ca-mx-auto">

        <label class="free-search-label ca-flex ca-mb-4 ca-w-full ca-h-14 ca-relative" for="search">
            <input type="text" name="search" id="search" value="<?php echo $_GET['search'] ?? ''; ?>"
                   style="max-width: none !important; width: 100% !important;"
                   placeholder="<?php echo __("Fritekst søgning. Eks: 'Audi A3'", 'car-app'); ?>"
                   class="free-search ca-w-full ca-mb-4 ca-py-0 ca-px-4 ca-h-14 ca-border-0 ca-rounded "
                   onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }"
            >
        </label>

        <div class="attributes ca-grid ca-grid-cols-1 sm:ca-grid-cols-2 md:ca-grid-cols-3 lg:ca-grid-cols-4 ca-gap-4">
            <label for="brands">
                <select id="brands" name="brands[]" class="multiselect" multiple="multiple">
                    <?php
                    if (property_exists($products->aggregations->global, 'brands')) {

                        if (isset($_GET['categories']) && !empty($_GET['categories'])) {
                            $brands = $products->aggregations->filtered->brands;
                        } else {
                            $brands = $products->aggregations->global->brands;
                        }
                        ksort($brands);

                        foreach ($brands as $key => $brand) {
                            if ($brand->count > 0) {
                                ?>
                                <option value="<?php echo $brand->item->slug; ?>"
                                    <?php
                                    if (in_array($brand->item->slug, $filters['brands'])) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    <?php echo $brand->item->name; ?> (<span
                                            style="color:red;"><?php echo $brand->count; ?></span>)
                                </option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </label>
            <label for="categories">
                <select id="categories" name="categories[]" class="multiselect" multiple="multiple">

                    <?php
                    if (property_exists($products->aggregations->global, 'categories')) {

                        if (isset($_GET['brands']) && !empty($_GET['brands'])) {
                            $models = $products->aggregations->filtered->categories;
                        } else {
                            $models = $products->aggregations->global->categories;
                        }
                        ksort($models);

                        foreach ($models as $key => $category) {
                            if ($category->count > 0) {
                                ?>
                                <option value="<?php echo $category->item->slug; ?>"
                                    <?php
                                    if (in_array($category->item->slug, $filters['categories'])) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    <?php echo $category->item->name; ?> (<?php echo $category->count; ?>)
                                </option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </label>
            <label for="propellant">
                <select name="properties[]" id="propellant" class="multiselect" multiple="multiple">

                    <?php
                    foreach ($connector->get_filter_options('Propellant') as $key => $option) {
                        if ($option['count'] > 0) {
                            ?>
                            <option value="<?php echo $option['slug']; ?>"
                                <?php
                                if (in_array($option['slug'], $filters['properties'])) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php echo $option['value']; ?>
                                (<?php echo $option['count']; ?>)
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </label>
            <label for="year">
                <select name="properties[]" id="year" class="multiselect" multiple="multiple">

                    <?php
                    foreach ($connector->get_filter_options('Year') as $key => $option) {
                        if ($option['count'] > 0) {
                            ?>
                            <option value="<?php echo $option['slug']; ?>"
                                <?php
                                if (in_array($option['slug'], $filters['properties'])) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php echo $option['value']; ?>
                                (<?php echo $option['count']; ?>)
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </label>
            <label for="geartype">
                <select name="properties[]" id="geartype" class="multiselect" multiple="multiple">

                    <?php
                    foreach ($connector->get_filter_options('GearType') as $key => $option) {

                        if ($option['count'] > 0) {
                            ?>
                            <option value="<?php echo $option['slug']; ?>"
                                <?php
                                if (in_array($option['slug'], $filters['properties'])) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php
                                switch ($option['value']) {
                                    case 'A':
                                        echo "Automatisk";
                                        break;
                                    case 'M':
                                        echo "Manuel";
                                        break;
                                }
                                ?>
                                (<?php echo $option['count']; ?>)
                            </option>
                            <?php
                        }

                    }
                    ?>
                </select>
            </label>

            <?php
            /*
            ?>
            <label for="pricingMax">
                <select name="pricingMax" id="pricingMax" class="auto-submit">
                    <option value="-1">Alle prisniveauer</option>
                    <?php
                    $prices = [25000, 50000, 75000, 100000, 150000, 200000, 300000, 400000, 500000];
                    foreach ($prices as $price) {
                        ?>
                        <option value="<?php echo $price; ?>" <?php echo (isset($_GET['pricingMax']) && !empty($_GET['pricingMax']) && $_GET['pricingMax'] == $price) ? 'selected' : ''; ?>>
                            op til <?php echo number_format_i18n($price); ?> DKK
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </label>
            */
            ?>
            <div class="ca-bg-white bg-white ca-rounded ca-text-text ca-h-14 ca-py-0 ca-px-4">
                <?php
                $min = $products->aggregations->global->pricing->DKK->min;
                $max = $products->aggregations->global->pricing->DKK->max;

                $pricingMinMaxValue = (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) ? $_GET['pricingMinMax'] : '';
                $sliderValue        = explode(",", $pricingMinMaxValue);
                ?>
                <div class="ca-flex ca-justify-between ca-text-sm">
                    <span class="ca-w-1/3 ca-text-left ca-font-thin"
                          id="apricingMin"><?php echo number_format_i18n(($sliderValue[0]) ? $sliderValue[0] : $min); ?></span>
                    <span class="ca-w-1/3 ca-text-center">Pris</span>
                    <span class="ca-w-1/3 ca-text-right ca-font-thin"
                          id="apricingMax"><?php echo number_format_i18n(($sliderValue[1]) ? $sliderValue[1] : $max); ?></span>
                </div>
                <div class="slider-container">
                    <input id="pricingMinMax"
                           name="pricingMinMax"
                           type="text"
                           class=""
                           value="<?php echo $pricingMinMaxValue; ?>"
                           data-slider-min="<?php echo $min; ?>"
                           data-slider-max="<?php echo $max; ?>"
                           data-slider-step="10000"
                           data-slider-value="[<?php echo ($sliderValue[0]) ? $sliderValue[0] : $min; ?>,<?php echo ($sliderValue[1]) ? $sliderValue[1] : $max; ?>]"
                    />
                </div>
                <script>
                    jQuery(function () {
                        const options1 = {style: 'currency', currency: 'DKK'};
                        const numberFormat1 = new Intl.NumberFormat('da-DK', options1);
                        jQuery("#pricingMinMax").slider({
                            tooltip: 'hide',
                        }).on("slide", function (slideEvt) {
                            jQuery("#apricingMin").text(slideEvt.value[0].toLocaleString('da-DK'));
                            jQuery("#apricingMax").text(slideEvt.value[1].toLocaleString('da-DK'));
                        });
                    });
                </script>
            </div>


            <div class="ca-bg-white bg-white ca-rounded ca-text-text ca-h-14 ca-py-0 ca-px-4 mileage-container">
                <?php
                $mileageMinMaxValues = $connector->getCustomFieldAggregation('mileage');

                $mileageMinMaxValue = (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) ? $_GET['mileageMinMax'] : '';
                $sliderMileage      = explode(",", $mileageMinMaxValue);
                ?>
                <div class="ca-flex ca-justify-between ca-text-sm">
                    <span class="ca-w-1/3 ca-text-left ca-font-thin"
                          id="amileageMin"><?php echo number_format_i18n(($sliderMileage[0]) ? $sliderMileage[0] : $mileageMinMaxValues->min); ?></span>
                    <span class="ca-w-1/3 ca-text-center">Kilometer</span>
                    <span class="ca-w-1/3 ca-text-right ca-font-thin"
                          id="amileageMax"><?php echo number_format_i18n(($sliderMileage[1]) ? $sliderMileage[1] : $mileageMinMaxValues->max); ?></span>
                </div>
                <div class="slider-container">
                    <input id="mileageMinMax"
                           name="mileageMinMax"
                           type="text"
                           class=""
                           value="<?php echo $mileageMinMaxValue; ?>"
                           data-slider-min="<?php echo $mileageMinMaxValues->min; ?>"
                           data-slider-max="<?php echo $mileageMinMaxValues->max; ?>"
                           data-slider-step="1000"
                           data-slider-value="[<?php echo ($sliderMileage[0]) ? $sliderMileage[0] : $mileageMinMaxValues->min; ?>,<?php echo ($sliderMileage[1]) ? $sliderMileage[1] : $mileageMinMaxValues->max; ?>]"
                    />
                </div>
                <script>
                    function numberWithDots(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    jQuery(function () {
                        jQuery("#mileageMinMax").slider({
                            tooltip: 'hide',
                        }).on("slide", function (slideEvt) {
                            jQuery("#amileageMin").text(numberWithDots(slideEvt.value[0]));
                            jQuery("#amileageMax").text(numberWithDots(slideEvt.value[1]));
                        });
                    })
                </script>
            </div>


            <?php
            if (!empty($filters)) {
                $buttonText = __('Vis', 'car-app') . " " . $connector->search()->summary->totalItems . " " . __('biler', 'car-app');
            } else {
                $buttonText = __('Søg', 'car-app');
            }
            ?>
            <button type="submit"
                    class="filter ca-rounded ca-bg-primary bg-primary ca-h-14 ca-text-white ca-font-medium ca-transition ca-duration-300 ca-ease-in-out hover:ca-bg-primary-dark"><?php echo $buttonText; ?></button>

        </div>


    </div>

</div>

<div class="car-active-filters ca-bg-secondary bg-secondary ca-p-4 md:ca-p-8">
    <div class="ca-container ca-mx-auto">
        <?php include("activeFilters.php"); ?>
    </div>
</div>