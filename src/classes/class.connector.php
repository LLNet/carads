<?php

namespace CarAds;

use \Indexed\Headless\Request;
use \DateTime;

class Connector
{
    /**
     * @var string
     */
    private $post_type = "bil";

    /**
     * @var
     */
    public $currency;

    /**
     * @var Request
     */
    private $headless;

    /**
     * @var mixed
     */
    private $ck;

    /**
     * @var mixed
     */
    private $cs;

    /**
     * @var mixed
     */
    private $pt;

    /**
     * @var string
     */
    private $api_endpoint;

    /**
     * @var Connector
     */
    private $localizedApi;

    /**
     * @var mixed
     */
    private $language;

    /**
     * @var
     */
    private $vat;


    /**
     * Connector constructor.
     * @param bool $ck
     * @param bool $cs
     * @param bool $pt
     */

    public function __construct($ck = false, $cs = false, $pt = false)
    {
        $this->api_endpoint = "https://api.carads.io/v1";

        if (!empty($ck) && !empty($cs) && !empty($pt)) {
            $this->ck = $ck;
            $this->cs = $cs;
            $this->pt = $pt;
        } else {
            $this->ck = get_option('car-ads')['consumer_key'];
            $this->cs = get_option('car-ads')['consumer_secret'];
            $this->pt = get_option('car-ads')['public_token'];
        }
        // Setup Headless API object
        $headless = new Request($this->ck, $this->cs, $this->pt);
        $headless->useCache(true);
        $headless->setUrl($this->api_endpoint);
        $this->headless = $headless;

        // Add actions on cronjob action
        add_action('car-ads', [$this, 'synchronize']);
        //add_action('car-ads', [$this, 'clean_up_non_existing_cars']);


        if ($_REQUEST['syncmanual'] == "1") {
            delete_option('_carads_last_updated');
            add_action('init', [$this, 'synchronize']);
            add_action('admin_notices', [$this, 'admin_notice']);
        }
        if ($_REQUEST['syncmanual'] == "2") {
            add_action('car-ads', [$this, 'clean_up_non_existing_cars']);
            add_action('admin_notices', [$this, 'admin_notice']);
        }


        add_action('wp_ajax_nopriv_pre_search', [$this, 'pre_search']);
        add_action('wp_ajax_pre_search', [$this, 'pre_search']);
    }

    public function admin_notice()
    {
        echo '<div class="notice notice-info is-dismissible">
             <p>CarAds.io: Done!</p>
         </div>';
    }

    public function getCurrency()
    {
        if (empty($this->currency)) {
            $this->setLocalizedApi();
        }
        return $this->currency;
    }

