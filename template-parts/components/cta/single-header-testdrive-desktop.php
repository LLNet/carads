<?php
$testdrive_btn = "";
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {

    ob_start();
    $testdrive_display   = !empty(get_option('car-ads-single-car')['testdrive_display']) ? get_option('car-ads-single-car')['testdrive_display'] : 'default';
    $testdrive_link      = !empty(get_option('car-ads-single-car')['testdrive_link']) ? get_option('car-ads-single-car')['testdrive_link'] : '#';
    $testdrive_elementor = !empty(get_option('car-ads-single-car')['testdrive_elementor_shortcode']) ? get_option('car-ads-single-car')['testdrive_elementor_shortcode'] : '0';

    if ($testdrive_display != "disabled") {
        ?>
        <div class="ca-flex ca-flex-col ca-items-center ca-justify-center">
            <a
                    href="<?php echo $testdrive_display == "link" ? $testdrive_link : '#'; ?>" <?php echo $testdrive_display == "link" ? 'target="_blank"' : ''; ?>
                <?php echo $testdrive_display == "elementor" ? 'onClick="elementorProFrontend.modules.popup.showPopup( { id: ' . $testdrive_elementor . ' } );"' : ''; ?>
                    class="show-modal ca-no-underline ca-ml-2 ca-mb-2 ca-px-4 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline <?php echo $testdrive_display == "default" ? 'show-modal' : ''; ?>"
                <?php echo $testdrive_display == "default" ? 'data-target="modalBestil"' : ''; ?>
            >
                <i class="fa fa-fw fa-car"></i> <?php echo __('Bestil prøvetur', 'car-app'); ?>
            </a>
        </div>
        <?php
    }
    $testdrive_btn = ob_get_clean();
}

echo apply_filters('car_ads_testdrive_btn', $testdrive_btn, $product);