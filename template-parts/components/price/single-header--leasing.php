<?php
echo __('Leasing pr. md. fra', 'car-app');
echo "&nbsp;";
if ($this->get_field($product->customFields, 'findleasingPriceMonthly') != "" && $this->get_field($product->customFields, 'findleasingPriceMonthly') != "-") {
    echo number_format_i18n($product->get_field($product->customFields, 'findleasingPriceMonthly')) . " " . $this->getCurrency();
} else {
    echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
}