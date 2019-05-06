<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title;?></title>
<link href="<?php echo base_url(); ?>assets/fonts/font.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/animate.css">
<link href="<?php echo base_url(); ?>assets/style/jquery.bxslider.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style/owl.carousel.css">

<link href="<?php echo base_url(); ?>assets/style/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/style/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/style/responsive.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/---datepicker.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url(); ?>assets/plugins/jquery-datepicker/css/---datepicker.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url(); ?>assets/style/animate.min.css" rel="stylesheet" type="text/css"/>
 <link href="<?php echo base_url(); ?>assets/custom/css/custom.css" rel="stylesheet" type="text/css"/>
 <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
 <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-responsive-tabs-master/css/bootstrap-responsive-tabs.css" rel="stylesheet" type="text/css"/>
 <link href="<?php echo base_url(); ?>assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
 <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/imagecrop/imgareaselect.css">-->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/image_cropper/css/cropper.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/image_cropper/css/main.css">
 
 <?php /*
<link href="<?php echo base_url(); ?>assets/plugins/mdb_input/css/mdb.css" rel="stylesheet" type="text/css"/> 
<link href="<?php echo base_url(); ?>assets/plugins/mdb_input/css/mdb.min.css" rel="stylesheet" type="text/css"/> 
 */?>
 
<script type="text/javascript">
            var BASEURL = "<?php echo base_url(); ?>";
            var WIDTH = "<?php echo WIDTH; ?>";
            var HEIGHT = "<?php echo HEIGHT; ?>";
            var USERID = "<?php echo $this->tank_auth->get_user_id(); ?>";
</script>
</head>

<body> 
    <header id="<?php if($page_title == 'HOME'){echo 'header';}else{echo 'inner_header';}?>">
        <div class="<?php if($page_title == 'HOME'){echo 'header';}else{echo 'inner_header';}?>">
          <div class="container">
            <div class="header_box">
            	<div class="logo-top">	
              	<a href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/images/logo.png"/></a>
              </div>
              
              <div class="main-nav">
                <nav id="nav"> <a href="#" class="menu-icon"><span></span><span></span><span></span></a>
                  <ul>
                    <?php if(!$this->tank_auth->get_user_id()){?>
                      <li><a class="moveto" href="<?php echo base_url();?>#share_section">How It Work</a></li>
                        <li><a class="moveto" href="<?php echo base_url();?>#reasons_section">Why Flex</a></li>
                    
                    <li><?php echo anchor('/home/about/', 'ABOUT'); ?></li>
                    <li><?php echo anchor('/home/contact/', 'CONTACTS'); ?></li>
                    <?php } ?>
                    <?php if($this->tank_auth->get_user_id()){?>
                    <li><?php echo anchor(base_url(), 'FLEXES'); ?></li>
                        <li><?php echo anchor('/home/notification/', '<span class="notify-bubble"></span><i class="fa fa-bell-o"></i>'); ?></li>
                    <?php } ?>
                    
                    <?php if(!$this->tank_auth->get_user_id()){ /* ?>
                    <li><a href="<?php echo base_url(); ?>index.php/auth/login/" ><button class="btn btn-warning"><i class="fa fa-user"></i> Login / Register</button></a></li>
                    <?php */ }else
                    { 
                      ?>

                    <!-- <li><a href="<?php echo base_url(); ?>index.php/auth/logout/" ><button class="btn btn-warning">LOGOUT</button></a></li> -->
                        
                    <?php
                        $file = USER_IMG_THUMB_PATH.$img ;
                        if(isset($img) && !empty($img) && file_exists($file)) {
                            $user_thumb_img = IMG_URL.USER_IMG_THUMB_PATH.$img; 
                        }else{
                            $user_thumb_img = base_url().'/assets/images/default_user.jpg';
                        }?>
                        
                    <li class="dropdown dropdown-user">
                      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                         
                          <img alt="" class="img-circle" src="<?php echo $user_thumb_img;?>" height="30px" width="30px" />
                     <?php /* <img alt="" class="img-circle" src="<?php echo base_url(); ?>assets/images/avatar1_small.jpg"/> */ ?>
                      <span class="username username-hide-on-mobile">
                       <?php echo $username;?> </span>
                      <i class="fa fa-angle-down"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                          <a href="<?php echo base_url(); ?>user">
                          <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url(); ?>index.php/auth/logout/">
                          <i class="icon-key"></i> Log Out </a>
                        </li>
                      </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->




                    
                    <?php } ?>
                  </ul>
                </nav>  
              </div> 
            </div>
          </div>    
       </div>
    </header>
    <?php if($page_title != 'HOME'){?>
   <section id="breadcrumb_section">
      <div class="content">
	      <div class="breadcrumb_block">
        	<div class="container">
            <div class="breadcrumb_box">
              <h3><?php echo $page_title;?></h3>
            </div>
          </div>
        </div>
	    </div>
    </section>
     <?php }?>