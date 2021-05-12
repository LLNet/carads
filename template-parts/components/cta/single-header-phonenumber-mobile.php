<?php
if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
    ?>
    <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
        <a href="tel:+45<?php echo $product->location->telephone ?? get_option('car-ads-single-car')['phonenumber']; ?>"
           class="ca-mb-2 single-car--call-us ca-no-underline ca-bg-primary bg-primary ca-rounded-full ca-text-xl ca-h-10 ca-w-full ca-flex ca-items-center ca-justify-center hover:ca-text-white hover:ca-no-underline ca-text-white ">
            <span class="car-button-label ca-text-white ca-font-medium ca-text-xs md:ca-text-base ca-mx-2 "><?php echo __('Ring til os', 'car-app'); ?></span>
        </a>
    </div>
    <?php
}