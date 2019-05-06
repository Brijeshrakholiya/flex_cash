<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 55,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or Username';
} else if ($login_by_username) {
	$login_label = 'Username';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 55,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);

$submit_btn = array(
    'name' => 'login_submit',
    'id' => 'login_submit',
    'value' => 'Sign In',
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
        <div class="col-md-12">
        <div class="text-center">
        <img src="<?php echo base_url(); ?>assets/img/logo.png" style="max-width:300px; margin:0 0 20px 0"/>
        </div>
        <div class="login-body">
          
          <h2>Sign in to Flex Cash</h2>
                <div class="row">
                    <div class="form-group col-md-10">
                        <?php $this->load->view("includes/messages");?>
                    </div>
                </div>
                <?php echo form_open($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
        <div class="row">
            <div class="form-group col-md-10">
                <?php echo form_label($login_label, $login['id']); ?>
		<?php echo form_input($login); ?>
		<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>    
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-10">
                <?php echo form_label('Password', $password['id']); ?>
                <?php echo form_password($password); ?>
                <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
            </div>
        </div>
        <div class="row">
          <div class="control-group  col-md-10">
            <div class="checkbox checkbox check-success"> <?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>&nbsp;&nbsp;
              <?php echo form_checkbox($remember); ?>
	      <?php echo form_label('Remember me', $remember['id']); ?>
            </div>
          </div>
          </div>
          <div class="row">
            <div class="control-group col-md-12">
              <?php echo form_submit($submit_btn); ?>
            </div>
          </div>
          
          </div>
            <?php /*<div class="row">
                <div class="control-group col-md-10">
                    Don't have an account yet?
                    <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
                </div>  */?>
          </div>
                     <!-- /form -->
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