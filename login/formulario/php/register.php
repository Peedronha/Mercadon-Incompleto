<?php
    include('control.php');
    include('connection.php');
    if(isset($_POST['message'])){

            error_reporting(0);
            $criptografia = $_POST["message"];
        
            $chave = "1234567887654321";
            $iv = "1234567890";
        
            $mensagem_decrypt = openssl_decrypt($criptografia, 'aes-128-cbc', $chave,  OPENSSL_ZERO_PADDING, $iv);

            $var = json_decode($mensagem_decrypt);
            
            

            $_SESSION['verification_code'] = random_int(1000, 9999);
            $_SESSION['aut'] = false;

            $username = $var['user'];  
            $password = $var['senha_hash'];
            $email = $var['email'];  
            $cpf = $var['cpf'];

            date_default_timezone_set('America/Sao_Paulo');
            $date = date('y-m-d h:i:s');

            $username = stripcslashes($username);  
            $psw = stripcslashes($password);
            $email= stripslashes($email);  
            $username = mysqli_real_escape_string($con, $username);  
            $password = mysqli_real_escape_string($con, $password); 
            $email = mysqli_real_escape_string($con, $email);

            $stmt = "SELECT CustomerName,CustomerEmail FROM customer WHERE CustomerName='$username' AND CustomerEmail='$email'";

            $rs = mysqli_query($con, $stmt)or die(mysqli_error($con)); 

                    if (mysqli_affected_rows($con) == 0){

                        $_SESSION['username'] = $var['user'];
                        $_SESSION['email'] = $var['email'];
                        $_SESSION['psw'] = $var['senha_hash'];
                        $_SESSION['cpf'] = $var['cpf'];

                        $verification_code = $_SESSION['verification_code'];

                        $stmt = "INSERT INTO customer (CustomerName, CustomerEmail, CustomerPassword,  verification_code, aut, active,acess_level, created_at) VALUES ('$username', '$email', '$password', '$verification_code', 0, 0, 0, '$date')";

                        $rs = mysqli_query($con, $stmt)or die(mysqli_error($con)); 
                        
                        if($_SESSION['aut'] == false){
                            include_once('mail.php');
                        }
                    }
                    else{

                      $message = 'Usuario já cadastrado';
                      $response = array("sucess" => false, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/login/index.html');
                   
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

