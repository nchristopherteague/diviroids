<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Module ImageBeforeAfter
 *
 * @package    DiviRoids\Includes\Modules\ImageBeforeAfter\DiviRoids_Module_Rotator_ImageBeforeAfter_Item
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Rotator_ImageBeforeAfter_Item')) :

    class DiviRoids_Module_Rotator_ImageBeforeAfter_Item extends DiviRoids_Module_Builder_Base
    {
        public function init()
        {
            parent::init();

            $this->name                           = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Image', DIVIROIDS_PLUGIN_SLUG);
            $this->plural                         = esc_html__(DIVIROIDS_PLUGIN_NAME . ' Rotator - Images', DIVIROIDS_PLUGIN_SLUG);
            $this->slug                           = $this->parent_instance->module_slug . '-rotator-image-item';
            $this->type                           = 'child';
            $this->child_title_var                = 'src';
            $this->child_item_text                = esc_html__('Rotator - Image', DIVIROIDS_PLUGIN_SLUG);
            $this->advanced_setting_title_text    = esc_html__('New Rotator - Image', DIVIROIDS_PLUGIN_SLUG);
            $this->settings_text                  = esc_html__('Rotator - Image Settings', DIVIROIDS_PLUGIN_SLUG);
        }

        // Get Modal Toggles
        public function get_settings_modal_toggles()
        {
            return array(
              'general'  => array(
                'toggles' => array(
                  'main_content' => esc_html__('Image', DIVIROIDS_PLUGIN_SLUG),
                  'link'         => esc_html__('Link', DIVIROIDS_PLUGIN_SLUG),
                ),
              ),
              'advanced' => array(
                'toggles' => array(
                  'overlay'     => esc_html__('Overlay', DIVIROIDS_PLUGIN_SLUG),
                  'alignment'   => esc_html__('Alignment', DIVIROIDS_PLUGIN_SLUG),
                  'width'       => array(
                    'title'     => esc_html__('Sizing', DIVIROIDS_PLUGIN_SLUG),
                    'priority'  => 65,
                  ),
                  'animation'      => array(
                    'title'     => esc_html__('Animation', DIVIROIDS_PLUGIN_SLUG),
                    'priority'  => 110,
                  ),
                ),
              ),
              'custom_css' => array(
                'toggles' => array(
                  'attributes'  => array(
                    'title'     => esc_html__('Attributes', DIVIROIDS_PLUGIN_SLUG),
                    'priority'  => 95,
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
              'borders'               => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "{$this->main_css_element} .et_pb_image_wrap",
                            'border_styles' => "{$this->main_css_element} .et_pb_image_wrap",
                        ),
                    ),
                ),
              ),
              'box_shadow'            => array(
                'default' => array(
                    'css' => array(
                        'main'         => "{$this->main_css_element} .et_pb_image_wrap",
                        'custom_style' => true,
                    ),
                ),
              ),
              'max_width'             => array(
                'options' => array(
                    'max_width' => array(
                        'depends_show_if' => 'off',
                    ),
                ),
              ),
              'filters'               => array(
                'css' => array(
                  'main' => "{$this->main_css_element} .et_pb_image_wrap",
                ),
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'filters',
                ),
              ),
              'fonts'                 => false,
              'text'                  => false,
              'button'                => false,
              'animation'             => false,
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
            $animation_fields = parent::get_animation_fields();
            $fields = array(
            'src' => array(
              'label'              => esc_html__('Image URL', DIVIROIDS_PLUGIN_SLUG),
              'type'               => 'upload',
              'option_category'    => 'basic_option',
              'upload_button_text' => esc_attr__('Upload an image', DIVIROIDS_PLUGIN_SLUG),
              'choose_text'        => esc_attr__('Choose an Image', DIVIROIDS_PLUGIN_SLUG),
              'update_text'        => esc_attr__('Set As Image', DIVIROIDS_PLUGIN_SLUG),
              'hide_metadata'      => true,
              'affects'            => array(
                'alt',
                'title_text',
              ),
              'description'        => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', DIVIROIDS_PLUGIN_SLUG),
              'toggle_slug'        => 'main_content',
            ),
            'alt' => array(
              'label'           => esc_html__('Image Alternative Text', DIVIROIDS_PLUGIN_SLUG),
              'type'            => 'text',
              'option_category' => 'basic_option',
              'depends_show_if' => 'on',
              'depends_on'      => array(
                'src',
              ),
              'description'     => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', DIVIROIDS_PLUGIN_SLUG),
              'tab_slug'        => 'custom_css',
              'toggle_slug'     => 'attributes',
            ),
            'title_text' => array(
              'label'           => esc_html__('Image Title Text', DIVIROIDS_PLUGIN_SLUG),
              'type'            => 'text',
              'option_category' => 'basic_option',
              'depends_show_if' => 'on',
              'depends_on'      => array(
                'src',
              ),
              'description'     => esc_html__('This defines the HTML Title text.', DIVIROIDS_PLUGIN_SLUG),
              'tab_slug'        => 'custom_css',
              'toggle_slug'     => 'attributes',
            ),
            'show_in_lightbox' => array(
              'label'             => esc_html__('Open in Lightbox', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'configuration',
              'options'           => array(
                'off' => esc_html__('No', DIVIROIDS_PLUGIN_SLUG),
                'on'  => esc_html__('Yes', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'off',
              'affects'           => array(
                'url',
                'url_new_window',
                'use_overlay',
              ),
              'toggle_slug'       => 'link',
              'description'       => esc_html__('Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.', DIVIROIDS_PLUGIN_SLUG),
            ),
            'url' => array(
              'label'           => esc_html__('Link URL', DIVIROIDS_PLUGIN_SLUG),
              'type'            => 'text',
              'option_category' => 'basic_option',
              'depends_show_if' => 'off',
              'affects'         => array(
                'use_overlay',
              ),
              'description'     => esc_html__('If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', DIVIROIDS_PLUGIN_SLUG),
              'toggle_slug'     => 'link',
            ),
            'url_new_window' => array(
              'label'             => esc_html__('Url Opens', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'select',
              'option_category'   => 'configuration',
              'options'           => array(
                'off' => esc_html__('In The Same Window', DIVIROIDS_PLUGIN_SLUG),
                'on'  => esc_html__('In The New Tab', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'off',
              'depends_show_if'   => 'off',
              'toggle_slug'       => 'link',
              'description'       => esc_html__('Here you can choose whether or not your link opens in a new window', DIVIROIDS_PLUGIN_SLUG),
            ),
            'use_overlay' => array(
              'label'             => esc_html__('Image Overlay', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'layout',
              'options'           => array(
                'off' => esc_html__('Off', DIVIROIDS_PLUGIN_SLUG),
                'on'  => esc_html__('On', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'off',
              'affects'           => array(
                'overlay_icon_color',
                'hover_overlay_color',
                'hover_icon',
              ),
              'depends_show_if'   => 'on',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'overlay',
              'description'       => esc_html__('If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', DIVIROIDS_PLUGIN_SLUG),
            ),
            'overlay_icon_color' => array(
              'label'             => esc_html__('Overlay Icon Color', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'depends_show_if'   => 'on',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'overlay',
              'description'       => esc_html__('Here you can define a custom color for the overlay icon', DIVIROIDS_PLUGIN_SLUG),
            ),
            'hover_overlay_color' => array(
              'label'             => esc_html__('Hover Overlay Color', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'depends_show_if'   => 'on',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'overlay',
              'description'       => esc_html__('Here you can define a custom color for the overlay', DIVIROIDS_PLUGIN_SLUG),
            ),
            'hover_icon' => array(
              'label'               => esc_html__('Hover Icon Picker', DIVIROIDS_PLUGIN_SLUG),
              'type'                => 'select_icon',
              'option_category'     => 'configuration',
              'class'               => array( 'et-pb-font-icon' ),
              'depends_show_if'     => 'on',
              'tab_slug'            => 'advanced',
              'toggle_slug'         => 'overlay',
              'description'         => esc_html__('Here you can define a custom icon for the overlay', DIVIROIDS_PLUGIN_SLUG),
            ),
            'show_bottom_space' => array(
              'label'             => esc_html__('Show Space Below The Image', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'layout',
              'options'           => array(
                'on'      => esc_html__('Yes', DIVIROIDS_PLUGIN_SLUG),
                'off'     => esc_html__('No', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'on',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'margin_padding',
              'description'       => esc_html__('Here you can choose whether or not the image should have a space below it.', DIVIROIDS_PLUGIN_SLUG),
            ),
            'align' => array(
              'label'               => esc_html__('Image Alignment', DIVIROIDS_PLUGIN_SLUG),
              'type'            => 'text_align',
              'option_category' => 'layout',
              'options'         => et_builder_get_text_orientation_options(array( 'justified' )),
              'default_on_front' => 'left',
              'tab_slug'        => 'advanced',
              'toggle_slug'     => 'alignment',
              'description'     => esc_html__('Here you can choose the image alignment.', DIVIROIDS_PLUGIN_SLUG),
              'options_icon'    => 'module_align',
            ),
            'force_fullwidth' => array(
              'label'             => esc_html__('Force Fullwidth', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'layout',
              'options'           => array(
                'off' => esc_html__('No', DIVIROIDS_PLUGIN_SLUG),
                'on'  => esc_html__('Yes', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'off',
              'tab_slug'    => 'advanced',
              'toggle_slug' => 'width',
              'affects' => array(
                'max_width',
              ),
            ),
            'always_center_on_mobile' => array(
              'label'             => esc_html__('Always Center Image On Mobile', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'layout',
              'options'           => array(
                'on'  => esc_html__('Yes', DIVIROIDS_PLUGIN_SLUG),
                'off' => esc_html__('No', DIVIROIDS_PLUGIN_SLUG),
              ),
              'default_on_front' => 'on',
              'tab_slug'          => 'advanced',
              'toggle_slug'       => 'alignment',
            ),

          );

            $fields = array_merge($fields, $animation_fields);

            return $fields;
        }

        public function get_alignment()
        {
            $alignment = isset($this->props['align']) ? $this->props['align'] : '';
            return et_pb_get_alignment($alignment);
        }

        // Render the contents
        public function render($attrs, $content = null, $render_slug)
        {
            $src                      = $this->props['src'];
            $alt                      = $this->props['alt'];
            $title_text               = $this->props['title_text'];
            $url                      = $this->props['url'];
            $url_new_window           = $this->props['url_new_window'];
            $show_in_lightbox         = $this->props['show_in_lightbox'];
            $show_bottom_space        = $this->props['show_bottom_space'];
            $align                    = $this->get_alignment();
            $force_fullwidth          = $this->props['force_fullwidth'];
            $always_center_on_mobile  = $this->props['always_center_on_mobile'];
            $overlay_icon_color       = $this->props['overlay_icon_color'];
            $hover_overlay_color      = $this->props['hover_overlay_color'];
            $hover_icon               = $this->props['hover_icon'];
            $use_overlay              = $this->props['use_overlay'];

            // Handle svg image behaviour
            $src_pathinfo = pathinfo($src);
            $is_src_svg = isset($src_pathinfo['extension']) ? 'svg' === $src_pathinfo['extension'] : false;

            // overlay can be applied only if image has link or if lightbox enabled
            $is_overlay_applied = 'on' === $use_overlay && ('on' === $show_in_lightbox || ('off' === $show_in_lightbox && '' !== $url)) ? 'on' : 'off';

            if ('on' === $force_fullwidth) {
                ET_Builder_Element::set_style($render_slug, array(
                            'selector'    => '%%order_class%%',
                            'declaration' => 'max-width: 100% !important;',
                          ));

                ET_Builder_Element::set_style($render_slug, array(
                            'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
                          'declaration' => 'width: 100%;',
                          ));
            }

            if (! $this->_is_field_default('align', $align)) {
                ET_Builder_Element::set_style($render_slug, array(
                            'selector'    => '%%order_class%%',
                            'declaration' => sprintf(
                              'text-align: %1$s;',
                              esc_html($align)
                            ),
                          ));
            }

            if ('center' !== $align) {
                ET_Builder_Element::set_style($render_slug, array(
                            'selector'    => '%%order_class%%',
                            'declaration' => sprintf(
                              'margin-%1$s: 0;',
                              esc_html($align)
                            ),
                          ));
            }

            if ('on' === $is_overlay_applied) {
                if ('' !== $overlay_icon_color) {
                    ET_Builder_Element::set_style($render_slug, array(
                                'selector'    => '%%order_class%% .et_overlay:before',
                                'declaration' => sprintf(
                                  'color: %1$s !important;',
                                  esc_html($overlay_icon_color)
                                ),
                              ));
                }

                if ('' !== $hover_overlay_color) {
                    ET_Builder_Element::set_style($render_slug, array(
                                'selector'    => '%%order_class%% .et_overlay',
                                'declaration' => sprintf(
                                  'background-color: %1$s;',
                                  esc_html($hover_overlay_color)
                                ),
                              ));
                }

                $data_icon = '' !== $hover_icon ? sprintf(
                              ' data-icon="%1$s"',
                              esc_attr(et_pb_process_font_icon($hover_icon))
                            ) : '';

                $overlay_output = sprintf(
                              '<span class="et_overlay%1$s"%2$s></span>',
                              ('' !== $hover_icon ? ' et_pb_inline_icon' : ''),
                              $data_icon
                            );
            }

            // Set display block for svg image to avoid disappearing svg image
            if ($is_src_svg) {
                ET_Builder_Element::set_style($render_slug, array(
                            'selector'    => '%%order_class%% .et_pb_image_wrap',
                            'declaration' => 'display: block;',
                          ));
            }

            // Create the image output
            $output = sprintf(
                          '<span class="et_pb_image_wrap"><img src="%1$s" alt="%2$s"%3$s />%4$s</span>',
                          esc_attr($src),
                          esc_attr($alt),
                          ('' !== $title_text ? sprintf(' title="%1$s"', esc_attr($title_text)) : ''),
                          'on' === $is_overlay_applied ? $overlay_output : ''
                        );

            if ('on' === $show_in_lightbox) {
                $output = sprintf(
                              '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
                              esc_attr($src),
                              $output,
                              esc_attr($alt)
                            );
            } elseif ('' !== $url) {
                $output = sprintf(
                              '<a href="%1$s"%3$s>%2$s</a>',
                              esc_url($url),
                              $output,
                              ('on' === $url_new_window ? ' target="_blank"' : '')
                            );
            }

            // Add Class Names
            parent::add_module_classnames(false, false);
            $this->add_classname('dr-module-rotator-item', 1);

            if ('on' !== $show_bottom_space) {
                $this->add_classname('et_pb_image_sticky');
            }

            if ('on' === $is_overlay_applied) {
                $this->add_classname('et_pb_has_overlay');
            }

            if ('on' === $always_center_on_mobile) {
                $this->add_classname('et_always_center_on_mobile');
            }

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
                $output,
                $render_slug
              );

            return $output;
        }
    }

endif;

new DiviRoids_Module_Rotator_ImageBeforeAfter_Item;
