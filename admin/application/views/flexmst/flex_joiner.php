<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Flex Joiner"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid simple horizontal orenge">
                    <div id="container">
                        <div class="grid-title">
                            <h4><span class="semi-bold"><?php  echo $flex_name->FlexName; ?></span></h4>
              
                       <div class="pull-right">  
                           <a data-original-title="" data-placement="top" data-toggle="tooltip" href="<?php echo base_url();?>flexmst/" class="btn btn-info"><span class="fa fa-reply"></span> Back</i></a>
                       </div>
                       </div>
                         <div class="grid-body">
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