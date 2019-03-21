<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Admin
 *
 * @package    DiviRoids\Includes\DiviRoids_Admin
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Admin')) :

    class DiviRoids_Admin extends DiviRoids_Instance_Base
    {
        #region Variables

        /**
         * Capability for this class.
         *
         * @since  1.0.0
         * @access public
         * @var    $capability
         */
        public $capability;

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
            $this->parent_instance            = DiviRoids();
            $this->capability                 = 'manage_options';
            $this->name                       = 'admin';
            $this->hook                       = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                       = $this->parent_instance->slug . '-' . $this->name;
            $this->dir                        = trailingslashit(DIVIROIDS_PLUGIN_INCLUDES_DIR . $this->name);

            // Register all hooks
            $this->register_hooks();

            // Load the dependencies
            $this->load_dependencies();
        }

        #endregion

        #region Private Functions

        /**
         * Loads all of the dependencies.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_dependencies()
        {
            $files = glob($this->dir . 'class-diviroids-*.php');
            DiviRoids_Library::load_files($files, false);

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

            // Admin menu action
            add_action('admin_menu', array($this, 'admin_menu' ), 10);

            // Add body class
            add_filter('admin_body_class', array($this, 'admin_body_class'), 99, 1);

            // Enqueue Styles and Scripts
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles' ));
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));

            //add_action('admin_footer', array($this, 'admin_footer'));
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
         * Creates the menu for admin.
         *
         * @since  1.0.0
         * @access public
         */
        public function admin_menu()
        {
            add_menu_page(
              DIVIROIDS_PLUGIN_NAME,
              DIVIROIDS_PLUGIN_NAME,
              $this->capability,
              $this->slug . '-settings',
              null,
              DIVIROIDS_PLUGIN_GEARS_BASE64
              //DIVIROIDS_PLUGIN_ASSETS_URL. 'images/logo-gears-animated.svg'
            );
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
            if (DiviRoids_Library::is_plugin_page(DIVIROIDS_PLUGIN_SLUG) === false) {
                return;
            }

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
        }

        /**
         * Callback function to admin_footer.
         *
         * @since  1.0.0
         * @access public
         */
        public function admin_footer()
        {
            $output = sprintf(
            '<div id="dr-action-panel-save">
              <div class="dr-action-panel-saving"><img src="%1$s" alt="loading" id="loading" /></div>
              <div class="dr-action-panel-saved"></div>
            </div><!-- dr-action-save -->
            <div id="dr-action-panel-confirm" class="dr-modal dr-modal-transition">
              <div class="dr-modal-content">
                <h3 class="dr-modal-content-title">%2$s</h3>
                <div>
                  <p class="dr-modal-content-description">%3$s</p>
                  <div class="clearfix"></div>
                  <span class="dr-modal-action-no">%4$s</span>
                  <span class="dr-modal-action-yes">%5$s</span>
                </div>
              </div>
            </div><!-- dr-action-confirm -->
            <div class="dr-modal-overlay"></div>',
             DIVIROIDS_PLUGIN_ASSETS_URL . 'images/divi-loader.gif',
             __('Clone', DIVIROIDS_PLUGIN_SLUG),
             __('This will clone the selected post. <strong>Are you sure you want to do this?</strong>', DIVIROIDS_PLUGIN_SLUG),
             __('No', DIVIROIDS_PLUGIN_SLUG),
             __('Yes', DIVIROIDS_PLUGIN_SLUG)
          );

            echo $output;
        }

        #endregion
    }

  /**
   * Returns instance of this object.
   *
   * @since 1.0.0
   */
  function DiviRoids_Admin()
  {
      return DiviRoids_Admin::getInstance();
  }

endif;

DiviRoids_Admin();
