<?php
// Only show santander is car has a santanderPaymentPerMonth value
if ($connector->get_field($product->customFields, 'santanderPaymentPerMonth') != '-' && $connector->get_field($product->customFields, 'santanderPaymentPerMonth') >= 0) {
    ?>
    <div class="ca-bg-santander ca-w-full ca-p-4 ca-border ca-border-santander ca-text-white ca-border-solid ca-mb-4">

        <div class="ca-flex ca-flex-col ca-items-center">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/santander-logo.png">
            <div class="ca-font-bold ca-my-3">

                Fra. <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                DKK. /md.

            </div>
            </span>
            <h4 class="ca-text-xl ca-font-bold ca-text-white">Finansier med Santander</h4>
            <div class="">
                <ul class="santander">
                    <li>Lån til lav fast eller variabel rente</li>
                    <li>Fornuftige etableringsomkostninger</li>
                    <li>Ingen gebyr ved indfrielse af lån</li>
                </ul>
            </div>
            <button class="ca-bg-white ca-text-santander ca-font-bold ca-rounded ca-p-2 ca-mt-2 show-modal" data-target="modalSantander">
                <i class="fa fa-calculator"></i> Beregn finansiering
            </button>



        </div>

    </div>
    <?php
}