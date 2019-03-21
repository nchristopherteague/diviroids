<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles options functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Post
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Post')) :

class DiviRoids_Post
{

  /**
   * Get post types options.
   *
   * @since   1.0.0
   * @access  public
   * @param   mixed $post
   * @return  mixed
   */
    public static function get_related_post($post)
    {
        $post_id    = $post->ID;
        $terms      = get_the_terms($post_id, 'post_tag');

        $term_ids   = array();
        if (is_array($terms)) {
            foreach ($terms as $term) {
                $term_ids[] = $term->term_id;
            }
        }

        $related_posts = new WP_Query(array(
          'tax_query'      => array(
            array(
              'taxonomy' => 'post_tag',
              'field'    => 'id',
              'terms'    => $term_ids,
              'operator' => 'IN',
            ),
          ),
          'post_type'      => 'post',
          'posts_per_page' => '3',
          'orderby'        => 'rand',
          'post__not_in'   => array( $post_id ),
        ));

        return $related_posts;
    }

    /**
     * Get post types options.
     *
     * @since   1.0.0
     * @access  public
     * @param   mixed $post
     * @return  mixed
     */
    public function get_post_thumbnail($args = array())
    {
        $default_args = array(
            'post_id'                    => 0,
            'size'                       => '',
            'height'                     => 50,
            'width'                      => 50,
            'title'                      => '',
            'link_wrapped'               => true,
            'permalink'                  => '',
            'a_class'                    => array(),
            'img_class'                  => array(),
            'img_style'                  => '',
            'img_after'                  => '', // Note: this value is not escaped/sanitized, and should be used for internal purposes only, not any user input
            'post_format_thumb_fallback' => false,
            'fallback'                   => '',
        );

        $args        = wp_parse_args($args, $default_args);
        $post_id     = $args['post_id'];
        $permalink   = $args['permalink'];
        $title       = $args['title'];
        $width       = (int)$args['width'];
        $height      = (int)$args['height'];
        $size        = !empty($args['size']) ? $args['size'] : array( $width, $height );
        $img_style   = $args['img_style'];

        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            $image_attributes = wp_get_attachment_image_src($thumbnail_id, $size);
        }

        $image_output  = $args['img_after'];
        if ($image_attributes) {
            $image_output = sprintf(
              '<img src="%1$s" alt="%2$s"%3$s %4$s/>%5$s',
              esc_attr($image_attributes[0]),
              esc_attr($title),
              (!empty($args['img_class']) ? sprintf(' class="%s"', esc_attr(implode(' ', $args['img_class']))) : ''),
              (!empty($img_style) ? sprintf(' style="%s"', esc_attr($img_style)) : ''),
              $args['img_after']
          );

            if ($args['link_wrapped']) {
                $image_output = sprintf(
                '<a href="%1$s" title="%2$s"%3$s%5$s>%4$s</a>',
                esc_attr($permalink),
                esc_attr($title),
                (!empty($args['a_class']) ? sprintf(' class="%s"', esc_attr(implode(' ', $args['a_class']))) : ''),
                $image_output,
                (!empty($img_style) ? sprintf(' style="%s"', esc_attr($img_style)) : '')
              );
            }
        }
        return $image_output;
    }
}

endif;
