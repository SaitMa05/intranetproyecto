<?php

namespace Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailModel extends Model {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->configure();
    }

    private function configure() {
        try {
            // Configuración del servidor SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'c2650896.ferozo.com'; // Servidor SMTP
            $this->mail->SMTPAuth = true;
            $this->mail->Username = SMTP_USER; // Usa variables de entorno
            $this->mail->Password = SMTP_PASS; // Usa variables de entorno
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // STARTTLS recomendado
            $this->mail->Port = 587; // Puerto para STARTTLS

            // Configuración del remitente
            $this->mail->CharSet = 'UTF-8';
            $this->mail->setFrom(SMTP_USER, 'Intranet');
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            error_log("Error en la configuración del correo: {$e->getMessage()}");
        }
    }

    public function enviar($destinatario, $asunto, $cuerpo) {
        try {
            $this->mail->clearAddresses(); // Limpiar direcciones previas
            $this->mail->addAddress($destinatario);
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $cuerpo;

            $this->mail->send();
            return true; // Correo enviado correctamente
        } catch (Exception $e) {
            error_log("Error al enviar el correo: {$e->getMessage()}"); // Registrar errores
            return false; // Hubo un error
        }
    }

    public function generarToken($longitud = 8) {
        $token = '';
        for ($i = 0; $i < $longitud; $i++) {
            $token .= mt_rand(0, 9);
        }
        return $token;
    }

}
