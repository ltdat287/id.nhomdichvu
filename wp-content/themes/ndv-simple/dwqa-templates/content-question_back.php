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
					echo dwqa_get_latest_action_date(); 
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

	<div class="block block-rounded">
		<div class="block-content">
			<table class="table table-borderless table-vcenter">
				<tbody>
					<tr class="active">
						<th style="width: 50px;"></th>
						<th>1. Intro</th>
						<th class="font-s12 text-right">
							<span class="text-muted">0.2 hours</span>
						</th>
					</tr>
					<tr>
						<td class="success text-center">
							<i class="fa fa-fw fa-unlock text-success"></i>
						</td>
						<td>
							<a href="frontend_elearning_lesson.php">1.1 HTML5 Intro (free preview)</a>
						</td>
						<td class="text-right">
							<em class="font-s12 text-muted">12 min</em>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>