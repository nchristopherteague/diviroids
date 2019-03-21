<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles options functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Settings
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Settings')) :

class DiviRoids_Settings extends DiviRoids_Instance_Base
{
    #region Variables

    /**
     * Settings for plugin.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $settings = array();

    /**
     * Acceptable options.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $acceptable_options = array();

    /**
     * Settings Prefix Name
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $settings_prefix_name;

    #endregion

    #region Constructors and Destructors

    /**
     * Class constructor and initializer.
     *
     * @since				1.0.0
     * @access protected
     */
    protected function initialization()
    {
        $this->name = 'settings';
        $this->hook = DIVIROIDS_PLUGIN_HOOK . '_' . $this->name;
        $this->slug = DIVIROIDS_PLUGIN_SLUG . '-' . $this->name;
        $this->settings_prefix_name = $this->slug;
        $this->acceptable_options = array('switch', 'switches', 'checkbox', 'checkboxes', 'select', 'select_multiple', 'text', 'textarea', 'password' );

        $this->load_settings();
    }

    #endregion

    #region Private Functions

    /**
     * Gets the default value from a setting.
     *
     * @since  1.0.0
     * @access private
     */
    private function get_option_default($option)
    {
        $tmparray = DiviRoids_Library::search_array($this->settings, 'id', $option);

        if (!is_array($tmparray)) {
            return null;
        }

        return isset($tmparray['default']) ? $tmparray['default'] : null;
    }

    /**
     * Checks to see if setting exist.
     *
     * @since  1.0.0
     * @access private
     */
    private function does_option_exist($option)
    {
        $options = wp_load_alloptions();
        return isset($options[$option]);
    }

