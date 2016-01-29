<?php
/**
 * Related Subscriptions section beneath order details table
 *
 * @author 		Prospress
 * @category 	WooCommerce Subscriptions/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<table class="shop_table_responsive table table-vcenter">
	<tr class="active">
		<th colspan="5"><?php esc_html_e( 'Related Subscriptions', 'woocommerce-subscriptions' ); ?></th>
	</tr>
	<tr>
		<th class="order-number"><span class="nobr"><?php esc_html_e( 'Subscription', 'woocommerce-subscriptions' ); ?></span></th>
		<th class="order-date"><span class="nobr"><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></span></th>
		<th class="order-status"><span class="nobr"><?php esc_html_e( 'Next Payment', 'woocommerce-subscriptions' ); ?></span></th>
		<th class="order-total"><span class="nobr"><?php esc_html_e( 'Total', 'woocommerce-subscriptions' ); ?></span></th>
		<th class="order-actions">&nbsp;</th>
	</tr>
	<tbody>
		<?php foreach ( $subscriptions as $subscription_id => $subscription ) : ?>
			<tr class="order">
				<td class="subscription-id order-number" data-title="<?php esc_attr_e( 'ID', 'woocommerce-subscriptions' ); ?>">
					<a href="<?php echo esc_url( $subscription->get_view_order_url() ); ?>">#<?php echo esc_html( $subscription->get_order_number() ); ?></a>
				</td>
				<td class="subscription-status order-status" style="text-align:left; white-space:nowrap;" data-title="<?php esc_attr_e( 'Status', 'woocommerce-subscriptions' ); ?>">
					<?php if ( $subscription->get_status() == 'active' ) : ?>
						<span class="label label-success"><?php echo esc_html( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?></span>
					<?php else : ?>
						<span class="label label-danger"><?php echo esc_html( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?></span>
					<?php endif; ?>
				</td>
				<td class="subscription-next-payment order-date" data-title="<?php esc_attr_e( 'Next Payment', 'woocommerce-subscriptions' ); ?>">
					<?php echo esc_attr( $subscription->get_date_to_display( 'next_payment' ) ); ?>
				</td>
				<td class="subscription-total order-total">
					<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
				</td>
				<td class="subscription-actions order-actions">
					<a href="<?php echo esc_url( $subscription->get_view_order_url() ) ?>" class="button view"><?php esc_html_e( 'View', 'woocommerce-subscriptions' ); ?></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_subscription_after_related_subscriptions_table', $subscriptions, $order_id ); ?>
