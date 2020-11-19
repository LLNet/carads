<?php
if (!empty($filters)) {
    ?>
    <div class="active-filters">

        <?php
        foreach ($filters as $filter) {
            if (!empty($filter)) {

                foreach ($filter as $key => $item) {
                    if (array_key_exists($item, $availableFilters)) {
                        ?>
                        <a href="#" class="btn btn-light remove-filter"
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
            <a href="#" class="btn btn-light remove-filter"
               data-target="<?php echo $_GET['pricingMin']; ?>">
                Minimumspris (<?php echo number_format_i18n($_GET['pricingMin']); ?>)
                <i class="fa fa-times"></i>
            </a>
            <?php
        }
        if (isset($_GET['pricingMax']) && !empty($_GET['pricingMax']) && $_GET['pricingMax'] != '-1') {
            ?>
            <a href="#" class="btn btn-light remove-filter"
               data-target="<?php echo $_GET['pricingMax']; ?>">Maksimumspris
                (<?php echo number_format_i18n($_GET['pricingMax']); ?>)
                <i class="fa fa-times"></i></a>
            <?php
        }

        if (isset($_GET['pricingMinMax']) && !empty($_GET['pricingMinMax'])) {
            $prices = explode(",", $_GET['pricingMinMax']);
            ?>
            <a href="#" class="btn btn-light remove-filter"
               data-target="<?php echo $_GET['pricingMinMax']; ?>">Pris mellem:
                <?php echo number_format_i18n($prices[0]); ?> &mdash; <?php echo number_format_i18n($prices[1]); ?>
                <i class="fa fa-times"></i></a>
            <?php
        }

        if (isset($_GET['mileageMinMax']) && !empty($_GET['mileageMinMax'])) {
            $prices = explode(",", $_GET['mileageMinMax']);
            ?>
            <a href="#" class="btn btn-light remove-filter"
               data-target="<?php echo $_GET['mileageMinMax']; ?>">Kilometer mellem:
                <?php echo number_format_i18n($prices[0]); ?> &mdash; <?php echo number_format_i18n($prices[1]); ?>
                <i class="fa fa-times"></i></a>
            <?php
        }

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            ?>
            <a href="#" class="btn btn-light remove-filter"
               data-target="<?php echo $_GET['search']; ?>">Fri tekst: <?php echo $_GET['search']; ?>
                <i class="fa fa-times"></i></a>
            <?php
        }
        ?>
        <a href="/<?php echo $archive_slug; ?>" class="btn btn-primary">Fjern alle filtre</a>
    </div>

    <?php
}