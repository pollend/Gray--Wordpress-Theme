<?php 
/**
 * Template Name: Front Page Template
 */
?>

<?php
define('WP_USE_THEMES', true);
 get_header(); ?>

<?php ?>
	<?php  get_template_part( 'Presentation', 'index' ); ?>

	<div id="main">
		<div>
		<div id="contentContainer" class="fullWidth">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

	

					<div class="entry">
						<?php the_content(); ?>
					</div>


				</div>
			<?php endwhile; ?>
		</div>


		<?php else : ?>

			<h2>Not Found</h2>

		<?php endif; ?>

		</div>
	</div>


<?php get_footer(); ?>
