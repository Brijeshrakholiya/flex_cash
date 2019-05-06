<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_services_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_tokenid($id,$TokenID){
        $data = array("TokenID" => $TokenID);
        $this->db->where('id', $id);
        $this->db->update(TBL_USERS, $data);
    }
    
    function update_pass($id,$pass){
        $data = array("password" => $pass);
        $this->db->where('id', $id);
        $this->db->update(TBL_USERS, $data);
        return;
    }
    
    function get_user($username) {
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('*, CONCAT("'.$user_url.'", image) as UserImage');    
        $where = "username ='$username' OR email ='$username'";
        $this->db->where($where);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    /*function user_dtl($id){
        $query = $this->db->get('(SELECT SUM( j.FlexAmt ) AS TotalEarning FROM '.TBL_USER_FLEXJOIN.' j JOIN '.TBL_FLEXMST.' f ON f.FlexID = j.FlexID JOIN '.TBL_USERS.' u ON u.id = f.FlexUserID AND u.id ='.$id.') as TotalEarning,(SELECT Count(UserpaymentDtlID) as IsPayAdd from '.TBL_PAYMENT_DTL.' where UserID = '.$id.')as IsPayAdd,(SELECT Count(UserID) as Followers from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.') as Followers,(SELECT Count(FollowersID) as Following from '.TBL_USER_FOLLOWERS.' where FollowersID = '.$id.') as Following , (SELECT count(FlexID) as CreatFlex from '.TBL_FLEXMST.' where FlexUserID = '.$id.')as CreatFlex ');
        if ($query->num_rows() > 0) {
            if($query->row()->TotalEarning == null)
            {
                $query->row()->TotalEarning = "0";
            }
            if($query->row()->IsPayAdd != 0)
            {
                $query->row()->IsPayAdd = "1";
            }else{
                $query->row()->IsPayAdd = "0";
            }
            return $query->row();
        }
        return NULL;
    }*/
    
    function user_dtl($id){
        $query = $this->db->get('(SELECT SUM( j.FlexAmt ) AS TotalEarning FROM '.TBL_USER_FLEXJOIN.' j JOIN '.TBL_FLEXMST.' f ON f.FlexID = j.FlexID JOIN '.TBL_USERS.' u ON u.id = f.FlexUserID AND u.id ='.$id.') as TotalEarning,(SELECT Count(ID) as IsPayAdd from '.TBL_USER_ACCOUNT.' where UserID = '.$id.')as IsPayAdd,(SELECT Count(UserID) as Followers from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.') as Followers,(SELECT Count(FollowersID) as Following from '.TBL_USER_FOLLOWERS.' where FollowersID = '.$id.') as Following , (SELECT count(FlexID) as CreatFlex from '.TBL_FLEXMST.' where FlexUserID = '.$id.')as CreatFlex ');
        if ($query->num_rows() > 0) {
            if($query->row()->TotalEarning == null)
            {
                $query->row()->TotalEarning = "0";
            }
            if($query->row()->IsPayAdd != 0)
            {
                $query->row()->IsPayAdd = "1";
            }else{
                $query->row()->IsPayAdd = "0";
            }
            return $query->row();
        }
        return NULL;
    }
    
    function get_user_data($userid) {
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('*, CONCAT("'.$user_url.'", image) as UserImage');    
        $this->db->where('id', $userid);
        $query = $this->db->get(TBL_USERS);
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }

    function get_notification($userid) {
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('*,CONCAT("'.$user_url.'", ImageURL) as UserImage');    
	$this->db->where('UserID', $userid);
        $this->db->order_by("NotificationDate", "desc");
        $query = $this->db->get(TBL_NOTIFICATION);
        if ($query->num_rows() > 0) {
            $result = array();
            
            foreach($query->result() as $single){
                $single->NotificationDate = time_elapsed_string($single->NotificationDate);
                if($single->Icon == 'plus-circle'){
                    $single->NotificationName ='Join';
                }else if($single->Icon == 'rss'){
                    $single->NotificationName ='Follow';
                }else if($single->Icon == 'eye-slash'){
                    $single->NotificationName ='Unfollow';
                }else if($single->Icon == 'flag'){
                    $single->NotificationName ='Invitation';
                }else if($single->Icon == 'comments'){
                    $single->NotificationName ='Comment';
                }else if($single->Icon == 'hourglass-end'){
                    $single->NotificationName ='Flex Info';
                }else if($single->Icon == 'money'){
                    $single->NotificationName ='Refund Request';
                }else if($single->Icon == 'signal'){
                    $single->NotificationName ='Goal Reached';
                }else if($single->Icon == 'send'){
                    $single->NotificationName ='Flex End';
                }else if($single->Icon == 'address-book-o'){
                    $single->NotificationName ='Setup Account';
                }else if($single->Icon == 'random'){
                    $single->NotificationName ='Goal Not Reached';
                }else if($single->Icon == 'undo'){
                    $single->NotificationName ='Payment Refunded';
                }else{
                    $single->NotificationName ='Flex';
                } 
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
    }

        function get_flex_list123($uid){
            $date = date('Y-m-d');
            $user_url = IMG_URL.USER_IMG_THUMB_PATH;
            $flex_url = IMG_URL.FLEX_IMG_VIEW_PATH;
            $this->db->select('f.*, u.username, CONCAT("'.$user_url.'", u.image) as UserImage, (SELECT IFNULL(SUM(`j`.`Qty`),0) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As Joiner, (SELECT IFNULL(SUM(`j`.`FlexAmt`),0) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As TotalAmount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments,(SELECT COUNT(`i`.`FlexInviteeID`) from '.TBL_FLEX_INVITEES.' i where i.FlexID = f.FlexID) As Invitee, (SELECT CONCAT("'.$flex_url.'",fi.FlexImageURL) as FlexImage from '.TBL_FLEXMST.' fi where fi.FlexID = f.FlexID) As FlexImage');
            $this->db->join(TBL_USERS.' u', 'f.FlexUserID = u.id');
            $this->db->where('f.FlexType', 1);
            $this->db->where('f.EndsOn >=',$date);
            $this->db->order_by("f.EndsOn", "asc");
            $query = $this->db->get(TBL_FLEXMST.' f');
            echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $result = array();

                foreach($query->result() as $single){
                    $single->Amount = ($single->Amount == NULL)?0:$single->Amount;
                    $single->EndsOn = get_remaing_days($single->EndsOn);
                    $result[] = $single;
                }
                return $result;
            }
            return NULL;
        }
        
    function get_flex_list($uid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $flex_url = IMG_URL.FLEX_IMG_VIEW_PATH;
        $thumb_url = IMG_URL.FLEX_IMG_THUMB_PATH;
       // CONCAT('$thumb_url', fi.FlexImageURL) as FlexThumb
        $date = date('Y-m-d H:i:s');
        $final_query ="SELECT `f`.*, `u`.`username`, CONCAT('$user_url', u.image) as UserImage, (SELECT IFNULL(SUM(`j`.`Qty`), 0) as Joiner from user_flexjoin j where j.FlexID = f.FlexID) As Joiner, (SELECT IFNULL(SUM(`j`.`FlexAmt`), 0) as Joiner from user_flexjoin j where j.FlexID = f.FlexID) As TotalAmount, (SELECT COUNT(`c`.`CommentID`) from user_comment c where c.FlexID = f.FlexID) As Comments, (SELECT COUNT(`i`.`FlexInviteeID`) from flex_invitees i where i.FlexID = f.FlexID) As Invitee, (SELECT CONCAT('$flex_url', fi.FlexImageURL) as FlexImage from flex_mst fi where fi.FlexID = f.FlexID) As FlexImage,(SELECT CONCAT('$thumb_url', fi.FlexImageURL) as FlexThumb from flex_mst fi where fi.FlexID = f.FlexID) As FlexThumb FROM `flex_mst` `f` JOIN `users` `u` ON `f`.`FlexUserID` = `u`.`id` WHERE `f`.`FlexType` = 1 AND `f`.`EndsOn` >= '$date' UNION SELECT `f`.*, `u`.`username`, CONCAT('$user_url', u.image) as UserImage, (SELECT IFNULL(SUM(`j`.`Qty`), 0) as Joiner from user_flexjoin j where j.FlexID = f.FlexID) As Joiner, (SELECT IFNULL(SUM(`j`.`FlexAmt`), 0) as Joiner from user_flexjoin j where j.FlexID = f.FlexID) As TotalAmount, (SELECT  COUNT(`c`.`CommentID`) from user_comment c where c.FlexID = f.FlexID) As Comments, (SELECT COUNT(`i`.`FlexInviteeID`) from flex_invitees i where i.FlexID = f.FlexID) As Invitee, (SELECT CONCAT('$flex_url', fi.FlexImageURL) as FlexImage from flex_mst fi where fi.FlexID = f.FlexID) As FlexImage,(SELECT CONCAT('$thumb_url', fi.FlexImageURL) as FlexThumb from flex_mst fi where fi.FlexID = f.FlexID) As FlexThumb FROM `flex_mst` `f` JOIN `users` `u` ON `f`.`FlexUserID` = `u`.`id` WHERE `f`.`FlexType` = 2 AND `f`.`FlexID` IN (SELECT FlexID from flex_invitees WHERE InviteeID = '$uid') OR `f`.`FlexUserID` = '$uid' AND `f`.`EndsOn` >= '$date' ORDER BY `EndsOn` ASC";
       $query = $this->db->query($final_query);
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $result = array();
            
            foreach($query->result() as $single){
                $single->Amount = ($single->Amount == NULL)?0:$single->Amount;
                $single->EndsOn = get_remaing_days($single->EndsOn);
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
    }    
    
    function get_date_formate($date){
        return get_remaing_days($date);
    }
    
    function get_flex_comments($id){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('c.*,u.username,CONCAT("'.$user_url.'", u.image) as UserImage');
        $this->db->join(TBL_USERS.' u', 'c.UserID = u.id');
        $this->db->where('c.FlexID', $id);
        $query = $this->db->get(TBL_USER_COMMENTS.' c');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
        
    }
    
    function insert_follow_user($data){
        $this->db->select('UserFollowersID as Id');
        $this->db->where('UserID', $data['UserID']);
        $this->db->where('FollowersID', $data['FollowersID']);
        $query = $this->db->get(TBL_USER_FOLLOWERS);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row){
                $this->db->where('UserFollowersID', $row->Id);
                $this->db->delete(TBL_USER_FOLLOWERS);
                return ;
            }
        }else{
            $this->db->insert(TBL_USER_FOLLOWERS, $data);
            return $this->db->insert_id();
        }    
    }
    
    function get_isfollow($uid,$fid){
       $final_query ="SELECT Count(UserFollowersID) as IsFollow from ".TBL_USER_FOLLOWERS." where UserID = $uid and FollowersID = $fid";
       $query = $this->db->query($final_query);
       
        if ($query->num_rows() > 0) {
            if($query->row()->IsFollow != null){
                return $query->row()->IsFollow;
            }else{
                return '0';
            }
        }
        return NULL;
    }
    
    function get_followers($uid){
       $final_query ="SELECT Count(UserFollowersID) as Followers from ".TBL_USER_FOLLOWERS." where UserID = $uid";
       $query = $this->db->query($final_query);
       
        if ($query->num_rows() > 0) {
            if($query->row()->Followers != null){
                return $query->row()->Followers;
            }else{
                return '0';
            }
        }
        return NULL;
    }
    
    function create_flex_api($data){
         $this->db->insert(TBL_FLEXMST, $data);
        return $this->db->insert_id();
    }
    
    function get_my_followig($id){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
         $this->db->select('f.*, u.username,CONCAT("'.$user_url.'", u.image) as UserImage');
        $this->db->join(TBL_USERS.' u', 'f.UserID = u.id');
        $this->db->where('f.FollowersID', $id);
        $query = $this->db->get(TBL_USER_FOLLOWERS.' f');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
	
	function get_my_followers($id){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
         $this->db->select('f.*, u.username,CONCAT("'.$user_url.'", u.image) as UserImage');
        $this->db->join(TBL_USERS.' u', 'f.FollowersID = u.id');
        $this->db->where('f.UserID', $id);
        $query = $this->db->get(TBL_USER_FOLLOWERS.' f');
        if ($query->num_rows() > 0) {
            $result = array();

            foreach($query->result() as $single){
                $single->IsFollow = $this->user_model->get_is_follow($single->FollowersID,$id);
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
    }
    
    function get_userdtl($id,$uid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('u.id,u.username,u.email,u.phone,(SELECT SUM( j.FlexAmt ) AS Amount FROM '.TBL_USER_FLEXJOIN.' j JOIN '.TBL_FLEXMST.' f ON f.FlexID = j.FlexID JOIN '.TBL_USERS.' u ON u.id = f.FlexUserID AND u.id ='.$id.') as Amount,(SELECT Count(UserFollowersID) from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.' and FollowersID = '.$uid.') As IsFollow,(SELECT Count(UserID) from '.TBL_USER_FOLLOWERS.' where FollowersID = '.$id.') as Following,(SELECT Count(FollowersID) from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.') as Followers, (SELECT count(FlexID) from '.TBL_FLEXMST.' where FlexUserID = '.$id.') as CreatFlex,(SELECT CONCAT("'.$user_url.'",ui.image) as UserImage from '.TBL_USERS.' ui where ui.id = u.id) As UserImage');
        $this->db->where('u.id', $id);
        $query = $this->db->get(TBL_USERS.' u');
//        echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {
//            if($query->row()->IsFollow != '')
//            {
//                $query->row()->IsFollow = "1";
//            }else{
//                $query->row()->IsFollow = "0";
//            }
            
            if($query->row()->Amount == null){
                $query->row()->Amount = "0";
            }
            return $query->result();
        }
        return NULL;
    }
    
    function join_user_list($fid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
         $this->db->select('j.*, u.username,CONCAT("'.$user_url.'", u.image) as UserImage');
        $this->db->join(TBL_USERS.' u', 'j.UserID = u.id');
        $this->db->where('j.FlexID', $fid);
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
	
    function get_userflex_join_list($userid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
		$flex_url = IMG_URL.FLEX_IMG_THUMB_PATH;
        $this->db->select('j.*,DATE_FORMAT(j.JoinDate,"%m/%d/%Y")as JoinDate, u.username,CONCAT("'.$user_url.'", u.image) as UserImage,f.FlexName,f.FlexCat,f.EndsOn,CONCAT("'.$flex_url.'", f.FlexImageURL) as FlexImage');
        $this->db->join(TBL_USERS.' u', 'j.UserID = u.id');
        $this->db->join(TBL_FLEXMST.' f', 'f.FlexID = j.FlexID');
        $this->db->where('j.UserID', $userid);
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
	

    function get_userflex_list($userid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $flex_url = IMG_URL.FLEX_IMG_THUMB_PATH;
         $this->db->select('f.*,CONCAT("'.$flex_url.'", f.FlexImageURL) as FlexImage,u.*,CONCAT("'.$user_url.'", u.image) as UserImage,(SELECT IFNULL(SUM(`j`.`Qty`),0) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As Joiner,(SELECT IFNULL(SUM(`j`.`FlexAmt`),0) as TotalAmount from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As TotalAmount,(SELECT COUNT(`i`.`FlexInviteeID`) from '.TBL_FLEX_INVITEES.' i where i.FlexID = f.FlexID) As Invitee,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments');
        $this->db->join(TBL_USERS.' u', 'f.FlexUserID = u.id'); 	
        $this->db->where('f.FlexUserID', $userid);
		$this->db->order_by("f.CreatedOn", "asc");
        $query = $this->db->get(TBL_FLEXMST.' f');
	if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $single){
                $single->TotalAmount = ($single->TotalAmount == NULL)?0:$single->TotalAmount;
                $single->Invitee = ($single->Invitee == NULL)?0:$single->Invitee;
                $single->Amount = ($single->Amount == NULL)?0:$single->Amount;
                $single->EndsOn = get_remaing_days($single->EndsOn);
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
    }


    function invitee_user_list($fid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
		
        $this->db->select('i.*, u.username as InviteBy,CONCAT("'.$user_url.'", u.image) as InviteByImage, ui.username as Invitee,CONCAT("'.$user_url.'", ui.image) as InviteeImage');
        $this->db->join(TBL_USERS.' u', 'i.InviteByID = u.id');
        $this->db->join(TBL_USERS.' ui', 'i.InviteeID = ui.id');
        $this->db->where('i.FlexID', $fid);
        $query = $this->db->get(TBL_FLEX_INVITEES.' i');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function flex_user_comment($data){
        $this->db->insert(TBL_USER_COMMENTS, $data);
        return $this->db->insert_id();
    }
	function update_user_profile($data, $id) {
        $this->db->where('id', $id);
        $this->db->update(TBL_USERS, $data);
        return $id;
    }	
    
    function add_temp_que($data){
        $this->db->insert(TBL_TEMP_QUESTION, $data);
        return $this->db->insert_id();
    }
    
    function get_user_activity($id){
        $flex_url = IMG_URL.FLEX_IMG_THUMB_PATH;
        $final_query ="(SELECT f.FlexName, u.username, f.CreatedOn,CONCAT('".$flex_url."', f.FlexImageURL) as FlexImage ,'Create' as act_type FROM flex_mst f JOIN users u ON f.FlexUserID = u.id WHERE u.id = $id ORDER by f.FlexID desc) union all (SELECT f.FlexName, u.username, uf.CreatedOn, CONCAT('".$flex_url."', f.FlexImageURL) as FlexImage,'Join' as act_type FROM user_flexjoin uf JOIN users u ON uf.UserID = u.id join flex_mst f ON uf.FlexID = f.FlexID WHERE u.id = $id ORDER BY uf.UserFlexID desc) UNION all (SELECT f.FlexName, u.username, uc.CreatedOn, CONCAT('".$flex_url."', f.FlexImageURL) as FlexImage,'Comment' as act_type FROM user_comment uc JOIN users u ON uc.UserID = u.id join flex_mst f ON uc.FlexID = f.FlexID WHERE u.id = $id) ORDER BY `CreatedOn` DESC";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
/*   function get_question($id){
        $this->db->select('*');
        $this->db->where('FlexID', $id);
        $this->db->order_by("Qorder", "asc");
        $query = $this->db->get(TBL_FLEX_QUESTION);
        
        if ($query->num_rows() > 0) {
            $cnt = 1;
            foreach($query->result() as $row){
                $result = $row;
                if($row->Qtype == 2){
                    $option = $this->get_option($row->FlexQID);
                    $result->sub = $option;
                }
                $cnt++;
            }
            return $result;
        }
        return NULL;
    } */
   
   /*function get_question($id){
        $this->db->select('*');
        $this->db->where('FlexID', $id);
        $this->db->order_by("Qorder", "asc");
        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
			
            return $query->result_array();
        }
        return NULL;
    }
    
     function get_option($id){
         $this->db->select('*');
         $this->db->where('FlexQueID', $id);
         $this->db->order_by("OptOrder", "asc");
         $query = $this->db->get(TBL_FLEX_OPTION);
         if ($query->num_rows() > 0) {
            return $query->result();
         }
         return NULL; 
    } */


	function get_question($id){
        $this->db->select('*');
        $this->db->where('FlexID', $id);
        $this->db->order_by("Qorder", "asc");
        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
            $cnt = 0;
            foreach($query->result() as $row){
                $result[] = $row;
                if($row->Qtype == 2){
                    $option = $this->get_option($row->FlexQID);
                    $result[$cnt]->sub = $option;
                }
                $cnt++;
            }
            return $result;
        }
        return NULL;
    }
    
     function get_option($id){
         $this->db->select('*');
         $this->db->where('FlexQueID', $id);
         $this->db->order_by("OptOrder", "asc");
         $query = $this->db->get(TBL_FLEX_OPTION);
         if ($query->num_rows() > 0) {
            return $query->result();
         }
         return NULL; 
    } 
    
    function check_app_social_login($email) {
        $this->db->select("*");
        $this->db->where('LOWER(email)=', strtolower($email));

        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() == 1)
            return $query->row();
        return NULL;
    }
    
    function check_email_id($email = '') {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function app_client($data) {
        $this->db->insert(TBL_USERS, $data);
        return $this->db->insert_id();
    }
	
	function get_flex_details($id,$userid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $flex_url = IMG_URL.FLEX_IMG_VIEW_PATH;
        
        $this->db->select('f.*,CONCAT("'.$flex_url.'", f.FlexImageURL) as FlexImage,u.*,CONCAT("'.$user_url.'", u.image) as UserImage,(SELECT SUM(`j`.`Qty`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As Joiner,(SELECT SUM(`j`.`FlexAmt`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As TotalAmount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments,(SELECT COUNT(`i`.`FlexInviteeID`) from '.TBL_FLEX_INVITEES.' i where i.FlexID = f.FlexID) As Invitee');
        //$this->db->where('f.Status', 1)
        $this->db->join(TBL_USERS.' u', 'f.FlexUserID = u.id');
        $this->db->where('f.FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST.' f');
        if ($query->num_rows() > 0) {
            if($query->row()->id == $userid)
            {
                $query->row()->IsSelf = "1";
            }else{
                $query->row()->IsSelf = "0";
            }
            if($query->row()->Joiner == null){
                $query->row()->Joiner = "0";
            }
            if($query->row()->Invitee == null){
                $query->row()->Invitee = "0";
            }
            if($query->row()->TotalAmount == null){
                $query->row()->TotalAmount = "0";
            }
            $query->row()->EndsOn = get_remaing_days($query->row()->EndsOn);
            return $query->row();
        }
        return NULL;
    }
	
    function get_user_img($id){
        $this->db->select('image');
        $this->db->where('id', $id);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_user_carddtl($id){
        $this->db->select('*');
        $this->db->where('UserID', $id);
        $query = $this->db->get(TBL_PAYMENT_DTL);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function invite_user($id,$fid){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        
        $final_query ="SELECT `u`.*,CONCAT('".$user_url."', u.image) as UserImage FROM `users` `u` WHERE (`id` IN (SELECT DISTINCT f.UserID FROM user_followers f WHERE `f`.`FollowersID` = $id ) OR `id` IN (SELECT DISTINCT f.FollowersID FROM user_followers f WHERE `f`.`UserID` = $id )) AND `id` NOT IN (SELECT UserID from user_flexjoin where FlexID = $fid) ORDER BY username ASC";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function is_account_add($id){
        $this->db->select('ID');
        $this->db->where('UserID', $id);
        $query = $this->db->get(TBL_USER_ACCOUNT);
        if ($query->num_rows() > 0) {
            return 1;
        }
        return 0;
    }
    
    function get_money_out($id){
        $flex_url = FLEX_IMG_THUMB_PATH;
        $this->db->select('FlexID,UserID,JoinDate,FlexAmt,TxAmt,Qty,TransactionID');
        $this->db->where('UserID', $id);
        $this->db->order_by("JoinDate", "desc");
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $row){
                $row->FlexName = $this->user_model->get_flexname($row->FlexID);
                $row->Image = $this->get_fleximage($row->FlexID);
                $row->FlexAmt = $row->TxAmt;
                $result[] = $row;
            }
            return $result;
        }
        return array();
    }
    
    function get_money_in($id){
        $this->db->select('FlexID');
        $this->db->where('FlexUserID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            
            $result = array();
            foreach($query->result() as $row){
                $new = $this->money_in_dtl($row->FlexID);
                foreach($new as $single){
                    $result[] = $single;
                }
            }
            usort($result, "cmp");
            return $result;
        }
        return array();
    }    
    
    function money_in_dtl($id){
        $this->db->select('FlexID,UserID,JoinDate,FlexAmt,Qty,TransactionID');
        $this->db->where('FlexID', $id);
        $this->db->order_by("JoinDate", "desc");
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $row){
                $row->FlexName = $this->user_model->get_flexname($row->FlexID);
                $row->Image = $this->get_fleximage($row->FlexID);
                $result[] = $row;
            }
            return $result;
        }
        return array();
    }
    
    function get_fleximage($id){
        $flex_url = IMG_URL.FLEX_IMG_VIEW_PATH;
        $this->db->select('CONCAT("'.$flex_url.'",FlexImageURL) as FlexImage');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
           return $query->row()->FlexImage;
        }
    }
    
    function get_all_money($id){
        $row[0] = $this->get_money_in($id);
        $row[1] = $this->get_money_out($id);
        $new = $row;
        foreach($new[0] as $single){
            $single->type = 1;
            $result[] = $single;
        }
        foreach($new[1] as $single){
            $single->type = 2;
            $result[] = $single;
        }
        
       usort($result, "cmp");
    
       return $result;
    }
}    