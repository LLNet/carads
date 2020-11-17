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
                    <a href="" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalByttepris"><i
                                class="fa fa-fw fa-calculator"></i> Beregn byttepris</a>
                    <a href="" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalBestil"><i
                                class="fa fa-fw fa-car"></i> Bestil prøvetur</a>
                    <a href="" class="btn btn-primary btn-block js-phone-switch" data-href="tel:+4586520033">
                        <span class="text-cta"><i class="fa fa-fw fa-phone"></i> Ring til os</span>
                        <span class="text-value"><i class="fa fa-fw fa-phone"></i> Tlf 86 52 00 33</span>
                    </a>
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

                    <div class="card-header">Beskrivelse</div>
                    <div class="card">

                        <?php echo $product->description; ?>

                    </div>

                    <div class="card-header">Specifikationer</div>
                    <div class="card">

                        <h4>Model</h4>
                        <div class="quick-specs">
                            <dl>
                                <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Effect') . " ";
                                    echo __("hk", 'PLUGIN_NAME');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Model', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'ModelSeries');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Year');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Registreringsår', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'RegistrationDate');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Kilometertal', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php

                                    if ($connector->get_field($product->properties, 'Mileage') != '-') {
                                        echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                                        echo " " . __("km.", 'PLUGIN_NAME');
                                    } else {
                                        _e('-', 'PLUGIN_NAME');
                                    }
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Farve', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Color');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Propellant');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Polstring', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Upholstery');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Polstring farve', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'UpholsteryColor');
                                    ?>
                                </dd>
                            </dl>

                        </div>
                        <hr>

                        <h4>Teknik</h4>
                        <div class="quick-specs">
                            <dl>
                                <dt><?php _e('Acceleration 0 til 100', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Acceleration0To100') . " sek.";
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    switch ($connector->get_field($product->properties, 'GearType')) {
                                        case 'A':
                                            _e('Automatisk', 'PLUGIN_NAME');
                                            break;
                                        case 'M':
                                            _e('Manuel', 'PLUGIN_NAME');
                                            break;
                                        default:
                                            _e('-', 'PLUGIN_NAME');
                                            break;
                                    }
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Topfart', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'TopSpeed') . " km/t";
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Virkning i nm', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'EffectInNm');
                                    ?>
                                </dd>
                            </dl>

                            <dl>
                                <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Effect') . " ";
                                    echo __("hk", 'PLUGIN_NAME');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Max. påhæng', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'TrailerWeight') ? $connector->get_field($product->properties, 'TrailerWeight') : '-';
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Cylindre', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Cylinders');
                                    ?>
                                </dd>
                            </dl>

                        </div>
                        <hr>
                        <h4>Miljø</h4>
                        <div class="quick-specs">

                            <dl>
                                <?php
                                if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                                    ?>

                                    <dt><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
                                    <dd>
                                        <?php
                                        echo $connector->get_field($product->properties, 'Range') . " ";
                                        echo __("km", 'PLUGIN_NAME');
                                        ?>
                                    </dd>

                                    <?php
                                } else {
                                    ?>

                                    <dt><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
                                    <dd>
                                        <?php
                                        echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                                        echo __("km/l", 'PLUGIN_NAME');
                                        ?>
                                    </dd>

                                    <?php
                                }
                                ?>
                            </dl>

                            <dl>
                                <dt><?php _e('Vægtafgift', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php echo $connector->get_field($product->properties, 'WeightTax'); ?>
                                    <?php
                                    if ($connector->get_field($product->properties, 'WeightTaxPeriod')) {
                                        echo "kr. / " . $connector->get_field($product->properties, 'WeightTaxPeriod') . ". måned";
                                    }
                                    ?>
                                </dd>
                            </dl>

                        </div>

                    </div>

                </div>
                <div class="content--col-2">
                    <div class="card">

                        <h1><?php echo $product->name; ?></h1>
                        <hr>

                        <div class="quick-specs">
                            <dl>
                                <dt><?php _e('Kilometer', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php

                                    if ($connector->get_field($product->properties, 'Mileage') != '-') {
                                        echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                                        echo " " . __("km.", 'PLUGIN_NAME');
                                    } else {
                                        _e('-', 'PLUGIN_NAME');
                                    }
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Year');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Propellant');
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <?php
                                if ("El" === $connector->get_field($product->properties, 'Propellant')) {
                                    ?>

                                    <dt><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
                                    <dd>
                                        <?php
                                        echo $connector->get_field($product->properties, 'Range') . " ";
                                        echo __("km", 'PLUGIN_NAME');
                                        ?>
                                    </dd>

                                    <?php
                                } else {
                                    ?>

                                    <dt><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
                                    <dd>
                                        <?php
                                        echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                                        echo __("km/l", 'PLUGIN_NAME');
                                        ?>
                                    </dd>

                                    <?php
                                }
                                ?>
                            </dl>
                            <dl>
                                <dt><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    switch ($connector->get_field($product->properties, 'GearType')) {
                                        case 'A':
                                            _e('Automatisk', 'PLUGIN_NAME');
                                            break;
                                        case 'M':
                                            _e('Manuel', 'PLUGIN_NAME');
                                            break;
                                        default:
                                            _e('-', 'PLUGIN_NAME');
                                            break;
                                    }
                                    ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
                                <dd>
                                    <?php
                                    echo $connector->get_field($product->properties, 'Effect') . " ";
                                    echo __("hk", 'PLUGIN_NAME');
                                    ?>
                                </dd>
                            </dl>
                        </div>
                        <hr>
                        <div class="price d-flex">
                            <p class="price--label">Kontantpris</p>
                            <p class="price--value">
                                <?php
                                echo number_format_i18n($product->pricing->{$currency}->price, 0);
                                echo " " . $currency;
                                ?>
                            </p>
                        </div>

                        <div class="cta">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalByttepris"><i
                                        class="fa fa-fw fa-calculator"></i> Beregn
                                byttepris</a>
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalBestil"><i
                                        class="fa fa-fw fa-car"></i> Bestil prøvetur</a>
                            <a href="#" data-href="tel:+4586520033" class="btn btn-primary js-phone-switch">
                                <span class="text-cta"><i class="fa fa-fw fa-phone"></i> Ring til os</span>
                                <span class="text-value"><i class="fa fa-fw fa-phone"></i> Telefon: 86 52 00 33</span>
                            </a>
                        </div>

                    </div>
                    <?php
                    // Only show santander is car has a santanderPaymentPerMonth value
                    if ($connector->get_field($product->customFields, 'santanderPaymentPerMonth') > 0) {
                        ?>
                        <div class="card santander">

                            <div class="santander--content">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/santander-logo.png">
                                <h4>Finansier med Santander</h4>
                                <ul>
                                    <li>Lån til lav fast eller variabel rente</li>
                                    <li>Fornuftige etableringsomkostninger</li>
                                    <li>Ingen gebyr ved indfrielse af lån</li>
                                </ul>
                                <button class="btn btn-light" data-toggle="modal" data-target="#modalSantander">
                                    <i class="fa fa-calculator"></i> Beregn finansiering
                                </button>

                                <div class="modal fade" id="modalSantander" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Beregn
                                                    finansiering</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="scbdkdealerexternalcalc"
                                                     partnerExternalDealerId="<?php echo $connector->getCustomField('santanderExternalPartnerId'); ?>"
                                                     publicApiKey=""
                                                     objectType="1"
                                                     make="<?php echo get_the_terms(get_the_ID(), 'car_brand')[0]->name; ?>"
                                                     model="<?php echo get_the_terms(get_the_ID(), 'car_model')[0]->name; ?>"
                                                     variant="<?php echo $connector->get_field($product->properties, 'ModelSeries'); ?>s"
                                                     mileage="<?php echo $connector->get_field($product->properties, 'Mileage'); ?>"
                                                     firstregistrationdate="<?php echo $connector->get_field($product->properties, 'RegistrationDate'); ?>"
                                                     objectPrice="<?php echo $product->pricing->{$currency}->price; ?>"
                                                     showaspricelabel="false">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <?php
                    }
                    ?>

                    <div class="card">
                        <?php echo do_shortcode('[contact-form-7 id="5066" title="Skriv besked til os"]'); ?>
                    </div>

                </div>


            </div>
        </div>

        <div class="single-bil--related">

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
                                    <a href="!#" class="item-thumb">
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Byttepris</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBestil" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bestil prøvetur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo do_shortcode('[contact-form-7 id="4075" title="Book en prøvetur"]'); ?>
                </div>
            </div>
        </div>
    </div>


    <script>
        jQuery(function ($) {

            let car_name = jQuery('.car_name').text();
            jQuery('[name="text-601"]').val(car_name);

            $(window).scroll(function () {
                if ($(window).scrollTop() >= 250) {
                    $('.single-bil--header').addClass('fixed-header');
                } else {
                    $('.single-bil--header').removeClass('fixed-header');
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