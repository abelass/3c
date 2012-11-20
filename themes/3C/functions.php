<?php 

// Fix for menu not dipalying the right language
add_filter('walker_nav_menu_start_el', 'qtrans_in_nav_el', 10, 4);
function qtrans_in_nav_el($item_output, $item, $depth, $args){
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    
   // Determine integration with qTranslate Plugin
   if (function_exists('qtrans_convertURL')) {
      $attributes .= ! empty( $item->url ) ? ' href="' . qtrans_convertURL(esc_attr( $item->url )) .'"' : '';
   } else {
      $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
   }
   
   $item_output = $args->before;
   $item_output .= '<a'. $attributes .'>';
   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
   $item_output .= '</a>';
   $item_output .= $args->after;
      
   return $item_output;
}


add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname;
		$themename = "3C";
		$shortname = "minimal";
	
		require_once(TEMPLATEPATH . '/epanel/custom_functions.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/comments.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/sidebars.php'); 

		load_theme_textdomain('3C',get_template_directory().'/lang');

		require_once(TEMPLATEPATH . '/epanel/options_minimal.php');

		require_once(TEMPLATEPATH . '/epanel/core_functions.php'); 

		require_once(TEMPLATEPATH . '/epanel/post_thumbnails_minimal.php');
		
		include(TEMPLATEPATH . '/includes/widgets.php');
	}
}

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -11px; }
		.et_pt_portfolio_item { margin-left: 23px; }
		.et_portfolio_small { margin-left: -39px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 35px !important; }
		.et_portfolio_large { margin-left: -20px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 14px !important; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'footer-menu' => __( 'Footer Menu' )
		)
	);
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );



/*if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}*/

// New post types
add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
register_post_type(
	'entreprise',
	 array(
		'label' => 'Enreprise',
		'description' => 'Entreprise',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' =>
		 array('slug' => ''),
		 'query_var' => true,
		 'supports' =>
				array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','adresse'),
		 'taxonomies' =>
				array(''),
		 'labels' => 
				array (
				  'name' => __('entreprises','3C'),
				  'singular_name' => __('entreprise','3C'),
				  'menu_name' => __('Companies','3C'),
				  'add_new' => __('Add company','3C'),
				  'add_new_item' => __('Add A New Company','3C'),
				  'edit' => __('Edit Company Profile','3C'),
				  'edit_item' => __('Edit Company','3C'),
				  'new_item' => __('New Company','3C'),
				  'view' => __('Preview Company','3C'),
				  'view_item' => __('Preview Company','3C'),
				  'search_items' =>__('Search Company','3C'),
				  'not_found' => __('Company Not Found','3C'),
				  'not_found_in_trash' => __('Company Not Found TO TRASH','3C'),
				  'parent' => __('Parent Company','3C'),
					),
			) 
		);
		
}	

// Custom fields

