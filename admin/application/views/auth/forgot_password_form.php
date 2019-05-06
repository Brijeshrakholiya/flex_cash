<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 55,
);

if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}

$submit_btn = array(
    'name' => 'reset',
    'id' => 'reset',
    'value' => 'Get a new password',
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
            <h2>Forgot password ?</h2>
            <?php echo form_open($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label($login_label, $login['id']); ?>
                    <?php echo form_input($login); ?>
                    <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-12">
                    <?php echo form_submit($submit_btn); ?>
                    <a class="btn btn-default cancel_button" href="<?php echo base_url('auth/logout'); ?>">Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>                                     
        </div>
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
	