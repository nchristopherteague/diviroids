<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the framework portions of DiviRoids
 *
 * @package    DiviRoids\Lib\DiviRoids_Framework
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Framework')) :

class DiviRoids_Framework extends DiviRoids_Instance_Base
{
    #region Variables

    /**
     * Required version of PHP.
     *
     * @since 1.0
     * @var string
     */
    public $php_version_required = '5.5';

    /**
     * Minimum version of WordPress required to use the library
     *
     * @since 1.0
     * @var string
     */
    public $wordpress_version_required = '4.2';

    #endregion

    #region Constructors and Destructors

    /**
     * Class constructor and initializer.
     *
     * @since				1.0.0
     * @access protected
     */
    protected function initialization()
    {
        $this->name = 'framework';
        $this->hook = DIVIROIDS_PLUGIN_HOOK . '_' . $this->name;
        $this->slug = DIVIROIDS_PLUGIN_SLUG . '-' . $this->name;

        // Load any dependencies
        // not loaded by master
        if (! function_exists('get_plugins')) {
            require_once(ABSPATH . '/wp-admin/includes/plugin.php');
        }
    }

    #endregion

    #region Private Functions

    /**
     * This function checks whether a specific plugin is installed, and returns information about it
     *
     * @since				1.0.0
     * @param  string $plugin_name Specify "Plugin Name" to return details about it.
     * @return array        Returns an array of details such as if installed, the name of the plugin and if it is active.
     */
    private function plugin_info($plugin_name)
    {
        $plugin_info['installed'] = false;
        $plugin_info['active']    = false;

        $plugins        = get_plugins();
        $active_plugins = get_option('active_plugins', array());

        foreach ($plugins as $key => $plugin) {

              // Only read info on selected plugin
            if ($key !== $plugin_name) {
                continue;
            }

            $plugin_info['installed'] = true;
            $plugin_info['name'] = $plugin['Name'];
            $plugin_info['full_name'] = $key;
            $plugin_info['version'] = $plugin['Version'];

            if (in_array($key, $active_plugins)) {
                $plugin_info['active'] = true;
            }

            break;
        }

        return $plugin_info;
    }

    #endregion

    #region Requirements Functions

    /**
     * Checks to see if license is valid
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function is_license_valid()
    {
        // TODO: Build out license functionality
        return true;
    }

    /**
     * Checks to see wordpress is correct version
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function is_wp_compatible()
    {
        return  version_compare($GLOBALS['wp_version'], $this->wordpress_version_required, '<') ?
                false :
                true;
    }

    /**
     * Checks to see php is correct version
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function is_php_compatible()
    {
        return  version_compare(PHP_VERSION, $this->php_version_required, '<') ?
              false :
              true;
    }

    /**
     * Checks to see if divi is currently active
     *
     * @since				1.0.0
     * @access			public
     * @return			boolean
     */
    public function is_divi_active()
    {
        // check if the themes exist
        $theme = wp_get_theme('Divi');
        if (!$theme->exists()) {
            return false;
        }

        // if function exist then return divi being active
        //if (function_exists('et_setup_theme')) {
        //return true;
        //}

        // Check to see if class file_exists
        $current_theme 	= wp_get_theme();
        $parent_theme 	= $current_theme->Name;
        $child_theme  	= $current_theme->Template;

        $is_active      = (stripos('divi', $parent_theme) !== false || stripos('divi', $child_theme) !== false) ? true : false;
        return $is_active;
    }

    /**
     * Checks to see if extra is currently active
     *
     * @since				1.0.0
     * @access			public
     * @return			boolean
     */
    public function is_extra_active()
    {
        // check if the themes exist
        $theme = wp_get_theme('Extra');
        if (!$theme->exists()) {
            return false;
        }

        // if function exist then return divi being active
        //if (function_exists('et_setup_theme')) {
        //return true;
        //}

        // Check to see if class file_exists
        $current_theme 	= wp_get_theme();
        $parent_theme 	= $current_theme->Name;
        $child_theme  	= $current_theme->Template;

        $is_active      = (stripos('extra', $parent_theme) !== false || stripos('extra', $child_theme) !== false) ? true : false;
        return $is_active;
    }

