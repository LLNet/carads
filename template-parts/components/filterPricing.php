<article class="filter-group">
    <header class="card-header">
        <a href="#" data-toggle="collapse" data-target="#collapse_aside3" class="ca-no-underline ">
            <i class="icon-control fa fa-chevron-down"></i>
            <h6 class="title"><?php _e('Price', 'car-app'); ?></h6>
        </a>
    </header>
    <div class="filter-content collapse" id="collapse_aside3">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><?php _e('Min', 'car-app'); ?></label>
                    <input class="form-control" type="number" name="pricingMin" value="<?php echo $filters['pricingMin'] ?? ''; ?>">
                </div>
                <div class="form-group text-right col-md-6">
                    <label><?php _e('Max', 'car-app'); ?></label>
                    <input class="form-control" type="number" name="pricingMax" value="<?php echo !empty($filters['pricingMax']) ? $filters['pricingMax'] : ''; ?>">
                </div>
            </div> <!-- form-row.// -->
            <button class="btn btn-block btn-primary"><?php _e('Apply', 'car-app'); ?></button>
        </div> <!-- card-body.// -->
    </div>
</article>