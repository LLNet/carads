<?php

$properties = $products->aggregations->global->properties;

foreach ($properties as $key => $propGroup) {

    foreach ($propGroup->groupItems as $k => $group) {
        ?>
        <article class="filter-group">
            <header class="card-header">
                <a href="#" data-toggle="collapse" data-target="#properties<?php echo $k;?>" class="ca-no-underline ">
                    <i class="icon-control fa fa-chevron-down"></i>
                    <h6 class="title"><?php echo $group->item->name; ?></h6>
                </a>
            </header>
            <div class="filter-content collapse" id="properties<?php echo $k;?>">
                <div class="card-body">
                    <?php
                    foreach ($group->items as $property) {
                        ?>
                        <label class="checkbox-btn">
                            <input type="checkbox" class="auto-submit" name="properties[]" value="<?php echo $property->item->slug; ?>"
                                <?php
                                if (in_array($property->item->slug, $filters['properties'])) {
                                    ?>
                                    checked=""
                                    <?php
                                }
                                ?>

                            >
                            <span class="btn btn-light"> <?php echo $property->item->value; ?> </span>
                        </label>
                        <?php
                    }
                    ?>
                    <button class="btn btn-block btn-primary"><?php _e('Apply', 'car-ads'); ?></button>
                </div> <!-- card-body.// -->
            </div>
        </article>
        <?php
    }

}

?>
