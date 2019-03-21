<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module Rotator
 *
 * @package    DiviRoids\Includes\Modules\Rotator\DiviRoids_Module_Rotator_Content_Item
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_Content_Item')) :

    class DiviRoids_Module_Rotator_Content_Item extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                           = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Content', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                         = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Content', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                           = $this->parent_instance->module_slug . '-rotator-content-item';
            $this->type                           = 'child';
            $this->child_title_var                = 'content';
            $this->child_item_text                = esc_html__('Rotator - Content', DIVIROIDS_PLUGIN_SLUG);
            $this->advanced_setting_title_text    = esc_html__('New Rotator - Content', DIVIROIDS_PLUGIN_SLUG);
            $this->settings_text                  = esc_html__('Rotator - Content Settings', DIVIROIDS_PLUGIN_SLUG);
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
              'general'  => array(
                'toggles' => array(
                  'main_content' => esc_html__('Content', DIVIROIDS_PLUGIN_SLUG),
                ),
              ),
              'advanced' => array(
                'toggles' => array(
                  'animation' => array(
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
            'background'  => array(
              'settings'    => array(
                'color'       => 'alpha',
              ),
            ),
            'fonts'       => array(
              'content'     => array(
                'label'         => esc_html__('Content', DIVIROIDS_PLUGIN_SLUG),
                'css'       => array(
                  'main'        => $this->main_css_element,
                  'plugin_main' => $this->main_css_element,
                  'font'        => $this->main_css_element,
                  'line_height' => $this->main_css_element,
                  'color'       => $this->main_css_element,
                ),
                'hide_text_align' => true,
                'font_size'       => array(
                  'default' => absint(et_get_option('body_font_size', '14')) . 'px',
                ),
                'line_height'     => array(
                  'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
                ),
                'letter_spacing'  => array(
                  'default' => '0px',
                ),
              ),
            ),
            'text'                  => true,
            'text_color'            => true,
            'text_shadow'           => array('default' => false),
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
              'content'  => array(
                'label'             => esc_html__('Content', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Create the content to animate.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'tiny_mce',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              )
            );

            $fields             = array_merge($fields, $animation_fields);

            return $fields;
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            // Add Class Names
            parent::add_module_classnames(false, false);
            $this->add_classname('dr-module-rotator-item', 1);

            // Remove Class Names
            $this->remove_classname('et_pb_module');

            $output = sprintf(
                '<div class="%1$s" data-options="%2$s">
                  %3$s
                  %4$s
                </div> <!-- %5$s -->',
                $this->module_classname($render_slug),
                parent::render_animation_options(),
                parent::render_additional_background_options(),
                $this->content,
                $render_slug
              );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_Content_Item;
