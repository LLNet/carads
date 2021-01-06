<h4 class="ca-text-xl ca-font-medium">Model</h4>
<div class="quick-specs ca-grid ca-grid-cols-3 ca-gap-3 ca-my-4 ca-border-b ca-border-solid ca-border-lightgrey ca-pb-4">
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'PLUGIN_NAME');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Model', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'ModelSeries');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Year');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Registreringsår', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'RegistrationDate');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Kilometertal', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php

            if ($connector->get_field($product->properties, 'Mileage') != '-') {
                echo number_format_i18n($connector->get_field($product->properties, 'Mileage'));
                echo " " . __("km.", 'PLUGIN_NAME');
            } else {
                _e('-', 'PLUGIN_NAME');
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Farve', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Color');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Propellant');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Upholstery');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Polstring farve', 'PLUGIN_NAME'); ?></dt>
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
        <dt class="ca-font-thin ca-leading-5"><?php _e('Acceleration 0 til 100', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Acceleration0To100') . " sek.";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            switch ($connector->get_field($product->properties, 'GearType')) {
                case 'A':
                    _e('Automatisk', 'PLUGIN_NAME');
                    break;
                case 'M':
                    _e('Manuel', 'PLUGIN_NAME');
                    break;
                default:
                    _e('-', 'PLUGIN_NAME');
                    break;
            }
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Topfart', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TopSpeed') . " km/t";
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Virkning i nm', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'EffectInNm');
            ?>
        </dd>
    </dl>

     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'PLUGIN_NAME');
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Max. påhæng', 'PLUGIN_NAME'); ?></dt>
        <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
            <?php
            echo $connector->get_field($product->properties, 'TrailerWeight') ? $connector->get_field($product->properties, 'TrailerWeight') : '-';
            ?>
        </dd>
    </dl>
     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Cylindre', 'PLUGIN_NAME'); ?></dt>
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

            <dt class="ca-font-thin ca-leading-5"><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'Range') . " ";
                echo __("km", 'PLUGIN_NAME');
                ?>
            </dd>

            <?php
        } else {
            ?>

            <dt class="ca-font-thin ca-leading-5"><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
            <dd class="ca-ml-0 ca-font-medium ca-leading-5 ca-mb-1">
                <?php
                echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                echo __("km/l", 'PLUGIN_NAME');
                ?>
            </dd>

            <?php
        }
        ?>
    </dl>

     <dl class="ca-flex ca-flex-col">
        <dt class="ca-font-thin ca-leading-5"><?php _e('Vægtafgift', 'PLUGIN_NAME'); ?></dt>
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