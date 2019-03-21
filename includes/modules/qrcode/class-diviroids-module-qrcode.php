<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module QRCode
 *
 * @package    DiviRoids\Includes\Modules\QRCode\DiviRoids_Module_QRCode
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_QRCode')) :

    class DiviRoids_Module_QRCode extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                     = esc_html__(DIVIROIDS_PLUGIN_NAME . ' QRCode', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                   = esc_html__(DIVIROIDS_PLUGIN_NAME . ' QRCode', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                     = $this->parent_instance->module_slug . '-qrcode';
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
                'general'  => array(
                  'toggles' => array(
                    'main_content'              => esc_html__('Content', DIVIROIDS_PLUGIN_SLUG),
                  ),
                ),
                'advanced' => array(
                  'toggles' => array(
                    'qrcode_settings'           => esc_html__('Settings', DIVIROIDS_PLUGIN_SLUG),
                  ),
                ),
            );
        }

        // Get advanced fields
        public function get_advanced_fields_config()
        {
            return array(
              'fonts'                     => false,
              'text'                      => false,
              'button'                    => false,
              'filters'                   => false,
            );
        }

        // Get Custom CSS fields
        public function get_custom_css_fields_config()
        {
            return array(
              'qrcode' => array(
                  'label'    => esc_html__('QRCode', DIVIROIDS_PLUGIN_SLUG),
                  'selector' => '.dr-module-qrcode-item',
              ),
            );
        }

        // Get the Fields
        public function get_fields()
        {
            $fields = array(
              'qrcode_content' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__('Content', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('The content will be used to generate the QRCode. This can be a url or any type of content.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'text',
              ),
              'qrcode_render' => array(
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'qrcode_settings',
                'label'             => esc_html__('Render Type', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Choose how to render the QRCode. Warning, not all browsers support "Canvas". ', DIVIROIDS_PLUGIN_SLUG),
                'option_category'   => 'configuration',
                'type'              => 'select',
                'default_on_front'  => 'canvas',
                'options'           => array(
                  'canvas'    => esc_html__('Canvas', DIVIROIDS_PLUGIN_SLUG),
                  'image'     => esc_html__('Image', DIVIROIDS_PLUGIN_SLUG),
                  'div'       => esc_html__('Div', DIVIROIDS_PLUGIN_SLUG),
                ),
              ),
              'qrcode_ec_level' => array(
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'qrcode_settings',
                'label'             => esc_html__('Error Correction Level', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('Choose the correction level. Higher level improves errors capability but also increases data size of QRCode. ', DIVIROIDS_PLUGIN_SLUG),
                'option_category'   => 'configuration',
                'type'              => 'select',
                'default_on_front'  => 'H',
                'options'           => array(
                  'L'     => esc_html__('Low', DIVIROIDS_PLUGIN_SLUG),
                  'M'     => esc_html__('Medium', DIVIROIDS_PLUGIN_SLUG),
                  'Q'     => esc_html__('Quartile', DIVIROIDS_PLUGIN_SLUG),
                  'H'     => esc_html__('High', DIVIROIDS_PLUGIN_SLUG),
                ),
              ),
              'qrcode_bg_color' => array(
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'qrcode_settings',
                'label'             => esc_html__('Background Color', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('The background color of the QRCode. The default is white. ', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'color-alpha',
                'option_category'   => 'configuration',
                'default'           => '#ffffff',
              ),
              'qrcode_fg_color' => array(
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'qrcode_settings',
                'label'             => esc_html__('Foreground Color', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('The foreground color of the QRCode. The default is black. ', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'color-alpha',
                'option_category'   => 'configuration',
                'default'           => '#000000',
              ),
              'qrcode_size' => array(
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'width',
                'label'             => esc_html__('QRCode Size', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('The output size of the QRCode measured in px. ', DIVIROIDS_PLUGIN_SLUG),
                'option_category'   => 'configuration',
                'type'              => 'range',
                'default'           => '200px',
                'fixed_unit'        => 'px',
                'fixed_range'       => true,
                'allow_empty'       => false,
                'range_settings'    => array(
                  'min'   => '0',
                  'max'   => '500',
                  'step'  => '25'
                ),
              ),
            );

            return $fields;
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $qrcode_content               = $this->props['qrcode_content'];
            $qrcode_render                = $this->props['qrcode_render'];
            $qrcode_ec_level              = $this->props['qrcode_ec_level'];
            $qrcode_bg_color              = $this->props['qrcode_bg_color'];
            $qrcode_fg_color              = $this->props['qrcode_fg_color'];
            $qrcode_size                  = $this->props['qrcode_size'];

            // Add the module class names
            parent::add_module_classnames(true, true);

            // Set the data-options for qrcode
            $size = !empty($qrcode_size) ? DiviRoids_Library::parse_measurement_value($qrcode_size) : '200';
            $qrcode_options = array(
              'render'          => $qrcode_render,
              'size'            => $size,
              'text'            => $qrcode_content,
              'background'      => $qrcode_bg_color,
              'fill'            => $qrcode_fg_color,
              'ecLevel'         => $qrcode_ec_level,
            );

            $output = sprintf(
              '<div%1$s class="%2$s">
                %3$s
                <div class="dr-module-qrcode-items" data-options="%4$s">
                  <div class="dr-module-qrcode-item"></div>
                </div>
    			     </div> <!-- %5$s -->',
               $this->module_id($render_slug),
               $this->module_classname($render_slug),
               parent::render_additional_background_options(),
               htmlentities(json_encode($qrcode_options), ENT_QUOTES, 'UTF-8'),
               $render_slug
            );

            return $output;
        }
    }

endif;

new DiviRoids_Module_QRCode;
