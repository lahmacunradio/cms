<?php
// Keep your Stripe API key protected by including it as an environment variable
// or in a private script that does not publicly expose the source code.
$stripeSecretKey = 'ADD_API_KEY';

//Product IDs (Stripe)
$price_id_recurring_membership = 'ADD_PRICE_ID';

//Domains and URLs
$YOUR_DOMAIN = 'http://localhost';
$success_url = '/thanks-for-your-payment';
$cancel_url = '/thanks-for-your-payment';