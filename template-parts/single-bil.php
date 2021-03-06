<?php
get_header();
?>

<?php
global $post;
$car_ads_id = get_post_meta($post->ID, 'carads_id', true);

$product  = $connector->get_single($car_ads_id);
$currency = $connector->getCurrency();
?>
    <div class="outer-wrapper" id="car-ads-top">
        <div class="single-bil--header ca-bg-secondary bg-secondary ca-sticky ca-top-0 ca-z-30">
            <div class="ca-container ca-mx-auto lg:ca-flex">
                <div class="single-car--header-left header--left ca-p-2 lg:ca-w-1/2 ca-flex lg:ca-flex lg:ca-flex-col lg:ca-justify-center">
                    <div class="ca-flex-grow">
                        <h3 class="name car_name ca-text-2xl ca-font-medium ca-overflow-ellipsis ca-overflow-hidden ca-transition-all ca-duration-300 ca-ease-in-out ca-my-0"><?php echo $product->name; ?></h3>
                        <p class="price ca-text-sm ca-p-0 ca-my-0">
                            <?php
                            if (!$product->disabled) {
                                $priceType = $connector->get_field($product->properties, 'PriceType');
                                switch ($priceType) {
                                    case 'RetailPriceWithoutTax':
                                        echo __('Uden afgift', 'car-app') . " " . number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                                        break;
                                    case 'Wholesale':
                                        echo __('Engros', 'car-app') . " " . number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                                        break;
                                    case 'CallForPrice':
                                        echo __('Ring for pris', 'car-app');
                                        break;
                                    case 'Leasing':
                                        $connector->getTemplatePart('components/price/single-header--leasing', $product);
                                        break;
                                    case 'RetailPrice':
                                    case null:
                                    default:
                                        echo __('Kontant pris', 'car-app') . " " . number_format_i18n($product->pricing->{$connector->getCurrency()}->price) . " " . $connector->getCurrency();
                                        break;
                                }
                            } else {
                                echo __('Solgt', 'car-app');
                            }
                            ?>
                        </p>
                    </div>
                    <div class="header--back-to-top ca-hidden ca-flex-grow-0 ca-w-10 ca-items-center ca-justify-center">
                        <a href="#" id="scroll-to-top"
                           class="ca-w-10 ca-h-10 ca-rounded-full ca-bg-primary bg-primary ca-flex ca-items-center ca-justify-center ca-text-white">
                            <i class="fa fa-chevron-up ca-text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="single-car--header-right header--right ca-p-2 lg:ca-w-1/2 ca-flex ca-items-center ca-justify-end">
                    <div class="ca-hidden md:ca-flex md:ca-justify-end ca-w-full">
                        <?php
                        $connector->getTemplatePart('components/cta/single-header-byttepris-desktop', $product);
                        $connector->getTemplatePart('components/cta/single-header-testdrive-desktop', $product);
                        $connector->getTemplatePart('components/cta/single-header-phonenumber-desktop', $product);
                        ?>
                    </div>
                    <div class="ca-flex ca-justify-end ca-w-full md:ca-hidden ca-space-x-1">
                        <?php
                        $connector->getTemplatePart('components/cta/single-header-byttepris-mobile', $product);
                        $connector->getTemplatePart('components/cta/single-header-testdrive-mobile', $product);
                        $connector->getTemplatePart('components/cta/single-header-phonenumber-mobile', $product);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="ca-container ca-mx-auto">
            <div class="ca-block lg:ca-grid lg:ca-grid-cols-6 ca-gap-4">

                <div class="single-car--col-1 content--col-1 ca-col-span-4 ca-overflow-x-hidden">
                    <?php
                    // Show back to archive
                    if (get_option('car-ads-single-car')['show_back_to_archive'] === "yes") {
                        ?>
                        <a href="/<?php echo get_option('car-ads')['archive_slug']; ?>"
                           class="single-car--back-to-list ca-mt-2 ca-mb-2 ca-rounded ca-inline-flex ca-items-center ca-text-secondary text-secondary">
                            <i class="fa fa-fw fa-caret-left"></i>
                            <?php echo __('Tilbage til oversigten', 'car-app'); ?>
                        </a>
                        <?php
                    }
                    // Show breadcrumb from Yoast if available / activated
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs" class="single-car--breadcrumbs ca-p-2 md:ca-p-0">', '</p>');
                    }

                    // Show main slider
                    if ($product->image->sizes->i1024x768 && $product->images) {
                        ?>
                        <div class="ca-relative">
                            <?php
                            if (!empty(get_option('car-ads-theming')['locations'])) {
                                ?>
                                <div class="car--placement ca-absolute ca-top-0 ca-left-0 ca-w-full ca-flex ca-items-center ca-justify-center ca-h-10 ca-bg-white ca-bg-opacity-50 ca-text-black ca-text-sm ca-z-30">
                                    <?php echo __('Placering', 'car-app'); ?>
                                    : <?php echo $product->location->address->city; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="single-car--main-slider carads-main-slider ca-relative ca-min-h-64 ca-mt-4">

                                <a href="<?php echo $product->image->sizes->i1024x768 ?>" data-lightbox="gallery"
                                   data-title="<?php echo $product->name; ?>">
                                    <img src="<?php echo $product->image->sizes->i1024x768 ?>">
                                </a>
                                <?php
                                if (property_exists($product, 'images')) {
                                    foreach ($product->images as $key => $image) {
                                        ?>
                                        <a href="<?php echo $image->sizes->i1024x768 ?>" data-lightbox="gallery"
                                           data-title="<?php echo $product->name; ?>"><img
                                                    src="<?php echo $image->sizes->i1024x768 ?>" loading="lazy"></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                    } // Show "no image"
                    else {
                        ?>
                        <div class="single-car--main-slider ca-relative ca-min-h-64 ca-mt-4">
                            <a href="/wp-content/plugins/car-app/assets/noImageBig.jpg" data-lightbox="gallery"
                               data-title="<?php echo __('Der er desv??rre ikke et billede af bilen endnu', 'car-app'); ?>">
                                <img src="/wp-content/plugins/car-app/assets/noImageBig.jpg">
                            </a>
                        </div>
                        <?php
                    }

                    // Thumbslider and image count
                    if (property_exists($product, 'images')) {
                        ?>
                        <div class="ca-h-14 ca-my-4 ca-text-primary ca-font-medium ca-text-center ca-flex ca-items-center ca-justify-between">
                            <button class="single-car--slider-prev focus:ca-outline-none focus:ca-ring focus:ca-text-white main-slider-prev slick-prev slick-arrow ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border ca-border-primary ca-rounded-full ca-ml-1
                        ca-flex ca-items-center ca-justify-center ca-text-primary ca-transform focus:ca-bg-primary border-primary text-primary focus:text-primary">
                                <i class="fa fa-fw fa-chevron-left"></i>
                            </button>
                            <div class="single-car--slide-page-info pagingInfo ca-text-primary text-primary">
                                <?php
                                echo "1/" . (count($product->images) + 1);
                                ?>
                            </div>
                            <button class="single-car--slider-next focus:ca-outline-none focus:ca-ring focus:ca-text-white main-slider-next slick-next slick-arrow ca-z-20 ca-h-14 ca-w-14 ca-bg-white ca-border ca-border-primary ca-rounded-full ca-mr-1
                        ca-flex ca-items-center ca-justify-center ca-text-primary ca-transform focus:ca-bg-primary border-primary text-primary focus:text-primary">
                                <i class="fa fa-fw fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="single-car--thumb-slider carads-thumb-slider ca-mb-4">
                            <img src="<?php echo $product->image->sizes->i1024x768 ?>"
                                 class="ca-object-cover ca-max-h-20 md:ca-max-h-32 ca-h-full">
                            <?php
                            foreach ($product->images as $key => $image) {
                                ?>
                                <img src="<?php echo str_replace('i1024x768', 'i768x400', $image->sizes->i1024x768) ?>"
                                     loading="lazy" class="ca-object-cover ca-max-h-20 md:ca-max-h-32 ca-h-full">
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="ca-block lg:ca-hidden">
                        <?php
                        $connector->getTemplatePart('components/single-car-quick-details-card', $product);
                        ?>
                    </div>
                    <?php do_action('car_ads_below_quick_car_details'); ?>
                    <div class="ca-block lg:ca-hidden ca-w-full">
                        <?php dynamic_sidebar('carads-single-sidebar-1'); ?>
                    </div>
                    <div class="ca-block lg:ca-hidden">
                        <?php

                        if (!$product->disabled) {
                            $connector->getTemplatePart('components/single-car-santander', $product);
                        }
                        ?>
                    </div>
                    <div class="ca-block lg:ca-hidden ">
                        <?php dynamic_sidebar('carads-single-sidebar-2'); ?>
                    </div>
                    <div class="car-ads--accordion"
                         x-data="{<?php echo apply_filters('car_ads_accordion_tabs', 'description:1, specifications:1'); ?>}">
                        <div class="ca-mb-4">
                            <div class="car-ads--accordion-title ca-bg-text bg-secondary ca-py-4 ca-px-4 ca-cursor-pointer ca-text-xl ca-text-white ca-font-medium ca-flex ca-justify-between ca-items-center"
                                 id="Beskrivelse" @click="description !== 1 ? description = 1 : description = 0">
                                <span><?php echo __('Beskrivelse', 'car-app'); ?></span>
                                <i class="fa fa-chevron-down" x-show="description != 1"></i>
                                <i class="fa fa-chevron-up" x-show="description == 1"></i>
                            </div>
                            <div class="car-ads--accordion-content ca-bg-lightgrey ca-p-4 md:ca-p-10 ca-relative ca-overflow-hidden ca-transition-all ca-duration-700 ca-animate"
                                 x-show.transition.inout.duration.300ms="description == 1">
                                <?php echo $product->description; ?>
                            </div>
                        </div>

                        <div class="ca-mb-4">
                            <div class="car-ads--accordion-title ca-bg-text bg-secondary ca-py-4 ca-px-4 ca-cursor-pointer ca-text-xl ca-text-white ca-font-medium ca-flex ca-justify-between ca-items-center"
                                 id="specifications"
                                 @click="specifications !== 1 ? specifications = 1 : specifications = 0">
                                <span><?php echo __('Specifikationer', 'car-app'); ?></span>
                                <i class="fa fa-chevron-down" x-show="specifications != 1"></i>
                                <i class="fa fa-chevron-up" x-show="specifications == 1"></i>
                            </div>
                            <div class="car-ads--accordion-content ca-bg-lightgrey ca-p-4 md:ca-p-10 ca-relative ca-overflow-hidden ca-transition-all ca-duration-700 ca-animate"
                                 x-show.transition.inout.duration.300ms="specifications == 1">
                                <?php include("components/single-car-specifications.php"); ?>
                            </div>
                        </div>

                        <?php
                        do_action('car_ads_accordion_content', $product);
                        ?>

                    </div>
                    <div class="ca-block lg:ca-hidden">
                        <?php dynamic_sidebar('carads-single-sidebar-3'); ?>
                    </div>
                </div>
                <div class="single-car--col-2 content--col-2 ca-col-span-2">
                    <div class="ca-hidden lg:ca-flex lg:ca-mt-4">
                        <?php
                        $connector->getTemplatePart('components/single-car-quick-details-card', $product);
                        ?>
                    </div>
                    <div class="ca-hidden lg:ca-flex">
                        <?php dynamic_sidebar('carads-single-sidebar-1'); ?>
                    </div>
                    <div class="ca-hidden lg:ca-flex car-order-1">
                        <?php
                        if (!$product->disabled) {
                            $connector->getTemplatePart('components/single-car-santander', $product);
                        }
                        ?>
                    </div>
                    <div class="ca-hidden lg:ca-flex">
                        <?php dynamic_sidebar('carads-single-sidebar-2'); ?>
                    </div>
                    <?php
                    // FindLeasing - Show financial first, then if financial is not available show operational if available
                    if ($connector->get_field($product->customFields, 'findleasingFinancial') != "" && $connector->get_field($product->customFields, 'findleasingFinancial') != "-") {
                        ?>
                        <div class="single-car--findleasing ca-bg-lightgrey bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">
                            <div id="findleasing-sliders-embed-div"
                                 data-findleasing
                                 data-width="100%"
                                 data-id="<?php echo $connector->get_field($product->customFields, 'findleasingFinancial'); ?>"
                                 data-tax="0">
                            </div>
                            <script src="https://www.findleasing.nu/static/javascript/embed-sliders.js"></script>
                        </div>
                        <?php

                    } elseif ($connector->get_field($product->customFields, 'findleasingOperational') != "" && $connector->get_field($product->customFields, 'findleasingOperational') != "-") {
                        ?>
                        <div class="single-car--findleasing ca-bg-lightgrey bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">
                            <div id="findleasing-sliders-embed-div"
                                 data-findleasing
                                 data-width="100%"
                                 data-id="<?php echo $connector->get_field($product->customFields, 'findleasingOperational'); ?>"
                                 data-tax="0">
                            </div>
                            <script src="https://www.findleasing.nu/static/javascript/embed-sliders.js"></script>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="ca-hidden lg:ca-flex">
                        <?php dynamic_sidebar('carads-single-sidebar-3'); ?>
                    </div>
                    <?php
                    // Contact form
                    if (!$product->disabled && !empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['contactform_shortcode'])) {
                        ?>
                        <div class="single-car--contact-us ca-bg-white bg-lightgrey ca-p-4 ca-border ca-border-lightgrey ca-border-solid ca-mb-4">
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
            jQuery('[name="ca-location"').val("<?php echo $product->location->address->city; ?>");
            jQuery('[name="ca-location"').attr("value", "<?php echo $product->location->address->city; ?>");
            jQuery('[name="ca-department-email"').val("<?php echo $product->location->email; ?>");
            jQuery('[name="ca-department-email"').attr("value", "<?php echo $product->location->email; ?>");
            jQuery('[name="ca-year"').val("<?php echo $connector->get_field($product->properties, 'Year'); ?>");
            jQuery('[name="ca-year"').attr("value", "<?php echo $connector->get_field($product->properties, 'Year'); ?>");
            jQuery('[name="ca-price"').val("<?php echo number_format_i18n($product->pricing->DKK->price, 0); ?>");
            jQuery('[name="ca-price"').attr("value", "<?php echo number_format_i18n($product->pricing->DKK->price, 0); ?>");
            jQuery('[name="ca-url"').val("<?php echo $actual_link; ?>");
            jQuery('[name="ca-url"').attr("value", "<?php echo $actual_link; ?>");
            /**
             * Fixed head on scroll
             */

            let single_car_quick_details = jQuery(".single-car--quick-details")
            let single_car_header_right = jQuery(".single-car--header-right")
            let single_car_quick_details_top = single_car_quick_details.offset().top;
            let single_car_quick_details_height = single_car_quick_details.outerHeight();

            jQuery(window).scroll(function () {
                if (jQuery(window).scrollTop() > (single_car_quick_details_top + single_car_quick_details_height)) {
                    single_car_quick_details.addClass('fixed-header');
                    if (jQuery(window).width < 768) {
                        single_car_header_right.fadeOut();
                    }
                } else {
                    single_car_quick_details.removeClass('fixed-header');
                    if (jQuery(window).width < 768) {
                        single_car_header_right.fadeIn();
                    }
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