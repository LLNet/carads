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

            <div class="modal fade" id="modalSantander" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                Beregn finansiering
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="scbdkdealerexternalcalc"
                                 partnerExternalDealerId="<?php echo $connector->getCustomField('santanderExternalPartnerId'); ?>"
                                 publicApiKey=""
                                 objectType="1"
                                 make="<?php echo get_the_terms(get_the_ID(), 'car_brand')[0]->name; ?>"
                                 model="<?php echo get_the_terms(get_the_ID(), 'car_model')[0]->name; ?>"
                                 variant="<?php echo $connector->get_field($product->properties, 'ModelSeries'); ?>s"
                                 mileage="<?php echo $connector->get_field($product->properties, 'Mileage'); ?>"
                                 firstregistrationdate="<?php echo $connector->get_field($product->properties, 'RegistrationDate'); ?>"
                                 objectPrice="<?php echo $product->pricing->{$currency}->price; ?>"
                                 showaspricelabel="false">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php
}