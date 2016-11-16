<?php get_header() ?>

	<div id="content" class="content_default">
		<div class="padder">

		<?php do_action( 'bp_before_blog_home' ) ?>

		<div class="page" id="blog-latest">
			<?php
			//override query parameters
			global $query_string;
			query_posts( $query_string . '&posts_per_page=5000000' );
			$primeiravez=true;
			?>
			<?php if ( have_posts() ) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php
					//organizando em blocos de datas
					$post_atual_ano = get_the_date('Y');
					$post_atual_mes = get_the_date('F');
					$post_atual_dia = get_the_date('j');
					$post_atual_autor = get_the_author();

					if($primeiravez) {
						echo '<h1>Projeto: '.single_tag_title("", false).'</h1>';
						//echo '<div style="background:#EF4;">';
					}
					
					//echo '<div style="background:#EEE; margin:10px;">';
					
					if($post_atual_mes<>$post_anterior_mes) {
						//echo '</div>';
						echo '<hr />';
						echo '<h3>Mês: '.$post_atual_mes.'</h3>';
						//echo '<div style="background:#EF4;">';
					}
					
					if($post_atual_dia<>$post_anterior_dia) {
						//echo '</div>';
						echo '<hr />';
						echo '<h3>Dia: '.$post_atual_dia.'</h3>';
						//echo '<div style="background:#EF4;">';
					}
					
					/*if($post_autor_atual<>$post_anterior_autor) {
						//echo '</div>';
						echo '<hr />';
						echo '<h3>Autor: '.$post_atual_dia.'</h3>';
						//echo '<div style="background:#EF4;">';
					}
					echo $post_autor_atual;*/
					?>

					<?php do_action( 'bp_before_blog_post' ) ?>

					<div class="post" id="post-<?php the_ID(); ?>">

						<div class="author-box">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
							<p><?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></p>
						</div>

						<div class="post-content">
							<h2 class="posttitle"><?php the_time('G:i') ?> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<!--p class="date"><?php the_date('m');/*.the_time()*/ ?> <em><?php _e( 'in', 'buddypress' ) ?> <?php the_category(', ') ?> <?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></em></p-->

							<div class="entry">
								<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							</div>

							<!--p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p-->
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ) ?>
					
					<?php
					//echo '</div>';
					
					//organizando em blocos de datas
					$post_anterior_ano = get_the_date('Y');
					$post_anterior_mes = get_the_date('F');
					$post_anterior_dia = get_the_date('j');
					$post_anterior_autor = get_the_author();
					$primeiravez=false;
					?>

				<?php endwhile; ?>
				<?php 
				//echo '</div>';
				?>
				<div class="navigation">

					<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
					<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>

				</div>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

				<?php locate_template( array( 'searchform.php' ), true ) ?>

			<?php endif; ?>
		</div>
		
		<?php do_action( 'bp_after_blog_home' ) ?>
		
		
		<?php if(function_exists('pf_show_link')){echo pf_show_link();}  ?>
		
		<?php global $post; ?>
		<a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?pfstyle=wp">GERAR PDF</a>
		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>