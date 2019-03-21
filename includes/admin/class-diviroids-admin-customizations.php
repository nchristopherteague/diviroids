<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Customizations
 *
 * @package    DiviRoids\Includes\Admin\DiviRoids_Admin_Customizations
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Admin_Customizations')) :

    class DiviRoids_Admin_Customizations extends DiviRoids_Instance_Base
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
         * $themeoptions_enhancements_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $themeoptions_enhancements_enabled
         */
        public $themeoptions_enhancements_enabled;

        /**
         * $divibuilder_enhancements_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $divibuilder_enhancements_enabled
         */
        public $divibuilder_enhancements_enabled;

        /**
         * $visualbuilder_enhancements_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $visualbuilder_enhancements_enabled
         */
        public $visualbuilder_enhancements_enabled;

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
            $this->name                 = 'customizations';
            $this->hook                 = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

            // Load the settings
            $this->load_settings();

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

        /**
         * Loads settings.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_settings()
        {
            $themeoptions_enhancements_value          = DiviRoids_Settings()->get($this->settings_prefix . '-themeoptions-enhancements', true);
            $this->themeoptions_enhancements_enabled  = DiviRoids_Library::parse_boolean_value($themeoptions_enhancements_value);

            $divibuilder_enhancements_value           = DiviRoids_Settings()->get($this->settings_prefix . '-divibuilder-enhancements', true);
            $this->divibuilder_enhancements_enabled   = DiviRoids_Library::parse_boolean_value($divibuilder_enhancements_value);

            $visualbuilder_enhancements_value           = DiviRoids_Settings()->get($this->settings_prefix . '-visualbuilder-enhancements', true);
            $this->visualbuilder_enhancements_enabled   = DiviRoids_Library::parse_boolean_value($visualbuilder_enhancements_value);
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles' ));
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
            // Load up the Theme Option Enhancements
            if ($this->themeoptions_enhancements_enabled) {
                wp_enqueue_style(
                $this->slug . '-themeoptions-enhancements',
                DIVIROIDS_PLUGIN_ASSETS_CSS_URL . 'diviroids-admin-customizations-themeoptions-enhancements.css',
                array(),
                DIVIROIDS_PLUGIN_VERSION,
                'all'
              );
            }

            // Load up the Divi Builder Enhancements
            if ($this->divibuilder_enhancements_enabled) {
                wp_enqueue_style(
                  $this->slug . '-divibuilder-enhancements',
                  DIVIROIDS_PLUGIN_ASSETS_CSS_URL . 'diviroids-admin-customizations-divibuilder-enhancements.css',
                  array(),
                  DIVIROIDS_PLUGIN_VERSION,
                  'all'
                );
            }

            // Load up the Visual Builder Enhancements
            if ($this->visualbuilder_enhancements_enabled) {
                wp_enqueue_style(
                  $this->slug . '-visualbuilder-enhancements',
                  DIVIROIDS_PLUGIN_ASSETS_CSS_URL . 'diviroids-public-customizations-visualbuilder-enhancements.css',
                  array(),
                  DIVIROIDS_PLUGIN_VERSION,
                  'all'
                );
            }
        }

        #endregion
    }

    function DiviRoids_Admin_Customizations()
    {
        return DiviRoids_Admin_Customizations::getInstance();
    }

endif;

DiviRoids_Admin_Customizations();
