<?php
// Only show santander is car has a santanderPaymentPerMonth value

if (!$product->disabled
    && $connector->get_field($product->customFields, 'santanderPaymentPerMonth') != '-'
    && $connector->get_field($product->customFields, 'santanderPaymentPerMonth') >= 0) {
    // Is santanderPartnerKey set? use this
    if ($connector->get_field($product->customFields, 'santanderPartnerKey') != '-') {
        $externalPartnerId = $connector->get_field($product->customFields, 'santanderPartnerKey');
    } else {
        // else use partner id from settings
        $externalPartnerId = $connector->getCustomField('santanderExternalPartnerId');
    }
    ?>
    <div id="modalSantander"
         class="modal ca-h-screen ca-w-full ca-fixed ca-left-0 ca-top-0 ca-flex ca-justify-center ca-items-center ca-bg-black ca-bg-opacity-50 ca-hidden ca-z-40">
        <!-- modal -->
        <div class="ca-mx-10 ca-bg-white ca-rounded ca-shadow-lg ca-w-auto md:ca-w-96 ca-overflow-y-auto" style="max-height: 80vh; overflow-y: auto;">
            <!-- modal header -->
            <div class="ca-border-b ca-px-4 ca-py-2 ca-flex ca-justify-between ca-items-center">
                <h3 class="ca-font-semibold ca-text-lg"><?php echo __(' Beregn finansiering', 'car-app'); ?></h3>
                <button class="ca-text-black close-modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- modal body -->
            <div class="ca-p-3 ca-flex ca-justify-center">
                <div id="scbdkdealerexternalcalc"
                     partnerExternalDealerId="<?php echo $externalPartnerId; ?>"
                     publicApiKey=""
                     objectType="1"
                     make="<?php echo get_the_terms(get_the_ID(), 'car_brand')[0]->name; ?>"
                     model="<?php echo get_the_terms(get_the_ID(), 'car_model')[0]->name; ?>"
                     variant="<?php echo $connector->get_field($product->properties, 'ModelSeries'); ?>s"
                     mileage="<?php echo $connector->get_field($product->properties, 'Mileage'); ?>"
                     firstregistrationdate="<?php echo $connector->get_field($product->properties, 'RegistrationDate'); ?>"
                     objectPrice="<?php echo $product->pricing->{$connector->getCurrency()}->price; ?>"
                     showaspricelabel="false">
                </div>
            </div>
        </div>
    </div>
    <?php
}