<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Security portions of DiviRoids.
 *
 * @package    DiviRoids\Security\DiviRoids_Security
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Security')) :

class DiviRoids_Security
{

    #region public static functions

    /**
      * Gets the current user
      *
      * @since			1.0.0
      * @access			public
      * @param      string $property
      * @return			mixed
      */
    public static function get_current_user($property = null)
    {
        $current_user = wp_get_current_user();

        if (0 === $current_user->ID) {
            return null;
        }

        if (empty($property)) {
            return $current_user;
        }

        return $current_user->{$property};
    }

    /**
     * Checks to see if user is administrator.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public static function is_user_administrator()
    {
        return current_user_can('administrator');
    }

    /**
     * Checks to see if user has correct capability.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			boolean
     */
    public static function is_user_capable($capability = null)
    {
        if (empty($capability)) {
            $capability = DIVIROIDS_PLUGIN_CAPABILITY;
        }

        return current_user_can($capability);
    }

    /**
     * Gets the current user roles.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			string
     */
    public static function get_editable_roles()
    {
        // Load any dependencies
        // not loaded by master
        if (! function_exists('get_editable_roles')) {
            require_once(ABSPATH . 'wp-admin/includes/user.php');
        }

        $all_roles = get_editable_roles();

        if (empty($all_roles)) {
            $all_roles = array(
                DIVIROIDS_PLUGIN_ADMIN_ROLE => ucfirst(DIVIROIDS_PLUGIN_ADMIN_ROLE),
                'editor'        => 'Editor',
                'author'        => 'Author',
                'contributor'   => 'Contributor',
            );
        }

        return $all_roles;
    }

    /**
     * Gets the current user roles.
     *
     * @since				1.0.0
     * @access			public
     *
     * @return			string
     */
    public static function get_current_user_roles()
    {
        return self::get_current_user('roles');
    }

    /**
     * Checks to see if current user has any of the roles.
     *
     * @since				1.0.0
     * @access			public
     * @param		    array $roles
     * @return			boolean
     */
    public static function does_current_user_have_roles($roles = null)
    {
        if (empty($roles)) {
            return false;
        }

        $user_roles = $roles;
        if (!is_array($user_roles)) {
            $user_roles = array();
            array_push($user_roles, $roles);
        }

        $current_user_roles = self::get_current_user_roles();
        if (array_intersect($roles, $current_user_roles)) {
            return true;
        }
        /*
                foreach ($current_user_roles as $role) {
                    if (in_array($role, (array)$roles)) {
                        return true;
                    }
                };
        */
        return false;
    }

    #endregion
}

endif;
