<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the 404 Public
 *
 * @package    DiviRoids\Includes\Public\DiviRoids_Public_404
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Public_404')) :

    class DiviRoids_Public_404 extends DiviRoids_Instance_Base
    {
        #region Variables

        /**
         * Settings prefix.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $settings_prefix;

        /**
         * 404 enabled.
         *
         * @since  1.0.0
         * @access private
         */
        private $enabled;

        /**
         * 404 layout.
         *
         * @since  1.0.0
         * @access private
         */
        private $layout;

        /**
         * 404 Template.
         *
         * @since  1.0.0
         * @access private
         */
        private $template;

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
            $this->parent_instance      = DiviRoids_Public();
            $this->name                 = '404';
            $this->hook                 = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

            // Get the settings
            $this->load_settings();

            // only execute enabled
            if (!$this->enabled) {
                return;
            }

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

        /**
         * Loads csmr settings.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_settings()
        {
            $this->layout       = DiviRoids_Settings()->get($this->settings_prefix . '-layout', true);
            $this->enabled      = !empty($this->layout);
            $this->template       = DiviRoids_Settings()->get($this->settings_prefix . '-template', true);
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            add_filter('404_template', array($this, 'custom_404_template'));
        }

        #endregion

        #region Public Functions

        /**
         * Executes during 404_template filter.
         *
         * @since  1.0.0
         * @access public
         */
        public function custom_404_template()
        {
            $template_file =  DIVIROIDS_PLUGIN_TEMPLATES_DIR . $this->template . '.php';
            return $template_file;
        }

        #endregion
    }

    function DiviRoids_Public_404()
    {
        return DiviRoids_Public_404::getInstance();
    }

endif;

DiviRoids_Public_404();
