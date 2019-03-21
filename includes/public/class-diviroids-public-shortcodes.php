<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Shortcodes Page
 *
 * @package    DiviRoids\Includes\Public\DiviRoids_Public_Shortcodes
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Public_Shortcodes')) :

    class DiviRoids_Public_Shortcodes extends DiviRoids_Instance_Base
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
            // Set the parent instance
            $this->parent_instance      = DiviRoids_Public();
            $this->name                 = 'shortcodes';
            $this->hook                 = $this->parent_instance->hook . '_' . $this->name;
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

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
            // Conditional
            add_shortcode('dr_conditional_devices', array($this, 'diviroids_conditional_devices'));
            add_shortcode('dr_conditional_roles', array($this, 'diviroids_conditional_roles'));

            // Add the menu/links shortcodes
            add_shortcode('dr_menu', array($this, 'diviroids_menu'));
            add_shortcode('dr_permalink', array($this, 'diviroids_permalink'));

            // Add the module shortcodes
            add_shortcode('dr_module', array($this, 'diviroids_module'));

            // Add the user shortcodes
            add_shortcode('dr_user_login', array($this, 'diviroids_user_login'));
            add_shortcode('dr_user_id', array($this, 'diviroids_user_id'));
            add_shortcode('dr_user_email', array($this, 'diviroids_user_email'));
            add_shortcode('dr_user_level', array($this, 'diviroids_user_level'));
            add_shortcode('dr_user_firstname', array($this, 'diviroids_user_firstname'));
            add_shortcode('dr_user_lastname', array($this, 'diviroids_user_lastname'));
            add_shortcode('dr_user_displayname', array($this, 'diviroids_user_displayname'));
            add_shortcode('dr_user_roles', array($this, 'diviroids_user_roles'));
            add_shortcode('dr_user_bio', array($this, 'diviroids_user_bio'));
            add_shortcode('dr_user_avatar', array($this, 'diviroids_user_avatar'));
        }

        #endregion

        #region Public Functions

        /**
         * Handle the dr_conditional_devices shortcode.
         *
         * module example: [dr_conditional_devices show=true devices='mobile']Any Content Here[/dr_conditional_devices]
         * php example: echo do_shortcode('[dr_conditional_devices show=true devices="mobile"]Any Content Here[/dr_conditional_devices]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_conditional_devices($atts, $content = null)
        {
            extract(shortcode_atts(array( 'show' => true, 'devices' => null ), $atts));

            // no valid devices
            if (empty($devices)) {
                return;
            }

            // Determine Action
            $show = DiviRoids_Library::parse_boolean_value($show);

            // Determine Match
            require_once DIVIROIDS_PLUGIN_LIB_DIR . 'Mobile_Detect.php';
            $devices = explode(',', $devices);
            $detect = new Mobile_Detect;
            $match = false;

            foreach ($devices as $device) {
                if ('desktop' === $device) {
                    $match = !$detect->isMobile();
                } elseif ('mobile' === $device) {
                    $match = $detect->isMobile();
                } elseif ('tablet' === $device) {
                    $match = $detect->isTablet();
                }

                if ($match) {
                    break;
                }
            }

            // if match and show = show
            // if match and !show = !show
            // if !match and show = !show
            // if !match and !show = show

            if ($match && $show || !$match && !$show) {
                return wpautop(do_shortcode($content));
            }

            return null;
        }

        /**
         * Handle the dr_conditional_roles shortcode.
         *
         * module example: [dr_conditional_roles show=true roles='administrator']Any Content Here[/dr_conditional_roles]
         * php example: echo do_shortcode('[dr_conditional_roles show=true roles="administrator"]Any Content Here[/dr_conditional_roles]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_conditional_roles($atts, $content = null)
        {
            extract(shortcode_atts(array( 'show' => true, 'roles' => null ), $atts));

            // no valid roles
            if (empty($roles)) {
                return;
            }

            // Determine Action
            $show = DiviRoids_Library::parse_boolean_value($show);

            // Determine Match
            $roles = explode(',', $roles);
            $match = DiviRoids_Security::does_current_user_have_roles($roles);

            // if match and show = show
            // if match and !show = !show
            // if !match and show = !show
            // if !match and !show = show

            if ($match && $show || !$match && !$show) {
                return wpautop(do_shortcode($content));
            }

            return null;
        }

        /**
         * Handle the menu shortcode.
         *
         * module example: [dr_menu name="" class=""]
         * php example: echo do_shortcode('[dr_menu name="" class=""]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_menu($atts)
        {
            extract(shortcode_atts(array( 'name' => null, 'class' => null, 'depth' => 0 ), $atts));
            return wp_nav_menu(array( 'menu' => $name, 'menu_class' => $class, 'echo' => false, 'depth' => $depth ));
        }

        /**
         * Handle the permalink shortcode.
         *
         * module example: [dr_permalink slug="" title="" target="" class=""]
         * php example: echo do_shortcode('[dr_permalink slug="" title="" target="" class=""]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_permalink($atts)
        {
            extract(shortcode_atts(array( 'slug' => null, 'title' => null, 'target' => null, 'class' => null ), $atts));

            $page = get_page_by_path($slug);

            $output = sprintf(
              '<a href="%1$s" title="%2$s"%3$s%4$s>%2$s</a>',
               get_permalink($page->ID),
               empty($title) ? get_the_title($page) : $title,
               !empty($target) ? ' target="'. $target .'"' : '',
               !empty($class) ? ' class="'. $class .'"' : ''
            );

            return $output;
        }

        /**
         * Handle the dr module shortcode.
         *
         * module example: [dr_module id=""]
         * php example: echo do_shortcode('[dr_module id=""]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_module($atts)
        {
            extract(shortcode_atts(array( 'id' => null), $atts));
            return do_shortcode('[et_pb_section global_module="'. $id .'"][/et_pb_section]');
        }

        /**
         * Handle the dr user login shortcode.
         *
         * module example: [dr_user_login]
         * php example: echo do_shortcode('[dr_user_login]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_login($atts)
        {
            return DiviRoids_Security::get_current_user('user_login');
        }

        /**
         * Handle the diviroids_user_id shortcode.
         *
         * module example: [dr_user_id]
         * php example: echo do_shortcode('[dr_user_id]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_id($atts)
        {
            return DiviRoids_Security::get_current_user('ID');
        }

        /**
         * Handle the diviroids_user_email shortcode.
         *
         * module example: [dr_user_email]
         * php example: echo do_shortcode('[dr_user_email]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_email($atts)
        {
            return DiviRoids_Security::get_current_user('user_email');
        }

        /**
         * Handle the diviroids_user_level shortcode.
         *
         * module example: [dr_user_level]
         * php example: echo do_shortcode('[dr_user_level]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_level($atts)
        {
            return DiviRoids_Security::get_current_user('user_level');
        }

        /**
         * Handle the diviroids_user_firstname shortcode.
         *
         * module example: [dr_user_firstname]
         * php example: echo do_shortcode('[dr_user_firstname]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_firstname($atts)
        {
            return DiviRoids_Security::get_current_user('user_firstname');
        }

        /**
         * Handle the diviroids_user_lastname shortcode.
         *
         * module example: [dr_user_lastname]
         * php example: echo do_shortcode('[dr_user_lastname]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_lastname($atts)
        {
            return DiviRoids_Security::get_current_user('user_lastname');
        }

        /**
         * Handle the diviroids_user_displayname shortcode.
         *
         * module example: [dr_user_displayname]
         * php example: echo do_shortcode('[dr_user_displayname]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_displayname($atts)
        {
            return DiviRoids_Security::get_current_user('display_name');
        }

        /**
         * Handle the diviroids_user_roles shortcode.
         *
         * module example: [dr_user_roles]
         * php example: echo do_shortcode('[dr_user_roles]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_roles($atts)
        {
            $roles = DiviRoids_Security::get_current_user('roles');
            return !empty($roles) ? implode(',', $roles) : '';
        }

        /**
         * Handle the diviroids_user_bio shortcode.
         *
         * module example: [dr_user_bio]
         * php example: echo do_shortcode('[dr_user_bio]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_bio($atts)
        {
            return DiviRoids_Security::get_current_user('description');
        }

        /**
         * Handle the diviroids_user_avatar shortcode.
         *
         * module example: [dr_user_avatar size="" class="" extra_attr=""]
         * php example: echo do_shortcode('[dr_user_avatar size="" class="" extra_attr=""]');
         *
         * @since  1.0.0
         * @access public
         * @return boolean
         */
        public function diviroids_user_avatar($atts)
        {
            extract(shortcode_atts(array( 'size' => 64, 'class' => null, 'extra_attr' => ''), $atts));
            $userId = DiviRoids_Security::get_current_user('ID');
            $avatar = (0 !== $userId) ? get_avatar($userId, $size, '', '', array('class' => $class, 'extra_attr' => $extra_attr)) : '';

            return $avatar;
        }

        #endregion
    }

    function DiviRoids_Public_Shortcodes()
    {
        return DiviRoids_Public_Shortcodes::getInstance();
    }

endif;

DiviRoids_Public_Shortcodes();
