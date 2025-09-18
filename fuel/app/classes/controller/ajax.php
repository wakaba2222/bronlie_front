<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Ajax extends Controller_Rest
{

	/**
	 * お気に入り追加
	 * @return unknown
	 */
	public function action_addwish()
	{
		$result = "";

		$customer_id = Input::json('customer_id');
		$product_id = Input::json('product_id');

		if( $customer_id != "" && $product_id != "" ) {
			$objWishlistctrl = new Tag_Wishlistctrl();
			$result = $objWishlistctrl->add_wish($customer_id, $product_id);
		}

		$this->format = 'json';
		$json = ['result' => $result];
		return $this->response($json);
	}


	/**
	 * お気に入り削除
	 * @return unknown
	 */
	public function action_delwish()
	{
		$result = "";

		$customer_id = Input::json('customer_id');
		$product_id = Input::json('product_id');

		if( $customer_id != "" && $product_id != "" ) {
			$objWishlistctrl = new Tag_Wishlistctrl();
			$result = $objWishlistctrl->del_wish($customer_id, $product_id);
		}

		$this->format = 'json';
		$json = ['result' => $result];
		return $this->response($json);
	}
	public function action_updateCheckout()
	{
        Config::load(Fuel::PRODUCTION.'/payment_conf.php', 'paymentapi');
		$amazonpay_config = array(
		    'public_key_id' => Config::get('paymentapi.public_key_id'),//'SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR',  // RSA Public Key ID (this 
		    'private_key'   => Config::get('paymentapi.private_key'),//'/var/www/bronline/fuel/app/config/keys/AmazonPay_SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR.pem',       
		    'sandbox'       => Config::get('paymentapi.amazon_sandbox'),                        // true (Sandbox) or false (Production) boolean
		    'region'        => Config::get('paymentapi.amazon_region')                         // Must be one of: 'us', 'eu', 'jp' 
		);

	    $checkout_session_id = $_REQUEST['checkout_session_id'];
	    $amount = $_REQUEST['amount'];
	    $order_id = $_REQUEST['order_id'];
	
		$server_name = 'https://'.str_replace('origin', 'www', $_SERVER['HTTP_HOST']);

	    $payload = array(
	        'webCheckoutDetails' => array(
	            'checkoutResultReturnUrl' => $server_name.'/cart/complete'
	        ),
	        'paymentDetails' => array(
	            'paymentIntent' => 'AuthorizeWithCapture',
	            'canHandlePendingAuthorization' => false,
                'totalOrderAmount' => array(
	                'amount' => $amount,
	                'currencyCode' => "JPY"
                ),
	            'chargeAmount' => array(
	                'amount' => $amount,
	                'currencyCode' => "JPY"
	            ),
	          //"softDescriptor" => "softDescriptor"
	        ),
	        'merchantMetadata' => array(
	            'merchantReferenceId' => $order_id,
	            'merchantStoreName' => 'B.R.ONLINE',
	            'noteToBuyer' => ''
	            // "customInformation" => "customInformation"
	        )
	        // "platformId" => "platformID"
	    );
	
	    try {
	        $client = new Amazon\Pay\API\Client($amazonpay_config);
	        $result = $client->updateCheckoutSession($checkout_session_id, $payload);
	        $response = '{"status":' . $result['status'] . ',"response":' . $result['response'] . '}';
//	        echo($response);

			$this->format = 'json';
			return $this->response($response);
	
	    } catch (\Exception $e) {
	        // handle the exception
//	        echo $e . "\n";
	    }
	}
	
	public function action_checkout()
	{
        Config::load(Fuel::PRODUCTION.'/payment_conf.php', 'paymentapi');
		$amazonpay_config = array(
		    'public_key_id' => Config::get('paymentapi.public_key_id'),//'SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR',  // RSA Public Key ID (this 
		    'private_key'   => Config::get('paymentapi.private_key'),//'/var/www/bronline/fuel/app/config/keys/AmazonPay_SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR.pem',       
		    'sandbox'       => Config::get('paymentapi.amazon_sandbox'),                        // true (Sandbox) or false (Production) boolean
		    'region'        => Config::get('paymentapi.amazon_region')                         // Must be one of: 'us', 'eu', 'jp' 
		);

	    $checkout_session_id = $_POST['checkout_session_id'];
	    try {
	        $client = new Amazon\Pay\API\Client($amazonpay_config);
	        $result = $client->getCheckoutSession($checkout_session_id);
	        $response = '{"status":' . $result['status'] . ',"response":' . $result['response'] . '}';
//	        echo($response);
	
			$this->format = 'json';
			return $this->response($response);

	    } catch (\Exception $e) {
	    	
	        // handle the exception
//	        echo $e . "\n";
	    }
	}

}
