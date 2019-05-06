<span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;">
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Stripe_payment extends CI_Controller {
  
    public function __construct() {
        parent::__construct();
       // $this->load->library('Stripe');
		require_once(APPPATH.'libraries/Stripe/init.php');//or you
		
		\Stripe\Stripe::setApiKey('sk_test_pfdgfNsP0nvkRtGrfNs6KS4C');
		\Stripe\Stripe::setClientId('ca_BuAGRs8N2kceh4iQtwSnc5AeetjhMT2G');
    }
  
    public function index()
    {
        $this->load->view('stripe/stripe');
    }
	
    public function checkout()
    {
		$token = \Stripe\Token::create(array(
			"card" => array(
			  'number' => $this->input->post('card_no'),
			  'cvc' => $this->input->post('cvv_no'),
			  'exp_month' => date('m',strtotime($this->input->post('expiry'))),
			  'exp_year' => 2022,
			  'name' => 'test',
			)
		));
		
		$dollars = 20;
		$stripeToken = $token->id;
		
		$Charge=\Stripe\Charge::create(array(
		  "amount" => 2000,
		  "currency" => "usd",
		  "source" => $stripeToken, // obtained with Stripe.js
		  "description" => "Charge for flex"
		));
		
		$transactionid = $Charge->id;		
		
    }
	
  
    public function Merchant_create()
    {
		
        try { 
			
			if (isset($_GET['code'])) 
			{
				
				$code=$_GET['code'];
				try {
					$resp = \Stripe\OAuth::token(array(
						'grant_type' => 'authorization_code',
						'code' => $code,
					));
				} catch (\Stripe\Error\OAuth\OAuthBase $e) {
					exit("Error: " . $e->getMessage());
				}
			
	
				$accountId = $resp->stripe_user_id;
				
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
			}
			else
			{
				$url = \Stripe\OAuth::authorizeUrl(array(
					'scope' => 'read_only',
				));
				echo "<a href=\"$url\">Connect with Stripe</a>\n";
			}
		}catch(Stripe_CardError $e) {
            
            print_r($e);

        }
        catch (Stripe_InvalidRequestError $e) {
	         } catch (Stripe_AuthenticationError $e) {
         } catch (Stripe_ApiConnectionError $e) {
         } catch (Stripe_Error $e) {
         } catch (Exception $e) {
         }
    }
  
    }?></span></span>