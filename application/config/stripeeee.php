<?php
// Configuration options

$config['stripe_key_test_public']         = "pk_test_2CsTBwLAOeoFdfF4J2PXzXOY";

$config['stripe_key_test_secret']         = "sk_test_pfdgfNsP0nvkRtGrfNs6KS4C";

$config['stripe_key_live_public']         = "";

$config['stripe_key_live_secret']         = "";

$config['stripe_test_mode']               = TRUE;

$stripe = new Stripe( $config );
?>