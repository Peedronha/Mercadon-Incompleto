<?php
include("login/formulario/php/connection.php");
              $stmt = 'SELECT img_dir, img_name from products';
            
              mysqli_query($con, $stmt) or die(mysqli_error($con));

              $response = array("sucess" => true, "message" => $file_array[$i]['name']. '-' .$php_errormsg[$file_array[$i]['error']]);                return json_encode($response);
                
              return json_encode($response);             
?>