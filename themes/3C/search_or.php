<?php


/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);



?>
<?php get_header(); ?>	
	<div id="content" class="clearfix">
		<div id="content-area"<?php if ( isset($fullWidthPage) && $fullWidthPage ) echo(' class="fullwidth_home"');?>>
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', '3C' ), '<span>' . $s . '</span>' ); ?></h1>
				</header>
				
				<?php 
					$format='search';
					
					include(locate_template('searchform_spec.php'));
				 ?>

				<?php /* Start the Loop */ ?>
				<ul class="results">
				<?php while ( have_posts() ) : the_post(); ?>

					<li class="item"><?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content','search' );
					?></li>

				<?php endwhile; ?>
				</ul>

			<?php else :'' ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', '3C' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', '3C' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			
		</div> <!-- end #content-area -->	

<?php get_sidebar(); ?>
	</div> <!-- end #content --> 

<?php get_footer(); ?>	
