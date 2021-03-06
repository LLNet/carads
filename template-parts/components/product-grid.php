<?php
$santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');

/** Findleasing priser */
$findleasingFinancial             = $connector->get_field($product->customFields, 'findleasingFinancial');
$findleasingFinansielPriceMonthly = $connector->get_field($product->customFields, 'findleasingFinansielPriceMonthly');

$findleasingOperationel             = $connector->get_field($product->customFields, 'findleasingOperationel');
$findleasingOperationelPriceMonthly = $connector->get_field($product->customFields, 'findleasingOperationelPriceMonthly');

/** Creating slug */
$car_slug_id = "";
if ($connector->get_field($product->properties, '__Id') != "-") {
    $car_slug_id = "-" . $connector->get_field($product->properties, '__Id');
}
if ($connector->get_field($product->properties, 'Id') != "-") {
    $car_slug_id = "-" . $connector->get_field($product->properties, 'Id');
}

$variant = str_replace('variant-', '', $connector->get_field($product->properties, 'Variant'));

$slug = ($variant != "-" ? sanitize_title($variant) : sanitize_title($product->name));
$slug .= $car_slug_id;
?>
<a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo $slug; ?>"
   class="ca-w-full ca-relative ca-bg-lightgrey ca-flex ca-flex-col ca-ca-no-underline"
   style="color: unset; text-decoration: none !important;"
   title="<?php echo __('Se flere detaljer om', 'car-app'); ?> <?php echo $product->name; ?>">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <div class="ca-car-image-container ca-w-full ca-max-h-56 ca-h-56 ca-relative ca-flex-none">
            <?php
            /**
             * Leasing label inside photo
             */
            if (!$product->disabled) {
                /** Vis først Finansiel hvis den findes */
                if (!empty($findleasingFinansielPriceMonthly) && $findleasingFinansielPriceMonthly != '-') {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Leasing fra', 'car-app') . ": ";
                        echo number_format_i18n($findleasingFinansielPriceMonthly) . " DKK";
                        ?>
                    </div>
                    <?php
                } /** Ellers vis operationel hvis den findes */
                elseif (!empty($findleasingOperationelPriceMonthly) && $findleasingOperationelPriceMonthly != '-') {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Leasing fra', 'car-app') . ": ";
                        echo number_format_i18n($findleasingOperationelPriceMonthly) . " DKK";
                        ?>
                    </div>
                    <?php
                } /** Engros label inside photo  */
                elseif ($connector->get_field($product->properties, 'PriceType') === "Wholesale") {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Engros', 'car-app');
                        ?>
                    </div>
                    <?php
                } /** Uden afgift label inside photo */
                elseif ($connector->get_field($product->properties, 'PriceType') === "RetailPriceWithoutTax") {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Uden afgift', 'car-app');
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product"
                 class="ca-w-full ca-object-cover ca-object-center"
                 style="height: 100% !important;"
                 loading="lazy"
            >
            <?php
            if (get_option('car-ads-archive')['showLocation'] === "yes" || get_option('car-ads-archive')['showLocation'] == "location") {
                if (property_exists($product->location->address, 'city')) {
                    ?>
                    <div class="car--placement ca-absolute ca-bottom-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-text-white ca-text-sm">
                        <?php echo __('Placering', 'car-app'); ?>: <?php echo $product->location->address->city; ?>
                    </div>
                    <?php
                }
            }
            if (get_option('car-ads-archive')['showLocation'] === "type") {
                if (property_exists($product->location->address, 'city')) {
                    ?>
                    <div class="car--type ca-absolute ca-bottom-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-text-white ca-text-sm">
                        <?php
                        $carType = $connector->get_field($product->properties, 'Type');
                        if ($carType) {
                            switch ($carType) {
                                case 'Varevogn plus moms':
                                    $typeText = __("Varevogn +Moms", "car-app");
                                    break;
                                case 'Varevogn minus moms':
                                    $typeText = __("Varevogn", "car-app");
                                    break;
                                default:
                                case 'Personvogn':
                                    $typeText = __("Personvogn", "car-app");
                                    break;
                                case 'Campingbus':
                                    $typeText = __("Campingbus", "car-app");
                                    break;
                            }
                            echo $typeText;
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <div class="ca-car-image-container ca-w-full ca-max-h-56 ca-h-56 ca-relative ca-flex-none">
            <img src="/wp-content/plugins/car-app/assets/noImageSmall.gif"
                 data-src="/wp-content/plugins/car-app/assets/noImageSmall.gif" alt="product"
                 class="ca-w-full ca-object-cover ca-object-center"
                 style="height: 100% !important;"
                 loading="lazy"
            >
        </div>
        <?php
    }
    ?>

    <figcaption class="car--info ca-flex-grow ca-bg-white">
        <div class="ca-p-4">
            <h2 class="ca-text-center ca-font-medium ca-text-xl"><?php echo $product->brand->name . " " . $product->category->name; ?></h2>
            <h3 class="ca-text-center ca-mb-2 ca-text-lg"><?php echo $connector->get_field($product->properties, 'Variant'); ?></h3>

            <div class="ca-text-center ca-font-medium ca-text-2xl ca-mb-0 mb-0">
                <?php
                if (!$product->disabled) {
                    $priceType = $connector->get_field($product->properties, 'PriceType');
                    switch ($priceType) {
                        case 'RetailPriceWithoutTax':
                            $connector->getTemplatePart('components/price/retailpricewithouttax', $product);
                            break;
                        case 'Wholesale':
                            $connector->getTemplatePart('components/price/wholesale', $product);
                            break;
                        case 'CallForPrice':
                            $connector->getTemplatePart('components/price/callforprice', $product);
                            break;
                        case 'Leasing':
                            $connector->getTemplatePart('components/price/leasing', $product);
                            break;
                        case 'RetailPrice':
                        case null:
                        default:
                            $connector->getTemplatePart('components/price/retail', $product);
                            break;
                    }
                } else {
                    echo __('Solgt', 'car-app');
                }
                ?>
            </div>
            <div class="ca-hidden hidden ca-text-sm ca-text-center ca-font-thin font-thin ca-mb-2">
                <?php _e('kontantpris inkl. moms', 'car-app'); ?>
            </div>
            <?php
            $showSantander = true;
            if ($connector->get_field($product->customFields, 'santanderDisabled') != '-' && $connector->get_field($product->customFields, 'santanderDisabled') == true) {
                $showSantander = false;
            }
            if ($showSantander) {
                if (!empty($santanderPrice) && $santanderPrice != "-" && !$product->disabled && $priceType !== "CallForPrice") {
                    ?>
                    <div class="ca-text-center ca-text-base ca-opacity-50 ca-font-medium ca-mb-0 mb-0">
                        <?php echo __('Fra', 'car-app') . " "; ?><?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                        <?php echo __('DKK. /md.', 'car-app'); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </figcaption>
    <div class="car--grid--specs ca-bg-primary-dark ca-p-4 ca-flex-none ca-flex ca-justify-evenly ca-text-center ca-text-white ca-text-sm">

        <div>
            <div class="ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Modelår', 'car-app'); ?></div>
            <div class="ca-font-medium ca-mb-0 mb-0">
                <?php
                echo $connector->get_field($product->properties, 'Year');
                ?>
            </div>
        </div>
        <div>
            <div class="ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Kilometer', 'car-app'); ?></div>
            <div class="ca-font-medium ca-mb-0 mb-0">
                <?php
                if ($connector->get_field($product->properties, 'Mileage') != '-') {
                    echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                } else {
                    _e('-', 'car-app');
                }
                ?>
            </div>
        </div>
        <div>
            <?php
            if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                ?>
                <div class="ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Rækkevidde', 'car-app'); ?></div>
                <div class="ca-font-medium ca-mb-0 mb-0">
                    <?php
                    echo $connector->get_field($product->properties, 'Range');
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Forbrug', 'car-app'); ?></div>
                <div class="ca-font-medium ca-mb-0 mb-0">
                    <?php
                    echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                    echo __("km/l", 'car-app');
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div>
            <div class="ca-font-thin font-thin"><?php _e('Drivmiddel', 'car-app'); ?></div>
            <div class="ca-font-medium">
                <?php
                echo $connector->get_field($product->properties, 'Propellant');
                ?>
            </div>
        </div>

    </div>
    <?php
    do_action('car_ads_archive_grid_below_content');
    ?>
</a>