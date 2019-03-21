<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module Rotator
 *
 * @package    DiviRoids\Includes\Modules\Rotator\DiviRoids_Module_Rotator_Quote_Item
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_Quote_Item')) :

    class DiviRoids_Module_Rotator_Quote_Item extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                           = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                         = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                           = $this->parent_instance->module_slug . '-rotator-quote-item';
            $this->type                           = 'child';
            $this->child_title_var                = 'quote_author';
            $this->child_title_fallback_var       = 'Quote';
            $this->child_item_text                = esc_html__('Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->advanced_setting_title_text    = esc_html__('New Rotator - Quote', DIVIROIDS_PLUGIN_SLUG);
            $this->settings_text                  = esc_html__('Rotator - Quote Settings', DIVIROIDS_PLUGIN_SLUG);
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
              'quote'     => array(
                'label'         => esc_html__('Quote', DIVIROIDS_PLUGIN_SLUG),
                'css'       => array(
                  'main'        => "{$this->main_css_element} blockquote.dr-module-rotator-quote-item-content",
                  'plugin_main' => "{$this->main_css_element} blockquote.dr-module-rotator-quote-item-content",
                  'font'        => "{$this->main_css_element} blockquote.dr-module-rotator-quote-item-content",
                  'line_height' => "{$this->main_css_element} blockquote.dr-module-rotator-quote-item-content",
                  'color'       => "{$this->main_css_element} blockquote.dr-module-rotator-quote-item-content",
                ),
                'hide_text_align' => true,
                'font_size'       => array(
                  'default' => absint(et_get_option('body_font_size', '14')) . 'px',
                ),
                'line_height'     => array(
                  'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
                ),
                'letter_spacing'  => array(
                  'default' => '0',
                ),
              ),
              'author'     => array(
                'label'         => esc_html__('Author', DIVIROIDS_PLUGIN_SLUG),
                'css'       => array(
                  'main'        => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                  'plugin_main' => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                  'font'        => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                  'line_height' => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                  'color'       => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                  'text_align'  => "{$this->main_css_element} cite.dr-module-rotator-quote-item-author",
                ),
                'font_size'       => array(
                  'default' => absint(et_get_option('body_font_size', '14')) . 'px',
                ),
                'line_height'     => array(
                  'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
                ),
                'letter_spacing'  => array(
                  'default' => '0',
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
            return array(
            'quote_before' => array(
                'label'    => esc_html__('Quote Before', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-content::before',
            ),
            'quote' => array(
                'label'    => esc_html__('Quote', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-content',
            ),
            'quote_after' => array(
                'label'    => esc_html__('Quote After', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-content::after',
            ),
            'author_before' => array(
                'label'    => esc_html__('Author Before', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-author::before',
            ),
            'author' => array(
                'label'    => esc_html__('Author', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-author',
            ),
            'author_after' => array(
                'label'    => esc_html__('Author After', DIVIROIDS_PLUGIN_SLUG),
                'selector' => '.dr-module-rotator-quote-item-author::after',
            ),
          );
        }

        // Get the Fields
        public function get_fields()
        {
            $animation_fields   = parent::get_animation_fields();
            $fields             = array(
              'quote_content'  => array(
                'label'             => esc_html__('Quote', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Quote to animate.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              ),
              'quote_author'  => array(
                'label'             => esc_html__('Author', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Author of the quote.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'main_content',
              ),
            );

            $fields             = array_merge($fields, $animation_fields);

            return $fields;
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $quote_content      = $this->props['quote_content'];
            $quote_author       = $this->props['quote_author'];

            // Add Class Names
            parent::add_module_classnames(false, false);
            $this->add_classname('dr-module-rotator-item', 1);

            // Remove Class Names
            $this->remove_classname('et_pb_module');

            $output = sprintf(
                '<div class="%1$s" data-options="%2$s">
                  %3$s
                  %4$s
                  %5$s
                </div> <!-- %6$s -->',
                $this->module_classname($render_slug),
                parent::render_animation_options(),
                parent::render_additional_background_options(),
                !empty($quote_content) ? '<blockquote class="dr-module-rotator-quote-item-content">' . $quote_content . '</blockquote>': '',
                !empty($quote_author) ? '<cite class="dr-module-rotator-quote-item-author">' . $quote_author . '</cite>': '',
                $render_slug
              );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_Quote_Item;
