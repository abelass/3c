<?php
/*

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
$args = array();
$args[0] = 'user_login';
$args[1] = 'user_nicename';
$args[2] = 'user_email';
$args[3] = 'user_url';
$wp_user_search = new WP_User_Query( array( 'role' => 'editor', 'fields' => $args ) );
$editors = $wp_user_search->get_results();

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
