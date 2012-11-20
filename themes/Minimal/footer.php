	 <div id="footer" >
		<div id="footer-content">
			
				<?php global $is_footer;
				$is_footer = true; ?>
				
				<?php $menuClass = 'bottom-menu';
				$footerNav = '';
				
				if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false, 'depth' => '1' ) );
				if ($footerNav == '') show_page_menu($menuClass);
				else echo($footerNav); ?>
			
			<p id="copyright"><?php _e('Designed by ','Minimal'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant WordPress Themes</a></p>
		</div> <!-- end #footer-content -->
	</div> <!-- end #footer -->
</div> <!-- end #page-wrap -->
	 
				
	<?php include(TEMPLATEPATH . '/includes/scripts.php'); ?>

	<?php wp_footer(); ?>	
</body>
</html>