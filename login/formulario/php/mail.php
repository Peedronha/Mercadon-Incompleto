<?php

include('control.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(); 

    $email = $_SESSION['email'];
    
                $message =  '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">'
                    . '<div style="margin:50px auto;width:70%;padding:20px 0">'
                    . '<div style="border-bottom:1px solid #eee">'
                    . '<a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">MercadON</a>'
                    . '</div>'
                    . '<p style="font-size:1.1em">Olá,</p>'
                    . '<p>Abaixo está seu codigo de verificação.</p>'
                    . '<a href="http://localhost/Mercadon-v2/Mercadon/login/formulario/auth.html?email='.$_SESSION['email'].'" style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px; text-decoration: none;">' . strval($_SESSION['verification_code']);'</h2>'
                    . '<p>MercadON</p>'
                    . '<hr style="border:none;border-top:1px solid #eee" />'
                    . '<div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">'
                    . '</div>'
                    . '</div>'
                    . '</div>';


                        // Configuração
                        $mail->Mailer = "smtp";
                        $mail->IsSMTP();
                        $mail->CharSet = 'UTF-8';
                        $mail->SMTPDebug = 0;
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'tls';
                        $mail->Host = '	smtp-mail.outlook.com';
                        $mail->Port = 587;

                        // Detalhes do envio de E-mail
                        $mail->Username = 'suporte.mercadon@outlook.com';
                        $mail->Password = 'wasdqer123';
                        $mail->SetFrom('suporte.mercadon@outlook.com', 'mercadON');
                        $mail->addAddress($_SESSION['email'], '');
                        $mail->Subject = "Código de Autenticação MercadON";
                        $mail->msgHTML($message);
                        
                        if($mail->send()){
                            $message = 'Email enviado para ' . $_SESSION['email'];
                    
                            $response = array("sucess" => true, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/login/formulario/auth.html');
                            
                            echo json_encode($response);

                        }
                        else{
                            $message = $mail->ErrorInfo;
                    
                            $response = array("sucess" => false, "message" => $message, "url" => 'http://localhost/Mercadon-v2/Mercadon/login/formulario/index.html');
                            
                            echo json_encode($response);
                        }             
?>
