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
    return ($cat == 1) ? 'Sell' : 'Collect';
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

function short_desc($desc, $limit=100, $strip = false) {
    $desc = ($strip == true)?strip_tags($desc):$desc;
    if (strlen ($desc) > $limit) {
        $desc = substr ($desc, 0, $limit - 3);
        return (substr ($desc, 0, strrpos ($desc, ' ')).'...');
    }
    return trim($desc);
}

function get_remaing_days($mydate,$h = 0){
    //Convert to date
    $datestr=$mydate;//Your date
    $date=strtotime($datestr);//Converted to a PHP date (a second count)
    //Calculate difference
    $diff=$date-time();//time returns current time in seconds
    $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
    $hours=round(($diff-$days*60*60*24)/(60*60));

    //Report
    if($h != 1){
        if($days < 0){
            return 'Ended'; 
        }else if($days >= 30){
            return 'Ends '.date('M d',strtotime($mydate));
        }else if($days != 0){
            if($days != 1){
                return "Ends in $days days";
            }else{
                return "Ends in $days day";
            }
        }else{
            return "Ends in $hours hours";
        }
    }else{
        return $hours;
    }
    //die;
}

/**
*
* $field_name => Input file field name.
* $target_folder => Folder path where the image will be uploaded.
* $file_name => Custom thumbnail image name. Leave blank for default image name.
* $thumb => TRUE for create thumbnail. FALSE for only upload image.
* $thumb_folder => Folder path where the thumbnail will be stored.
* $thumb_width => Thumbnail width.
* $thumb_height => Thumbnail height.
*
**/
function image_resize_upload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
    //echo $field_name.'</br>'.$target_folder.'</br>'.$file_name.'</br>'.$thumb_folder.'</br>'.$thumb_width.'</br>'.$thumb_height;die;
    //folder path setup
    $target_path = $target_folder;
    $thumb_path = $thumb_folder;

    //file name setup
    $filename_err = explode(".",$_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    $file_ext = $filename_err[$filename_err_count-1];
    if($file_name != ''){
        $fileName = $file_name.'.'.$file_ext;
    }else{
        $fileName = $_FILES[$field_name]['name'];
    }

    //upload image path
    $upload_image = $target_path.basename($fileName);

    //upload image
    if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
    {
        //thumbnail creation
        if($thumb == TRUE)
        {
            $thumbnail = $thumb_path.$fileName;
            list($width,$height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($file_ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;

                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                    break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }

            imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail,100);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail,100);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail,100);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail,100);
            }

        }

        return $fileName;
    }
    else
    {
        return false;
    }
    
    
}

function random_string($type = 'alnum', $len = 8)
	{
		switch ($type)
		{
			case 'basic':
				return mt_rand();
			case 'alnum':
			case 'numeric':
			case 'nozero':
			case 'alpha':
				switch ($type)
				{
					case 'alpha':
						$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'alnum':
						$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric':
						$pool = '0123456789';
						break;
					case 'nozero':
						$pool = '123456789';
						break;
				}
				return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
			case 'unique': // todo: remove in 3.1+
			case 'md5':
				return md5(uniqid(mt_rand()));
			case 'encrypt': // todo: remove in 3.1+
			case 'sha1':
				return sha1(uniqid(mt_rand(), TRUE));
		}
	}
        
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
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
    
    function cmp($a, $b)
    {
        return strcmp($b->JoinDate,$a->JoinDate);
    }
    
    function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
    {
      // open the directory
      $dir = opendir( $pathToImages );
      
      // loop through it, looking for any/all JPG files:
      while (false !== ($fname = readdir( $dir ))) {
          
        // parse path for the extension
        $info = pathinfo($pathToImages . $fname);
        $file_ext = strtolower($info['extension']);
        // continue only if this is a JPEG image
        switch($file_ext){
                case 'jpg':
                    $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
                    break;
                case 'jpeg':
                    $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
                    break;

                case 'png':
                    $img = imagecreatefrompng("{$pathToImages}{$fname}");
                    break;
                case 'gif':
                    $img = imagecreatefromgif("{$pathToImages}{$fname}");
                    break;
                default:
                    $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
            }
        
        
          $width = imagesx( $img );
          $height = imagesy( $img );

          // calculate thumbnail size
          $new_width = $thumbWidth;
          $new_height = floor( $height * ( $thumbWidth / $width ) );

          // create a new temporary image
          $tmp_img = imagecreatetruecolor( $new_width, $new_height );

          // copy and resize old image into new image 
          imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

          // save thumbnail into a file
          switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($tmp_img,"{$pathToThumbs}{$fname}",100);
                    break;
                case 'png':
                    imagepng($tmp_img,"{$pathToThumbs}{$fname}",100);
                    break;

                case 'gif':
                    imagegif($tmp_img,"{$pathToThumbs}{$fname}",100);
                    break;
                default:
                    imagejpeg($tmp_img,$thumbnail,100);
            }

      }
      // close the directory
      closedir( $dir );
    }

    
    function Thumbnail($url, $path,$filename, $width = 150, $height = 150) {
        // download and create gd image
        $image = ImageCreateFromString(file_get_contents($url));
        
        // calculate resized ratio
        // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
        //$height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
        
        // create image 
        $output = ImageCreateTrueColor($width, $height);
        ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));

        // save image
        ImageJPEG($output, $path.$filename, 100); 

        // return resized image
        return $output; // if you need to use it
   }
?>