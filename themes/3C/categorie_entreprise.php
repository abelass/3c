<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
<?php
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$cat_id=get_query_var('categorie_entreprise');

$term = get_term_by('',$cat_id,'categorie_entreprise'); 

$type_entreprise=get_query_var('type_entreprise')?get_query_var('type_entreprise'): $type_entreprise;
if($type_entreprise)$q_te='&type_entreprise='.$type_entreprise;
$args = array(
  'base' => add_query_arg( 'paged', '%#%' ),
);

query_posts('categorie_entreprise='.$term->slug.$q_te.'&post_type=entreprise&posts_per_page=10&paged='.$paged);



//query_posts('post_type=entreprise&posts_per_page=10');

//$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 ;
/*$args = array( 'order' => 'DESC', 'orderby' => 'date', 'paged' => $paged,'cat' => $cat_id, 'post_type' => 'entreprise', 'posts_per_page' => 1 );

posts_per_page( $args );*/

?>





<?php get_header(); ?>1
	<?php if (get_option('minimal_integration_single_top') <> '' && get_option('minimal_integrate_singletop_enable') == 'on') echo(get_option('minimal_integration_single_top')); ?>	
	
	<div id="content" class="clearfix">
		<div id="content-area">
			
				<header class="page-header">
	
				<h1 class="entry-title"><?php  if($type_entreprise){ 
				$term=get_term_by('slug',$type_entreprise, 'type_entreprise',ARRAY_A);echo $term['name']; } ?></h1>	

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>
				
			<?php if ( have_posts() ) : 


					$format='search';
					
					include(locate_template('searchform_spec.php'));
					$search=true;

			?>

				<?php /* Start the Loop */  ?>
                          <?php // if(function_exists('wp_pagenavi')) { wp_pagenavi(); } 
                          global $wp_query;



			echo paginate_links( array(
				'base' => add_query_arg( 'page', '%#%' ),
				'format' => '?paged=%#%',
				'current' => max( 1, $paged ),
				'total' => $wp_query->max_num_pages
			) );
                          
                          
                          ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */

						get_template_part( 'content', 'search' );
					?>

				<?php endwhile; ?>


			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'threec' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'threec' ); ?></p>
						<?php include(locate_template('searchform_spec.php')); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

		</div> <!-- end #content-area -->	
	<?php get_sidebar(); ?>

	</div> <!-- end #content --> 
	
<?php get_footer(); ?>

