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
 * Helper function for creating a Stripe checkout session for show host donations
 */
function StripeCheckoutSessionMembership($priceID,$paymentMode, $show_name, $success_url, $cancel_url) {
  global $YOUR_DOMAIN;
  
  if ($paymentMode == 'payment'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'payment_intent_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'membership',
            'show_name' => $show_name
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
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'membership',
            'show_name' => $show_name
        ]
      ]
    ]);  
  }
}

/*
 * Helper function for creating a Stripe checkout session for listener donations
 */
function StripeCheckoutSessionListener($priceID,$paymentMode, $success_url, $cancel_url) {
  global $YOUR_DOMAIN;
  
  if ($paymentMode == 'payment'){
    return \Stripe\Checkout\Session::create([
      'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
          'price' => $priceID,
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'payment_intent_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'listener'
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
      'success_url' => $YOUR_DOMAIN . $success_url,
      'cancel_url' => $YOUR_DOMAIN . $cancel_url,
      'subscription_data' => [
        'metadata' => [
            'kultdesk_org' => 'lahmacun_radio',
            'lahmacun_form' => 'listener'
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

    global $success_url_membership;
    global $cancel_url_membership;
    
    if ($request['is_recurring'] == "no"){
      if ($request['currency'] == "huf"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_one_time_membership_huf,'payment',$request['show_name'],$success_url_membership,$cancel_url_membership);
      } elseif ($request['currency'] == "eur"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_one_time_membership_eur,'payment',$request['show_name'],$success_url_membership,$cancel_url_membership);
      }
    } elseif ($request['is_recurring'] == "yes"){
      if ($request['currency'] == "huf"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_recurring_membership_huf,'subscription',$request['show_name'],$success_url_membership,$cancel_url_membership);
      } elseif ($request['currency'] == "eur"){
        $checkout_session = StripeCheckoutSessionMembership($price_id_recurring_membership_eur,'subscription',$request['show_name'],$success_url_membership,$cancel_url_membership);
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

  global $success_url_donation;
  global $cancel_url_donation;

  if ($request['is_recurring'] == "no"){
    if ($request['currency'] == "huf"){
      $checkout_session = StripeCheckoutSessionListener($price_id_one_time_listener_huf,'payment',$success_url_donation,$cancel_url_donation);
    } elseif ($request['currency'] == "eur"){
      $checkout_session = StripeCheckoutSessionListener($price_id_one_time_listener_eur,'payment',$success_url_donation,$cancel_url_donation);
    }
  } elseif ($request['is_recurring'] == "yes"){
    if ($request['currency'] == "huf"){
      $checkout_session = StripeCheckoutSessionListener($price_id_recurring_listener_huf,'subscription',$success_url_donation,$cancel_url_donation);
    } elseif ($request['currency'] == "eur"){
      $checkout_session = StripeCheckoutSessionListener($price_id_recurring_listener_eur,'subscription',$success_url_donation,$cancel_url_donation);
    }
  }

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);

}

add_action('rest_api_init', 'route_return_checkout_session_membership');
add_action('rest_api_init', 'route_return_checkout_session_listener');