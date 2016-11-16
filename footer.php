		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ) ?>

		<div class="clear"></div>

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer">
			<div id="footer-contact-form">
				    <?php echo do_shortcode( '[contact-form-7 id="60" title="footer"]' ); ?>
				</div>
			<div id="footer-info">
			    <?php /*
			    <p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>
			    */ ?>
			</div>
		<?php do_action( 'bp_footer' ) ?>
		</div>

		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>

	</body>

</html>