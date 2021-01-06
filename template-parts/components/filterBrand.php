<div class="filter-group">
    <header class="card-header">
        <a href="#" data-toggle="collapse" data-target="#collapse_aside1" class="ca-no-underline">
            <i class="icon-control fa fa-chevron-down"></i>
            <h6 class="title"><?php echo __('Brands', 'car-ads'); ?></h6>
        </a>
    </header>
    <div class="filter-content collapse show" id="collapse_aside1">

        <div class="card-body">
            <?php
            if (property_exists($products->aggregations->global, 'brands')) {

                foreach ($products->aggregations->global->brands as $key => $brand) {
                    ?>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="auto-submit custom-control-input" name="brands[]"
                               value="<?php echo $brand->item->slug; ?>"
                            <?php
                            if (in_array($brand->item->slug, $filters['brands'])) {
                                echo 'checked=""';
                            }
                            ?>
                        >
                        <div class="custom-control-label"><?php echo $brand->item->name; ?> <b
                                    class="badge badge-pill badge-light float-right"><?php echo $brand->count; ?></b>
                        </div>
                    </label>
                    <?php
                }
            }
            ?>


        </div>
    </div>
</div>