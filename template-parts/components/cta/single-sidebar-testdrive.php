<?php
$testdrive_sidebar_button = "";
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {

    ob_start();
    $testdrive_display   = !empty(get_option('car-ads-single-car')['testdrive_display']) ? get_option('car-ads-single-car')['testdrive_display'] : 'default';
    $testdrive_link      = !empty(get_option('car-ads-single-car')['testdrive_link']) ? get_option('car-ads-single-car')['testdrive_link'] : '#';
    $testdrive_elementor = !empty(get_option('car-ads-single-car')['testdrive_elementor_shortcode']) ? get_option('car-ads-single-car')['testdrive_elementor_shortcode'] : '0';

    if ($testdrive_display != "disabled") {
        ?>
        <a
            href="<?php echo $testdrive_display == "link" ? $testdrive_link : '#'; ?>" <?php echo $testdrive_display == "link" ? 'target="_blank"' : ''; ?>
            <?php echo $testdrive_display == "elementor" ? 'onClick="elementorProFrontend.modules.popup.showPopup( { id: ' . $testdrive_elementor . ' } );"' : ''; ?>
            class="ca-bg-primary bg-primary ca-rounded ca-h-10 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline
                        <?php echo $testdrive_display == "default" ? 'show-modal' : ''; ?>"
            <?php echo $testdrive_display == "default" ? 'data-target="modalBestil"' : ''; ?>
        >
            <i class="fa fa-fw fa-car"></i> <?php echo __('Bestil prøvetur', 'car-app'); ?>
        </a>
        <?php
    }
    $testdrive_sidebar_button = ob_get_clean();

}
echo apply_filters('car_ads_testdrive_btn_sidebar', $testdrive_sidebar_button);