if ( !class_exists('myCustomFields') ) {

	class myCustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = '_mcf_';
		/**
		* @var  array  $postTypes  An array of public custom post types, plus the standard "post" and "page" - add the custom types you want to include here
		*/
		var $postTypes = array( "page", "post","entreprise" );
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields =	array(
			array(
				'name'			=> 'adresse',
				'title'		=> 'Adresse',
				'description'	=> '',
				"type"			=> "textarea",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,
			),
			array(
				'name'			=> 'numero',
				'title'		=> 'numero',
				'description'	=> '',
				"type"			=> "text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,
			),
			array(
				"name"			=> "code_postal",
				"title"			=> "Code postal",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,				
			),
			array(
				"name"			=> "ville",
				"title"			=> "Ville",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,
			),
			array(
				"name"			=> "tva",
				"title"			=> "Tva",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts"
			),
			array(
				"name"			=> "telephone",
				"title"			=> "Telephone",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,			
			),
			array(
				"name"			=> "fax",
				"title"			=> "Fax",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,
			),
			array(
				"name"			=> "site_internet",
				"title"			=> "Site Internet",
				"description"	=> "",
				"type"			=>	"text",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts",
				"required"		=> true,
			),
			/*array(
				"name"			=> "checkbox",
				"title"			=> "Checkbox",
				"description"	=> "",
				"type"			=> "checkbox",
				"scope"			=>	array( "entreprise" ),
				"capability"	=> "edit_posts"
			)*/
		);
		
		
		/**
		* PHP 4 Compatible Constructor
		*/
		function myCustomFields() { $this->__construct(); }
		/**
		* PHP 5 Constructor
		*/
		function __construct() {
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
		//	add_action( 'pre_post_update', array( &$this, 'validateCustomFields' ), 1, 2 );

			
			// Comment this line out if you want to keep default custom fields meta box
			//add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
		}
		/**
		* Remove the default Custom Fields meta box
		*/
		/*function removeDefaultCustomFields( $type, $context, $post ) {
			foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
				foreach ( $this->postTypes as $postType ) {
					remove_meta_box( 'postcustom', $postType, $context );
				}
			}
		}*/
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			if ( function_exists( 'add_meta_box' ) ) {
				foreach ( $this->postTypes as $postType ) {
					add_meta_box( 'my-custom-fields',__('Information additionnel','3C'), array( &$this, 'displayCustomFields' ), $postType, 'normal', 'high' );
				}
			}
		}
		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post;
			?>
			<div class="form-wrap">
				</style>

  

				<?php
				wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
				foreach ( $this->customFields as $customField ) {
					// Check scope
					$scope = $customField[ 'scope' ];
					$output = false;
					foreach ( $scope as $scopeItem ) {
						switch ( $scopeItem ) {
							default: {
								if ( $post->post_type == $scopeItem )
									$output = true;
								break;
							}
						}
						if ( $output ) break;
					}
					// Check capability
					if ( !current_user_can( $customField['capability'], $post->ID ) )
						$output = false;
					// Output if allowed
					if ( $output ) { ?>
						<div class="form-field required">

							<?php
							switch ( $customField[ 'type' ] ) {
								case "checkbox": {
									// Checkbox
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . __($customField[ 'title' ],'3C') . '</b></label>&nbsp;&nbsp;';
									echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
									if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
										echo ' checked="checked"';
									echo '" style="width: auto;" />';
									break;
								}
								case "textarea":
								case "wysiwyg": {
									// Text area
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' 
									. __($customField[ 'title' ],'3C') . '</b></label>';
									echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
									// WYSIWYG
									if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
										<script type="text/javascript">
											jQuery( document ).ready( function() {
												jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
												if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
													tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
												}
											});
										</script>
									<?php }
									break;
								}
								default: {
									// Plain text field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' .  __($customField[ 'title' ],'3C') . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									break;
								}
							}
							?>
							<?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
						</div>
					<?php
					}
				} ?>
			</div>
			<?php
		}
	
		
		/**
		* Validate de custom fields
		*/
		function validateCustomFields($id) {
		     $post = get_post($id);
		     // now do something with it
		}




		
		/**
		* Save the new Custom Fields values
		*/
		function saveCustomFields( $post_id, $post ) {
			if ( !isset( $_POST[ 'my-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			if ( ! in_array( $post->post_type, $this->postTypes ) )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) ) {
					if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {echo 1;
						$value = $_POST[ $this->prefix . $customField['name'] ];
						// Auto-paragraphs for any WYSIWYG
						if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
					} else {echo 2;
						return 'error';
						//delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
					}
				}
			}
		}

	} // End Class

} // End if class exists statement

// Instantiate the class
if ( class_exists('myCustomFields') ) {
	$myCustomFields_var = new myCustomFields();
}
		

