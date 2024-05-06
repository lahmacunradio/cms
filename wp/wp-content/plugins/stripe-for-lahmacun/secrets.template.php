<?php
// Keep your Stripe API key protected by including it as an environment variable
// or in a private script that does not publicly expose the source code.
$stripeSecretKey = 'ADD_API_KEY';

//Product IDs (Stripe)
$price_id_recurring_membership_huf = 'ADD_PRICE_ID';
$price_id_recurring_membership_eur = 'ADD_PRICE_ID';
$price_id_one_time_membership_huf = 'ADD_PRICE_ID';
$price_id_one_time_membership_eur = 'ADD_PRICE_ID';
$price_id_one_time_listener_huf = 'ADD_PRICE_ID';
$price_id_one_time_listener_eur = 'ADD_PRICE_ID';
$price_id_recurring_listener_huf = 'ADD_PRICE_ID';
$price_id_recurring_listener_eur = 'ADD_PRICE_ID';

//Domains and URLs
$YOUR_DOMAIN = 'http://localhost';
$success_url_membership = '/thanks-for-your-payment-show-host';
$cancel_url_membership = '/thanks-for-your-payment-show-host';
$success_url_donation = '/bummer-you-go-listener';
$cancel_url_donation = '/bummer-you-go-listener';