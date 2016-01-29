<?php
/**
 * Template Name: Account
 */
?>
<?php get_header(); ?>

<main id="main-container" class="site-main" role="main">

    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <div class="push-50-t text-center">
                <h1 class="h2 text-white push-10 animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown"><?php wp_title( '' ); ?></h1>
            </div>
        </section>
    </div>

    <div class="bg-gray-lighter">
        <section class="content content-boxed">
            <div class="row">
                <?php if ( ! is_user_logged_in() ) : ?>
                <div class="col-md-12">
                    <div class="block block-rounded block-bordered">
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
                <?php else : ?>
                    <div class="col-md-8">
                        <div class="block block-rounded block-bordered">
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
                    <div class="col-md-4">
                        <?php
                        dln_get_avatar();$user = wp_get_current_user(); ?>
                        <?php if ( $user->ID ) : ?>
                        <div class="block block-rounded block-bordered">
                            <div class="block-header bg-gray-lighter text-center">
                                <h3 class="block-title"><?php _e( 'Tài khoản của bạn', NDV_SPL ) ?></h3>
                            </div>
                            <div class="block-content block-content-full clearfix">
                                <div class="pull-right">
                                    <img class="img-avatar" src="<?php echo dln_get_avatar() ?>" alt="<?php echo $user->user_email ?>" />
                                </div>
                                <div class="pull-left push-10-t">
                                    <div class="font-w600 push-5"><i class="fa fa-user"></i> <?php echo $user->user_email ?></div>
                                    <div class="text-muted" data-toggle="tooltip" data-original-title="Ngày đăng ký"><i class="fa fa-calendar"></i> <?php echo dln_format_date( $user->user_registered ) ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="block block-rounded block-bordered">
                            <div class="block-header bg-gray-lighter text-center">
                                <h3 class="block-title"><?php _e( 'Bảng điều khiển', NDV_SPL ) ?></h3>
                            </div>
                            <div class="block-content">
                                <?php
                                wp_nav_menu( array(
                                    'menu' => 'account',
                                    'menu_class'     => 'nav nav-pills nav-stacked push'
                                ) );
                                ?>
                            </div>
                        </div>
                        <?php get_sidebar( 'account' ); ?>
                    </div>
                <?php endif ?>
            </div>
        </section>
    </div>

</main>


<?php get_footer(); ?>