<div id="dwqa-add-answers" class="dwqa-answer-form">
	<h3 class="dwqa-headline"><?php _e( 'Answer this Question', 'dwqa' ); ?></h3>
	<?php  
	if ( isset( $_GET['errors'] ) ) {
		echo '<p class="alert">';
		echo urldecode( esc_url( $_GET['errors'] ) ) . '<br>';
		echo '</p>';
	}
	?>
	<form action="<?php echo admin_url( 'admin-ajax.php?action=dwqa-add-answer' ); ?>" name="dwqa-answer-question-form" id="dwqa-answer-question-form" method="post">
	<?php 

	add_filter( 'tiny_mce_before_init', 'dwqa_paste_srtip_disable' );
	$editor = array( 
		'wpautop'       => false,
		'id'            => 'dwqa-answer-question-editor',
		'textarea_name' => 'answer-content',
		'rows'          => 2,
	);
	?>
	<?php dwqa_init_tinymce_editor( $editor ); ?>
	<?php do_action( 'dwqa_submit_answer_ui', get_the_ID() ); ?>
	
	<?php dwqa_load_template( 'captcha', 'form' ) ?>
		<div class="form-buttons">
			<input type="submit" name="submit-answer" id="submit-answer" value="<?php _e( 'Add answer','dwqa' ); ?>" class="dwqa-btn dwqa-btn-primary" />

			<?php if ( current_user_can( 'edit_posts' ) ) { ?>
			<input type="submit" name="submit-answer" id="save-draft-answer" value="<?php _e( 'Save draft','dwqa' ); ?>" class="dwqa-btn dwqa-btn-default" />
			<?php } ?>
		</div>
	</form>
</div>