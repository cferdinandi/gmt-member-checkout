<?php

/**
 * functions.php
 * For modifying and expanding core WordPress functionality.
 */

	/**
	 * Load inline header content
	 */
	function keel_load_inline_header() {
		?>
			<style type="text/css">
				<?php echo file_get_contents( get_theme_file_path('/dist/css/fonts.css') ); ?>
				<?php echo file_get_contents( get_theme_file_path('/dist/css/member-checkout.min.css') ); ?>
			</style>
		<?php
	}
	add_action('wp_head', 'keel_load_inline_header', 30);



	/**
	 * Load inline footer content
	 */
	function keel_load_inline_footer() {
		?>
			<script>
				<?php echo file_get_contents( get_theme_file_path('/dist/js/swInit.min.js') ); ?>
			</script>
		<?php
	}
	add_action('wp_footer', 'keel_load_inline_footer', 30);


	// Remove feeds from header
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );



	/**
	 * Customize the `wp_title` method
	 * @param  string $title The page title
	 * @param  string $sep   The separator between title and description
	 * @return string        The new page title
	 */
	function keel_pretty_wp_title( $title, $sep ) {

		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name
		$title .= get_bloginfo( 'name' );

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'keel' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'keel_pretty_wp_title', 10, 2 );



	/**
	 * Sets max allowed content width
	 * Deliberately large to prevent pixelation from content stretching
	 * @link http://codex.wordpress.org/Content_Width
	 */
	if ( !isset( $content_width ) ) {
		$content_width = 960;
	}



	/**
	 * Registers navigation menus for use with wp_nav_menu function
	 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
	 */
	function keel_register_menus () {
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu' ),
				'secondary' => __( 'Secondary Menu' ),
			)
		);
	}
	add_action( 'init', 'keel_register_menus' );



	/**
	 * Remove empty paragraphs created by wpautop()
	 * @author Ryan Hamilton
	 * @link https://gist.github.com/Fantikerz/5557617
	 */
	function keel_remove_empty_p ( $content ) {
		$content = force_balance_tags( $content );
		$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
		$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
		return $content;
	}
	add_filter('the_content', 'keel_remove_empty_p', 20, 1);



	/**
	 * Unlink images by default
	 */
	function keel_update_image_default_link_type () {
		update_option( 'image_default_link_type', 'none' );
	}
	add_action( 'admin_init', 'keel_update_image_default_link_type' );


	/**
	 * Check if more than one page of content exists
	 * @return boolean True if content is paginated
	 */
	function keel_is_paginated () {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Check if post is the last in a set
	 * @param  object  $wp_query WPQuery object
	 * @return boolean           True if is last post
	 */
	function keel_is_last_post ($wp_query) {
		$post_current = $wp_query->current_post + 1;
		$post_count = $wp_query->post_count;
		if ( $post_current == $post_count ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Print a pre formatted array to the browser - useful for debugging
	 * @param array $array Array to print
	 * @author 	Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_print_a ( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}



	// Remove Jetpack Styles
	add_filter( 'jetpack_implode_frontend_css', '__return_false' );



	/**
	 * Includes
	 */
	require_once( dirname( __FILE__) . '/includes/theme-options.php' ); // Theme options