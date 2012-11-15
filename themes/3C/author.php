<?php 
/*
Template Name: Author Page
*/

?>


<?php get_header(); ?>	

	<div id="content" class="clearfix">
		<div id="content-area"<?php if ( isset($fullWidthPage) && $fullWidthPage ) echo(' class="fullwidth_home"');?>>
			<div class="entry clearfix">
				<!-- This sets the $curauth variable -->

    <?php
    
    if (do_shortcode('[access_entreprise_full]')){
   // if (isset($_GET['author_name']) OR isset($_GET['author']) ){
    
    /* $curauth = (
		isset($_GET['author_name']) ? 
			get_user_by('slug', $author_name) : 
			(isset($_GET['author']) ? get_userdata(intval($author)) :'')
		);*/
	$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));	
	//$curauth = (get_query_var('author')) ? get_user_by('slug', get_query_var('author')) : get_userdata(get_query_var('author'));
	

	if($search=trim(get_query_var('s'))){
		
		
		

        $result = $wpdb->get_results("SELECT * from $wpdb->users  WHERE $wpdb->users.user_nicename LIKE '%$search%' ORDER BY last_name");                       
                                        

		}
	if($curauth) $id_auteur=$curauth->ID;	

	    $author_fields = array( 'ID');

	    //$abonnes='';
	    $abonne_gratuits = get_users( array( 'role' => 'member-limited-access', 'fields' => $author_fields ) );
	    $abonne_payants = get_users( array( 'role' => 'member-full-access', 'fields' => $author_fields ) );
        $member_full_access_associated = get_users( array( 'role' => 'member-full-access-associated', 'fields' => $author_fields ) );
        $admin_prive = get_users( array( 'role' => 'admin_prive', 'fields' => $author_fields ) );	    
	    $id_abonne_gratuits=array();
	    foreach( $abonne_gratuits AS $id_g){
			$id_abonne_gratuits[] = $id_g->ID;
			}
			
	    $id_abonne_payants=array();
	    foreach( $abonne_payants AS $id_g){
			$id_abonne_payants[] = $id_g->ID;
			}
        
	    $id_admin_prive =array();
	    foreach( $admin_prive AS $id_g){
			$id_admin_prive [] = $id_g->ID;
			}
        
        $id_member_full_access_associated =array();
        foreach( $member_full_access_associated  AS $id_g){
            $id_admin_prive [] = $id_g->ID;
            }
        
	    $abonnes=array_merge( $id_abonne_payants,$id_abonne_gratuits,$id_admin_prive,$id_member_full_access_associated);
	    //$id_abonnes=implode($abonnes,',');  
	    

	   $users = get_users( array( 'include' =>$abonnes, 'fields' =>'all_with_meta','orderby'=>'lastname' ) );
       // merci à http://wordpress.stackexchange.com/questions/29179/order-by-first-name
       usort($users, create_function('$a, $b', 'if($a->user_lastname == $b->user_lastname) { return 0;} return ($a->user_lastname > $b->user_lastname) ? 1 : -1;'));
      //echo serialize($users);

	
    ?>

    <?php if(!$curauth){ ?>
    		<header class="page-header">
	
				<h1 class="entry-title">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
						the_title() ;
						endwhile; endif; ?>
				</h1>	
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
				?>
				</header>
    
    
    <?php } 
    ?>
        <div class="side-by-side clearfix">

	<form method="get" id="searchform"  action="<?php echo home_url('/'.qtrans_getLanguage().'/'); ?>">
