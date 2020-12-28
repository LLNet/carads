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
        $headless = new \Indexed\Headless\Request($this->ck, $this->cs, $this->pt);
        $headless->useCache(true);
        $headless->setUrl($this->api_endpoint);
        $this->headless = $headless;

        // Add actions on cronjob action
        add_action('car-ads', [$this, 'synchronize']);
        add_action('car-ads', [$this, 'clean_up_non_existing_cars']);


        if ($_REQUEST['syncmanual'] == "1") {

            add_action('init', [$this, 'synchronize']);

            print "<pre>";
            print_r("Done");
            print "</pre>";

        }


        add_action('wp_ajax_nopriv_pre_search', [$this, 'pre_search']);
        add_action('wp_ajax_pre_search', [$this, 'pre_search']);
    }

    public function getCurrency()
    {
        if (empty($this->currency)) {
            $this->setLocalizedApi();
        }
        return $this->currency;
    }

    public function setLocalizedApi()
    {
        $locale = substr(get_locale(), 0, 2);
        // loop for at finde website med sprog = get_locale()
        $websites = $this->headless->get("/websites");

        if (!empty($websites->items)) {
            foreach ($websites->items as $key => $site) {

                if ($site->language === $locale) {
                    // Set localized API object
                    $this->localizedApi = new Connector($site->consumerKey, $site->consumerSecret, $site->publicToken);
                    $this->language     = $site->language;
                    $this->vat          = $site->vat;
                    $this->currency     = $site->currency;
                }

            }
        }

    }

    public function getCustomField($name)
    {
        $settings     = $this->headless->get("/settings");
        $customFields = $settings->customFields;
        foreach ($customFields as $key => $customField) {
            if ($customField->name === $name) {
                return $customField->value;
            }
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

        $offset = "?size=50";

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
                        if (new DateTime($product->updated) > new DateTime($car->post_modified)) {
                            $this->update($car->ID, $product);
                        }
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
        $products = $this->headless->get('/products?size=1000');
        $slugs    = [];
        foreach ($products->items as $key => $product) {
            $slugs[] = $product->slug;
        }

        // Loop through local cars and delete cars that are not in CarAds.io
        global $wpdb;

        $cars = $wpdb->get_results("SELECT ID, post_title, post_name 
                FROM `" . $wpdb->posts . "` 
                WHERE `post_type` = '" . $this->post_type . "' 
                AND (`post_status` = 'draft' OR `post_status` = 'publish' OR `post_status` = 'trash')", ARRAY_A);

        foreach ($cars as $key => $car) {
            if (!in_array($car['post_name'], $slugs)) {
                $this->remove($car['ID']);
            }

        }
    }

    /**
     * @param $product
     * @return bool
     */
    public function create($product)
    {
        try {
            $page = wp_insert_post([
                'post_type'         => $this->post_type,
                'post_title'        => $product->slug . "-" . $this->get_field($product->properties, 'Id'),
                'post_name'         => $product->slug,
                'post_modified'     => $product->updated,
                'post_modified_gmt' => $product->updated,
                'post_status'       => 'publish',
                'meta_input'        => [
                    'carads_id' => $product->id
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
            $updated = wp_update_post([
                'ID'         => $post_id,
                'post_name'  => $data->slug . "-" . $this->get_field($data->properties, 'Id'),
                'post_title' => $data->name,
                'meta_input' => [
                    'carads_id' => $data->id
                ]
            ]);

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
        wp_delete_post($post_id, true);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function get_single($slug)
    {
        return $this->headless->get('/products/' . $slug);
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
            ////        $search .= '&sort_by='.$request->get('sort_by', 'name:asc');
            //        if (!empty($_GET['offset'])) {
            //            $search .= '&offset=' . $_GET['offset'];
            //        }

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

        $products = $this->headless->get('/products' . $search);

        if (isset($products->error)) {
            throw new \Exception($products->items);
        }

        return $products;
    }

    public function filters()
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
        $products = $this->headless->get("/products?size=1");
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

        $products = $this->headless->get("/products?size=1" . $search);
        if (property_exists($products, 'error')) {
            print $products->error;
        } else {
            print $products->summary->totalItems;
        }
        wp_die();

    }

    public
    function availableFilters($products)
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

//        foreach ($products->aggregations->filtered->pricingMin as $key => $data) {
//            $availableFilters[$data->item->slug] = $data->item->name;
//        }
//        foreach ($products->aggregations->filtered->pricingMax as $key => $data) {
//            $availableFilters[$data->item->slug] = $data->item->name;
//        }

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
    public
    function get_field(&$properties, $name)
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
    public
    function get_filter_options($name)
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

}

new Connector();