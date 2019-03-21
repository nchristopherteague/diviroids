<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="chancesare" />
	<meta charset="<?php bloginfo('charset'); ?>" />
	<?php
    elegant_description();
    elegant_keywords();
    elegant_canonical();
    do_action('et_head_meta');
  ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page-container">
			<?php
        do_action('et_before_main_content');

        $id = DiviRoids_Settings()->get(DiviRoids_Settings()->settings_prefix_name . '-csmr-layout', true);
        $page = get_page($id);
        echo apply_filters('the_content', $page->post_content);

        do_action('et_after_main_content');

        if ('on' == et_get_option('divi_back_to_top', 'false')) :
    ?>
    <span class="et_pb_scroll_top et-pb-icon"></span>
    <?php endif; ?>
  </div> <!-- #page-container -->
	<?php wp_footer(); ?>
</body>
</html>
