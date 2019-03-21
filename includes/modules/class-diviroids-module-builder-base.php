<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Base contains common singleton functionality.
 *
 * @package    DiviRoids\Modules\DiviRoids_Module_Builder_Base
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Builder_Base')) :

abstract class DiviRoids_Module_Builder_Base extends ET_Builder_Module
{

    #region Variables

    /**
     * Parent Instance.
     *
     * @since  1.0.0
     * @var    $parent_instance
     */
    protected $parent_instance;

    #endregion

    #region Constructors and Destructors

    /**
     * Executes during init action.
     *
     * @since  1.0.0
     * @access public
     */
    public function init()
    {
        $this->parent_instance          = DiviRoids_Modules();
        $this->vb_support               = 'on';
        $this->main_css_element         = '%%order_class%%';
        $this->module_credits           = array(
            'module_uri' => 'http://www.diviroids.com',
            'author'     => 'DiviRoids Team',
            'author_uri' => 'http://www.diviroids.com',
        );
    }

    #endregion

    #region Private Functions


    #endregion

    #region Public Functions

    /**
     * Adds the primary class names
     *
     * @since  1.0.0
     * @access protected
     * @param boolean $add_clearfix
     */
    protected function add_module_classnames($add_mainmodule = true, $add_clearfix = false)
    {
        $additional_classnames = '';

        // Add the main module class name
        if ($add_mainmodule) {
            $this->add_classname('dr-module', 1);
        }

        // Add the animation
        if (isset($this->props['animation_style'])) {
            $animation_style = $this->props['animation_style'];
            if (! in_array($animation_style, array( '', 'none' ))) {
                $additional_classnames .= 'et-waypoint,';
            }
        }

        // Add the clearfix
        if ($add_clearfix) {
            $additional_classnames .= 'et-clearfix,';
        }

        if (!empty($additional_classnames)) {
            $this->add_classname(explode(',', $additional_classnames));
        }
    }


