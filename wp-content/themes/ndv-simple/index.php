<?php get_header(); ?>

<main id="main-container" class="site-main" role="main">

	<div class="bg-black-op">
		<section class="content content-full content-boxed overflow-hidden">
			<div class="push-50-t text-center">
				<h1 class="h2 text-white push-10 animated fadeInDown" data-toggle="appear"
				    data-class="animated fadeInDown"><?php wp_title( '' ); ?></h1>
			</div>
		</section>
	</div>

	<div class="bg-white">
		<section class="content content-mini content-mini-full content-boxed overflow-hidden">
			<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action('woocommerce_before_main_content');
			?>
		</section>
	</div>

	<div class="bg-gray-lighter">
		<section class="content content-boxed">
			<div class="push-50-t push-50">
				<div class="row">
					<div class="col-md-12">
						<div class="block block-rounded">
							<div class="block-content">
								<?php if ( have_posts() ) : ?>

									<?php if ( is_home() && ! is_front_page() ) : ?>
										<header>
											<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
										</header>
									<?php endif; ?>

									<?php
									// Start the loop.
									while ( have_posts() ) : the_post();

										/*
                                         * Include the Post-Format-specific template for the content.
                                         * If you want to override this in a child theme, then include a file
                                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                         */
										get_template_part( 'template-parts/content', get_post_format() );

										// End the loop.
									endwhile;

									// Previous/next page navigation.
									the_posts_pagination( array(
										'prev_text'          => __( 'Previous page', 'twentysixteen' ),
										'next_text'          => __( 'Next page', 'twentysixteen' ),
										'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
									) );

								// If no content, include the "No posts found" template.
								else :
									get_template_part( 'template-parts/content', 'none' );

								endif;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

</main>

<?php get_footer(); ?>
