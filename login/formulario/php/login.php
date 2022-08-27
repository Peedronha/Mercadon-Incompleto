<?php
    include("connection.php");
    if(isset($_POST['user'])){

            $username = $_POST['user'];  
            $password = $_POST['senha_hash'];  
        
            $username = stripcslashes($username);  
            $password = stripcslashes($password);  
            $username = mysqli_real_escape_string($con, $username);  
            $password = mysqli_real_escape_string($con, $password);  
        
            $stmt = "SELECT * FROM customer WHERE CustomerName = '$username' AND CustomerPassword = '$password'";

            $result = mysqli_query($con, $stmt) or die(mysqli_error($con));

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            $count = mysqli_num_rows($result);  
            
            if($count==1){
                
                include("control.php");

                /*if ($row["access_level"]== true) {
                    $_SESSION['acess_level'] == 1;
                }
                else{
                    $_SESSION['acess_level'] == 0;
                }*/

                $_SESSION['username'] = $username;
                $_SESSION['psw'] = $password;

                $stmt = "UPDATE customer SET active = '1' WHERE CustomerName = '$username' AND CustomerPassword = '$password'";

                mysqli_query($con, $stmt) or die(mysqli_error($con));

                $_SESSION['logged'] = true;

                $_SESSION['acess_level'] = 1;

                $acess = $_SESSION['acess_level'];
                //Mercadon\admin\index.html

                $message = 'Usuario logado com sucesso';
                if( $_SESSION['acess_level'] == 1){
                    $response = array("sucess" => true, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/admin/index.html');
                }
                else{
                    $response = array("sucess" => true, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/index2.html');
                }
    
                echo json_encode($response);
            }  
            else{

                $message = 'Usuário e/ou senha incorretos';
                $response = array( "sucess" => false, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/login/index.html');

                echo json_encode($response);  
            }
        }
?>