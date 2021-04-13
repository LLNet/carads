<div class="single-car--quick-details ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4 ca-w-full">

    <h1 class="ca-text-2xl ca-font-medium"><?php echo $product->name; ?></h1>
    <hr class="ca-my-2 ca-bg-text bg-darkgrey">

    <div class="ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4">
        <dl class="ca-flex ca-flex-col">
            <dt class="ca-font-thin ca-leading-5"><?php _e('Kilometer', 'car-app'); ?></dt>
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
            <dt class="ca-font-thin ca-leading-5"><?php _e('Modelår', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Year');
                ?>
            </dd>
        </dl>
        <dl class="ca-flex ca-flex-col">
            <dt class="ca-font-thin ca-leading-5"><?php _e('Drivmiddel', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Propellant');
                ?>
            </dd>
        </dl>
        <dl class="ca-flex ca-flex-col">
            <?php
            if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                ?>

                <dt class="ca-font-thin ca-leading-5"><?php _e('Rækkevidde', 'car-app'); ?></dt>
                <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                    <?php
                    echo $connector->get_field($product->properties, 'Range') . " ";
                    echo __("km", 'car-app');
                    ?>
                </dd>

                <?php
            } else {
                ?>

                <dt class="ca-font-thin ca-leading-5"><?php _e('Forbrug', 'car-app'); ?></dt>
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
            <dt class="ca-font-thin ca-leading-5"><?php _e('Gearkasse', 'car-app'); ?></dt>
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
            <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Effect') . " ";
                echo __("hk", 'car-app');
                ?>
            </dd>
        </dl>
    </div>
    <hr class="ca-my-2 ca-bg-lightgrey">
    <?php
    if (!$product->disabled) {
        ?>
        <div>
            <?php
            $carType = $connector->get_field($product->properties, 'Type');
            if ($carType) {
                switch ($carType) {
                    case 'Varevogn plus moms':
                    case 'Varevogn +Moms':
                        $typeText = __("Varevogn +Moms", "car-app");
                        break;
                    case 'Varevogn minus moms':
                    case 'Varevogn -Moms':
                        $typeText = __("Varevogn", "car-app");
                        break;
                    default:
                        $typeText = $carType;
                        break;
                    case 'Personvogn':
                        $typeText = __("Personvogn", "car-app");
                        break;
                    case 'Campingbus':
                        $typeText = __("Campingbus", "car-app");
                        break;
                }
                ?>
                <div class="leasing ca-opacity-50 ca-font-normal ca-text-base ca-text-center"><?php echo $typeText; ?></div>
                <?php

            }
            ?>
        </div>
        <div class="price ca-flex ca-flex-col ca-items-center lg:ca-flex-row ca-mt-4 ca-mb-2">
            <div class="price--value ca-font-medium ca-text-3xl ca-mx-auto lg:ca-text-center ca-flex-col ca-flex">
                <?php
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
                ?>
            </div>
        </div>
        <?php
        do_action('car_ads_single_car_below_price', $product);
    } else {
        ?>
        <div class="price ca-flex ca-flex-col ca-items-center lg:ca-flex ca-justify-center ca-mt-4 ca-mb-2">
            <p class="price--value ca-font-medium ca-text-3xl text-center">
                <?php echo __('Solgt', 'car-app'); ?>
            </p>
        </div>
        <?php
    }
    ?>

    <div class="cta ca-hidden lg:ca-block">
        <?php
        $connector->getTemplatePart('components/cta/single-sidebar-byttepris', $product);
        $connector->getTemplatePart('components/cta/single-sidebar-testdrive', $product);
        $connector->getTemplatePart('components/cta/single-sidebar-phonenumber', $product);
        ?>
    </div>

</div>