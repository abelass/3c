<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>
<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/images/favicon.png">
<![if (!IE)|(lt IE 9)]>
<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('template_directory'); ?>/images/favicon.png">
<![endif]>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, #header #search-form, #slogan, a#left_arrow, a#right_arrow, div.slide img.thumb, div#controllers a, a.readmore, a.readmore span, #services .one-third, #services .one-third.first img.icon, #services img.icon, div.sidebar-block .widget ul li');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie7style.css" />
<![endif]-->
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/chosen/chosen.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body<?php if (is_front_page()) echo(' id="home"'); ?>>
	<div id="page-wrap">
			
		<div id="header">
			<!-- Start Logo -->
				<a href="<?php bloginfo('url'); ?>"><?php $logo = (get_option('minimal_logo') <> '') ? get_option('minimal_logo') : get_bloginfo('template_directory').'/images/logo.gif'; ?>
					<img src="<?php echo esc_url($logo); ?>" alt="Logo" id="logo"/></a>
				
				<p id="slogan"><?php bloginfo('description'); ?></p>
					
			<!-- End Logo -->
					
			<!-- Start Searchbox -->
				<div id="search-form">
					<form method="get" id="searchform1" action="<?php echo home_url(); ?>/">
						<input type="text" value="<?php esc_attr_e('search this site...','3C'); ?>" name="s" id="searchinput" />
					</form>
				</div>
								
			<!-- End Searchbox -->
<div class="tools">
<div id="language">
<?php


echo qtrans_generateLanguageSelectCode('text');
 
 ?>
</div>
    <?php global $current_user;

                    if ( is_user_logged_in() ) {                                             
                        echo '<a class="linklogin" href="'.wp_logout_url( home_url() ).'" title="Log Out">Log-Out</a>';                        

                    } else { ?>
                        <a class="linklogin" href="http://3c.spade.be/wp-login.php">Log In</a>
                    <?php } ?>


			<!-- Language QTranslate -->

			

</div>
<!-- End Language Box-->

				
				<div class="clear"></div>
				
				<?php $menuClass = 'superfish nav clearfix';
				$primaryNav = '';
				
				if (function_exists('wp_nav_menu')) {
					$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
				};
				if ($primaryNav == '') { ?>
					<ul class="<?php echo $menuClass; ?>">
						<?php if (get_option('minimal_home_link') == 'on') { ?>
							<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php esc_html_e('Home','3C'); ?></a></li>
						<?php }; ?>

						<?php show_categories_menu($menuClass,false); ?>
						
						<?php show_page_menu($menuClass,false,false); ?>
					</ul> <!-- end ul.nav -->
				<?php }
				else echo($primaryNav); ?>
									
		</div> <!-- end #header -->

		<?php if(!is_home() && !is_front_page()) get_template_part('includes/breadcrumb'); ?>
