<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer(true); // Habilita excepciones

        try {
            // Configuración del servidor SMTP
             $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'acaaveir@gmail.com';
            $mail->Password = 'xtuhknqbkweusrjz'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port =587;

            // Remitente y destinatario
            $mail->setFrom('acaaveir@gmail.com', 'Workspace');
            $mail->addAddress($this->email, $this->nombre);

            // Asunto y contenido
            $mail->Subject = 'Confirma tu cuenta';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $url = BASE_URL . "confirmar?token=" . $this->token;
$contenido = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reestablecer Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="
                font-size: 32px;
                background: linear-gradient(to right, #7C3AED 40%, #00de00 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin: 0;
            ">
                WORKSCAPE
            </h1>
        </div>

        <h2 style="color: #333;">Hola ' . htmlspecialchars($this->nombre) . ',</h2>
        <p style="font-size: 16px;">
            Has solicitado confirmar su Usuario. Para continuar con el proceso, por favor haz clic en el siguiente botón:
        </p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="' . BASE_URL . '/confirmar?token=' . urlencode($this->token) . '" 
               style="background-color:rgb(79, 53, 123); color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; display: inline-block; font-size: 16px;">
                Confirmar Usuario
            </a>
        </p>
        <p style="font-size: 14px; color: #666;">
            Si tú no solicitaste este cambio, puedes ignorar este correo. Tu contraseña permanecerá sin cambios.
        </p>
        <hr style="margin: 30px 0;">
        <p style="font-size: 12px; color: #aaa; text-align: center;">
            © ' . date("Y") . ' WORKSCAPE. Todos los derechos reservados.
        </p>
    </div>
</body>
</html>
';

$mail->Body = $contenido;

$mail->send();


        } catch (Exception $e) {
            error_log('Error al enviar correo: ' . $mail->ErrorInfo);
        }
    }

   public function reestrablecerPassword(){
    $mail = new PHPMailer(true); 

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'acaaveir@gmail.com';
            $mail->Password = 'weuolspenlultbfe'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port =587;


        // Remitente y destinatario
         $mail->setFrom('acaaveir@gmail.com', 'Workspace');
        $mail->addAddress($this->email, $this->nombre);

        // Asunto y contenido
        $mail->Subject = 'Reestablecer Password';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

      
$contenido = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reestablecer Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        
        <!-- Logo simulado con texto y degradado -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="
                font-size: 32px;
                background: linear-gradient(to right, #7C3AED 40%, #00de00 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin: 0;
            ">
                WORKSCAPE
            </h1>
        </div>

        <h2 style="color: #333;">Hola ' . htmlspecialchars($this->nombre) . ',</h2>
        <p style="font-size: 16px;">
            Has solicitado restablecer tu contraseña. Para continuar con el proceso, por favor haz clic en el siguiente botón:
        </p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="' . BASE_URL . 'reestablecer?token=' . urlencode($this->token) . '" 
               style="background-color: #7C3AED; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; display: inline-block; font-size: 16px;">
                Reestablecer contraseña
            </a>
        </p>
        <p style="font-size: 14px; color: #666;">
            Si tú no solicitaste este cambio, puedes ignorar este correo. Tu contraseña permanecerá sin cambios.
        </p>
        <hr style="margin: 30px 0;">
        <p style="font-size: 12px; color: #aaa; text-align: center;">
            © ' . date("Y") . ' WORKSCAPE. Todos los derechos reservados.
        </p>
    </div>
</body>
</html>
';

$mail->Body = $contenido;

$mail->send();


    } catch (Exception $e) {
        error_log('Error al enviar correo: ' . $mail->ErrorInfo);
    }


   }
}
