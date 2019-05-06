<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
$submit_btn = array(
    'name' => 'change',
    'id' => 'change',
    'value' => 'Change Password',
    'class' => 'btn btn-info',
);
?>
<?php /*
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
<title>C4MH</title>

<body class="error-body no-top">
*/ ?>
<?php
$this->load->view('includes/header');
$this->load->view('includes/admin_sidebar');
$this->load->view("includes/messages");
?>
<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Change Password"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
                <?php echo form_open($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
                <div class="grid-body no-border"> <br>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Old Password', $old_password['id']); ?>
                    <?php echo form_password($old_password); ?>
                    <?php echo form_error($old_password['name'], "<p class='error'>", '</p>'); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('New Password', $new_password['id']); ?>
                    <?php echo form_password($new_password); ?>
                    <?php echo form_error($new_password['name'], "<p class='error'>", '</p>'); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
                    <?php echo form_password($confirm_new_password); ?>
                    <?php echo form_error($confirm_new_password['name'], "<p class='error'>", '</p>'); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
                </div>
            </div>
            <div class="form-actions">  
                    <div class="pull-left">
                       <?php echo form_submit($submit_btn); ?>
                    <a class="btn btn-default cancel_button" href="<?php echo base_url('auth/logout'); ?>">Cancel</a>
                    </div>
                </div>
                </div>
                
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	   
    </div>
</div>        


            <div class="row">
                <div class="control-group col-md-6">
                    <?php echo form_submit($submit_btn); ?>
                    <a class="btn btn-default cancel_button" href="<?php echo base_url('auth/logout'); ?>">Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>                                     
        </div>
    </div>
</div>

</body>
<?php /*
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/login.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
 * 
 */?>
<?php $this->load->view('includes/footer');?>