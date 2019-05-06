<?php



function success_elements() {
    return array('<div class="alert alert-block alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button>', '</div>');
}

function error_elements() {
    return array('<div class="alert alert-block alert-danger fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button>', '</div>');
}

function date_formated($date) {
    return date("d-m-Y", strtotime($date));
}

function permission_text($active) {
    return ($active == 1) ? 'Active' : 'Inactive';
}

function flex_type_text($type) {
    return ($type == 1) ? 'Public' : 'Private';
}

function flex_cat_text($cat) {
    return ($cat == 1) ? 'Sell' : 'Collection';
}

function flex_amount_type_text($amount_type) {
    if($amount_type == 1) { 
        return 'Any'; 
    }else if($amount_type == 2){
        return 'Exact';
    }else{
        return 'Atleast';
    }
}

function flex_is($val){
    return ($val == 1) ? 'YES' : 'NO';
}

function flex_get_img($url){
    return '<img src="'.IMG_URL.FLEX_IMG_VIEW_PATH.$url.'" class="img-thumbnail" width="50" height="40" />';
}

function question_type_text($type){
    return ($type == 1) ? 'Text' : 'Multiple';
}

function status($val){
    return ($val == 1) ? 'Active' : 'Inactive';
}

function pay_type($type){
    if($type == 1) { 
        return 'Apple Pay'; 
    }else if($type == 2){
        return 'Credit Card';
    }else{
        return 'Debit Card';
    }
}

function change_date_formate($date){
    if(!empty($date)) {
        return date("d M Y", strtotime($date));
    }
}

function change_status_formate($val){
    if($val == 1){
        return '<p style="color:#3c763d;"><b>Approved</b></p>';
    }else if ($val == 2){
        return '<p class="text-danger"><b>Denied</b></p>';
    }else{
        return '<p class="text-warning"><b>Pending</b></p>';
    }
}

function one_singal_notification($playerIds,$msg) {
        
        $key='ZTYxZTM2NzYtMmFhMi00MzUwLWI3NjgtZDkwNTM1Y2E4OTc5';
        $message = $msg;
        
        $title='FlexCash';
        $ids = array($playerIds);
        $content = array(
            "en" => $message,
            "title" => $title,
            "message" => $msg,    
        );
        $fields = array(
            'app_id' => "99a8ded3-9a16-40ed-bbfd-d8bc200e77bf",
           // 'included_segments' => array('All'),
           
            'large_icon' =>"ic_launcher.png",
            'small_icon' =>"ic_launcher_small.png",
            'include_player_ids'=>  $ids,
            'contents' => $content

            
        );
        
        $fields = json_encode($fields);
        //var_dump($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $response = curl_exec($ch);
        curl_close($ch);
        //print("\nJSON sent:\n");
    	//print($response);
        return $response;
    }



?>