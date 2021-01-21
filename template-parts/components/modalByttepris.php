<?php
/**
 * Byttepris Modal
 */
if (get_option('car-ads-single-car')['byttepris_shortcode']) {
    ?>
    <div id="modalByttepris"
         class="modal ca-h-screen ca-w-full ca-fixed ca-left-0 ca-top-0 ca-flex ca-justify-center ca-items-center ca-bg-black ca-bg-opacity-50 ca-hidden ca-z-40">
        <!-- modal -->
        <div class="ca-mx-10 ca-bg-white ca-rounded ca-shadow-lg ca-w-auto ca-overflow-y-auto ca-max-h-screen">
            <!-- modal header -->
            <div class="ca-border-b ca-px-4 ca-py-2 ca-flex ca-justify-between ca-items-center">
                <h3 class="ca-font-semibold ca-text-lg"><?php echo __('Beregn byttepris', 'car-app'); ?></h3>
                <button class="ca-text-black close-modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- modal body -->
            <div class="ca-p-3">
                <?php
                echo do_shortcode(get_option('car-ads-single-car')['byttepris_shortcode']);
                ?>
            </div>
        </div>
    </div>
    <?php
}