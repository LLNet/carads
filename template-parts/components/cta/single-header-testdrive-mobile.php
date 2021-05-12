<?php
$testdrive_btn_mobile = "";
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {

    ob_start();
    $testdrive_display   = !empty(get_option('car-ads-single-car')['testdrive_display']) ? get_option('car-ads-single-car')['testdrive_display'] : 'default';
    $testdrive_link      = !empty(get_option('car-ads-single-car')['testdrive_link']) ? get_option('car-ads-single-car')['testdrive_link'] : '#';
    $testdrive_elementor = !empty(get_option('car-ads-single-car')['testdrive_elementor_shortcode']) ? get_option('car-ads-single-car')['testdrive_elementor_shortcode'] : '0';

    if ($testdrive_display != "disabled") {
        ?>
        <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
            <a href="<?php echo $testdrive_display == "link" ? $testdrive_link : '#'; ?>"  <?php echo $testdrive_display == "link" ? 'target="_blank"' : ''; ?>
                <?php echo $testdrive_display == "elementor" ? 'onClick="elementorProFrontend.modules.popup.showPopup( { id: ' . $testdrive_elementor . ' } );"' : ''; ?>
                class="ca-mb-2 ca-no-underline ca-bg-primary bg-primary ca-rounded-full ca-text-xl ca-h-10 ca-w-full ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline <?php echo $testdrive_display == "default" ? 'show-modal' : ''; ?>"
                <?php echo $testdrive_display == "default" ? 'data-target="modalBestil"' : ''; ?>
            >
                <span class="car-button-label ca-text-white ca-font-medium ca-text-xs md:ca-text-base ca-mx-1 "><?php echo __('Bestil prøvetur', 'car-app'); ?></span>
            </a>
        </div>
        <?php
    }
    $testdrive_btn_mobile = ob_get_clean();
}

echo apply_filters('car_ads_testdrive_btn_mobile', $testdrive_btn_mobile, $product);