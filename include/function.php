<?php                                                           

date_default_timezone_set('Asia/Kolkata');
//header( 'Content-Type: text/html; charset=utf-8' );
include('config.php');
include('queries.php');

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function to_prety_url($str){
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
}
function site_url(){
	//return 'http://viraltrack.newstracklive.in';
	return 'https://'.$_SERVER['HTTP_HOST'].'/';
	
}
function admin_url(){
	return site_url().'agency/';

}
function ajax_url(){
	return site_url().'admin/ajax/';
}
function debug($val){
	switch (gettype($val)) {
		case 'string':
			echo $val;
		break;
		case 'array':
			echo "<pre>";
			print_r($val);
			echo "</pre>";
		break; 
		case 'object':
			echo "<pre>";
			var_dump($val);
			echo "</pre>";
		break;
		default:
			echo $val;
		break;
	}
}
function upload_dir(){
	$upload['url'] = site_url().'uploads/';
	$upload['path'] = dirname(__DIR__).'/uploads/';
	return $upload;
}
function handle_media($file_tmp,$ext,$path=""){
	$upload = upload_dir();
	$generate_media_name = generateRandomString();
	$file_name = $generate_media_name.time().'.'.$ext;
	if(move_uploaded_file($file_tmp,$upload['path'].$path.$file_name)){
		return "uploads/".$path.$file_name;
	}
	return false;
}

function current_user_id(){
	if(isset($_SESSION['loginId'])){
	
		return $_SESSION['loginId'];
	}else{
		return false;
	}		
}

function check_user_status(){
	if(current_user_id()){
		return true;
	}else{
		header("Location:".users_url()."login");
	}		
}

function current_admin_id(){
	if(isset($_SESSION['adminId'])){
		return $_SESSION['adminId'];
	}else{
		return false;
	}		
}

function check_admin_status(){
	if(!current_admin_id()){
                header("loaction:".admin_url());                       
	}else{
              return true;                    
          }		
}



function current_page_url(){
	$pageURL = 'http';
    $pageURL .= "://";
    $pageURL .="localhost/massivepay/" ;
    return $pageURL;
}

function currentFileName(){
    $pageName = '';
    if(current_page_url() == site_url()){
        $pageName = '/';
    }
    else{
       $pageArray = explode('/',$_SERVER['SCRIPT_NAME']);
	   $pageName=end($pageArray);
    }
    return $pageName;
}

function sendmail($to,$subject,$message,$header){
        
        $headers = "MIME-Version: 1.0 \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .=$header."\r\n";
		$headers .= "Content-Type: multipart/mixed;\r\n\r\n"; 
	  	if(mail($to,$subject,$message,$headers)){
            return true;
	  	}else{
	  		return false;
	  	}
}
function createThumbnail($filename) {
     
    //require 'config.php';
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = imagecreatefromjpeg($path_to_image_directory . $filename);
    } else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($path_to_image_directory . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($path_to_image_directory . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = $final_width_of_image;
    $ny = floor($oy * ($final_width_of_image / $ox));
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    if(!file_exists($path_to_thumbs_directory)) {
      if(!mkdir($path_to_thumbs_directory)) {
           die("There was a problem. Please try again!");
      } 
       }
 
    imagejpeg($nm, $path_to_thumbs_directory . $filename);
    $tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';
    $tn .= '<br />Congratulations. Your file has been successfully uploaded, and a      thumbnail has been created.';
    echo $tn;
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
function is_mobile(){

    $useragent=$_SERVER['HTTP_USER_AGENT'];

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

      return '1';//mobile

    }

    return '0';

  }
?>