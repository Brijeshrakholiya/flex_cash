<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "View Flex"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
                
                
                <div class="grid simple horizontal orenge">
                    <div id="container">
                        <div class="grid-title">
                            <h4><span class="semi-bold"><?php echo $flex_info->FlexName; ?></span></h4>
              
                       <div class="pull-right">  
                           <a data-original-title="" data-placement="top" data-toggle="tooltip" href="flexmst/" class="btn btn-info"><span class="fa fa-reply"></span> Back</i></a>
                       </div>
                       </div>
                         <div class="grid-body">
                            <ul class="nav nav-tabs  responsive-tabs panel-heading">
                                <li class="active"><a href="#details"><b><span class="fa fa-pencil-square-o"></span> Flex Details</b></a></li>
                              <li><a href="#joiner"><b><span class="fa fa-users"></span> Flex Joiner</b></a></li>
                              <li><a href="#invitees"><b><span class="fa fa-plus-circle"></span> Flex Invitees</b></a></li>
                              <li><a href="#comments"><b><span class="fa fa-comments-o"></span> User Comments</b></a></li>
                            </ul>
 
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">
                                <table class="table table-responsive table-bordered">
                                      <tbody>
                                        <tr>
                                            <td style="width:25% !important;"><b>Flex Name</b></td>
                                          <td><?php echo $flex_info->FlexName; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Flex Image</b></td>
                                          <td><img src="<?php echo IMG_URL.FLEX_IMG_VIEW_PATH.$flex_info->FlexImageURL ;?>" class="img-thumbnail" /></td>
                                        </tr>
                                        <tr>
                                          <td style="width:25% !important;"><b>Flex Description</b></td>
                                          <td style="font-size:15px !important;"><?php echo $flex_info->FlexDesc; ?></td>
                                        </tr>
                                         <tr>
                                            <td style="width:25% !important;"><b>Flex Category</b></td>
                                          <td><?php echo flex_cat_text($flex_info->FlexCat); ?></td>
                                        </tr>
                                         <tr>
                                            <td style="width:25% !important;"><b>Amount Type</b></td>
                                          <td><?php  echo flex_amount_type_text($flex_info->AmountType); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Amount</b></td>
                                          <td><?php echo $flex_info->Amount; ?></td>
                                        </tr>
                                         <tr>
                                            <td style="width:25% !important;"><b>Max Qty.</b></td>
                                          <td><?php  echo $flex_info->MaxQty; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Goal Qty. </b></td>
                                          <td><?php echo $flex_info->GoalQty; ?></td>
                                        </tr>
                                         <tr>
                                            <td style="width:25% !important;"><b>IS Charged</b></td>
                                          <td><?php  echo flex_is($flex_info->isCharged); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>IS Published</b></td>
                                          <td><?php  echo flex_is($flex_info->isPublished); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Published Date</b></td>
                                          <td><?php echo date('d M Y',strtotime($flex_info->PublishedDate));?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Ends On</b></td>
                                          <td><?php  echo date('d M Y',strtotime($flex_info->EndsOn)); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Flex Type</b></td>
                                          <td><?php  echo flex_type_text($flex_info->FlexType); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25% !important;"><b>Status</b></td>
                                          <td><?php  echo status($flex_info->Status); ?></td>
                                        </tr>
                                      </tbody>
                                    </table> 
                              </div>

                                <div class="tab-pane" id="joiner">
                                <table class="table table-responsive table-bordered">
                                       <thead>
                                           <tr>
                                               <th>No.</th>
                                               <th>Name</th>
                                               <th>Email</th>
                                               <th>Phone No.</th>
                                               <th>Join Date</th>
                                               <th>Details</th>
                                           </tr>
                                       </thead>
                                      <tbody>
                                        <?php
                                        if($join_info != ''){
                                        $cnt = 1;
                                        foreach ($join_info as $join){
                                        ?>
                                        <tr>
                                            <td style="width:8% !important;"><b><?php echo $cnt; ?></b></td>
                                            <td><?php echo $join->username; ?></td>
                                            <td><?php echo $join->email; ?></td>
                                            <td><?php echo $join->phone; ?></td>
                                            <td><?php echo date('d M Y', strtotime($join->JoinDate)); ?></td>
                                            <td style="width:15% !important;">
                                                <div class="tooltip-top">
                                                 <a data-original-title="View Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-id="<?php echo $join->FlexID;?>" data-userid="<?php echo $join->UserID;?>" class="btn btn-xs btn-info btn-equal btn-mini view_user_details"><i class="fa fa-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $cnt++;} }else{?>
                                        <tr>
                                            <td colspan="6">No User Found.</td>
                                        </tr>
                                        <?php }?>
                                      </tbody>
                                    </table> 
                              </div>
                                
                                <div class="tab-pane" id="invitees">
                                    <table class="table table-responsive table-bordered">
                                       <thead>
                                           <tr>
                                               <th>No.</th>
                                               <th>Invite By</th>
                                               <th>Invitee</th>
                                               <th>Invitation Date</th>
                                           </tr>
                                       </thead>
                                      <tbody>
                                        <?php
                                        if($invitee_info != ''){
                                        $cnt = 1;
                                        foreach ($invitee_info as $inv){
                                        ?>
                                        <tr>
                                            <td style="width:8% !important;"><b><?php echo $cnt; ?></b></td>
                                            <td ><?php echo $inv->InviteBy; ?></td>
                                            <td><?php echo $inv->Invitee; ?></td>
                                            <td style="width:12% !important;"><?php echo date('d M Y', strtotime($inv->InvitationDate)); ?></td>
                                        </tr>
                                        <?php $cnt++;} }else{?>
                                        <tr>
                                            <td colspan="6">No Invitation Found.</td>
                                        </tr>
                                        <?php }?>
                                      </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="comments">
                                    <table class="table table-responsive table-bordered">
                                       <thead>
                                           <tr>
                                               <th>No.</th>
                                               <th>User Name</th>
                                               <th>Comment</th>
                                               <th>Comment Date</th>
                                               <th>Is Testimonial</th>
                                           </tr>
                                       </thead>
                                      <tbody>
                                        <?php
                                        if($comment_info != ''){
                                        $cnt = 1;
                                        foreach ($comment_info as $com){
                                        ?>
                                        <tr>
                                            <td style="width:8% !important;"><b><?php echo $cnt; ?></b></td>
                                            <td style="width:12% !important;"><?php echo $com->username; ?></td>
                                            <td><?php echo $com->Comment; ?></td>
                                            <td style="width:12% !important;"><?php echo date('d M Y', strtotime($com->CommentDate)); ?></td>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="checkbox check-success 	">
                                                        <input id="istest_<?php echo $com->CommentID;?>" name="istest_<?php echo $com->CommentID;?>" class="is_testimonial" type="checkbox" value="1" <?php if(isset($comment_info) && $com->IsTestimonial == 1){ echo 'checked="checked"';}?>>
                                                      <label for="istest_<?php echo $com->CommentID;?>"></label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $cnt++;} }else{?>
                                        <tr>
                                            <td colspan="6">No Comments Found.</td>
                                        </tr>
                                        <?php }?>
                                      </tbody>
                                    </table>
                                </div>  
                            </div>
                    </div>    
                    </div>
                </div>
            </div>
        </div>
	<!-- END BASIC FORM ELEMENTS-->	   
    </div>
</div>


<div class="modal fade bs-example-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">User Details</span></h4>
            </div>
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                    <table class="table table-responsive table-bordered" id="model_content_area">
                        
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>