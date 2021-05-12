<div class="leasing ca-opacity-50 ca-font-normal ca-text-base"><?php echo __('Leasing pr. md. fra', 'car-app'); ?></div>
<?php
$view_mode = $_COOKIE['car_view'] ?? 'grid';
if(is_single()) {
    $classes = "ca-text-center";
} else {
    if($view_mode == 'grid') {
        $classes = "ca-text-center";
    } else {
        $classes = "ca-text-center lg:ca-text-right";
    }
}
?>
<div class="<?php echo $classes; ?> ca-text-xl md:ca-text-2xl ca-mt-2 lg:ca-mt-0 ca-font-medium">

    <?php
    // carAdsLeasingPrice
    if (!empty($this->get_field($product->customFields, 'carAdsLeasingPrice')) && $this->get_field($product->customFields, 'carAdsLeasingPrice') != "-") {
        // Finansiel price pr month
        if ($price = (int)$this->get_field($product->customFields, 'carAdsLeasingPrice')) {
            echo number_format_i18n($price) . " " . $this->getCurrency();
        } else {
            // Fallback to full price
            echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
        }
    }
    // Findleasing Finansiel
    elseif (!empty($this->get_field($product->customFields, 'findleasingFinancial')) && $this->get_field($product->customFields, 'findleasingFinancial') != "-") {
        // Finansiel price pr month
        if ($price = (int)$this->get_field($product->customFields, 'findleasingFinansielPriceMonthly')) {
            echo number_format_i18n($price) . " " . $this->getCurrency();
        } else {
            // Fallback to full price
            echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
        }
    } // Findleasing Operationel
    elseif (!empty($this->get_field($product->customFields, 'findleasingOperational')) && $this->get_field($product->customFields, 'findleasingOperational') != "-") {
        // Operationel price pr month
        if ($price = (int)$this->get_field($product->customFields, 'findleasingOperationelPriceMonthly')) {
            echo number_format_i18n($price) . " " . $this->getCurrency();
        } else {
            // Fallback to full price
            echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
        }
    }
    // bilinfo pris
    // LeasingPrice <-- properties
    elseif (!empty($this->get_field($product->properties, 'LeasingPrice')) && $this->get_field($product->properties, 'LeasingPrice') != "-") {
        $price = $this->get_field($product->properties, 'LeasingPrice');
        echo number_format_i18n($price) . " " . $this->getCurrency();
    } else {
        echo __('Ikke tilgængelig', 'car-app');
    }
    if(!is_single()) {
        do_action('car_ads_archive_list_below_price', $product);
    }

    ?>

</div>
