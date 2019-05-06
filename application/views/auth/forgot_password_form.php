<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
        'class' => 'form-control',
	'value' => set_value('login'),
);

if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Enter Register Email';
} else {
	$login_label = 'Email';
}

$submit_btn = array(
    'name' => 'reset',
    'id' => 'reset',
    'value' => 'Get Password',
    'class' => 'btn btn-custom',
);

$Cancel_btn = array(
    'name' => 'reset',
    'id' => 'reset',
    'value' => 'Cancel',
    'class' => 'btn btn-custom',
);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password | FlexCash</title>
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
                    <li class="active"><?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Create a New Account ?'); ?></li>
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
	    <?php /*  <div class="banner">
        	<ul class="bxslider">
          	<li><img src="<?php echo base_url(); ?>assets/images/slide1.jpg"/></li>
          </ul>  */?>
          <div class="banner_txt login">              	
            <h5>Forget Your Password</h5>
            <?php echo form_open($this->uri->uri_string(), array('action'=> '','method'=>'post','id' => 'login-form','class' => 'login-form')); ?>
            <div class="form-group">
              <?php echo form_label($login_label, $login['id']); ?>
                    <?php echo form_input($login); ?>
                    <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
            </div>
           
            <div class="form-group">
              <?php echo form_submit($submit_btn); ?>
                <a class="btn btn-custom"  href="<?php echo base_url('auth/logout'); ?>">Cancel</a>
            </div>
            <?php echo form_close(); ?>     
          </div>
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
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]--> 
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wow.js"></script> 
<script src="<?php echo base_url(); ?>assets/custom/js/error_message.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/custom-for-all.js"></script>


  <script>
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
  </script>
 
  
</body>
</html>
	