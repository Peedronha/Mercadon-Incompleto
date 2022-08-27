<?php
    include('control.php');
    include('connection.php');
    if(isset($_POST['psw_hash'])){
        
            $username = $_POST['user'];
            $psw = $_POST['psw_hash'];  
            $psw2 = $_POST['new_hash'];  
        

            $username = stripcslashes($username);
            $psw = stripcslashes($psw);  
            $psw2 = stripcslashes($psw2);
            $username = mysqli_real_escape_string($con,$username);  
            $psw = mysqli_real_escape_string($con, $psw);  
            $psw2 = mysqli_real_escape_string($con, $psw2);  
        
            $stmt = "SELECT * FROM customer WHERE psw = '$psw' AND username='$username'";

            $result = mysqli_query($con, $stmt) or die(mysqli_error($con));

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            $count = mysqli_num_rows($result);  
            
            if($count == 1){
                $stmt = "UPDATE customer SET psw = '$psw2' WHERE psw = '$psw' AND username='$username'";

                mysqli_query($con, $stmt) or die(mysqli_error($con));

                $message = 'Senha trocada com sucesso';
                $response = array();
                $response['sucess'] = true;
                $response['message'] = $message;
                
                echo $response;
            }  
            else{
                $message = 'Erro ao trocar a senha';
                $response = array();
                $response['sucess'] = false;
                $response['message'] = $message;

                echo $response;
            }
        }
?>