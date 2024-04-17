<?php
// Keep your Stripe API key protected by including it as an environment variable
// or in a private script that does not publicly expose the source code.
$stripeSecretKey = 'ADD_API_KEY';

//Product IDs (Stripe)
$price_id_recurring_membership_huf = 'ADD_PRICE_ID';
$price_id_recurring_membership_eur = 'ADD_PRICE_ID';
$price_id_one_time_listener_huf = 'ADD_PRICE_ID';
$price_id_one_time_listener_eur = 'ADD_PRICE_ID';
$price_id_recurring_listener_huf = 'ADD_PRICE_ID';
$price_id_recurring_listener_eur = 'ADD_PRICE_ID';

//Domains and URLs
$YOUR_DOMAIN = 'http://localhost';
$success_url_membership = '/thanks-for-your-payment';
$cancel_url_membership = '/thanks-for-your-payment';
$success_url_donation = '/thanks-for-your-payment';
$cancel_url_donation = '/thanks-for-your-payment';