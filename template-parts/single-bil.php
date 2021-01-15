<?php
get_header();
?>

<?php
global $post;
$car_ads_id = get_post_meta($post->ID, 'carads_id', true);

$connector = new CarAds\Connector();
$product   = $connector->get_single($car_ads_id);
$currency  = $connector->getCurrency();
?>
    <div class="outer-wrapper">
        <div class="single-bil--header ca-bg-secondary ca-sticky ca-top-0 ca-z-30">
            <div class="ca-container ca-mx-auto lg:ca-flex">
                <div class="single-car--header-left header--left ca-p-2 lg:ca-w-1/2 lg:ca-flex lg:ca-flex-col lg:ca-justify-center">
                    <div>
                        <h3 class="name car_name ca-text-2xl ca-font-medium ca-overflow-ellipsis ca-overflow-hidden"><?php echo $product->name; ?></h3>
                        <p class="price ca-text-sm">
                            <?php
                            if (!$product->disabled) {
                                echo __('Kontantpris', 'car-app') . " " . number_format_i18n($product->pricing->{$currency}->price, 0);
                                echo " " . $currency;
                            } else {
                                echo __('Solgt', 'car-app');
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="single-car--header-right header--right ca-p-2 lg:ca-w-1/2 ca-flex ca-items-center ca-justify-end">
                    <div class="ca-hidden md:ca-flex md:ca-justify-end">
                        <?php
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['byttepris_shortcode'])) {
                            ?>
                            <a href="#"
                               class="ca-no-underline ca-ml-2 ca-px-4 ca-bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white  show-modal"
                               data-target="modalByttepris">
                                <i class="fa fa-fw fa-calculator"></i> <?php echo __('Beregn byttepris', 'car-app'); ?>
                            </a>
                            <?php
                        }
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
                            ?>
                            <a href="#"
                               class="ca-no-underline ca-ml-2 ca-px-4 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white  show-modal"
                               data-target="modalBestil">
                                <i class="fa fa-fw fa-car"></i> <?php echo __('Bestil prøvetur', 'car-app'); ?>
                            </a>
                            <?php
                        }
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
                            ?>
                            <a href="#"
                               class="ca-no-underline ca-ml-2 ca-px-4 ca-bg-primary bg-primary ca-rounded ca-h-10 ca-flex ca-items-center ca-justify-center ca-text-white  js-phone-switch"
                               data-href="tel:+45<?php echo get_option('car-ads-single-car')['phonenumber']; ?>">
                                <span class="text-cta ca-block" id="cta_before"><i
                                            class="fa fa-fw fa-phone"></i><?php echo __('Ring til os', 'car-app'); ?></span>
                                <span class="text-value ca-hidden" id="cta_after"><i
                                            class="fa fa-fw fa-phone"></i> Tlf <?php echo get_option('car-ads-single-car')['phonenumber']; ?></span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="ca-flex ca-justify-between md:ca-hidden">
                        <?php
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['byttepris_shortcode'])) {
                            ?>
                            <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
                                <a href="#"
                                   class="ca-no-underline ca-bg-primary ca-rounded-full ca-text-xl ca-h-14 ca-w-14 ca-flex ca-items-center ca-justify-center ca-text-white show-modal"
                                   data-target="modalByttepris">
                                    <i class="fa fa-fw fa-calculator"></i>
                                </a>
                                <span class="car-button-label ca-text-primary ca-font-medium"><?php echo __('Beregn byttepris', 'car-app'); ?></span>
                            </div>
                            <?php
                        }
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
                            ?>
                            <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
                                <a href="#"
                                   class="ca-no-underline ca-bg-primary ca-rounded-full ca-text-xl ca-h-14 ca-w-14 ca-flex ca-items-center ca-justify-center ca-text-white show-modal"
                                   data-target="modalBestil">
                                    <i class="fa fa-fw fa-car"></i>
                                </a>
                                <span class="car-button-label ca-text-primary ca-font-medium"><?php echo __('Bestil prøvetur', 'car-app'); ?></span>
                            </div>
                            <?php
                        }
                        if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
                            ?>
                            <div class="ca-flex ca-flex-col ca-items-center ca-justify-center ca-w-1/3">
                                <a href="tel:+45<?php echo get_option('car-ads-single-car')['phonenumber']; ?>"
                                   class="single-car--call-us ca-no-underline ca-bg-primary bg-primary ca-rounded-full ca-text-xl ca-h-14 ca-w-14 ca-flex ca-items-center ca-justify-center ca-text-white ">
                                    <i class="fa fa-fw fa-phone"></i>
                                </a>
                                <span class="car-button-label ca-text-primary ca-font-medium"><?php echo __('Ring til os', 'car-app'); ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="ca-container ca-mx-auto">
            <div class="ca-block lg:ca-grid lg:ca-grid-cols-6 ca-gap-4">

                <div class="single-car--col-1 content--col-1 ca-col-span-4 ca-overflow-x-hidden">
                    <?php
                    if (get_option('car-ads-single-car')['show_back_to_archive'] === "yes") {
                        ?>
                        <a href="/<?php echo get_option('car-ads')['archive_slug']; ?>"
                           class="single-car--back-to-list ca-mt-2 ca-mb-2 ca-rounded ca-inline-flex ca-items-center ca-text-secondary text-secondary">
                            <i class="fa fa-fw fa-caret-left"></i>
                            <?php echo __('Tilbage til oversigten', 'car-app'); ?>
                        </a>
                        <?php
                    }

                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs" class="single-car--breadcrumbs">', '</p>');
                    }
                    ?>
                    <div class="single-car--main-slider main-slider ca-relative ca-min-h-64 ca-mt-4">
                        <img src="<?php echo $product->image->sizes->i1024x768 ?>">
                        <?php
                        if (property_exists($product, 'images')) {
                            foreach ($product->images as $key => $image) {
                                ?>
                                <img src="<?php echo $image->sizes->i1024x768 ?>">
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="ca-h-14 ca-my-4 ca-text-primary ca-font-medium ca-text-center ca-flex ca-items-center ca-justify-between">
                        <button class="single-car--slider-prev focus:ca-outline-none focus:ca-ring focus:ca-text-white main-slider-prev slick-prev slick-arrow ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border ca-border-primary ca-rounded-full
                        ca-flex ca-items-center ca-justify-center ca-text-primary ca-transform focus:ca-bg-primary"><i
                                    class="fa fa-fw fa-chevron-left"></i></button>
                        <div class="single-car--slide-page-info pagingInfo">
                            <?php
                            echo "1/" . (count($product->images) + 1);
                            ?>
                        </div>
                        <button class="single-car--slider-next focus:ca-outline-none focus:ca-ring focus:ca-text-white main-slider-next slick-next slick-arrow ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border ca-border-primary ca-rounded-full
                        ca-flex ca-items-center  ca-justify-center ca-text-primary  ca-transform focus:ca-bg-primary"><i
                                    class="fa fa-fw fa-chevron-right"></i></button>
                    </div>
                    <div class="single-car--thumb-slider thumb-slider ca-mb-4">
                        <img src="<?php echo $product->image->sizes->i1024x768 ?>">
                        <?php
                        if (property_exists($product, 'images')) {
                            foreach ($product->images as $key => $image) {
                                ?>
                                <img src="<?php echo str_replace('i1024x768', 'i768x400', $image->sizes->i1024x768) ?>">
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <!--                    <div class="ca-z-50 ca-relative ca-transform ca-transition ca-justify-between ca-items-center ca-ease-in-out-->
                    <!--                    ca-duration-300 ca-opacity-0 lg:ca-opacity-100 ca--translate-y-20 pointer-events-none lg:ca-hidden">-->
                    <!--                        <button id="thumb-prev"-->
                    <!--                                class="slick-prev slick-arrow ca-absolute ca-top-0 ca-left-0 ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border-->
                    <!--                                ca-border-primary ca-rounded-full ca-flex-->
                    <!--                                ca-items-center ca-justify-center ca-text-primary ca-translate ca-transform lg:ca--translate-y-1 xl:ca--translate-y-3 focus:ca-bg-primary lg:ca-flex">-->
                    <!--                            <i class="fa fa-chevron-left"></i></button>-->
                    <!--                        <button id="thumb-next"-->
                    <!--                                class="slick-next slick-arrow ca-absolute ca-top-0 ca-right-0 ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border-->
                    <!--                                ca-border-primary ca-rounded-full ca-flex-->
                    <!--                                ca-items-center ca-justify-center ca-text-primary ca-translate ca-transform lg:ca--translate-y-1 xl:ca--translate-y-3 focus:ca-bg-primary lg:ca-flex">-->
                    <!--                            <i class="fa fa-chevron-right"></i></button>-->
                    <!--                    </div>-->

                    <div class="ca-block lg:ca-hidden">
                        <?php include("components/single-car-quick-details-card.php"); ?>
                    </div>
                    <div class="ca-block lg:ca-hidden">
                        <?php
                        if (!$product->disabled) {
                            include("components/single-car-santander.php");
                        }
                        ?>
                    </div>

                    <div class="accordion" x-data="{selected:1}">
                        <div class="ca-mb-4">
                            <div class="ca-bg-text ca-py-4 ca-px-4 ca-cursor-pointer ca-text-xl ca-text-white ca-font-medium ca-flex ca-justify-between ca-items-center"
                                 id="Beskrivelse" @click="selected !== 1 ? selected = 1 : selected = null">
                                <span><?php echo __('Beskrivelse', 'car-app'); ?></span>
                                <i class="fa fa-chevron-down" x-show="selected != 1"></i>
                                <i class="fa fa-chevron-up" x-show="selected == 1"></i>
                            </div>
                            <div class="ca-bg-lightgrey ca-p-4 md:ca-p-10 ca-relative ca-overflow-hidden ca-transition-all ca-duration-700 ca-animate"
                                 x-show.transition.inout.duration.300ms="selected == 1">
                                <?php echo $product->description; ?>
                            </div>
                        </div>

                        <div class="ca-mb-4">
                            <div class="ca-bg-text ca-py-4 ca-px-4 ca-cursor-pointer ca-text-xl ca-text-white ca-font-medium ca-flex ca-justify-between ca-items-center"
                                 id="specifications" @click="selected !== 2 ? selected = 2 : selected = null">
                                <span><?php echo __('Specifikationer', 'car-app'); ?></span>
                                <i class="fa fa-chevron-down" x-show="selected != 2"></i>
                                <i class="fa fa-chevron-up" x-show="selected == 2"></i>
                            </div>
                            <div class="ca-bg-lightgrey ca-p-4 md:ca-p-10 ca-relative ca-overflow-hidden ca-transition-all ca-duration-700 ca-animate"
                                 x-show.transition.inout.duration.300ms="selected == 2">
                                <?php include("components/single-car-specifications.php"); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="single-car--col-2 content--col-2 ca-col-span-2">
                    <div class="ca-hidden lg:ca-flex lg:ca-mt-4">
                        <?php include("components/single-car-quick-details-card.php"); ?>
                    </div>
                    <div class="ca-hidden lg:ca-flex car-order-1">
                        <?php
                        if (!$product->disabled) {
                            include("components/single-car-santander.php");
                        }
                        ?>
                    </div>
                    <?php
                    /**
                     * FindLeasing
                     */
                    if ($connector->get_field($product->customFields, 'findleasingFinancial') != "") {
                        ?>
                        <div class="single-car--findleasing ca-bg-lightgrey bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4 ca-w-full">
                            <div id="findleasing-sliders-embed-div"
                                 data-findleasing
                                 data-width="100%"
                                 data-id="<?php echo $connector->get_field($product->customFields, 'findleasingFinancial'); ?>"
                                 data-tax=0>
                            </div>
                            <script src="https://www.findleasing.nu/static/javascript/embed-sliders.js"></script>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['contactform_shortcode'])) {
                        ?>
                        <div class="single-car--contact-us ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4 ca-w-full">
                            <?php echo do_shortcode(get_option('car-ads-single-car')['contactform_shortcode']); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>


            </div>
        </div>


    </div>


<?php
include("components/modalByttepris.php");
include("components/modalBestil.php");
include("components/modalSantander.php");

if (!$product->disabled) {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <script>
        jQuery(function ($) {

            /**
             Modals
             */
            jQuery('.show-modal').on('click', function (e) {
                e.preventDefault();
                let target = jQuery(this).data('target');
                jQuery('#' + target).removeClass('ca-hidden');
            });
            jQuery('.close-modal').on('click', function (e) {
                e.preventDefault();
                jQuery(this).closest('.modal').addClass('ca-hidden');
            });

            /**
             * Contactform 7 stuff
             */
            let car_name = jQuery('.car_name').text();
            jQuery('[name="ca-bil"]').val(car_name);
            jQuery('[name="ca-bil"]').attr("value", car_name);
            jQuery('[name="ca-mileage"').val("<?php echo $connector->get_field($product->properties, 'Mileage'); ?>");
            jQuery('[name="ca-mileage"').attr("value", "<?php echo $connector->get_field($product->properties, 'Mileage'); ?>");
            jQuery('[name="ca-year"').val("<?php echo $connector->get_field($product->properties, 'Year'); ?>");
            jQuery('[name="ca-year"').attr("value", "<?php echo $connector->get_field($product->properties, 'Year'); ?>");
            jQuery('[name="ca-price"').val("<?php echo number_format_i18n($product->pricing->DKK->price, 0); ?>");
            jQuery('[name="ca-price"').attr("value", "<?php echo number_format_i18n($product->pricing->DKK->price, 0); ?>");
            jQuery('[name="ca-url"').val("<?php echo $actual_link; ?>");
            jQuery('[name="ca-url"').attr("value", "<?php echo $actual_link; ?>");

            /**
             * Fixed head on scroll
             */
            jQuery(window).scroll(function () {
                if (jQuery(window).scrollTop() >= 250) {
                    jQuery('.single-bil--header').addClass('fixed-header');
                    jQuery('.single-bil--content').addClass('fixed');
                } else {
                    jQuery('.single-bil--header').removeClass('fixed-header');
                    jQuery('.single-bil--content').removeClass('fixed');
                }
            });

            /**
             * Switch button text on click
             */
            jQuery('.js-phone-switch').on('click', function (e) {
                e.preventDefault();
                if (jQuery(this).find('#cta_after').hasClass('ca-block')) {
                    window.location.href = jQuery(this).data('href');
                    return false;
                } else {
                    jQuery(this).find('#cta_before').removeClass('ca-block').addClass('ca-hidden');
                    jQuery(this).find('#cta_after').removeClass('ca-hidden').addClass('ca-block');
                }
            });

        });
    </script>
    <?php
}
get_footer();