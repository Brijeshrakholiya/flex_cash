<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
                'class' => 'form-control',
                'placeholder' => 'Your Name'
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
        'class' => 'form-control',
        'placeholder' => 'Your Email'
);
$phone = array(
        'name'	=> 'phoneNumber',
        'id'	=> 'phoneNumber',
        'value' => set_value('phoneNumber'),
        'class' => 'form-control input-phone',
        'placeholder' => 'Your Phone'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
        'class' => 'form-control',
        'placeholder' => 'Your Password'
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
        'class' => 'form-control',
        'placeholder' => 'Confirm Password'
);
$submit_btn = array(
    'name' => 'register',
    'id' => 'register',
    'value' => 'Join Now',
    'class' => 'btn btn-custom',
);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | FlexCash</title>
<link href="<?php echo base_url(); ?>assets/fonts/font.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/animate.css">
<link href="<?php echo base_url(); ?>assets/style/jquery.bxslider.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/owl.carousel.css">

<link href="<?php echo base_url(); ?>assets/custom/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/style/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/style/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/plugins/IntlInputPhone/css/intlInputPhone.css" rel="stylesheet" type="text/css"/>

</head>

<body> 
    <header id="header">
        <div class="header">
          <div class="container">
            <div class="header_box">
            	<div class="logo-top">	
              	<a href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/images/logo.png"/></a>
              </div>
              
              <div class="main-nav">
                <nav id="nav"> <a href="#" class="menu-icon"><span></span><span></span><span></span></a>
                  <ul>
                    <li class="active"><?php echo anchor('/auth/login/', 'Sign In'); ?></li>
                  </ul>
                </nav>  
              </div> 
            </div>
          </div>    
       </div>
    </header>
    
    <section id="content">
      <div class="content">
          <div class="banner" style="background-image:url('<?php echo base_url(); ?>assets/images/slide1.jpg')">
	    <?php  /* <div class="banner">
        	<ul class="bxslider">
          	<li><img src="<?php echo base_url(); ?>assets/images/slide1.jpg"/></li>
          </ul> */?>
          <?php echo form_open_multipart($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
          <div class="banner_txt login">              	
            <h5>Create a new account</h5>
            <div class="pro_img">
              <img src="<?php echo base_url(); ?>assets/images/profile.png" id="img_back" onclick='return OpenFileBrowser(event)' alt="" style="cursor:pointer;">
              <input type="file" name="image" id="fileUpload"  class="hidden" accept=".png,.jpg,.jpeg,.gif" />
            </div>
            <p>Select Your Profile Picture</p>
            <div class="form-group">
              <?php echo form_input($username); ?>
              <?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
            </div>
            <div class="form-group">
              <?php echo form_input($email); ?>
              <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
            </div>
            <div class="form-group">
                <div class="input-phone"></div>
              <?php // echo form_input($phone_code); ?>
              <?php // echo form_input($phone); ?>
              <?php echo form_error($phone['name']); ?><?php echo isset($errors[$phone['name']])?$errors[$phone['name']]:''; ?>
            </div>
            <div class="form-group">
              <?php echo form_password($password); ?>
              <?php echo form_error($password['name']); ?>
            </div>
            <div class="form-group">
              <?php echo form_password($confirm_password); ?>
              <?php echo form_error($confirm_password['name']); ?>
            </div>
            <p><input type="checkbox" id="term_condition" name="term_condition" value="1" > Accept <span><?php echo anchor('/home/terms_conditions/', 'Terms & conditions'); ?></span>  for joining</p>
            <div class="form-group">
            <?php echo form_error('term_condition'); ?>
            </div>    
            <div class="form-group">
              <?php echo form_submit($submit_btn); ?>
            </div>
          </div>
           <?php echo form_close(); ?>     
          <div class="footer_banner">
            <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p>Copyright @ flexcash 2018</p>
              </div>
              <div class="col-sm-6">
                <div class="social-icon">
                  <ul>
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
	    </div>
    </section>
    


<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>-->

<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wow.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/custom-for-all.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/IntlInputPhone/js/intlInputPhone.js"></script>
<script src="<?php echo base_url(); ?>assets/custom/js/error_message.js"></script> 


  <script>
    $("#fileUpload").change(function () {
        filePreview(this);
    });
    
    function filePreview(input) {
       if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_back').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }  
      
    wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
          console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
      }
    );
    wow.init();
    if (($("moar").length > 0)) {
    document.getElementById('moar').onclick = function() {
      var section = document.createElement('section');
      section.className = 'section--purple wow fadeInDown';
      this.parentNode.insertBefore(section, this);
    };
    }
    function OpenFileBrowser(elem) {
        $('#fileUpload').click();
    }
  </script>
  
  
</body>
</html>