// New taxamonies
add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
	/*register_taxonomy( 'secteur_activite', 'entreprise', array( 'hierarchical' => false, 'label' => __('Secteur Activite','3C'), 'query_var' => true, 'rewrite' => true ) );*/
	register_taxonomy( 'fonction', 'user', array( 'hierarchical' => false, 'label' => __('fonction','3C'), 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'formation', 'user', array( 'hierarchical' => false, 'label' => __('formation','3C'), 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'niveau_experience', 'user', array( 'hierarchical' => false, 'label' => __('niveau_experience','3C'), 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'type_entreprise', 'entreprise', array( 'hierarchical' => false, 'label' => __('Company type','3C'), 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'categorie_entreprise', 'entreprise', array( 'hierarchical' => true, 'label' => __('Company category','3C'), 'query_var' => 'categorie_entreprise', 'rewrite' => array('slug'=>'categorie_entreprises') ) );	
}

// Translate de custom taxo
function qtranslate_edit_taxonomies(){
   $args=array(
      'public' => true ,
      '_builtin' => false
   ); 
   $output = 'object'; // or objects
   $operator = 'and'; // 'and' or 'or'

   $taxonomies = get_taxonomies($args,$output,$operator); 

   if  ($taxonomies) {
     foreach ($taxonomies  as $taxonomy ) {
         add_action( $taxonomy->name.'_add_form', 'qtrans_modifyTermFormFor');
         add_action( $taxonomy->name.'_edit_form', 'qtrans_modifyTermFormFor');        
      
     }
   }

}
add_action('admin_init', 'qtranslate_edit_taxonomies');

// Replace cutomstom taxo search menu by a dropdown menu
function custom_meta_box() {

    remove_meta_box( 'tagsdiv-type_entreprise', 'entreprise', 'side' );
    //remove_meta_box( 'categorydiv', 'post', 'side' );

    add_meta_box( 'tagsdiv-types', __('Company type','3C'), 'types_meta_box', 'entreprise', 'side' );
	//add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args );
}
add_action('add_meta_boxes', 'custom_meta_box');

/* Prints the taxonomy box content */
function types_meta_box($post) {

    $tax_name = 'type_entreprise';
    $taxonomy = get_taxonomy($tax_name);
?>
<div class="tagsdiv" id="<?php echo $tax_name; ?>">
    <div class="jaxtag">
    <?php 
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'types_noncename' );
    $type_IDs = wp_get_object_terms( $post->ID, 'type_entreprise', array('fields' => 'ids') );
   if($type_IDs)$sel=$type_IDs[0];
   else $sel='';
    wp_dropdown_categories('taxonomy=type_entreprise&hide_empty=0&orderby=name&name=type_entreprise&show_option_none='.__('Select type','3C').'&selected='.  $sel); ?>
    <p class="howto"><?php  _e('Select type','3C');?></p>
    </div>
</div>
<?php
}
/* When the post is saved, saves our custom taxonomy */
function types_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['types_noncename'], plugin_basename( __FILE__ ) ) )
      return;


  // Check permissions
  if ( 'type_entreprise' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  $type_ID = $_POST['type_entreprise'];

  $type = ( $type_ID > 0 ) ? get_term( $type_ID, 'type_entreprise' )->slug : NULL;

  wp_set_object_terms(  $post_id , $type, 'type_entreprise' );

}
/* Do something with the data entered */
add_action( 'save_post', 'types_save_postdata' );
/**
 * Function for updating the 'fonction' taxonomy count.  What this does is update the count of a specific term
 * by the number of users that have been given the term.  We're not doing any checks for users specifically here.
 * We're just updating the count with no specifics for simplicity.
 *
 * See the _update_post_term_count() function in WordPress for more info.
 *
 * @param array $terms List of Term taxonomy IDs
 * @param object $taxonomy Current taxonomy object of terms
 */
function threec_update_fonction_count( $terms, $taxonomy ) {
	global $wpdb;

	foreach ( (array) $terms as $term ) {

		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term ) );

		do_action( 'edit_term_taxonomy', $term, $taxonomy );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
		do_action( 'edited_term_taxonomy', $term, $taxonomy );
	}
}

/* Adds the taxonomy page in the admin. */
add_action( 'admin_menu', 'threec_add_tax_admin_page' );

/**
 * Creates the admin page for the 'fonction' taxonomy under the 'Users' menu.  It works the same as any
 * other taxonomy page in the admin.  However, this is kind of hacky and is meant as a quick solution.  When
 * clicking on the menu item in the admin, WordPress' menu system thinks you're viewing something under 'Posts'
 * instead of 'Users'.  We really need WP core support for this.
 */
