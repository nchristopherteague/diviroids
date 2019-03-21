<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Admin_Settings Page
 *
 * @package    DiviRoids\Includes\Admin\DiviRoids_Admin_Settings
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Admin_Settings')) :

    class DiviRoids_Admin_Settings extends DiviRoids_Instance_Base
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
         * Settings prefix.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $settings_prefix;

        /**
         * Nonce name.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $action_nonce;

        /**
         * Save action.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $action_save;

        /**
         * Reset action.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $action_reset;

        #endregion

        #region Constructor and Destructors

        /**
         * Initialize the class and set its properties.
         *
         * @since  1.0.0
         * @access protected
         */
        protected function initialization()
        {
            // Set the parent instance
            $this->parent_instance      = DiviRoids_Admin();
            $this->name                 = 'settings';
            $this->hook                 = $this->parent_instance->hook . '_' . $this->name; //diviroids_admin_settings
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name; //diviroids-admin-settings
            $this->action_nonce         = $this->hook . '_nonce';
            $this->action_save          = $this->hook . '_save';
            $this->action_reset         = $this->hook . '_reset';
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name;

            // Load the Settings
            $this->load_settings();

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

        /**
         * Loads all settings.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_settings()
        {
            $this->settings = DiviRoids_Settings()->settings;
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            // Admin menu action
            add_action('admin_menu', array($this, 'admin_menu' ), 20);

            // Enqueue Styles and Scripts
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles' ));
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));

            // Add the action to save the settings
            add_action('wp_ajax_' . $this->action_save, array($this, 'save'));
            add_action('wp_ajax_' . $this->action_reset, array($this, 'save'));
        }

        /**
         * Saves the settings.
         *
         * @since  1.0.0
         * @access private
         */
        private function save_settings()
        {
            $Admin_Settings_page = !empty($_GET['page']) ? $_GET['page'] : basename(__FILE__);
            $redirect_url = esc_url_raw(add_query_arg('page', $Admin_Settings_page, admin_url('admin.php')));
            $action = $_POST['action'];

            check_ajax_referer($this->action_nonce);

            $acceptable_options = DiviRoids_Settings()->acceptable_options;

            if ($this->action_save == $action) {
                foreach ($this->settings as $setting_value) {
                    foreach ($setting_value as $value) {
                        $option_key             = $value['id'];
                        $option_type            = $value['type'];
                        $option_validation      = !empty($value['validation']) ? $value['validation'] : $option_type;

                        if (!in_array($option_type, $acceptable_options)) {
                            continue;
                        }

                        $option_visibility      = !empty($value['visibility']) ? call_user_func(array(DiviRoids_Settings(), $value['visibility'])) : true;
                        $option_default         = $value['default'];

                        // Let's check to see if the post contains this option
                        // if it does not, then this option needs to be removed
                        if (!isset($_POST[$option_key])) {
                            DiviRoids_Settings()->save($option_key, '');
                            continue;
                        }

                        // Set the value to default
                        // and only use the post value
                        // if this field was visibile
                        $option_value = $option_default;
                        if ($option_visibility) {
                            $option_value = !empty($_POST[$option_key]) ? $_POST[$option_key] : $option_default;
                            $option_value = DiviRoids_Settings()->sanitize($option_value, $option_validation);
                        }

                        DiviRoids_Settings()->save($option_key, $option_value);
                        DiviRoids_Logger::info($this->slug, 'DiviRoids Settings were updated successfully.');
                    };
                };
            } elseif ($this->action_reset == $action) {
                foreach ($this->settings as $setting_value) {
                    foreach ($setting_value as $value) {
                        $option_key             = $value['id'];
                        $option_value           = !empty($value['default']) ? $value['default'] : '';
                        $option_type            = $value['type'];

                        if (!in_array($option_type, $acceptable_options)) {
                            continue;
                        }

                        DiviRoids_Settings()->save($option_key, $option_value);
                        DiviRoids_Logger::info($this->slug, 'DiviRoids Settings were reset successfully.');
                    };
                };
            }
        }

        /**
         * Loads a template view.
         *
         * @since  1.0.0
         * @access private
         *
         * @param  string $template PHP file at includes/admin/templates, excluding file extension
         * @param  array  $data     Any data to pass to the view
         * @return void
         */
        private function load_template($template, $data = array())
        {
            $dir = trailingslashit($this->parent_instance->dir . 'templates');
            $file = $dir . $template . '.php';
            include($file);
        }

        #endregion

        #region Public Functions

        /**
         * Register all styles.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_styles()
        {
            wp_enqueue_style(
              $this->slug,
              DIVIROIDS_PLUGIN_ASSETS_CSS_URL . $this->slug . '.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );
        }

        /**
         * Register all scripts.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_scripts()
        {
            wp_enqueue_script(
              $this->slug,
              DIVIROIDS_PLUGIN_ASSETS_JS_URL . $this->slug . '.min.js',
              array( 'jquery' ),
              DIVIROIDS_PLUGIN_VERSION,
              false
            );

            wp_localize_script(
              $this->slug,
              $this->hook,
              array(
                'settings_nonce'  => wp_create_nonce($this->action_nonce),
                'action_save'     => $this->action_save,
                'action_reset'    => $this->action_reset,
              )
            );
        }

        /**
         * Creates the menu.
         *
         * @since  1.0.0
         * @access public
         */
        public function admin_menu()
        {
            add_submenu_page(
              $this->slug,
              ucfirst(__($this->name, DIVIROIDS_PLUGIN_SLUG)),
              ucfirst(__($this->name, DIVIROIDS_PLUGIN_SLUG)),
              $this->parent_instance->capability,
              $this->slug,
              array($this, 'render')
            );
        }

        /**
         * Render the page.
         *
         * @since  1.0.0
         * @access public
         */
        public function render()
        {
            // load and render
            $this->load_template('settings');
        }

        /**
         * Callback function to handle saving settings.
         *
         * @since  1.0.0
         * @access public
         */
        public function save()
        {
            $this->save_settings();
            die();
        }

        #endregion
    }

    function DiviRoids_Admin_Settings()
    {
        return DiviRoids_Admin_Settings::getInstance();
    }

endif;

DiviRoids_Admin_Settings();
