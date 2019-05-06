<!--<span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;"><!DOCTYPE html>
<html lang="en">
<body>
<div class='web'>
<form action="<?php echo site_url('stripe_payment/checkout');?>" method="POST">
<script src="https://checkout.stripe.com/checkout.js"
class="stripe-button"
data-key="pk_test_2CsTBwLAOeoFdfF4J2PXzXOY"
data-image="your site image"
data-name="TEST"
data-description="Demo Transaction ($100.00)"
data-amount="10000" />
</script>
</form>
</div>
</body>
</html></span></span>
-->
<form action="<?php echo site_url('stripe_payment/checkout');?>" method="post">

          <div class="news-letter-box services">

                   <h2>Stripe Payment</h2>

                   <span>$ 11.50</span>

                   <div class="row">

                             <div class="col-md-6 col-sm-6">

                                      <p for="example-text-input">Card Number</p>

                                      <input class="form-control" type="text" placeholder="your card number" id="card_number" maxlength="16" name="card_number">

                                      <input type="hidden" name="amount" id="amount" value="11.50">

                             </div>

                             <div class="col-md-6 col-sm-6">

                                      <p for="example-text-input">Email Address</p>

                                      <input class="form-control" type="text" placeholder="your email" id="email" name="email">

                             </div>                  

                             <div class="col-md-4 col-sm-4">

                                      <p for="example-text-input">Exp. Month</p>

                                      <input class="form-control" type="text" placeholder="Month" Value="" id="exp_month" maxlength="2" name="exp_month" />

                             </div>

                             <div class="col-md-4 col-sm-4">

                                      <p for="example-text-input">Exp. Year</p>

                                      <input type="text" class="form-control" name="exp_year" id="exp_year" placeholder="Year" maxlength="4" Value="" />

                             </div>

                             <div class="col-md-4 col-sm-4">

                                      <p for="example-text-input">CVV</p>

                                      <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CVV" maxlength="3" Value="" />

                             </div>

                             <div class="col-md-12 col-sm-12 update_btn">

                                      <button type="submit" id="paynow" name="paynow" style="padding: 0px; float:none;" class="default-btn">Pay Now</button>

                             </div>

                   </div>

          </div> 

</form> 