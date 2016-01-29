<div class="wrap">
    <h1><?php _e( 'NDV WooCommerce Gateway', 'ndv_woo' ); ?></h1>

    <form action="options.php" method="post">

        <table class="form-table">
            <tbody>
            <tr class="row-dln-exchange-rate">
                <th scope="row">
                    <label for="dln_exchange_rate"><?php _e( 'Tỷ giá chuyển đổi', 'ndv_woo' ); ?></label>
                </th>
                <td>
                    <input type="text" name="dln_exchange_rate" id="dln_exchange_rate" class="regular-text" placeholder="<?php echo esc_attr( '', 'ndv_woo' ); ?>" value="" />
                    <label for="dln_chk_er"><input type="checkbox" name="dln_chk_er" id="dln_chk_er" value="on" /> <?php _e( 'Sử dụng', 'ndv_woo' ) ?></label>
                </td>
            </tr>
            </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'ndv_woo_nonce_key' ); ?>
        <?php submit_button( __( 'Cập nhật', 'ndv_woo' ), 'primary', 'submit_setting' ); ?>

    </form>
</div>