<div class="leasing ca-opacity-50 ca-font-normal ca-text-base"><?php echo __('Leasing pr. md. fra', 'car-app'); ?></div>
<div class="ca-text-xl md:ca-text-2xl ca-mt-2 lg:ca-mt-0 ca-font-medium">

    <?php
    if ($this->get_field($product->customFields, 'findleasingPriceMonthly') != "" && $this->get_field($product->customFields, 'findleasingPriceMonthly') != "-") {
        echo number_format_i18n($product->get_field($product->customFields, 'findleasingPriceMonthly')) . " " . $this->getCurrency();
    } else {
        echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency();
    }
    ?>

</div>
