<h4 class="ca-text-xl ca-font-medium">Model</h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-border-b ca-border-solid ca-border-lightgrey ca-pb-4">
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'car-ads');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Model', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'ModelSeries');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Årgang', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Year');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Registreringsår', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'RegistrationDate');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Kilometertal', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php

            if ($connector->get_field($product->properties, 'Mileage') != '-') {
                echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                echo " " . __("km.", 'car-ads');
            } else {
                _e('-', 'car-ads');
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Farve', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Color');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Drivmiddel', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Propellant');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Upholstery');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring farve', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'UpholsteryColor');
            ?>
        </dd>
    </dl>

</div>
<h4 class="ca-text-xl ca-font-medium">Teknik</h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-border-b ca-border-solid ca-border-lightgrey ca-pb-4">
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Acceleration 0 til 100', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Acceleration0To100') . " sek.";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Gearkasse', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            switch ($connector->get_field($product->properties, 'GearType')) {
                case 'A':
                    _e('Automatisk', 'car-ads');
                    break;
                case 'M':
                    _e('Manuel', 'car-ads');
                    break;
                default:
                    _e('-', 'car-ads');
                    break;
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Topfart', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TopSpeed') . " km/t";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Virkning i nm', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'EffectInNm');
            ?>
        </dd>
    </dl>

     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'car-ads');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Max. påhæng', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TrailerWeight') ? $connector->get_field($product->properties, 'TrailerWeight') : '-';
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Cylindre', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Cylinders');
            ?>
        </dd>
    </dl>

</div>

<h4 class="ca-text-xl ca-font-medium">Miljø</h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-pb-4">

     <dl class="ca-flex ca-flex-col">
        <?php
        if ("El" === $connector->get_field($product->properties, 'Propellant')) {
            ?>

            <dt class="ca-font-thin ca-leading-5"><?php _e('Rækkevidde', 'car-ads'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Range') . " ";
                echo __("km", 'car-ads');
                ?>
            </dd>

            <?php
        } else {
            ?>

            <dt class="ca-font-thin ca-leading-5"><?php _e('Forbrug', 'car-ads'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                echo __("km/l", 'car-ads');
                ?>
            </dd>

            <?php
        }
        ?>
    </dl>

     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Vægtafgift', 'car-ads'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php echo $connector->get_field($product->properties, 'WeightTax'); ?>
            <?php
            if ($connector->get_field($product->properties, 'WeightTaxPeriod')) {
                echo "kr. / " . $connector->get_field($product->properties, 'WeightTaxPeriod') . ". måned";
            }
            ?>
        </dd>
    </dl>
</div>