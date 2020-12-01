<div class="card">

    <h1><?php echo $product->name; ?></h1>
    <hr>

    <div class="quick-specs">
        <dl>
            <dt><?php _e('Kilometer', 'PLUGIN_NAME'); ?></dt>
            <dd>
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
            <dt><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
            <dd>
                <?php
                echo $connector->get_field($product->properties, 'Year');
                ?>
            </dd>
        </dl>
        <dl>
            <dt><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
            <dd>
                <?php
                echo $connector->get_field($product->properties, 'Propellant');
                ?>
            </dd>
        </dl>
        <dl>
            <?php
            if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                ?>

                <dt><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
                <dd>
                    <?php
                    echo $connector->get_field($product->properties, 'Range') . " ";
                    echo __("km", 'PLUGIN_NAME');
                    ?>
                </dd>

                <?php
            } else {
                ?>

                <dt><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
                <dd>
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
            <dt><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
            <dd>
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
            <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
            <dd>
                <?php
                echo $connector->get_field($product->properties, 'Effect') . " ";
                echo __("hk", 'PLUGIN_NAME');
                ?>
            </dd>
        </dl>
    </div>
    <hr>
    <div class="price d-flex">
        <p class="price--label">Kontantpris</p>
        <p class="price--value">
            <?php
            echo number_format_i18n($product->pricing->{$currency}->price, 0);
            echo " " . $currency;
            ?>
        </p>
    </div>

    <div class="cta desktop">
        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalByttepris"><i
                class="fa fa-fw fa-calculator"></i> Beregn
            byttepris</a>
        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalBestil"><i
                class="fa fa-fw fa-car"></i> Bestil prøvetur</a>
        <a href="#" data-href="tel:+4586520033" class="btn btn-primary js-phone-switch">
            <span class="text-cta"><i class="fa fa-fw fa-phone"></i> Ring til os</span>
            <span class="text-value"><i class="fa fa-fw fa-phone"></i> Telefon: 86 52 00 33</span>
        </a>
    </div>

</div>