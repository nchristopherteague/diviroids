<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles the Shortcodes Page
 *
 * @package    DiviRoids\Includes\Public\DiviRoids_Public_Single_Post
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Public_Single_Post')) :

    class DiviRoids_Public_Single_Post extends DiviRoids_Instance_Base
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
         * $pagination_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $pagination_enabled
         */
        public $pagination_enabled;

        /**
         * $author_box_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $author_box_enabled
         */
        public $author_box_enabled;

        /**
         * $related_post_enabled enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $related_post_enabled
         */
        public $related_post_enabled;

        /**
         * $post_tags enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $post_tags
         */
        public $post_tags;

        /**
         * $any_setting enabled.
         *
         * @since  1.0.0
         * @access public
         * @var    $any_setting_enabled
         */
        public $any_setting_enabled;

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
            $this->name                 = 'single-post';
            $this->hook                 = $this->parent_instance->hook . '_single_post';
            $this->slug                 = $this->parent_instance->slug . '-' . $this->name;
            $this->settings_prefix      = DiviRoids_Settings()->settings_prefix_name . '-' . $this->name;

            // Load the settings
            $this->load_settings();

            if (!$this->any_setting_enabled) {
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
            $pagination_value                   = DiviRoids_Settings()->get($this->settings_prefix . '-pagination', true);
            $this->pagination_enabled           = DiviRoids_Library::parse_boolean_value($pagination_value);

            $author_box_value                   = DiviRoids_Settings()->get($this->settings_prefix . '-author-box', true);
            $this->author_box_enabled           = DiviRoids_Library::parse_boolean_value($author_box_value);

            $related_post_value                 = DiviRoids_Settings()->get($this->settings_prefix . '-related-post', true);
            $this->related_post_enabled         = DiviRoids_Library::parse_boolean_value($related_post_value);

            $this->post_tags                    = DiviRoids_Settings()->get($this->settings_prefix . '-post-tags', true);

            $this->any_setting_enabled = false;
            if ($this->pagination_enabled ||
                $this->author_box_enabled ||
                $this->related_post_enabled ||
                '0' !== $this->post_tags) {
                $this->any_setting_enabled = true;
            }
        }

        /**
         * Register all hooks for this class.
         *
         * @since  1.0.0
         * @access private
         */
        private function register_hooks()
        {
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_styles' ));
            add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));

            add_filter('the_content', array( $this, 'single_post_content'));
        }

        /**
         * Render the post tags
         *
         * @since  1.0.0
         * @access private
         * @param  string $content
         * @return string
         */
        private function render_post_tags($content)
        {
            $tags   = get_the_tags();
            if (empty($tags)) {
                return $content;
            }

            $tag_links  = '';
            foreach ($tags as $key=>$tag) {
                $tag_links .= sprintf(
                '%3$s<a href="%1$s">%2$s</a>',
                get_tag_link($tag->term_id),
                $tag->name,
                0 === $key  ? ' ' : ', '
              );
            }

            $output   = '1' === $this->post_tags ? '<div class="dr-single-post-tags-above"> |' : '<div class="dr-single-post-tags-below">' . esc_html__('Tags:', DIVIROIDS_PLUGIN_SLUG);
            $output  .= $tag_links;
            $output  .= '</div>';

            return '1' === $this->post_tags ? $output . $content : $content . $output;
        }

        /**
         * Render the post pagination
         *
         * @since  1.0.0
         * @access private
         * @param  string $content
         * @return string
         */
        private function render_pagination($content)
        {
            $output = sprintf(
              '<div class="clearfix"></div>
              <div class="dr-single-post-nav">
                <div class="dr-single-post-nav-links">
                  <div class="dr-single-post-nav-link dr-single-post-nav-link-prev">%1$s</div>
                  <div class="dr-single-post-nav-link dr-single-post-nav-link-next">%2$s</div>
                </div>
              </div><!-- dr-single-post-nav -->',
              get_previous_post_link('%link', et_get_safe_localization(__('<span class="button">Previous</span><span class="title">%title</span>', DIVIROIDS_PLUGIN_SLUG))),
              get_next_post_link('%link', et_get_safe_localization(__('<span class="button">Next</span><span class="title">%title</span>', DIVIROIDS_PLUGIN_SLUG)))
            );

            return $content . $output;
        }

        /**
         * Render the author box
         *
         * @since  1.0.0
         * @access private
         * @param  string $content
         * @return string
         */
        private function render_author_box($content)
        {
            $title            = esc_html('About The Author', DIVIROIDS_PLUGIN_SLUG);
            $author_id        = get_the_author_meta('ID');
            $author_name      = get_the_author();
            $author_avatar    = get_avatar($author_id, 170, 'mystery', esc_attr($author_name));
            $author_bio       = get_the_author_meta('description');
            $author_url       = get_author_posts_url($author_id);

            $author_link = sprintf(
              '<a class="dr-author-link url fn" href="%1$s" rel="author" title="%2$s">%3$s</a>',
              esc_url($author_url),
              et_get_safe_localization(__('View all posts by ' . $author_name, DIVIROIDS_PLUGIN_SLUG)),
              $author_name
            );

            $output = sprintf(
            '<div class="clearfix"></div>
            <div class="dr-box dr-author">
              <div class="dr-box-header">
                <h3>%1$s</h3>
              </div>
              <div class="dr-box-content clearfix">
                <div class="dr-author-avatar">%2$s</div>
                <div class="dr-author-description">
                  <h4>%3$s</h4>
                  <p class="note">%4$s</p>
                </div>
              </div>
            </div>',
            $title,
            $author_avatar,
            $author_link,
            $author_bio
          );

            return $content . $output;
        }

        /**
         * Render the related post
         *
         * @since  1.0.0
         * @access private
         * @param  string $content
         * @return string
         */
        private function render_related_posts($content)
        {
            global $post;
            $query = DiviRoids_Post::get_related_post($post);

            if (!$query->have_posts()) {
                return $content;
            }

            $related_posts = '';

            while ($query->have_posts()) :
              $query->the_post();

            $post_id          = get_the_ID();
            $post_permalink   = get_the_permalink();
            $post_title       = get_the_title();
            $post_author      = get_the_author();

            $related_posts .= sprintf(
                '<div class="dr-related-post"><div class="dr-related-post-feature-image">%1$s</div><div class="dr-related-post-title"><h4><a href="%2$s">%3$s</a></h4><p>by %4$s</p></div></div>',
                DiviRoids_Post::get_post_thumbnail(array(
                  'post_id'                     => $post_id,
                  'permalink'                   => $post_permalink,
                  'title'                       => $post_title,
                  'size'                        => 'dr-image-small',
                  'a_class'                     => array('post-thumbnail'),
                  'post_format_thumb_fallback'  => true,
                  'img_after'                   => '<span class="et_overlay"></span>',
                )),
                $post_permalink,
                $post_title,
                $post_author
              );
            endwhile;

            $output = sprintf(
            '<div class="clearfix"></div>
            <div class="dr-box dr-related-posts">
              <div class="dr-box-header">
                <h3>%1$s</h3>
              </div>
              <div class="dr-box-content clearfix">
                %2$s
              </div>
            </div>',
            esc_html__('Related Posts', DIVIROIDS_PLUGIN_SLUG),
            $related_posts
            );

            wp_reset_postdata();

            return $content . $output;
        }

        #endregion

        #region Public Functions

        /**
         * Register all styles.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_styles()
        {
            wp_enqueue_style(
              $this->slug,
              DIVIROIDS_PLUGIN_ASSETS_CSS_URL . $this->slug . '.css',
              array(),
              DIVIROIDS_PLUGIN_VERSION,
              'all'
            );
        }

        /**
         * Register all scripts.
         *
         * @since  1.0.0
         * @access public
         */
        public function enqueue_scripts()
        {
            wp_enqueue_script(
              $this->slug,
              DIVIROIDS_PLUGIN_ASSETS_JS_URL . $this->slug . '.min.js',
              array( 'jquery' ),
              DIVIROIDS_PLUGIN_VERSION,
              false
            );
        }

        /**
         * Handle the_content filter
         *
         * @since  1.0.0
         * @access public
         */
        public function single_post_content($content)
        {
            if (is_singular('post')) {
                if ('0' != $this->post_tags) {
                    $content = $this->render_post_tags($content);
                }

                if ($this->pagination_enabled) {
                    $content = $this->render_pagination($content);
                }

                if ($this->author_box_enabled) {
                    $content = $this->render_author_box($content);
                }

                if ($this->related_post_enabled) {
                    $content = $this->render_related_posts($content);
                }
            }

            return $content;
        }

        #endregion
    }

    function DiviRoids_Public_Single_Post()
    {
        return DiviRoids_Public_Single_Post::getInstance();
    }

endif;

DiviRoids_Public_Single_Post();

/*

function et_pb_postinfo_meta($postinfo=null, $date_format=null, $comment_zero=null, $comment_one=null, $comment_more=null)
{
    return 'christopherteagafgdsa';
}

*/
