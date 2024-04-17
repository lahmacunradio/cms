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
function return_checkout_session_recurring_membership($request) {
    global $stripeSecretKey;
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    header('Content-Type: application/json');

    global $price_id_recurring_membership;

    global $YOUR_DOMAIN;
    global $success_url_membership;
    global $cancel_url_membership;
    
    $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        'price' => $price_id_recurring_membership,
        'quantity' => 1,
      ]],
      'mode' => 'subscription',
      'success_url' => $YOUR_DOMAIN . $success_url_membership,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url_membership,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'recurring_show_membership',
            'show_name' => $request['show_name']                  
        ]
      ]
    ]);
    
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);

//    return new WP_REST_Response('Hello World! This is my first REST API');
}

function route_return_checkout_session_listener() {
  register_rest_route('stripe', 'return_checkout_session_listener', array(
      'methods' => 'GET',
      'callback' => 'return_checkout_session_listener',
          )
  );
}

function return_checkout_session_listener($request) {
  global $stripeSecretKey;
  \Stripe\Stripe::setApiKey($stripeSecretKey);

  header('Content-Type: application/json');

  global $price_id_one_time_listener;
  global $price_id_recurring_listener;

  global $YOUR_DOMAIN;
  global $success_url_donation;
  global $cancel_url_donation;
  
  if ($request['is_recurring'] == "no"){
      $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
          # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          if ($request['currency'] == "huf"){
            'price' => $price_id_one_time_listener_huf,
          }
          elseif ($request['currency'] == "eur"){
            'price' => $price_id_one_time_listener_eur,
          }
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . $success_url_donation,
        'cancel_url' => $YOUR_DOMAIN . $cancel_url_donation,
        'payment_intent_data' => [
          'metadata' => [
              'kultdesk_org' => 'lahmacun_radio',
              'lahmacun_form' => 'one_time_listener_donation'
          ]
        ]
      ]);
  }

  if ($request['is_recurring'] == "yes"){
    $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        if ($request['currency'] == "huf"){
          'price' => $price_id_recurring_listener_huf,
        }
        elseif ($request['currency'] == "eur"){
          'price' => $price_id_recurring_listener_eur,
        }
        'quantity' => 1,
      ]],
      'mode' => 'subscription',
      'success_url' => $YOUR_DOMAIN . $success_url_donation,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url_donation,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'recurring_listener_donation'
        ]
      ]
    ]);

  }



  
  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);

}

add_action('rest_api_init', 'route_return_checkout_session_recurring_membership');
add_action('rest_api_init', 'route_return_checkout_session_listener');