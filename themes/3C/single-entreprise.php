<?php get_header(); ?>
	<?php if (get_option('minimal_integration_single_top') <> '' && get_option('minimal_integrate_singletop_enable') == 'on') echo(get_option('minimal_integration_single_top')); ?>	
	
	<div id="content" class="clearfix">
		<div id="content-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php  the_title(); ?></h1>


	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php the_post_thumbnail(); ?>
		 
		<?php
		 the_content(); 
		 ?>
		
		<?php
			global $post;
			$prefix = '_mcf_';
			
			$address_composants=array('adresse','numero','code_postal','ville');
			$address_brut=array();
			foreach($address_composants AS $item){
				if(get_post_meta($post->ID,$prefix.$item,true)) $address_brut[]=get_post_meta($post->ID,$prefix.$item,true);
				}
			
			if(count($address_brut)>0)$address = implode(', ',$address_brut);
			if($address){
		?>
		
		<div class="map">
		<?php make_map($address); ?>
		</div>
		<?php } ?>
		<ul class="meta_data left">
		<li class="title"><?php _e('Contact','3C');?></li>
		<?php 
			$prefix = '_mcf_';
			$fields_contact=array('telephone'=>'T','fax'=>'F','email'=>'E','adresse'=>'A');

			foreach($fields_contact AS $field=>$label){
				if(get_post_meta($post->ID,$prefix.$field,true))
					if($field=='adresse'){
					echo '<li>'.$label. ' : '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).', '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.'numero',true)).', '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.'code_postal',true)).' - '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.'ville',true)).'</li>';
					}
					else echo '<li>'.$label. ' : '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'</li>';
			}
			
	
			
			?>
		</ul>		
		<ul class="meta_data right">
		<li class="title"><?php _e('Websites','3C');?></li>			
		<?php 
			$fields_websites=array('site_internet'=>__('Site Internet','3C'),'twitter'=>__('Twitter','3C'));

			foreach($fields_websites AS $field=>$label){
				if(get_post_meta($post->ID,$prefix.$field,true))
				if($field=='site_internet')
				echo '<li><a href="'.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'">'.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'</a></li>';
				else echo '<li>'.$label. ' : '.qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_post_meta($post->ID,$prefix.$field,true)).'</a></li>';
					
			}
			
	
			?>
		</ul>
				
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', '3C' ) . '</span>', 'after' => '</div>' ) ); ?>
		
		<?php if (get_post_type()=='entreprise'){
			
			if (do_shortcode('[access_entreprise_full]')){
				 
				$authors = get_coauthors();

	
				$log='';
				$listing=array('fonction');
				if(is_array($authors )){
					$log .='<h2 class="title-employees">'.__('Membre de ','3C').' '.get_the_title($post->ID)."</h2>\n";
					$log .="<ul class='liste authors'>\n";
					foreach($authors as $key=>$value){
						//$user = get_userdata( $value->ID );
						$login = $value->user_login;
						if($login !='admin'){
						$list='';
						foreach($listing AS $taxo){
							$name=get_the_author_meta($taxo,$value->ID);					
							if($name){
								$term=get_term_by('slug',$name,$taxo,ARRAY_A);
								$list.='<div class="'.$taxo.'">'.__(trim($taxo),'3C').' : '.$term['name']."</div>\n";
								}
							}
						$capabilities = $user->{$wpdb->prefix . 'capabilities'};
						$log .= '<li><h3>'.get_avatar( get_the_author_meta( 'user_email',$value->ID ), apply_filters( '3C_author_bio_avatar_size', 60 ) ).' <a href="'.get_author_posts_url($value->ID).'">'.$value->first_name.' '. $value->last_name.'</a></h3>'.$list."</li>\n";}
					}
				$log .="</ul>\n\n";
				
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

		<?php endwhile; endif; ?>
		</div> <!-- end #content-area -->	
	
<?php get_sidebar(); ?>
	</div> <!-- end #content --> 
	
<?php get_footer(); ?>
