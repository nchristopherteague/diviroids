<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module Rotator
 *
 * @package    DiviRoids\Includes\Modules\Rotator\DiviRoids_Module_Rotator_Text
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_Text')) :

    class DiviRoids_Module_Rotator_Text extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                     = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Text', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                   = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Text', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                     = $this->parent_instance->module_slug . '-rotator-text';
            $this->child_slug               = $this->parent_instance->module_slug . '-rotator-text-item';
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
            'text'                  => false,
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
            $rotation_fields  = parent::get_rotation_fields();
            $fields           = array(
              'animation_text_before'  => array(
                'label'             => esc_html__('Text Before Animation', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Enter text to be displayed before the animation.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              ),
              'animation_text_after'  => array(
                'label'             => esc_html__('Text After Animation', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Enter text to be displayed after the animation.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              )
            );

            $fields         = array_merge($fields, $rotation_fields);

            return $fields;
        }

        public function add_new_child_text()
        {
            return esc_html__('Add New Rotator - Text', DIVIROIDS_PLUGIN_SLUG);
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $text_before  = $this->props['animation_text_before'];
            $text_after   = $this->props['animation_text_after'];

            // Add the module class names
            parent::add_module_classnames(true, true);
            $this->add_classname('dr-module-rotator', 2);

            $output = sprintf(
              '<div%1$s class="%2$s">
                %3$s
                <div class="dr-module-rotator-before">%4$s</div>
                <div class="dr-module-rotator-items" data-options="%5$s">%6$s</div>
                <div class="dr-module-rotator-after">%7$s</div>
               </div> <!-- %8$s -->',
               $this->module_id($render_slug),
               $this->module_classname($render_slug),
               parent::render_additional_background_options(),
               $text_before,
               parent::render_rotation_options(),
               $this->content,
               $text_after,
               $render_slug
            );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_Text;
