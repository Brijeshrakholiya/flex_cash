</div>

        <!-- END CONTAINER -->
        <!-- BEGIN CORE JS FRAMEWORK-->

        <!--[if lt IE 9]>
        <script src="assets/plugins/respond.js"></script>
        <![endif]-->
        
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/breakpoints.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
         <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/boostrap-clockpicker/bootstrap-clockpicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/plugins/ios-switch/ios7-switch.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
        <!-- END CORE JS FRAMEWORK -->
        <!-- BEGIN PAGE LEVEL JS -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js" type="text/javascript" ></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-responsive-tabs-master/js/jquery.bootstrap-responsive-tabs.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-responsive-tabs-master/js/jquery.bootstrap-responsive-tabs.min.js" type="text/javascript"></script>
         <script src="<?php echo base_url(); ?>assets/plugins/alert/js/alert.min.js"></script>   
        
       
    
        <!-- END PAGE LEVEL PLUGINS -->
       
        <!-- BEGIN CORE TEMPLATE JS -->
        <script src="<?php echo base_url(); ?>assets/js/datatables.js" type="text/javascript"></script>
         <script src="<?php echo base_url(); ?>assets/js/form_elements.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/core.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/chat.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/demo.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/custom-for-all.js"></script>
        
        
        
        
       
        <?php
        if (isset($extra_js) && is_array($extra_js) && count($extra_js) > 0) {
            foreach ($extra_js as $js) {
                if (!empty($js)) {
                    echo '<script type="text/javascript" src="' . base_url() . 'assets/custom/js/' . $js . '.js" ></script>';
                }
            }
        }
        ?>                                                          
        <!-- END CORE TEMPLATE JS -->
    </body>
</html>