function threec_add_tax_admin_page() {

	$tax = get_taxonomy( 'fonction' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
	
		$tax = get_taxonomy( 'formation' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
	
		$tax = get_taxonomy( 'niveau_experience' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
	
		$tax = get_taxonomy( 'categorie_entreprise' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
	
}



/* Create custom columns for the manage profession page. */
add_filter( 'manage_edit-fonction_columns', 'threec_manage_fonction_user_column' );

/**
 * Unsets the 'posts' column and adds a 'users' column on the manage profession admin page.
 *
 * @param array $columns An array of columns to be shown in the manage terms table.
 */
function threec_manage_fonction_user_column( $columns ) {

	unset( $columns['posts'] );

	$columns['users'] = __( 'Users' );

	return $columns;
}

/* Customize the output of the custom column on the manage fonction page. */
add_action( 'manage_fonction_custom_column', 'threec_manage_fonction_column', 10, 3 );

/**
 * Displays content for custom columns on the manage fonctions page in the admin.
 *
 * @param string $display WP just passes an empty string here.
 * @param string $column The name of the custom column.
 * @param int $term_id The ID of the term being displayed in the table.
 */
function threec_manage_fonction_column( $display, $column, $term_id ) {

	if ( 'users' === $column ) {
		$term = get_term( $term_id, 'fonction' );
		echo $term->count;
	}
}

/* Create custom columns for the manage formation page. */
add_filter( 'manage_edit-formation_columns', 'threec_manage_formation_user_column' );

/**
 * Unsets the 'posts' column and adds a 'users' column on the manage formation admin page.
 *
 * @param array $columns An array of columns to be shown in the manage terms table.
 */
function threec_manage_formation_user_column( $columns ) {

	unset( $columns['posts'] );

	$columns['users'] = __( 'Users' );

	return $columns;
}

/* Customize the output of the custom column on the manage professions page. */
add_action( 'manage_formation_custom_column', 'threec_manage_formation_column', 10, 3 );

/**
 * Displays content for custom columns on the manage professions page in the admin.
 *
 * @param string $display WP just passes an empty string here.
 * @param string $column The name of the custom column.
 * @param int $term_id The ID of the term being displayed in the table.
 */
function threec_manage_formation_column( $display, $column, $term_id ) {

	if ( 'users' === $column ) {
		$term = get_term( $term_id, 'formation' );
		echo $term->count;
	}
}

/* Create custom columns for the manage niveau_experience page. */
add_filter( 'manage_edit-niveau_experience_columns', 'threec_manage_niveau_experience_user_column' );

/**
 * Unsets the 'posts' column and adds a 'users' column on the manage formation admin page.
 *
 * @param array $columns An array of columns to be shown in the manage terms table.
 */
function threec_manage_niveau_experience_user_column( $columns ) {

	unset( $columns['posts'] );

	$columns['users'] = __( 'Users' );

	return $columns;
}

/* Customize the output of the custom column on the manage professions page. */
add_action( 'manage_niveau_experience_custom_column', 'threec_manage_niveau_experience_column', 10, 3 );

/**
 * Displays content for custom columns on the manage professions page in the admin.
 *
 * @param string $display WP just passes an empty string here.
 * @param string $column The name of the custom column.
 * @param int $term_id The ID of the term being displayed in the table.
 */
function threec_manage_niveau_experience_column( $display, $column, $term_id ) {

	if ( 'users' === $column ) {
		$term = get_term( $term_id, 'niveau_experience' );
		echo $term->count;
	}
}

// add to admin header
function my_admin_init() {
	//jquery
	wp_enqueue_script('jquery');
	
	//jquery-ui
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widgets');
	// datepicker
	wp_enqueue_script('jquery.ui.datepicker', get_template_directory_uri(). '/js/jquery.ui.datepicker.js', array('jquery', 'jquery-ui-core') );
	wp_enqueue_style('jquery.ui.theme', get_template_directory_uri().  '/js/css/lightness/jquery-ui-1.8.16.custom.css');
	// jquery validate
	wp_enqueue_script('jqueryvalidate',  get_template_directory_uri() .'/js/jquery.validate.min.js', array('jquery'));
	//wp_enqueue_script('jquery.validate.min.js');
	wp_enqueue_style('jquery-validate',get_template_directory_uri() . '/js/css/style.css');
	
	// validation rules
	wp_enqueue_script('validation_entreprise',  get_template_directory_uri() .'/js/validation_entreprise.js');
}
add_action('admin_init', 'my_admin_init');


/* Add section to the edit user page in the admin to select profession. */
add_action( 'show_user_profile', 'threec_edit_user_fonction_section' );
add_action( 'edit_user_profile', 'threec_edit_user_fonction_section' );

// changes the contactmethods
function threec_user_contactmethods(){
 return array(
 'site_web' => __( 'site_web','3C' ),
 'facebook' => __( 'facebook','3C' ),
 'twitter' => __( 'twitter','3C' ),
 'google_plus' => __('google_plus','3C' ),
 'Skype' => __( 'Skype','3C' ),
 'jabber_google' => __( 'jabber_google','3C' ).'/'.__( 'Google Talk','3C' ),
 );
}
add_filter( 'user_contactmethods', 'threec_user_contactmethods' );

/**
 * Adds an additional settings section on the edit user/profile page in the admin.  This section allows users to
 * select a profession from a checkbox of terms from the profession taxonomy.  This is just one example of
 * many ways this can be handled.
 *
 * @param object $user The user object currently being edited.
 */
function threec_edit_user_fonction_section( $user ) {

	$fonct = get_taxonomy( 'fonction' );
	$form = get_taxonomy( 'formation' );
	$exp = get_taxonomy( 'niveau_experience' );



	/* Get the data. */
	$fonctions = get_terms( 'fonction', array( 'hide_empty' => false ) ); 
	$formations = get_terms( 'formation', array( 'hide_empty' => false ) ); 
	$niveau_experience = get_terms( 'niveau_experience', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'Informations Professionnelles','3C' ); ?></h3>

	<table class="form-table">

		<tr>
			<th><label for="fonction"><?php _e( 'Choisir Fonction','3C' ); ?></label></th>

			<td><?php

			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $fonctions ) AND current_user_can( $fonct->cap->assign_terms )) {
				echo '<select name="fonction">';
				echo '<option value="" >'.__( 'Aucune Fonction','3C' ).'</option>';
				foreach ( $fonctions as $fonction ) { ?>
					<option value="<?php echo esc_attr($fonction->slug ); ?>" <?php selected(esc_attr( $fonction->slug ), get_the_author_meta( 'fonction', $user->ID ) ); ?> ><?php echo $fonction->name; ?></option>
					 <label for="fonction-<?php  echo __('fonction','3C');; ?>"></label> <br />
				<?php }
				echo '</select>';
			}
			/* If there are no profession terms, display a message. */
			else {
				_e( 'Aucune fonction disponible','3C' );
			}

			?></td>
		</tr>
		<tr>
			<th><label for="formation"><?php _e( 'Choisir Formation','3C' ); ?></label></th>

			<td><?php

			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $formations ) AND current_user_can( $form->cap->assign_terms )) {
				echo '<select name="formation">';
				echo '<option value="">'.__( 'Aucune Formation','3C' ).'</option>';
				foreach ( $formations as $formation ) { ?>
					<option value="<?php echo esc_attr( $formation->slug ); ?>" <?php selected(esc_attr( $formation->slug ), get_the_author_meta( 'formation', $user->ID ) ); ?> ><?php echo $formation->name; ?></option>
					 <label for="formation-<?php echo  __('formation','3C'); ?>"></label> <br />
				<?php }
				echo '</select>';
			}
			/* If there are no profession terms, display a message. */
			else {
				_e( 'Aucune formation disponible','3C' );
			}

			?></td>
				</tr>
		<tr>	
			<th><label for="niveau_experience"><?php _e( 'Choisir experience','3C' ); ?></label></th>

			<td><?php

			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $niveau_experience ) AND current_user_can( $exp->cap->assign_terms )) {
				echo '<select name="niveau_experience">';
				echo '<option value="">'.__( 'Aucune experience','3C' ).'</option>';
				foreach ( $niveau_experience  as $niveau ) { ?>
					<option value="<?php echo esc_attr( $niveau->slug ); ?>" <?php selected(esc_attr( $niveau->slug ), get_the_author_meta( 'niveau_experience', $user->ID ) ); ?> ><?php echo $niveau->name; ?></option>
					 <label for="niveau_experience-<?php echo __('niveau_experience','3C'); ?>"></label> <br />
				<?php }
				echo '</select>';
			}
			/* If there are no profession terms, display a message. */
			else {
				_e('Aucune experience disponible','3C' );
			}

			?></td>
		</tr>
        <tr>
            <th><label for="annnee_experience_comm_corp"><?php echo  __('annnee_experience_comm_corp','3C');?></label></th>

            <td>
                <input type="text" name="annnee_experience_comm_corp" id="annnee_experience_comm_corp" value="<?php echo esc_attr( get_the_author_meta( 'annnee_experience_comm_corp', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
	</table>
	
	    <h3><?php echo  __('Information additionnel','3C');?></h3>

    <table class="form-table">

        <tr>
            <th><label for="adresse_prive"><?php echo  __('adresse_prive','3C');?></label></th>

            <td>
                <input type="text" name="adresse_prive" id="adresse_prive" value="<?php echo esc_attr( get_the_author_meta( 'adresse_prive', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
         </tr> 
        <tr>
            <th><label for="numero"><?php echo  __('numero','3C');?></label></th>

            <td>
                <input type="text" name="numero" id="adresse_prive" value="<?php echo esc_attr( get_the_author_meta( 'numero', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
         </tr> 
        <tr>
            <th><label for="code_postal"><?php echo  __('code_postal','3C');?></label></th>

            <td>
                <input type="text" name="code_postal" id="code_postal" value="<?php echo esc_attr( get_the_author_meta( 'code_postal', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
         </tr>
		<tr>   
            <th><label for="ville"><?php echo  __('ville','3C');?></label></th>

            <td>
                <input type="text" name="ville" id="ville" value="<?php echo esc_attr( get_the_author_meta( 'ville', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="telephone"><?php echo  __('telephone','3C');?></label></th>

            <td>
                <input type="text" name="telephone" id="telephone" value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
		<tr>    
            <th><label for="fax"><?php echo  __('fax','3C');?></label></th>

            <td>
                <input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'fax', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>

	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#datepicker').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:-nn",
			defaultDate: -40*365  
		});
	});
	</script>
	  
        
        <tr>
            <th><label for="date_naissance"><?php echo  __('date_naissance','3C');?></label></th>

            <td>
                <input type="text" name="date_naissance" id="datepicker" value="<?php echo esc_attr( get_the_author_meta( 'date_naissance', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
		<tr>               
            <th><label for="lang"><?php echo  __('lang','3C');?></label></th>

            <td>
                <input type="text" name="lang" id="lang" value="<?php echo esc_attr( get_the_author_meta( 'lang', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
		<tr>               

            <td>
                <a href="<?php echo get_author_posts_url($user->ID); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', '3C' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e( 'Preview profile', '3C' ); ?>
            </td>
        </tr>

    </table>

