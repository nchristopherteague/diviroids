<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module Rotator
 *
 * @package    DiviRoids\Includes\Modules\Rotator\DiviRoids_Module_Rotator_Quote
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_Quote')) :

    class DiviRoids_Module_Rotator_Quote extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                     = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                   = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                     = $this->parent_instance->module_slug . '-rotator-quote';
            $this->child_slug               = $this->parent_instance->module_slug . '-rotator-quote-item';
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
              'general'  => array(
                'toggles' => array(
                  'main_content' => esc_html__('Quote', DIVIROIDS_PLUGIN_SLUG),
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
              'background'            => array(
                'settings'              => array(
                  'color'                 => 'alpha',
                ),
              ),
              'fonts'       => array(
                'header' => array(
                    'label'    => esc_html__('Title', 'et_builder'),
                    'css'      => array(
                        'main'        => "{$this->main_css_element} h1.dr-module-rotator-quote-item-title, {$this->main_css_element} h2.dr-module-rotator-quote-item-title, {$this->main_css_element} h3.dr-module-rotator-quote-item-title, {$this->main_css_element} h4.dr-module-rotator-quote-item-title, {$this->main_css_element} h5.dr-module-rotator-quote-item-title, {$this->main_css_element} h6.dr-module-rotator-quote-item-title",
                        'plugin_main' => "{$this->main_css_element} h1.dr-module-rotator-quote-item-title, {$this->main_css_element} h2.dr-module-rotator-quote-item-title, {$this->main_css_element} h3.dr-module-rotator-quote-item-title, {$this->main_css_element} h4.dr-module-rotator-quote-item-title, {$this->main_css_element} h5.dr-module-rotator-quote-item-title, {$this->main_css_element} h6.dr-module-rotator-quote-item-title",
                        'font'        => "{$this->main_css_element} h1.dr-module-rotator-quote-item-title, {$this->main_css_element} h2.dr-module-rotator-quote-item-title, {$this->main_css_element} h3.dr-module-rotator-quote-item-title, {$this->main_css_element} h4.dr-module-rotator-quote-item-title, {$this->main_css_element} h5.dr-module-rotator-quote-item-title, {$this->main_css_element} h6.dr-module-rotator-quote-item-title",
                        'line_height' => "{$this->main_css_element} h1.dr-module-rotator-quote-item-title, {$this->main_css_element} h2.dr-module-rotator-quote-item-title, {$this->main_css_element} h3.dr-module-rotator-quote-item-title, {$this->main_css_element} h4.dr-module-rotator-quote-item-title, {$this->main_css_element} h5.dr-module-rotator-quote-item-title, {$this->main_css_element} h6.dr-module-rotator-quote-item-title",
                        'color'       => "{$this->main_css_element} h1.dr-module-rotator-quote-item-title, {$this->main_css_element} h2.dr-module-rotator-quote-item-title, {$this->main_css_element} h3.dr-module-rotator-quote-item-title, {$this->main_css_element} h4.dr-module-rotator-quote-item-title, {$this->main_css_element} h5.dr-module-rotator-quote-item-title, {$this->main_css_element} h6.dr-module-rotator-quote-item-title",

                    ),
                    'header_level' => array(
                        'default' => 'h3',
                    ),
                    'font_size'       => array(
                      'default' => absint(et_get_option('body_header_size', '30')) . 'px',
                    ),
                    'line_height'     => array(
                      'default' => floatval(et_get_option('body_header_height', '1.7')) . 'em',
                    ),
                    'letter_spacing'  => array(
                      'default' => intval(et_get_option('body_header_spacing', '0')) . 'px',
                    ),
                ),
              ),
              'text'                  => false,
              'button'                => false,
              'animation'             => false,
              'filters'               => false,
          );
        }

        // Get Custom CSS fields
        public function get_custom_css_fields_config()
        {
            return array(
              'title' => array(
                  'label'    => esc_html__('Title', DIVIROIDS_PLUGIN_SLUG),
                  'selector' => '.dr-module-rotator-quote-item-title',
              ),
            );
        }

        // Get the Fields
        public function get_fields()
        {
            $rotation_fields  = parent::get_rotation_fields();
            $fields           = array(
              'animation_title'  => array(
                'label'             => esc_html__('Title', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Title for the quotes.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              ),
            );
            $fields           = array_merge($fields, $rotation_fields);

            return $fields;
        }

        public function add_new_child_text()
        {
            return esc_html__('Add New Rotator - Blog', DIVIROIDS_PLUGIN_SLUG);
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $animation_title      = $this->props['animation_title'];
            $header_level         = $this->props['header_level'];

            // Add the module class names
            parent::add_module_classnames(true, true);
            $this->add_classname('dr-module-rotator', 2);

            $output = sprintf(
              '<div%1$s class="%2$s">
                %3$s
                %4$s
                <div class="dr-module-rotator-items" data-options="%5$s">%6$s</div>
               </div> <!-- %7$s -->',
               $this->module_id($render_slug),
               $this->module_classname($render_slug),
               parent::render_additional_background_options(),
               !empty($animation_title) ? sprintf('<%1$s class="dr-module-rotator-quote-title">%2$s</%1$s>', et_pb_process_header_level($header_level, 'h4'), $animation_title) : '',
               parent::render_rotation_options(),
               $this->content,
               $render_slug
            );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_Quote;
