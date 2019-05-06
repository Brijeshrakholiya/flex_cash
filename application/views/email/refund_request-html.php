<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Refund Request From <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Refund Request</h2>
Hi,<br/>
<?php echo $user->username; ?> Request Refund for <?php echo $flex_name; ?>.
<br />
Here is user Join Information,
<br />
<br />
<b>User Name</b>       : <?php echo $user->username; ?><br />
<b>Flex Name</b>       : <?php echo $flex_name; ?><br />
<b>Quantity</b>        : <?php echo $join_info->Qty; ?><br />
<b>Amount</b>          : <?php echo $join_info->FlexAmt;?><br />
<b>Join Date</b>       : <?php echo $join_info->JoinDate;?><br />
<b>Transection ID</b>  : <?php echo $join_info->TransactionID; ?><br />
<br />
<br />
You received this email, because it was requested by a <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> user. This is part of the procedure for Request Refund of any Flex.<br />
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