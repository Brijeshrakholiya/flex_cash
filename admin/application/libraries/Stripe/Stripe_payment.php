<span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;">
<?php
       // $this->load->library('Stripe');
		require_once('init.php');//or you
		
		\Stripe\Stripe::setApiKey('sk_test_pfdgfNsP0nvkRtGrfNs6KS4C');
		\Stripe\Stripe::setClientId('ca_BuAGRs8N2kceh4iQtwSnc5AeetjhMT2G');
		
			
				
				$acct=\Stripe\Account::create(array(
				  "type" => "custom",
				  "country" => "US",
				  "email" => "bob@example.com",
				  
				  "external_account" => array(
					"object" => "bank_account",
					"account_holder_name" => "bob",
					"account_holder_type" => "individual",
					"bank_name" => "STRIPE TEST",
					"country" => "US",
					"currency" => "usd",
					"routing_number" => "110000000",
					"account_number" => "000123456789",
				  ),
				  "tos_acceptance" => array(
					"date" => 1512717228,
					"ip" => "150.129.150.183"
				  )
				  
				  
				));							
				
				
				
				$acct_id = $acct->id;
				
				$token = \Stripe\Token::create(array(
					"card" => array(
					  'number' => '4242424242424242',
					  'cvc' => '123',
					  'exp_month' => 12,
					  'exp_year' => 2022,
					  'name' => 'test',
					)
				));
			
				$dollars = 20;
				$stripeToken = $token->id;
			
				
				$charge = \Stripe\Charge::create(array(
				  "amount" => 2000,
				  "currency" => "usd",
				  "source" => $stripeToken, // obtained with Stripe.js
				  "description" => "Charge for flex"
				 ), array("stripe_account" => $acct_id));

				
				echo $transactionid = $charge->id;		

				echo "<h1>Your payment has been completed.</h1>"; 
    
  
?></span></span>