<?php
/**
 * Template Name: Homepage
 */
?>
<?php get_header(); ?>

<main id="main-container" class="site-main" role="main">

    <div class="bg-image" style="/*background-image: url('assets/img/various/hero1.jpg');*/">
        <div class="bg-primary-dark-op">
            <section class="content content-full content-boxed overflow-hidden">
                <div class="push-100-t push-50 text-center">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        the_content();

                    endwhile;
                    ?>
                </div>
                <div class="row animated fadeInUp" data-toggle="appear" data-class="animated fadeInUp">
                    <div class="col-sm-8 col-sm-offset-2">
<!--                        <img class="img-responsive pull-b" src="assets/img/various/promo1.jpg" alt="">-->
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="bg-white">
        <section class="content content-boxed">
            <div class="row items-push-3x push-50-t nice-copy">
                <div class="col-sm-4">
                    <div class="text-center push-30">
                        <span class="item item-2x item-circle border">
                        <i class="si si-book-open"></i>
                        </span>
                    </div>
                    <h3 class="h5 font-w600 text-uppercase text-center push-10"><?php _e( 'Quản lý dễ dàng', NDV_SPL ) ?></h3>

                    <p><?php _e( 'Dịch vụ của chúng tôi sẽ giúp các bạn có thể quản lý tại một nơi và bạn có thể nắm bắt mọi thông tin một cách nhanh nhất, dễ dàng nhất.', NDV_SPL ) ?></p>
                </div>
                <div class="col-sm-4">
                    <div class="text-center push">
                        <span class="item item-2x item-circle border">
                        <i class="si si si-screen-smartphone"></i>
                        </span>
                    </div>
                    <h3 class="h5 font-w600 text-uppercase text-center push-10"><?php _e( 'Đa nền tảng', NDV_SPL ) ?></h3>

                    <p><?php _e( 'Bạn có thể truy cập dịch vụ của chúng tôi tại bất cứ nơi đâu, bất cứ thiết bị nào mà không cảm thấy khó khăn khi thao tác.', NDV_SPL ) ?></p>
                </div>
                <div class="col-sm-4">
                    <div class="text-center push">
                        <span class="item item-2x item-circle border">
                        <i class="si si-speedometer"></i>
                        </span>
                    </div>
                    <h3 class="h5 font-w600 text-uppercase text-center push-10"><?php _e( 'Đo lường', NDV_SPL ) ?></h3>

                    <p><?php _e( 'Dịch vụ của chúng tôi sẽ cung cấp các giải pháp tốt nhất, giúp bạn đo lường được các sản phẩm của chính mình.', NDV_SPL ) ?></p>
                </div>
            </div>
        </section>
    </div>

    <div class="bg-gray-lighter">
        <section class="content content-boxed">
            <div class="row items-push push-20-t push-20 text-center">
                <div class="col-sm-6">
                    <?php
                    // Count users.
                    $count = count_users();
                    $count = isset( $count['total_users'] ) ? $count['total_users'] : 0;
                    $count = ceil( $count / 10 ) * 10;
                    ?>
                    <div class="h1 push-5" data-toggle="countTo" data-to="<?php echo $count ?>" data-after="+"><?php echo $count ?>+</div>
                    <div class="font-w600 text-uppercase text-muted"><?php _e( 'Khách hàng', NDV_SPL ) ?></div>
                </div>
                <div class="col-sm-6">
                    <?php
                    // Count orders.
                    $status = 'wc-completed';
                    $count = wp_count_posts( 'shop_order' )->$status;
                    $count = ceil( $count / 10 ) * 10;
                    ?>
                    <div class="h1 push-5" data-toggle="countTo" data-to="<?php echo $count ?>" data-after="+"><?php echo $count ?>+</div>
                    <div class="font-w600 text-uppercase text-muted"><?php _e( 'Đơn hàng', NDV_SPL ) ?></div>
                </div>
            </div>
        </section>
    </div>

</main>


<?php get_footer(); ?>