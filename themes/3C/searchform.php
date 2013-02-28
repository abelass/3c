<?php
	$cat_id=$_GET['categorie_entreprise'];
	$s=$_GET['src']?$_GET['src']:$_GET['s'];
?>
	
	<form method="get" id="searchform" action="<?php echo esc_url(  get_permalink( 67) ); ?>">
	<input type="hidden" name="post_type" value="entreprise" />
	<input type="hidden"  name="type_entreprise"  value="<?php echo $type_entreprise ?>" value="<?php the_search_query() ?>"/>
		<input type="text" class="field" name="src" id="s" placeholder="<?php esc_attr_e( 'Search', '3C' ); ?>" value="<?php echo $s ?>"/>
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', '3C' ); ?>" />
	</form>
	<form method="get" id="searchform" action="<?php echo esc_url( get_permalink( 67)); ?>">
	    <input type="hidden" name="post_type" value="entreprise" />
		    <?php wp_dropdown_categories('hierarchical=1&name=categorie_entreprise&show_count=1&show_option_all='.__('Choisir categorie', '3C' ).'&hierarchical=1&depth=0&taxonomy=categorie_entreprise&selected='.$cat_id); ?>
		<input type="submit" class="submit" name="submit" id="searchsubmit2" value="<?php _e( 'Voir', '3C' ); ?>" />
	</form>
	

