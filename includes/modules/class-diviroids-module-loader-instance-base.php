<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Base contains common singleton functionality.
 *
 * @package    DiviRoids\Modules\DiviRoids_Module_Loader_Instance_Base
 * @since      1.0.0
*/

abstract class DiviRoids_Module_Loader_Instance_Base extends DiviRoids_Instance_Base
{

    #region Variables

    /**
     * Enabled Modules.
     *
     * @since  1.0.0
     * @var    $modules
     */
    protected $modules;

    /**
     * CSS URL.
     *
     * @since  1.0.0
     * @var    $url_css
     */
    protected $url_css;

    /**
     * JS URL.
     *
     * @since  1.0.0
     * @var    $url_js
     */
    protected $url_js;

    /**
     * Has JS to load.
     *
     * @since  1.0.0
     * @var    $has_js
     */
    protected $has_js;

    /**
     * Has css to load.
     *
     * @since  1.0.0
     * @var    $has_css
     */
    protected $has_css;

    #endregion

    #region Constructors and Destructors

    /**
     * Parent constructor for the child class
     *
     * @since  1.0.0
     * @access protected
     */
    protected function __construct()
    {
    }

    /**
     * Initialize the class and set its properties.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function initialization()
    {
        $this->parent_instance      = DiviRoids_Modules();
        $this->url_css              = DIVIROIDS_PLUGIN_ASSETS_CSS_URL;
        $this->url_js               = DIVIROIDS_PLUGIN_ASSETS_JS_URL;
        $this->has_js               = true;
        $this->has_css              = true;
    }

    /**
     * Initialize the actions.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_actions()
    {
        // if this module is not enabled, just return
        /* TODO: enable this and add functionality for grouped modules. i.e. rotator, rotator-image, rotator-text, etc.
        $this->modules = DiviRoids_Settings()->get(DiviRoids_Settings()->settings_prefix_name . '-' . $this->parent_instance->name);
        if (empty($this->modules) || !in_array($this->name, $this->modules)) {
            return;
        }
        */

        // initialize action
        add_action('init', array( $this, 'init' ), 10);

        // Enqueue Styles and Scripts
        if ($this->has_js) {
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
        }
        if ($this->has_css) {
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_styles' ));
        }

        // Load the module
        add_action('et_builder_ready', array( $this, 'et_builder_ready' ), 20);
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
     * Register all styles.
     *
     * @since  1.0.0
     * @access public
     */
    public function enqueue_styles()
    {
        do_action($this->hook . '_before_enqueue_styles');

        wp_enqueue_style(
          $this->slug,
          $this->url_css . $this->slug . '.css',
          array(),
          DIVIROIDS_PLUGIN_VERSION,
          'all'
        );

        do_action($this->hook . '_after_enqueue_styles');
    }

    /**
     * Register all scripts.
     *
     * @since  1.0.0
     * @access public
     */
    public function enqueue_scripts()
    {
        do_action($this->hook . '_before_enqueue_scripts');

        wp_enqueue_script(
          $this->slug,
          $this->url_js . $this->slug . '.min.js',
          array( 'jquery' ),
          DIVIROIDS_PLUGIN_VERSION,
          false
        );

        do_action($this->hook . '_after_enqueue_scripts');
    }

    /**
     * Executes during et_builder_ready action.
     *
     * @since  1.0.0
     * @access public
     */
    public function et_builder_ready()
    {
        // Load the Modules
        $files = glob($this->dir . 'class-' . $this->slug . '*.php');
        DiviRoids_Library::load_files($files, true);
    }

    #endregion
}
