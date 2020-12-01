<h4>Model</h4>
<div class="quick-specs">
    <dl>
        <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'PLUGIN_NAME');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Model', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'ModelSeries');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Årgang', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Year');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Registreringsår', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'RegistrationDate');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Kilometertal', 'PLUGIN_NAME'); ?></dt>
        <dd>
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
    <dl>
        <dt><?php _e('Farve', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Color');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Drivmiddel', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Propellant');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Polstring', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Upholstery');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Polstring farve', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'UpholsteryColor');
            ?>
        </dd>
    </dl>

</div>
<hr>

<h4>Teknik</h4>
<div class="quick-specs">
    <dl>
        <dt><?php _e('Acceleration 0 til 100', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Acceleration0To100') . " sek.";
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Gearkasse', 'PLUGIN_NAME'); ?></dt>
        <dd>
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
    <dl>
        <dt><?php _e('Topfart', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'TopSpeed') . " km/t";
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Virkning i nm', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'EffectInNm');
            ?>
        </dd>
    </dl>

    <dl>
        <dt><?php _e('HK', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Effect') . " ";
            echo __("hk", 'PLUGIN_NAME');
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Max. påhæng', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'TrailerWeight') ? $connector->get_field($product->properties, 'TrailerWeight') : '-';
            ?>
        </dd>
    </dl>
    <dl>
        <dt><?php _e('Cylindre', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php
            echo $connector->get_field($product->properties, 'Cylinders');
            ?>
        </dd>
    </dl>

</div>
<hr>
<h4>Miljø</h4>
<div class="quick-specs">

    <dl>
        <?php
        if ("El" === $connector->get_field($product->properties, 'Propellant')) {
            ?>

            <dt><?php _e('Rækkevidde', 'PLUGIN_NAME'); ?></dt>
            <dd>
                <?php
                echo $connector->get_field($product->properties, 'Range') . " ";
                echo __("km", 'PLUGIN_NAME');
                ?>
            </dd>

            <?php
        } else {
            ?>

            <dt><?php _e('Forbrug', 'PLUGIN_NAME'); ?></dt>
            <dd>
                <?php
                echo $connector->get_field($product->properties, 'KmPerLiter') . " ";
                echo __("km/l", 'PLUGIN_NAME');
                ?>
            </dd>

            <?php
        }
        ?>
    </dl>

    <dl>
        <dt><?php _e('Vægtafgift', 'PLUGIN_NAME'); ?></dt>
        <dd>
            <?php echo $connector->get_field($product->properties, 'WeightTax'); ?>
            <?php
            if ($connector->get_field($product->properties, 'WeightTaxPeriod')) {
                echo "kr. / " . $connector->get_field($product->properties, 'WeightTaxPeriod') . ". måned";
            }
            ?>
        </dd>
    </dl>

</div>