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
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'b45ca7be279d0f';
            $mail->Password = '315a187376ff35';

            // Remitente y destinatario
            $mail->setFrom('cuenta@workspace.com', 'Workspace');
            $mail->addAddress($this->email, $this->nombre);

            // Asunto y contenido
            $mail->Subject = 'Confirma tu cuenta';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $url = BASE_URL . "/confirmar?token=" . $this->token;

            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>, has creado tu cuenta en Workspace.</p>";
            $contenido  = "<p>Presiona aquí: ";
            $contenido .= "<a href='" . BASE_URL . "/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>";

            $contenido .= '</html>';

            $mail->Body = $contenido;

            $mail->send();
        } catch (Exception $e) {
            error_log('Error al enviar correo: ' . $mail->ErrorInfo);
        }
    }

   public function reestrablecerPassword(){
    $mail = new PHPMailer(true); // Habilita excepciones

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b45ca7be279d0f';
        $mail->Password = '315a187376ff35';

        // Remitente y destinatario
        $mail->setFrom('cuenta@workspace.com', 'Workspace');
        $mail->addAddress($this->email, $this->nombre);

        // Asunto y contenido
        $mail->Subject = 'Reestablecer Password';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

      

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>, has olvidado tu password? siguie el siguiente enlace:.</p>";
        $contenido .= "<p>Presiona aquí: ";
        $contenido .= "<a href='" . BASE_URL . "/reestablecer?token=" . $this->token . "'>Reestablecer el password</a></p>";
        $contenido .= "<p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>";

        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    } catch (Exception $e) {
        error_log('Error al enviar correo: ' . $mail->ErrorInfo);
    }


   }
}
