<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles options functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Options
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Options')) :

class DiviRoids_Options
{

  /**
   * Get post types options.
   *
   * @since   1.0.0
   * @access  public
   * @param   array $query_args
   * @param   array $option_args
   * @return  array $options
   */
    public static function get_post_types_options($query_args = array(), $option_args = array())
    {
        $query_args     = wp_parse_args($query_args, array('show_ui' => true));
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Post Type'));
        $query          = DiviRoids_Queries::query_post_types($query_args);
        $options        = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options = DiviRoids_Library::array_merge_with_keys($options, $query);

        return $options;
    }

    /**
     * Get categories options.
     *
     * @since   1.0.0
     * @access  public
     * @param   string $post_type
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_categories_options($post_type = 'post', $option_args = array())
    {
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Category'));
        $query          = DiviRoids_Queries::query_categories($post_type);
        $options        = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options = DiviRoids_Library::array_merge_with_keys($options, $query);

        return $options;
    }

    /**
     * Get posts options.
     *
     * @since   1.0.0
     * @access  public
     * @param   string $post_type
     * @param   int $number_posts
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_posts_options($post_type = 'post', $number_posts = -1, $option_args = array())
    {
        $query          = DiviRoids_Queries::query_posts(array('post_type' => $post_type, 'numberposts' => $number_posts, 'post_status' => 'publish'));
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Post'));
        $options        = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options = DiviRoids_Library::array_merge_with_keys($options, $query);

        return $options;
    }

    /**
     * Get divi library Options.
     *
     * @since   1.0.0
     * @access  public static
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_divi_library_options($option_args = array())
    {
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Layout'));
        $options        = array();
        $query          = DiviRoids_Queries::query_divi_library();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options = DiviRoids_Library::array_merge_with_keys($options, $query);

        return $options;
    }

    /**
     * Get 404 Templates.
     *
     * @since   1.0.0
     * @access  public static
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_404_template_options($option_args = array())
    {
        $option_args    = wp_parse_args($option_args, array('include_blank' => false, 'blank_key' => '', 'blank_value' => 'Select Template'));
        $options        = array();
        $query          = DiviRoids_Queries::query_divi_library();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options['404']             = 'Sidebar';
        $options['404_nosidebar']   = 'No Sidebar';

        return $options;
    }

    /**
     * Get divi library and pages combined options.
     *
     * @since   1.0.0
     * @access  public
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_divi_library_and_pages_options($option_args = array())
    {
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Layout or Page'));
        $options        = array();
        $layouts        = self::get_divi_library_options(array('include_blank' => false));
        $pages          = self::get_posts_options('page', -1, array('include_blank' => false));
        $options        = [];

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        foreach ($layouts as $key => $value) {
            if (!empty($key)) {
                $options[$key] = $value . ' - LAYOUT';
            }
        }

        foreach ($pages as $key => $value) {
            if (!empty($key)) {
                $options[$key] = $value . ' - PAGE';
            }
        }

        return $options;
    }

    /**
     * Get editable roles.
     *
     * @since   1.0.0
     * @access  public
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_editable_roles_options($option_args = array())
    {
        $option_args    = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Role'));
        $options        = array();
        $query          = DiviRoids_Security::get_editable_roles();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        foreach ($query as $role => $details) {
            if ($role != DIVIROIDS_PLUGIN_ADMIN_ROLE) {
                $options[$role] = $details['name'];
            }
        }

        return $options;
    }

    /**
     * Get CSMR options.
     *
     * @since   1.0.0
     * @access  public
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_post_tags_display_options($option_args = array())
    {
        $options        = array();
        $options['0']   = 'Disabled';
        $options['1']   = 'Above Post Content';
        $options['2']   = 'Below Post Content';

        return $options;
    }



    /**
     * Get CSMR options.
     *
     * @since   1.0.0
     * @access  public
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_csmr_options($option_args = array())
    {
        $option_args              = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Mode'));
        $options                  = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options['coming_soon']   = 'Coming Soon Mode';
        $options['maintenance']   = 'Maintenance Mode';
        $options['redirect']      = 'Redirect Mode';

        return $options;
    }

    /**
     * Get module options.
     *
     * @since   1.0.0
     * @access  public
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_module_options($option_args = array())
    {
        $option_args                        = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Module'));
        $options                            = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        //$options['imagebeforeafter']        = 'Image - Before and After';
        $options['qrcode']                  = 'QRCode';
        $options['rotator-content']         = 'Rotator - Content';
        $options['rotator-divilibrary']     = 'Rotator - Divi Library';
        $options['rotator-image']           = 'Rotator - Image';
        $options['rotator-text']            = 'Rotator - Text';
        $options['rotator-quote']           = 'Rotator - Quote';

        return $options;
    }

    /**
     * Get vendor animate options.
     *
     * @since   1.0.0
     * @access  public static
     * @param   array $option_args
     * @return  array $options
     */
    /*
    public static function get_vendor_animate_options($option_args = array())
    {
        $option_args                      = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Animation'));
        $options                          = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options['bounce']                = 'bounce';
        $options['flash']                 = 'flash';
        $options['pulse']                 = 'pulse';
        $options['rubberBand']            = 'rubberBand';
        $options['shake']                 = 'shake';
        $options['headShake']             = 'headShake';
        $options['swing']                 = 'swing';
        $options['tada']                  = 'tada';
        $options['wobble']                = 'wobble';
        $options['jello']                 = 'jello';
        $options['bounceIn']              = 'bounceIn';
        $options['bounceInDown']          = 'bounceInDown';
        $options['bounceInLeft']          = 'bounceInLeft';
        $options['bounceInRight']         = 'bounceInRight';
        $options['bounceInUp']            = 'bounceInUp';
        $options['bounceOut']             = 'bounceOut';
        $options['bounceOutDown']         = 'bounceOutDown';
        $options['bounceOutLeft']         = 'bounceOutLeft';
        $options['bounceOutRight']        = 'bounceOutRight';
        $options['bounceOutUp']           = 'bounceOutUp';
        $options['fadeIn']                = 'fadeIn';
        $options['fadeInDown']            = 'fadeInDown';
        $options['fadeInDownBig']         = 'fadeInDownBig';
        $options['fadeInLeft']            = 'fadeInLeft';
        $options['fadeInLeftBig']         = 'fadeInLeftBig';
        $options['fadeInRight']           = 'fadeInRight';
        $options['fadeInRightBig']        = 'fadeInRightBig';
        $options['fadeInUp']              = 'fadeInUp';
        $options['fadeInUpBig']           = 'fadeInUpBig';
        $options['fadeOut']               = 'fadeOut';
        $options['fadeOutDown']           = 'fadeOutDown';
        $options['fadeOutDownBig']        = 'fadeOutDownBig';
        $options['fadeOutLeft']           = 'fadeOutLeft';
        $options['fadeOutLeftBig']        = 'fadeOutLeftBig';
        $options['fadeOutRight']          = 'fadeOutRight';
        $options['fadeOutRightBig']       = 'fadeOutRightBig';
        $options['fadeOutUp']             = 'fadeOutUp';
        $options['fadeOutUpBig']          = 'fadeOutUpBig';
        $options['flip']                  = 'flip';
        $options['flipInX']               = 'flipInX';
        $options['flipInY']               = 'flipInY';
        $options['flipOutX']              = 'flipOutX';
        $options['flipOutY']              = 'flipOutY';
        $options['lightSpeedIn']          = 'lightSpeedIn';
        $options['lightSpeedOut']         = 'lightSpeedOut';
        $options['rotateIn']              = 'rotateIn';
        $options['rotateInDownLeft']      = 'rotateInDownLeft';
        $options['rotateInDownRight']     = 'rotateInDownRight';
        $options['rotateInUpLeft']        = 'rotateInUpLeft';
        $options['rotateInUpRight']       = 'rotateInUpRight';
        $options['rotateOut']             = 'rotateOut';
        $options['rotateOutDownLeft']     = 'rotateOutDownLeft';
        $options['rotateOutDownRight']    = 'rotateOutDownRight';
        $options['rotateOutUpLeft']       = 'rotateOutUpLeft';
        $options['rotateOutUpRight']      = 'rotateOutUpRight';
        $options['slideInUp']             = 'slideInUp';
        $options['slideInDown']           = 'slideInDown';
        $options['slideInLeft']           = 'slideInLeft';
        $options['slideInRight']          = 'slideInRight';
        $options['slideOutUp']            = 'slideOutUp';
        $options['slideOutDown']          = 'slideOutDown';
        $options['slideOutLeft']          = 'slideOutLeft';
        $options['slideOutRight']         = 'slideOutRight';
        $options['zoomIn']                = 'zoomIn';
        $options['zoomInDown']            = 'zoomInDown';
        $options['zoomInLeft']            = 'zoomInLeft';
        $options['zoomInRight']           = 'zoomInRight';
        $options['zoomInUp']              = 'zoomInUp';
        $options['zoomOut']               = 'zoomOut';
        $options['zoomOutDown']           = 'zoomOutDown';
        $options['zoomOutLeft']           = 'zoomOutLeft';
        $options['zoomOutRight']          = 'zoomOutRight';
        $options['zoomOutUp']             = 'zoomOutUp';
        $options['hinge']                 = 'hinge';
        $options['jackInTheBox']          = 'jackInTheBox';
        $options['rollIn']                = 'rollIn';
        $options['rollOut']               = 'rollOut';

        return $options;
    }
    */

