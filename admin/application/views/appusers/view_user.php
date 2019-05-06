<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "View User"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid simple horizontal orenge">
                    <div id="container">
                        <div class="grid-title">
                                <h4><span class="semi-bold"><?php echo $user_info->username; ?></span></h4>
              
                       <div class="pull-right">  
                           <a data-original-title="" data-placement="top" data-toggle="tooltip" href="appuser/" id="back-btn" class="btn btn-info"><span class="fa fa-reply"></span> Back</i></a>
                       </div>
                       </div>
                         <div class="grid-body">
                             <div class="col-md-9">    
                       <table class="table table-responsive table-bordered">
                          <tbody>
                            <tr>
                                <td style="width:25% !important;"><b>User Name</b></td>
                              <td><?php echo $user_info->username; ?></td>
                            </tr>
                            <tr>
                                <td style="width:25% !important;"><b>Email</b></td>
                              <td><?php echo $user_info->email; ?></td>
                            </tr>
                            <tr>
                              <td style="width:25% !important;"><b>Phone No.</b></td>
                              <td><?php echo $user_info->phone; ?></td>
                            </tr>
                            <tr>
                                <td style="width:25% !important;"><b>Status</b></td>
                                <td>
                                    <?php  echo status($user_info->activated); ?>
                                    <div class="pull-right">
                                        <?php if($user_info->activated != 1){
                                            $class = 'btn-success';
                                            $value = 'Active User';
                                        }else{
                                            $class = 'btn-danger';
                                            $value = 'Inactive User';
                                        }?>
                                        
                                        <a data-original-title="Payment Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-userid="<?php echo $user_info->id;?>" data-val="<?php echo $user_info->activated;?>" class="btn activation <?php echo $class;?>"><?php echo $value; ?></a>
                                        
                                    </div>
                                </td>
                            </tr>
                          </tbody>
                        </table> 
                             </div>
                             <div class="col-lg-3">
                                 <table class="table table-responsive table-bordered">
                                     <tbody>
                                        <tr>
                                          <td><b>User Profile</b></td>
                                          
                                        </tr>
                                        <tr>
                                          <td><img src="<?php echo IMG_URL.USER_IMG_VIEW_PATH.$user_info->image ;?>" class="img-thumbnail" /></td>
                                        </tr>
                                     </tbody>
                                 </table>
                             </div>
                    </div>    
                    </div>
                </div>
            </div>
        </div>
	<!-- END BASIC FORM ELEMENTS-->	   
    </div>
</div>
