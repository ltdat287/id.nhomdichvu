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

    <div class="bg-gray-lighter">
        <section class="content content-boxed">
            <div class="push-50-t push-50">
                <div class="row">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();
                        $post = get_post();
                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="block block-rounded block-link-hover2" href="<?php echo get_permalink( $post->ID ) ?>">
                                <div class="block-content block-content-full text-center bg-primary ribbon ribbon-bookmark ribbon-crystal">
                                    <div class="ribbon-box font-w600"><?php echo get_post_meta( $post->ID, 'sub_title' )[0] ?></div>
                                    <div class="item item-2x item-circle bg-crystal-op push-20-t push-20 animated fadeIn" data-toggle="appear" data-offset="50" data-class="animated fadeIn">
                                        <i class="<?php echo get_post_meta( $post->ID, 'icon' )[0] ?> text-white-op"></i>
                                    </div>
                                    <div class="text-white-op">
                                        <em><?php echo dln_format_date( $post->post_date, 'sub_title' ) ?></em>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <h4 class="push-10 text-center"><?php echo $post->post_title ?></h4>
                                    <p class="font-s12 push"><?php echo $post->post_excerpt ?></p>
                                </div>
                            </a>
                        </div>
                    <?php

                    endwhile;
                    ?>
                </div>
            </div>
        </section>
    </div>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>