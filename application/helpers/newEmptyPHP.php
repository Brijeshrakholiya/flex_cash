
<?php
/*********************************************************************
     Purpose            : update image.
     Parameters         : null
     Returns            : integer
     ***********************************************************************/
	
    function changeAvatar() {
        
        $post = isset($_POST) ? $_POST: array();
        $max_width = "1180"; 
        $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = FLEX_IMG_VIEW_PATH;
            
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
        $name = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if(strlen($name))
        {
        list($txt, $ext) = explode(".", $name);
        if(in_array($ext,$valid_formats))
        {
        
            $actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
            $filePath = $path .'/'.$actual_image_name;
            $tmp = $_FILES['photoimg']['tmp_name'];
            $type = $_FILES['photoimg']['type'];
           
            if(move_uploaded_file($tmp, $filePath))
            {
                $width = getWidth($filePath);
                $height = getHeight($filePath);
                //Scale the image if it is greater than the width set above
                if ($width > $max_width){
                    $scale = $max_width/$width;
                    $uploaded = resizeImage($filePath,$width,$height,$scale);
                }else{
                    $scale = 1;
                    $uploaded = resizeImage($filePath,$width,$height,$scale);
                }
            /*$res = saveAvatar(array(
                            'userId' => isset($userId) ? intval($userId) : 0,
                                                    'avatar' => isset($actual_image_name) ? $actual_image_name : '',
                            ));*/

            //mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
                echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".base_url().$filePath.'?'.time()."' class='preview'/>";
            }
            else
                echo "failed";
        }
        else
        echo "Invalid file format.."; 
        }
        else
        echo "Please select image..!";
        exit;
        
        
    }
    /*********************************************************************
     Purpose            : update image.
     Parameters         : null
     Returns            : integer
     ***********************************************************************/
     function saveAvatarTmp() {
         
        $post = isset($_POST) ? $_POST: array();
        $userId = isset($post['id']) ? intval($post['id']) : 0;
        $path = base_url().FLEX_IMG_VIEW_PATH;
        $t_width = 300; // Maximum thumbnail width
        $t_height = 300;    // Maximum thumbnail height
        
        if(isset($_POST['t']) and $_POST['t'] == "ajax")
        {
            extract($_POST);

            //$img = get_user_meta($userId, 'user_avatar', true);
            $fileType=explode(".", $_POST['image_name']);
            
            $imagePath = $path.$_POST['image_name'];
            $ratio = ($t_width/$w1); 
           
            $nw = ceil($w1 * $ratio);
            $nh = ceil($h1 * $ratio);
            
            $nimg = imagecreatetruecolor($nw,$nh);
//            switch($fileType) 
//            {
//                case "gif":
//                    $im_src = imagecreatefromgif($imagePath); 
//                    break;
//                case "pjpeg":
//                case "jpeg":
//                case "jpg":
//                    $im_src = imagecreatefromjpeg($imagePath); 
//                    break;
//                case "png":
//                case "x-png":
//                    $im_src = imagecreatefrompng($imagePath); 
//                    break;
//            }
            
            $im_src = imagecreatefromjpeg($imagePath);
            imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
            imagejpeg($nimg,$imagePath,100);

        }
        echo $imagePath;
        exit(0);    
    }
    
    /*********************************************************************
     Purpose            : resize image.
     Parameters         : null
     Returns            : image
     ***********************************************************************/
    function resizeImage($image,$width,$height,$scale) {
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
        //echo $newImage;die;
//        switch($fileType) 
//        {
//            case "image/gif":
//                $source = imagecreatefromgif($image); 
//                break;
//            case "image/pjpeg":
//            case "image/jpeg":
//            case "image/jpg":
//                $source = imagecreatefromjpeg($image); 
//                break;
//            case "image/png":
//            case "image/x-png":
//                $source = imagecreatefrompng($image); 
//                break;
//        }
    
    $source = imagecreatefromjpeg($image);
    imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
    imagejpeg($newImage,$image,90);
    chmod($image, 0777);
    return $newImage;
}
/*********************************************************************
     Purpose            : get image height.
     Parameters         : null
     Returns            : height
     ***********************************************************************/
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/*********************************************************************
     Purpose            : get image width.
     Parameters         : null
     Returns            : width
     ***********************************************************************/
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
?>
