<?php
$santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
$findleasingFinancial = $connector->get_field($product->customFields, 'findleasingFinancial');
?>
<a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant')); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
   class="ca-w-full ca-relative ca-bg-lightgrey ca-flex ca-flex-col ca-ca-no-underline"
   style="color: unset; text-decoration: none !important;"
   title="<?php echo __('Se flere detaljer om', 'car-app'); ?> <?php echo $product->name; ?>">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <div class="ca-w-full ca-h-80 ca-relative ca-flex-none">

            <?php
            if (!empty($findleasingFinancial)) {
                ?>
                <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                    <?php echo __('Se leasingberegner', 'car-app'); ?>
                </div>
                <?php
            }
            ?>


            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product"
                 class="ca-w-full ca-object-cover ca-object-center"
                 style="height: 100% !important;"
            >
            <?php
            if (property_exists($product->location->address, 'city')) {
                ?>
                <div class="ca-absolute ca-bottom-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-text-white ca-text-sm">

                    <?php echo __('Placering', 'car-app'); ?>: <?php echo $product->location->address->city; ?>

                </div>
                <?php
            }
            ?>
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
                    echo number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                } else {
                    echo __('Solgt', 'car-app');
                }
                ?>
            </div>
            <div class="ca-hidden hidden ca-text-sm ca-text-center ca-font-thin font-thin ca-mb-2">
                <?php _e('kontantpris inkl. moms', 'car-app'); ?>
            </div>
            <?php
            if (!empty($santanderPrice) && $santanderPrice != "-" && !$product->disabled) {
                ?>
                <div class="ca-text-center ca-text-lg ca-font-medium ca-mb-0 mb-0">
                    <?php echo __('Fra', 'car-app'); ?> <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                    <?php echo __('DKK. /md.', 'car-app'); ?>
                </div>
                <?php
            }
            ?>
        </div>

    </figcaption>
    <div class="car--grid--specs ca-bg-primary-dark ca-p-4 ca-flex-none ca-flex ca-justify-evenly ca-text-center ca-text-white ca-text-sm">

        <div>
            <div class="ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Årgang', 'car-app'); ?></div>
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
                    echo " " . __("km.", 'car-app');
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
                    echo $connector->get_field($product->properties, 'Range') . " ";
                    echo __("km", 'car-app');
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
</a>