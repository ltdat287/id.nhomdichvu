<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

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

    <section class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-content">
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();
                            ?>
                            <h3 class="push"><?php the_title() ?></h3>
                            <?php
                            the_content();

                            // End of the loop.
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>