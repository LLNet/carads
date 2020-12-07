<div class="car">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo $product->slug; ?>"
           class="img-wrap">
            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product">
        </a>
        <?php
    }
    ?>
    <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo $product->slug; ?>"
       class="car--info__title">
    <figcaption class="car--info">

            <?php echo $product->name; ?>


        <div class="car--info--content">
            <div class="car--info--content__specs">
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
                    <dt><?php _e('Energiklasse', 'PLUGIN_NAME'); ?></dt>
                    <dd>-</dd>
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
                    <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
                    <dd>
                        <?php
                        echo $connector->get_field($product->properties, 'Effect') . " ";
                        echo __("hk", 'PLUGIN_NAME');
                        ?>
                    </dd>
                </dl>
                <dl>
                    <dt><?php _e('Registreringsår', 'PLUGIN_NAME'); ?></dt>
                    <dd>
                        <?php
                        echo $connector->get_field($product->properties, 'RegistrationDate');
                        ?>
                    </dd>
                </dl>
            </div>
            <div class="car--info--content__price">
                <?php
                echo number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                $santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
                if (!empty($santanderPrice) && $santanderPrice != "-") {
                    ?>
                    <small class="leasing">
                        Fra. <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                        DKK. /md.
                    </small>
                    <?php
                }
                ?>
            </div>
        </div>

    </figcaption>
    </a>
</div>