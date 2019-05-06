<span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;">
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Stripe_payment extends CI_Controller {
  
    public function __construct() {
        parent::__construct();
        $this->load->library('Stripe');
    }
  
    public function index()
    {
        $this->load->view('stripe/stripe');
    }
  
    public function checkout()
    {
        $card_data = array(

          "number" => $this->input->post("card_number"),

          "cvc" => $this->input->post("cvv"),

          "exp_month" => $this->input->post("exp_month"),

          "exp_year" => $this->input->post("exp_year"),

          "name" => $this->input->post("email"),
		 );
		$dollars = $this->input->post("amount");
		
		$tokenArray = json_decode($this->stripe->card_token_create($card_data,$cents));
		
		$stripeToken = $tokenArray->id;
		
		
		$card = $stripeToken;

		$email = $this->input->post("email");
		
		$desc = $this->input->post("description");
		
		$plan = $this->input->post("plan_id");
		
		$customerCreateArray = json_decode($this->stripe->customer_create( $card, $email, $desc, $plan));
		
		$customer_id = $customerCreateArray->id;
		
		$amount =  $cents;
		
		$card = $card_data;
		
		$desc = $this->input->post("description");
		
		$payWithStripe = json_Decode($this->stripe->charge_card($amount, $card, $desc));
		
    }
  
    }?></span></span>