<?php
/*
 * Plugin Name: Stripe for Lahmacun
 */

require_once 'stripe/init.php';
require_once 'secrets.php';


function route_return_checkout_session_recurring_membership() {
    register_rest_route('stripe', 'return_checkout_session_recurring_membership', array(
        'methods' => 'GET',
        'callback' => 'return_checkout_session_recurring_membership',
            )
    );
}
function return_checkout_session_recurring_membership() {
    global $stripeSecretKey;
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    header('Content-Type: application/json');

    global $price_id_recurring_membership;

    global $YOUR_DOMAIN;
    global $success_url;
    global $cancel_url;
    
    $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        'price' => $price_id_recurring_membership,
        'quantity' => 1,
      ]],
      'mode' => 'subscription',
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'recurring_show_membership'            ]
        ]
    ]);
    
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);

//    return new WP_REST_Response('Hello World! This is my first REST API');
}

add_action('rest_api_init', 'route_return_checkout_session_recurring_membership');