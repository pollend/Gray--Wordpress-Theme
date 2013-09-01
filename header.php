<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<style type="text/css">
		body{
			background: rgb(25,88,160); /* Old browsers */
			background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPHJhZGlhbEdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNzUlIj4KICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiMxOTU4YTAiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjMDAxYTZiIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L3JhZGlhbEdyYWRpZW50PgogIDxyZWN0IHg9Ii01MCIgeT0iLTUwIiB3aWR0aD0iMTAxIiBoZWlnaHQ9IjEwMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,-moz-radial-gradient(center, ellipse cover,  <?php echo get_theme_mod('gray_gradient_one'); ?> 0%, <?php echo get_theme_mod('gray_gradient_two'); ?> 100%); /* FF3.6+ */
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,-webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,<?php echo get_theme_mod('gray_gradient_one'); ?>), color-stop(100%,<?php echo get_theme_mod('gray_gradient_two'); ?>)); /* Chrome,Safari4+ */
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,-webkit-radial-gradient(center, ellipse cover,  <?php echo get_theme_mod('gray_gradient_one'); ?> 0%,<?php echo get_theme_mod('gray_gradient_two'); ?> 100%); /* Chrome10+,Safari5.1+ */
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,-o-radial-gradient(center, ellipse cover, <?php echo get_theme_mod('gray_gradient_one'); ?> 0%,<?php echo get_theme_mod('gray_gradient_two'); ?> 100%); /* Opera 12+ */
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,-ms-radial-gradient(center, ellipse cover,  <?php echo get_theme_mod('gray_gradient_one'); ?> 0%,<?php echo get_theme_mod('gray_gradient_two'); ?> 100%); /* IE10+ */
			background: url("<?php echo get_theme_mod('gray_pattern_repeat'); ?>") repeat top left,radial-gradient(ellipse at center, <?php echo get_theme_mod('gray_gradient_one'); ?> 0%,<?php echo get_theme_mod('gray_gradient_two'); ?> 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1958a0', endColorstr='#001a6b',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */

		}

	</style>

	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php // Site Main javascript ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/main.js" type="text/javascript"></script>
</head>

<body <?php body_class(); ?>>
	
	<div id="page">

		<div id="header">
			<div id="title">
				<div id="searchFormContainer"><?php get_search_form(); ?></div>
				<?php if(get_header_image() == "") : ?>
					<a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
				<?php else: ?>
					<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
				<?php endif; ?>

			</div>
			<div class="description"><?php bloginfo('description'); ?></div>
		</div>
					<?php wp_nav_menu(); ?>