<?php }

// Save the user fields
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_user_meta( $user_id, 'code_postal', $_POST['code_postal'] );
    update_user_meta( $user_id, 'fonction', $_POST['fonction'] );
    update_user_meta( $user_id, 'formation', $_POST['formation'] );
    update_user_meta( $user_id, 'niveau_experience', $_POST['niveau_experience'] );
    update_user_meta( $user_id, 'annnee_experience_comm_corp', $_POST['annnee_experience_comm_corp'] );    
    update_user_meta( $user_id, 'ville', $_POST['ville'] );
    update_user_meta( $user_id, 'telephone', $_POST['telephone'] );
    update_user_meta( $user_id, 'fax', $_POST['fax'] );
    update_user_meta( $user_id, 'date_naissance', $_POST['date_naissance'] );
    update_user_meta( $user_id, 'lang', $_POST['lang'] );
    update_user_meta( $user_id, 'adresse_prive', $_POST['adresse_prive'] );
    update_user_meta( $user_id, 'numero', $_POST['numero'] );
}


/* Update the profession terms when the edit user page is updated. */
add_action( 'personal_options_update', 'threec_save_user_fonction_terms' );
add_action( 'edit_user_profile_update', 'threec_save_user_fonction_terms' );

/**
 * Saves the term selected on the edit user/profile page in the admin. This function is triggered when the page
 * is updated.  We just grab the posted data and use wp_set_object_terms() to save it.
 *
 * @param int $user_id The ID of the user to save the terms for.
 */
