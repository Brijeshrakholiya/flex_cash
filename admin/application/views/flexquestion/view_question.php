<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "View Question"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid simple horizontal orenge">
                    <div id="container">
                        <div class="grid-title">
                                <h4><span class="semi-bold"><?php echo $que_info->QuestionText; ?></span></h4>
              
                       <div class="pull-right">  
                           <a data-original-title="" data-placement="top" data-toggle="tooltip" href="flexquestion/" class="btn btn-info"><span class="fa fa-reply"></span> Back</i></a>
                       </div>
                       </div>
                         <div class="grid-body">
                       <table class="table table-responsive table-bordered">
                          <tbody>
                            <tr>
                                <td style="width:25% !important;"><b>Question</b></td>
                              <td><?php echo $que_info->QuestionText; ?></td>
                            </tr>
                            <tr>
                                <td style="width:25% !important;"><b>Question Type</b></td>
                              <td><?php echo question_type_text($que_info->Qtype); ?></td>
                            </tr>
                            <?php 
                                if(isset($opt_info) && $opt_info != ''){
                                    $cnt = 1;
                                    foreach($opt_info as $opt){?>
                                        <tr>
                                            <td style="width:25% !important;"><b>Option <?php echo $cnt;?></b></td>
                                            <td><?php echo $opt->FlexOption; ?></td>
                                        </tr>
                                <?php    $cnt++;}
                                }
                            ?>
                            <tr>
                              <td style="width:25% !important;"><b>Question Order</b></td>
                              <td><?php echo $que_info->Qorder; ?></td>
                            </tr>
                            <tr>
                                <td style="width:25% !important;"><b>Is Required</b></td>
                              <td><?php  echo flex_is($que_info->isRequired); ?></td>
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
