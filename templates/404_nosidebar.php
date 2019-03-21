<?php get_header(); ?>


<div id="main-content">
	<article id="post-0" <?php post_class('et_pb_post not_found'); ?>>

		<?php
                $id = DiviRoids_Settings()->get(DiviRoids_Settings()->settings_prefix_name . '-404-layout', true);
                $page = get_page($id);
                echo apply_filters('the_content', $page->post_content);
        ?>

	</article> <!-- .et_pb_post -->
</div> <!-- #main-content -->

<?php get_footer(); ?>