    /**
     * Get the Rotation Fields
     *
     * @since  1.0.0
     * @access protected
     * @return string $output
     */
    protected function get_rotation_fields($tab_slug = 'advanced', $toggle_slug = 'rotator_settings')
    {
        $fields = array(
            'rotation_repeat' => array(
              'label'             => esc_html__('Rotation Repeat', DIVIROIDS_PLUGIN_SLUG),
              'description'       => esc_html__('By default, rotations will continuously play. If you would like to end the rotation after the last item then can choose the Repeat option here.', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'select',
              'option_category'   => 'configuration',
              'default'           => 'true',
              'options'           => array(
                  'false'     => esc_html__('Once', DIVIROIDS_PLUGIN_SLUG),
                  'true'      => esc_html__('Loop', DIVIROIDS_PLUGIN_SLUG),
              ),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'rotation_delay' => array(
              'label'             => esc_html__('Rotation Delay (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'description'       => esc_html__('If you would like to add a delay before each rotation you can designate that delay here in milliseconds. This delay should be greater than durations used for each animation.', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '5000',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '10000',
                      'step' => '50',
              ),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'rotation_delay_first' => array(
              'label'             => esc_html__('Delay First Rotation', DIVIROIDS_PLUGIN_SLUG),
              'description'       => esc_html__('You can choose to apply the delay to first rotation item. If this is disabled, the first rotation item will be displayed when page loads.', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'yes_no_button',
              'option_category'   => 'configuration',
              'default'           => 'off',
              'default_on_front'  => 'off',
              'options'           => array(
                'off'   => esc_html__('No', DIVIROIDS_PLUGIN_SLUG),
                'on'    => esc_html__('Yes', DIVIROIDS_PLUGIN_SLUG),
              ),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),

          );

        return $fields;
    }

    /**
     * Render the drrotation options
     *
     * @since  1.0.0
     * @access protected
     * @return string $output
     */
    protected function render_rotation_options()
    {
        $output     = array();

        $rotation_repeat          = $this->props['rotation_repeat'];
        $rotation_delay           = $this->props['rotation_delay'];
        $rotation_delay_first     = $this->props['rotation_delay_first'];

        // Add the animation
        if (isset($rotation_delay) && !empty($rotation_delay)) {
            $output['delay']  = DiviRoids_Library::parse_measurement_value($rotation_delay);
        }
        if (isset($rotation_delay_first) && !empty($rotation_delay_first)) {
            $output['delayFirst']  = DiviRoids_Library::parse_boolean_value($rotation_delay_first);
        }
        if (isset($rotation_repeat) && !empty($rotation_repeat)) {
            $output['loop']  = DiviRoids_Library::parse_boolean_value($rotation_repeat);
        }

        return htmlentities(json_encode($output), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get the Animation Fields
     *
     * @since  1.0.0
     * @access protected
     * @return string $output
     */
    protected function get_animation_fields($includes = array(), $tab_slug = 'advanced', $toggle_slug = 'animation')
    {
        $animation_typeof_text   = in_array('typeof_text', $includes) ? true : false;

        // Create the Animation Type Options
        $animation_type_options = array();
        $animation_type_options['none'] = esc_html__('None', DIVIROIDS_PLUGIN_SLUG);
        $animation_type_options['animate'] = esc_html__('Animate', DIVIROIDS_PLUGIN_SLUG);

        if ($animation_typeof_text) {
            $animation_type_options['shuffle'] = esc_html__('Shuffle Text', DIVIROIDS_PLUGIN_SLUG);
            $animation_type_options['typing'] = esc_html__('Typing', DIVIROIDS_PLUGIN_SLUG);
        }

        // Create the Animation Type Affects
        $animation_type_affects = array('animation_effect', 'animation_repeat', 'animation_duration');

        if ($animation_typeof_text) {
            $animation_type_affects = array_merge($animation_type_affects, array('animation_text_sequential', 'animation_shuffle_steps', 'animation_shuffle_fps', 'animation_shuffle_back_speed', 'animation_shuffle_back_delay', 'animation_typing_speed', 'animation_typing_back_speed', 'animation_typing_back_delay'));
        }

        // Get the animations
        $animation_options = $animation_typeof_text ? DiviRoids_Options::get_text_animation_options() : DiviRoids_Options::get_animation_options();

        $fields = array(
          'animation_type' => array(
            'label'             => esc_html__('Animation Type', DIVIROIDS_PLUGIN_SLUG),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'default'           => 'none',
            'options'           => $animation_type_options,
            'affects'           => $animation_type_affects,
            'tab_slug'          => $tab_slug,
            'toggle_slug'       => $toggle_slug,
          ),
          'animation_effect'  => array(
            'label'             => esc_html__('Animation Effect', DIVIROIDS_PLUGIN_SLUG),
            'description'       => esc_html__('Select an animation effect to enable animations for this element.', DIVIROIDS_PLUGIN_SLUG),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'default'           => '',
            'options'           => $animation_options,
            'depends_show_if'   => 'animate',
            'depends_on'        => array('animation_type'),
            'tab_slug'          => $tab_slug,
            'toggle_slug'       => $toggle_slug,
          ),
          'animation_repeat' => array(
            'label'             => esc_html__('Animation Repeat', DIVIROIDS_PLUGIN_SLUG),
            'description'       => esc_html__('By default, animations will only play once. If you would like to loop your animation continuously you can choose the Loop option here.', DIVIROIDS_PLUGIN_SLUG),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'default'           => 'false',
            'options'           => array(
                'false'     => esc_html__('Once', DIVIROIDS_PLUGIN_SLUG),
                'true'      => esc_html__('Loop', DIVIROIDS_PLUGIN_SLUG),
            ),
            'depends_show_if'   => 'animate',
            'depends_on'        => array('animation_type'),
            'tab_slug'          => $tab_slug,
            'toggle_slug'       => $toggle_slug,
          ),
          'animation_duration' => array(
            'label'             => esc_html__('Animation Duration (in ms)', DIVIROIDS_PLUGIN_SLUG),
            'description'       => esc_html__('Speed up or slow down your animation by adjusting the animation duration. Units are in milliseconds and the default animation duration is one second.', DIVIROIDS_PLUGIN_SLUG),
            'type'              => 'range',
            'option_category'   => 'configuration',
            'default'           => '1000',
            'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '3000',
                    'step' => '50',
            ),
            'depends_show_if'   => 'animate',
            'depends_on'        => array('animation_type'),
            'tab_slug'          => $tab_slug,
            'toggle_slug'       => $toggle_slug,
          ),
        );

        if ($animation_typeof_text) {
            $fields = array_merge(
                $fields,
                array(
              'animation_text_sequential' => array(
                'label'             => esc_html__('Animation Sequential or Random', DIVIROIDS_PLUGIN_SLUG),
                'description'       => esc_html__('By default, text animations will be sequential.', DIVIROIDS_PLUGIN_SLUG),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'default'           => 'false',
                'options'           => array(
                    'sequence'     => esc_html__('Sequential', DIVIROIDS_PLUGIN_SLUG),
                    'random'      => esc_html__('Random', DIVIROIDS_PLUGIN_SLUG),
                ),
                'depends_show_if'   => 'animate',
                'depends_on'        => array('animation_type'),
                'tab_slug'          => $tab_slug,
                'toggle_slug'       => $toggle_slug,
              ),
            'animation_shuffle_steps' => array(
              'label'             => esc_html__('Shuffle Steps', DIVIROIDS_PLUGIN_SLUG),
              'description'       => esc_html__('Determine how many times a letter is changed.', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '10',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '50',
                      'step' => '1',
              ),
              'depends_show_if'   => 'shuffle',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_shuffle_fps' => array(
              'label'             => esc_html__('Shuffle Frames Per Second', DIVIROIDS_PLUGIN_SLUG),
              'description'       => esc_html__('Determine how many frames per second.', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '25',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '100',
                      'step' => '5',
              ),
              'depends_show_if'   => 'shuffle',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_shuffle_back_speed' => array(
              'label'             => esc_html__('Back Speed (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '100',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '500',
                      'step' => '10',
              ),
              'depends_show_if'   => 'shuffle',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_shuffle_back_delay' => array(
              'label'             => esc_html__('Delay Time Before Backspacing (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '1000',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '5000',
                      'step' => '100',
              ),
              'depends_show_if'   => 'shuffle',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_typing_speed' => array(
              'label'             => esc_html__('Typing Speed (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '100',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '500',
                      'step' => '10',
              ),
              'depends_show_if'   => 'typing',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_typing_back_speed' => array(
              'label'             => esc_html__('Back Speed (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '100',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '500',
                      'step' => '10',
              ),
              'depends_show_if'   => 'typing',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
            'animation_typing_back_delay' => array(
              'label'             => esc_html__('Delay Time Before Backspacing (in ms)', DIVIROIDS_PLUGIN_SLUG),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'           => '1000',
              'range_settings'    => array(
                      'min'  => '0',
                      'max'  => '5000',
                      'step' => '100',
              ),
              'depends_show_if'   => 'typing',
              'depends_on'        => array('animation_type'),
              'tab_slug'          => $tab_slug,
              'toggle_slug'       => $toggle_slug,
            ),
          )
            );
        }

        return $fields;
    }

    /**
     * Render the background options
     *
     * @since  1.0.0
     * @access protected
     * @return string $output
     */
    protected function render_additional_background_options()
    {
        $output    = '';
        $output   .= $this->video_background();
        $output   .= $this->get_parallax_image_background();

        return $output;
    }

    /**
     * Render the dranimation options
     *
     * @since  1.0.0
     * @access protected
     * @return string $output
     */
    protected function render_animation_options()
    {
        $output     = array();

        $animation_type                   = $this->props['animation_type'];
        $animation_effect                 = $this->props['animation_effect'];
        $animation_repeat                 = $this->props['animation_repeat'];
        $animation_duration               = $this->props['animation_duration'];
        $animation_text_sequential        = $this->props['animation_text_sequential'];
        $animation_shuffle_steps          = $this->props['animation_shuffle_steps'];
        $animation_shuffle_fps            = $this->props['animation_shuffle_fps'];
        $animation_shuffle_back_speed     = $this->props['animation_shuffle_back_speed'];
        $animation_shuffle_back_delay     = $this->props['animation_shuffle_back_delay'];
        $animation_typing_speed           = $this->props['animation_typing_speed'];
        $animation_typing_back_speed      = $this->props['animation_typing_back_speed'];
        $animation_typing_back_delay      = $this->props['animation_typing_back_delay'];

        // Add the animation
        $output['type'] = (isset($animation_type) && !empty($animation_type)) ? $animation_type : 'none';

        switch ($output['type']) {

          case 'animate':
            if (isset($animation_effect) && !empty($animation_effect)) {
                $output['effect']  = $animation_effect;
            }
            if (isset($animation_duration) && !empty($animation_duration)) {
                $output['duration']  = DiviRoids_Library::parse_measurement_value($animation_duration);
            }
            if (isset($animation_repeat) && !empty($animation_repeat)) {
                $output['loop']  = DiviRoids_Library::parse_boolean_value($animation_repeat);
            }
            if (isset($animation_text_sequential) && !empty($animation_text_sequential)) {
                $output['text_sequential'] = $animation_text_sequential;
            }

          break;

          case 'shuffle':

            if (isset($animation_shuffle_steps) && !empty($animation_shuffle_steps)) {
                $output['steps']  = DiviRoids_Library::parse_measurement_value($animation_shuffle_steps);
            }
            if (isset($animation_shuffle_fps) && !empty($animation_shuffle_fps)) {
                $output['fps']  = DiviRoids_Library::parse_measurement_value($animation_shuffle_fps);
            }
            if (isset($animation_shuffle_back_speed) && !empty($animation_shuffle_back_speed)) {
                $output['backspaceSpeed']  = DiviRoids_Library::parse_measurement_value($animation_shuffle_back_speed);
            }
            if (isset($animation_shuffle_back_delay) && !empty($animation_shuffle_back_delay)) {
                $output['backspaceDelay']  = DiviRoids_Library::parse_measurement_value($animation_shuffle_back_delay);
            }

          break;

          case 'typing':

          if (isset($animation_typing_speed) && !empty($animation_typing_speed)) {
              $output['typeSpeed']  = DiviRoids_Library::parse_measurement_value($animation_typing_speed);
          }
          if (isset($animation_typing_back_speed) && !empty($animation_typing_back_speed)) {
              $output['backspaceSpeed']  = DiviRoids_Library::parse_measurement_value($animation_typing_back_speed);
          }
          if (isset($animation_typing_back_delay) && !empty($animation_typing_back_delay)) {
              $output['backspaceDelay']  = DiviRoids_Library::parse_measurement_value($animation_typing_back_delay);
          }

          break;

          default:
          break;

        }

        return htmlentities(json_encode($output), ENT_QUOTES, 'UTF-8');
    }

    #endregion
}

endif;