    /**
     * Get animation options.
     *
     * @since   1.0.0
     * @access  public static
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_animation_options($option_args = array())
    {
        $option_args                      = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Animation'));
        $options                          = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options['hu__hu__'] = 'hu... hu...';
        $options['effect3d'] = '3D Effect';
        $options['pepe'] = 'Pe Pe';
        $options['lightning'] = 'Lightning';
        $options['typing'] = 'Typing';
        $options['electricity'] = 'Electricity';
        $options['wipe'] = 'Wipe';
        $options['open'] = 'Open';
        $options['fadeIn'] = 'Fade In';
        $options['fadeInLeft'] = 'Fade In Left';
        $options['fadeInRight'] = 'Fade In Right';
        $options['fadeInTop'] = 'Fade In Top';
        $options['fadeInBottom'] = 'Fade In Bottom';
        $options['fadeOut'] = 'Fade Out';
        $options['fadeOutLeft'] = 'Fade Out Left';
        $options['fadeOutRight'] = 'Fade Out Right';
        $options['fadeOutTop'] = 'Fade Out Top';
        $options['fadeOutBottom'] = 'Fade Out Bottom';
        $options['moveFromLeft'] = 'Move From Left';
        $options['moveFromRight'] = 'Move From Right';
        $options['moveFromTop'] = 'Move From Top';
        $options['moveFromBottom'] = 'Move From Bottom';
        $options['moveToLeft'] = 'Move To Left';
        $options['moveToRight'] = ' Move To Right';
        $options['moveToTop'] = 'Move To Top';
        $options['moveToBottom'] = 'Move To Bottom';
        $options['doorCloseFromLeft'] = 'Door Close From Left';
        $options['doorOpenFromRight'] = 'Door Open From Right';
        $options['doorCloseFromRight'] = 'Door Close From Right';
        $options['doorOpenFromLeft'] = 'Door Open From Left';
        $options['heartbeatSlow'] = 'Heartbeat Slow';
        $options['heartbeatFast'] = 'Heartbeat Fast';
        $options['hangOnLeft'] = 'Hang On Left';
        $options['hangOnRight'] = 'Hang On Right';
        $options['hangAndDropLeft'] = 'Hang And Drop Left';
        $options['hangAndDropRight'] = 'Hang And Drop Right';
        $options['pulseShake'] = 'Pulse Shake';
        $options['horizontalShake'] = 'Horizontal Shake';
        $options['verticalShake'] = 'Shake Vertical';
        $options['madMax'] = 'Mad Max';
        $options['coolHorizontalShake'] = 'Cool Horizontal Shake';
        $options['coolVerticalShake'] = 'Cool Vertical Shake';
        $options['quietMad'] = 'Quiet Mad';
        $options['vibration'] = 'Vibration';
        $options['pushReleaseFrom'] = 'Push Release From';
        $options['pushReleaseFromLeft'] = 'Push Release From Left';
        $options['pushReleaseFromRight'] = 'Push Release From Right';
        $options['pushReleaseFromTop'] = 'Push Release From Top';
        $options['pushReleaseFromBottom'] = 'Push Release From Bottom';
        $options['pushReleaseTo'] = 'Push Release To';
        $options['pushReleaseToLeft'] = 'Push Release To Left';
        $options['pushReleaseToRight'] = 'Push Release To Right';
        $options['pushReleaseToTop'] = 'Push ReleaseTom Top';
        $options['pushReleaseToBottom'] = 'Push Release To Bottom';
        $options['flipX'] = 'Flip X';
        $options['flipXZoomIn'] = 'Flip X Zoom In';
        $options['flipXZoomOut'] = 'Flip X Zoom Out';
        $options['flipY'] = 'Flip Y';
        $options['flipYZoomIn'] = 'Flip Y Zoom In';
        $options['flipYZoomOut'] = 'Flip Y Zoom Out';
        $options['skewLeft'] = 'Skew Left';
        $options['skewRight'] = 'Skew Right';
        $options['skewInLeft'] = 'Skew In Left';
        $options['skewInRight'] = 'Skew In Right';
        $options['skewOutLeft'] = 'Skew Out Left';
        $options['skewOutRight'] = 'Skew Out Right';
        $options['shockZoom'] = 'Shock Zoom';
        $options['shockInLeft'] = 'Shock In left';
        $options['shockInRight'] = 'Shock In Right';
        $options['shockInTop'] = 'Shock In Top';
        $options['shockInBottom'] = 'Shock In Bottom';
        $options['pullRelease'] = 'Pull Release';
        $options['pushRelease'] = 'Push Release';
        $options['swingInLeft'] = 'Swing In Left';
        $options['swingInRight'] = 'Swing In Right';
        $options['swingInTop'] = 'Swing In Top';
        $options['swingInBottom'] = 'Swing In Bottom';
        $options['elevateLeft'] = 'Elevate Left';
        $options['elevateRight'] = 'Elevate Right';
        $options['rollFromLeft'] = 'Roll From Left';
        $options['rollFromRight'] = 'Roll From Left';
        $options['rollFromTop'] = 'Roll From Top';
        $options['rollFromBottom'] = 'Roll From Bottom';
        $options['rollToLeft'] = 'Roll To Left';
        $options['rollToRight'] = 'Roll To Left';
        $options['rollToTop'] = 'Roll To Top';
        $options['rollToBottom'] = 'Roll To Bottom';
        $options['rotate'] = 'Rotate';
        $options['rotateX'] = 'Rotate X';
        $options['rotateXIn'] = 'Rotate X In';
        $options['rotateXOut'] = 'Rotate X Out';
        $options['rotateY'] = 'Rotate Y';
        $options['rotateYIn'] = 'Rotate Y In';
        $options['rotateYOut'] = 'Rotate Y Out';
        $options['rotateInLeft'] = 'Rotate In Left';
        $options['rotateInRight'] = 'Rotate In Right';
        $options['rotateInTop'] = 'Rotate In Top';
        $options['rotateInBottom'] = 'Rotate In Bottom';
        $options['rotateOutLeft'] = 'Rotate Out Left';
        $options['rotateOutRight'] = 'Rotate Out Right';
        $options['rotateOutTop'] = 'Rotate Out Top';
        $options['rotateOutBottom'] = 'Rotate Out Bottom';
        $options['spinToLeft'] = 'Spin To Left';
        $options['spinToRight'] = 'Spin To Right';
        $options['spinToTop'] = 'Spin To Top';
        $options['spinToBottom'] = 'Spin To Bottom';
        $options['spinFromLeft'] = 'Spin From Left';
        $options['spinFromRight'] = 'Spin From Right';
        $options['spinFromTop'] = 'Spin From Top';
        $options['spinFromBottom'] = 'Spin From Bottom';
        $options['blurIn'] = 'Blur In';
        $options['blurInLeft'] = 'Blur In Left';
        $options['blurInRight'] = 'Blur In Right';
        $options['blurInTop'] = 'Blur In Top';
        $options['blurInBottom'] = 'Blur In Bottom';
        $options['blurOut'] = 'Blur Out';
        $options['blurOutLeft'] = 'Blur Out Left';
        $options['blurOutRight'] = 'Blur Out Right';
        $options['blurOutTop'] = 'Blur Out Top';
        $options['blurOutBottom'] = 'Blur Out Bottom';
        $options['bounceFromTop'] = 'Bounce From Top';
        $options['bounceFromDown'] = 'Bounce From Down';
        $options['bounceX'] = 'Bounce X';
        $options['bounceY'] = 'Bounce Y';
        $options['bounceZoomIn'] = 'Bounce Zoom In';
        $options['bounceZoomOut'] = 'Bounce Zoom Out';
        $options['bounceInTop'] = 'Bounce In Top';
        $options['bounceInLeft'] = 'Bounce In Left';
        $options['bounceInRight'] = 'Bounce In Right';
        $options['bounceInBottom'] = 'Bounce In Bottom';
        $options['bounceOutTop'] = 'Bounce Out Top';
        $options['bounceOutLeft'] = 'Bounce Out Left';
        $options['bounceOutRight'] = 'Bounce Out Right';
        $options['bounceOutBottom'] = 'Bounce Out Bottom';
        $options['perspectiveToTop'] = 'Perspective To Top';
        $options['perspectiveToBottom'] = 'Perspective To Bottom';
        $options['zoomIn'] = 'Zoom In';
        $options['zoomInLeft'] = 'Zoom In Left';
        $options['zoomInRight'] = 'Zoom In Right';
        $options['zoomInTop'] = 'Zoom In Top';
        $options['zoomInBottom'] = 'Zoom In Bottom';
        $options['zoomOut'] = 'Zoom Out';
        $options['zoomOutLeft'] = 'Zoom Out Left';
        $options['zoomOutRight'] = 'Zoom Out Right';
        $options['zoomOutTop'] = 'Zoom Out Top';
        $options['zoomOutBottom'] = 'Zoom Out Bottom';
        $options['scaleZoomInLeft'] = 'Scale And Zoom In Left';
        $options['scaleZoomInRight'] = 'Scale And Zoom In Right';
        $options['scaleZoomInTop'] = 'Scale And Zoom In Top';
        $options['scaleZoomInBottom'] = 'Scale And Zoom In Bottom';
        $options['scaleZoomOutLeft'] = 'Scale And Zoom Out Left';
        $options['scaleZoomOutRight'] = 'Scale And Zoom Out Right';
        $options['scaleZoomOutTop'] = 'Scale And Zoom Out Top';
        $options['scaleZoomOutBottom'] = 'Scale And Zoom Out Bottom';
        $options['danceTop'] = 'Dance Top';
        $options['danceMiddle'] = 'Dance Middle';
        $options['danceBottom'] = 'Dance Bottom';
        $options['dr-animation-wabble'] = 'Wabble';
        $options['dr-animation-spin'] = 'Spin';
        $options['dr-animation-spin-y'] = 'Spin-Y';
        $options['dr-animation-whirl'] = 'Whirl';
        $options['dr-animation-orbit'] = 'Orbit';

        return $options;
    }

    /**
     * Get text animation options.
     *
     * @since   1.0.0
     * @access  public static
     * @param   array $option_args
     * @return  array $options
     */
    public static function get_text_animation_options($option_args = array())
    {
        $option_args                      = wp_parse_args($option_args, array('include_blank' => true, 'blank_key' => '', 'blank_value' => 'Select Animation'));
        $options                          = array();

        if ($option_args['include_blank']) {
            $options[$option_args['blank_key']] = $option_args['blank_value'];
        }

        $options['leSnake'] = 'Snake';
        $options['lePeek'] = 'Peek';
        $options['leRainDrop'] = 'Rain Drop';
        $options['leWaterWave'] = 'Water Wave';
        $options['leJoltZoom'] = 'Jolt Zoom';
        $options['leMagnify'] = 'Magnify';
        $options['leBeat'] = 'Letter Beat';
        $options['leFadeIn'] = 'Fade In';
        $options['leFadeInLeft'] = 'Fade In Left';
        $options['leFadeInRight'] = 'Fade In Right';
        $options['leFadeInTop'] = 'Fade In Top';
        $options['leFadeInBottom'] = 'Fade In Bottom';
        $options['leFadeOut'] = 'Fade Out';
        $options['leFadeOutLeft'] = 'Fade Out Left';
        $options['leFadeOutRight'] = 'Fade Out Right';
        $options['leFadeOutTop'] = 'Fade Out Top';
        $options['leFadeOutBottom'] = 'Fade Out Bottom';
        $options['leMovingBackFromRight'] = 'Moving Back From Right';
        $options['leMovingBackFromLeft'] = 'Moving Back From Left';
        $options['leKickOutFront'] = 'Kick Out Front';
        $options['leKickOutBehind'] = 'Kick Out Behind';
        $options['leSkateX'] = 'Skate Left Right';
        $options['leSkateY'] = 'Skate Top Bottom';
        $options['leSkateXY'] = 'Skate Both';
        $options['leScaleXIn'] = 'ScaleX In';
        $options['leScaleXOut'] = 'ScaleX Out';
        $options['leScaleYIn'] = 'ScaleY In';
        $options['leScaleYOut'] = 'ScaleY Out';
        $options['leJump'] = 'Letter Jump';
        $options['leAboundTop'] = 'Abound Top';
        $options['leAboundBottom'] = 'Abound Bottom';
        $options['leAboundLeft'] = 'Abound Left';
        $options['leAboundRight'] = 'Abound Right';
        $options['leFlyInTop'] = 'Fly In Top';
        $options['leFlyInLeft'] = 'Fly In Left';
        $options['leFlyInRight'] = 'Fly In Right';
        $options['leFlyInBottom'] = 'Fly In Bottom';
        $options['leFlyOutTop'] = 'Fly Out Top';
        $options['leFlyOutLeft'] = 'Fly Out Left';
        $options['leFlyOutRight'] = 'Fly Out Right';
        $options['leFlyOutBottom'] = 'Fly Out Bottom';
        $options['leDoorCloseLeft'] = 'Door Close Left';
        $options['leDoorOpenRight'] = 'Door Open Right';
        $options['leDoorCloseRight'] = 'Door Close Right';
        $options['leDoorOpenLeft'] = 'Door Open Left';
        $options['leHangAndDropLeft'] = 'Hang And Drop Left';
        $options['leHangAndDropRight'] = 'Hang And Drop Right';
        $options['leRencontre'] = 'Rencontre';
        $options['lePulseShake'] = 'Pulse Shake';
        $options['leHorizontalShake'] = 'Horizontal Shake';
        $options['leVerticalShake'] = 'Shake Vertical';
        $options['leMadMax'] = 'Shake - Mad Max';
        $options['leHorizontalTremble'] = 'Horizontal Tremble';
        $options['leVerticalTremble'] = 'Vertical Tremble';
        $options['leCrazyCool'] = 'Crazy Cool';
        $options['leVibration'] = 'Vibration';
        $options['lePushReleaseFrom'] = 'Push Release From';
        $options['lePushReleaseFromLeft'] = 'Push Release From Left';
        $options['lePushReleaseFromTop'] = 'Push Release From Top';
        $options['lePushReleaseFromBottom'] = 'Push Release From Bottom';
        $options['lePushReleaseTo'] = 'Push Release To';
        $options['lePushReleaseToTop'] = 'Push Release To Top';
        $options['lePushReleaseToBottom'] = 'Push Release To Bottom';
        $options['leFlipInTop'] = 'Flip In Top';
        $options['leFlipOutTop'] = 'Flip Out Top';
        $options['leFlipInBottom'] = 'Flip In Bottom';
        $options['leFlipOutBottom'] = 'Flip Out Bottom';
        $options['leElevateLeft'] = 'Elevate Left';
        $options['leElevateRight'] = 'Elevate Right';
        $options['leRollFromLeft'] = 'Roll From Left';
        $options['leRollFromRight'] = 'Roll From Right';
        $options['leRollFromTop'] = 'Roll From Top';
        $options['leRollFromBottom'] = 'Roll From Bottom';
        $options['leRollToLeft'] = 'Roll To Left';
        $options['leRollToRight'] = 'Roll To Right';
        $options['leRollToTop'] = 'Roll To Top';
        $options['leRollToBottom'] = 'Roll To Bottom';
        $options['leRotateSkateInRight'] = 'Rotate Skate In Right';
        $options['leRotateSkateInLeft'] = 'Rotate Skate In Left';
        $options['leRotateSkateInTop'] = 'Rotate Skate In Top';
        $options['leRotateSkateInBottom'] = 'Rotate Skate In Bottom';
        $options['leRotateSkateOutRight'] = 'Rotate Skate Out Right';
        $options['leRotateSkateOutLeft'] = 'Rotate Skate Out Left';
        $options['leRotateSkateOutTop'] = 'Rotate Skate Out Top';
        $options['leRotateSkateOutBottom'] = 'Rotate Skate Out Bottom';
        $options['leRotateXZoomIn'] = 'Rotate X Zoom In';
        $options['leRotateXZoomOut'] = 'Rotate X Zoom Out';
        $options['leRotateYZoomIn'] = 'Rotate Y Zoom In';
        $options['leRotateYZoomOut'] = 'Rotate Y Zoom Out';
        $options['leRotateIn'] = 'Rotate In';
        $options['leRotateOut'] = 'Rotate Out';
        $options['leRotateInLeft'] = 'Rotate In Left';
        $options['leRotateOutLeft'] = 'Rotate Out Left';
        $options['leRotateInRight'] = 'Rotate In Right';
        $options['leRotateOutRight'] = 'Rotate Out Right';
        $options['leSpinInLeft'] = 'Spin In Left';
        $options['leSpinInRight'] = 'Spin In Right';
        $options['leSpinOutLeft'] = 'Spin Out Left';
        $options['leSpinOutRight'] = 'Spin Out Right';
        $options['leBlurIn'] = 'Blur In';
        $options['leBlurInRight'] = 'Blur In Right';
        $options['leBlurInLeft'] = 'Blur In Left';
        $options['leBlurInTop'] = 'Blur In Top';
        $options['leBlurInBottom'] = 'Blur In Bottom';
        $options['leBlurOut'] = 'Blur Out';
        $options['leBlurOutRight'] = 'Blur Out Right';
        $options['leBlurOutLeft'] = 'Blur Out Left';
        $options['leBlurOutTop'] = 'Blur Out Top';
        $options['leBlurOutBottom'] = 'Blur Out Bottom';
        $options['lePopUp'] = 'Pop Up';
        $options['lePopUpLeft'] = 'Pop Up Left';
        $options['lePopUpRight'] = 'Pop Up Right';
        $options['lePopOut'] = 'Pop Out';
        $options['lePopOutLeft'] = 'Pop Out Left';
        $options['lePopOutRight'] = 'Pop Out Right';
        $options['leBounceFromTop'] = 'Bounce From Top';
        $options['leBounceFromDown'] = 'Bounce From Down';
        $options['leBounceY'] = 'Bounce Y';
        $options['leBounceZoomIn'] = 'Bounce Zoom In';
        $options['leBounceZoomOut'] = 'Bounce Zoom Out';
        $options['lePerspectiveOutTop'] = 'Letter Perspective Out Top';
        $options['lePerspectiveOutBottom'] = 'Letter Perspective Out Bottom';
        $options['leZoomIn'] = 'Zoom In';
        $options['leZoomInLeft'] = 'Zoom In Left';
        $options['leZoomInRight'] = 'Zoom In Right';
        $options['leZoomInTop'] = 'ZoomIn Top';
        $options['leZoomInBottom'] = 'Zoom In Bottom';
        $options['leZoomOut'] = 'Zoom Out';
        $options['leZoomOutLeft'] = 'Zoom Out Left';
        $options['leZoomOutRight'] = 'Zoom Out Right';
        $options['leZoomOutTop'] = 'Zoom Out Top';
        $options['leZoomOutBottom'] = 'Zoom Out Bottom';
        $options['leDanceInTop'] = 'Dance In Top';
        $options['leDanceInMiddle'] = 'Dance In Middle';
        $options['leDanceInBottom'] = 'Dance In Bottom';
        $options['leDanceOutTop'] = 'Dance Out Top';
        $options['leDanceOutMiddle'] = 'Dance Out Middle';
        $options['leDanceOutBottom'] = 'Dance Out Bottom';
        $options['oaoFadeIn'] = 'One after One Fade In';
        $options['oaoFadeOut'] = 'One after One Fade Out';
        $options['oaoFlyIn'] = 'One after One Fly In';
        $options['oaoFlyOut'] = 'One after One Fly Out';
        $options['oaoRotateIn'] = 'One after One Rotate In';
        $options['oaoRotateOut'] = 'One after One Rotate Out';
        $options['oaoRotateXIn'] = 'One after One Rotate X In';
        $options['oaoRotateXOut'] = 'One after One Rotate X Out';
        $options['oaoRotateYIn'] = 'One after One Rotate Y In';
        $options['oaoRotateYOut'] = 'One after One Rotate Y Out';

        return $options;
    }
}

endif;
