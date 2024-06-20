<?php
require_once 'vendor/autoload.php'; // Uključite Composer autoload fajl

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class OrderMailer {
    private $smtpHost = 'smtp.gmail.com';
    private $smtpUser = 'patofnak@gmail.com';
    private $smtpPass = 'ztfy edqt mohe fjrc '; // Ispravite lozinku ovde
    private $smtpPort = 587;
    private $smtpSecure = PHPMailer::ENCRYPTION_STARTTLS;

    public function sendOrderEmail($supplierEmail, $orderDetails) {
        $mail = new PHPMailer(true);

        try {
            // Postavke SMTP servera
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpUser;
            $mail->Password = $this->smtpPass;
            $mail->SMTPSecure = $this->smtpSecure;
            $mail->Port = $this->smtpPort;

            // Omogućite detaljno logovanje
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Debugoutput = 'html';

            // Postavke e-maila
            $mail->setFrom($this->smtpUser, 'Your Company Name');
            $mail->addAddress($supplierEmail); // E-mail dobavljača
            $mail->Subject = 'Nova narudžbina'; // Naslov e-maila
            $mail->isHTML(true); // Omogućava HTML formatiranje
            $mail->Body = '<h1>Detalji narudžbine</h1><p>' . $orderDetails . '</p>'; // Telo e-maila

            // Slanje e-maila
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email nije poslat. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>