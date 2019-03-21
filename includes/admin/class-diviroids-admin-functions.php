<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Admin General Page
 *
 * @package    DiviRoids\Includes\Admin\DiviRoids_Admin_Functions
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Admin_Functions')) :

    class DiviRoids_Admin_Functions extends DiviRoids_Instance_Base
    {

        #region Constructor and Destructors


        protected function initialization()
        {
            // Set the parent instance
            $this->parent_instance    = DiviRoids_Admin();
            $this->name               = 'functions';
            $this->hook               = $this->parent_instance->hook . '_' . $this->name;
            $this->slug               = $this->parent_instance->slug . '-' . $this->name;

            // Register all hooks
            $this->register_hooks();
        }

        #endregion

        #region Private Functions

        private function register_hooks()
        {
            add_action('et_pb_postinfo_meta', array($this, 'et_pb_postinfo_meta' ), 1);

            // Admin menu action
            add_action('admin_menu', array($this, 'admin_menu' ), 20);
        }

        public function et_pb_postinfo_meta($postinfo=null, $date_format=null, $comment_zero=null, $comment_one=null, $comment_more=null)
        {
            return 'fdsafdsafdsafdsafdsafdsa';
        }

        private function render_heading($heading)
        {
            echo '<br><strong>' . $heading . '</strong><br>';
        }

        private function render_posttypes_category()
        {
            $postoptions = DiviRoids_Options::get_posts_options('page', -1, array('include_blank' => false));

            $posttypes = DiviRoids_Queries::query_post_types(array('show_ui' => true));
            $posttypes_filtered = DiviRoids_Queries::query_post_types(array('show_ui' => true, 'show_in_menu' => true));
            $posttypes_options = DiviRoids_Options::get_post_types_options();
            $posttypes_divi = DiviRoids_Queries::query_divi_registered_post_types();
            $posttypes_divi_library = DiviRoids_Queries::query_divi_registered_post_types(true);
            $posttypes_divi_blacklisted = DiviRoids_Queries::query_divi_registered_post_types(false, array('page'));
            $posttypes_divi_registered = DiviRoids_Queries::is_divi_registered_post_type('project', true);

            $this->render_heading('$postoptions');
            foreach ($postoptions as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes');
            foreach ($posttypes as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_filtered');
            foreach ($posttypes_filtered as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_options');
            foreach ($posttypes_options as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_divi');
            foreach ($posttypes_divi as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_divi_library');
            foreach ($posttypes_divi_library as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_divi_blacklisted');
            foreach ($posttypes_divi_blacklisted as $key => $value) {
                echo $key . '-' . $value . '<br>';
            }

            $this->render_heading('$posttypes_divi_registered');
            if ($posttypes_divi_registered) {
                echo 'yes<br>';
            } else {
                echo 'no<br>';
            }

            $this->render_heading('query_categories');
            foreach ($posttypes_divi as $key => $value) {
                echo $key . '-' . $value . '<br>' ;
                $categories = DiviRoids_Queries::query_categories($key);
                foreach ($categories as $catkey => $category) {
                    echo $catkey . ' - ' . $category . '<br>';
                }
            }

            $this->render_heading('get_query_categories');
            foreach ($posttypes_divi as $key => $value) {
                echo $key . '-' . $value . '<br>' ;
                $categories = DiviRoids_Options::get_categories_options($key, array('include_blank' => true));
                foreach ($categories as $catkey => $category) {
                    echo $catkey . ' - ' . $category . '<br>';
                }
            }
        }

        private function render_shortcodes()
        {
            $this->render_heading('desktop');
            echo do_shortcode('[dr_conditional_devices show=true devices="desktop"]desktop[/dr_conditional_devices]');

            $this->render_heading('mobile');
            echo do_shortcode('[dr_conditional_devices show=true devices="mobile"]mobile[/dr_conditional_devices]');

            $this->render_heading('desktop and mobile');
            echo do_shortcode('[dr_conditional_devices show=true devices="mobile,desktop"]desktop, mobile[/dr_conditional_devices]');

            $this->render_heading('desktop and mobile');
            echo do_shortcode('[dr_conditional_devices show=false devices="mobile,desktop"]desktop, mobile[/dr_conditional_devices]');

            $this->render_heading('administrator');
            echo do_shortcode('[dr_conditional_roles show=true roles="administrator"]administrator[/dr_conditional_roles]');

            $this->render_heading('editor');
            echo do_shortcode('[dr_conditional_roles show=false roles="editor"]editor[/dr_conditional_roles]');

            $this->render_heading('administrator and editor');
            echo do_shortcode('[dr_conditional_roles show=true roles="administrator,editor"]administrator,editor[/dr_conditional_roles]');
        }

        #endregion

        #region Public Functions

        public function admin_menu()
        {
            add_management_page(
            ucfirst(__($this->name, DIVIROIDS_PLUGIN_SLUG)), //$page_title,
            ucfirst(__($this->name, DIVIROIDS_PLUGIN_SLUG)), //$menu_title,
            $this->parent_instance->capability, //$capability,
            $this->slug, //$menu_slug,
            array($this, 'render') //$function
          );
        }

        public function render()
        {
            $this->render_posttypes_category();
            $this->render_shortcodes();
        }

        #endregion
    }

    function DiviRoids_Admin_Functions()
    {
        return DiviRoids_Admin_Functions::getInstance();
    }

endif;

DiviRoids_Admin_Functions();
