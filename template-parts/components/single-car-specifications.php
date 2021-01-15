<h4 class="ca-text-xl ca-font-medium"><?php echo __('Model', 'car-app'); ?></h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-border-b ca-border-solid ca-border-lightgrey ca-pb-4">
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'car-app');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Model', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'ModelSeries');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Modelår', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Year');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Registreringsår', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            $date = $connector->get_field($product->properties, 'RegistrationDate');
            echo date("m/Y", strtotime($date));
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Kilometertal', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php

            if ($connector->get_field($product->properties, 'Mileage') != '-') {
                echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                echo " " . __("km.", 'car-app');
            } else {
                _e('-', 'car-app');
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Farve', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Color');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Drivmiddel', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Propellant');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Upholstery');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring farve', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'UpholsteryColor');
            ?>
        </dd>
    </dl>

</div>
<h4 class="ca-text-xl ca-font-medium"><?php echo __('Teknik', 'car-app'); ?></h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-border-b ca-border-solid ca-border-lightgrey ca-pb-4">
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Acceleration 0 til 100', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Acceleration0To100') . " sek.";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Gearkasse', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            switch ($connector->get_field($product->properties, 'GearType')) {
                case 'A':
                    _e('Automatisk', 'car-app');
                    break;
                case 'M':
                    _e('Manuel', 'car-app');
                    break;
                default:
                    _e('-', 'car-app');
                    break;
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Topfart', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TopSpeed') . " km/t";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Virkning i nm', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'EffectInNm');
            ?>
        </dd>
    </dl>

     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'car-app');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Max. påhæng', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TrailerWeight') ? $connector->get_field($product->properties, 'TrailerWeight') : '-';
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Cylindre', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Cylinders');
            ?>
        </dd>
    </dl>

</div>

<h4 class="ca-text-xl ca-font-medium"><?php echo __('Miljø', 'car-app'); ?></h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-pb-4">

     <dl class="ca-flex ca-flex-col">
        <?php
        if ("El" === $connector->get_field($product->properties, 'Propellant')) {
            ?>

            <dt class="ca-font-thin ca-leading-5"><?php _e('Rækkevidde', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Range') . " ";
                echo __("km", 'car-app');
                ?>
            </dd>

            <?php
        } else {
            ?>

            <dt class="ca-font-thin ca-leading-5"><?php _e('Forbrug', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                echo __("km/l", 'car-app');
                ?>
            </dd>

            <?php
        }
        ?>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Vægtafgift', 'car-app'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php echo $connector->get_field($product->properties, 'WeightTax'); ?>
            <?php
            if ($connector->get_field($product->properties, 'WeightTaxPeriod')) {
                echo "kr. hver " . $connector->get_field($product->properties, 'WeightTaxPeriod') . ". md";
            }
            ?>
        </dd>
    </dl>
    <?php
    if(!empty($connector->get_field($product->properties, 'GreenTax')) && $connector->get_field($product->properties, 'GreenTax') != '-') {
        ?>
        <dl class="ca-flex ca-flex-col">
            <dt class="ca-font-thin ca-leading-5"><?php _e('Grøn ejerafgift', 'car-app'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php echo $connector->get_field($product->properties, 'GreenTax'); ?>
                <?php
                if ($connector->get_field($product->properties, 'GreenTaxPeriod')) {
                    echo "kr. / år";
                }
                ?>
            </dd>
        </dl>
        <?php
    }
    ?>
</div>