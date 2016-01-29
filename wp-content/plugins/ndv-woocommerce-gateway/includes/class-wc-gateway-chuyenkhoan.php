<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ) {

	add_filter( 'woocommerce_payment_gateways', function ( $methods ) {
		$methods[] = 'WC_Gateway_ChuyenKhoan';

		return $methods;
	} );

	//Create class after the plugins are loaded
	add_action('plugins_loaded', 'init_gateway_chuyenkhoan');

	//Init payment gateway class
	function init_gateway_chuyenkhoan()
	{
		/**
		 * Bank Transfer Payment Gateway
		 *
		 * Provides a Bank Transfer Payment Gateway. Based on code by Mike Pepper.
		 *
		 * @class       WC_Gateway_BACS
		 * @extends     WC_Payment_Gateway
		 * @version     2.1.0
		 * @package     WooCommerce/Classes/Payment
		 * @author      WooThemes
		 */
		class WC_Gateway_ChuyenKhoan extends WC_Payment_Gateway {

			/** @var array Array of locales */
			public $locale;

			/**
			 * Constructor for the gateway.
			 */
			public function __construct() {

				$this->id                 = 'chuyenkhoan';
				$this->icon               = apply_filters('woocommerce_chuyenkhoan_icon', '');
				$this->has_fields         = false;
				$this->method_title       = __( 'Chuyển Khoản', 'woocommerce' );
				$this->method_description = __( 'Allows payments by BACS, more commonly known as direct bank/wire transfer.', 'woocommerce' );

				// Load the settings.
				$this->init_form_fields();
				$this->init_settings();

				// Define user set variables
				$this->title        = $this->get_option( 'title' );
				$this->description  = $this->get_option( 'description' );
				$this->instructions = $this->get_option( 'instructions', $this->description );

				// BACS account fields shown on the thanks page and in emails
				$this->account_details = get_option( 'woocommerce_chuyenkhoan_accounts',
					array(
						array(
							'account_name'   => $this->get_option( 'account_name' ),
							'account_number' => $this->get_option( 'account_number' ),
							'bank_name'      => $this->get_option( 'bank_name' ),
							'branch'         => $this->get_option( 'branch' ),
							'city'           => $this->get_option( 'city' ),
							'thumbnail'      => $this->get_option( 'thumbnail' )
						)
					)
				);

				// Actions
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'save_account_details' ) );
				add_action( 'woocommerce_thankyou_chuyenkhoan', array( $this, 'thankyou_page' ) );

				// Customer Emails
				add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );

			}

			/**
			 * Initialise Gateway Settings Form Fields
			 */
			public function init_form_fields() {

				$this->form_fields = array(
					'enabled' => array(
						'title'   => __( 'Enable/Disable', 'woocommerce' ),
						'type'    => 'checkbox',
						'label'   => __( 'Enable Bank Transfer', 'woocommerce' ),
						'default' => 'no'
					),
					'title' => array(
						'title'       => __( 'Title', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
						'default'     => __( 'Direct Bank Transfer', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'description' => array(
						'title'       => __( 'Description', 'woocommerce' ),
						'type'        => 'textarea',
						'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
						'default'     => __( 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won\'t be shipped until the funds have cleared in our account.', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'instructions' => array(
						'title'       => __( 'Instructions', 'woocommerce' ),
						'type'        => 'textarea',
						'description' => __( 'Instructions that will be added to the thank you page and emails.', 'woocommerce' ),
						'default'     => '',
						'desc_tip'    => true,
					),
					'account_details' => array(
						'type'        => 'account_details'
					),
				);

			}

			/**
			 * generate_account_details_html function.
			 */
			public function generate_account_details_html() {

				ob_start();

				?>
				<tr valign="top">
					<th scope="row" class="titledesc"><?php _e( 'Account Details', 'woocommerce' ); ?>:</th>
					<td class="forminp" id="chuyenkhoan_accounts">
						<table class="widefat wc_input_table sortable" cellspacing="0">
							<thead>
							<tr>
								<th class="sort">&nbsp;</th>
								<th><?php _e( 'Account Name', 'woocommerce' ); ?></th>
								<th><?php _e( 'Account Number', 'woocommerce' ); ?></th>
								<th><?php _e( 'Bank Name', 'woocommerce' ); ?></th>
								<th><?php _e( 'Chi Nhánh', 'woocommerce' ); ?></th>
								<th><?php _e( 'Tỉnh/Thành phố', 'woocommerce' ); ?></th>
								<th><?php _e( 'Thumbnail', NDV_WOO ); ?></th>
							</tr>
							</thead>
							<tbody class="accounts">
							<?php
							$i = -1;
							if ( $this->account_details ) {
								foreach ( $this->account_details as $account ) {
									$i++;

									echo '<tr class="account">
									<td class="sort"></td>
									<td><input type="text" value="' . esc_attr( wp_unslash( $account['account_name'] ) ) . '" name="chuyenkhoan_account_name[' . $i . ']" /></td>
									<td><input type="text" value="' . esc_attr( $account['account_number'] ) . '" name="chuyenkhoan_account_number[' . $i . ']" /></td>
									<td><input type="text" value="' . esc_attr( wp_unslash( $account['bank_name'] ) ) . '" name="chuyenkhoan_bank_name[' . $i . ']" /></td>
									<td><input type="text" value="' . esc_attr( $account['branch'] ) . '" name="chuyenkhoan_branch[' . $i . ']" /></td>
									<td><input type="text" value="' . esc_attr( $account['city'] ) . '" name="chuyenkhoan_city[' . $i . ']" /></td>
									<td><input type="text" value="' . esc_attr( $account['thumbnail'] ) . '" name="chuyenkhoan_thumnail[' . $i . ']" /></td>
								</tr>';
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<th colspan="7"><a href="#" class="add button"><?php _e( '+ Add Account', 'woocommerce' ); ?></a> <a href="#" class="remove_rows button"><?php _e( 'Remove selected account(s)', 'woocommerce' ); ?></a></th>
							</tr>
							</tfoot>
						</table>
						<script type="text/javascript">
							jQuery(function() {
								jQuery('#chuyenkhoan_accounts').on( 'click', 'a.add', function(){

									var size = jQuery('#chuyenkhoan_accounts').find('tbody .account').size();

									jQuery('<tr class="account">\
									<td class="sort"></td>\
									<td><input type="text" name="chuyenkhoan_account_name[' + size + ']" /></td>\
									<td><input type="text" name="chuyenkhoan_account_number[' + size + ']" /></td>\
									<td><input type="text" name="chuyenkhoan_bank_name[' + size + ']" /></td>\
									<td><input type="text" name="chuyenkhoan_branch[' + size + ']" /></td>\
									<td><input type="text" name="chuyenkhoan_city[' + size + ']" /></td>\
									<td><input type="text" name="chuyenkhoan_thumnail[' + size + ']" /></td>\
								</tr>').appendTo('#chuyenkhoan_accounts table tbody');

									return false;
								});
							});
						</script>
					</td>
				</tr>
				<?php
				return ob_get_clean();

			}

			/**
			 * Save account details table
			 */
			public function save_account_details() {

				$accounts = array();

				if ( isset( $_POST['chuyenkhoan_account_name'] ) ) {

					$chuyenkhoan_account_names   = array_map( 'wc_clean', $_POST['chuyenkhoan_account_name'] );
					$chuyenkhoan_account_numbers = array_map( 'wc_clean', $_POST['chuyenkhoan_account_number'] );
					$chuyenkhoan_bank_names      = array_map( 'wc_clean', $_POST['chuyenkhoan_bank_name'] );
					$chuyenkhoan_branchs         = array_map( 'wc_clean', $_POST['chuyenkhoan_branch'] );
					$chuyenkhoan_citys           = array_map( 'wc_clean', $_POST['chuyenkhoan_city'] );
					$chuyenkhoan_thumnails       = array_map( 'wc_clean', $_POST['chuyenkhoan_thumnail'] );

					foreach ( $chuyenkhoan_account_names as $i => $name ) {
						if ( ! isset( $chuyenkhoan_account_names[ $i ] ) ) {
							continue;
						}

						$accounts[] = array(
							'account_name'   => $chuyenkhoan_account_names[ $i ],
							'account_number' => $chuyenkhoan_account_numbers[ $i ],
							'bank_name'      => $chuyenkhoan_bank_names[ $i ],
							'branch'         => $chuyenkhoan_branchs[ $i ],
							'city'           => $chuyenkhoan_citys[ $i ],
							'thumbnail'      => $chuyenkhoan_thumnails[ $i ]
						);
					}
				}

				update_option( 'woocommerce_chuyenkhoan_accounts', $accounts );

			}

			/**
			 * Output for the order received page.
			 */
			public function thankyou_page( $order_id ) {

				if ( $this->instructions ) {
					echo wpautop( wptexturize( wp_kses_post( $this->instructions ) ) );
				}
				$this->bank_details( $order_id );

			}

			/**
			 * Add content to the WC emails.
			 *
			 * @param WC_Order $order
			 * @param bool $sent_to_admin
			 * @param bool $plain_text
			 */
			public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {

				if ( ! $sent_to_admin && 'chuyenkhoan' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
					if ( $this->instructions ) {
						echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
					}
					$this->bank_details( $order->id );
				}

			}

			/**
			 * Get bank details and place into a list format
			 */
			private function bank_details( $order_id = '' ) {

				if ( empty( $this->account_details ) ) {
					return;
				}

				// Get order and store in $order
				$order 		= wc_get_order( $order_id );

				$chuyenkhoan_accounts = apply_filters( 'woocommerce_chuyenkhoan_accounts', $this->account_details );

				if ( ! empty( $chuyenkhoan_accounts ) ) {
					echo '<h2 class="h3 font-w600 push-20">' . __( 'Our Bank Details', 'woocommerce' ) . '</h2>' . PHP_EOL;

					foreach ( $chuyenkhoan_accounts as $account ) {

						$account = (object) $account;

						if ( $account->account_name || $account->bank_name ) {
							echo '<h3 class="h4">' . wp_unslash( $account->bank_name ) . '</h3>' . PHP_EOL;
						}

						echo '<ul class="order_details chuyenkhoan_details">' . PHP_EOL;

						// BACS account fields shown on the thanks page and in emails
						$account_fields = apply_filters( 'woocommerce_chuyenkhoan_account_fields', array(
							'thumbnail' => array(
								'value' => '<img src="' . $account->thumbnail . '" alt="' . $account->bank_name . '" />'
							),
							'account_name'=> array(
								'label' => __( 'Account Name', 'woocommerce' ),
								'value' => $account->account_name
							),
							'account_number'=> array(
								'label' => __( 'Account Number', 'woocommerce' ),
								'value' => $account->account_number
							),
							'branch'        => array(
								'label' => __( 'Chi nhánh', 'woocommerce' ),
								'value' => $account->branch
							),
							'city'     => array(
								'label' => __( 'Tỉnh/Thành phố', 'woocommerce' ),
								'value' => $account->city
							),
							'message' => array(
								'label' => __( 'Nội dung', NDV_WOO ),
								'value' => sprintf( __( 'NDV %s', NDV_WOO ), $order_id )
							)
						), $order_id );

						foreach ( $account_fields as $field_key => $field ) {
							if ( ! empty( $field['value'] ) && $field_key != 'thumbnail' ) {
								echo '<li class="push-10 ' . esc_attr( $field_key ) . '">' . esc_attr( $field['label'] ) . ': <strong>' . wptexturize( $field['value'] ) . '</strong></li>' . PHP_EOL;
							} else if ( $field_key == 'thumbnail' ) {
								echo '<li class="push-10">' . $field['value'] . '</li>' . PHP_EOL;
							}
						}

						echo '</ul>';
					}
				}

			}

			/**
			 * Process the payment and return the result
			 *
			 * @param int $order_id
			 * @return array
			 */
			public function process_payment( $order_id ) {

				$order = wc_get_order( $order_id );

				// Mark as on-hold (we're awaiting the payment)
				$order->update_status( 'on-hold', __( 'Awaiting BACS payment', 'woocommerce' ) );

				// Reduce stock levels
				$order->reduce_order_stock();

				// Remove cart
				WC()->cart->empty_cart();

				// Return thankyou redirect
				return array(
					'result'    => 'success',
					'redirect'  => $this->get_return_url( $order )
				);

			}
		}
	}

	add_filter( 'woocommerce_get_order_item_totals', function ( $total_rows, $order ) {

		if ( isset( $total_rows['payment_method'] ) && $order->payment_method === 'chuyenkhoan' ) {
			$total_rows['payment_method']['value'] = '<a href="' . $order->get_checkout_order_received_url() . '">' . $total_rows['payment_method']['value'] . '</a>';
		}

		return $total_rows;

	}, 10, 2 );

}
