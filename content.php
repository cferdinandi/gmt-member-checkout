<?php

/**
 * content.php
 * Template for post content.
 */

$options = keel_get_theme_options();

?>

<?php
	/**
	 * Individual Posts
	 */
	if ( is_single() ) :
?>

	<article>

		<header>

			<aside class="text-muted">
				<time datetime="<?php the_time( 'F j, Y' ); ?>" pubdate><?php the_time( 'F j, Y' ); ?></time>
				<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
			</aside>

			<h1 class="no-padding-top">
				<?php the_title(); ?>
			</h1>

		</header>


		<?php
			// The post content
			the_content();
		?>

	</article>

<?php
	/**
	 * All Posts
	 */
	else :
?>

	<h1><?php _e('Posts', 'gomakethings'); ?></h1>

	<?php
		global $year;
		$post_year = get_the_time( 'F Y', $post );
		if ( empty($year) || strcmp( $year, $post_year ) !== 0 ) :
	?>
		<h2 <?php echo ( $wp_query->current_post === 0 ? 'class="no-padding-top"' : '' ); ?>><?php echo $post_year; ?></h2>
	<?php
		$year = $post_year;
		endif;
	?>

	<article>

		<header class="row">

			<div class="grid-fourth grid-flip ">
				<aside class="text-muted text-small">
					<time datetime="<?php the_time( 'F j, Y' ); ?>" pubdate><?php the_time( 'F j, Y' ); ?></time>
				</aside>
			</div>

			<div class="grid-three-fourths">
				<h3 class="h5 text-normal no-padding-top">
					<a class="link-no-underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
				</h3>
			</div>

		</header>

	</article>

<?php endif; ?>