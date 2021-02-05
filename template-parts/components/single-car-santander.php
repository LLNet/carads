<?php
// Only show santander is car has a santanderPaymentPerMonth value
if ($connector->get_field($product->customFields, 'santanderPaymentPerMonth') != '-' && $connector->get_field($product->customFields, 'santanderPaymentPerMonth') >= 0 &&  $connector->get_field($product->properties, 'PriceType') !== "CallForPrice") {
    ?>
    <div class="single-car--santander ca-bg-santander ca-w-full ca-p-4 ca-border ca-border-santander ca-text-white ca-border-solid ca-mb-4">

        <div class="ca-flex ca-flex-col ca-items-center">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/santander-logo.png">
            <div class="ca-font-medium ca-my-3">

                <?php echo __('Fra', 'car-app'); ?> <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                <?php echo __('DKK. /md.', 'car-app'); ?>

            </div>
            </span>
            <h4 class="ca-text-xl ca-font-medium ca-text-white"><?php echo __('Finansier med Santander', 'car-app'); ?></h4>
            <div class="">
                <ul class="santander">
                    <li><?php echo __('Lån til lav fast eller variabel rente', 'car-app'); ?></li>
                    <li><?php echo __('Fornuftige etableringsomkostninger', 'car-app'); ?></li>
                    <li><?php echo __('Ingen gebyr ved indfrielse af lån', 'car-app'); ?></li>
                </ul>
            </div>
            <button class="show-modal ca-bg-white ca-text-santander ca-font-medium ca-rounded ca-p-2 ca-mt-2 bg-white" data-target="modalSantander">
                <i class="fa fa-calculator"></i> <?php echo __('Beregn finansiering', 'car-app'); ?>
            </button>



        </div>

    </div>
    <?php
}