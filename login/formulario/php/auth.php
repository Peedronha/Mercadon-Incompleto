<?php
    include("connection.php");
    if(isset($_POST['verification_code'])){

                  $code = $_POST['verification_code'];

                  date_default_timezone_set('America/Sao_Paulo');
                  $date = date('y-m-d h:i:s');

                  $rs = mysqli_query($con,"UPDATE customer SET aut='1',modified_at = '$date' WHERE verification_code= '$code' AND aut= '0'") or die(mysqli_error($con));

                    if (mysqli_affected_rows($con) == 0)
                    {
                      $message = 'Erro no numero enviado';
                      $response = array("sucess"=>false,"message"=>$message);
                   
                      echo json_encode($response);
                  
                      die("Erro no código de verificação.");
                    }
                    else{
                      include("control.php");
                      $_SESSION['logged'] = true;
                      $_SESSION['aut'] = true;

                      $message = 'Usuario cadastrado com sucesso';
                      $response = array("sucess"=>true,"message"=>$message, "url"=>'http://localhost/Mercadon-v2/Mercadon/login/index.html');
                   
                      echo json_encode($response);
                    } 
                  }             
?>