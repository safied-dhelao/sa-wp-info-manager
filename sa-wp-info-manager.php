<?php define('PLUGIN_GITHUB_URL', 'https://github.com/safied-dhelao/sa-wp-info-manager');
/**
 * Plugin Name: Safied Info
 * Plugin URI: 
 * Description: Manage information and integration settings for Safied
 * Version: 1.0.0
 * Author: dh
 * Author URI: https://masmusika.com/
 * License: MIT License
 * License URI: https://opensource.org/licenses/MIT
 */

add_action( 'add_meta_boxes', 'dh_order_dni_info' );

function dh_order_dni_info()
{
    add_meta_box(
        'woocommerce-order-dni-info',
        __( 'Safied Info' ),
        'dh_order_meta_box_dni_info',
        'shop_order',
        'side',
        'default'
    );
}

function dh_order_meta_box_dni_info()
{
    global $post;

	$_dni = get_post_meta((int)$post->ID, '_billing_cedula', true );
	$_type = get_post_meta((int)$post->ID, '_billing_type_id', true );
	
	switch ($_type) {
    case 'C':
        echo '<b>Cédula: </b>' . ($_dni??'');
        break;
    case 'R':
        echo '<b>RUC: </b>' . ($_dni??'');
        break;
    case 'P':
        echo '<b>Pasaporte: </b>' . ($_dni??'');
        break;
    default:
        echo '<b>DNI: </b>' . ($_dni??'');
	}
	
	unset($_dni);
	unset($_type);
}

?>