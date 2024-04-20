<?php
/*
 * Plugin Name: Stripe for Lahmacun
 */

require_once 'stripe/init.php';
require_once 'secrets.php';


function route_return_checkout_session_membership() {
    register_rest_route('stripe', 'return_checkout_session_membership', array(
        'methods' => 'GET',
        'callback' => 'return_checkout_session_membership',
            )
    );
}

/*
 * Helper function for creating Stripe session for show host membership
 */
function StripeCheckoutSessionMembership($priceID,$paymentMode) {
  global $YOUR_DOMAIN;
  global $success_url_donation;
  global $cancel_url_donation;
  
  if ($paymentMode == 'payment'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $YOUR_DOMAIN . $success_url_donation,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url_donation,
      'payment_intent_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'one_time_membership'
        ]
      ]
    ]);  
  } elseif ($paymentMode == 'subscription'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
        'quantity' => 1,
      ]],
      'mode' => 'subscription',
      'success_url' => $YOUR_DOMAIN . $success_url_donation,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url_donation,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'recurring_membership'
        ]
      ]
    ]);  
  }
}

/*
 * Create frontend code for show host membership paywall
 */
function return_checkout_session_membership($request) {
    global $stripeSecretKey;
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    header('Content-Type: application/json');

    global $price_id_recurring_membership_huf;
    global $price_id_recurring_membership_eur;
    global $price_id_one_time_membership_huf;
    global $price_id_one_time_membership_eur;

    global $YOUR_DOMAIN;
    global $success_url_membership;
    global $cancel_url_membership;
    
    if ($request['is_recurring'] == "no"){
      if ($request['currency'] == "huf"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_one_time_membership_huf,'payment');
      } elseif ($request['currency'] == "eur"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_one_time_membership_eur,'payment');
      }
    } elseif ($request['is_recurring'] == "yes"){
      if ($request['currency'] == "huf"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_recurring_membership_huf,'subscription');
      } elseif ($request['currency'] == "eur"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_recurring_membership_eur,'subscription');
      }
    }
      
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


/*
 * Helper function for creating Stripe session for listener donation
 */
function StripeCheckoutSessionListener($priceID,$paymentMode) {
  global $YOUR_DOMAIN;
  global $success_url_donation;
  global $cancel_url_donation;
  
  if ($paymentMode == 'payment'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
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
  } elseif ($paymentMode == 'subscription'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
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
}

/*
 * Create frontend code for listener donation paywall
 */
function return_checkout_session_listener($request) {
  global $stripeSecretKey;
  \Stripe\Stripe::setApiKey($stripeSecretKey);

  header('Content-Type: application/json');

  global $price_id_one_time_listener_huf;
  global $price_id_one_time_listener_eur;
  global $price_id_recurring_listener_huf;
  global $price_id_recurring_listener_eur;

  if ($request['is_recurring'] == "no"){
    if ($request['currency'] == "huf"){
      $checkout_session = StripeCheckoutSessionListener($price_id_one_time_listener_huf,'payment');
    } elseif ($request['currency'] == "eur"){
      $checkout_session = StripeCheckoutSessionListener($price_id_one_time_listener_eur,'payment');
    }
  } elseif ($request['is_recurring'] == "yes"){
    if ($request['currency'] == "huf"){
      $checkout_session = StripeCheckoutSessionListener($price_id_recurring_listener_huf,'subscription');
    } elseif ($request['currency'] == "eur"){
      $checkout_session = StripeCheckoutSessionListener($price_id_recurring_listener_eur,'subscription');
    }
  }

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);

}

add_action('rest_api_init', 'route_return_checkout_session_membership');
add_action('rest_api_init', 'route_return_checkout_session_listener');