    /**
     * Setting localized API based on
     * WordPress' get_locale() function
     */
    public function setLocalizedApi()
    {

        if (false === ($cached = get_transient('CarAds_setLocalizedApi'))) {
            // It wasn't there, so regenerate the data and save the transient
            $locale = substr(get_locale(), 0, 2);
            // loop for at finde website med sprog = get_locale()
            $websites = $this->headless->get("/websites");

            if (!empty($websites->items)) {
                foreach ($websites->items as $key => $site) {

                    if ($site->language === $locale) {
                        set_transient('CarAds_setLocalizedApi', $site, 1 * DAY_IN_SECONDS);
                        // Set localized API object
                        $this->localizedApi = new Connector($site->consumerKey, $site->consumerSecret, $site->publicToken);
                        $this->language     = $site->language;
                        $this->vat          = $site->vat;
                        $this->currency     = $site->currency;
                    }
                }
            }
        } else {
            $cache              = get_transient('CarAds_setLocalizedApi');
            $this->localizedApi = new Connector($cache->consumerKey, $cache->consumerSecret, $cache->publicToken);;
            $this->language = $cache->language;
            $this->vat      = $cache->vat;
            $this->currency = $cache->currency;
        }


    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCustomField($name)
    {

        if (false === ($cached = get_transient('CarAds_customfield_' . $name))) {
            // It wasn't there, so regenerate the data and save the transient
            $settings     = $this->headless->get("/settings");
            $customFields = $settings->customFields;
            foreach ($customFields as $key => $customField) {
                if ($customField->name === $name) {
                    set_transient('CarAds_customfield_' . $name, $customField->value, 1 * DAY_IN_SECONDS);
                    return get_transient('CarAds_customfield_' . $name);
                }
            }

        } else {
            return get_transient('CarAds_customfield_' . $name);
        }
    }

    public function getTemplatePart($filename, $product)
    {
        $currentTheme    = get_template_directory();
        $plugin_dir_path = __CAR_ADS_DIR__ . "template-parts/";

        if (file_exists($currentTheme . "/car-app/" . $filename . ".php")) {
            include $currentTheme . "/car-app/" . $filename . ".php";
        } else {
            include $plugin_dir_path . $filename . ".php";
        }
    }


    /**
     * Synchronize cars from CarAds.io
     * @return false
     */
    public function synchronize()
    {
        // Set timelimits
        ini_set('max_execution_time', 900);
        set_time_limit(900);

        $offset = "?size=50" . $this->includeOptions();

        if (get_option('_carads_last_updated')) {
            $offset .= "&updated[gte]=" . urlencode(get_option('_carads_last_updated'));
        } else {
            $offset .= "&created[lte]=" . urlencode(date("Y-m-d H:i:s"));
        }

        do {

            $products = $this->headless->get("/products" . $offset);
            $offset   = $products->navigation->next ?? '';

            if (property_exists($products, 'error')) {
                return false;
            }

            foreach ($products->items as $key => $product) {

                $post_id = $this->get_product_by_external_id($product->id);

                // if car does not exist
                if ($post_id) {
                    $car = get_post($post_id);

                    try {
                        //if (new DateTime($product->updated) > new DateTime($car->post_modified)) { @FIXME Skip modified check
                        $this->update($car->ID, $product);
                        //}
                    } catch (\Exception $e) {
                        error_log($e->getMessage());
                    }

                } else {
                    $this->create($product);
                }

            }

        } while (!empty($offset));

        // Update last updated timestamp
        update_option('_carads_last_updated', date("Y-m-d H:i:s"));

    }

    /**
     * @param $external_id
     * @return int
     */
    public function get_product_by_external_id($external_id)
    {
        global $wpdb;
        return intval(
            $wpdb->get_var(
                "SELECT P.*, M.post_id 
                FROM `" . $wpdb->postmeta . "` M  
                LEFT JOIN `" . $wpdb->posts . "` P ON M.post_id = P.ID 
                WHERE M.`meta_key` = 'carads_id' AND M.`meta_value` = '" . $external_id . "'"
            )
        );

    }

    /**
     * removes cars that are no longer in carads.io
     */
    public function clean_up_non_existing_cars()
    {
        // Get all slugs
        $offset = "?size=50";
        $slugs  = [];
        do {

            $products = $this->headless->get("/products" . $offset);
            $offset   = $products->navigation->next ?? '';

            foreach ($products->items as $key => $product) {
                $slugs[] = $product->slug;
            }

        } while (!empty($offset));

        // Loop through local cars and delete cars that are not in CarAds.io
        global $wpdb;

        $cars = $wpdb->get_results("SELECT ID, post_title, post_name 
                FROM `" . $wpdb->posts . "` 
                WHERE `post_type` = '" . $this->post_type . "' 
                AND (`post_status` = 'draft' OR `post_status` = 'publish' OR `post_status` = 'trash')", ARRAY_A);

        foreach ($cars as $key => $car) {
            print_r(get_post_meta($car['ID'], 'slug', true));
            print " = ";
            var_dump(in_array(get_post_meta($car['ID'], 'slug', true), $slugs));
            print "<br>";
            if (in_array(get_post_meta($car['ID'], 'slug', true), $slugs)) {
                continue;
            } else {
                $this->remove($car['ID']);
            }

        }
        die();
    }

    /**
     * @param $product
     * @return bool
     */
    public function create($product)
    {
        try {

            $variant = str_replace('variant-', '', $this->get_field($product->properties, 'Variant'));
            $page    = wp_insert_post([
                'post_type'         => $this->post_type,
                'post_title'        => $product->name,
                'post_name'         => $variant . "-" . $this->get_field($product->properties, 'Id'),
                'post_modified'     => $product->updated,
                'post_modified_gmt' => $product->updated,
                'post_status'       => 'publish',
                'meta_input'        => [
                    'carads_id'                        => $product->id,
                    'slug'                             => $product->slug,
                    '_yoast_wpseo_meta-robots-noindex' => 1
                ]
            ]);
            // Add brand and model
            wp_set_object_terms($page, $product->brand->name, 'car_brand');
            wp_set_object_terms($page, $product->category->name, 'car_model');

            return $page;

        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    /**
     * @param $post_id
     * @param $data
     * @return bool
     */
    public function update($post_id, $data)
    {
        try {
            $variant = str_replace('variant-', '', $this->get_field($data->properties, 'Variant'));
            $updated = wp_update_post([
                'ID'         => $post_id,
                'post_name'  => $variant . "-" . $this->get_field($data->properties, 'Id'),
                'post_title' => $data->name,
            ]);

            update_post_meta($post_id, 'carads_id', $data->id);
            update_post_meta($post_id, 'slug', $data->slug);
            update_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', 1);

            // Add brand and model
            wp_set_object_terms($post_id, $data->brand->name, 'car_brand');
            wp_set_object_terms($post_id, $data->category->name, 'car_model');

            if ($updated) {
                return true;
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    /**
     * @param $post_id
     */
    public function remove($post_id)
    {
        //wp_trash_post($post_id);
    }

    /**
     * @param $carads_id
     * @return mixed
     */
    public function get_single($carads_id)
    {
        return $this->headless->get('/products/' . $carads_id);
    }

    /**
     * @param bool $all
     * @return mixed
     * @throws \Exception
     */
    public function search($all = false)
    {

        $search = '?filter';
        if ($all === false) {

            // Brands
            if (isset($_GET['brands']) && !empty($_GET['brands'])) {
                foreach ($_GET['brands'] as $slug) {
                    $search .= '&brands[]=' . $slug;
                }
            }
            if (!empty(get_query_var('car_brand'))) {
                $search .= '&brands[]=' . get_query_var('car_brand');
            }

            // Categories
            if (isset($_GET['categories']) && !empty($_GET['categories'])) {
                foreach ($_GET['categories'] as $slug) {
                    $search .= '&categories[]=' . $slug;
                }
            }
            if (!empty(get_query_var('car_model'))) {
                $search .= '&categories[]=' . get_query_var('car_model');
            }

            // Properties
            if (isset($_GET['properties']) && !empty($_GET['properties'])) {
                foreach ($_GET['properties'] as $slug) {
                    $search .= '&properties[]=' . $slug;
                }
            }
            // Free search
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search .= '&q=' . urlencode($_GET['search']);
            }

            //        if (!empty($_GET['size'])) {
            //            $search .= '&size=' . $_GET['size'];
            //        }
            if (!empty($_GET['offset'])) {
                $search .= '&offset=' . (int)$_GET['offset'];
            }

            // Min Max Pricing
            if (!empty($_GET['pricingMinMax'])) {
                // Make sure mileage has indeed been set, before sending to api.
                $min = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->min;
                $max = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->max;

                $pricingMinMaxValue = (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) ? $_GET['pricingMinMax'] : '';

                $values = explode(",", $pricingMinMaxValue);
                if ($min != $values[0] || $max != $values[1]) {
                    $search .= '&pricingMin=' . $values[0];
                    $search .= '&pricingMax=' . $values[1];
                }
            }

            if (!empty($_GET['mileageMinMax'])) {
                // Make sure mileage has indeed been set, before sending to api.
                $mileageMinMaxValues = $this->getCustomFieldAggregation('mileage');
                $mileageMinMaxValue  = (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) ? $_GET['mileageMinMax'] : '';
                $sliderMileage       = explode(",", $mileageMinMaxValue);

                if ($mileageMinMaxValues->min != $sliderMileage[0] || $mileageMinMaxValues->max != $sliderMileage[1]) {

                    // Syntax: customFields[mileage][gte]=10000&customFields[mileage][lte]=50000
                    $search .= '&customFields[mileage][gte]=' . $sliderMileage[0];
                    $search .= '&customFields[mileage][lte]=' . $sliderMileage[1];
                }
            }

            // Sorting
            if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
                $search .= '&sort_by=' . $_GET['sort_by'];
            }

        }

        $products = $this->headless->get('/products' . $search . $this->includeOptions() . $this->includePriceType());

        if (isset($products->error)) {
            throw new \Exception($products->items);
        }

        return $products;
    }

    /**
     * Add search property to filter cars based on priceType. Default is "all"
     */
    public function includePriceType()
    {
        // PriceType
        $price_type = get_option('car-ads-archive')['usePriceType'] ?? 'all';
        if (!is_null($price_type) && $price_type !== "all") {
            return '&properties[]=' . strtolower($price_type);
        }
    }

    public function filters(): array
    {

        $filters = [];

        if (!empty(get_query_var('car_brand'))) {
            $filters['brands'][] = get_query_var('car_brand');
        }
        if (!empty(get_query_var('car_model'))) {
            $filters['categories'][] = get_query_var('car_model');
        }
        if (isset($_GET['pricingMin']) && !empty($_GET['pricingMin']) && $_GET['pricingMin'] != '-1') {
            $filters['pricingMin'] = $_GET['pricingMin'];
        }
        if (isset($_GET['pricingMax']) && !empty($_GET['pricingMax']) && $_GET['pricingMax'] != '-1') {
            $filters['pricingMax'] = $_GET['pricingMax'];
        }
        if (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax']) && $_GET['pricingMinMax'] != '-1') {

            // Make sure mileage has indeed been set, before sending to api.
            $min = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->min;
            $max = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->max;

            $pricingMinMaxValue = (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) ? $_GET['pricingMinMax'] : '';

            $values = explode(",", $pricingMinMaxValue);
            if ($min != $values[0] || $max != $values[1]) {
                $filters['pricingMinMax'] = $_GET['pricingMinMax'];
            }

        }
        if (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax']) && $_GET['mileageMinMax'] != '-1') {
            // Make sure mileage has indeed been set, before sending to api.
            $mileageMinMaxValues = $this->getCustomFieldAggregation('mileage');
            $mileageMinMaxValue  = (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) ? $_GET['mileageMinMax'] : '';
            $sliderMileage       = explode(",", $mileageMinMaxValue);

            if ($mileageMinMaxValues->min != $sliderMileage[0] || $mileageMinMaxValues->max != $sliderMileage[1]) {

                $filters['mileageMinMax'] = $_GET['mileageMinMax'];
            }


        }
        if (isset($_GET['brands']) && !empty($_GET['brands']) && $_GET['brands'][0] != '-1') {
            $filters['brands'] = $_GET['brands'];
        }
        if (isset($_GET['properties']) && !empty($_GET['properties'])) {
            foreach ($_GET['properties'] as $property) {
                if ($property != '-1') {
                    $filters['properties'][] = $property;
                }
            }
        }
        if (isset($_GET['categories']) && !empty($_GET['categories']) && $_GET['categories'][0] != '-1') {
            $filters['categories'] = $_GET['categories'];
        }
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }

        return $filters;

    }

    public function getMinMaxPrice()
    {
        $products = $this->headless->get("/products?size=1" . $this->includeOptions());
        if (isset($products->error)) {
            throw new \Exception($products->items);
        }

        return $products;
    }

    /**
     * @param $fieldName
     * @param false $includeCount
     * @return mixed
     */
    public function getCustomFieldAggregation($fieldName, $includeCount = false)
    {
        $data = $this->headless->get("/products?aggregationMinMaxAvg=customFields." . $fieldName . ($includeCount == true ? 'aggregationCount=customFields.' . $fieldName : ''));

        return $data->aggregations->global->customFields->{$fieldName};

    }

    public function pre_search()
    {

        $data = $_POST['data'];

        $params = array();
        parse_str($data, $params);


        /* Pricing Min/Max */
        if (isset($params['pricingMinMax']) && !empty($params['pricingMinMax'])) {
            $min = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->min;
            $max = $this->getMinMaxPrice()->aggregations->global->pricing->{$this->getCurrency()}->max;

            $pricingMinMaxValue = (isset($params['pricingMinMax']) && !empty($params['pricingMinMax'])) ? $params['pricingMinMax'] : '';

            $values = explode(",", $pricingMinMaxValue);
            if ($min != $values[0] || $max != $values[1]) {

                $params['pricingMin'] = $values[0];
                $params['pricingMax'] = $values[1];
            }

            unset($params['pricingMinMax']);
        }

        /* Milage Min/Max */
        if (isset($params['mileageMinMax']) && !empty($params['mileageMinMax'])) {

            // Make sure mileage has indeed been set, before sending to api.
            $mileageMinMaxValues = $this->getCustomFieldAggregation('mileage');
            $mileageMinMaxValue  = (isset($params['mileageMinMax']) && !empty($params['mileageMinMax'])) ? $params['mileageMinMax'] : '';
            $parts               = explode(",", $mileageMinMaxValue);

            if ($mileageMinMaxValues->min != $parts[0] || $mileageMinMaxValues->max != $parts[1]) {

                $params['customFields[mileage][gte]'] = $parts[0];
                $params['customFields[mileage][lte]'] = $parts[1];

            }

            unset($params['mileageMinMax']);
        }
        $search = "";


        foreach ($params as $key => $param) {
            if ("brands" == $key) {
                foreach ($param as $slug) {
                    $search .= '&brands[]=' . $slug;
                }
            } elseif ("categories" == $key) {
                foreach ($param as $slug) {
                    $search .= '&categories[]=' . $slug;
                }
            } elseif ("properties" == $key) {
                foreach ($param as $slug) {
                    $search .= '&properties[]=' . $slug;
                }
            } else {
                $search .= "&" . $key . "=" . $param;
            }

        }

        $products = $this->headless->get("/products?size=1" . $search . $this->includeOptions());
        if (property_exists($products, 'error')) {
            print $products->error;
        } else {
            print $products->summary->totalItems;
        }
        wp_die();

    }

    public function availableFilters($products)
    {
        $availableFilters = [];
        foreach ($products->aggregations->filtered->brands as $key => $data) {
            $availableFilters[$data->item->slug] = $data->item->name;
        }

        foreach ($products->aggregations->filtered->categories as $key => $data) {
            if (!empty($data->item->slug)) {
                $availableFilters[$data->item->slug] = $data->item->name;
            }
        }

        foreach ($products->aggregations->filtered->properties as $key => $propGroup) {
            foreach ($propGroup->groupItems as $k => $group) {
                foreach ($group->items as $data) {
                    if (!empty($data->item->slug)) {
                        $availableFilters[$data->item->slug] = $data->item->value;
                    }
                }
            }
        }

        foreach ($products->aggregations->filtered->properties as $key => $propGroup) {
            foreach ($propGroup->groupItems as $k => $group) {
                foreach ($group->items as $data) {
                    $availableFilters[$data->item->slug] = $data->item->value;
                }
            }
        }

        return $availableFilters;

    }


    /**
     * Gets a single field from properties with the name = $name
     * @param $properties
     * @param $name
     * @return string
     */
    public function get_field(&$properties, $name)
    {

        foreach ($properties as $key => $property) {
            if ($property->name === $name) {
                return $property->value;
            }
        }
        return '-';

    }

    /**
     * Gets all available options for a property with name = $name
     * @param $name
     * @return array
     * @throws \Exception
     */
    public function get_filter_options($name)
    {
        $filter_options = [];
        foreach ($this->search()->aggregations->filtered->properties as $key => $groupItems) {
            foreach ($groupItems as $groupKey => $groupItem) {
                foreach ($groupItem as $itemKey => $item) {
                    if ($name == $item->item->name) {
                        foreach ($item->items as $k => $value) {
                            $filter_options[$value->item->value] = [
                                'slug'  => $value->item->slug,
                                'value' => $value->item->value,
                                'count' => $value->count
                            ];
                        }
                    }
                }
            }
        }

        // Sort Year reversed
        switch ($name) {
            case 'Year':
                krsort($filter_options);
                break;
            default:
                ksort($filter_options);
                break;
        }

        return $filter_options;

    }

    public function getDropdownValuesForElementor($products)
    {
        $getDropdownValuesForElementor = [];
        foreach ($products->aggregations->filtered->brands as $key => $data) {
            $getDropdownValuesForElementor['brands'][$data->item->slug] = $data->item->name;
        }

        foreach ($products->aggregations->filtered->categories as $key => $data) {
            if (!empty($data->item->slug)) {
                $getDropdownValuesForElementor['categories'][$data->item->slug] = $data->item->name;
            }
        }

//        print "<pre>";
//        print_r($products->aggregations->filtered->properties);
//        print "</pre>";
        foreach ($products->aggregations->global->properties as $key => $propGroup) {
            foreach ($propGroup->groupItems as $k => $group) {
                $groupName = $group->item->name;
                foreach ($group->items as $data) {
                    if (!empty($data->item->slug)) {
                        $getDropdownValuesForElementor['properties'][$data->item->slug] = $groupName . " " . $data->item->value;
                    }
                }
            }
        }


//
//        foreach ($products->aggregations->filtered->properties as $key => $propGroup) {
//            foreach ($propGroup->groupItems as $k => $group) {
//                foreach ($group->items as $data) {
//                    if (!empty($data->item->slug)) {
//                        $getDropdownValuesForElementor[$data->item->slug] = $data->item->value;
//                    }
//                }
//            }
//        }
//
//        foreach ($products->aggregations->filtered->properties as $key => $propGroup) {
//            foreach ($propGroup->groupItems as $k => $group) {
//                foreach ($group->items as $data) {
//                    $getDropdownValuesForElementor[$data->item->slug] = $data->item->value;
//                }
//            }
//        }
        ksort($getDropdownValuesForElementor['brands']);
        ksort($getDropdownValuesForElementor['categories']);
        ksort($getDropdownValuesForElementor['properties']);
        return $getDropdownValuesForElementor;

    }

    public function getCarsFromElementor($params = null)
    {

        $search = "?filter";
        if (!empty($params)) {

            // Brands
            if (isset($params['brands']) && !empty($params['brands'])) {
                foreach ($params['brands'] as $key => $slug) {
                    $search .= '&brands[]=' . $slug;
                }
            }

            // Categories
            if (isset($params['properties']) && !empty($params['properties'])) {
                foreach ($params['properties'] as $key => $slug) {
                    $search .= '&properties[]=' . $slug;
                }
            }

            // Properties
            if (isset($params['categories']) && !empty($params['categories'])) {
                foreach ($params['categories'] as $key => $slug) {
                    $search .= '&categories[]=' . $slug;
                }
            }

            // SortBy
            if (isset($params['sort_by']) && !empty($params['sort_by'])) {
                $search .= '&sort_by=' . $params['sort_by'];
            }

            // Number of cars
            if (isset($params['size']) && !empty($params['size'])) {
                $search .= '&size=' . $params['size'];
            }

            // Location
            if (isset($params['location']) && !is_null($params['location'])) {
                $search .= '&location[address][city]=' . strtolower($params['location']);
            }

            // PriceType
            if (isset($params['price_type']) && !is_null($params['price_type'])) {
                $search .= '&properties[]=' . strtolower($params['price_type']);
            }

        }

        $products = $this->headless->get('/products?' . $search . $this->includeOptions());


        if (isset($products->error)) {
            throw new \Exception($products->items);
        }

        return $products;
    }

    public function get_brands_categories($brand)
    {
        $products       = $this->headless->get('/products?brand=' . $brand . $this->includeOptions());
        $all_categories = $products->aggregations->filtered->categories;


        $categories = [];
        foreach ($all_categories as $key => $category) {
            if ($category->count > 0) {
                $categories[] = $category->item;
            }
        }
        usort($categories, function ($a, $b) {
            return $a->slug <=> $b->slug;
        });
        return $categories;

    }

    public function includeOptions()
    {
        $options = "";

        /**
         * Include disabled cars
         * Global setting
         */
        $includeDisabled      = get_option('car-ads-archive')['includeDisabled'] ?? "false";
        $includeDisabledSince = get_option('car-ads-archive')['includeDisabledSince'];

        if (!empty($includeDisabled) && $includeDisabled === "true" && !empty($includeDisabledSince)) {

            $since   = date("Y-m-d H:i:s", strtotime("-" . $includeDisabledSince . " days"));
            $options .= "&includeDisabled=true&updated[gt]=" . urlencode($since);
        }

        return $options;
    }


}

new Connector();