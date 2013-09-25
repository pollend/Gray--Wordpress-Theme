<?php 



if ( 'posts' == get_option( 'show_on_front' ) ): 
	get_template_part( 'page', '' ); 
else:

update_option('current_page_template','front-page');
?>

<?php get_header(); ?>

<?php  get_template_part( 'Presentation', 'index' ); ?>
<?php get_footer(); 

endif;
?>
