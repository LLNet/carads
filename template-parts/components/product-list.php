<?php
global $product;
$santanderPrice          = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');

/** Findleasing priser */
$findleasingFinancial    = $connector->get_field($product->customFields, 'findleasingFinancial');
$findleasingFinansielPriceMonthly = (int) $connector->get_field($product->customFields, 'findleasingFinansielPriceMonthly');

$findleasingOperationel    = $connector->get_field($product->customFields, 'findleasingOperationel');
$findleasingOperationelPriceMonthly = (int) $connector->get_field($product->customFields, 'findleasingOperationelPriceMonthly');

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
<div class="car md:ca-grid md:ca-grid-cols-4 ca-mb-8 ca-bg-white ca-w-full ca-border ca-border-solid ca-border-lightgrey">
    <?php

    if ($product->image->sizes->i1024x768) {


        ?>
        <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo $slug ?>"
           class="ca-max-h-80 img-wrap ca-relative ca-col-span-4 md:ca-col-span-2 lg:ca-col-span-1 ca-flex ca-w-full md:ca-w-auto ca-flex-shrink-0 ca-height-full ca-overflow-hidden md:ca-max-w-md">
            <?php
            /**
             * Leasing label inside photo
             */
            if (!$product->disabled) {
                /** Vis først Finansiel hvis den findes */
                if ($findleasingFinansielPriceMonthly) {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Leasing fra', 'car-app') . ": ";
                        echo number_format_i18n($findleasingFinansielPriceMonthly) . " DKK";
                        ?>
                    </div>
                    <?php
                }
                /** Ellers vis operationel hvis den findes */
                elseif($findleasingOperationelPriceMonthly) {
                    ?>
                    <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                        <?php
                        echo __('Leasing fra', 'car-app') . ": ";
                        echo number_format_i18n($findleasingOperationelPriceMonthly) . " DKK";
                        ?>
                    </div>
                    <?php
                }
            }
            /** Engros label inside photo */
            elseif ($connector->get_field($product->properties, 'PriceType') === "Wholesale") {
                ?>
                <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                    <?php
                    echo __('Engros', 'car-app');
                    ?>
                </div>
                <?php
            }
            /** Uden afgift label inside photo */
            elseif ($connector->get_field($product->properties, 'PriceType') === "RetailPriceWithoutTax") {
                ?>
                <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                    <?php
                    echo __('Uden afgift', 'car-app');
                    ?>
                </div>
                <?php
            }
            ?>
            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product"
                 class="ca-object-cover ca-object-center ca-w-full"
                 loading="lazy">
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
        </a>
        <?php
    } else {
        ?>
        <div class="ca-w-full ca-h-80 ca-relative ca-flex-none">
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
    <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo $slug ?>"
       class="car--info__title md:ca-col-span-2 lg:ca-col-span-3 ca-no-underline"
       style="color: unset; text-decoration: none !important;"
    >
        <figcaption class="car--info ca-p-2 md:ca-p-8 ca-w-full">
            <div class="ca-text-2xl ca-font-medium ca-mb-4"><?php echo $product->name; ?></div>
            <div class="car--info--content lg:ca-flex">
                <div class="car--info--content__specs ca-w-full lg:ca-w-3/4">
                    <div class="ca-grid ca-grid-cols-3 lg:ca-grid-cols-4 ca-gap-1">
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Kilometer', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                if ($connector->get_field($product->properties, 'Mileage') != '-') {
                                    echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                                } else {
                                    _e('-', 'car-app');
                                }
                                ?>
                            </dd>
                        </dl>
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Modelår', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                echo $connector->get_field($product->properties, 'Year');
                                ?>
                            </dd>
                        </dl>
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Drivmiddel', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                echo $connector->get_field($product->properties, 'Propellant');
                                ?>
                            </dd>
                        </dl>
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Gearkasse', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                switch ($connector->get_field($product->properties, 'GearType')) {
                                    case 'A':
                                        _e('Automatisk', 'car-app');
                                        break;
                                    case 'M':
                                        _e('Manuel', 'car-app');
                                        break;
                                    default:
                                        _e('-', 'car-app');
                                        break;
                                }
                                ?>
                            </dd>
                        </dl>
                        <?php
                        if (!empty($connector->get_field($product->properties, 'GreenTax')) && $connector->get_field($product->properties, 'GreenTax') != '-') {
                            ?>
                            <dl class="ca-flex ca-flex-col">
                                <dt class="ca-font-thin ca-leading-5"><?php _e('Grøn ejerafgift', 'car-app'); ?></dt>
                                <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                    <?php echo number_format_i18n($connector->get_field($product->properties, 'GreenTax')); ?>
                                    <?php
                                    if ($connector->get_field($product->properties, 'GreenTaxPeriod')) {
                                        echo "kr. / år";
                                    }
                                    ?>
                                </dd>
                            </dl>
                            <?php
                        }
                        ?>
                        <dl class="ca-flex ca-flex-col">
                            <?php
                            if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                                ?>

                                <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Rækkevidde', 'car-app'); ?></dt>
                                <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                    <?php
                                    echo $connector->get_field($product->properties, 'Range') . " ";
                                    echo __("km", 'car-app');
                                    ?>
                                </dd>

                                <?php
                            } else {
                                ?>

                                <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Forbrug', 'car-app'); ?></dt>
                                <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                    <?php
                                    echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                                    echo __("km/l", 'car-app');
                                    ?>
                                </dd>

                                <?php
                            }
                            ?>
                        </dl>

                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('HK', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                echo $connector->get_field($product->properties, 'Effect') . " ";
                                echo __("hk", 'car-app');
                                ?>
                            </dd>
                        </dl>
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Registreringsår', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                $date = $connector->get_field($product->properties, 'RegistrationDate');
                                if (!empty($date) && $date !== '-') {
                                    echo date("m/Y", strtotime($date));
                                } else {
                                    echo $date;
                                }
                                ?>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="car--info--content__price ca-w-full lg:ca-w-1/4 ca-flex ca-justify-center ca-items-center lg:ca-items-end lg:ca-justify-center ca-flex-col">
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

                    <?php
                    $santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
                    if (!empty($santanderPrice) && $santanderPrice != "-" && !$product->disabled && $priceType !== "CallForPrice") {
                        ?>
                        <div class="leasing ca-opacity-50 ca-font-normal ca-text-base">
                            <?php echo __('Fra', 'car-app') . " "; ?><?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                            <?php echo __('DKK. /md.', 'car-app'); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            do_action('car_ads_archive_list_below_content');
            ?>
        </figcaption>
    </a>

</div>