<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles common functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Queries
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Queries')) :

class DiviRoids_Queries
{

    #region Constants

    // DIVI constants
    const DIVIROIDS_DIVI_POST_TYPE_LAYOUT = 'et_pb_layout';

    #endregion

    #region Wordpress Queries

    /**
     * Query post types.
     *
     * @since		1.0.0
     * @access	public
     * @param   array $query_args
     * @return	array $query
     */
    public static function query_post_types($query_args = array())
    {
        $query_args   = wp_parse_args($query_args, array());
        $objects      = get_post_types($query_args, 'objects');
        $query        = array();

        foreach ($objects as $object) {
            $query[$object->name] = $object->label;
        }

        return $query;
    }

    /**
     * Query categories.
     *
     * @since		1.0.0
     * @access	public
     * @param   string $post_type
     * @return	array $query
     */
    public static function query_categories($post_type = 'post')
    {
        $taxonomies   = get_object_taxonomies($post_type, 'objects');
        $query        = array();

        if (!$taxonomies) {
            return $query;
        }

        foreach ($taxonomies as $key => $value) {
            if (! $value->hierarchical) {
                continue;
            }

            if ('nav_menu' === $key || 'link_category' === $key || 'post_format' === $key) {
                continue;
            }

            $objects = get_terms(array(
                  'taxonomy' =>$value->name,
                  'hide_empty' => false,
              ));

            foreach ($objects as $object) {
                $query[$object->term_id] = $object->name;
            }
        }

        return $query;
    }

    /**
     * Query posts.
     *
     * @since				1.0.0
     * @access			public
     * @param       array $query_args
     * @return			array $query
     */
    public static function query_posts($query_args = array())
    {
        $query_args   = wp_parse_args($query_args, array());
        $objects      = get_posts($query_args, 'objects');
        $query        = array();

        foreach ($objects as $object) {
            $query[$object->ID] = $object->post_title;
        }

        return $query;
    }

    #endregion

    #region Divi / ET Queries

    /**
     * Is post type registered with Divi.
     *
     * @since		1.0.0
     * @access	public
     * @param   string $post_type
     * @param   boolean $include_divi_library
     * @return  array $query
     */
    public static function is_divi_registered_post_type($post_type = 'post', $include_divi_library = false, $blacklisted = array())
    {
        $objects      = self::query_divi_registered_post_types($include_divi_library, $blacklisted);
        $included     = array_key_exists($post_type, $objects);

        return $included;
    }

    /**
     * Query divi registered post types.
     *
     * @since		1.0.0
     * @access	public
     * @param   boolean $include_divi_library
     * @return  array $query
     */
    public static function query_divi_registered_post_types($include_divi_library = false, $blacklisted = array())
    {
        require_once ET_BUILDER_DIR . 'class-et-builder-settings.php';
      
        $query                    = array();
        $et_post_type_options     = et_get_option('et_pb_post_type_integration', array());
        $et_post_type_registered  = ET_Builder_Settings::get_registered_post_type_options();

        foreach ($et_post_type_registered as $key => $value) {
            if (array_key_exists($key, $et_post_type_options) && 'off' === $et_post_type_options[$key]) {
                continue;
            }

            $query[$key] = $value;
        }

        // Add the Divi Library back in
        if ($include_divi_library) {
            if (!array_key_exists(self::DIVIROIDS_DIVI_POST_TYPE_LAYOUT, $et_post_type_registered)) {
                $query['et_pb_layout'] = 'Divi Library';
            }
        }

        if (!empty($blacklisted)) {
            foreach ($blacklisted as $value) {
                if (array_key_exists($value, $query)) {
                    unset($query[$value]);
                }
            }
        }

        return $query;
    }

    /**
     * Query divi library.
     *
     * @since				1.0.0
     * @access			public
     * @return			array $query
     */
    public static function query_divi_library()
    {
        $query      = self::query_posts(array(
          'post_type'         => self::DIVIROIDS_DIVI_POST_TYPE_LAYOUT,
          'posts_per_page'    => '-1',
          'post_status'       => 'publish',
          'meta_query'        => array(
              array(
                  'key'       => '_et_pb_predefined_layout',
                  'compare'   => 'NOT EXISTS',
              ),
              array(
                  'key'       => '_et_pb_built_for_post_type',
                  'value'     => 'page',
              ),
          )
        ));

        return $query;
    }

    /**
     * Checks to see if current post is from DiviLibrary
     *
     * @since				1.0.0
     * @access			public
     * @param       string $post_id
     * @return			boolean
     */
    public static function is_divi_library($post_id)
    {
        return self::DIVIROIDS_DIVI_POST_TYPE_LAYOUT === get_post_type($post_id);
    }

    #endregion

    #region Woocommerce Queries


    #endregion
}

endif;
