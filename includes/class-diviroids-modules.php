<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Modules
 *
 * @package    DiviRoids\Includes\DiviRoids_Modules
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Modules')) :

    class DiviRoids_Modules extends DiviRoids_Instance_Base
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
         * Enabled Modules.
         *
         * @since  1.0.0
         * @access public
         * @var    $modules
         */
        public $modules;

        /**
         * Module Slug.
         *
         * @since  1.0.0
         * @access public
         * @var    $module_slug
         */
        public $module_slug;

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
            // Setup the local properties
            $this->parent_instance      = DiviRoids();
            $this->name                 = 'modules';
            $this->hook                 = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->module_slug          = DIVIROIDS_PLUGIN_SLUG_ABBR . '-module';
            $this->dir                  = trailingslashit(DIVIROIDS_PLUGIN_INCLUDES_DIR . $this->name);
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

            // Load the settings
            $this->load_settings();

            // No Modules, just Exit
            if (empty($this->modules)) {
                return;
            }

            // Register all hooks
            $this->register_hooks();

            // Load the dependencies
            $this->load_dependencies();
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
            $this->modules = DiviRoids_Settings()->get($this->settings_prefix, true);
        }

        /**
         * Loads all of the dependencies.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_dependencies()
        {
            if (!class_exists('DiviRoids_Module_Loader_Instance_Base')) {
                DiviRoids_Library::load_files(DIVIROIDS_PLUGIN_MODULES_DIR . 'class-diviroids-module-loader-instance-base.php', true);
            }

            // Load Each Module
            $module_loaded = array();
            foreach ($this->modules as $module) {
                $module_name = explode('-', $module)[0];

                if (empty($module_name) || in_array($module_name, $module_loaded)) {
                    continue;
                }

                $module_loaded[] = $module_name;
                $file = $this->dir . $module_name . '/class-diviroids-module-loader-' . $module_name . '.php';
                DiviRoids_Library::load_files($file, false);
            }

            return true;
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            // initialize action
            add_action('init', array( $this, 'init' ), 10);

            // Admin init action
            add_action('admin_init', array( $this, 'admin_init' ), 10);

            // Add body class
            add_filter('body_class', array($this, 'body_class'), 99, 1);
            add_filter('admin_body_class', array($this, 'admin_body_class'), 99, 1);

            // Enqueue Styles and Scripts
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_styles' ));
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles' ));

            // Load the module
            add_action('et_builder_ready', array( $this, 'et_builder_ready' ), 10);
        }

        #endregion

        #region Public Functions

        /**
         * Executes during init action.
         *
         * @since  1.0.0
         * @access public
         */
        public function init()
        {
            // TODO: Handle the init event
        }

        /**
         * Executes during admin_init action.
         *
         * @since  1.0.0
         * @access public
         */
        public function admin_init()
        {
            //TODO: Handle the admin_init event
        }

        /**
          * Add classes to the body tag.
          *
          * @since		1.0.0
          * @param		array $classes Current body classes.
          * @return		array          Altered body classes.
          */
        public function body_class($classes)
        {
            $classes[] = $this->slug;
            return $classes;
        }

        /**
          * Add classes to the body tag.
          *
          * @since		1.0.0
          * @param		string $classes Current body classes.
          * @return		string          Altered body classes.
          */
        public function admin_body_class($classes)
        {
            return $classes . ' ' . $this->slug . ' ';
        }

        /**
         * Register all styles.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_styles()
        {
            // Load up the styles
            wp_enqueue_style(
              $this->slug,
              DIVIROIDS_PLUGIN_ASSETS_CSS_URL . $this->slug . '.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );
        }

        /**
         * Executes during et_builder_ready action.
         *
         * @since  1.0.0
         * @access public
         */
        public function et_builder_ready()
        {
            // Load the Module Builder Base
            if (!class_exists('DiviRoids_Module_Builder_Base')) {
                DiviRoids_Library::load_files(DIVIROIDS_PLUGIN_MODULES_DIR . '/class-diviroids-module-builder-base.php', true);
            }
        }

        #endregion
    }

  /**
   * Returns instance of this object.
   *
   * @since 1.0.0
   */
  function DiviRoids_Modules()
  {
      return DiviRoids_Modules::getInstance();
  }

endif;

DiviRoids_Modules();
