<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Post Type Customizations
 *
 * @package    DiviRoids\Includes\Admin\DiviRoids_Admin_PostType_Customizations
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Admin_PostType_Customizations')) :

    class DiviRoids_Admin_PostType_Customizations extends DiviRoids_Instance_Base
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
         * Nonce name.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $action_nonce;

        /**
         * Post Type Custom Columns.
         *
         * @since  1.0.0
         * @access public
         * @var    $columns
         */
        public $columns;

        /**
         * Divi Library Custom Columns.
         *
         * @since  1.0.0
         * @access public
         * @var    $columns_divilibrary
         */
        public $columns_divilibrary;

        /**
         * Post Type Custom Actions.
         *
         * @since  1.0.0
         * @access public
         * @var    $actions
         */
        public $actions;

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
            $this->parent_instance      = DiviRoids_Admin();
            $this->name                 = 'posttype-customizations';
            $this->hook                 = $this->parent_instance->hook . '_posttype_customizations';
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->action_nonce         = $this->hook . '_nonce';
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

            // Load the settings
            $this->load_settings();

            // No settings enabled, just return
            if (empty($this->columns) && empty($this->columns_divilibrary) && empty($this->actions)) {
                return;
            }

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

        /**
         * Loads settings.
         *
         * @since  1.0.0
         * @access private
         */
        private function load_settings()
        {
            $this->columns                  = DiviRoids_Settings()->get($this->settings_prefix . '-columns', true);
            $this->columns_divilibrary      = DiviRoids_Settings()->get($this->settings_prefix . '-columns-divilibrary', true);
            $this->actions                  = DiviRoids_Settings()->get($this->settings_prefix . '-actions', true);
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
            add_action('admin_init', array( $this, 'admin_init' ), 20);

            // TODO: Add the ajax to clone post
            // Enqueue Styles and Scripts
            //add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));
            //add_action('wp_ajax_diviroids_clone_post', array($this, 'clone'));
        }

        /**
         * Handles the Post Type columns.
         *
         * @since  1.0.0
         * @access private
         */
        private function handle_columns()
        {
            if (empty($this->columns)) {
                return;
            }

            $custom_post_types = DiviRoids_Queries::query_divi_registered_post_types();

            foreach ($custom_post_types as $key => $value) {
                add_filter('manage_' . $key . '_posts_columns', array( $this, 'add_columns' ));
                add_action('manage_' . $key . '_posts_custom_column', array( $this, 'add_value' ), 500, 2);
            }
        }

        /**
         * Handles the divilibrary columns.
         *
         * @since  1.0.0
         * @access private
         */
        private function handle_columns_divilibrary()
        {
            if (empty($this->columns_divilibrary)) {
                return;
            }

            add_filter('manage_et_pb_layout_posts_columns', array( $this, 'divilibrary_add_columns' ));
            add_action('manage_et_pb_layout_posts_custom_column', array( $this, 'divilibrary_add_value' ), 500, 2);
        }

        /**
         * Handles the post type actions.
         *
         * @since  1.0.0
         * @access private
         */
        private function handle_actions()
        {
            if (empty($this->actions)) {
                return;
            }

            add_filter('post_row_actions', array( $this, 'add_actions' ), 10, 2);
            add_filter('page_row_actions', array( $this, 'add_actions' ), 10, 2);
            add_action('admin_action_diviroids_clone_post', array( $this, 'clone_post' ));
        }

        /**
         * Handles custom columns value.
         *
         * @since  1.0.0
         * @access private
         */
        private function handle_custom_column_value($column_key, $object_id)
        {
            $output         = null;
            $post_type      = get_post_type($object_id);

            switch ($column_key) {

                case 'diviroids_id':
                  $output         = $object_id;
                  break;

                case 'diviroids_short_code':
                  $shortcode      = '[dr_module id="' . $object_id . '"]';
                  $output         = '<a id="copytoclipboard" href="#" data-text="' . $shortcode . '">' . $shortcode . '</a> <em>click shortcode to copy to clipboard</em>';
                  break;

                case 'diviroids_permalink':
                  $permalink      = get_permalink($object_id);
                  $output         = '<a href="' . $permalink .'" target="_blank">' . $permalink . '</a>';
                  break;

                case 'diviroids_slug':
                  $output         = get_post_field('post_name', $object_id, 'raw');
                  break;

                case 'diviroids_status':
                  $output         = get_post_field('post_status', $object_id);
                  break;

                case 'diviroids_template':
                  $templates      = get_page_templates(null, $post_type);
                  $template_slug  = get_page_template_slug($object_id);
                  $template_name  = __('Default', DIVIROIDS_PLUGIN_SLUG);

                  foreach ($templates as $key => $value) {
                      if ($template_slug == $value) {
                          $template_name = $key . '<br><em>(' . $value .')</em>';
                      }
                  }

                  $output = $template_name;
                  break;

                default:
                  break;
            }

            return $output;
        }

        /**
         * Handles custom actions.
         *
         * @since  1.0.0
         * @access private
         */
        private function handle_custom_actions($actions, $action, $object)
        {
            $post_id = $object->ID;

            switch ($action) {

                case 'diviroids_id':
                  $tmpactions               = array();
                  $tmpactions[$action]      = 'ID:' . $post_id;
                  $actions                  = array_merge($tmpactions, $actions);
                  break;

                case 'diviroids_edit_visual_builder':

                    $is_not_builder_enabled_single      = ! et_builder_fb_enabled_for_post($post_id);
                    $is_not_builder_enabled_single      = ! et_builder_fb_enabled_for_post($post_id);
                    $is_not_in_wc_shop                  = ! et_builder_used_in_wc_shop();
                    $not_allowed_fb_access              = ! et_pb_is_allowed('use_visual_builder');

                    if ($not_allowed_fb_access || ($is_not_builder_enabled_single && $is_not_in_wc_shop)) {
                        break;
                    }

                    $is_divi_library      = DiviRoids_Queries::is_divi_library($post_id);
                    $page_url             = $is_divi_library ? get_edit_post_link($post_id) : get_permalink($post_id);

                    if (!current_user_can('edit_post', $post_id)) {
                        break;
                    }

                    $url = add_query_arg('et_fb', '1', get_permalink());
                    $actions[$action]   = '<a href="' . $url . '" class="edit_link">' . __('Edit with Visual Builder', DIVIROIDS_PLUGIN_SLUG) . '</a>';

                  break;

                case 'diviroids_clone':
                  if (!current_user_can('edit_post', $post_id)) {
                      break;
                  }

                  $url                  = wp_nonce_url('admin.php?action=diviroids_clone_post&post=' . $post_id, DIVIROIDS_PLUGIN_FILE, 'diviroids_clone_nonce');
                  $onclick              = 'if(!confirm("Are you sure you want to clone post id=' . $post_id . '?")){return false;}';
                  $actions[$action]     = '<a class="dr-link-clone" href="' . $url . '" onclick=\'' . $onclick . '\' data-post_id="' . $post_id . '">' . __('Clone', DIVIROIDS_PLUGIN_SLUG) . '</a>';
                  break;

                default:
                  break;
            }

            return $actions;
        }

        /**
         * Handle the cloning.
         * https://rudrastyh.com/wordpress/duplicate-post.html
         * @since  1.0.0
         * @access private
         */
        private function diviroids_clone_post()
        {
            global $wpdb;
            if (! (isset($_GET['post']) || isset($_POST['post'])  || (isset($_REQUEST['action']) && 'diviroids_clone_post' == $_REQUEST['action']))) {
                wp_die('No post to duplicate has been supplied!');
            }

            /*
        	 * Nonce verification
        	 */
            if (!isset($_GET['diviroids_clone_nonce']) || !wp_verify_nonce($_GET['diviroids_clone_nonce'], DIVIROIDS_PLUGIN_FILE)) {
                return;
            }

            // TODO Implement this when we implement ajax
            // check_ajax_referer($this->action_nonce);

            /*
        	 * get the original post id
        	 */
            $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));

            /*
        	 * and all the original post data then
        	 */
            $post = get_post($post_id);

            /*
        	 * if you don't want current user to be the new post author,
        	 * then change next couple of lines to this: $new_post_author = $post->post_author;
        	 */
            $current_user = wp_get_current_user();
            $new_post_author = $current_user->ID;

            /*
        	 * if post data exists, create the post duplicate
        	 */
            if (isset($post) && $post != null) {

            /*
        		 * new post data array
        		 */
                $args = array(
                    'comment_status' => $post->comment_status,
                    'ping_status'    => $post->ping_status,
                    'post_author'    => $new_post_author,
                    'post_content'   => $post->post_content,
                    'post_excerpt'   => $post->post_excerpt,
                    'post_name'      => $post->post_name,
                    'post_parent'    => $post->post_parent,
                    'post_password'  => $post->post_password,
                    'post_status'    => 'draft',
                    'post_title'     => $post->post_title . '-copy',
                    'post_type'      => $post->post_type,
                    'to_ping'        => $post->to_ping,
                    'menu_order'     => $post->menu_order
                );

                /*
        		 * insert the post by wp_insert_post() function
        		 */
                $new_post_id = wp_insert_post($args);

                /*
        		 * get all current post terms ad set them to the new post draft
        		 */
                $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");

                foreach ($taxonomies as $taxonomy) {
                    $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                    wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
                }

                /*
        		 * duplicate all post meta just in two SQL queries
        		 */
                $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
                if (count($post_meta_infos)!=0) {
                    $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                    foreach ($post_meta_infos as $meta_info) {
                        $meta_key = $meta_info->meta_key;
                        if ($meta_key == '_wp_old_slug') {
                            continue;
                        }
                        $meta_value = addslashes($meta_info->meta_value);
                        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
                    }
                    $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                    $wpdb->query($sql_query);
                }

                //wp_redirect(admin_url('edit.php?post_type=' . $post_type));
                //exit;
            } else {
                echo '<strong>Post creation failed, could not find original post: ' . $post_id .'</strong>';
                die();
            }

            wp_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }

        #endregion

        #region Public Functions

        /**
         * Executes during admin_init action.
         *
         * @since  1.0.0
         * @access public
         */
        public function admin_init()
        {
            // Handle the Post Type Columns
            $this->handle_columns();

            // Handle the DiviLibrary Columns
            $this->handle_columns_divilibrary();

            // Handle the Post Type Actions
            $this->handle_actions();
        }

        /**
         * Register all scripts.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_scripts()
        {
            /* TODO Add future ajax for cloning
              wp_enqueue_script(
                $this->slug,
                DIVIROIDS_PLUGIN_ASSETS_JS_URL . $this->slug . '.min.js',
                array( 'jquery' ),
                DIVIROIDS_PLUGIN_VERSION,
                false
              );

              wp_localize_script(
                $this->slug,
                $this->hook,
                array(
                  'settings_nonce'  => wp_create_nonce($this->action_nonce),
                )
              );
            */
        }

        /**
         * Adds column(s) to Post Types
         *
         * @since  1.0.0
         * @access public
         * @param mixed $columns
         */
        public function add_columns($columns)
        {
            foreach ($this->columns as $key) {
                if (!in_array($key, $columns)) {
                    $columns[$key] = DiviRoids_Settings()->get_custom_column_name($key);
                }
            }

            return $columns;
        }

        /**
         * Add value to Post Type custom column(s)
         *
         * @since  1.0.0
         * @access public
         * @param mixed $column
         * @param mixed $id
         */
        public function add_value($column, $id)
        {
            if (empty($this->columns) || !in_array($column, $this->columns)) {
                return;
            }

            $output = $this->handle_custom_column_value($column, $id);
            echo $output;
        }

        /**
         * Adds column(s) to Divi Library
         *
         * @since  1.0.0
         * @access public
         * @param mixed $columns
         */
        public function divilibrary_add_columns($columns)
        {
            foreach ($this->columns_divilibrary as $key) {
                if (!in_array($key, $columns)) {
                    $columns[$key] = DiviRoids_Settings()->get_custom_column_name($key);
                }
            }

            return $columns;
        }

        /**
         * Add value to Divi Library custom column(s)
         *
         * @since  1.0.0
         * @access public
         * @param mixed $column
         * @param mixed $id
         */
        public function divilibrary_add_value($column, $id)
        {
            if (empty($this->columns_divilibrary) || !in_array($column, $this->columns_divilibrary)) {
                return;
            }

            $output = $this->handle_custom_column_value($column, $id);
            echo $output;
        }

        /**
         * Add custom actions.
         *
         * @since  1.0.0
         * @access public
         * @param array $actions
         * @param mixed $post
         */
        public function add_actions($actions, $post)
        {
            if (!DiviRoids_Queries::is_divi_registered_post_type($post->post_type, true, array('product'))) {
                return $actions;
            }

            foreach ($this->actions as $action) {
                $actions = $this->handle_custom_actions($actions, $action, $post);
            }

            return $actions;
        }

        /**
         * Callback function to handle cloning.
         *
         * @since  1.0.0
         * @access public
         */
        public function clone_post()
        {
            $this->diviroids_clone_post();
            die();
        }

        #endregion
    }

    function DiviRoids_Admin_PostType_Customizations()
    {
        return DiviRoids_Admin_PostType_Customizations::getInstance();
    }

endif;

DiviRoids_Admin_PostType_Customizations();