<select name="author" id="author" class="author chzn-select-deselect">
    <option value="-1"><?php _e('Choisir Membre','3C') ?></option>
    <?php 
    foreach ($users as $user) {
        echo '<option value="'.$user->ID.'">'.$user->user_lastname.' '.$user->user_firstname.'</option>';
    }
    ?>
        <input type="submit" id="searchsubmit_view" value="<?php _e('Voir la Fiche','3C') ?>" />
    </form>
	</div>
	 <script type="text/javascript"> 
	 $(".chzn-select-deselect").chosen({allow_single_deselect:true});
 </script>

	<?php
		if($curauth){
			//foreach($result AS $curauth){
			 ?>
		
		<h1 class="entry-title">    <?php echo get_the_author_meta('first_name',$curauth->ID).' '.get_the_author_meta('last_name',$curauth->ID); ?></h1>
	
				<div id="author-info">
					<div id="author-avatar">
						<?php //echo userphoto($id_auteur); ?>
					</div><!-- #author-avatar -->
					<div id="author-description">
						<?php echo qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage(get_the_author_meta('description',$curauth->ID)); ?>
					</div><!-- #author-description	-->
				</div><!-- #entry-author-info -->
    <dl>

        <?php 
        // Si autorisé on affiche les metas





        if (do_shortcode('[access_entreprise_full]')){
			$display=array(
				__('Profil','3C')=>array('fonction','formation','niveau_experience','date_naissance','lang'),
				__('Coordonn&eacute;es','3C')=>array('ville','telephone','fax','site_web','facebook', 'twitter','google_plus','Skype','jabber_google')
				);
								
				$fields_convert=array('fonction','formation','niveau_experience');	
							$dis=array();
			foreach($display AS $titre=>$fields){

									
				foreach($fields AS $field){
					if(get_the_author_meta($field,$curauth->ID)){
															
						$name=get_the_author_meta($field,$curauth->ID);
						if(in_array($field,$fields_convert)){
							$term=get_term_by('slug',$name,$field,ARRAY_A);
							$name=$term['name'];
							}
							if($name)$dis['<dt>'.__($titre,'3C').'</dt>'][]='<dd>'.__($field,'3C').' : '  . $name.'</dd>';
							}									
						}
					}
					foreach ($dis AS $title=>$items){
						if(count($items)>0){
							echo $title;
							foreach($items AS $item){
								echo $item;
							}
							
						}
					}
				}		
		 ?>
    </dl>
				<?php 
				
				query_posts(array('post_type'=>'entreprise','posts_per_page'=>-1,'orderby'=>'title','order' => 'ASC'));
				$display2=array();

			
				while ( have_posts() ) : the_post();  
				//echo get_the_title();
					if(is_coauthor_for_post($id_auteur,get_the_ID())) { 
					$display2['<h2>'.__('Les Entreprises','3C').'</h2>'][]='
					<li>
						<a href="'.get_permalink().'"  rel="bookmark">'.get_the_title().'</a>
					</li>';
					
					 }endwhile; 
				
					foreach ($display2 AS $title=>$items){
						if(count($items)>0){
							echo $title;
							echo '<ul>';
							foreach($items AS $item){
								echo $item;
							}
						echo '</ul>';
						}
					}
		}
		/*else{
	
					echo '<ul  class="liste authors">';
					$args = array(
						'orderby' => 'user_registered',
						'include' => $abonnes,
						'orderby' => 'display_name',						
						'order' => 'ASC',
						'number' => 10,
						 );
					
					$listing=array('fonction');
					$lesderniers=get_users($args);
					foreach($lesderniers AS $id){
						$id_auteur=	$id->ID ;
						$entreprise='';					
						$user = get_userdata($id->ID );
						$list='';

						$name=get_the_author_meta('fonction',$id->ID);						
							if($name){
								$term=get_term_by('slug',$name,'fonction',ARRAY_A);

				//pas très propre, mais je n'ai pas trouvé comment afficher les entreeprise par coautheur
				query_posts('post_type=entreprise'); 			
				while ( have_posts() ) : the_post(); 
					if(is_coauthor_for_post($id_auteur,get_the_ID())) {
						 $entreprise=get_the_title();  }	
				endwhile; 		
						$list.='<div class="entreprise">'.$entreprise.' : '.$term['name']."</div>\n";
								}
							
						
						echo '<li><h3><a href="'.get_author_posts_url($id_auteur).'">'.get_the_author_meta('first_name',$id_auteur).' '. get_the_author_meta('last_name',$id_auteur).'</a>';
						userphoto_thumbnail($id_auteur);
						echo ' </h3>
							'.$list.'</li>';
						}
					echo '</ul>';
				}*/
				

					}
				else {?>
							<header class="page-header">
	
				<h1 class="entry-title">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
						the_title() ;

						endwhile; endif; ?>
				</h1>	
				</header>
					<?php echo '<p>'.__('Access non authorise - devenez membre','3C').'
					</p>';	
					
					}

?>
			</div> <!-- end .entry -->

		</div> <!-- end #content-area -->	
			<?php get_sidebar(); ?>	

	</div> <!-- end #content --> 

<?php get_footer(); ?>	


