<?php get_header(); ?>
<div id="main">
	<div>
		<div id="contentContainer">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

					<div class="postTitle"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>

					<div class="meta">

						<em>Posted on:</em> <span class="postTime"><?php the_time('F jS, Y') ?></span> by <span class="postAuthor"><?php echo get_the_author()?></span>
					</div>


					<div class="entry">
						<?php the_content(); ?>
					</div>

					<div class="postmetadata">
						<?php the_tags('Tags: ', ', ', '<br />'); ?>
						Entries: <?php the_category(', ') ?> 
					</div>

				
				</div>
					<?php comments_template(); ?>

				<?php endwhile; endif; ?>


			</div>

			<div id="sidebarContainer">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>


<?php get_footer(); ?>