    /**
     * Loads all settings.
     *
     * @since  1.0.0
     * @access private
     */
    private function load_settings()
    {
        $prefix = 'posttype-customizations';
        $this->settings[$prefix] = array(
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-columns',
             'name'                   => __('Custom columns on post types', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable custom columns for post types.', DIVIROIDS_PLUGIN_SLUG) . '<br><br><strong><a class="dr-input-switches-all" href="#">ENABLE ALL</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="dr-input-switches-none" href="#">DISABLE ALL</a></strong>',
             'type'			              => 'switches',
             'options'                => $this->get_cpt_columns_options(),
             'default'                => $this->get_cpt_columns_defaults(),
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-actions',
             'name'                   => __('Custom actions on post types', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable custom actions for post types.', DIVIROIDS_PLUGIN_SLUG) . '<br><br><strong><a class="dr-input-switches-all" href="#">ENABLE ALL</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="dr-input-switches-none" href="#">DISABLE ALL</a></strong>',
             'type'			              => 'switches',
             'options'                => $this->get_cpt_actions_options(),
             'default'                => $this->get_cpt_actions_defaults(),
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-columns-divilibrary',
             'name'                   => __('Custom columns on Divi Library', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable custom columns for Divi Library.', DIVIROIDS_PLUGIN_SLUG) . '<br><br><strong><a class="dr-input-switches-all" href="#">ENABLE ALL</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="dr-input-switches-none" href="#">DISABLE ALL</a></strong>',
             'type'			              => 'switches',
             'options'                => $this->get_divilibrary_columns_options(),
             'default'                => $this->get_divilibrary_columns_defaults(),
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
        );

        $prefix = 'customizations';
        $this->settings[$prefix] = array(
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-themeoptions-enhancements',
             'name'                   => __('Theme Options Enhancements', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable this option to enhance Theme Options screen. Includes permanently displaying help text for each option, floating the "Save Changes" button, and larger Custom CSS and Code Boxes. ', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switch',
             'default'                => 'off',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-divibuilder-enhancements',
             'name'                   => __('Divi Builder Enhancements', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable this option to enhance the Divi Builder. If you experience any design issues, just disable this option.', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switch',
             'default'                => 'off',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-visualbuilder-enhancements',
             'name'                   => __('Visual Builder Enhancements', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable this option to enhance the Visual Builder. If you experience any design issues, just disable this option.', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switch',
             'default'                => 'off',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
        );

        $prefix = 'modules';
        $this->settings[$prefix] = array(
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix,
             'name'                   => __('Modules', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Disable each module to prevent the module, css, scripts and/or any other resources for the module to load. <strong>WARNING!</strong> make sure this module is not being used before you disable it.', DIVIROIDS_PLUGIN_SLUG) . '<br><br><strong><a class="dr-input-switches-all" href="#">ENABLE ALL</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="dr-input-switches-none" href="#">DISABLE ALL</a></strong>',
             'type'			              => 'switches',
             'options'                => DiviRoids_Options::get_module_options(array('include_blank' => false)),
             'default'                => $this->get_module_defaults(),
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
        );

        $prefix = 'shortcodes';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'shortcodes',
              'type'                   => 'template'
          )
        );

        $prefix = 'single-post';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-post-tags',
              'name'                   => __('Post Tags', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Enable this option to add Post Tags to the top or bottom of single post layout.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'select',
              'options'                => DiviRoids_Options::get_post_tags_display_options(),
              'default'                => '0',
              'additional'             => '',
              'validation'             => '',
              'visibility'             => 'is_divi_theme'
          ),
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-pagination',
              'name'                   => __('Single Post Pagination', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Enable this option to pagination (similar to Extra) to the bottom of single post layout.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'switch',
              'default'                => 'off',
              'additional'             => 'Enabled|Disabled',
              'validation'             => '',
              'visibility'             => 'is_divi_theme'
          ),
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-author-box',
              'name'                   => __('About the Author', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Enable this option to add About the Author Box (similar to Extra) to the bottom of single post layout.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'switch',
              'default'                => 'off',
              'additional'             => 'Enabled|Disabled',
              'validation'             => '',
              'visibility'             => 'is_divi_theme'
          ),
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-related-post',
              'name'                   => __('Related Posts', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Enable this option to add Related Posts (similar to Extra) to the bottom of single post layout.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'switch',
              'default'                => 'off',
              'additional'             => 'Enabled|Disabled',
              'validation'             => '',
              'visibility'             => 'is_divi_theme'
          ),
          array(
            'id'                     => $this->settings_prefix_name . '-' . $prefix,
            'name'                   => 'post-type-layouts-extra',
            'type'                   => 'template',
            'visibility'             => 'is_extra_theme'
          )
        );

        $prefix = 'csmr';
        $this->settings['csmr'] = array(
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-status',
             'name'                   => __('Coming Soon / Maintenance / Redirect', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable this option to display coming soon or maintenance page to your visitors or redirect them to another url. ', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switch',
             'default'                => '',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => ''
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-mode',
             'name'                   => __('Mode', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('<strong>Coming Soon Mode</strong> will return HTTP 200 ok response code.<br><strong>Maintenance Mode</strong> will return HTTP 503 HTTP Service unavailable response code.<br><strong>Redirect Mode</strong> will redirect your visitors to another URL.', DIVIROIDS_PLUGIN_SLUG),
             'type'                   => 'select',
             'options'                => DiviRoids_Options::get_csmr_options(),
             'default'                => '',
             'additional'             => '',
             'validation'             => '',
             'visibility'             => 'is_csmr_enabled'
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-layout',
             'name'                   => __('Choose Layout', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Select a layout or a page to display to visitors.', DIVIROIDS_PLUGIN_SLUG),
             'type'                   => 'select',
             'options'                => DiviRoids_Options::get_divi_library_and_pages_options(),
             'default'                => '',
             'additional'             => '',
             'validation'             => '',
             'visibility'             => 'is_csmr_layout_visible'
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-redirect',
             'name'                   => __('Redirect URL', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enter the URL to redirect visitors.', DIVIROIDS_PLUGIN_SLUG),
             'type'                   => 'text',
             'default'                => '',
             'additional'             => '',
             'validation'             => 'url',
             'visibility'             => 'is_csmr_redirect_visible'
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-bypass-roles',
             'name'                   => __('Bypass User Roles', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable the User Roles to bypass the coming soon or maintenance landing page. <strong>Administrator</strong> role will always bypass the landing page by default.', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switches',
             'options'                => DiviRoids_Options::get_editable_roles_options(array('include_blank' => false)),
             'default'                => '',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => 'is_csmr_enabled'
          ),
          array(
             'id'                     => $this->settings_prefix_name . '-' . $prefix . '-bypass-pages',
             'name'                   => __('Bypass Pages', DIVIROIDS_PLUGIN_SLUG),
             'description'            => __('Enable the pages to bypass the coming soon or maintenance landing page.', DIVIROIDS_PLUGIN_SLUG),
             'type'			              => 'switches',
             'options'                => DiviRoids_Options::get_posts_options('page', -1, array('include_blank' => false)),
             'default'                => '',
             'additional'             => 'Enabled|Disabled',
             'validation'             => '',
             'visibility'             => 'is_csmr_enabled'
          ),
        );

        $prefix = '404';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-layout',
              'name'                   => __('Custom 404 Page', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Select a layout to display to visitors instead of the default 404 error page.<br>Custom 404 will return HTTP 404 HTTP Not Found response code.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'select',
              'options'                => DiviRoids_Options::get_divi_library_options(),
              'default'                => '',
              'additional'             => '',
              'validation'             => '',
              'visibility'             => ''
          ),
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix . '-template',
              'name'                   => __('Custom 404 Template', DIVIROIDS_PLUGIN_SLUG),
              'description'            => __('Select the template top use for the layout page.', DIVIROIDS_PLUGIN_SLUG),
              'type'                   => 'select',
              'options'                => DiviRoids_Options::get_404_template_options(),
              'default'                => '',
              'additional'             => '',
              'validation'             => '',
              'visibility'             => 'is_404_enabled'
          )
        );

        $prefix = 'css-hover';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'css-hover',
              'type'                   => 'template'
          )
        );

        $prefix = 'css-filters';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'css-filters',
              'type'                   => 'template'
          )
        );

        $prefix = 'css-transitions';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'css-transitions',
              'type'                   => 'template'
          )
        );

        $prefix = 'whats-coming';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'whats-coming',
              'type'                   => 'template'
          )
        );

        $prefix = 'support';
        $this->settings[$prefix] = array(
          array(
              'id'                     => $this->settings_prefix_name . '-' . $prefix,
              'name'                   => 'support',
              'type'                   => 'template'
          )
        );

        // allow hooks to add settings
        $this->settings = apply_filters($this->hook, $this->settings);
    }

    /**
     * Get Module Defaults.
     *
     * @since  1.0.0
     * @access private
     * @return array $options Module Defaults
     */
    private function get_module_defaults()
    {
        $options = DiviRoids_Options::get_module_options(array('include_blank' => false));
        return array_keys($options);
    }

    /**
     * Get CPT Columns Options.
     *
     * @since  1.0.0
     * @access private
     * @return array $options CPT Columns Options
     */
    private function get_cpt_columns_options()
    {
        $options                            = [];
        $options['diviroids_id']            = $this->get_custom_column_name('diviroids_id');
        $options['diviroids_permalink']     = $this->get_custom_column_name('diviroids_permalink');
        $options['diviroids_slug']          = $this->get_custom_column_name('diviroids_slug');
        $options['diviroids_status']        = $this->get_custom_column_name('diviroids_status');
        $options['diviroids_template']      = $this->get_custom_column_name('diviroids_template');

        return $options;
    }

    /**
     * Get CPT Columns Defaults.
     *
     * @since  1.0.0
     * @access private
     * @return array $options CPT Columns Defaults
     */
    private function get_cpt_columns_defaults()
    {
        return array();
    }

    /**
     * Get DiviLibrary Columns Options.
     *
     * @since  1.0.0
     * @access private
     * @return array $options DiviLibrary Columns Options
     */
    private function get_divilibrary_columns_options()
    {
        $options                              = [];
        $options['diviroids_id']              = $this->get_custom_column_name('diviroids_id');
        $options['diviroids_short_code']      = $this->get_custom_column_name('diviroids_short_code');

        return $options;
    }

    /**
     * Get DiviLibrary Columns Defaults.
     *
     * @since  1.0.0
     * @access private
     * @return array $options DiviLibrary Columns Defaults
     */
    private function get_divilibrary_columns_defaults()
    {
        return array();
    }

    /**
     * Get CPT Action Options.
     *
     * @since  1.0.0
     * @access private
     * @return array $options CPT Action Options
     */
    private function get_cpt_actions_options()
    {
        $options                                    = [];
        $options['diviroids_id']                    = 'ID';
        $options['diviroids_edit_visual_builder']   = 'Edit with Visual Builder';
        $options['diviroids_clone']                 = 'Clone';

        return $options;
    }

    /**
     * Get CPT Action Defaults.
     *
     * @since  1.0.0
     * @access private
     * @return array $options CPT Action Defaults
     */
    private function get_cpt_actions_defaults()
    {
        return array();
    }

    #endregion

    #region Public Functions

    /**
     * See if current theme is Divi.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_divi_theme()
    {
        return DiviRoids_Framework()->is_divi_active();
    }

    /**
     * See if current theme is Extra.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_extra_theme()
    {
        return DiviRoids_Framework()->is_extra_active();
    }

    /**
     * See if 404 mode is visible.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_404_enabled()
    {
        $key      = $this->settings_prefix_name . '-404-layout';
        $value    = DiviRoids_Settings()->get($key);
        $enabled  = !empty($value);

        return $enabled;
    }

    /**
     * See if CSMR mode is visible.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_csmr_enabled()
    {
        $key      = $this->settings_prefix_name . '-csmr-status';
        $value    = DiviRoids_Settings()->get($key);
        $enabled  = DiviRoids_Library::parse_boolean_value($value);

        return $enabled;
    }

    /**
     * See if CSMR Layout is visible.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_csmr_layout_visible()
    {
        $key      = $this->settings_prefix_name . '-csmr-mode';
        $value    = DiviRoids_Settings()->get($key);
        $enabled  = ('coming_soon' == $value || 'maintenance' == $value);

        return $enabled;
    }

    /**
     * See if CSMR Redirect is visible.
     *
     * @since  1.0.0
     * @access public
     * @return boolean
     */
    public function is_csmr_redirect_visible()
    {
        $key      = $this->settings_prefix_name . '-csmr-mode';
        $value    = DiviRoids_Settings()->get($key);
        $enabled  = ('redirect' == $value);

        return $enabled;
    }

    /**
     * Formats the password
     *
     * @since 		1.0.0
     * @access    public
     * @param     string   $data
     * @return 		string  formatted value
     */
    public function format_password($data)
    {
        return '************';
    }

    /**
     * Sanitizes and validates Options.
     *
     * @since 		1.0.0
     * @access    public
     * @param     string   $data submitted value
     * @param     string $type Type of field to validate
     * @return    string       Validated value
     */
    public function sanitize($data = '', $type = 'text')
    {
        switch ($type) {
          case 'text': $data = sanitize_text_field(stripslashes($data)); break;
          case 'number': $data = intval(stripslashes($data)); break;
          case 'url': $data = esc_url_raw(stripslashes($data)); break;
          case 'date_format': $data = sanitize_option('date_format', $data); break;
          case 'nohtml': $data = wp_filter_nohtml_kses(stripslashes($data)); break;
          case 'apikey': $data = sanitize_text_field(stripslashes($data)); break;
          case 'switch': $data = 'on'; break;
          case 'switches': is_array($data) ? $data = array_map('sanitize_text_field', stripslashes_deep($data)) : $data; break;
          case 'select': $data = sanitize_text_field(stripslashes($data)); break;
          case 'email': $data = is_email(sanitize_email(stripslashes($data))); break;

          default: $data = sanitize_text_field(stripslashes($data)); break;
        }

        return $data;
    }

    /**
     * Gets the Option.
     *
     * @access public
     * @param  string   $option key for the setting
     * @param  bool     $lookup_default
     * @param  mixed    $default_value default value for the setting
     * @return mixed    $Options
     */
    public function get($option, $lookup_default = false, $default_value = null)
    {
        // Get the Option
        if ($lookup_default) {
            $default_value = $this->get_option_default($option);
        }

        $data = get_option($option, $default_value);
        return $data;
    }

    /**
     * Deletes the Option.
     *
     * @access public
     * @param  string   $option key for the setting
     * @return boolean
     */
    public function delete($option)
    {
        return delete_option($option);
    }

    /**
     * Saves the Option.
     *
     * @access public
     * @param  string   $option key for the storage
     * @param  mixed    $data to be saved
     */
    public function save($option, $data)
    {
        update_option($option, $data);
    }

    /**
     * Deletes all Options.
     *
     * @access public
     */
    public function delete_all()
    {
        foreach ($this->settings as $setting_value) {
            foreach ($setting_value as $value) {
                $this->delete($value['id']);
            };
        };
    }

    /**
     * Set defaults
     *
     * @access public
     */
    public function set_defaults()
    {
        foreach ($this->settings as $setting_value) {
            foreach ($setting_value as $value) {
                $option_key             = $value['id'];
                $option_value           = !empty($value['default']) ? $value['default'] : '';
                $option_type            = $value['type'];

                if (!in_array($option_type, $this->acceptable_options)) {
                    continue;
                }

                $this->save($option_key, $option_value);
            };
        };
    }

    /**
     * Handles custom columns names
     *
     * @since  1.0.0
     * @access public
     */
    public function get_custom_column_name($column_key)
    {
        $output = null;

        switch ($column_key) {

            case 'diviroids_id':
              $output = __('ID', DIVIROIDS_PLUGIN_SLUG);
              break;

            case 'diviroids_short_code':
              $output = __('Short Code', DIVIROIDS_PLUGIN_SLUG);
              break;

            case 'diviroids_permalink':
              $output = __('Permalink', DIVIROIDS_PLUGIN_SLUG);
              break;

            case 'diviroids_slug':
              $output = __('Slug', DIVIROIDS_PLUGIN_SLUG);
              break;

            case 'diviroids_status':
              $output = __('Status', DIVIROIDS_PLUGIN_SLUG);
              break;

            case 'diviroids_template':
              $output = __('Template', DIVIROIDS_PLUGIN_SLUG);
              break;

            default:
              break;
        }

        return $output;
    }

    #endregion
}

/**
 * Returns instance of this object
 *
 * @since 1.0.0
 */
function DiviRoids_Settings()
{
    return DiviRoids_Settings::getInstance();
}

endif;

// self initialize
DiviRoids_Settings();
