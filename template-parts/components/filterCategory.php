<div class="filter-group">
    <header class="card-header">
        <a href="#" data-toggle="collapse" data-target="#collapse_aside2" class="ca-no-underline">
            <i class="icon-control fa fa-chevron-down"></i>
            <h6 class="title"><?php echo __('Categories', 'car-ads'); ?></h6>
        </a>
    </header>
    <div class="filter-content collapse" id="collapse_aside2">

        <div class="card-body">
            <?php
            if (property_exists($products->aggregations->global, 'categories')) {

                ksort($products->aggregations->global->categories);

                foreach ($products->aggregations->global->categories as $key => $category) {
                    if ($category->count > 0) {
                        ?>

                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input auto-submit" name="categories[]"
                                   value="<?php echo $category->item->slug; ?>"
                                <?php
                                if (in_array($category->item->slug, $filters['categories'])) {
                                    echo 'checked=""';
                                }
                                ?>
                            >
                            <div class="custom-control-label"><?php echo $category->item->name; ?> <b
                                        class="badge badge-pill badge-light float-right"><?php echo $category->count; ?></b>
                            </div>
                        </label>

                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>