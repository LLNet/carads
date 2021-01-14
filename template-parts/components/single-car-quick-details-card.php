<div class="ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4 ca-w-full">

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
            <dt class="ca-font-thin ca-leading-5"><?php _e('Årgang', 'car-app'); ?></dt>
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
        <div class="price ca-flex ca-flex-col ca-items-center lg:ca-flex-row ca-mt-4 ca-mb-2">
            <p class="price--label ca-font-medium lg:ca-flex-grow-1"><?php echo __('Kontantpris', 'car-app'); ?></p>
            <p class="price--value ca-font-medium ca-text-3xl lg:ca-ml-auto lg:ca-text-right">
                <?php
                echo number_format_i18n($product->pricing->{$currency}->price, 0);
                echo " " . $currency;
                ?>
            </p>
        </div>
        <?php
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
        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['byttepris_shortcode'])) {
            ?>
            <a href=""
               class="ca-bg-primary bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white show-modal"
               data-target="modalByttepris">
                <i class="fa fa-fw fa-calculator"></i> <?php echo __('Beregn byttepris', 'car-app'); ?>
            </a>
            <?php
        }
        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
            ?>
            <a href=""
               class="ca-bg-primary bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white show-modal"
               data-target="modalBestil">
                <i class="fa fa-fw fa-car"></i> <?php echo __('Bestil prøvetur', 'car-app'); ?>
            </a>
            <?php
        }
        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
            ?>
            <a href="#"
               class="ca-col-span-1 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white  js-phone-switch"
               data-href="tel:+45<?php echo get_option('car-ads-single-car')['phonenumber']; ?>">
                <div class="text-cta ca-block" id="cta_before">
                    <i class="fa fa-fw fa-phone"></i>
                    <?php echo __('Ring til os', 'car-app'); ?>
                </div>
                <div class="text-value ca-hidden" id="cta_after">
                    <i class="fa fa-fw fa-phone"></i>
                    Tlf <?php echo get_option('car-ads-single-car')['phonenumber']; ?>
                </div>
            </a>
            <?php
        }
        ?>
    </div>

</div>