<?php
if(!is_post_type_archive('bil')) {
    return false;
}
?>
<div class="update-filters" id="update-filters">
    <div class="container">
        <a href="#top" class="toggle-filters"><i class="fa fa-sliders"></i> Opdater søgning</a>
    </div>
</div>
<?php
//    print "<pre>";
//    print_r($connector->get_filter_options('Mileage'));
//    print "</pre>";

?>
<div class="car-filters" id="car-filters">
    <div class="container">

            <label class="free-search-label" for="search">
                <input type="text" name="search" id="search" value="<?php echo $_GET['search'] ?? ''; ?>"
                       placeholder="Fritekst søgning. Eks: 'Audi A3'" class="free-search">
            </label>

            <div class="attributes">
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
                <div class="pricing-container">
                    <?php
                    $min = $products->aggregations->global->pricing->DKK->min;
                    $max = $products->aggregations->global->pricing->DKK->max;

                    $pricingMinMaxValue = (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) ? $_GET['pricingMinMax'] : '';
                    $sliderValue = explode(",", $pricingMinMaxValue);
                    ?>
                    <div style="display:flex; justify-content: space-between;">
                        <span id="apricingMin"><?php echo number_format_i18n(($sliderValue[0]) ? $sliderValue[0] : $min); ?></span>
                        <span>Pris</span>
                        <span id="apricingMax"><?php echo number_format_i18n(($sliderValue[1]) ? $sliderValue[1] : $max); ?></span>
                    </div>
                    <div class="slider-container">
                        <input id="pricingMinMax"
                               name="pricingMinMax"
                               type="text"
                               class=""
                               value="<?php echo $pricingMinMaxValue;?>"
                               data-slider-min="<?php echo $min; ?>"
                               data-slider-max="<?php echo $max; ?>"
                               data-slider-step="10000"
                               data-slider-value="[<?php echo ($sliderValue[0]) ? $sliderValue[0] : $min; ?>,<?php echo ($sliderValue[1]) ? $sliderValue[1] : $max; ?>]"
                        />
                    </div>
                </div>
                <script>
                    jQuery(function () {

                        const options1 = { style: 'currency', currency: 'DKK' };
                        const numberFormat1 = new Intl.NumberFormat('da-DK', options1);

                        jQuery("#pricingMinMax").slider({
                            tooltip: 'hide',
                        }).on("slide", function(slideEvt) {
                            jQuery("#apricingMin").text(slideEvt.value[0].toLocaleString('da-DK'));
                            jQuery("#apricingMax").text(slideEvt.value[1].toLocaleString('da-DK'));
                        });
                    });
                </script>

                <label>
                    <select name="properties[]" id="mileage" class="multiselect" multiple="multiple">

                        <?php
                        foreach ($connector->get_filter_options('Mileage') as $key => $option) {
                            if ($option['count'] > 0) {
                                ?>
                                <option value="<?php echo $option['slug']; ?>"
                                    <?php
                                    if (in_array($option['slug'], $filters['properties'])) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    <?php echo number_format_i18n($option['value']); ?> km
                                    (<?php echo $option['count']; ?>)
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </label>
                <label>
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
                if (!empty($filters)) {
                    $buttonText = "Vis ". $connector->search()->summary->totalItems . " biler";
                } else {
                    $buttonText = "Søg";
                }
                ?>
                <button type="submit" class="filter"><?php echo $buttonText; ?></button>

            </div>



    </div>

</div>

<div class="car-active-filters">
    <div class="container">
        <?php include("activeFilters.php"); ?>
    </div>
</div>