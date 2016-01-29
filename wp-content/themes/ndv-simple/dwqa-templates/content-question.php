	<?php $post_id = get_the_ID(); ?>
	<article id="question-<?php echo $post_id; ?>" class="dwqa-question <?php echo dwqa_is_sticky( $post_id ) ? 'dwqa-sticky-question' : ''; ?>">
		<header class="dwqa-header">
			<?php if ( current_user_can( 'edit_posts' ) ) { ?>
				<?php if ( dwqa_is_pending( $post_id ) ) { ?>
				<span class="dwqa-label"><?php _e( 'Pending', 'dwqa' ); ?></span>
				<?php } ?>
			<?php } ?>
			&nbsp;<a class="dwqa-title" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'dwqa' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			<div class="dwqa-meta">
				<?php 
					do_action( 'dwqa_question_meta' ); 
				?>  
			</div>
		</header>
		<footer class="dwqa-footer-meta">
			<div class="dwqa-comment">
				<?php $answer_count = dwqa_question_answers_count(); ?>
				<?php if ( $answer_count > 0 ) {
				printf(
					'<strong>%d</strong> %s',
					$answer_count,
					_n( 'answer', 'answers', $answer_count, 'dwqa' )
					); ?>
				<?php } else {
					echo '<strong>0</strong> '.__( 'answer','dwqa' );
				}
				?>
			</div>
		</footer>
	</article>
