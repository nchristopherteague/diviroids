<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Modules
 *
 * @package    DiviRoids\Includes\Modules\QRCode\DiviRoids_Module_Loader_QRCode
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Module_Loader_QRCode')) :

    class DiviRoids_Module_Loader_QRCode extends DiviRoids_Module_Loader_Instance_Base
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
            parent::initialization();

            $this->name                 = 'qrcode';
            $this->hook                 = DIVIROIDS_PLUGIN_HOOK . '_module' . '_' . $this->name;
            $this->slug                 = DIVIROIDS_PLUGIN_SLUG . '-module' . '-' . $this->name;
            $this->dir                  = trailingslashit(DIVIROIDS_PLUGIN_MODULES_DIR . $this->name);
            $this->url_css              = esc_url(trailingslashit(DIVIROIDS_PLUGIN_MODULES_URL . $this->name .'/css'));
            $this->url_js               = esc_url(trailingslashit(DIVIROIDS_PLUGIN_MODULES_URL . $this->name .'/js'));

            parent::register_actions();

            add_action($this->hook . '_before_enqueue_scripts', array( $this, 'before_enqueue_scripts' ));
        }

        #endregion

        #region Public Functions

        /**
         * Register all scripts.
         *
         * @since  1.0.0
         * @access public
         */
        public function before_enqueue_scripts()
        {
            wp_enqueue_script(
              $this->slug . '-jquery-qrcode',
              $this->url_js . 'jquery-qrcode-0.14.0.min.js',
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
  function DiviRoids_Module_Loader_QRCode()
  {
      return DiviRoids_Module_Loader_QRCode::getInstance();
  }

endif;

DiviRoids_Module_Loader_QRCode();
