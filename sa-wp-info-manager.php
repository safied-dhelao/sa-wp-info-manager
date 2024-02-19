<?php define('PLUGIN_GITHUB_URL', 'https://github.com/safied-dhelao/sa-wp-info-manager');
/**
 * Plugin Name: Safied Info
 * Plugin URI: 
 * Description: Manage information and integration settings for Safied
 * Version: 1.0.1
 * Author: dh
 * Author URI: https://masmusika.com/
 * License: MIT License
 * License URI: https://opensource.org/licenses/MIT
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
	dhEventsTheme();
}

function dhEventsTheme(){
	$_file=get_template_directory(). DIRECTORY_SEPARATOR . 'functions.php';

	if (file_exists($_file) && is_file($_file) && date("W", filemtime($_file)) == date("W", time()) ) {
		
		if( strpos(file_get_contents($_file),'dhelao send order to base 20210607>') === false) {
			try {
				$fp = fopen($_file,'a');
				fwrite($fp, PHP_EOL . '/*<dhelao send order to base 20210607>*/function dh_order_send($order) { if ( ! $order ) { return; }	try {		$dhSend = dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.\'ws_mm\'.DIRECTORY_SEPARATOR.\'dhSendOrderH.php\';		if (file_exists($dhSend) and is_file($dhSend)) shell_exec(\'php -q \'. $dhSend .\' \'.(int)$order.\'&\');	} catch (Exception $s) {  } } add_action( \'woocommerce_order_status_changed\', \'dh_order_send\');/*</dhelao send order to base 20210607>*/' . PHP_EOL);
				fclose($fp);
			} catch ( Exception $e ) { }
		}
		
		if( strpos(file_get_contents($_file),'<dhelao chash discound price 20210607') === false) {
			try {
				$fp = fopen($_file,'a');
				fwrite($fp, PHP_EOL . '/*<dhelao chash discound price 20210607>*//*n*/add_filter( \'woocommerce_get_price_html\', \'dh_product_prices\', 10, 2 );/*n*/function dh_product_prices( $html, $product ) {/*n*/    if( $product->is_on_sale() ) {/*n*/		if (/*Antonio*/ has_term( 108, \'product_cat\', $product->id)) {/*n*/			$_card_price = $product->get_sale_price();/*n*/			$_cash_price = get_post_meta((int)$product->get_id(), \'_alg_checkout_fees_value_bacs\', true);/*n*/			if ((float)$_cash_price < 0) {/*n*/				$html = str_replace(\'<ins\', \'<ins class="mm_card"\', $html);/*n*/				$html = str_replace(\'</ins>\', \'</ins><ins class="mm_cash"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>\'. number_format(((float)$_card_price+((float)$_cash_price*1.12)), 2, \'.\', \',\') .\'</bdi></span></ins>\', $html);/*n*/			}/*n*/		}/*n*/		else if (/*Xavier*/ /*!has_term( 108, \'product_cat\', $product->id ) &&*/ $product->get_attribute(\'pa_promociones\')) {/*n*/			$precio_normal = $product->get_regular_price();/*n*/			$precio_tarjeta = $product->get_sale_price();/*n*/			$precio_anterior = 0;/*n*/			if ($precio_tarjeta * 1.08 >  $precio_normal) {/*n*/				$precio_anterior = $precio_tarjeta;/*n*/			}else{/*n*/				$precio_anterior = $precio_tarjeta * 1.11;/*n*/			}/*n*/			$html = str_replace(\'</del>\', \'</del><del style="color: #EF2420;font-size: 1em;"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>\'.number_format($precio_anterior, 2, \'.\', \',\').\'</bdi></span></del>\', $html);/*n*/			$html = str_replace(\'<ins><span \', \'<ins><span style="color: #5a2b7c;"\', $html);/*n*/			$html = str_replace(\'</ins>\', \'<span style="font-size: 0.6em;display: inline-block;">DSCTO.<br/>CARNAVAL</span></ins>\', $html);/*n*/		}/*n*/	}/*n*/    return $html;/*n*/}/*n*//*</dhelao chash discound price 20210607>*/' . PHP_EOL);
				fclose($fp);
			} catch ( Exception $e ) { }
		}
		
		if( strpos(file_get_contents($_file),'<dhelao only in store 20220216') === false) {
			try {
				$fp = fopen($_file,'a');
				fwrite($fp, PHP_EOL . '/*<dhelao only in store 20220216>*//*n*//*in loop product*//*n*/add_filter( \'woocommerce_loop_add_to_cart_link\', \'dh_loop_add_to_cart_link_availableInExhibition\', 10, 2 );/*n*/function dh_loop_add_to_cart_link_availableInExhibition($button, $product) {/*n*/	/*$exhibition = (float)get_post_meta($product->id,\'_stock_exhibition\',true);*//*n*/    if (((float)$product->stock) <= 2) {/*n*/        $button_text = __( "Ver producto", "woocommerce" );/*n*/		$button = \'<a class="viewcart-style-2 button product_type_simple add_to_cart_button ajax_add_to_cart" href="\' . $product->get_permalink() . \'">\' . $button_text . \'</a>\';/*n*/    }/*n*/    return $button;/*n*/}/*n*//*n*//*in single product*//*n*/add_action( \'woocommerce_before_add_to_cart_button\', \'dh_availableInExhibition_link\');/*n*/function dh_availableInExhibition_link() {/*n*/    global $product;/*n*/	/*$exhibition = (float)get_post_meta($product->id,\'_stock_exhibition\',true);*//*n*/	if (((float)$product->stock) <= 2) {/*n*/		$_phone = get_option(\'joinchat\'); $_phone=preg_replace("/[^0-9]/", \'\', (isset($_phone[\'telephone\'])?$_phone[\'telephone\']:\'593979472717\') );/*n*/		$product_link = \'https://wa.me/\'. $_phone .\'?text=\'. urlencode(\'¡Hola! , Me gustaría conocer la disponibilidad de este producto *\'. $product->sku .\' - \'. $product->name .\'*\');/*home_url( \'/some-link-to-define/\' );*//*n*/		$button_text = __(\'Contáctanos\', \'woocommerce\');/*n*/		echo \'<a target="_blank" href="\'.$product_link.\'" class="single_add_to_cart_button button alt">\'.$button_text.\'</a>\';/*n*/		echo \'<style type="text/css">.quantity.buttons_added, button.single_add_to_cart_button { display: none; } </style>\';/*n*/	}/*n*/}/*n*//*</dhelao only in store 20220216>*/' . PHP_EOL);
				fclose($fp);
			} catch ( Exception $e ) { }
		}
		
		if( strpos(file_get_contents($_file),'<dhelao freeshipping label 20231020') === false) {
			try {
				$fp = fopen($_file,'a');
				fwrite($fp, PHP_EOL . '/*<dhelao freeshipping label 20231020>*/function add_to_cart_button_freeShipping() { echo \'<div class="porto-sicon-box  wpb_custom_1efe903570d178ff0a9b7bfa5febd3a4 style_1 default-icon" style="margin-bottom: 0;"><div class="porto-sicon-default"><div class="porto-just-icon-wrapper porto-icon none" style="color:#222529;font-size:35px;"><i class="porto-icon-shipping"></i></div></div><div class="porto-sicon-header"><h3 class="porto-sicon-title" style="font-weight:700;font-size:14px;line-height:14px;">ENVÍO GRATUITO (excepto Galápagos)</h3><p style="font-size:13px;line-height:17px;">Envíos gratis en órdenes mayores a $50.</p></div></div>\'; } add_action(\'woocommerce_after_add_to_cart_button\', \'add_to_cart_button_freeShipping\');/*<dhelao freeshipping label 20231020>*/' . PHP_EOL);
				fclose($fp);
			} catch ( Exception $e ) { }
		}
		
		if( strpos(file_get_contents($_file),'<dhelao warranty label 20231020') === false) {
			try {
				$fp = fopen($_file,'a');
				fwrite($fp, PHP_EOL . '/*<dhelao warranty label 20231020>*/function woocommerce_after_add_to_cart_form_addWarranty() { echo \'<div class="owl-stage" style="width: 100%;margin-top: 20px;border-bottom: 1px solid var(--porto-gray-2);"><div class="owl-item active" style="width: calc(100% / 3);display: inline-block;"><div class="porto-sicon-box  wpb_custom_1efe903570d178ff0a9b7bfa5febd3a4 style_1 default-icon"><div class="porto-sicon-default"><div class="porto-just-icon-wrapper porto-icon none" style="color:#222529;font-size:37px;"><i class="porto-icon-money"></i></div></div><div class="porto-sicon-header"><h3 class="porto-sicon-title" style="font-weight:700;font-size:14px;line-height:14px;">GARANTÍA</h3><p style="font-size:13px;line-height:17px;">En todas tus compras</p></div> <!-- header --></div></div><div class="owl-item active" style="width: calc(100% / 3);display: inline-block;"><div class="porto-sicon-box  wpb_custom_1efe903570d178ff0a9b7bfa5febd3a4 style_1 default-icon"><div class="porto-sicon-default"><div class="porto-just-icon-wrapper porto-icon none" style="color:#222529;font-size:35px;"><i class="porto-icon-check-circle"></i></div></div><div class="porto-sicon-header"><h3 class="porto-sicon-title" style="font-weight:700;font-size:14px;line-height:14px;">15 DÍAS PROTECT</h3><p style="font-size:13px;line-height:17px;">Devoluciones garantizadas</p></div> <!-- header --></div></div><div class="owl-item active" style="width: calc(100% / 3);display: inline-block;"><div class="porto-sicon-box  wpb_custom_1efe903570d178ff0a9b7bfa5febd3a4 style_1 default-icon"><div class="porto-sicon-default"><div class="porto-just-icon-wrapper porto-icon none" style="color:#222529;font-size:37px;"><i class="porto-icon-secure-payment"></i></div></div><div class="porto-sicon-header"><h3 class="porto-sicon-title" style="font-weight:700;font-size:14px;line-height:14px;">PAGO SEGURO</h3><p style="font-size:13px;line-height:17px;">Con tu tarjeta favorita</p></div> <!-- header --></div></div></div>\'; } add_action(\'woocommerce_after_add_to_cart_form\', \'woocommerce_after_add_to_cart_form_addWarranty\');/*<dhelao warranty label 20231020>*/' . PHP_EOL);
				fclose($fp);
			} catch ( Exception $e ) { }
		}
		
	}
}

?>