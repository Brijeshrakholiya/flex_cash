<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'class' => 'form-control',
    'value' => set_value('login'),
    'placeholder' => 'Your E-mail'
);

$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'placeholder' => 'Your Password'
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
    'style' => 'margin:0;padding:0',
);
$submit_btn = array(
    'name' => 'login_submit',
    'id' => 'login_submit',
    'class' => 'btn btn-custom',
    'value' => 'Sign in',
);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in | FlexCash</title>
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
                    <?php /* <ul class="bxslider">
                      <li style="background-image:url('<?php echo base_url(); ?>assets/images/slide1.jpg')"></li>
                      </ul> */ ?>
                    <div class="banner_txt login">              	




                        <h5>Sign in your account</h5>
                        <?php
                        if ($this->session->flashdata('success_msg') != ''):
                            echo '<div class="alert alert-block alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button>
                               ' . $this->session->flashdata('success_msg') . '</div>';
                        endif;
                        ?>
                        <?php echo form_open($this->uri->uri_string(), array('action' => '', 'method' => 'post', 'id' => 'login-form', 'class' => 'login-form')); ?>
                        <div class="form-group">
                            <?php echo form_input($login); ?>
                            <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?>   
                        </div>
                        <div class="form-group">
                            <?php echo form_password($password); ?>
                            <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
                        </div>
                        <div class="form-group">
                            <?php echo anchor('/auth/forgot_password/', 'Forget Password?'); ?>
                        </div>
                        <div class="form-group">
                            <?php /* <button class="btn btn-custom">Sign in <i class="fa fa-angle-right" aria-hidden="true"></i></button> */ ?>
                            <?php echo form_submit($submit_btn); ?>
                        </div>
                        <?php echo form_close(); ?>
                        <p>Don’t Have an Account ? <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Sign Up Now'); ?></p>
                        <div class="login_with">
                            <a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>assets/images/facebook.jpg"></a>
                            <a href="<?php echo $loginURL; ?>"><img src="<?php echo base_url(); ?>assets/images/google.jpg"></a>
                        </div>
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
                        offset: 100,
                        callback: function (box) {
                            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                        }
                    }
            );
            wow.init();
            if (($("moar").length > 0)) {
                document.getElementById('moar').onclick = function () {
                    var section = document.createElement('section');
                    section.className = 'section--purple wow fadeInDown';
                    this.parentNode.insertBefore(section, this);
                };
            }
        </script>


    </body>
</html>
