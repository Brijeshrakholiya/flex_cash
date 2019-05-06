<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 55,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 55,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 55,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 55,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$submit_btn = array(
    'name' => 'register',
    'id' => 'register',
    'value' => 'Register',
    'class' => 'btn btn-primary btn-cons pull-right',
);
?>

<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo base_url(); ?>assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->
<!-- BEGIN CSS TEMPLATE -->
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->
<title>Flex Cash</title>

<body class="error-body no-top">
<div class="container">
    <div class="row login-container column-seperation">  
        <div class="col-md-6 col-md-offset-4">
            <h2>Flex Cash</h2>
            <?php echo form_open($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Username', $username['id']); ?>
                    <?php echo form_input($username); ?>
                    <?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Email Address', $email['id']); ?>
                    <?php echo form_input($email); ?>
                    <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Password', $password['id']); ?>
                    <?php echo form_password($password); ?>
                    <?php echo form_error($password['name']); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Confirm Password', $confirm_password['id']); ?>
                    <?php echo form_password($confirm_password); ?>
                    <?php echo form_error($confirm_password['name']); ?>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-10">
                    <?php echo form_submit($submit_btn); ?>
                    <a class="btn btn-default cancel_button" href="<?php echo base_url('auth/logout'); ?>">Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>                                     
        </div>
    </div>
</div>

</body>

<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/login.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
	