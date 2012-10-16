<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php the_post_thumbnail(); ?>
		 
		<?php
		 the_content(); 
		 ?>
		
		<div class="map">
		<?php make_map(); ?>
		</div>
		
		<ul class="meta_data left">
		<li class="title"><?php _e('Contact','3C');?></li>
		<?php 
			$prefix = '_mcf_';
			$fields_contact=array('telephone'=>'T','fax'=>'F','email'=>'E');

			foreach($fields_contact AS $field=>$label){
				if(get_post_meta($post->ID,$prefix.$field,true))echo '<li>'.$label. ' : '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'</li>';
			}
			
	
			
			?>
		</ul>		
		<ul class="meta_data right">
		<li class="title"><?php _e('Websites','3C');?></li>			
		<?php 
			$fields_websites=array('site_internet'=>__('Site Internet','3C'),'twitter'=>__('Twitter','3C'));

			foreach($fields_websites AS $field=>$label){
				if(get_post_meta($post->ID,$prefix.$field,true))echo '<li>'.$label. ' : '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'</li>';
			}
			
	
			
			?>
		</ul>		
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', '3C' ) . '</span>', 'after' => '</div>' ) ); ?>
		
		<?php if (get_post_type()=='entreprise'){
			
			if (do_shortcode('[access_entreprise_full]')){
				 
				$authors = get_coauthors();

	
				$log='';
				if(is_array($authors )){
					$log .='<h2 class="title-employees">'.__('Membre de','3C').' '.the_title().'</h2>';
					$log .= '<ul>';
					foreach($authors as $key=>$value){
						$user = get_userdata( $value->ID );
						
						$name=get_the_author_meta('fonction',$value->ID);
						
							if($name){$myrows = $wpdb->get_results( "SELECT name FROM wp_terms WHERE slug='$name'",ARRAY_A );

							$name= qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($myrows[0]['name']);}
	
						$capabilities = $user->{$wpdb->prefix . 'capabilities'};
							$log .= '<li><h3>'.get_avatar( get_the_author_meta( 'user_email',$value->ID ), apply_filters( '3C_author_bio_avatar_size', 60 ) ).' <a href="'.get_author_posts_url($value->ID).'">'.$value->first_name.' '. $value->last_name.'</a></h3>
							'.(get_the_author_meta('fonction',$value->ID)?'<div class="fonctions">
								'.__('Fonction','3C').' : '.$name.'
							</div>':'').'</li>';
					}
				$log .=  '</ul>';
				
				}
				echo $log;
				}
			}

    
    ?>			
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', '3C' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', '3C' ) );

		?>
		<?php edit_post_link( __( 'Edit', '3C' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