    /**
     * Checks to see if woocommerce is currently active
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function is_woocommerce_active()
    {
        return is_plugin_active('woocommerce/woocommerce.php');
    }

    #endregion

    #region Activation Functions

    /**
     * Activates the current plugin.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function activate()
    {
        $errors_found     = false;
        $error_title      =  DIVIROIDS_PLUGIN_NAME . ' - '. ucfirst(__(DiviRoids_Notices::ERROR . '(s)', DIVIROIDS_PLUGIN_SLUG));
        $error_message    = '';

        // Is User Capable
        if (!DiviRoids_Security::is_user_capable('activate_plugins')) {
            $errors_found   = true;
            $error_message .= sprintf(
                                'You do not have the capability of activating %1$s.<br>',
                                DIVIROIDS_PLUGIN_NAME
                              );
        }

        // Is WP Compatible
        if (!$this->is_wp_compatible()) {
            $errors_found   = true;
            $error_message .= sprintf(
                                'WordPress %2$s or newer is required for %1$s to run properly. Your current WordPress version is %3$s.<br>',
                                DIVIROIDS_PLUGIN_NAME,
                                $this->wordpress_version_required,
                                $GLOBALS['wp_version']
                              );
        }

        // Is PHP Compatible
        if (!$this->is_php_compatible()) {
            $errors_found   = true;
            $error_message .= sprintf(
                                'PHP %2$s or newer is required for %1$s to run properly. Your current PHP version is %3$s.<br>',
                                DIVIROIDS_PLUGIN_NAME,
                                $this->php_version_required,
                                PHP_VERSION
                              );
        }

        // Check if Divi is Active
        if (!$this->is_divi_active() && !$this->is_extra_active()) {
            $errors_found   = true;
            $error_message .= sprintf(
                                'Divi or Extra theme from <a href=\"%2$s\" target=\"_blank\">ElegantThemes</a> is required for %1$s to run properly. <a href=\"%2$s\" target=\"_blank\">Click here to obtain your copy of Divi or Extra Theme</a>.<br>',
                                DIVIROIDS_PLUGIN_NAME,
                                'http://www.elegantthemes.com'
                              );
        }

        if ($errors_found) {
            $error_message .= sprintf(
                              '<br><strong>%1$s</strong> has not been activated.',
                              DIVIROIDS_PLUGIN_NAME
                            );

            DiviRoids_Logger::error($error_title, $error_message);
            DiviRoids_Notices()->error('DiviRoids-Errors', $error_title, $error_message);

            deactivate_plugins(DIVIROIDS_PLUGIN_FILE);
            unset($_GET['activate']);
        }

        return !$errors_found;
    }

    #endregion

    #region Deactivation Functions

    /**
     * Deactivates the current plugin.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function deactivate()
    {

       // TODO: Deactivate functionality
    }

    #endregion

    #region Uninstall Functions

    /**
     * Uninstalls the current plugin.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function uninstall()
    {

       // TODO: Uninstall functionality

        // Delete all DiviRoids Options
        DiviRoids_Settings()->delete_all_options();

        // Flush cache
        wp_cache_flush();
    }

    #endregion

    #region Warning Checks Functions

    /**
     * Uninstalls the current plugin.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public function check_for_warnings()
    {
        $warnings_found   = false;
        $warning_title    =  DIVIROIDS_PLUGIN_NAME . ' - '. ucfirst(__(DiviRoids_Notices::WARNING . '(s)', DIVIROIDS_PLUGIN_SLUG));
        $warning_message  = '';

        // Check for warnings that prevent DiviRoids features not to run properly

        // Is Valid License
        if (!$this->is_license_valid()) {
            $warnings_found   = true;
            $warning_message .= sprintf(
                                '%1$s requires a valid license to work.<br>',
                                DIVIROIDS_PLUGIN_NAME
                              );
        }

        // Is Valid License
        if (!$this->is_woocommerce_active()) {
            $warnings_found   = true;
            $warning_message .= sprintf(
                              '%1$s requires <strong><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a></strong> to be active to or some features may not work.<br>',
                              DIVIROIDS_PLUGIN_NAME
                            );
        }

        if ($warnings_found) {
            $warning_message .= sprintf(
                   '<strong>%1$s</strong> may or may not function properly.',
                   DIVIROIDS_PLUGIN_NAME
                 );

            DiviRoids_Logger::warning($warning_title, $warning_message);
            DiviRoids_Notices()->warning('DiviRoids-Warnings', $warning_title, $warning_message);
        }

        return $warnings_found;
    }

    #endregion
}

/**
 * Returns instance of this object
 *
 * @since 1.0.0
 */
function DiviRoids_Framework()
{
    return DiviRoids_Framework::getInstance();
}

endif;

// self initialize
DiviRoids_Framework();
