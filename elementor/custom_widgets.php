<?php

namespace Indexed;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use Elementor\Plugin;

add_action('elementor/widgets/widgets_registered', function () {

    require_once('widgets/carads-slider.php');
    Plugin::instance()->widgets_manager->register_widget_type(new CarAdsSlider());

    require_once('widgets/carads-list-grid.php');
    Plugin::instance()->widgets_manager->register_widget_type(new CarAdsListGrid());

});
