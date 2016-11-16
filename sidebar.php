<?php do_action( 'bp_before_sidebar' ) ?>

<div id="sidebar" role="complementary">

	<div class="padder">

	<?php do_action( 'bp_inside_before_sidebar' ) ?>

	<?php if ( is_user_logged_in() ) : ?>

		<?php do_action( 'bp_before_sidebar_me' ) ?>

		<div id="sidebar-me">
			<a href="<?php echo bp_loggedin_user_domain() ?>">
				<?php bp_loggedin_user_avatar( 'type=thumb&width=40&height=40' ) ?>
			</a>

			<h4><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></h4>
			<a class="button logout" href="<?php echo wp_logout_url( bp_get_root_domain() ) ?>"><?php _e( 'Log Out', 'buddypress' ) ?></a>

			<?php do_action( 'bp_sidebar_me' ) ?>
		</div>

		<?php do_action( 'bp_after_sidebar_me' ) ?>

		<?php if ( bp_is_active( 'messages' ) ) : ?>
			<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
		<?php endif; ?>
		
		
		<?php the_widget('WP_Widget_Calendar', 'title=Calendario'); ?>
		
		<h2 class="widgettitle">Projetos</h2>
		<?php #ctc(); ?>
		
		<?php /*the_widget('WP_Widget_Pages', 'title=Contents');*/ ?>
		
		<?php the_widget( 'WP_Widget_Recent_Posts', 'title=Ultimos ciclos' ); ?> 
		
		<?php do_shortcode('[bc_member name="imath" size="100" fields="About me,Website,Twitter Name"]'); ?>
		
		<?php dynamic_sidebar( 'painel' ); ?>
		
	<?php else : ?>

		<?php do_action( 'bp_before_sidebar_login_form' ) ?>

		<?php if ( bp_get_signup_allowed() ) : ?>
		
			<p id="login-text">

				<?php printf( __( 'Please <a href="%s" title="Create an account">create an account</a> to get started.', 'buddypress' ), site_url( bp_get_signup_slug() . '/' ) ) ?>

			</p>

		<?php endif; ?>

		<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo site_url( 'wp-login.php?', 'login_post' ) ?>" method="post">
			<label><?php _e( 'Username', 'buddypress' ) ?><br />
			<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php _e( 'Password', 'buddypress' ) ?><br />
			<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

			<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'buddypress' ) ?></label><a href="http://pomodoros.com.br/wp-admin" title="Recuperar a senha">Esqueci a senha</a></p>

			<?php do_action( 'bp_sidebar_login_form' ) ?>
			<input type="submit" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Log In', 'buddypress' ); ?>" tabindex="100" /><a href="http://pomodoros.com.br/register/" title="Registre-se para entrar na rede"><input type="button" name="wp-submit" id="sidebar-wp-submit" value="Registre-se" tabindex="100" /></a>
			<input type="hidden" name="testcookie" value="1" />
		</form>

		<?php do_action( 'bp_after_sidebar_login_form' ) ?>

	<?php endif; ?>

	<?php /* Show forum tags on the forums directory */
	if ( bp_is_active( 'forums' ) && bp_is_forums_component() && bp_is_directory() ) : ?>
		<div id="forum-directory-tags" class="widget tags">
			<h3 class="widgettitle"><?php _e( 'Forum Topic Tags', 'buddypress' ) ?></h3>
			<div id="tag-text"><?php bp_forums_tag_heat_map(); ?></div>
		</div>
	<?php endif; ?>

	<?php dynamic_sidebar( 'sidebar-1' ) ?>

	
	<?php do_action( 'bp_inside_after_sidebar' ) ?>	
	
	<!-- LAST POMOS -->
	<?php if (function_exists('qtrans_generateLanguageSelectCode')){?>
		<p>Linguagem</p>
		<?php echo qtrans_generateLanguageSelectCode('both'); ?>
		<?php the_widget('WP_Widget_Calendar'); ?> 
		<?php the_widget('WP_Widget_Categories','title=Categorias', 'before_title=<h3>&after_title=</h3>'); ?> 
		<?php the_widget('WP_Widget_Tag_Cloud'); ?> 
	<?php } ?>
	
	<?php /*
	<?php do_shortcode('[bc_member name="imath" size="100" fields="About me,Website,Twitter Name"]'); ?>
	<div class="widget">
	<h3 class="widgettitle"><script>document.write(txt_last_pomodoros_of_community )</script></h3>
	<?php
	$pomodoros_completed2 = $wpdb->get_results('SELECT * FROM  `wp_usermeta` WHERE `meta_key` =  "pomodoro_completed" ORDER BY umeta_id DESC LIMIT 8');
	
	echo "<ul>";
	foreach ($pomodoros_completed2 as $key) {
		//The pomodoro has 2 information, data and description separated by "|"
		list($data, $desc) = explode("|", $key->meta_value);
		//Is necessary to separate the day and the hour manage information
		list($year_month_day, $hour) = explode(" ", $data);
		
		echo "<li><strong>".$hour."</strong></br>".$desc."</li>";
	}
	echo "</ul>";
	?>
	</div>
	<!-- LAST POMOS -->
	
	<!-- TOTAL POMOS -->
	<div class="widget">
	<h3 class="widgettitle"><script>document.write(txt_total_pomodoros_of_community)</script></h3>
	<?php
	$total_pomodoros = $wpdb->get_results('SELECT * FROM  `wp_usermeta` WHERE `meta_key` =  "pomodoro_completed"');
	echo count($total_pomodoros);
	echo "<ul>";
	*foreach ($pomodoros_completed2 as $key) {
		//The pomodoro has 2 information, data and description separated by "|"
		list($data, $desc) = explode("|", $key->meta_value);
		//Is necessary to separate the day and the hour manage information
		list($year_month_day, $hour) = explode(" ", $data);
		
		echo "<li><strong>".$hour."</strong></br>".$desc."</li>";
	}/
	echo "</ul>";
	?>
	</div>
	*/ ?>
	<!-- LAST POMOS -->
	
	
	</div><!-- .padder -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ) ?>
