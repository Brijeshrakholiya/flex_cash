<link href="<?php echo base_url(); ?>assets/plugins/alert/css/alert.min.css" rel="stylesheet" />
 <link href="<?php echo base_url(); ?>assets/plugins/alert/themes/default/theme.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/plugins/alert/js/alert.min.js"></script>   
<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <div class="content">
        <?php $this->load->view("includes/messages"); ?>
        <div class="page-title"> <i class="icon-custom-left"></i>
            <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Refund Request"); ?></span></h3>
        </div>
        <div id="container">
            <div class="row">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="grid simple horizontal orenge">
                            <div class="grid-title">
                                <h4><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Refund Request"); ?></span></h4>
                                <?php /*
                                  <div class="col-md-1 pull-right">
                                  <a href="<?php echo base_url('flexmst/add')?>" class="btn btn-block btn-primary" ><span class="bold">ADD</span></a>
                                  </div */ ?>
                            </div>

                            <div class="grid-body">
                                <div class="col-md-4">	                           
                                    <select id="status" class="search" style="width:100%">
                                        <option value="0"> Select Refund Status</option>
                                        <option value="1" >Approve</option>
                                        <option value="2" >Denied</option>
                                    </select>
                                </div>
                            </div>  
                            <div class="grid-body ">

                                <table class="table table-bordered table-advance table-hover" id="refund" data-control="refundmst" data-method="manage">
                                    <thead>
                                        <tr>
                                            <th style="">Flex Name</th>
                                            <th>User Name</th>
                                            <th>Transaction ID</th>
                                            <th>Request Date</th>
                                            <th>Status</th>
                                            <th style="width:150px !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>



    <div class="modal fade bs-example-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" >
            <div class="modal-content" id="timetable_model_main">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4><span class="semi-bold" id="myModalLabel2">Refund Request Details</span></h4>
                </div>
                <div class="grid simple horizontal orenge" id="timetable-slot">
                    <div class="grid-body" >
                        <table class="table table-responsive table-bordered" id="model_content_area">

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <span id="refund_btns">
                        
                    </span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>    
    
    

