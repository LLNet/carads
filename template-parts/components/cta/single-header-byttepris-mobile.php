<?php
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {
    $byttepris_display   = !empty(get_option('car-ads-single-car')['byttepris_display']) ? get_option('car-ads-single-car')['byttepris_display'] : 'default';
    $byttepris_link      = !empty(get_option('car-ads-single-car')['byttepris_link']) ? get_option('car-ads-single-car')['byttepris_link'] : '#';
    $byttepris_elementor = !empty(get_option('car-ads-single-car')['byttepris_elementor_shortcode']) ? get_option('car-ads-single-car')['byttepris_elementor_shortcode'] : '0';

    if ($byttepris_display != "disabled") {
        ?>
        <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
            <a href="<?php echo $byttepris_display == "link" ? $byttepris_link : '#'; ?>" <?php echo  $byttepris_display == "link" ? 'target="_blank"' : ''; ?>
                <?php echo $byttepris_display == "elementor" ? 'onClick="elementorProFrontend.modules.popup.showPopup( { id: ' . $byttepris_elementor . ' } );"' : ''; ?>
                class="ca-mb-2 show-modal ca-no-underline ca-bg-primary bg-primary ca-rounded-full ca-text-xl ca-h-10 ca-w-full ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline  <?php echo $byttepris_display == "default" ? 'show-modal' : ''; ?>"
                <?php echo $byttepris_display == "default" ? 'data-target="modalByttepris"' : ''; ?>
            >
                <i class="fa fa-fw fa-calculator"></i>
                <span class="car-button-label ca-text-white ca-font-medium ca-text-xs md:ca-text-base ca-mx-1 "><?php echo __('Beregn byttepris', 'car-app'); ?></span>
            </a>
        </div>
        <?php
    }
}