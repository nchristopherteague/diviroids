<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module Rotator
 *
 * @package    DiviRoids\Includes\Modules\Rotator\DiviRoids_Module_Rotator_DiviLibrary_Item
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_DiviLibrary_Item')) :

    class DiviRoids_Module_Rotator_DiviLibrary_Item extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                           = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Divi Library', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                         = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Divi Library', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                           = $this->parent_instance->module_slug . '-rotator-divilibrary-item';
            $this->type                           = 'child';
            $this->child_title_var                = '';
            $this->child_item_text                = esc_html__('Rotator - Divi Library', DIVIROIDS_PLUGIN_SLUG);
            $this->advanced_setting_title_text    = esc_html__('New Rotator - Divi Library', DIVIROIDS_PLUGIN_SLUG);
            $this->settings_text                  = esc_html__('Rotator - Divi Library Settings', DIVIROIDS_PLUGIN_SLUG);
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
              'general'  => array(
                'toggles' => array(
                  'main_content' => esc_html__('Divi Library', DIVIROIDS_PLUGIN_SLUG),
                ),
              ),
              'advanced' => array(
                'toggles' => array(
                  'animation'      => array(
                    'title'    => esc_html__('Animation', DIVIROIDS_PLUGIN_SLUG),
                    'priority' => 110,
                  ),
                ),
              ),
            );
        }

        // Get advanced fields
        public function get_advanced_fields_config()
        {
            return array(
              'borders'               => false,
              'box_shadow'            => false,
              'max_width'             => false,
              'margin_padding'        => false,
              'background'            => false,
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
            $animation_fields   = parent::get_animation_fields();
            $fields             = array(
              'divilibrary'  => array(
                'label'             => esc_html__('Divi Library Item', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Select a layout from your Divi Library.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'default'           => '0',
                'options'           => DiviRoids_Options::get_divi_library_options(array('blank_key' => 0)),
                'toggle_slug'       => 'main_content',
              ),
            );

            $fields             = array_merge($fields, $animation_fields);

            return $fields;
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $divilibrary  = $this->props['divilibrary'];

            // Add Class Names
            parent::add_module_classnames(false, false);
            $this->add_classname('dr-module-rotator-item', 1);

            // Remove Class Names
            $this->remove_classname('et_pb_module');

            $output = empty($divilibrary) || '0' === $divilibrary ?
            '' :
            do_shortcode('[et_pb_section global_module="' . $divilibrary . '"][/et_pb_section]');

            $output = sprintf(
                '<div class="%1$s" data-options="%2$s">
                  %3$s
                  %4$s
                </div> <!-- %5$s -->',
                $this->module_classname($render_slug),
                parent::render_animation_options(),
                parent::render_additional_background_options(),
                $output,
                $render_slug
              );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_DiviLibrary_Item;
