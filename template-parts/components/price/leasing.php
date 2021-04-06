<div class="leasing ca-opacity-50 ca-font-normal ca-text-base"><?php echo __('Leasing pr. md. fra', 'car-app'); ?></div>
<div class="ca-text-xl md:ca-text-2xl ca-mt-2 lg:ca-mt-0 ca-font-medium">

    <?php
    // Findleasing Finansiel
    if (!empty($this->get_field($product->customFields, 'findleasingFinancial')) && $this->get_field($product->customFields, 'findleasingFinancial') != "-") {
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
            echo number_format_i18n($product->get_field($product->customFields, 'findleasingOperationelPriceMonthly')) . " " . $this->getCurrency();
        } else {
            // Fallback to full price
            echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
        }
    } else {
        echo __('Ikke tilgængelig', 'car-app');
    }
    ?>

</div>
