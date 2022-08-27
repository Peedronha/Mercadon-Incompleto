<?php
include("connection.php");
$php_errormsg = array(
    0 => 'Sucess',
    1 => 'File exceeds the maximum size in php.ini',
    2 => 'File exceeds MAX_FILE_SIZE specified int the html form',
    3 => 'File partially uploaded',
    4 => 'No file was uploaded',
    5 => 'Missing a tempory folder',
    6 => 'Failed to write file to disk',
    7 => 'A PHP extension stopped the file upload',
);
if(isset($_FILES['file'])){
      $extensions = array('jpeg', 'jpg', 'png');
      $path = 'local/'; 
      
      $img = $_FILES['image']['name'];
      $tmp = $_FILES['image']['tmp_name'];


      $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

      $final_image = rand(1000,1000000).$img;
    
      if(in_array($ext, $valid_extensions)) { 
      $path = $path.strtolower($final_image); 
        if(move_uploaded_file($tmp,$path)) {
          $response = array("sucess" => true, "message" => $file_array[$i]['name']. '-' .$php_errormsg[$img['error']]);                
              
            return json_encode($response);
    
            $stmt ="INSERT INTO products (ProductImage) VALUES ('$path')";

            mysqli_query($con, $stmt)or die(mysqli_error($con));

        }
  } 

}        
    
?>