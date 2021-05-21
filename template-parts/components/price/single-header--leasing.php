<?php
echo __('Leasing pr. md. fra: ', 'car-app');
echo "&nbsp;";
if ($this->get_field($product->customFields, 'carAdsLeasingActive')) {
    // carAdsLeasingPrice
    if ($price = (int)$this->get_field($product->customFields, 'carAdsLeasingPrice')) {
        echo number_format_i18n($price) . " " . $this->getCurrency();
    } else {
        // Fallback to full price
        echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
    }
} else {

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
}
