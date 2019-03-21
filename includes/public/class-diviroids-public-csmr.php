<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the CSMR Public
 *
 * @package    DiviRoids\Includes\Public\DiviRoids_Public_CSMR
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Public_CSMR')) :

    class DiviRoids_Public_CSMR extends DiviRoids_Instance_Base
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
         * enabled.
         *
         * @since  1.0.0
         * @access private
         */
        private $enabled;

        /**
         * status.
         *
         * @since  1.0.0
         * @access private
         */
        private $status;

        /**
         * mode.
         *
         * @since  1.0.0
         * @access private
         */
        private $mode;

        /**
         * layout.
         *
         * @since  1.0.0
         * @access private
         */
        private $layout;

        /**
         * Redirect.
         *
         * @since  1.0.0
         * @access private
         */
        private $redirect;

        /**
         * Bypass Roles.
         *
         * @since  1.0.0
         * @access private
         */
        private $bypass_roles;

        /**
         * Bypass Pages.
         *
         * @since  1.0.0
         * @access private
         */
        private $bypass_pages;

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
            $this->name                 = 'csmr';
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
            $this->status               = DiviRoids_Settings()->get($this->settings_prefix . '-status', true);
            $this->mode                 = DiviRoids_Settings()->get($this->settings_prefix . '-mode', true);
            $this->layout               = DiviRoids_Settings()->get($this->settings_prefix . '-layout', true);
            $this->redirect             = DiviRoids_Settings()->get($this->settings_prefix . '-redirect', true);
            $this->bypass_roles         = DiviRoids_Settings()->get($this->settings_prefix . '-bypass-roles', true);
            $this->bypass_pages         = DiviRoids_Settings()->get($this->settings_prefix . '-bypass-pages', true);

            if ($this->bypass_roles == null) {
                $this->bypass_roles = array();
            }
            if (DiviRoids_Security::is_user_administrator()) {
                array_push($this->bypass_roles, DIVIROIDS_PLUGIN_ADMIN_ROLE);
            }

            $enabled                    = DiviRoids_Library::parse_boolean_value($this->status);
            $this->enabled              = $enabled && $this->mode != '';
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            // Admin init action
            add_action('admin_init', array($this, 'bypass_override'));

            // Login action
            add_action('wp_login', array($this, 'bypass_override'));

            // Template Redirect Action
            add_action('template_redirect', array($this, 'template_redirect'));
        }

        /**
         * Check to see if current page is in page array .
         *
         * @since  1.0.0
         * @access private
         *
         * @return boolean if current page is considered a bypass page
         */
        public function is_bypass_page()
        {
            if (is_front_page() && is_home()) {
                $page_id = '-1'; // default homepage
            } elseif (is_front_page()) {
                $page_id = '-1'; // static homepage
            } elseif (is_home()) {
                $page_id = get_option('page_for_posts'); // posts page
            } else {
                $page_id = get_the_ID(); //everyting else
            }

            if (!empty($this->bypass_pages) && in_array($page_id, $this->bypass_pages)) {
                return true;
            }

            return false;
        }

        #endregion

        #region Public Functions

        /**
         * Executes during wp_login and admin_init actions.
         *
         * @since  1.0.0
         * @access public
         */
        public function bypass_override()
        {
            // if csmr is not enabled, return
            if (!$this->enabled) {
                return;
            }

            // if the user is logged in
            // check to see if they can bypass cmp
            if (is_user_logged_in() && !DiviRoids_Security::does_current_user_have_roles($this->bypass_roles)) {
                DiviRoids_Logger::alert($this->slug, DiviRoids_Security::get_current_user('user_login') . ' is logged in but does not have the roles to bypass CSMR. roles:' . implode(',', $this->bypass_roles));
                wp_logout();
                wp_redirect(get_bloginfo('url'));
                exit();
            }
        }

        /**
         * Executes during template_redirect action.
         *
         * @since  1.0.0
         * @access public
         */
        public function template_redirect()
        {
            // if csmr is not enabled, return
            if (!$this->enabled) {
                return;
            }

            // if user is logged in, make sure they have
            // the bypass role. This is already checked and should
            // always be true. However, i do want to keep this check here
            // as a precaution
            if (is_user_logged_in() && DiviRoids_Security::does_current_user_have_roles($this->bypass_roles)) {
                return;
            }

            // if the current page is considered
            // to be a bypass page, then just allow it.
            if ($this->is_bypass_page()) {
                return;
            }

            switch ($this->mode) {
                case 'coming_soon':
                case 'maintenance':

                  $template_file =  DIVIROIDS_PLUGIN_TEMPLATES_DIR . 'csmr.php' ;

                  if (!is_front_page() && !is_home()) {
                      wp_redirect(esc_url_raw(home_url('/')));
                      exit();
                  }

                  if ('maintenance' == $this->mode) {
                      // Add 503 Header
                      header('HTTP/1.1 503 Service Temporarily Unavailable');
                      header('Status: 503 Service Temporarily Unavailable');
                      header('Retry-After: 86400'); // retry in a day
                  }

                  require($template_file);

                  exit();
                  break;

                case 'redirect':
                  if (empty($this->redirect)) {
                      return;
                  }

                  wp_redirect(esc_url($this->redirect));
                  exit();
                  break;

                default:
                  return;
                  break;
            }

            return;
        }

        #endregion
    }

    function DiviRoids_Public_CSMR()
    {
        return DiviRoids_Public_CSMR::getInstance();
    }

endif;

DiviRoids_Public_CSMR();
