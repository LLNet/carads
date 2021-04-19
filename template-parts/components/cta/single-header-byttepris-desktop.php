<?php
$byttepris_btn = "";
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {

    ob_start();

    $byttepris_display   = !empty(get_option('car-ads-single-car')['byttepris_display']) ? get_option('car-ads-single-car')['byttepris_display'] : 'default';
    $byttepris_link      = !empty(get_option('car-ads-single-car')['byttepris_link']) ? get_option('car-ads-single-car')['byttepris_link'] : '';
    $byttepris_elementor = !empty(get_option('car-ads-single-car')['byttepris_elementor_shortcode']) ? get_option('car-ads-single-car')['byttepris_elementor_shortcode'] : '';

    if ($byttepris_display != "disabled") {
        ?>
        <a
                href="<?php echo $byttepris_display == "link" ? $byttepris_link : '#'; ?>" <?php echo $byttepris_display == "link" ? 'target="_blank"' : ''; ?>
            <?php echo $byttepris_display == "elementor" ? 'onClick="elementorProFrontend.modules.popup.showPopup( { id: ' . $byttepris_elementor . ' } );"' : ''; ?>
                class="ca-bg-primary bg-primary ca-rounded ca-ml-2 ca-h-10 ca-px-4 ca-mb-2 ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline
                        <?php echo $byttepris_display == "default" ? 'show-modal' : ''; ?>"
            <?php echo $byttepris_display == "default" ? 'data-target="modalByttepris"' : ''; ?>
        >
            <i class="fa fa-fw fa-calculator"></i> <?php echo __('Beregn byttepris', 'car-app'); ?>
        </a>    
        <?php
    }

    $byttepris_btn = ob_get_clean();
}

echo apply_filters('car_ads_byttepris_btn', $byttepris_btn);