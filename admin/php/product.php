<?php
include('connection.php');
if(isset($_POST['full_name'])){

            $p_name= $_POST['full_name'];  
            $price = $_POST['price'];
            $message = $_POST['message'];
            $s_price = $_POST['salePrice'];
            $qtd = $_POST['qtd'];
            $description = $_POST['message'];


            date_default_timezone_set('America/Sao_Paulo');
            $date = date('y-m-d h:i:s');

            $p_name = stripcslashes($p_name);  
            $message = stripcslashes($message);
            $username = mysqli_real_escape_string($con, $p_name);  
            $password = mysqli_real_escape_string($con, $message); 


            $stmt = "INSERT INTO product (ProductName, ProductDesc, ProductPrice, ProductSalePrice,ProductStock, ProductCategory, created_at) VALUES ('$p_name', '$message', '$price', '$s_price', '$qtd', 0, '$date')";

            $rs = mysqli_query($con, $stmt)or die(mysqli_error($con)); 
                        
             if(mysqli_affected_rows($con)>0){
                $message = 'Produto cadastrado';
                $response = array("sucess" => true, "message" => $message);
             
                echo json_encode($response);
            }       
            else{
                $message = 'Falha no cadastro';
                $response = array("sucess" => false, "message" => $message);
                   
                echo json_encode($response);
                } 
    }
    else{
        $response = array();
        $response['sucess'] = false;
        $response['message'] = "http/1.1 404 Not Found";
        echo json_encode($response);
    }
?>