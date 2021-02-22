<div class="leasing ca-opacity-50 ca-font-normal ca-text-base"><?php echo __('Engros', 'car-app'); ?></div>
<div class="ca-text-xl md:ca-text-2xl ca-mt-2 lg:ca-mt-0 ca-font-medium">
    <?php echo number_format_i18n($product->pricing->{$this->getCurrency()}->price) . " " . $this->getCurrency(); ?>
</div>
