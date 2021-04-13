<?php
if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
    ?>
    <a href="#"
       class="ca-no-underline ca-ml-2 ca-px-4 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white hover:ca-text-white hover:ca-no-underline js-phone-switch"
       data-href="tel:+45<?php echo $product->location->telephone ?? get_option('car-ads-single-car')['phonenumber']; ?>">
                                <span class="text-cta ca-block" id="cta_before"><i
                                        class="fa fa-fw fa-phone"></i><?php echo __('Ring til os', 'car-app'); ?></span>
        <span class="text-value ca-hidden" id="cta_after"><i
                class="fa fa-fw fa-phone"></i> Tlf <?php echo $product->location->telephone ?? get_option('car-ads-single-car')['phonenumber']; ?></span>
    </a>
    <?php
}