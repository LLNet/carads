<div class="ca-bg-white ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4 ca-w-full">

    <h1 class="ca-text-2xl ca-font-bold"><?php echo $product->name; ?></h1>
    <hr class="ca-my-2 ca-bg-lightgrey">

    <div class="ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4">
        <dl>
            <dt class="ca-font-normal ca-leading-5"><?php _e('Kilometer', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                <?php

                if ($connector->get_field($product->properties, 'Mileage') != '-') {
                    echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                    echo " " . __("km.", 'PLUGIN_NAME');
                } else {
                    _e('-', 'PLUGIN_NAME');
                }
                ?>
            </dd>
        </dl>
        <dl>
            <dt class="ca-font-normal ca-leading-5"><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Year');
                ?>
            </dd>
        </dl>
        <dl>
            <dt class="ca-font-normal ca-leading-5"><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Propellant');
                ?>
            </dd>
        </dl>
        <dl>
            <?php
            if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                ?>

                <dt class="ca-font-normal ca-leading-5"><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
                <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                    <?php
                    echo $connector->get_field($product->properties, 'Range') . " ";
                    echo __("km", 'PLUGIN_NAME');
                    ?>
                </dd>

                <?php
            } else {
                ?>

                <dt class="ca-font-normal ca-leading-5"><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
                <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                    <?php
                    echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                    echo __("km/l", 'PLUGIN_NAME');
                    ?>
                </dd>

                <?php
            }
            ?>
        </dl>
        <dl>
            <dt class="ca-font-normal ca-leading-5"><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                <?php
                switch ($connector->get_field($product->properties, 'GearType')) {
                    case 'A':
                        _e('Automatisk', 'PLUGIN_NAME');
                        break;
                    case 'M':
                        _e('Manuel', 'PLUGIN_NAME');
                        break;
                    default:
                        _e('-', 'PLUGIN_NAME');
                        break;
                }
                ?>
            </dd>
        </dl>
        <dl>
            <dt class="ca-font-normal ca-leading-5"><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Effect') . " ";
                echo __("hk", 'PLUGIN_NAME');
                ?>
            </dd>
        </dl>
    </div>
    <hr class="ca-my-2 ca-bg-lightgrey">
    <div class="price ca-flex ca-flex-col ca-items-center lg:ca-flex-row ca-mt-4 ca-mb-2">
        <p class="price--label ca-font-bold lg:ca-flex-grow-1">Kontantpris</p>
        <p class="price--value ca-font-bold ca-text-3xl lg:ca-ml-auto lg:ca-text-right">
            <?php
            echo number_format_i18n($product->pricing->{$currency}->price, 0);
            echo " " . $currency;
            ?>
        </p>
    </div>

    <div class="cta ca-hidden lg:ca-block">
        <a href="" class="ca-bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white show-modal" data-target="modalByttepris"><i
                class="fa fa-fw fa-calculator"></i> Beregn
            byttepris</a>
        <a href="" class="ca-bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white show-modal" data-target="modalBestil"><i
                class="fa fa-fw fa-car"></i> Bestil prøvetur</a>
        <a href="#" data-href="tel:+4586520033" class="ca-bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white js-phone-switch">
            <span class="text-cta"><i class="fa fa-fw fa-phone"></i> Ring til os</span>
            <span class="text-value"><i class="fa fa-fw fa-phone"></i> Telefon: 86 52 00 33</span>
        </a>
    </div>

</div>