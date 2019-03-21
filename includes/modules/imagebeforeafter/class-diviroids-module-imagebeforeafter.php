<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module ImageBeforeAfter
 *
 * @package    DiviRoids\Includes\Modules\ImageBeforeAfter\DiviRoids_Module_Rotator_ImageBeforeAfter
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_ImageBeforeAfter')) :

    class DiviRoids_Module_Rotator_ImageBeforeAfter extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                     = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Image', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                   = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Images', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                     = $this->parent_instance->module_slug . '-rotator-image';
            $this->child_slug               = $this->parent_instance->module_slug . '-rotator-image-item';
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
              'general'  => array(),
              'advanced' => array(
                'toggles' => array(
                  'rotator_settings'      => array(
                    'title'    => esc_html__('Rotator Settings', DIVIROIDS_PLUGIN_SLUG),
                  ),
                ),
              ),
            );
        }

        // Get advanced fields
        public function get_advanced_fields_config()
        {
            return array(
                'fonts'                 => false,
                'text'                  => false,
                'button'                => false,
                'animation'             => false,
                'filters'               => false,
            );
        }

        // Get Custom CSS fields
        public function get_custom_css_fields_config()
        {
            return array();
        }

        // Get the Fields
        public function get_fields()
        {
            $rotation_fields  = parent::get_rotation_fields();
            $fields           = array_merge(array(), $rotation_fields);

            return $fields;
        }

        public function add_new_child_text()
        {
            return esc_html__('Add New Rotator - Image', DIVIROIDS_PLUGIN_SLUG);
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            // Add the module class names
            parent::add_module_classnames(true, true);
            $this->add_classname('dr-module-rotator', 2);

            $output = sprintf(
              '<div%1$s class="%2$s">
                %3$s
                <div class="dr-module-rotator-items" data-options="%4$s">%5$s</div>
               </div> <!-- %6$s -->',
               $this->module_id($render_slug),
               $this->module_classname($render_slug),
               parent::render_additional_background_options(),
               parent::render_rotation_options(),
               $this->content,
               $render_slug
            );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_ImageBeforeAfter;
