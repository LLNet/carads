<?php
$santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
$findleasingFinancial = $connector->get_field($product->customFields, 'findleasingFinancial');
?>
<div class="car md:ca-grid md:ca-grid-cols-4 ca-mb-8 ca-bg-white ca-w-full ca-border ca-border-solid ca-border-lightgrey">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant')); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
           class="img-wrap ca-relative ca-col-span-4 md:ca-col-span-2 lg:ca-col-span-1 ca-flex ca-w-full md:ca-w-auto ca-flex-shrink-0 ca-height-full ca-overflow-hidden md:ca-max-w-md">
            <?php
            if (!empty($findleasingFinancial) && $findleasingFinancial != '-') {
                ?>
                <div class="carads-leasing-price ca-absolute ca-top-0 ca-right-0 ca-py-1 ca-px-2 ca-bg-primary ca-text-white">
                    <?php echo __('Se leasingberegner', 'car-app'); ?>
                </div>
                <?php
            }
            ?>
            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product"
                 class="ca-object-fit ca-w-full">
            <?php
            if (property_exists($product->location->address, 'city')) {
                ?>
                <div class="ca-absolute ca-bottom-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-text-white ca-text-sm">
                    <?php echo __('Placering', 'car-app'); ?>: <?php echo $product->location->address->city; ?>
                </div>
                <?php
            }
            ?>
        </a>
        <?php
    }
    ?>
    <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant')); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
       class="car--info__title md:ca-col-span-2 lg:ca-col-span-3 ca-no-underline"
       style="color: unset; text-decoration: none !important;"
    >
        <figcaption class="car--info ca-p-8 ca-w-full">

            <span class="ca-text-2xl ca-font-medium"><?php echo $product->name; ?></span>
            <div class="car--info--content ca-w-full md:ca-flex ca-flex-wrap">
                <div class="car--info--content__specs ca-w-full lg:ca-w-3/4">
                    <div class="ca-grid ca-grid-cols-3 lg:ca-grid-cols-4 ca-gap-1">
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Kilometer', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                                <?php
                                if ($connector->get_field($product->properties, 'Mileage') != '-') {
                                    echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                                    echo " " . __("km.", 'car-app');
                                } else {
                                    _e('-', 'car-app');
                                }
                                ?>
                            </dd>
                        </dl>
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Årgang', 'car-app'); ?></dt>
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
                        <dl class="ca-flex ca-flex-col">
                            <dt class="ca-font-thin font-thin ca-leading-5"><?php _e('Energiklasse', 'car-app'); ?></dt>
                            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">-</dd>
                        </dl>
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
                                echo $connector->get_field($product->properties, 'RegistrationDate');
                                ?>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="car--info--content__price ca-w-full lg:ca-w-1/4 ca-flex ca-justify-center ca-items-center lg:ca-items-end lg:ca-justify-center ca-flex-col">
                    <span class="ca-text-2xl md:ca-text-xl ca-mt-2 lg:ca-mt-0 ca-font-medium">
                        <?php
                        if (!$product->disabled) {
                            echo number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                        } else {
                            echo __('Solgt', 'car-app');
                        }
                        ?>
                    </span>
                    <?php
                    $santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
                    if (!empty($santanderPrice) && $santanderPrice != "-" && !$product->disabled) {
                        ?>
                        <small class="leasing ca-opacity-50 ca-font-medium">
                            <?php echo __('Fra', 'car-app'); ?><?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                            <?php echo __('DKK. /md.', 'car-app'); ?>
                        </small>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </figcaption>
    </a>

</div>