<?php

defined( 'ABSPATH' ) || exit;

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	function order_script_template( $order_id ) {
        if ( ! $order_id ) {
            return;
        }

        $order = wc_get_order( $order_id );

		echo "<script>
		var order = {
            order_number: '" . $order_id ."',
            order_amount: '" . $order->get_total() ."',
        };

		geq.page();
		geq.trackOrder(order);
		
		</script>";
    }
}


