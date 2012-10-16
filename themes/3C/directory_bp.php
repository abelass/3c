<?php
/*
Template Name: Directory Page
*

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
	// Sortir les custom fields;
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
	<?php if (get_option('minimal_integration_single_top') <> '' && get_option('minimal_integrate_singletop_enable') == 'on') echo(get_option('minimal_integration_single_top')); ?>	
	
	<div id="content" class="clearfix">
		<div id="content-area">
			
			<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<div class="form search">
		<?php get_search_form(); ?>
		
				<?php endwhile; ?>
			</div>
						
				<?php
		global $wp_query;
		$total_results = $wp_query->found_posts;
		?>
		</div> <!-- end #content-area -->	
	
<?php get_sidebar(); ?>
	</div> <!-- end #content --> 
	
<?php get_footer(); ?>
