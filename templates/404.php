<?php get_header(); ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<article id="post-0" <?php post_class('et_pb_post not_found'); ?>>

					<?php
              $id = DiviRoids_Settings()->get(DiviRoids_Settings()->settings_prefix_name . '-404-layout', true);
              $page = get_page($id);
              echo apply_filters('the_content', $page->post_content);
          ?>

				</article> <!-- .et_pb_post -->
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>

		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>
