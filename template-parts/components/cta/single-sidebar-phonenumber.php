<?php
if (!$product->disabled && !empty(get_option('car-ads-single-car'))) {
    ?>
    <a href="#"
       class="ca-col-span-1 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline  js-phone-switch"
       data-href="tel:+45<?php echo $product->location->telephone ?? get_option('car-ads-single-car')['phonenumber']; ?>">
        <div class="text-cta ca-block" id="cta_before">
            <i class="fa fa-fw fa-phone"></i>
            <?php echo __('Ring til os', 'car-app'); ?>
        </div>
        <div class="text-value ca-hidden" id="cta_after">
            <i class="fa fa-fw fa-phone"></i>
            <?php echo __('Tlf', 'car-app'); ?> <?php echo $product->location->telephone ?? get_option('car-ads-single-car')['phonenumber']; ?>
        </div>
    </a>
    <?php
}