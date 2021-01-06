<?php
if (!empty($filters)) {
    ?>
    <div class="active-filters ca-flex ca-flex-wrap">

        <?php
        foreach ($filters as $filter) {
            if (!empty($filter)) {

                foreach ($filter as $key => $item) {
                    if (array_key_exists($item, $availableFilters)) {
                        ?>
                        <a href="#" class="ca-no-underline remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
                           data-target="<?php echo $item; ?>"
                        >
                            <?php
                            switch ($availableFilters[$item]) {
                                case 'A':
                                    echo 'Automatisk';
                                    break;
                                case 'M':
                                    echo 'Manuel';
                                    break;
                                default:
                                    echo $availableFilters[$item];
                                    break;
                            }
                            ?>
                            <i class="fa fa-times"></i></a>

                        <?php
                    }
                }
            }
        }
        if (isset($_GET['pricingMin']) && !empty($_GET['pricingMin'])) {
            ?>
            <a href="#" class="ca-no-underline remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
               data-target="<?php echo $_GET['pricingMin']; ?>">
                Minimumspris (<?php echo number_format_i18n($_GET['pricingMin']); ?>)
                <i class="fa fa-times"></i>
            </a>
            <?php
        }
        if (isset($_GET['pricingMax']) && !empty($_GET['pricingMax']) && $_GET['pricingMax'] != '-1') {
            ?>
            <a href="#" class="ca-no-underline remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
               data-target="<?php echo $_GET['pricingMax']; ?>">Maksimumspris
                (<?php echo number_format_i18n($_GET['pricingMax']); ?>)
                <i class="fa fa-times"></i></a>
            <?php
        }

        if (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) {
            // Make sure mileage has indeed been set, before sending to api.
            $min = $connector->getMinMaxPrice()->aggregations->global->pricing->{$connector->getCurrency()}->min;
            $max = $connector->getMinMaxPrice()->aggregations->global->pricing->{$connector->getCurrency()}->max;

            $pricingMinMaxValue = (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) ? $_GET['pricingMinMax'] : '';

            $prices = explode(",", $pricingMinMaxValue);
            if ($min != $prices[0] || $max != $prices[1]) {

                ?>
                <a href="#" class="ca-no-underline remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
                   data-target="<?php echo $_GET['pricingMinMax']; ?>">Pris mellem:
                    <?php echo number_format_i18n($prices[0]); ?> &mdash; <?php echo number_format_i18n($prices[1]); ?>
                    <i class="fa fa-times"></i></a>
                <?php
            }

        }

        if (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) {

            $mileageMinMaxValues = $connector->getCustomFieldAggregation('mileage');
            $mileageMinMaxValue  = (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) ? $_GET['mileageMinMax'] : '';

            $sliderMileage = explode(",", $mileageMinMaxValue);
            if ($mileageMinMaxValues->min != $sliderMileage[0] || $mileageMinMaxValues->max != $sliderMileage[1]) {

                ?>
                <a href="#" class="ca-no-underline  remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
                   data-target="<?php echo $mileageMinMaxValue; ?>">Kilometer mellem:
                    <?php echo number_format_i18n($sliderMileage[0]); ?>
                    &mdash; <?php echo number_format_i18n($sliderMileage[1]); ?>
                    <i class="fa fa-times"></i></a>
                <?php
            }
        }

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            ?>
            <a href="#" class="ca-no-underline remove-filter ca-bg-white hover:ca-bg-lightgrey ca-rounded ca-px-2 ca-py-1 ca-mr-1 ca-text-xs md:ca-text-sm ca-mb-1"
               data-target="<?php echo $_GET['search']; ?>">Fri tekst: <?php echo $_GET['search']; ?>
                <i class="fa fa-times"></i></a>
            <?php
        }
        ?>
        <a href="/<?php echo $archive_slug; ?>" class="carads-remove-all-filters ca-no-underline ca-bg-primary hover:ca-bg-primary-dark ca-text-white ca-rounded ca-px-2 ca-py-1 ca-text-xs md:ca-text-sm ca-mb-1">Fjern alle filtre</a>
    </div>

    <?php
}