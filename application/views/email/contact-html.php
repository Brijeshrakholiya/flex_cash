<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Contact Support <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Contact Support Mail</h2>
Hello, there  <br>

I have some Query in <?php echo $site_name; ?>, Please Help me.<br />
My Query is ...<br />
<br />
<?php echo $message;?>
<br /><br />
You received this email, because it was requested by a <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> user. This is part of the procedure to Contact with <?php echo $site_name; ?> Admin. <br />
<br />
<br />
Thank you,<br />
<?php echo $user->username; ?>
</td>
</tr>
</table>
</div>
</body>
</html>