function threec_save_user_fonction_terms( $user_id ) {

	$tax = get_taxonomy( 'fonction' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$term = esc_attr( $_POST['fonction'] );

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, array( $term ), 'fonction', false);

	clean_object_term_cache( $user_id, 'fonction' );
	
	$tax = get_taxonomy( 'formation' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$term = esc_attr( $_POST['formation'] );

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, array( $term ), 'formation', false);

	clean_object_term_cache( $user_id, 'formation' );
	
	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$term = esc_attr( $_POST['niveau_experience'] );

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, array( $term ), 'niveau_experience', false);

	clean_object_term_cache( $user_id, 'niveau_experience' );

}

add_filter( 'map_meta_cap', 'my_map_meta_cap', 10, 4 );

function my_map_meta_cap( $caps, $cap, $user_id, $args ) {

	/* If editing, deleting, or reading a entreprise, get the post and post type object. */
	if ( 'edit_entreprise' == $cap || 'delete_entreprise' == $cap || 'read_entreprise' == $cap ) {
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a movie, assign the required capability. */
	if ( 'edit_entreprise' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a movie, assign the required capability. */
	elseif ( 'delete_entreprise' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private movie, assign the required capability. */
	elseif ( 'read_entreprise' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}





// New shortcodes

add_shortcode( 'access_entreprise_full', 'access_check_shortcode' );

function access_check_shortcode( $attr, $content = null ) {

	/*extract( shortcode_atts( array( 'capability' => 'access_entreprise_full' ), $attr ) );
    


	if ( current_user_can( $capability ) && !is_feed() )
		return 'true';
*/


   $current_user = wp_get_current_user();
   
   $aut=array('member-full-access-associated','member-full-access','administrator','admin_prive');
   
   $cap=array_flip($current_user->caps);
   
   if(!is_array($cap))$cap=array();
   
   if(in_array($cap[1],$aut))return true;
    
	return '';
}

//Google map

add_action('admin_menu', 'google_maps_api_menu');
function google_maps_api_menu() {
add_options_page('Google Maps API Key', 'Google Maps API Key', 'manage_options', 'your-unique-identifier', 'gma_plugin_options');
}
function gma_plugin_options() {
?>
<div>
<h2>Google Maps API</h2>
<?php
if (array_key_exists('maps_key',$_POST)) {
update_option('maps_key',$_POST['maps_key']);
}
?>
<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php
settings_fields('maps_key');
?>
<table>
<tr valign="top">
<th scope="row">Google Maps API Key</th>
<td><input type="text" name="maps_key" value="<?php echo get_option('maps_key'); ?>" /></td>
</tr>
</table>
<input type="hidden" name="page_options" value="maps_key" />
<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?
}


function make_map($address='') {
if(is_single()):

//	$address='123 Main Street Houston TX';
	$google_api_key = get_option('maps_key');
	if($address): ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo $google_api_key; ?>" type="text/javascript"></script>
	<div id="map_canvas" style="width: 500px; height: 400px"></div>
	<script type="text/javascript">
	function showAddress(address) {
		var map = new GMap2(document.getElementById("map_canvas"));
		var geocoder = new GClientGeocoder();
		geocoder.getLatLng(
			address,
			function(point) {
				if (!point) {
				alert(address + " not found");
				} else {
				map.setCenter(point, 13);
				var marker = new GMarker(point);
				map.addOverlay(marker);
				}
			}
		);
	}
	showAddress("<?php echo $address; ?>");
	</script>
	<?php endif;
	endif;
}
add_action('thesis_hook_before_post','make_map');

// iplmoad image

function bd_parse_post_variables(){
// bd_parse_post_variables function for WordPress themes by Nick Van der Vreken.
// please refer to bydust.com/using-custom-fields-in-wordpress-to-attach-images-or-files-to-your-posts/
// for further information or questions.
global $post, $post_var;

// fill in all types you'd like to list in an array, and
// the label they should get if no label is defined.
// example: each file should get label "Download" if no
// label is set for that particular file.
$types = array('image' => 'no info available',
'file' => 'Download',
'link' => 'Read more...');

// this variable will contain all custom fields
$post_var = array();
foreach(get_post_custom($post->ID) as $k => $v) $post_var[$k] = array_shift($v);

// creating the arrays
foreach($types as $type => $message){
global ${'post_'.$type.'s'}, ${'post_'.$type.'s_label'};
$i = 1;
${'post_'.$type.'s'} = array();
${'post_'.$type.'s_label'} = array();
while($post_var[$type.$i]){
echo $type.$i.' - '.${$type.$i.'_label'};
array_push(${'post_'.$type.'s'}, $post_var[$type.$i]);
array_push(${'post_'.$type.'s_label'},  $post_var[$type.$i.'_label']?htmlspecialchars($post_var[$type.$i.'_label']):$message);
$i++;
}
}
}

// thumb

if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}


add_filter('posts_where', 'title_like_posts_where', 10, 2 );

function title_like_posts_where( $where, &$wp_query ) {


    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $post_title_like ) ) . '%\'';
    }
    return $where;
}

/******************change the HOWDY *************************
 * http://184.172.186.91/~icode/change-the-howdy-wp-admin-bar
 */
add_filter('gettext', 'change_howdy', 10, 3);

function change_howdy($translated, $text, $domain) {

    if (!is_admin() || 'default' != $domain)
        return str_replace('Howdy,', '' ,  $translated);

    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome to Arrowhead Press', $translated);

    return $translated;
}

