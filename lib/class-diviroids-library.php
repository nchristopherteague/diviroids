<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles common static functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Library
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Library')) :

class DiviRoids_Library
{

    #region Parse static functions

    /**
     * Parse measurement values.
     *
     * @since  1.0.0
     * @access public
     * @return string range value
     */
    public static function parse_measurement_value($measurement)
    {
        $measurement        = trim($measurement);
        $measurement_digit  = floatval($measurement);

        return $measurement_digit;
    }

    /**
     * Parse boolean values.
     *
     * @since  1.0.0
     * @access public
     * @return bool value
     */
    public static function parse_boolean_value($boolean)
    {
        return ('on' === $boolean || 1 === $boolean || '1' === $boolean || 'true' === $boolean || true === $boolean || 'yes' === $boolean);
    }

    #endregion

    #region Wordpress static functions

    /**
     * Checks to see if current page is part of this plugin
     *
     * @since				1.0.0
     * @access			public
     * @var      		string   	$slug
     *
     * @return			boolean
     */
    public static function is_plugin_page($slug)
    {
        require_once(ABSPATH . 'wp-admin/includes/screen.php');

        if (!function_exists('get_current_screen')) {
            require_once(ABSPATH . 'wp-admin/includes/screen.php');
        }

        $current_screen = get_current_screen();

        if (empty($current_screen)) {
            return false;
        }

        if (strpos($current_screen->id, $slug) === false) {
            return false;
        }

        return true;
    }

    #endregion

    #region File static functions

    /**
     * Load Files.
     *
     * @since				1.0.0
     * @access			public
     * @var      		array   	$files 			The files  to load.
     * @var      		boolean   $required   The file is required.
     *
     * @return			boolean
     */
    public static function load_files($files, $required = false)
    {
        if (empty($files)) {
            return false;
        }

        $files = is_array($files) ? $files : array( $files );

        foreach ($files as $file) {
            $required ? require_once($file) : include_once($file);
        }

        return true;
    }

    #endregion

    #region Array static functions

    /**
     * Merge second array with the first array with keys.
     *
     * @since				1.0.0
     * @access			public
     * @var      		array   	$array
     * @var      		array   	$array
     *
     * @return			array
     */
    public static function array_merge_with_keys($array1, $array2)
    {
        foreach ($array2 as $key => $value) {
            if (!array_key_exists($key, $array1)) {
                $array1[$key] = $value;
            }
        }

        return $array1;
    }

    /**
     * Returns array that matches based on a key value.
     *
     * @since				1.0.0
     * @access			public
     * @var      		array   	$array 			The array to search.
     * @var      		string  	$key	 			The field to search.
     * @var      		string  	$value 			The search criteria.
     *
     * @return			array
     */
    public static function search_array($array, $key, $value)
    {
        $results = array();

        if (!is_array($array)) {
            return $results;
        }

        if (isset($array[$key]) && $array[$key] == $value) {
            return $array;
        }

        foreach ($array as $subarray) {
            $results = self::search_array($subarray, $key, $value);
            if (!empty($results)) {
                return $results;
            }
        }

        return $results;
    }

    /**
     * Removes element from array.
     *
     * @since				1.0.0
     * @access			public
     * @var      		array   	$array 				The array to search.
     * @var     		string  	$key	 				The field to search.
     * @var      		string  	$value		 		The search criteria.
     *
     * @return		array
     */
    public static function remove_array($array, $key, $value, $within = false)
    {
        foreach ($array as $item_key => $item_values) {
            if ($within && stripos($item_values[$key], $value) !== false && (gettype($value) === gettype($item_values[$key]))) {
                unset($array[$item_key]);
            } elseif ($item_values[$key] === $value) {
                unset($array[$item_key]);
            }
        }

        return $array;
    }

    /**
     * Removes element from array.
     *
     * @since			1.0.0
     * @access			public
     * @var      	array   	$array 				The array to search.
     * @var     		string  	$key	 				The field to search.
     * @var      	string  	$value		 		The search criteria.
     *
     * @return			array
     */
    public static function sort_array($array, $key, $asc)
    {
        array_multisort(array_column($array, $key), $asc, $array);

        return $array;
    }

    /**
     * Gets element from array.
     *
     * @since			  1.0.0
     * @access			public
     * @var      	  array   	$array 				The array to search.
     * @var     		string  	$key	 				The field to search.
     *
     * @return			array
     */
    public static function get_array(array $array, $key)
    {
        // is in base array?
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        // check arrays contained in this array
        foreach ($array as $element) {
            if (is_array($element)) {
                if (multiKeyExists($element, $key)) {
                    return $element[$key];
                }
            }
        }

        return null;
    }

    /**
     * Gets all image sizes
     *
     * @since			  1.0.0
     * @access			public
     * @return			array
     */
    public static function get_image_sizes()
    {
        $sizes = array(
            'dr-image-small'         => array(
                'width'  => 440,
                'height' => 264,
                'crop'   => true,
            ),
        );

        return $sizes;
    }

    #endregion
}

endif;
