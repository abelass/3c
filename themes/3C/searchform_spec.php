<?php



$sel=get_query_var('categorie_entreprise');
$s=$_GET['src']?$_GET['src']:$_GET['s'];

$posts=get_posts('post_type=entreprise');

/*foreach ($posts as $post_values) {
   $array_id[] = $post_values->ID;
}


$results = wp_get_object_terms($array_id, 'categorie_entreprise', 'fields=names' );
if ($results) {
    echo 'Tags: '.implode(', ', $results);
}*/



$id_posts=array();

foreach($posts as $post){
	$id_posts[]=$post->ID;
	}
	

	
$terms = wp_get_object_terms($id_posts,'categorie_entreprise',array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all'));


//$terms=array_unique($t);
//echo serialize($terms );

$parents=array();
$children=array();
$used=array();

foreach($terms AS $term){
	$parent=$term->parent;
	$id_term=$term->term_id;
		if($parent==0){
			$parents[]=$term;
		}
		else {
			//$parents[]=get_term($parent,'categorie_entreprise');
			$children[$parent][$term->name]=array('term_id'=>$term->term_id,'name'=>$term->name,'slug'=>$term->slug);
			}
		}
	
//sort($parents);

?>

	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/annuaire/'.qtrans_getLanguage().'/' ) ); ?>">
		<input type="hidden" name="post_type" value="entreprise" />
		<input type="hidden"  name="type_entreprise"  value="<?php echo $type_entreprise ?>" value="<?php the_search_query() ?>"/>
		<input type="text" class="field" name="src" id="src" placeholder="<?php esc_attr_e('Search', '3C' ); ?>" value="<?php echo $s ?>"/>

		    <?php
		    if(count($terms)>0){
	echo '<select class="postform" name="categorie_entreprise">';
	echo '<option value="0">'.__( 'Choisir categorie', '3C' ).'</option>';	
	foreach($parents AS $parent){
		$id_term_p=$parent->term_id;
		if(!in_array($id_term_p,$used)){
			if($sel==$parent->slug)$selected=' selected="selected"';
			else $selected='';
			echo '<option class="level-0" value="'.$id_term_p.'"' .$selected.'>'.$parent->name.'</option>';
			$used[]=$id_term_p;
			foreach($children[$id_term_p] AS $child){
				$id_term=$child['term_id'];
				if($sel==$child['slug'])$selected=' selected="selected"';
				else $selected='';
				echo '<option class="level-1" value="'.$id_term.'"' .$selected.'>&nbsp;&nbsp;&nbsp;'.$child['name'].'</option>';			
			}
		}
		
		}
		
	
	echo '</select>';	
		    
	}	    
		 //    wp_dropdown_categories('&hierarchical=1&name=categorie_entreprise&show_count=1&show_option_all='.__( 'Acceder fiche membre', '3C' ).'&hierarchical=1&depth=0&taxonomy=categorie_entreprise&selected='.$cat_id); ?>
		<input type="submit" class="submit" name="submit" id="searchsubmit2" value="<?php _e( 'Voir', '3C' ); ?>" />
	</form>
	

