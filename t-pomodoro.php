<?php
/*Template Name: Pomodoro Painel*/

/*Language files are loaded on header*/
?>
<?php get_header() ?>

<!--MooTools-->
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/mootools-1.2.js" type="text/javascript"></script>
<!--jQuery-->
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/jquery-1.6.1.min.js" type="text/javascript"></script>
<!--Sound System-->
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/soundmanager2-nodebug-jsmin.js" type="text/javascript"></script>
<!--Pomodoros-->
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/pomodoro-functions.js" type="text/javascript"></script>
<!--Tips-->
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/tips.js" type="text/javascript"></script>

	<!--Template-->
	<?php get_sidebar() ?>
	<?php if (is_user_logged_in()) {
		locate_template( array( 's-pomodoros.php' ), true );
	} ?>
	
	<div class="content_pomodoro">
		<?php if ( is_user_logged_in() ) {
			//user is logged in
			locate_template( array( 'pomodoros-painel.php' ), true );
		} else { ?>
			<?php
			$my_id = 62;
			
			$post_id = get_post($my_id); 
			$title = $post_id->post_title;
			$content = $post_id->post_content;
			_e("<h1>".$title."</h1>");
			_e($content);
			?> 
		<?php }?>
	</div><!-- #content -->

	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
	
	
	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
<?php get_footer() ?>