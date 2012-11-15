<?php 
/*
Template Name: List all WP 
*/

?>


<?php get_header(); ?>	

	<div id="content" class="clearfix">
		<div id="content-area"<?php if ( isset($fullWidthPage) && $fullWidthPage ) echo(' class="fullwidth_home"');?>>
			<div class="entry clearfix">
				<!-- This sets the $curauth variable -->

    <?php
	global $wpdb, $coauthors_plus;
	$authors = $coauthors_plus->search_authors();
	foreach ( (array) $authors as $author ) {
	        $name = $author->display_name;
		echo "<li>".$name." - ".$author->ID;
		query_posts(array('post_type'=>'entreprise','posts_per_page'=>-1,'orderby'=>'title','order' => 'ASC'));
		while ( have_posts() ) : the_post();
			if(is_coauthor_for_post($author->ID,get_the_ID()));{
					echo ' - ';
					echo '<a href="'.get_permalink().'"  rel="bookmark">'.get_the_title().'</a>';
			}
		endwhile;
		echo "</li>";
	wp_reset_postdata();
	}

?>
		</div> <!-- end #content-area -->	

	</div> <!-- end #content --> 

<?php get_footer(); ?>	

