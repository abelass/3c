<?php 
/*
Template Name: List all co-authors 
*/

?>


<?php get_header(); ?>	

	<div id="content" class="clearfix">
		<div id="content-area"<?php if ( isset($fullWidthPage) && $fullWidthPage ) echo(' class="fullwidth_home"');?>>
			<div class="entry clearfix">
				<!-- This sets the $curauth variable -->

    <?php
    
				query_posts(array('post_type'=>'entreprise','posts_per_page'=>-1,'orderby'=>'title','order' => 'ASC'));

			
				while ( have_posts() ) : the_post();  
				//echo get_the_title();
					if(get_coauthors(get_the_ID())) { 
					$coauthdisplay = get_coauthors(get_the_ID());
					echo '<li>';
					echo '<a href="'.get_permalink().'"  rel="bookmark">'.get_the_title().'</a>';
					echo '<ul>';
					foreach($coauthdisplay as $coauth){
						echo "<li>".$coauth->data->user_login."</li>";
					}
					echo '</ul>';
					echo '</li>';
					
					 }endwhile; 
?>
		</div> <!-- end #content-area -->	
			<?php get_sidebar(); ?>	

	</div> <!-- end #content --> 

<?php get_footer(); ?>	

