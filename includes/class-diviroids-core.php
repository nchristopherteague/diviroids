<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Core
 *
 * @package    DiviRoids\Includes\DiviRoids_Core
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Core')) :

    class DiviRoids_Core extends DiviRoids_Instance_Base
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
            $this->name                       = 'core';
            $this->hook                       = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                       = $this->parent_instance->slug . '-' . $this->name;
            $this->dir                        = trailingslashit(DIVIROIDS_PLUGIN_INCLUDES_DIR . $this->name);

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

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
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles' ));
            add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));
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

          // Add image sizes
            foreach (DiviRoids_Library::get_image_sizes() as $name => $size_info) {
                add_image_size($name, $size_info['width'], $size_info['height'], $size_info['crop']);
            }
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
            // Load up the fonts
            wp_enqueue_style(
              $this->slug . '-main-fonts',
              'http://fonts.googleapis.com/css?family=Dancing+Script|Raleway|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,latin-ext',
              false
            );

            // Load up the DiviRoids Animations
            wp_enqueue_style(
              $this->slug . '-animations',
              DIVIROIDS_PLUGIN_ASSETS_CSS_URL . $this->slug . '-animations.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );

            // Link the Animate css
            // https://daneden.github.io/animate.css/
            /*
            wp_enqueue_style(
              $this->slug . '-animate',
              'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );
            */
            
            // Link the CSS Animate css
            // https://cssanimation.io/index.html
            wp_enqueue_style(
              $this->slug . '-cssanimation',
              DIVIROIDS_PLUGIN_ASSETS_CSS_URL . 'cssanimation.min.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );

            // Load up the core styles
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
              $this->slug . '-letter-animation',
              DIVIROIDS_PLUGIN_ASSETS_JS_URL . 'letteranimation.min.js',
              array( 'jquery' ),
              DIVIROIDS_PLUGIN_VERSION,
              false
            );

            wp_enqueue_script(
              $this->slug . '-animator',
              DIVIROIDS_PLUGIN_ASSETS_JS_URL . 'diviroids-animator.min.js',
              array( 'jquery' ),
              DIVIROIDS_PLUGIN_VERSION,
              false
            );
        }

        #endregion
    }

  /**
   * Returns instance of this object.
   *
   * @since 1.0.0
   */
  function DiviRoids_Core()
  {
      return DiviRoids_Core::getInstance();
  }

endif;

DiviRoids_Core();
