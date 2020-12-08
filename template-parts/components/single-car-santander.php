<?php
// Only show santander is car has a santanderPaymentPerMonth value
if ($connector->get_field($product->customFields, 'santanderPaymentPerMonth') != '-' && $connector->get_field($product->customFields, 'santanderPaymentPerMonth') >= 0) {
    ?>
    <div class="card santander">

        <div class="santander--content">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/santander-logo.png">
            <div class="price">

                Fra. <?php echo number_format_i18n($connector->get_field($product->customFields, 'santanderPaymentPerMonth')); ?>
                DKK. /md.

            </div>
            </span>
            <h4>Finansier med Santander</h4>
            <div class="list-container">
                <ul style="list-style-type: none;">
                    <li>Lån til lav fast eller variabel rente</li>
                    <li>Fornuftige etableringsomkostninger</li>
                    <li>Ingen gebyr ved indfrielse af lån</li>
                </ul>
            </div>
            <button class="btn btn-light" data-toggle="modal" data-target="#modalSantander">
                <i class="fa fa-calculator"></i> Beregn finansiering
            </button>



        </div>

    </div>
    <?php
}