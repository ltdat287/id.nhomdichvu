<?php  
/**
 *  Template for display content of single answer 
 *  @since  DW Question Answer 1.0
 */
	global $current_user, $post, $position;
	$answer_id = get_the_ID(); 
	$question_id = get_post_meta( $answer_id, '_question', true );
	$question = get_post( $question_id );
	$answer = get_post( $answer_id );
	setup_postdata( $answer );
	$post_class = 'dwqa-answer';
	$vote = dwqa_vote_count();
?>
	<div id="answer-<?php echo $answer_id; ?>" <?php post_class(); ?>>
		<header class="dwqa-header">
			<div class="dwqa-meta">
				
				<?php if ( is_user_logged_in() ) { ?>
				<div class="dwqa-actions">
					<span class="loading"></span>
				</div>
				<?php } ?>

				<div data-post="<?php echo $answer_id; ?>" data-nonce="<?php echo wp_create_nonce( '_dwqa_update_privacy_nonce' ); ?>" data-type="answer" class="dwqa-privacy">
				<input type="hidden" name="privacy" value="<?php get_post_status(); ?>">
				<?php if ( get_post_status() != 'draft' && is_user_logged_in() && (dwqa_current_user_can( 'edit_answer' ) || $answer->post_author == $current_user->ID || $current_user->ID == $question->post_author ) ) : ?>
					<span class="dwqa-change-privacy">
						<div class="dwqa-btn-group">
							<div class="dwqa-dropdown-menu">
								<div class="dwqa-dropdown-caret">
									<span class="dwqa-caret-outer"></span>
									<span class="dwqa-caret-inner"></span>
								</div>
								<ul role="menu">
									<li title="<?php _e( 'Everyone can see', 'dwqa' ); ?>" <?php echo 'private' != get_post_status() ? 'class="current"' : ''; ?> data-privacy="publish"><a href="javascript:void( 0 );"><i class="fa fa-globe"></i> <?php _e( 'Public', 'dwqa' ); ?></a></li>
									<li title="<?php _e( 'Only Author and Administrator can see', 'dwqa' ); ?>" data-privacy="private" <?php echo 'private' == get_post_status() ? 'class="current"' : ''; ?>><a href="javascript:void( 0 );"  ><i class="fa fa-lock"></i> <?php _e( 'Private', 'dwqa' ) ?></a></li>
								</ul>
							</div>
						</div>
					</span>
				<?php elseif ( get_post_status() != 'draft' ) : ?>
					<span class="dwqa-current-privacy"><?php echo 'private' == get_post_status() ? '<i class="fa fa-lock"></i> '.__( 'Private', 'dwqa' ) : '<i class="fa fa-globe"></i> '.__( 'Public', 'dwqa' ); ?></span>
				<?php endif; ?>
				</div>

			</div>
			<div class="dwqa-author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?>
				<span class="author">
				<?php if ( ! dwqa_is_anonymous( $answer_id ) )  { the_author_posts_link(); ?>
					<?php if ( user_can( $answer->post_author, 'edit_posts' ) ) {
							echo ' <strong>&sdot;</strong> <span class="dwqa-label dwqa-staff">'.__( 'Staff','dwqa' ).'</span>';
						} ?>
					
				<?php } else {
						_e( 'Anonymous', 'dwqa' ); 
					}
				?>
				</span>
				<span class="dwqa-date">
					<strong>&sdot; </strong><a href="#answer-<?php echo $answer_id ?>" title="<?php _e( 'Link to answer','dwqa' ) ?> #<?php echo $answer_id ?>"><?php echo get_the_date(); ?></a>
				</span>

				<?php if ( get_post_status() == 'draft' ) { ?>
					<strong>&sdot; </strong> <?php _e( 'Draft', 'dwqa' ); ?>
				<?php } ?>
			</div><!-- Answer Author -->
		</header>
		<div class="dwqa-content">
			<?php if ( dwqa_is_answer_flag( $answer_id ) ) { ?>
			<p class="answer-flagged-alert alert">
				<i class="fa fa-flag"></i> 
				<?php 
					_e( 'This answer was flagged as spam.', 'dwqa' ); 
					echo ' <strong class="answer-flagged-show">' . __( 'show', 'dwqa' ) . '</strong>';
				?>
			</p>
			<?php } ?>
			<div class="dwqa-content-inner <?php echo dwqa_is_answer_flag( $answer_id ) ? 'dwqa-hide' : ''; ?>">
				<?php the_content(); ?>
			</div>
		</div>
		<?php if ( ! dwqa_is_closed( $question_id ) ) { ?>
		<div class="dwqa-comments">
			<?php comments_template(); ?>
		</div>
		<?php } ?>
	</div>