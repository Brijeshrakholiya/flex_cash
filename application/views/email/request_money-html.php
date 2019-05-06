<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Request Money From <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Refund Request</h2>
Hi,<br/>
<?php echo $user->username; ?> Request Money Before Time.
<br />
Here is user Account Details of <?php echo $user->username; ?>,
<br />
<br />
<b>Account Holder Name</b>   : <?php echo $account->AccountHolderName; ?><br />
<b>Email</b>                 :  <?php echo $account->Email; ?><br />
<b>Bank Name</b>             :  <?php echo $account->BankName; ?><br />
<b>Account ID</b>             : <?php echo $account->StripeAcID;?><br />
<br />
<br />
You received this email, because it was requested by a <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> user. This is part of the procedure for Request Money Before Time.<br />
<br />
<br />
Thank you,<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>