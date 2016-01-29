<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.10
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'numberposts' => $order_count,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
	'post_type'   => wc_get_order_types( 'view-orders' ),
	'post_status' => array_keys( wc_get_order_statuses() )
) ) );

if ( $customer_orders ) : ?>

	<table class="shop_table_responsive table">

		<tr class="active">
			<th colspan="5"><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'Recent Orders', 'woocommerce' ) ); ?></th>
		</tr>

		<tr>
			<th class="order-number"><span class="nobr"><?php _e( 'Order', 'woocommerce' ); ?></span></th>
			<th class="order-date"><span class="nobr"><?php _e( 'Date', 'woocommerce' ); ?></span></th>
			<th class="order-status"><span class="nobr"><?php _e( 'Status', 'woocommerce' ); ?></span></th>
			<th class="order-total"><span class="nobr"><?php _e( 'Total', 'woocommerce' ); ?></span></th>
			<th class="order-actions">&nbsp;</th>
		</tr>

		<tbody><?php
			foreach ( $customer_orders as $customer_order ) {
				$order = wc_get_order( $customer_order );
				$order->populate( $customer_order );
				$item_count = $order->get_item_count();

				?><tr class="order">
					<td class="order-number" data-title="<?php esc_attr_e( 'Order Number', 'woocommerce' ); ?>">
						<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
							<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
						</a>
					</td>
					<td class="order-date" data-title="<?php esc_attr_e( 'Date', 'woocommerce' ); ?>">
						<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</td>
					<td class="order-status" data-title="<?php esc_attr_e( 'Status', 'woocommerce' ); ?>" style="text-align:left; white-space:nowrap;">
						<?php if ( $order->get_status() == 'completed' ) : ?>
						<span class="label label-success"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span>
						<?php else : ?>
						<span class="label label-danger"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span>
						<?php endif ?>
					</td>
					<td class="order-total" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
						<?php echo sprintf( _n( '%s', '%s', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); ?>
					</td>
					<td class="order-actions">
						<?php
							$actions = array();

							if ( $order->needs_payment() ) {
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay', 'woocommerce' )
								);
							}

							if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
									'name' => __( 'Cancel', 'woocommerce' )
								);
							}

							$actions['view'] = array(
								'url'  => $order->get_view_order_url(),
								'name' => __( 'View', 'woocommerce' )
							);

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							if ( $actions ) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
						?>
					</td>
				</tr><?php
			}
		?></tbody>

	</table>
<?php else: ?>
	<p class="no_subscriptions"><?php printf( esc_html__( 'Bạn hiện tại không có hóa đơn sử dụng dịch vụ nào, xin vui lòng đăng ký tại %sđây%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( home_url( 'dich-vu' ) ) . '">', '</a>' ); ?></p>
<?php endif; ?>
