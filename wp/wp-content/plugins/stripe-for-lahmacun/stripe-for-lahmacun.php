<?php
/*
 * Plugin Name: Stripe for Lahmacun
 */

require_once 'stripe/init.php';
require_once 'secrets.php';


function my_register_route() {
    register_rest_route('my-route', 'my-phrase', array(
        'methods' => 'GET',
        'callback' => 'custom_phrase',
            )
    );
}
function custom_phrase() {
    global $stripeSecretKey;
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    header('Content-Type: application/json');

    global $price_id;

    global $YOUR_DOMAIN;
    global $success_url;
    global $cancel_url;
    
    $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        'price' => $price_id,
        'quantity' => 1,
      ]],
      'mode' => 'subscription',
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'subscription_data' => [
        'metadata' => [
            'lahmacun_form' => 'recurring_membership',
        ]
      ]
    ]);
    
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);

//    return new WP_REST_Response('Hello World! This is my first REST API');
}

add_action('rest_api_init', 'my_register_route');