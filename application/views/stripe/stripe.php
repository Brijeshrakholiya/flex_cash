<span style="font-size:12px;"><span style="font-family:arial,helvetica,sans-serif;"><!DOCTYPE html>
<html lang="en">
<body>
<div class='web'>
<form action="<?php echo site_url('Stripe_payment/checkout');?>" method="POST">
<script src="https://checkout.stripe.com/checkout.js"
class="stripe-button"
data-key="pk_test_2CsTBwLAOeoFdfF4J2PXzXOY"
data-image="your site image"
data-name="w3code.in"
data-description="Demo Transaction ($100.00)"
data-amount="10000" />
</script>
</form>
</div>
</body>
</html></span></span>