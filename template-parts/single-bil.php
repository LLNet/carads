<?php
get_header();
?>

<?php
global $post;

$connector = new CarAds\Connector();
$product   = $connector->get_single($post->post_name);
$currency  = $connector->getCurrency();
?>
    <div class="outer-wrapper">
        <div class="single-bil--header sticky">
            <div class="container">
                <div class="header--left">
                    <h3 class="name car_name"><?php echo $product->name; ?></h3>
                    <p class="price">
                        <?php
                        echo __('Kontantpris', 'PLUGIN_NAME') . " " . number_format_i18n($product->pricing->{$currency}->price, 0);
                        echo " " . $currency;
                        ?>
                    </p>
                </div>
                <div class="header--right cta">
                    <div class="desktop">
                        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalByttepris">
                            <i class="fa fa-fw fa-calculator"></i> <?php echo __('Beregn byttepris', 'car-ads'); ?>
                        </a>
                        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalBestil">
                            <i class="fa fa-fw fa-car"></i> <?php echo __('Bestil prøvetur', 'car-ads'); ?>
                        </a>
                        <?php
                        if (!empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
                            ?>
                            <a href="#" class="btn btn-primary btn-block js-phone-switch"
                               data-href="tel:+45<?php echo get_option('car-ads-single-car')['phonenumber']; ?>">
                                <span class="text-cta"><i
                                            class="fa fa-fw fa-phone"></i> <?php echo __('Ring til os', 'car-ads'); ?></span>
                                <span class="text-value"><i
                                            class="fa fa-fw fa-phone"></i> Tlf <?php echo get_option('car-ads-single-car')['phonenumber']; ?></span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="mobile">
                        <div>
                            <a href="#" class="btn btn-primary btn-block" data-toggle="modal"
                               data-target="#modalByttepris">
                                <i class="fa fa-fw fa-calculator"></i>
                            </a>
                            <span><?php echo __('Beregn byttepris', 'car-ads'); ?></span>
                        </div>
                        <?php
                        if (!empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
                            ?>
                            <div>
                                <a href="#" class="btn btn-primary btn-block" data-toggle="modal"
                                   data-target="#modalBestil">
                                    <i class="fa fa-fw fa-car"></i>
                                </a>
                                <span><?php echo __('Bestil prøvetur', 'car-ads'); ?></span>
                            </div>
                            <?php
                        }
                        if (!empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['phonenumber'])) {
                            ?>
                            <div>
                                <a href="tel:+45<?php echo get_option('car-ads-single-car')['phonenumber']; ?>"
                                   class="btn btn-primary btn-block">
                                    <i class="fa fa-fw fa-phone"></i>
                                </a>
                                <span><?php echo __('Ring til os', 'car-ads'); ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="single-bil--content">

                <div class="content--col-1">
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                    }
                    ?>
                    <div class="main-slider">
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
                    <div class="pagingInfo">
                        <?php
                        echo "1/" . (count($product->images) + 1);
                        ?>
                    </div>
                    <div class="thumb-slider">
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

                    <div class="mobile">
                        <?php include("components/single-car-quick-details-card.php"); ?>
                    </div>
                    <div class="mobile">
                        <?php include("components/single-car-santander.php"); ?>
                    </div>

                    <div class="accordion" id="Accordion">
                        <div>
                            <div class="card-header" id="Beskrivelse" data-toggle="collapse" data-target="#beskrivelse"
                                 aria-expanded="false" aria-controls="beskrivelse">
                                <span><?php echo __('Beskrivelse', 'car-ads'); ?></span>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                            <div id="beskrivelse" class="card collapse show" aria-labelledby="Beskrivelse"
                                 data-parent="#Accordion">
                                <?php echo $product->description; ?>
                            </div>
                        </div>

                        <div>
                            <div class="card-header" id="specifications" data-toggle="collapse"
                                 data-target="#Specifikationer" aria-expanded="false" aria-controls="Specifikationer">
                                <span><?php echo __('Specifikationer', 'car-ads'); ?></span>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                            <div id="Specifikationer" class="card collapse" aria-labelledby="specifications"
                                 data-parent="#Accordion">
                                <?php include("components/single-car-specifications.php"); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="content--col-2">
                    <div class="desktop">
                        <?php include("components/single-car-quick-details-card.php"); ?>
                    </div>
                    <div class="desktop car-order-1">
                        <?php include("components/single-car-santander.php"); ?>
                    </div>
                    <?php
                    if (!empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['contactform_shortcode'])) {
                        ?>
                        <div class="card">
                            <?php echo do_shortcode(get_option('car-ads-single-car')['contactform_shortcode']); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>


            </div>
        </div>

        <div class="single-bil--content car d-none">
            <div class="car-row no-gutters">
                <aside class="car-col-6">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap">
                            <div>
                                <?php
                                if (property_exists($product, 'image')) {
                                    ?>
                                    <img id="image" src="<?php echo $product->image->sizes->i1024x768 ?>">
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="thumbs-wrap">
                            <?php
                            if (property_exists($product, 'images')) {
                                foreach ($product->images as $key => $image) {
                                    ?>
                                    <a href="!#" class="item-thumb" style="object-fit: contain">
                                        <img src="<?php echo $image->sizes->i150x150 ?>"
                                             onclick="jQuery('#image').attr('src', jQuery(this).data('src'));return false;"
                                             data-src="<?php echo $image->sizes->i1024x768 ?>">
                                    </a>
                                    <?php
                                }
                            }
                            ?>

                        </div> <!-- slider-nav.// -->
                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <main class="car-col-6 border-left">
                    <article class="content-body">

                        <h1 class="title" id="title"><?php echo $product->name; ?></h1>

                        <div class="mb-3">
                            <var class="price h4" id="price">
                                <?php
                                $currency = get_option('car-ads')['currency'];
                                echo number_format_i18n($product->pricing->$currency->price, 2);
                                ?>
                            </var>
                        </div> <!-- price-detail-wrap .// -->

                        <div>
                            <a class="badge badge-info badge-pill"
                               href="/biler/<?php echo $product->brand->slug; ?>">
                                <?php echo $product->brand->name; ?>
                            </a>
                            <a class="badge badge-info badge-pill"
                               href="/biler/<?php echo $product->brand->slug; ?>/<?php echo $product->category->slug; ?>">
                                <?php echo $product->category->name; ?>
                            </a>
                        </div>

                        <p id="snippet">
                            <?php echo $product->snippet; ?>
                        </p>

                        <p id="description">
                            <?php echo $product->description; ?>
                        </p>
                    </article> <!-- product-info-aside .// -->
                </main> <!-- col.// -->
            </div>
            <div class="row">
                <div class="col">

                    <?php
                    $groups = [
                        'specifications' => 'Specifications',
                        'equipent'       => 'Equipment',
                        'leasing'        => 'Leasing',
                        'pricing'        => 'Pricing',
                        'dealer_pricing' => 'Dealer pricing',
                        'tax'            => 'Tax',
                    ];
                    ?>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php
                        $active = true;
                        foreach ($groups as $key => $group) {
                            ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo $active == true ? 'active' : ''; ?>"
                                   id="<?php echo $key; ?>-tab" data-toggle="tab" href="#<?php echo $key; ?>"
                                   role="tab" aria-controls="<?php echo $key; ?>"
                                   aria-selected="true"><?php echo __($group, 'car-ads'); ?></a>
                            </li>
                            <?php
                            $active = false;
                        }
                        ?>
                    </ul>
                    <div class="tab-content" id="myTabContent" style="padding:30px;">

                        <?php
                        $active = true;
                        foreach ($groups as $key => $group) {
                            ?>
                            <div class="tab-pane fade show <?php echo $active == true ? 'active' : ''; ?>"
                                 id="<?php echo $key; ?>" role="tabpanel"
                                 aria-labelledby="<?php echo $key; ?>-tab">
                                <dl class="row">
                                    <?php
                                    if (property_exists($product, 'properties')) {

                                        foreach ($product->properties as $property_key => $property) {
                                            if ($property->private == false and $property->group == $group) {
                                                ?>
                                                <dt class="col-sm-4"><?php echo __($property->name, 'car-ads'); ?></dt>
                                                <dd class="col-sm-8"><?php echo $property->value; ?></dd>
                                                <?php
                                            }
                                        }

                                    }
                                    ?>

                                </dl>
                            </div>
                            <?php
                            $active = false;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modalByttepris" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo __('Byttepris', 'car-ads'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    if (get_option('car-ads-single-car')['byttepris_shortcode']) {
                        echo do_shortcode(get_option('car-ads-single-car')['byttepris_shortcode']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
if (!empty(get_option('car-ads-single-car')) and !empty(get_option('car-ads-single-car')['testdrive_shortcode'])) {
    ?>
    <div class="modal fade" id="modalBestil" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLongTitle"><?php echo __('Bestil prøvetur', 'car-ads'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    if(get_option('car-ads-single-car')['testdrive_shortcode']) {
                        echo do_shortcode(get_option('car-ads-single-car')['testdrive_shortcode']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>

    <script>
        jQuery(function ($) {

            let car_name = jQuery('.car_name').text();
            jQuery('[name="text-601"]').val(car_name);

            $(window).scroll(function () {
                if ($(window).scrollTop() >= 250) {
                    $('.single-bil--header').addClass('fixed-header');
                    jQuery('.single-bil--content').addClass('fixed');
                } else {
                    $('.single-bil--header').removeClass('fixed-header');
                    jQuery('.single-bil--content').removeClass('fixed');
                }
            });

            jQuery('.js-phone-switch').on('click', function (e) {
                e.preventDefault();
                if (jQuery(this).hasClass('active')) {

                    window.location.href = jQuery(this).data('href');
                    return false;

                } else {
                    jQuery(this).addClass('active');
                }
            });


        });
    </script>

<?php


get_footer();