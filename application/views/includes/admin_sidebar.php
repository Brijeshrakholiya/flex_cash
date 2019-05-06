<!-- BEGIN SIDEBAR -->
<div class="page-sidebar" id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
        
        <!-- END MINI-PROFILE -->
        <!-- BEGIN SIDEBAR MENU -->
        <ul>
            <li <?php echo ((isset($page) && $page == 'dashboard') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>"> <i class="fa fa-dashboard"></i> <span class="title">Dashboard </span></a></li>
            
            <li <?php echo ((isset($page) && $page == 'flex') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>flexmst/"> <i class="fa fa-th-large"></i> <span class="title">Flex </span></a></li>
            
            <li <?php echo ((isset($page) && ($page == 'flex_question' || $page == 'flex_option')) ? 'class="active open"' : ""); ?>> <a href="javascript:;"> <i class="fa fa-question-circle"></i> <span class="title">Manage Question</span> <span class="arrow "></span> </a>
                <ul class="sub-menu">
                   <li <?php echo ((isset($page) && $page == 'flex_question') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>flexquestion/"> <i class="fa fa-angle-double-right"></i> <span class="title">Flex Question</span></a></li>
            <li <?php echo ((isset($page) && $page == 'flex_option') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>flexoption/"> <i class="fa fa-angle-double-right"></i> <span class="title">Flex Option</span></a></li>
                </ul>
            </li>
            <li <?php echo ((isset($page) && ($page == 'paymentmst' || $page == 'paymentdtl')) ? 'class="active open"' : ""); ?>> <a href="javascript:;"> <i class="fa fa-credit-card"></i> <span class="title">Manage Payment</span> <span class="arrow "></span> </a>
                <ul class="sub-menu">
                   <li <?php echo ((isset($page) && $page == 'paymentmst') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>paymentmst/"> <i class="fa fa-angle-double-right"></i> <span class="title">Payment Mst</span></a></li>
            <li <?php echo ((isset($page) && $page == 'paymentdtl') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>paymentdtl/"> <i class="fa fa-angle-double-right"></i> <span class="title">Payment Details</span></a></li>
                </ul>
            </li>
            <li <?php echo ((isset($page) && $page == 'users') ? 'class="active"' : ""); ?>> <a href="<?php echo base_url(); ?>appuser/"> <i class="fa fa-users"></i> <span class="title">App Users</span></a></li>
        </ul>
        
           
        <div class="clearfix"></div>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
    