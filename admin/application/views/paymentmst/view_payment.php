<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "View Payment"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid simple horizontal orenge">
                    <div id="container">
                        <div class="grid-title">
                                <h4><span class="semi-bold">Payment Details</span></h4>
              
                       <div class="pull-right">  
                           <a data-original-title="" data-placement="top" data-toggle="tooltip" href="paymentmst/" class="btn btn-info"><span class="fa fa-reply"></span> Back</i></a>
                       </div>
                       </div>
                         <div class="grid-body">
                       <table class="table table-responsive table-bordered">
                          <tbody>
                            <tr>
                                <td style="width:25% !important;"><b>Payment Type</b></td>
                              <td><?php echo pay_type($pay_info->PayType); ?></td>
                            </tr>
                            <?php 
                                if(isset($dtl_info) && $dtl_info != ''){?>
                                    <tr>
                                        <td style="width:25% !important;"><b>Card Name</b></td>
                                        <td><?php echo $dtl_info->CardName; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:25% !important;"><b>Card No.</b></td>
                                        <td><?php echo $dtl_info->CardNo; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:25% !important;"><b>Expiry Month</b></td>
                                        <td><?php echo $dtl_info->ExpiryMonth; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:25% !important;"><b>Expiry Year</b></td>
                                        <td><?php echo $dtl_info->ExpiryYear; ?></td>
                                    </tr>
                                    
                         <?php  }
                            ?>
                            <tr>
                                <td style="width:25% !important;"><b>Is Default</b></td>
                              <td><?php  echo flex_is($pay_info->isDefault); ?></td>
                            </tr>
                            
                          </tbody>
                        </table> 
                    </div>    
                    </div>
                </div>
            </div>
        </div>
	<!-- END BASIC FORM ELEMENTS-->	   
    </div>
</div>
