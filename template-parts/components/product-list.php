<div class="car md:ca-grid md:ca-grid-cols-4 ca-mb-8 ca-bg-white ca-w-full ca-border ca-border-solid ca-border-lightgrey">
    <?php
    if ($product->image->sizes->i1024x768) {
        ?>
        <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant') ); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
           class="img-wrap ca-col-span-4 md:ca-col-span-2 lg:ca-col-span-1 ca-flex ca-w-full md:ca-w-auto ca-flex-shrink-0 ca-height-full ca-overflow-hidden md:ca-max-w-md">
            <img src="<?php echo str_replace("i1024x768", "500x250", $product->image->sizes->i1024x768); ?>"
                 data-src="<?php echo $product->image->sizes->i1024x768; ?>" alt="product" class="ca-object-fit ca-w-full">
        </a>
        <?php
    }
    ?>
    <a href="/<?php echo $single_slug; ?>/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>/<?php echo sanitize_title($connector->get_field($product->properties, 'Variant') ); ?>-<?php echo $connector->get_field($product->properties, 'Id'); ?>"
       class="car--info__title md:ca-col-span-2 lg:ca-col-span-3">
        <figcaption class="car--info ca-p-8 ca-w-full">

            <span class="ca-text-2xl ca-font-bold"><?php echo $product->name; ?></span>
            <div class="car--info--content ca-w-full md:ca-flex ca-flex-wrap">
                <div class="car--info--content__specs ca-w-full lg:ca-w-3/4">
                    <div class="ca-grid ca-grid-cols-3 lg:ca-grid-cols-4 ca-gap-1">
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
                            <dt class="ca-font-normal ca-leading-5"><?php _e('Energiklasse', 'PLUGIN_NAME'); ?></dt>
                            <dd class="ca-font-bold ca-leading-5 ca-mb-1">-</dd>
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
                            <dt class="ca-font-normal ca-leading-5"><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
                            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                                <?php
                                echo $connector->get_field($product->properties, 'Effect') . " ";
                                echo __("hk", 'PLUGIN_NAME');
                                ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt class="ca-font-normal ca-leading-5"><?php _e('Registreringsår', 'PLUGIN_NAME'); ?></dt>
                            <dd class="ca-font-bold ca-leading-5 ca-mb-1">
                                <?php
                                echo $connector->get_field($product->properties, 'RegistrationDate');
                                ?>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="car--info--content__price ca-w-full lg:ca-w-1/4 ca-flex ca-justify-center ca-items-center lg:ca-items-end lg:ca-justify-center ca-flex-col">
                    <span class="ca-text-2xl md:ca-text-xl ca-mt-2 lg:ca-mt-0 ca-font-bold"><?php echo number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency(); ?></span>
                    <?php
                    $santanderPrice = $connector->get_field($product->customFields, 'santanderPaymentPerMonth');
                    if (!empty($santanderPrice) && $santanderPrice != "-") {
                        ?>
                        <small class="leasing ca-opacity-50 ca-font-bold">
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