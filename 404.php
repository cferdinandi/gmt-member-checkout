<?php

/**
 * 404.php
 * Template for 404 error page.
 */

// Get the theme options
$options = keel_get_theme_options();
if (!empty($options['404_url'])) {
	wp_redirect($options['404_url']);
}

get_header(); ?>


<article>
	<header>
		<h1><?php _e('Page not found.', 'gomakethings'); ?></h1>
	</header>

</article>


<?php get_footer(); ?>