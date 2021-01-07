<?php
$santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
?>
<a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant')); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
   class="ca-w-full ca-relative ca-bg-lightgrey ca-flex ca-flex-col ca-ca-no-underline"
   style="color: unset; text-decoration: none !important;"
   title="Se flere detaljer om <?php echo $product->name; ?>">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <div class="ca-w-full ca-h-64 ca-relative ca-flex-none">

            <?php
            if (!empty($santanderPrice) && $santanderPrice != "-") {
                ?>
                <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                    Fra. <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                    DKK. /md.
                </div>
                <?php
            }
            ?>


            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product"
                 class="ca-w-full ca-h-64 ca-object-cover ca-object-center"
                 style="max-height: 260px !important; height: 100% !important;"
            >
            <?php
            if (property_exists($product->location->address, 'city')) {
                ?>
                <div class="ca-absolute ca-bottom-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-text-white ca-text-sm">

                    Bilen er udstillet i vores <?php echo $product->location->address->city; ?> afdeling.

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

            <div class="ca-text-center ca-font-medium ca-text-2xl ca-mb-0 mb-0"><?php echo number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency(); ?></div>
            <div class="ca-text-sm ca-text-center ca-font-thin font-thin ca-mb-2"><?php _e('kontantpris inkl. moms', 'car-app'); ?></div>


            <?php
            if (!empty($santanderPrice) && $santanderPrice != "-") {
                ?>
                <div class="ca-text-center ca-text-lg ca-font-medium ca-mb-0 mb-0">
                    Fra. <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                    DKK. /md.</div>

                <?php
            }
            ?>
        </div>

    </figcaption>
    <div class="car--grid--specs ca-bg-primary-dark ca-p-4 ca-flex-none ca-flex ca-justify-evenly ca-text-center ca-text-white ca-text-sm">

        <div>
            <div class="ca-leading-none ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Årgang', 'car-app'); ?></div>
            <div class="ca-leading-none ca-font-medium ca-mb-0 mb-0">
                <?php
                echo $connector->get_field($product->properties, 'Year');
                ?>
            </div>
        </div>
        <div>
            <div class="ca-leading-none ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Kilometer', 'car-app'); ?></div>
            <div class="ca-leading-none ca-font-medium ca-mb-0 mb-0">
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
                <div class="ca-leading-none ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Rækkevidde', 'car-app'); ?></div>
                <div class="ca-leading-none ca-font-medium ca-mb-0 mb-0">
                    <?php
                    echo $connector->get_field($product->properties, 'Range') . " ";
                    echo __("km", 'car-app');
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="ca-leading-none ca-font-thin font-thin ca-mb-0 mb-0"><?php _e('Forbrug', 'car-app'); ?></div>
                <div class="ca-leading-none ca-font-medium ca-mb-0 mb-0">
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
            <div class="ca-leading-none ca-font-thin font-thin"><?php _e('Drivmiddel', 'car-app'); ?></div>
            <div class="ca-leading-none ca-font-medium">
                <?php
                echo $connector->get_field($product->properties, 'Propellant');
                ?>
            </div>
        </div>

    </div>
</a>