<?php
/**
 * Bestil prøvetur modal
 */
if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
    ?>
    <div id="modalBestil"
         class="modal ca-h-screen ca-w-full ca-transition ca-duration-300 ca-ease-in-out ca-fixed ca-left-0 ca-top-0 ca-flex ca-justify-center ca-items-center ca-bg-black ca-bg-opacity-50 ca-hidden ca-z-40">
        <!-- modal -->
        <div class="ca-mx-10 ca-bg-white ca-rounded ca-shadow-xl ca-w-auto ca-transition ca-duration-300 ca-ease-in-out ca-overflow-y-auto ca-max-h-screen">
            <!-- modal header -->
            <div class="ca-border-b ca-px-4 ca-py-2 ca-flex ca-justify-between ca-items-center">
                <h3 class="ca-font-semibold ca-text-lg">
                    <?php
                    echo apply_filters('car_ads_testdrive_model_title', __('Bestil prøvetur', 'car-app'));
                    ?>
                </h3>
                <button class="ca-text-black close-modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- modal body -->
            <div class="ca-p-3">
                <?php
                echo do_shortcode(apply_filters('car_ads_single_car_modal_testdrive', get_option('car-ads-single-car')['testdrive_shortcode']));

                ?>
            </div>
        </div>
    </div>
    <?php
}