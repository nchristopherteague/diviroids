<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Public
 *
 * @package    DiviRoids\Includes\DiviRoids_Public
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Public')) :

    class DiviRoids_Public extends DiviRoids_Instance_Base
    {

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
            $this->name                       = 'public';
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

            // Add body class
            add_filter('body_class', array($this, 'body_class'), 99, 1);

            // Enqueue Styles and Scripts
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_styles' ));
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

        #endregion
    }

  /**
   * Returns instance of this object.
   *
   * @since 1.0.0
   */
  function DiviRoids_Public()
  {
      return DiviRoids_Public::getInstance();
  }

endif;

DiviRoids_Public();
